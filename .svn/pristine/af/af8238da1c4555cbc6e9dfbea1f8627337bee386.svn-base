<?php

/*
 * Bono.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 23/04/2019
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

 * This is the model class for table "general.bono".
 *
 * The followings are the available columns in table 'general.bono':
 * @property integer $id
 * @property string $descripcion
 * @property double $monto
 * @property boolean $tipo
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Empleadobono[] $empleadobonos
 */

class Bono extends CActiveRecord {

    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $mes, $administrativo, $produccion, $area, $empleado, $idempleado, $cuenta,$aportebeneficio,$pagounico;

    public function defaultScope() {
        return array(
            'condition' => $this->getTableAlias(false, false) .
            '.eliminado = false',
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'general.bono';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('monto', 'numerical'),
            array('usuario', 'length', 'max' => 30),
            array('nombre, fecha,estado, eliminado', 'safe'),
            array('nombre,enplanilla,esagrupador,seprorratea', 'required', 'on' => array('insert', 'update')),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre,pagounico,fechamespago,aportebeneficio, monto,enplanilla, estado, usuario,empleado,idempleado, fecha, eliminado', 'safe', 'on' => 'search'),
        array('id, nombre,pagounico,fechamespago,aportebeneficio, monto,enplanilla, estado, usuario,empleado,idempleado, fecha, eliminado', 'safe', 'on' => 'searchBonoPlanillaTributaria'),
        
            );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
          
            'idbonopadre0' => array(self::BELONGS_TO, 'Bono', 'idbonopadre'),
            'empleadobonos' => array(self::HAS_MANY, 'Empleadobono', 'idbono'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'descripcion' => 'Descripción',
            'monto' => 'Monto',
            'tipo' => 'Tipo',
            'usuario' => 'Usuario',
            'fecha' => 'Fecha',
            'eliminado' => 'Eliminado',
            'estado' => 'Activo?',
            'enplanilla'=> 'En Planilla',
            'esagrupador'=>'Es Agrupador?',
            'idbonopadre'=>'Grupo',
            'fechamespago'=>'Fecha Mes Pago'
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $this->id);
        $criteria->addSearchCondition('t.nombre', $this->nombre, true, 'AND', 'ILIKE');
        $criteria->compare('t.monto', $this->monto);
        $criteria->addCondition("t.enplanilla=true");
        $criteria->compare('t.estado',$this->estado);
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        if ($this->fecha != Null) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
        }
       
        
        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
              'sort' => array(
                        'defaultOrder' => 't.nombre asc',                      
                        
                  )
        ));
    }
   public function searchBonoPlanillaTributaria() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $this->id);
        $criteria->addSearchCondition('t.nombre', $this->nombre, true, 'AND', 'ILIKE');
        $criteria->compare('t.monto', $this->monto);
        $criteria->addCondition("t.enplanilla=false");
        $criteria->compare('t.estado',$this->estado);
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        if ($this->fecha != Null) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
        }
       
        
        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
              'sort' => array(
                        'defaultOrder' => 't.nombre asc',                      
                        
                  )
        ));
    }
    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection() {
        return Yii::app()->rrhh;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Bono the static model class
     */
    public static function model($className = __CLASS__) {
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
        $this->nombre = strtoupper($this->nombre);
        $this->usuario = Yii::app()->user->getName();
        $this->fecha = new CDbExpression('NOW()');
        return parent::beforeSave();
    }

    protected function beforeSafeDelete() {
        //borrar_unidad(p_idunidad int,p_usuario varchar(40))
        $id = $this->id;
        $respuesta = Yii::app()->rrhh
                        ->createCommand("select borrar_bono($id) as r")
                        ->queryScalar();
        if ($respuesta) {

            return parent::beforeSafeDelete();
        } else {
            echo System::messageError('El Bono NO puede ser eliminado porque tiene Empleados asociados a este bono... ! ');
            return;
        }
    }
    /**
     * 
     * @param integer $id, id del bono
     * @return boolean ,true= si se puede mostrar en el administrado de bono ,false= si No se  puede mostrar en el administrador de bono
     */
    public function MostrarAsignar($id) {
         $model= Bono::model()->find('t.id='.SeguridadModule::dec($id));         
         return !$model->esagrupador;
    }

}
