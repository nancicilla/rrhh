<?php
/*
 * Seguimientoempleado.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 15/06/2021
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
 
 * This is the model class for table "general.seguimientoempleado".
 *
 * The followings are the available columns in table 'general.seguimientoempleado':
 * @property integer $id
 * @property integer $idempleado
 * @property integer $idcrugeuser
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Empleado $idempleado
 */
class Seguimientoempleado extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public  $crugeuser;
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
            return 'general.seguimientoempleado';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idempleado, idcrugeuser', 'numerical', 'integerOnly'=>true),
                    array('usuario', 'length', 'max'=>30),
                    array('fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, idempleado, idcrugeuser,crugeuser, usuario, fecha, eliminado', 'safe', 'on'=>'search'),
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
                    'idempleado' => array(self::BELONGS_TO, 'Empleado', 'idempleado'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'idempleado' => 'Idempleado',
                    'idcrugeuser' => 'Encargado de Seguimiento',
                    'crugeuser' => 'Encargado de Seguimiento',
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

		
		$criteria->compare('t.idcrugeuser',$this->id);
                $criteria->addSearchCondition('r.username',$this->crugeuser,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
                 $criteria->select=array('t.idcrugeuser','(select username  from ftbl_usuario_web_cruge_user where iduser=t.idcrugeuser ) as nombre','t.id','t.fecha::date as fecha','t.usuario');
                 $criteria->distinct = true;
                 $criteria->addCondition("t.id in(select ( select id from  general.seguimientoempleado where eliminado=false and idcrugeuser=t.iduser order by id desc limit 1) as id   from (select distinct cru.iduser from ftbl_usuario_web_cruge_user cru inner join general.seguimientoempleado se on se.idcrugeuser=cru.iduser) as t) ");
            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                 'sort' => array(
                        'defaultOrder' => '2 asc',
                    ),
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
     * @return Seguimientoempleado the static model class
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
     * @param integer $idusuarioweb, id del usuario que hara el seguimiento
     * @param integer[] $lista, lista de id de los empleado a los cuales se hara el seguimineto de sus asistencia
     */
    public function registrarSeguimiento($idusuarioweb, $lista) {
        $cant=count($lista);
        for($i=1;$i<=$cant;$i++){
            if($lista[$i]['id']!=''){
               $seguimiento=new Seguimientoempleado;
               $id=Yii::app()->rrhh
                        ->createCommand("select id+1  from general.seguimientoempleado order by id desc limit 1 ")->queryScalar();
               $seguimiento->id=$id;
               $seguimiento->idempleado=$lista[$i]['id'];
               $seguimiento->idcrugeuser=$idusuarioweb;
               $seguimiento->save();
               
        
            }
        }
    }/**
     * 
     * @param intger $idusuario, id del usuario que hara el seguimineto de la asistencia
     * @return string, nombre del usuario
     */
    public function dameNombreUsuario($idusuario){
        return Yii::app()->rrhh
                        ->createCommand("select username  from ftbl_usuario_web_cruge_user where iduser=$idusuario ")->queryScalar();
        
    }
    /**
     * 
     * @param integer $id, id del usuario qu hara el seguimiento
     * @param intger $lista, id de los empleados a los cuales sehara el seguimiento
     */
    public function guardarCambios($id, $lista) {
         $cant=count($lista);
         $usuario= Yii::app()->user->getName();
         $idusuarioweb=Yii::app()->rrhh
                        ->createCommand("select idcrugeuser from general.seguimientoempleado where id=   $id ")->queryScalar();
        
        Yii::app()->rrhh
                        ->createCommand("delete from general.seguimientoempleado  where  idcrugeuser=$idusuarioweb ")->execute();
        
         
        for($i=1;$i<=$cant;$i++){
            if($lista[$i]['id']!=''){
                              
               $seguimiento=new Seguimientoempleado;
                $id=Yii::app()->rrhh
                        ->createCommand("select id+1  from general.seguimientoempleado order by id desc limit 1 ")->queryScalar();
               $seguimiento->id=$id;
               $seguimiento->idempleado=$lista[$i]['id'];
               $seguimiento->idcrugeuser=$idusuarioweb;
               $seguimiento->save();
                
        
            }
        }
    }

}
