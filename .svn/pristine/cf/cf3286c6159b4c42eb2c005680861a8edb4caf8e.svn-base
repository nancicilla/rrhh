<?php
/*
 * Cuerpohorariolactancia.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 24/01/2022
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
 
 * This is the model class for table "cuerpohorariolactancia".
 *
 * The followings are the available columns in table 'cuerpohorariolactancia':
 * @property integer $id
 * @property integer $iddia
 * @property integer $iddiad
 * @property string $horai
 * @property string $horas
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 * @property integer $idhorariolactancia
 *
 * The followings are the available model relations:
 * @property Horariolactancia $idhorariolactancia0
 */
class Cuerpohorariolactancia extends CActiveRecord
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
            return 'cuerpohorariolactancia';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('iddia, iddiad, idhorariolactancia', 'numerical', 'integerOnly'=>true),
                    array('horai, horas', 'length', 'max'=>5),
                    array('usuario', 'length', 'max'=>30),
                    array('fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, iddia, iddiad, horai, horas, usuario, fecha, eliminado, idhorariolactancia', 'safe', 'on'=>'search'),
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
                    'idhorariolactancia0' => array(self::BELONGS_TO, 'Horariolactancia', 'idhorariolactancia'),
                    'iddia0' => array(self::BELONGS_TO, 'Dia', 'iddia'),
                    'iddiad0' => array(self::BELONGS_TO, 'Dia', 'iddiad'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'iddia' => 'Iddia',
                    'iddiad' => 'Iddiad',
                    'horai' => 'Horai',
                    'horas' => 'Horas',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'idhorariolactancia' => 'Idhorariolactancia',
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
		$criteria->compare('t.iddia',$this->iddia);
		$criteria->compare('t.iddiad',$this->iddiad);
		$criteria->addSearchCondition('t.horai',$this->horai,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.horas',$this->horas,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->compare('t.idhorariolactancia',$this->idhorariolactancia);

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
     * @return Cuerpohorariolactancia the static model class
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
		$this->horai=strtoupper($this->horai);
		$this->horas=strtoupper($this->horas);
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }
    /**
     * 
     * @param integer $idhorariolactancia, id del horario de lactancia
     * @return \CActiveDataProvider ,informacion del cuerpo de horario de lactancia
     */
    public function listaHorarios($idhorariolactancia)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.idhorariolactancia = ".$idhorariolactancia);
        
        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.id asc',
            )
        ));
    }

}
