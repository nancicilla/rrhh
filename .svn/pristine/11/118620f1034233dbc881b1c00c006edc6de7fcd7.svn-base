<?php
/*
 * Formulario110.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 03/08/2022
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
 
 * This is the model class for table "general.formulario110".
 *
 * The followings are the available columns in table 'general.formulario110':
 * @property string $id
 * @property integer $idempleado
 * @property string $fechapresenacion
 * @property string $montopresentado
 * @property string $porcentaje
 * @property string $montodescontado
 * @property string $saldo
 * @property integer $idplanilla
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Empleado $idempleado
 * @property Planilla $idplanilla
 */
class Formulario110 extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public  $empleado;
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
            return 'general.formulario110';
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
                    array('montopresentado, montodescontado, saldo', 'length', 'max'=>12),
                    array('usuario', 'length', 'max'=>30),
                    array('fechapresentacion, porcentaje, fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, idempleado,empleado, fechapresentacion, montopresentado, porcentaje, montodescontado, saldo, planillas, usuario, fecha, eliminado', 'safe', 'on'=>'search'),
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
                    'idempleado0' => array(self::BELONGS_TO, 'Empleado', 'idempleado')
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'idempleado' => 'Empleado',
                    'fechapresentacion' => 'Fecha Presentacion',
                    'montopresentado' => 'Monto Presentado',
                    'porcentaje' => 'Porcentaje (%)',
                    'montodescontado' => 'Monto Descontado',
                    'saldo' => 'Saldo',
                    'planillas' => 'Planillas',
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
		//$criteria->compare('t.montopresentado',$this->montopresentado);
                $criteria->addSearchCondition('t.montopresentado::text',$this->montopresentado,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.porcentaje',$this->porcentaje,true,'AND','ILIKE');
		$criteria->compare('t.saldo',$this->saldo);
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		$criteria->addSearchCondition('p.nombrecompleto',$this->empleado,true,'AND','ILIKE');
                $criteria->select ='t.*';
                $criteria->join = "right outer  JOIN  general.empleado e ON e.id= t.idempleado right outer  JOIN general.persona p on p.id=e.idpersona ";
       
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
                 if ($this->fechapresentacion != Null) {
		$criteria->addCondition("t.fechapresentacion::date = '" . $this->fechapresentacion. "'");
		 }

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                'sort' => array(
                        'defaultOrder' => 't.fechapresentacion desc,p.nombrecompleto asc,t.id desc ',                      
                        'attributes' => array(
                            'fechapresentacion'=>array(
                                'asc'=>'t.fechapresentacion asc,p.nombrecompleto asc ,t.id asc',
                                'desc'=>'t.fechapresentacion desc,p.nombrecompleto desc,t.id desc'
                            ),
                           
                            'idempleado'=>array(
                                'asc'=>'p.nombrecompleto asc,t.fechapresentacion desc,t.id desc ',
                                'desc'=>'p.nombrecompleto desc,t.fechapresentacion desc,t.id desc'
                                
                            ),
                            'montopresentado'=>array(
                                'asc'=>'t.montopresentado asc, p.nombrecompleto asc,t.fechapresentacion desc,t.id desc ',
                                'desc'=>'t.montopresentado desc, p.nombrecompleto desc,t.fechapresentacion desc,t.id desc'
                                
                            ),
                            'saldo'=>array(
                                'asc'=>'t.saldo asc, p.nombrecompleto asc,t.fechapresentacion desc,t.id desc ',
                                'desc'=>'t.saldo desc, p.nombrecompleto desc,t.fechapresentacion desc,t.id desc'
                                
                            )
                            
                        )
                   )
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
     * @return Formulario110 the static model class
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
     * @param date $fechapresentacion, fecha en la que hace la presentacion de la factura
     * @param array $lista, lista de empleados-montos 
     */
    public function Registrar($fechapresentacion,$lista) {
        $usuario= Yii::app()->user->getName();
        $cantidad= count($lista);
        for($i=1;$i<=$cantidad;$i++){
            if($lista[$i]['ci']!=''){
                $idempleado=Yii::app()->rrhh->createCommand('select  e.id from general.empleado e inner join general.persona p on p.id=e.idpersona where p.ci::int='.$lista[$i]["ci"])->queryScalar();
            
                 Yii::app()->rrhh
            ->createCommand("select registrar_formulario110('$fechapresentacion'::date,".$idempleado." ,".$lista[$i]['monto'].",'$usuario') ")
            ->execute();
            }
        }
        
    }
    /**
     * 
     * @param integer $id, id de relacionado con el monto presentado 
     * @return boolean , true= Si se va mostrar el Boton Editar/Eliminar y false = si No se va a mostrar el Boton  Editar/Eliminar
     */ 
    public function MostrarBoton($id)
    {
        $fechaminima=    Yii::app()->rrhh
            ->createCommand("select case when estado=1 then fechadesde-1 else  fechahasta+1 end from planilla where eliminado=false order by id desc limit 1  ")
            ->queryScalar();
       
        if(!isset($fechaminima)){
            $fechaminima=    Yii::app()->rrhh
            ->createCommand("select valor::date from general.configuracion where id=26 ")
            ->queryScalar();
        }
        
       $factura= Formulario110::model()->find('t.id='.SeguridadModule::dec($id));
    
        if ($factura->fechapresentacion>=$fechaminima && $factura->montopresentado>0) {
         return true;
        }else{
            return false;
        }
        
    }
    /**
     * 
     * @param integer $id, id del elemento a modificar
     * @param date $fechapresentacion, fecha en la que hace la presentacion de la factura
     * @param float $monto, nuevo monto 
     */
    public function Actualizar($id, $fechapresentacion,$monto) {
        $usuario= Yii::app()->user->getName();
        Yii::app()->rrhh
            ->createCommand("select actualizar_formulario110($id, '$fechapresentacion'::date, $monto,'$usuario') ")
            ->execute();
        
        
    }


}
