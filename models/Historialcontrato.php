<?php
/*
 * Historialcontrato.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 30/12/2022
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
 
 * This is the model class for table "historialcontrato".
 *
 * The followings are the available columns in table 'historialcontrato':
 * @property string $id
 * @property integer $idnivelsalarial
 * @property integer $idpuestotrabajo
 * @property integer $idcontrato
 * @property string $fecharegistro
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Contrato $idcontrato0
 * @property Puestotrabajo $idpuestotrabajo0
 * @property Nivelsalarial $idnivelsalarial0
 */
class Historialcontrato extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $nivelsalarial;
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
            return 'historialcontrato';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idnivelsalarial, idpuestotrabajo, idcontrato', 'numerical', 'integerOnly'=>true),
                    array('usuario', 'length', 'max'=>30),
                    array('fecharegistro, fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, idnivelsalarial, idpuestotrabajo, idcontrato, fecharegistro, usuario, fecha, eliminado', 'safe', 'on'=>'search'),
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
                    'idcontrato0' => array(self::BELONGS_TO, 'Contrato', 'idcontrato'),
                    'idpuestotrabajo0' => array(self::BELONGS_TO, 'Puestotrabajo', 'idpuestotrabajo'),
                    'idnivelsalarial0' => array(self::BELONGS_TO, 'Nivelsalarial', 'idnivelsalarial'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'idnivelsalarial' => 'Idnivelsalarial',
                    'idpuestotrabajo' => 'Idpuestotrabajo',
                    'idcontrato' => 'Idcontrato',
                    'fecharegistro' => 'Fecharegistro',
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

		$criteria->addSearchCondition('t.id',$this->id,true,'AND','ILIKE');
		$criteria->compare('t.idnivelsalarial',$this->idnivelsalarial);
		$criteria->compare('t.idpuestotrabajo',$this->idpuestotrabajo);
		$criteria->compare('t.idcontrato',$this->idcontrato);
		$criteria->addSearchCondition('t.fecharegistro',$this->fecharegistro,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
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
     * @return Historialcontrato the static model class
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
     * @return \Nivelsalarial
     */
    public function dameNivelsalarial()
    {
        if ($this->idnivelsalarial0!=Null) {
        return $this->idnivelsalarial0;
        }else{
            return new Nivelsalarial;
        }
    }
     /**
     * 
     * @return \Puestotrabajo
     */
    public function damePuestotrabajo()
    {
        if ($this->idpuestotrabajo0!=Null) {
        return  Puestotrabajo::model()->findAll('t.idseccion='.$this->idpuestotrabajo0->idseccion) ;
        }else{
            return new Puestotrabajo;
        }
    }

}
