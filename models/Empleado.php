<?php
/*
 * Empleado.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 08/04/2019
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
 
 * This is the model class for table "general.empleado".
 *
 * The followings are the available columns in table 'general.empleado':
 * @property integer $id
 * @property string $huella1
 * @property string $huella2
 * @property double $pretencionsalarial
 * @property integer $idpersona
 * @property integer $idpuestotrabajo
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Persona $idpersona
 * @property Puestotrabajo $idpuestotrabajo
 * @property Contrato[] $contratos
 */
class Empleado extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $pempleado,$estadoempleado,$fechadesde,$observacion,$minlactancia,$idhoralactancia,$nombrecompleto,$fechahasta,$idr,$mes,$tipocontrato,$area,$sexo,$tipo,$ultimaevaluacion;
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
            return 'general.empleado';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
          return array(
                    array('idpersona', 'numerical', 'integerOnly'=>true),
                    array('montocategoria,montotransporte,jornadalaboral', 'numerical'),
                    array('usuario', 'length', 'max'=>30),
                    array('codrciva', 'length', 'max'=>20),
                    array('fecha,fechaingreso,codrciva, eliminado', 'safe'),
                    array('idpersona,montocategoria,jornadalaboral,montotransporte,analizarsellada,esobrero,jubilado', 'required', 'on' => array('insert', 'update')),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id,pempleado,observacion, idpersona,fechaminima, idpuestotrabajo, usuario, fecha, eliminado,nombrecompleto,fechahasta,manual,codrciva', 'safe', 'on'=>'search'),
                    array('id,pempleado,observacion, idpersona,fechaminima, idpuestotrabajo, usuario, fecha, eliminado,nombrecompleto,fechahasta,codrciva', 'safe', 'on'=>'searchregistroasistencia'),
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
                    'idpersona0' => array(self::BELONGS_TO, 'Persona', 'idpersona'),
                    'idafp0' => array(self::BELONGS_TO, 'Afp', 'idafp'),
                    'empleadobonos' => array(self::HAS_MANY, 'Empleadobono', 'idempleado'),
                    'entegauniformes' => array(self::HAS_MANY, 'Entregauniforme', 'idempleado'),
                    'movimientopersonal' => array(self::HAS_MANY, 'Movimientopersonal', 'idempleado'),
                    'asistencias' => array(self::HAS_MANY, 'Asistencias', 'idempleado'),
                    'Historialestadoempleados' => array(self::HAS_MANY, 'Historialestadoempleado', 'idempleado'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
           return array(
                    'id' => 'ID',                 
                   
                    'idpersona' => 'Idpersona',
                    'montotransporte' => 'Bono Transporte',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'fechaingreso'=>'Fecha Ingreso',
                    'fechahasta'=>'Fecha Hasta',
                    'montocategoria'=>'Bono Categorización',
                    'codrciva'=>'Codigo RC_IVA'

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
          $usuario= Yii::app()->user->getName();
        if ($this->fecha != Null) {
          $criteria->compare('t.id',$this->id);

          

          
           $criteria->order = 'p.nombrecompleto ASC';
      
          
         return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
            ));

         }else{
        

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
            ));
            }
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
     * @return Empleado the static model class
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
		
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }
    /**
     * 
     * @return model movimiento ayor al dia de hoy
     */
    public function dameMovimiento()
    {     
      if ($this->movimientopersonal!=null) {
        $criteria=new CDbCriteria;
        $criteria->addCondition("t.idempleado = ".$this->id);
        $criteria->addCondition("t.fechaini<=now()::date");
        $criteria->order='t.id DESC';
        $criteria->limit=1;
        $movimiento=Movimientopersonal::model()->find($criteria);
         if (isset($movimiento)){

            return $movimiento;
         }else{
              $criteria=new CDbCriteria;

        $criteria->addCondition("t.idempleado = ".$this->id);
        $criteria->addCondition("t.fechaini>now()::date");
        $criteria->order='t.id asc';
        $criteria->limit=1;
        $movimiento=Movimientopersonal::model()->find($criteria);

            return $movimiento;  
          }
     }
        
      }
      public function registrarEvaluacion($evaluacion) {
          $usuario= Yii::app()->user->getName();
          Yii::app()->rrhh
            ->createCommand("select registrar_evaluacion(".$this->id.", '$evaluacion' ,'$usuario')")
            ->execute();
      }

  

      
}
