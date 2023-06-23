<?php
/*
 * Otrosgastos.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 21/02/2022
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
 
 * This is the model class for table "otrosgastos".
 *
 * The followings are the available columns in table 'otrosgastos':
 * @property integer $id
 * @property string $nombre
 * @property string $fecharegistro
 * @property integer $idempleado
 * @property string $monto
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Empleado $idempleado0
 */
class Otrosgastos extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public  $fechadesde,$fechahasta,$empleado;
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
            return 'otrosgastos';
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
                    array('monto', 'length', 'max'=>12),
                    array('usuario', 'length', 'max'=>30),
                    array('nombre, fecharegistro, fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, nombre,empleado, fecharegistro,fechadesde,fechahasta, idempleado, monto, usuario, fecha, eliminado', 'safe', 'on'=>'search'),
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
                    'nombre' => 'Descripción',
                    'fecharegistro' => 'Fecha Registro',
                    'idempleado' => 'Empleado',
                    'monto' => 'Monto(Bs.)',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'fechadesde'=>'Desde',
                    'fechahasta'=>'Hasta'
                
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
		$criteria->addSearchCondition('t.nombre',$this->nombre,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.monto',$this->monto,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		$criteria->join='right outer  JOIN  general.empleado e on e.id=t.idempleado inner join general.persona p on p.id=e.idpersona';
                $criteria->addCondition('e.eliminado=false');
               
                
                if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
                if ($this->fechadesde != Null && $this->fechahasta == Null) {
                    $criteria->addCondition("t.fecharegistro::date >= '" . $this->fechadesde. "'");
		 }
                else if ($this->fechadesde != Null && $this->fechahasta != Null) {
                    $criteria->addCondition("t.fecharegistro::date between  '" . $this->fechadesde. "' and '".$this->fechahasta."'");
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
     * @return Otrosgastos the static model class
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
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }
    /**
     * 
     * @param date $fecharegistro, fecha de registro
     * @param string $descripcion, un detalle
     * @param integer[,] $lista, lista de ci y mosnto a descontar en Otros gastos
     * @return boolean
     */
    public function registrarOtrosGastosEmpleado ($fecharegistro ,$descripcion,$lista)
    {
       $usuario= Yii::app()->user->getName();
        $cant=count($lista);
        for ($i=1; $i <=$cant ; $i++) { 
            if ($lista[$i]['ci']!='' &&  $lista[$i]['monto']!='0'  ) {
              Yii::app()->rrhh
            ->createCommand(" select registrar_empleado_otrosgastos('".$lista[$i]['ci']."' ,".$lista[$i]['monto'].",'$descripcion' ,'$fecharegistro'::date,'$usuario')")
            ->execute();   
            }
        }
    return true;
     }
     /**
      * 
      * @param integer $id, id relacionado con otros gastos
      * @return boolean, true= si se va a mostrar el boton de eliminar en el administrador de Otros Gastos y false si NO se va a mostrar 
      */
    public function mostrarElemento($id) {
      
       $model=Otrosgastos::model()->findByPk(SeguridadModule::dec($id));
       $fecha=Yii::app()->rrhh
        ->createCommand("select case when estado=1 then fechadesde else fechahasta+1 end  from planilla where eliminado=false order by id desc limit 1        ")
        ->queryScalar();
       if ($model->fecharegistro>=$fecha || $fecha ==null){
           return true;
       }else{
           return false;
       }

       
         
     }
}
