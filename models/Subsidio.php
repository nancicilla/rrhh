<?php

/*
 * Subsidio.php
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

 * This is the model class for table "subsidio".
 *
 * The followings are the available columns in table 'subsidio':
 * @property integer $id
 * @property integer $idempleado
 * @property integer $iddependiente
 * @property string $gestion
 * @property string $fechar
 * @property string $fechaiqmes
 * @property string $fechanacbebe
 * @property integer $numbebe
 * @property boolean $activo
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Empleado $idempleado0
 * @property Dependiente $iddependiente0
 * @property Horariolactancia[] $horariolactancias
 * @property Pagosubsidio[] $pagosubsidios
 */

class Subsidio extends CActiveRecord {

    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $empleado, $beneficiario = false,$area,$fechainicio;

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
        return 'subsidio';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('idempleado, iddependiente, numbebe', 'numerical', 'integerOnly' => true),
            array('fechar, fechaiqmes,fechaafiliacion, fechanacbebe,fechapagonacidovivo, activo, fecha, eliminado', 'safe'),
            array('empleado, fechaiqmes,fechar,numbebe', 'required', 'on' => array('insert')),
            array('fechaiqmes,fechar,numbebe', 'required', 'on' => array('update')),
            array('fechanacbebe,fechaafiliacion,fechainiciolactancia,fechapagonacidovivo', 'required', 'on' => array('registroNacidoVivo')),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, empleado, iddependiente,fechainiciolactancia,fechadesde,fechahasta, gestion, fechar, fechaiqmes, fechanacbebe, numbebe, activo, usuario, fecha, eliminado,area', 'safe', 'on' => 'search'),
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
            'iddependiente0' => array(self::BELONGS_TO, 'Dependiente', 'iddependiente'),
            'horariolactancias' => array(self::HAS_MANY, 'Horariolactancia', 'idsubsidio'),
            'pagosubsidios' => array(self::HAS_MANY, 'Pagosubsidio', 'idsubsidio'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'idempleado' => 'Empleado',
            'iddependiente' => 'Beneficiaria',
            'gestion' => 'Gestión',
            'fechar' => 'Fecha Noficación',
            'fechaiqmes' => 'Fecha Quinto Mes',
            'fechanacbebe' => 'Fecha Nacimiento Bebe(s)',
            'fechaafiliacion' => 'Fecha Afiliacion',
            'fechadesde'=>'Desde',
            'fechahasta'=>'Hasta',
            'numbebe' => 'Cantidad Bebe(s)',
            'activo' => 'Estado',
            'usuario' => 'Usuario',
            'fecha' => 'Fecha',
            'eliminado' => 'Eliminado',
            'fechainiciolactancia'=>'Fecha Inicio Pago de  Lactancia',
            'fechapagonacidovivo'=>'Fecha Pago Nacido Vivo'
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
        $criteria->compare('t.idempleado', $this->idempleado);
        $criteria->compare('t.iddependiente', $this->iddependiente);
        $criteria->addSearchCondition('t.gestion', $this->gestion, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.fechar', $this->fechar, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.fechaiqmes', $this->fechaiqmes, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.fechanacbebe', $this->fechanacbebe, true, 'AND', 'ILIKE');
        $criteria->compare('t.numbebe', $this->numbebe);
        if ($this->activo != Null){    
            if ($this->activo == 1) {
                $criteria->addCondition("t.activo=true");
            } else {
                $criteria->addCondition("t.activo=false");
            }
        }
        
            $criteria->join = "right outer  JOIN general.empleado e on e.id=t.idempleado right outer  JOIN general.persona p on p.id=e.idpersona  right  JOIN dame_lista_empleado_area('".$this->area."') r ON r.id= p.id ";
       
         
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        if ($this->fecha != Null) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
        }
        $criteria->addSearchCondition('p.nombrecompleto', $this->empleado, true, 'AND', 'ILIKE');
        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
             'sort' => array(
                        'defaultOrder' => 't.id desc',                      
                        'attributes' => array(
                            'idempleado'=>array(
                                'asc'=>'p.nombrecompleto asc, t.fechar desc',
                                'desc'=>'p.nombrecompleto desc,t.fechar desc'
                            ),
                            'area'=>array(
                                'asc'=>'r.nombrearea ,p.nombrecompleto asc',
                                'desc'=>'r.nombrearea desc,p.nombrecompleto asc'
                            ),
                            'fechar'=>array(
                                'asc'=>'t.fechar ,p.nombrecompleto asc',
                                'desc'=>'t.fechar desc,p.nombrecompleto asc'
                            ),
                            'fechaiqmes'=>array(
                                'asc'=>'t.fechaiqmes ,p.nombrecompleto asc',
                                'desc'=>'t.fechaiqmes desc,p.nombrecompleto asc'
                            ),
                            'fechanacbebe'=>array(
                                'asc'=>'t.fechanacbebe ,p.nombrecompleto asc',
                                'desc'=>'t.fechanacbebe desc,p.nombrecompleto asc'
                            ),
                            'numbebe'=>array(
                                'asc'=>'t.numbebe ,p.nombrecompleto asc',
                                'desc'=>'t.numbebe desc,p.nombrecompleto asc'
                            ),
                            'usuario'=>array(
                                'asc'=>'t.usuario,p.nombrecompleto asc',
                                'desc'=>'t.usuario desc,p.nombrecompleto asc'
                            ),
                            'fecha'=>array(
                                'asc'=>'t.fecha,p.nombrecompleto asc',
                                'desc'=>'t.fecha desc,p.nombrecompleto asc'
                            ),
                        )
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
     * @return Subsidio the static model class
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
        $this->gestion = strtoupper($this->gestion);
        $this->usuario = Yii::app()->user->getName();
        $this->fecha = new CDbExpression('NOW()');
        return parent::beforeSave();
    }
    /**
     * 
     * @param integer $id, id del subsidio vinculadocon el empleado
     * @return boolean, true = si se le puede asigna Horario de Lactancia al empleado, false = No se puede Asignar Horario de Lactancia
     */
    public function MotrarHorarioLactancia($id)
    {
       $subsidio= Subsidio::model()->find('t.id='.SeguridadModule::dec($id));
       $hoy=date("Y-m-d"); 
        if ($subsidio->activo==TRUE && (($hoy >=  $subsidio->fechadesde && $hoy<=$subsidio->fechahasta )||$subsidio->fechadesde ==null)) {
         return true;
        }else{
            return false;
        }
        
    }
    
    

}
