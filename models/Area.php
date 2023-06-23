<?php
/*
 * Area.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 29/03/2019
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
 
 * This is the model class for table "general.area".
 *
 * The followings are the available columns in table 'general.area':
 * @property integer $id
 * @property string $sigla
 * @property string $nombre
 * @property integer $idunidad
 * @property integer $idcuenta
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Unidad $idunidad
 * @property Seccion[] $seccions
 */
class Area extends CActiveRecord
{
    public $cuenta;
    public $listaa;
    public $unidad;
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
            return 'general.area';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idunidad, idcuenta', 'numerical', 'integerOnly'=>true),
                    array('sigla', 'unique', 'on' => array('insert', 'update'), 'message' => 'La sigla ya existe'),                    
                    array('nombre, idunidad,toleranciaenhorario', 'required', 'on' => array('insert', 'update')),
                    array('sigla', 'length', 'max'=>3),
                    array('nombre', 'length', 'max'=>60),
                    array('usuario', 'length', 'max'=>30),
                    array('fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.

                    array('id, sigla, nombre,unidad,cuenta, usuario, fecha,toleranciaenhorario, eliminado', 'safe', 'on'=>'search'),
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
                 'idcuenta0' => array(self::BELONGS_TO, 'Cuenta', 'idcuenta'),
                   'idunidad0' => array(self::BELONGS_TO, 'Unidad', 'idunidad'),
                    'seccions' => array(self::HAS_MANY, 'Seccion', 'idarea'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'sigla' => 'Sigla',
                    'nombre' => 'Nombre',
                    'idunidad' => 'Unidad',
                    'idcuenta' => 'Cuenta Planilla',
                    'toleranciaenhorario'=>'Tolerancia en Horario?',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
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
		$criteria->addSearchCondition('t.sigla',$this->sigla,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.nombre',$this->nombre,true,'AND','ILIKE');

		$criteria->join = "right outer  JOIN  general.unidad u on u.id=t.idunidad";
         
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
       
        
          if ($this->unidad!='') {
             $criteria->addCondition("u.nombre like'%".strtoupper($this->unidad)."%'");
        
         }
          if ($this->cuenta!=null) {
             $criteria->addCondition("t.idcuenta in ( select id from  ftbl_moodle_cuenta where nombre like'%".strtoupper($this->cuenta)."%' or REPLACE (numero, '.', '') like'".strtoupper($this->cuenta)."%' )");
         }
       
         // $criteria->order='t.nombre asc';


            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                 'sort' => array(
                        'defaultOrder' => 't.nombre asc',
                    ),
            ));
    }
    /**
     * 
     * @param string $nombre, nombre del area
     * @return \CActiveDataProvider  de areas que contengan en su nombre a $nombre
     */
 public function filtraArea($nombre)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.nombre ilike '%".$nombre."%'");
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
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
     * @return Area the static model class
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
		$this->sigla=strtoupper($this->sigla);
		$this->nombre=strtoupper($this->nombre);
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }
  protected function beforeSafeDelete() {
        $id=$this->id;     
        $respuesta=Yii::app()->rrhh
            ->createCommand("select borrar_area($id) as r")
            ->queryScalar(); 
        if ($respuesta) {
            
            return parent::beforeSafeDelete();
        } else {
            echo System::messageError('La Area NO puede ser eliminada porque tiene Secciones asociadas... ! ');
            return;
        }
    }

}
