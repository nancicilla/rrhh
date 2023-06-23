<?php

/*
 * Puestotrabajo.php
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

 * This is the model class for table "general.puestotrabajo".
 *
 * The followings are the available columns in table 'general.puestotrabajo':
 * @property integer $id
 * @property string $nombre
 * @property string $nivel
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 * @property integer $idseccion
 *
 * The followings are the available model relations:
 * @property Seccion $idseccion
 * @property Contrato[] $contratos
 * @property Movimientopersonal[] $movimientopersonals
 */

class Puestotrabajo extends CActiveRecord {

    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $unidad;
    public $area;
    public $seccion;
    public $idunidad, $cuenta;

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
        return 'general.puestotrabajo';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('idseccion', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 60),
            array('nivel, usuario', 'length', 'max' => 30),
            array('fecha, eliminado', 'safe'),
            array('nombre,idseccion,clasificacionlaboral', 'required', 'on' => array('insert', 'update')),
            array('area', 'required', 'on' => array('insert')),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, nivel, usuario,cuenta, fecha, eliminado, seccion', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idcuenta0' => array(self::BELONGS_TO, 'Cuenta', 'idcuenta'),
            'idseccion0' => array(self::BELONGS_TO, 'Seccion', 'idseccion'),
            'movimientopersonal' => array(self::HAS_MANY, 'Movimientopersonal', 'idpuestotrabajo'),
            'puestotrabajobonoses' => array(self::HAS_MANY, 'Puestotrabajobonos', 'idpuestotrabajo'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nombre' => 'Nombre',
            'nivel' => 'Nivel',
            'usuario' => 'Usuario',
            'fecha' => 'Fecha',
            'eliminado' => 'Eliminado',
            'idseccion' => 'Sección',
            'horaextra' => 'Hora Extra',
            'minutostolerancia' => 'Minutos Entrada/Salida',
            'asignarhora' => 'Asignar Horas Extra Automaticamente?',
            'idcuenta' => 'Cuenta',
            'clasificacionlaboral'=>'Clasificacion Laboral'
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
        $criteria->addSearchCondition('t.nivel', $this->nivel, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        if ($this->fecha != Null) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
        }

        $criteria->join = "right outer  JOIN  general.seccion s on s.id=t.idseccion";
        if ($this->cuenta != null) {
            $criteria->addCondition("t.idcuenta in ( select id from  ftbl_moodle_cuenta where nombre like'%" . strtoupper($this->cuenta) . "%' or REPLACE (numero, '.', '') like'" . strtoupper($this->cuenta) . "%' )");
        }
        if ($this->seccion != '') {
            $criteria->addCondition("s.nombre like'%" . strtoupper($this->seccion) . "%'");
        }
       
        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
            'sort' => array(
                        'defaultOrder' => 't.nombre asc',
                        'attributes' => array(
                                    'idseccion' => array(
                                        'asc' => 's.nombre asc,t.nombre asc',
                                        'desc' => 's.nombre desc,t.nombre asc',
                                    ),
                            'nombre' => array(
                                        'asc' => 't.nombre asc',
                                        'desc' => 't.nombre desc',
                                    ),
                            
           
            
        )
                    ),
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
     * @return Puestotrabajo the static model class
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
        $this->nivel = strtoupper($this->nivel);
        $this->usuario = Yii::app()->user->getName();
        $this->fecha = new CDbExpression('NOW()');
        return parent::beforeSave();
    }
    /**
     * 
     * @param string $nombre,nombre o parte del nombre del puesto de trabajo
     * @return \CActiveDataProvider
     */
    public function filtraPuestoTrabajo($nombre) {
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.nombre ilike '%" . $nombre . "%'");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }
   /**
    * 
    * @return string,mensaje en el caso de que No pueda elminar el Puesto de Trabajo
    */
    protected function beforeSafeDelete() {
        $id = $this->id;
        $respuesta = Yii::app()->rrhh
                        ->createCommand("select borrar_puestotrabajo($id) as r")
                        ->queryScalar();


        if ($respuesta) {

            return parent::beforeSafeDelete();
        } else {
            echo System::messageError('El Puesto de Trabajo NO puede ser eliminado porque tiene Empleado(s) asociados... ! ');
            return;
        }
    }

}
