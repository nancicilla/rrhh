<?php
/*
 * Feriado.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 07/07/2022
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
 
 * This is the model class for table "general.feriado".
 *
 * The followings are the available columns in table 'general.feriado':
 * @property string $id
 * @property string $nombre
 * @property string $fechafestividad
 * @property string $descripcion
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 */
class Feriado extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $anio;
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
            return 'general.feriado';
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
                    array('usuario', 'length', 'max'=>30),
                    array('fechafestividad, descripcion, fecha, eliminado', 'safe'),
                    array('fechafestividad, nombre','required','on'=>array('insert','update')),
                    
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id,anio, nombre, fechafestividad, descripcion, usuario, fecha, eliminado', 'safe', 'on'=>'search'),
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
                    'fechafestividad' => 'Fecha Festividad',
                    'descripcion' => 'Descripcion',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'anio'=>'Año'
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

		$criteria->addSearchCondition('t.id',$this->id,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.nombre',$this->nombre,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.descripcion',$this->descripcion,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if($this->fechafestividad!=null){
                    $criteria->addCondition("t.fechafestividad::date = '" . $this->fechafestividad."'");
                    
                 }
                 if($this->anio!=null){
                    $criteria->addCondition(" date_part('year',t.fechafestividad::date) = " . $this->anio);
                    
                 }

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                    'sort' => array(
                        'defaultOrder' => 't.fechafestividad desc',
                        'attributes' => array(
                          'nombre'=>array(
                              'asc'=>'t.nombre asc,t.fechafestividad desc',
                              'desc'=>'t.nombre desc, t.fechafestividad desc'
                          ),
                           
                            'fechafestividad'=>array(
                                'asc'=>'t.fechafestividad asc',
                                'desc'=>'t.fechafestividad desc'
                            ),
                            
                            'usuario'=>array(
                                'asc'=>'t.usuario asc,t.fechafestividad desc',
                                'desc'=>'t.usuario desc,t.fechafestividad desc'
                            )                            
           
            
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
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Feriado the static model class
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
		$this->descripcion=strtoupper($this->descripcion);
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }
    /**
     * 
     * @param integer $id, id  relacinoado con el feriado
     * retorna boolean, true si se puede mostrar el boton en el administrador, false= No se mostrara el Boton en el administrador
     */
    public function MostrarElemento($id) {
         $planilla= Planilla::model()->find(array('order'=>'id desc'));
         $feriado= Feriado::model()->find('t.id='.SeguridadModule::dec($id));
        if ($feriado->fechafestividad<=$planilla->fechafc) {
         return false;
        }else{
            return true;
        }
    }
    


}
