<?php
/*
 * Seccion.php
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
 
 * This is the model class for table "general.seccion".
 *
 * The followings are the available columns in table 'general.seccion':
 * @property integer $id
 * @property string $sigla
 * @property string $nombre
 * @property integer $idarea
 * @property integer $idcuenta
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Area $idarea
 */
class Seccion extends CActiveRecord
{
     public $cuenta;
      public $unidad;
       public $area;
      
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
            return 'general.seccion';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idarea, idcuenta', 'numerical', 'integerOnly'=>true),
                      array('nombre,idarea', 'required', 'on' => array('insert', 'update')),
                        array('sigla', 'unique', 'on' => array('insert', 'update'), 'message' => 'La Sigla ya existe'),
                       
                    array('sigla', 'length', 'max'=>4),
                    array('nombre', 'length', 'max'=>40),
                    array('usuario', 'length', 'max'=>30),
                    array('fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.

                    array('id, sigla, nombre, area,cuenta, idcuenta, usuario, fecha, eliminado', 'safe', 'on'=>'search'),

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
                    'idarea0' => array(self::BELONGS_TO, 'Area', 'idarea'),
                    'puestotrabajos' => array(self::HAS_MANY, 'Puestotrabajo', 'idseccion'),
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
                    'idarea' => 'Area',
                    'idcuenta' => 'Cuenta',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
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
		$criteria->addSearchCondition('t.sigla',$this->sigla,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.nombre',$this->nombre,true,'AND','ILIKE');
		$criteria->compare('t.idcuenta',$this->idcuenta);
        $criteria->join = "right outer  JOIN  general.area a on a.id=t.idarea";
        $criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
          if ($this->cuenta!=null) {
            $criteria->addCondition("t.idcuenta in ( select id from  ftbl_moodle_cuenta where nombre like'%".strtoupper($this->cuenta)."%' or REPLACE (numero, '.', '') like'".strtoupper($this->cuenta)."%' )");
         }
         if ($this->area!='') {
             $criteria->addCondition("a.nombre like'%".strtoupper($this->area)."%'");
        
         }
     
          if ($this->cuenta!=null) {
             $criteria->addCondition("t.idcuenta in ( select id from  ftbl_moodle_cuenta where nombre like'%".strtoupper($this->cuenta)."%')");
        
         }
         if ($this->area!='') {
             $criteria->addCondition("a.nombre like'%".strtoupper($this->area)."%'");
        
         }
       

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                     'sort' => array(
                        'defaultOrder' => 't.nombre asc',
                            'attributes' => array(
                                    'idarea' => array(
                                        'asc' => 'a.nombre asc,t.nombre asc',
                                        'desc' => 'a.nombre desc,t.nombre asc',
                                    ),
                                 'sigla' => array(
                                        'asc' => 't.sigla asc,t.nombre asc,a.nombre asc',
                                        'desc' => 't.sigla desc,t.nombre asc,a.nombre asc',
                                    ),
                                 'nombre' => array(
                                        'asc' => 't.nombre asc,a.nombre asc',
                                        'desc' => 't.nombre desc,a.nombre asc',
                                    ),
                            
           
        )
                    ),
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
     * 
     * @param model $model, modelo relacionado con la tabla seccion
     * @return boolean, true = si el Modelo se guardo correctamente,false = si no se Pudo guardar
     */
    public function guardarDatos($model)
    {

        $mod=Seccion::model()->findAll("t.sigla='".strtoupper($model->sigla)."'");
        if (count($mod)>0) {
           return false;
        }
        else{
           return $model->save();
        }
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Seccion the static model class
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
    /**
     * 
     * @return string, Mensaje en el caso de No poder eliminar la seccion
     */
     protected function beforeSafeDelete() {
        $id=$this->id;         
        $respuesta=Yii::app()->rrhh
            ->createCommand("select borrar_seccion($id) as r")
            ->queryScalar(); 
        if ($respuesta) {
            
            return parent::beforeSafeDelete();
        } else {
            echo System::messageError('La Seccion NO puede ser eliminada porque tiene Puestos de  Trabajo asociados... ! ');
            return;
        }
    }


}
