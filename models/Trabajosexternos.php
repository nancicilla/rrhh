<?php
/*
 * Trabajosexternos.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 26/10/2021
 *
 * Ultima Actualizacion: $Date: 2015-03-17 10:26:19 -0400 (mar, 17 mar 2015) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 
 * This is the model class for table "trabajosexternos".
 *
 * The followings are the available columns in table 'trabajosexternos':
 * @property integer $id
 * @property integer $idempleado
 * @property string $fechadesde
 * @property string $fechahasta
 * @property string $descripcion
 * @property string $horainicio
 * @property string $horafin
 * @property boolean $tipo
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Empleado $idempleado0
 */
class Trabajosexternos extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public  $empleado,$hi,$hs,$mi,$ms,$hi1,$hs1,$mi1,$ms1;

    public function defaultScope() {
        return array(
            'condition' => $this->getTableAlias(false, false) .
            '.eliminado = false',
        );
    }
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
            return 'trabajosexternos';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idempleado', 'numerical', 'integerOnly'=>true),
                    array('horainicio, horafin', 'length', 'max'=>5),
                    array('usuario', 'length', 'max'=>30),
                    array('fechadesde, fechahasta,empleado, descripcion, tipo, fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, idempleado,empleado, fechadesde, fechahasta, descripcion, horainicio, horafin, tipo, usuario, fecha, eliminado', 'safe', 'on'=>'search'),
            );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
            // NOTE: you may need to adjust the relation name and the related
            // class name for the relations automatically generated below.
            return array(
                    'idempleado0' => array(self::BELONGS_TO, 'Empleado', 'idempleado'),
            );
            
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'idempleado' => 'Empleado',
                    'fechadesde' => 'Desde',
                    'fechahasta' => 'Hasta',
                    'descripcion' => 'Descripcion',
                    'horainicio' => 'Hora Inicio',
                    'horafin' => 'Hora Fin',
                    'tipo' => 'Tipo',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
            );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
            // @todo Please modify the following code to remove attributes that should not be searched.

            $criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		
        $pfecha=   Yii::app()->rrhh
            ->createCommand("select valor as f from general.configuracion where id=26")
            ->queryScalar();       
           
        $criteria->addCondition("t.fechadesde::date > '$pfecha' ");
        $criteria->compare('t.idempleado',$this->idempleado);
        $criteria->join ='right outer  JOIN general.empleado e on e.id=t.idempleado right outer  JOIN general.persona p on p.id=e.idpersona right outer join general.seguimientoempleado se on se.idempleado=e.id  right outer JOIN ftbl_usuario_web_cruge_user cu  on cu.iduser=se.idcrugeuser';
        $criteria->addCondition("cu.username = '".Yii::app()->user->getName()."'");
        $criteria->addCondition("se.eliminado::boolean =false::boolean");
        $criteria->addSearchCondition('p.nombrecompleto',$this->empleado,true,'AND','ILIKE');     
        $criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
         if ($this->fecha != Null) {
        $criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
         }
           if ($this->fechadesde != Null) {
        $criteria->addCondition("t.fechadesde::date = '" . $this->fechadesde. "'");
         }
           if ($this->fechahasta != Null) {
        $criteria->addCondition("t.fechahasta::date = '" . $this->fechahasta. "'");
         }

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
            ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection()
    {
            return Yii::app()->rrhh;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Trabajosexternos the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }


    /**
     *
     * Sentencias entes de ejecutar metodo save
     * Antes de guardar se cambia todos los campos  de tipo character
     * varying y text a mayúsculas
     * Si existe el campo fecha, este toma el valor de la fecha actual antes
     * de almacenarse
     * Si existe el campo usuario, toma el valor del usuario actual antes de
     * almacenarse
     * 
     */
    public function beforeSave() {
		$this->descripcion=strtoupper($this->descripcion);
		$this->horainicio=strtoupper($this->horainicio);
		$this->horafin=strtoupper($this->horafin);
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }
    /**
     * Registra el tranbajo externo e un empleado
     * @param model $texterno, modelo relacionado con el trabajo externo
     */
    public  function registrarTrabajoExterno($texterno) {
    $usuario= Yii::app()->user->getName();
     Yii::app()->rrhh->createCommand("select registrar_trabajoexterno(".$texterno->idempleado .",'".$texterno->fechadesde."'::date,'".$texterno->fechahasta."'::date,'".$texterno->horainicio."'::varchar(5),'".$texterno->horafin."'::varchar(5),'".$texterno->tipo."'::boolean ,upper('".$texterno->descripcion."'),'$usuario') as r")->queryAll()[0]['r'];  
    
    }
    /**
     * 
     * @param model $texterno, modelo relaciondo con el trabajo externo
     * @return string, mensaje en caso de No poder Actualizar el Trabajo Externo de un empleado
     */
    public function actualizarTrabajoexterno($texterno) {
       $usuario= Yii::app()->user->getName();
        if ($texterno->tipo=='1') {
        $hi=intval( $texterno->hi);
        $hs=intval($texterno->hs);
        $mi=intval($texterno->mi);
        $ms=intval($texterno->ms);
        if ($hi<10) {
          $hi='0'.$hi;
        }
        if ($mi<10) {
        $mi='0'.$mi;
        }
        if ($hs<10) {
          $hs='0'.$hs;
        }
        if ($ms<10) {
        $ms='0'.$ms;
        }
        $texterno->horainicio=$hi.':'.$mi;
        $texterno->horafin=$hs.':'.$ms;
        $texterno->fechahasta=$texterno->fechadesde;
         }

      $respuesta=  Yii::app()->rrhh->createCommand("select modificar_trabajoexterno(".$texterno->id.",'".$texterno->fechadesde."'::date, '".$texterno->fechahasta."'::date,'".$texterno->horainicio."','".$texterno->horafin."','".$texterno->descripcion."','$usuario' ) as r")->queryScalar();
      return $respuesta;
    }
    /**
     * 
     * @return string, en el caso de que No se pueda eliminar el registro del trabajo externo
     */
    protected function beforeSafeDelete() {
        $usuario= Yii::app()->user->getName();
        $id=$this->id;             
        $fechaplanilla=Yii::app()->rrhh
            ->createCommand("select fechahasta from planilla where eliminado=false order by id desc limit 1")
            ->queryScalar(); 
        if ($fechaplanilla<$this->fechadesde) {           
            
             return  parent::beforeSafeDelete();;
        } else {
           
            echo System::messageError('Trabajo Externo no puede borrarse porque se encuentra asociado a un Corte de Planilla ... ! ');
            return;
        }
    }
}
