<?php
/*
 * Cuerpo.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 12/11/2019
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
 
 * This is the model class for table "general.cuerpo".
 *
 * The followings are the available columns in table 'general.cuerpo':
 * @property integer $id
 * @property string $general
 * @property string $beneficio
 * @property string $aporte
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 * @property integer $idplanilla
 * @property integer $tipo
 * @property string $horasextras
 * @property string $horasnocturnas
 * @property string $dominical
 * @property string $feriados
 * @property integer $unidad
 *
 * The followings are the available model relations:
 * @property Planilla $idplanilla
 */
class Cuerpo extends CActiveRecord
{
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
            return 'cuerpo';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idplanilla, tipo, unidad', 'numerical', 'integerOnly'=>true),
                    array('usuario', 'length', 'max'=>30),
                    array('general, beneficio, aporte, fecha, eliminado, horasextras, horasnocturnas, dominical, feriados', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, general, beneficio, aporte, usuario, fecha, eliminado, idplanilla, tipo, horasextras, horasnocturnas, dominical, feriados, unidad', 'safe', 'on'=>'search'),
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
                    'idplanilla' => array(self::BELONGS_TO, 'Planilla', 'idplanilla'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'general' => 'General',
                    'beneficio' => 'Beneficio',
                    'aporte' => 'Aporte',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'idplanilla' => 'Idplanilla',
                    'tipo' => 'Tipo',
                    'horasextras' => 'Horasextras',
                    'horasnocturnas' => 'Horasnocturnas',
                    'dominical' => 'Dominical',
                    'feriados' => 'Feriados',
                    'unidad' => 'Unidad',
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
		$criteria->addSearchCondition('t.general',$this->general,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.beneficio',$this->beneficio,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.aporte',$this->aporte,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->compare('t.idplanilla',$this->idplanilla);
		$criteria->compare('t.tipo',$this->tipo);
		$criteria->addSearchCondition('t.horasextras',$this->horasextras,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.horasnocturnas',$this->horasnocturnas,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.dominical',$this->dominical,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.feriados',$this->feriados,true,'AND','ILIKE');
		$criteria->compare('t.unidad',$this->unidad);

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
     * @return Cuerpo the static model class
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


}