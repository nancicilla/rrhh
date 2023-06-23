<?php
/*
 * Asistencia.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 26/06/2019
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
 
 * This is the model class for table "general.asistencia".
 *
 * The followings are the available columns in table 'general.asistencia':
 * @property integer $id
 * @property double $diasa
 * @property integer $horasa
 * @property integer $mina
 * @property double $diasv
 * @property integer $horasv
 * @property integer $minv
 * @property double $dias
 * @property string $fechadesde
 * @property string $fechahasta
 * @property integer $idempleado
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Empleado $idempleado
 */
class Asistencia extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $empleado,$fechamin,$fechamax,$fechainic,$fechaseguimiento,$minlactancia,$idhoralactancia;
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
            return 'asistencia';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('horasasistidas,horashorario,horasatrasos, idempleado', 'numerical', 'integerOnly'=>true),
                    array(' dias', 'numerical'),
                    array('usuario', 'length', 'max'=>30),
                    array('fechadesde, fechahasta, fecha, eliminado', 'safe'),
                    array('fechadesde,fechahasta,fechaic,fechafc','required','on'=>array('insert')),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id,  horasasistidas,horashorario,horasatrasos, dias, fechadesde, fechahasta, empleado, usuario, fecha, eliminado, estado', 'safe', 'on'=>'search'),
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
                    'idempleado0' => array(self::BELONGS_TO, 'Empleado', 'idempleado'),
                 'idplanilla0' => array(self::BELONGS_TO, 'Planilla', 'idplanilla'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    
                 
                    'dias' => 'Dias',
                    'fechadesde' => 'Desde(fecha)',
                    'fechahasta' => 'Hasta(fecha)',
                    'idempleado' => 'Empleado',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    
                    'fechaic'=>'Desde',
                    'fechafc'=>'Hasta',
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
	$criteria->compare('t.id',$this->id);
	$criteria->join = "right outer  JOIN  general.empleado t.idempleado= e.id right outer  JOIN general.persona p on p.id=t.idpersona";
        $criteria->addSearchCondition('p.nombrecompleto',$this->empleado,true,'AND','ILIKE');
        $criteria->compare('pl.estado',1);
        $criteria->join = "right  JOIN  general.empleado e on e.id=t.idempleado inner join general.persona p on p.id=e.idpersona inner join planilla pl  on pl.id=t.idplanilla";
        
	if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),

                    ), 
                    'criteria'=>$criteria,
                    'sort' => array(
                        'defaultOrder' => 'p.nombrecompleto asc', 
                     'attributes' => array(
                         'idempleado'=>array(
                             'asc'=>'p.nombrecompleto asc',
                             'desc'=>'p.nombrecompleto desc'
                         ),
                         'horashorario'=>array(
                             'asc'=>'t.horashorario ,p.nombrecompleto asc',
                             'desc'=>'t.horashorario ,p.nombrecompleto desc'
                         ),
                         'horasasistidas'=>array(
                             'asc'=>'t.horasasistidas,p.nombrecompleto asc',
                             'desc'=>'t.horasasistidas ,p.nombrecompleto desc'
                         ),
                         'horasatraso'=>array(
                             'asc'=>'t.horasatraso,p.nombrecompleto asc',
                             'desc'=>'t.horasatraso ,p.nombrecompleto desc'
                         ),
                         'horasextras'=>array(
                             'asc'=>'t.horasextras,p.nombrecompleto asc',
                             'desc'=>'t.horasextras ,p.nombrecompleto desc'
                         ),
                         'diasfalta'=>array(
                             'asc'=>'t.diasfalta,p.nombrecompleto asc',
                             'desc'=>'t.diasfalta,p.nombrecompleto desc'
                         ),
                         
                     ))
                ))
            ;
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
     * @return Asistencia the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    public function dameFechas()
    {
        $asistecia=Asistencia::model()->findAll(array('limit'=>1));
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
