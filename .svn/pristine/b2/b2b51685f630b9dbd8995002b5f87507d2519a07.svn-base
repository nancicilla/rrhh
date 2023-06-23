<?php
/*
 * Porcentajepago.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 16/11/2021
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
 
 * This is the model class for table "general.porcentajepago".
 *
 * The followings are the available columns in table 'general.porcentajepago':
 * @property string $id
 * @property string $porcentaje
 * @property string $fechadesde
 * @property integer $idempresasubempleadora
 * @property integer $idempleado
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Empleado $idempleado
 * @property Empresasubempleadora $idempresasubempleadora
 */
class Porcentajepago extends CActiveRecord
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
            return 'general.porcentajepago';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idempresasubempleadora, idempleado', 'numerical', 'integerOnly'=>true),
                    array('porcentaje', 'length', 'max'=>12),
                    array('usuario', 'length', 'max'=>30),
                    array('fechadesde, fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, porcentaje, fechadesde, idempresasubempleadora, idempleado, usuario, fecha, eliminado', 'safe', 'on'=>'search'),
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
                    'idempleado' => array(self::BELONGS_TO, 'Empleado', 'idempleado'),
                    'idempresasubempleadora0' => array(self::BELONGS_TO, 'Empresasubempleadora', 'idempresasubempleadora'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'porcentaje' => 'Porcentaje',
                    'fechadesde' => 'Fechadesde',
                    'idempresasubempleadora' => 'Idempresasubempleadora',
                    'idempleado' => 'Idempleado',
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
		$criteria->addSearchCondition('t.porcentaje',$this->porcentaje,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.fechadesde',$this->fechadesde,true,'AND','ILIKE');
		$criteria->compare('t.idempresasubempleadora',$this->idempresasubempleadora);
		$criteria->compare('t.idempleado',$this->idempleado);
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
     * @return Porcentajepago the static model class
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
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }
    /**
     * 
     * @param integer $idempleado, id del empleado
     * @return \CActiveDataProvider
     */
    public function listaPagos($idempleado)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.idempleado = ".$idempleado);
        $criteria->join = "right  JOIN general.empresasubempleadora e  ON e.id= t.idempresasubempleadora ";
        $criteria->order = 'e.nombre asc';
        $criteria->select='t.*,e.nombre';
        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.id asc',
            )
        ));
    }
    /**
     * 
     * @param integer $idempleado
     * @return \CActiveDataProvider
     */
     public function listaPagosfecha($idempleado)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.idempleado = ".$idempleado);
        $criteria->join = "right  JOIN general.empresasubempleadora e  ON e.id= t.idempresasubempleadora ";
        $criteria->order = 'e.nombre asc';
        $criteria->addCondition("t.id in( select id from general.porcentajepago  where idempleado=$idempleado  and eliminado=false  and fechadesde=(select fechadesde from general.porcentajepago  where eliminado=false and idempleado=$idempleado order by fechadesde desc limit 1))");
        $criteria->select='t.*,e.nombre';
        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.id asc',
            )
        ));
    }
    /**
     * 
     * @param integer $idempleado, id del empleado
     * @param date $fechadesde, fecha de ingreso a Planilla 
     * @param array $lista, lista de empresas SubEmpleadoras
     */
    public function registrarPorcentajes($idempleado,$fechadesde,$lista) {
       $cant=count($lista);
         if($fechadesde==''){
             $tusuario= Yii::app()->user->getName();
             Yii::app()->rrhh
            ->createCommand("update general.porcentajepago set eliminado=true,fecha=now() where eliminado=false and idempleado=$idempleado and fechadesde=now()::date")
            ->execute();
         }
         for ($i=1; $i <=$cant ; $i++) { 
         if($lista[$i]['idempresasubempleadora']!='' && $lista[$i]['porcentaje']!=''){
         $d=new Porcentajepago;
         $d->idempresasubempleadora=$lista[$i]['idempresasubempleadora'];
         $d->porcentaje= floatval( $lista[$i]['porcentaje']);
         if($fechadesde!=''){
         $d->fechadesde=$fechadesde;
         
         }else{
             $d->fechadesde=date("Y-m-d");
         }
         $d->idempleado=$idempleado;          
         if (!$d->save()) {
               print_r($d);
           }  
        }
    } 
    }


}
