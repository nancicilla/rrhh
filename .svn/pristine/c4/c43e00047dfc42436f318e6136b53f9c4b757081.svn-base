<?php
/*
 * Permiso.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 12/04/2019
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
 
 * This is the model class for table "general.permiso".
 *
 * The followings are the available columns in table 'general.permiso':
 * @property integer $id
 * @property integer $idempleado
 * @property integer $idtipopermiso
 * @property string $fechai
 * @property string $fechaf
 * @property string $descripcion
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 * @property string $ruta
 *
 * The followings are the available model relations:
 * @property Tipopermiso $idtipopermiso
 * @property Empleado $idempleado
 */
class Permiso extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $hi,$hs,$mi,$ms,$hi1,$hs1,$mi1,$ms1,$empleado,$tipopermiso,$dias,$jornada,$observacion;
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
            return 'permiso';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idempleado, idtipopermiso', 'numerical', 'integerOnly'=>true),
                    array('usuario', 'length', 'max'=>30),
                     array('horai,horaf', 'length', 'max'=>5),
                    array('fechai, fechaf,horai,horaf, descripcion,tipo, fecha, eliminado, ruta', 'safe'),
                    array('idtipopermiso,fechai','required','on'=>array('insert')),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.

                    array('id, empleado, idtipopermiso,tipopermiso, fechai, fechaf, descripcion, usuario, fecha, eliminado,horai,horaf, ruta,tipo', 'safe', 'on'=>'search'),

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
                    'idtipopermiso0' => array(self::BELONGS_TO, 'Tipopermiso', 'idtipopermiso'),
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
                    'idtipopermiso' => 'Tipo de Permiso',
                    'fechai' => 'Desde',
                    'fechaf' => 'A',
                    'descripcion' => 'Descripción',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'tipo'=>'Permiso por',
                    'ruta' => 'Ruta',
                    'horai'=>'Hora Inicial',
                    'horaf'=>'Hora Final',
                    'conconstancia'=>'Tiene Constancia?'

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
	$criteria->join = " inner  JOIN  dame_lista_permiso() r ON r.idpermiso= t.id";
        $criteria->select ='t.*';
        $criteria->join = "right outer  JOIN  general.empleado e ON e.id= t.idempleado right outer  JOIN general.persona p on p.id=e.idpersona right outer join general.seguimientoempleado se on se.idempleado=e.id  right outer JOIN ftbl_usuario_web_cruge_user cu  on cu.iduser=se.idcrugeuser";
        $criteria->addSearchCondition('t.horai',$this->horai,true,'AND','ILIKE');
	$criteria->addSearchCondition('t.horaf',$this->horaf,true,'AND','ILIKE');
        $criteria->addCondition("cu.username = '".Yii::app()->user->getName()."'");
        $criteria->addCondition("se.eliminado::boolean =false::boolean");
	if ($this->tipo !=Null &&$this->tipo!='') {
           $criteria->addCondition("t.tipo::boolean = '" . $this->tipo. "'::boolean");
        
        }
        if ($this->idtipopermiso!=Null) {
            $criteria->addCondition("t.idtipopermiso = " . $this->idtipopermiso);
        }
        if ($this->fecha != Null) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
	}
        if ($this->fechai != Null && $this->fechaf != Null  ) {
        $criteria->addCondition("t.fechai::date between '" . $this->fechai. "' and '" . $this->fechaf. "' ");
         }elseif ($this->fechai != Null ) {
            $criteria->addCondition("t.fechai::date >= '" . $this->fechai.  "' ");
       
        }elseif ($this->fechaf != Null ){
        $criteria->addCondition("t.fechaf::date <='" . $this->fechaf. "'");
         }
        $criteria->addSearchCondition('t.ruta',$this->ruta,true,'AND','ILIKE');
        $criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
        $criteria->addSearchCondition('p.nombrecompleto',$this->empleado,true,'AND','ILIKE');
        return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
               'sort' => array(
                        'defaultOrder' => 't.fechai desc,t.fechaf desc,t.horai desc,t.horaf desc,p.nombrecompleto asc ',                      
                        'attributes' => array(
                            'fechai'=>array(
                                'asc'=>'t.fechai asc,p.nombrecompleto asc',
                                'desc'=>'t.fechai desc,p.nombrecompleto desc'
                            ),
                            'fechaf'=>array(
                                'asc'=>'t.fechaf asc, p.nombrecompleto asc',
                                'desc'=>'t.fechaf desc, p.nombrecompleto asc'
                            ),
                            'horai'=>array(
                                'asc'=>'t.horai asc,p.nombrecompleto asc',
                                'desc'=>'t.horai desc, p.nombrecompleto asc'
                            ),
                            'horaf'=>array(
                                'asc'=>'t.horaf asc, p.nombrecompleto asc',
                                'desc'=>'t.horaf desc, p.nombrecompleto asc'
                            ),
                            'idempleado'=>array(
                                'asc'=>'p.nombrecompleto asc,t.fechai asc, t.fechaf asc,t.horai asc,t.horaf asc',
                                'desc'=>'p.nombrecompleto desc,t.fechai asc, t.fechaf asc,t.horai asc,t.horaf asc'
                                
                            )
                            
                        )
                   )
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
     * @return Permiso the static model class
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
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
		$this->ruta=strtoupper($this->ruta);
        return parent::beforeSave();            
    }
    /**
     * 
     * @param integer $id, id relacionado con el permiso
     * @param date $fechadesde, fecha desde  del permiso
     * @param date $fechahasta, fecha hasta del permiso
     * @param time $horainicio, hora inicio del permiso
     * @param time $horafin, hora fin del permiso
     * @param string $observacion, detalle del permiso
     * @param integer $idtipopermiso, id del tipo de permiso
     * @return string, un mensaje en caso de no poder actualizar el permiso
     */
    public function actualizar_permiso($id,$fechadesde,$fechahasta,$horainicio,$horafin,$observacion,$idtipopermiso) {
         $usuario=  Yii::app()->user->getName();
                   
          $resp=Yii::app()->rrhh->createCommand("select  actualizar_permiso($id,'$fechadesde'::date,'$fechahasta'::date,'$horainicio'::varchar(5),'$horafin'::varchar(5),'$observacion'::text,$idtipopermiso,'$usuario') as resp")->queryAll()[0];
        return $resp['resp'];
    }
    /**
     * 
     * @return string, un mensaje en caso que no se pueda eliminar el permiso
     */
    protected function beforeSafeDelete() {
        $usuario= Yii::app()->user->getName();
        $id=$this->id;     
             Yii::app()->rrhh
                ->createCommand("select dar_baja_permiso($id,'$usuario')")
                ->execute();
         
        $fechaplanilla=Yii::app()->rrhh
            ->createCommand("select fechahasta from planilla where eliminado=false order by id desc limit 1")
            ->queryScalar(); 
        if ($fechaplanilla<$this->fechai) {
            
            
            
             return  parent::beforeSafeDelete();;
        } else {
            
            echo System::messageError('El Permiso no puede borrarse porque se encuentra asociada a un Corte de Planilla ... ! ');
            return;
        }
    }
    /**
     * 
     * @param lista $lista lista de empleados a los cuales vamos a registrar en bloque a cuenta de Banco Horas
     * @param date $fecha fecha a la que registraremos el permiso
     * @param numeric $dias cantidad de dias a registrar
     * @param int $jornada nos permite saber si los registros se haran al inicio o al final de la jornada
     * @param text $observacion texto general que ira en todos los permisos
     * @return boolean
     */
    public function RegistroGrupal($lista,$fecha,$dias,$jornada,$observacion,$idtipopermiso)
    { $usuario= Yii::app()->user->getName();
        $cant=count($lista);
        for ($i=1; $i <=$cant ; $i++) { 
            if ($lista[$i]['id']!=='') {
               Yii::app()->rrhh->createCommand("select registro_grupal_bhpv(".$lista[$i]['id'].",'$fecha',$dias,$jornada,upper('$observacion'),'$usuario',6,$idtipopermiso)")->execute();
               
                
            }
        }
        return true;
    }

}
