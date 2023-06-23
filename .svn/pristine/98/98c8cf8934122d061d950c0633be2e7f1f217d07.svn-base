<?php

/*
 * Empleadodeducciones.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 09/12/2019
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

 * This is the model class for table "empleadodeducciones".
 *
 * The followings are the available columns in table 'empleadodeducciones':
 * @property integer $id
 * @property string $monto
 * @property integer $iddeducciones
 * @property integer $idempleado
 * @property string $descripcion
 * @property string $fechar
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Empleado $idempleado0
 * @property Deducciones $iddeducciones0
 */

class Empleadodeducciones extends CActiveRecord {

    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $empleado, $cuenta, $tipodeduccion, $fechadesde, $fechahasta;

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
        return 'empleadodeducciones';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('iddeducciones, idempleado', 'numerical', 'integerOnly' => true),
            array('usuario', 'length', 'max' => 30),
            array('monto, descripcion, fechar, fecha, eliminado', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('iddeducciones, idempleado,fechar,monto', 'required', 'on' => array('insert')),
            array('iddeducciones, fechar,monto', 'required', 'on' => array('update')),
            array('id, monto, iddeducciones,tipodeduccion,fechadesde,fechahasta, empleado, descripcion, fechar, usuario, fecha, eliminado', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idempleado0' => array(self::BELONGS_TO, 'Empleado', 'idempleado'),
            'iddeducciones0' => array(self::BELONGS_TO, 'Deducciones', 'iddeducciones'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'monto' => 'Monto(Bs.)',
            'iddeducciones' => 'Deducción',
            'idempleado' => 'Empleado',
            'descripcion' => 'Descripción',
            'fechar' => 'Fecha Deducción',
            'usuario' => 'Usuario',
            'fecha' => 'Fecha ',
            'eliminado' => 'Eliminado',
            'fechadesde' => 'Fecha desde',
            'fechahasta' => 'Fecha hasta',
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
        $criteria->addSearchCondition('t.monto', $this->monto, true, 'AND', 'ILIKE');
        $criteria->compare('t.iddeducciones', $this->iddeducciones);
        $criteria->join = "inner join general.deducciones d on d.id=t.iddeducciones right outer  JOIN  general.empleado e ON t.idempleado= e.id right outer  JOIN general.persona p on p.id=e.idpersona";
        $criteria->addSearchCondition('t.descripcion', $this->descripcion, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        if ($this->fecha != Null) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
        }
        if ($this->fechadesde != Null) {
            $criteria->addCondition("t.fechar::date >='$this->fechadesde'");
        }
        if ($this->fechahasta != Null) {
            $criteria->addCondition("t.fechar::date <='$this->fechahasta'");
        }
        $criteria->addSearchCondition('p.nombrecompleto', $this->empleado, true, 'AND', 'ILIKE');

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'p.nombrecompleto,t.fechar,t.descripcion asc',
                'attributes'=>array(
                    'idempleado'=>array(
                        'asc'=>'p.nombrecompleto asc,t.fechar ,t.descripcion asc',
                        'desc'=>'p.nombrecompleto desc,t.fechar ,t.descripcion asc'
                    ),
                    'fechar'=>array(
                        'asc'=>' t.fechar asc,p.nombrecompleto ,t.descripcion asc',
                        'desc'=>'t.fechar desc,p.nombrecompleto ,t.descripcion asc'
                    ),
                    'iddeducciones'=>array(
                        'asc'=>'d.nombre ,p.nombrecompleto ,t.fechar asc,t.descripcion asc',
                        'desc'=>'d.nombre desc ,p.nombrecompleto ,t.fechar asc,t.descripcion asc'
                    ),
                    'descripcion'=>array(
                        'asc'=>'t.descripcion ,p.nombrecompleto ,t.fechar ,t.descripcion asc',
                        'desc'=>'t.descripcion desc ,p.nombrecompleto ,t.fechar ,t.descripcion asc'
                    ),
                    'monto'=>array(
                        'asc'=>'t.monto ,p.nombrecompleto ,t.fechar ,t.descripcion asc',
                        'desc'=>'t.monto desc ,p.nombrecompleto ,t.fechar ,t.descripcion asc'
                    ),
                    'usuario'=>array(
                        'asc'=>'t.usuario ,p.nombrecompleto ,t.fechar ,t.descripcion asc',
                        'desc'=>'t.usuario desc ,p.nombrecompleto ,t.fechar ,t.descripcion asc'
                    ),
                    'fecha'=>array(
                        'asc'=>'t.fecha ,p.nombrecompleto ,t.fechar ,t.descripcion asc',
                        'desc'=>'t.fecha desc ,p.nombrecompleto ,t.fechar ,t.descripcion asc'
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
     * @return Empleadodeducciones the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    /**
     * 
     * @param integer $id , id de la deduccion vinculada con el empleado
     * @return boolean ,true= si se puede mostrar el boton , false= no se puede mostrar el boton
     */
     public function MostrarElemento($id)
    {
        $model=Empleadodeducciones::model()->findByPk(SeguridadModule::dec($id));

        $fecha=Yii::app()->rrhh
        ->createCommand("select case when estado=1 then to_char(fechadesde,'dd-mm-YYYY') else to_char(fechahasta+1,'dd-mm-YYYY') end  from planilla where eliminado=false order by id desc limit 1
        ")
        ->queryScalar();
        if ($fecha==null){
            $fecha=date("d-m-Y");
        }
        if ($fecha< $model->fechar) {
          return true;
         }else{
          return false;
         }
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
        $this->descripcion = strtoupper($this->descripcion);
        $this->usuario = Yii::app()->user->getName();
        $this->fecha = new CDbExpression('NOW()');
        return parent::beforeSave();
    }

}
