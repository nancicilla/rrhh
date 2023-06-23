<?php
/*
 * Gestion.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 03/01/2017
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
 
 * This is the model class for table "general.gestion".
 *
 * The followings are the available columns in table 'general.gestion':
 * @property integer $id
 * @property string $inicio
 * @property string $fin
 * @property boolean $abierta
 * @property boolean $valida
 * @property string $esquema
 */
class Gestion extends CActiveRecord
{
    
   // public static $schemaGestionEstandar;//constantes q guardan para no volvera consultar
    public static $schemaGestion_;//constantes q guardan para no volvera consultar
    public static $schemaGestionAnterior_;//constantes q guardan para no volvera consultar
    public static $schemaGestionLast_;//constantes q guardan para no volvera consultar
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
            return 'general.gestion';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('inicio, fin, abierta, valida, esquema', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, inicio, fin, abierta, valida, esquema', 'safe', 'on'=>'search'),
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
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'inicio' => 'Inicio',
                    'fin' => 'Fin',
                    'abierta' => 'Abierta',
                    'valida' => 'Valida',
                    'esquema' => 'Esquema',
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
		$criteria->addSearchCondition('t.inicio',$this->inicio,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.fin',$this->fin,true,'AND','ILIKE');
		$criteria->compare('t.abierta',$this->abierta);
		$criteria->compare('t.valida',$this->valida);
		$criteria->addSearchCondition('t.esquema',$this->esquema,true,'AND','ILIKE');

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
     * @return Gestion the static model class
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
		$this->esquema=strtoupper($this->esquema);
        return parent::beforeSave();            
    }
    
    public function getSchemaGestion(){
        if(self::$schemaGestion_==null){
            $getGestionSchema=getGestionSchema();
            self::$schemaGestion_= $getGestionSchema=='public'?null:$getGestionSchema;
            //self::$schemaGestionEstandar=$getGestionSchema=='public'?null:$getGestionSchema;
        }
        if(self::$schemaGestion_==null){
            $connection = Yii::app()->rrhh;
             
             $q="select esquema from general.gestion where abierta=true ";
             $command = $connection->createCommand($q);
             $gestion = $command->queryRow();
             self::$schemaGestion_=$gestion['esquema'];
        }
            
        return self::$schemaGestion_;
    }
    public function getSchemaGestionAnterior(){
        $gestion=  self::getSchemaGestion();
        if(self::$schemaGestionAnterior_==null){
             $connection = Yii::app()->venta;
             
             $q="select id from general.gestion where esquema='$gestion' ";
             $command = $connection->createCommand($q);
             $idGestionAnterior = $command->queryScalar()-1;
             
             $q="select * from general.gestion where id=$idGestionAnterior ";
             $command = $connection->createCommand($q);
             $gestionAnterior= $command->queryRow();
             self::$schemaGestionAnterior_=$gestionAnterior['esquema'];
         
        }
            
        return self::$schemaGestionAnterior_;
    }
    
    public function getSchema($schema){
        if($schema==self::getSchemaGestion()) return '';
        return '"'.$schema.'".';
    }


}
