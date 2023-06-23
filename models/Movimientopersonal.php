<?php
/*
 * Movimientopersonal.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 28/05/2019
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
 
 * This is the model class for table "general.movimientopersonal".
 *
 * The followings are the available columns in table 'general.movimientopersonal':
 * @property integer $id
 * @property string $fechaini
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 * @property integer $idempleado
 * @property integer $idcontrato
 * @property integer $idpuestotrabajo
 * @property integer $idnivelsalarial
 *
 * The followings are the available model relations:
 * @property Empleado $idempleado
 * @property Contrato $idcontrato
 * @property Puestotrabajo $idpuestotrabajo
 * @property Nivelsalarial $idnivelsalarial
 * @property Horario[] $horarios
 */
class Movimientopersonal extends CActiveRecord
{
       public $empleado ,$puestoactual,$unidad,$area,$seccion,$rangohora,$tipocontrato,$fechafincontrato,$nivelsalarial,$nivelsalarialid;
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
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
            return 'movimientopersonal';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idempleado ,idhorario', 'numerical', 'integerOnly'=>true),
                    array('usuario', 'length', 'max'=>30),
                    array('fechaini, fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                   array('fechaini,idempleado,idhorario','required','on'=>array('insert')),
                    array('fechaini,idempleado','required','on'=>array('update')),
                array('id, fechaini, usuario, fecha, eliminado, empleado,idhorario', 'safe', 'on'=>'search'),
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
                     'idhorario0' => array(self::BELONGS_TO, 'Horario', 'idhorario'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'fechaini' => 'Fecha Inicio',                  
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha Registro',
                    'eliminado' => 'Eliminado',
                    'idempleado' => 'Empleado',
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
		$criteria->addSearchCondition('t.fechaini::date',$this->fechaini,true,'AND','=');
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
                $criteria->addSearchCondition('p.nombrecompleto',$this->empleado,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
    		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }         
                $criteria->addCondition("t.idhorario is not null");		
                $criteria->join='right outer  JOIN  general.empleado e on e.id=t.idempleado inner join general.persona p on p.id=e.idpersona inner join general.seguimientoempleado se on se.idempleado=e.id inner join ftbl_usuario_web_cruge_user cu on cu.iduser=se.idcrugeuser ';
                $criteria->addCondition('e.eliminado=false');
                
                $criteria->addCondition("cu.username = '".Yii::app()->user->getName()."'");
                $criteria->addCondition("se.eliminado::boolean =false::boolean");
                return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                 'sort' => array(
                        'defaultOrder' => 'p.nombrecompleto,t.fechaini asc',
                        'attributes' => array(
                            'idempleado'=>array(
                                'asc'=>'p.nombrecompleto asc,t.fechaini asc',
                                'desc'=>'p.nombrecompleto desc,t.fechaini asc'
                            ),
                            'fechaini'=>array(
                                'asc'=>'t.fechaini asc, p.nombrecompleto asc',
                                'desc'=>'t.fechaini desc,p.nombrecompleto asc'
                            ),
                            'usuario'=>array(
                                'asc'=>'t.usuario asc,p.nombrecompleto asc',
                                'desc'=>'t.usuario desc,p.nombrecompleto asc'
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
     * @return Movimientopersonal the static model class
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
     * @return array, con la informacion del horario
     */
   public function dameHorarios()
    {
        if (  $this->idhorario!=null) {

           $cant= Yii::app()->rrhh
            ->createCommand("select count(*) as cant from general.horario where eliminado=false and id=".$this->idhorario)
            ->queryScalar();
            
            if ($cant>0) {
                 return $this->idhorario0->dameHorarios();
            }else{
            return array();
            }
           
        }else{
         return array();
        }
        
       
    }
   
    /**
     * 
     * @return string,mensaje en el caso de que no se pueda eliminar el movimiento
     */
    protected function beforeSafeDelete() {
        $id=$this->id;     
        $movimientos=Movimientopersonal::model()->findByPk($id);
        $fecha= Yii::app()->rrhh
            ->createCommand("select  fechafc  from planilla  where eliminado=false  order  by id desc  limit 1 ")
            ->queryScalar();
        if ($fecha!=false){
            if ($movimientos->fechaini> $fecha) {
                
                return parent::beforeSafeDelete();
            } else {
                echo System::messageError('El Contrato/Horario NO puede ser eliminado porque  la fecha de inicio del Horario fue tomado encuenta en un Corte de Planilla ! ');
                return;
            }
        }else{
            if ($movimientos->estado==false) {                
                return parent::beforeSafeDelete();
            } else {
                echo System::messageError('El Contrato/Horario NO puede ser eliminado porque es la configuracion Incial del Empleado ... ! ');
                return;
            }
        }
    }
    /**
     * 
     * @param integer $id, id del movimiento
     * @return boolean , true =  si el movimiento No  se encuentra dentro de un Corte de Planilla,false= en el caso de que el movimiento se encuentre dentro de un Corte de Planilla
     */
    public function mostrarBorrar($id)
    {
        $id=SeguridadModule::dec($id);     
        $movimientos=Movimientopersonal::model()->findByPk($id);
        $fecha= Yii::app()->rrhh
            ->createCommand("select  fechafc  from planilla  where eliminado=false  order  by id desc  limit 1 ")
            ->queryScalar();
        $borra;    
        if ($fecha!=false ){
            if ($movimientos->fechaini> $fecha) {
                
                $borra=true;
            } else {
               $borra=false;
            }
        }else{
            if ($movimientos->estado==false) {                
                $borra=false ;
            } else {
                $borra=true ;
            }
        }
        
    return $borra;
    }



}
