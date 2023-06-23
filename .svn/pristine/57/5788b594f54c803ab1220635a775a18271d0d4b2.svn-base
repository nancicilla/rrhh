<?php
/*
 * Nivelsalarial.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 13/05/2019
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
 
 * This is the model class for table "general.nivelsalarial".
 *
 * The followings are the available columns in table 'general.nivelsalarial':
 * @property integer $id
 * @property double $sueldo
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 * @property string $nombre
 *
 * The followings are the available model relations:
 * @property Movimientopersonal[] $movimientopersonals
 */
class Nivelsalarial extends CActiveRecord
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
            return 'general.nivelsalarial';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('sueldo', 'numerical'),
                    array('usuario, nombre', 'length', 'max'=>30),
                    array('fecha, eliminado', 'safe'),
                     array('sueldo','required','on'=>array('insert','update')),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, sueldo, usuario, fecha, eliminado, nombre', 'safe', 'on'=>'search'),
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
                    'movimientopersonal' => array(self::HAS_MANY, 'Movimientopersonal', 'idnivelsalarial'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'sueldo' => 'Sueldo',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'nombre' => 'Nombre',
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
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
                 if ($this->sueldo != Null&& floatval($this->sueldo)>0) {
                $criteria->addSearchCondition('t.sueldo::text',$this->sueldo,true,'AND','ILIKE');

                 }
		$criteria->addSearchCondition('t.nombre',$this->nombre,true,'AND','ILIKE');

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                'sort' => array(
                        'defaultOrder' => 't.sueldo asc', )
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
     * @return Nivelsalarial the static model class
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
		$this->nombre=strtoupper($this->nombre);
        return parent::beforeSave();            
    }
   /**
    * 
    * @return boolean, true = en el caso que el nivel salarial esta asociado a algun empleado ,false= en el caso de no este asociado a un empleado
    */
   public function tieneMovimiento() {
        $retorno = 0;

        if ($this->id != "") {
            $retorno = Movimientopersonal::model()->exists('idnivelsalarial=' . $this->id);
        }
        return $retorno;
    }

    /**
     * Sentencias entes de ejecutar metodo delete
     * @return CActiveRecord con la tupla a eliminarse
     */
    protected function beforeSafeDelete() {
        if ($this->tieneMovimiento()) {
            echo System::messageError('El nivel Salarial  no puede ser eliminada ,hay Empleado con ese Nivel Salarial');
            return;
        } else {
            return parent::beforeSafeDelete();
        }
    }

}
