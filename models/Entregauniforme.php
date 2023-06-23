<?php
/*
 * Entregauniforme.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 16/05/2022
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
 
 * This is the model class for table "entregauniforme".
 *
 * The followings are the available columns in table 'entregauniforme':
 * @property string $id
 * @property integer $idempleado
 * @property string $fechaentrega
 * @property string $fechadevolucion
 * @property string $descripcion_entrega
 * @property string $descripcion_devolucion
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Empleado $idempleado0
 */
class Entregauniforme extends CActiveRecord
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
            return 'entregauniforme';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idempleado', 'numerical', 'integerOnly'=>true),
                    array('usuario', 'length', 'max'=>30),
                    array('fechaentrega, fechadevolucion, descripcion_entrega, descripcion_devolucion, fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, idempleado, fechaentrega, fechadevolucion, descripcion_entrega, descripcion_devolucion, usuario, fecha, eliminado', 'safe', 'on'=>'search'),
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
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'idempleado' => 'Idempleado',
                    'fechaentrega' => 'Fecha Entrega',
                    'fechadevolucion' => 'Fecha Devolucion',
                    'descripcion_entrega' => 'Descripcion Entrega',
                    'descripcion_devolucion' => 'Descripcion Devolucion',
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

		$criteria->addSearchCondition('t.id',$this->id,true,'AND','ILIKE');
		$criteria->compare('t.idempleado',$this->idempleado);
		$criteria->addSearchCondition('t.fechaentrega',$this->fechaentrega,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.fechadevolucion',$this->fechadevolucion,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.descripcion_entrega',$this->descripcion_entrega,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.descripcion_devolucion',$this->descripcion_devolucion,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
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
     * @return Entregauniforme the static model class
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
		$this->descripcion_entrega=strtoupper($this->descripcion_entrega);
		$this->descripcion_devolucion=strtoupper($this->descripcion_devolucion);
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }
    /**
     * 
     * @param integer $idempleado, id del empleado
     * @param integer[] $lista, lista de id de uniformes a devolver
     * @param date $fecha , fecha de devolucion
     * @param string $descripcion, descripcion de la devolucion
     */
     public function guardarDebolucionUniforme($idempleado,$lista,$fecha,$descripcion)
    {

        $cantidad=count($lista);
     
     for ($i=1; $i <=$cantidad ; $i++) { 
            if ($lista[$i]['id']!='' && $lista[$i]['descripcion_entrega']!='') {
             $entregauniforme=  Entregauniforme::model()->findByPk($lista[$i]['id']);             
             $entregauniforme->fechadevolucion=$fecha;           
             $entregauniforme->descripcion_devolucion= strtoupper($descripcion);

                
              if($entregauniforme->save()){
                echo '';
             }else{
                echo "-->".$fecha;
                print_r($entregauniforme->getErrors());
               
             }
        
        }
    }
    }
    /**
     * 
     * @param integer $idempleado, id del empleado
     * @return \CActiveDataProvider, informacion de los uniformes entregados
     */
    public function listaUniformes($idempleado)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.idempleado = ".$idempleado);
        $criteria->addCondition("t.fechadevolucion is null");
        
        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.id asc',
            )
        ));
    }

}
