<?php
/*
 * Tipopagobeneficio.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 09/06/2020
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
 
 * This is the model class for table "general.tipopagobeneficio".
 *
 * The followings are the available columns in table 'general.tipopagobeneficio':
 * @property integer $id
 * @property string $nombre
 * @property boolean $eliminado
 * @property string $fecha
 * @property string $usuario
 *
 * The followings are the available model relations:
 * @property Pagobeneficio[] $pagobeneficios
 */
class Tipopagobeneficio extends CActiveRecord
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
            return 'general.tipopagobeneficio';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('nombre', 'length', 'max'=>100),
                    array('usuario', 'length', 'max'=>40),
                    array('eliminado, fecha', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('nombre, vigente,asolicitudempleado', 'required', 'on' => array('insert', 'update')),
                    array('id, nombre, eliminado, fecha, usuario', 'safe', 'on'=>'search'),
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
                    'pagobeneficios' => array(self::HAS_MANY, 'Pagobeneficio', 'idtipopagobeneficio'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'nombre' => 'Nombre',
                    'eliminado' => 'Eliminado',
                    'fecha' => 'Fecha',
                    'usuario' => 'Usuario',
                    'asolicitudempleado'=>'A Solicitud Empleado?',

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
		$criteria->addSearchCondition('t.nombre',$this->nombre,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
                $criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
                $criteria->compare('t.asolicitudempleado',$this->asolicitudempleado);
                $criteria->compare('t.vigente',$this->vigente);

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                 'sort' => array(
                        'defaultOrder' => 't.nombre asc', )
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
     * @return Tipopagobeneficio the static model class
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
		$this->nombre=strtoupper($this->nombre);
		$this->fecha= new CDbExpression('NOW()');
		$this->usuario= Yii::app()->user->getName();
        return parent::beforeSave();            
    }
    /**
     * 
     * @return string , mensaje en caso de no poder eliminar el tipo pago beneficio
     */
    protected function beforeSafeDelete() {
        $id=$this->id;     
        $respuesta=Yii::app()->rrhh
            ->createCommand("select borrar_tipopagobeneficio($id) as r")
            ->queryScalar(); 
        if ($respuesta) {
            
            return parent::beforeSafeDelete();
        } else {
            echo System::messageError('El Tipo Pago Beneficio NO puede ser eliminada porque tiene  Asignaciones asociadas... ! ');
            return;
        }
    }

}
