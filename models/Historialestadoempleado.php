<?php
/*
 * Historialestadoempleado.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 04/05/2020
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
 
 * This is the model class for table "general.historialestadoempleado".
 *
 * The followings are the available columns in table 'general.historialestadoempleado':
 * @property integer $id
 * @property string $fechaantiguedad
 * @property string $fechaplanilla
 * @property string $fechaultidemnizacion
 * @property string $fecharetiro
 * @property boolean $eliminado
 * @property string $fecha
 * @property string $usuario
 * @property integer $idempleado
 *
 * The followings are the available model relations:
 * @property Empleado $idempleado
 */
class Historialestadoempleado extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $empleado,$sueldo;
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
            return 'general.historialestadoempleado';
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
                    array('usuario', 'length', 'max'=>40),
                    array('fechaantiguedad, fechaplanilla, fechaultidemnizacion, fecharetiro, eliminado', 'safe'),
                    array('fechaplanilla,fechaantiguedad,fechaultidemnizacion,activo', 'required', 'on' => array('insert')),
array('fechavacacion', 'required', 'on' => array( 'update')),
                                      
// array('fecharetiro,fechaplanilla,fechaantiguedad,fechaultidemnizacion,activo', 'required', 'on' => array( 'update')),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, fechaantiguedad,fechafincontrato, fechaplanilla, fechaultidemnizacion, fecharetiro, eliminado, fecha,empleado, usuario, idempleado', 'safe', 'on'=>'search'),
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
                    'fechaantiguedad' => 'Fecha Antiguedad',
                    'fechaplanilla' => 'Fecha Planilla',
                    'fechaultidemnizacion' => 'Fecha U.Indemnizacion',
                    'fecharetiro' => 'Fecha Retiro / Reincorporacion',                
                    'fechavacacion' => 'Fecha Vacacion',
                    'fechafincontrato' => 'Fecha Fin Contrato',
                    'eliminado' => 'Eliminado',
                    'fecha' => 'Fecha',
                    'usuario' => 'Usuario',
                    'idempleado' => 'Empleado',
                    'idtiporetiro'=>'Tipo Retiro'
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
		
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
                 }
                if ($this->fechaantiguedad != Null) {
                $criteria->addCondition("t.fechaantiguedad::date = '" . $this->fechaantiguedad. "'");
                }
                if ($this->fechaplanilla != Null) {
                        $criteria->addCondition("t.fechaplanilla::date = '" . $this->fechaplanilla. "'");
                }
                if ($this->fechaultidemnizacion != Null) {
                 $criteria->addCondition("t.fechaultidemnizacion::date = '" . $this->fechaultidemnizacion. "'");
                  }
                if ($this->fecharetiro != Null) {
                        $criteria->addCondition("t.fecharetiro::date = '" . $this->fecharetiro. "'");
                }
                $criteria->addSearchCondition('p.nombrecompleto',$this->empleado,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		$criteria->compare('t.idempleado',$this->idempleado);
                $criteria->join='right outer  JOIN  general.empleado e on e.id=t.idempleado inner join general.persona p on p.id=e.idpersona ';
        
       
            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                   'sort' => array(
                        'defaultOrder' => 'p.nombrecompleto ,t.id desc',
                        'attributes' => array(
                          'idempleado'=>array(
                              'asc'=>'p.nombrecompleto asc,t.id desc',
                              'desc'=>'p.nombrecompleto desc,t.id desc'
                          ),
                           'fechaantiguedad'=>array(
                               'asc'=>'t.fechaantiguedad asc,p.nombrecompleto asc',
                               'desc'=>'t.fechaantiguedad desc,p.nombrecompleto asc'
                           ),
                            'fechaplanilla'=>array(
                              'asc'=>'t.fechaplanilla asc,p.nombrecompleto asc',
                               'desc'=>'t.fechaplanilla desc,p.nombrecompleto asc'
                            ),
                            'fechavacacion'=>array(
                                'asc'=>'t.fechavacacion asc,p.nombrecompleto asc',
                                'desc'=>'t.fechavacacion desc,p.nombrecompleto asc'
                            ),
                            'fechaultidemnizacion'=>array(
                                'asc'=>'t.fechaultidemnizacion asc,p.nombrecompleto asc',
                                'desc'=>'t.fechaultidemnizacion desc,p.nombrecompleto asc'
                                
                            ),
                            'fecharetiro'=>array(
                                'asc'=>'t.fecharetiro asc,p.nombrecompleto asc',
                                'desc'=>'t.fecharetiro desc,p.nombrecompleto asc'
                            ),
                            'activo'=>array(
                                'asc'=>'t.activo asc,p.nombrecompleto asc',
                                'desc'=>'t.activo desc ,p.nombrecompleto asc'
                            ),
                            'usuario'=>array(
                                'asc'=>'t.usuario asc,p.nombrecompleto asc',
                                'desc'=>'t.usuario desc,p.nombrecompleto asc'
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
     * @return Historialestadoempleado the static model class
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
		$this->fecha= new CDbExpression('NOW()');
		$this->usuario= Yii::app()->user->getName();
        return parent::beforeSave();            
    }
    /**
     * 
     * @param interge $id, id del historia estado empleado
     * @return boolean, true = se va amostrar el boton en el administrado, false = No se va a mostrar el boton en el administrador
     */
    public function MostrarAfiliacion($id) {
        $id = SeguridadModule::dec($id);
        $model=Historialestadoempleado::model()->findByPk($id);
        if($model->activo==1){
            return true;
        }else{
            return false;
        }
		
    }
    /**
     * 
     * @param integer $id, id del historial estado empleado
     * @return boolean, true= si se va a mostrar en el administador , flase No se va a mostrar en el adminstrador
     */
     public function MostrarEdicion($id) {
        $id = SeguridadModule::dec($id);
        $model=Historialestadoempleado::model()->findByPk($id);
         $mostrar= Yii::app()->rrhh->createCommand('select count(*) from general.historialestadoempleado where eliminado=false and idempleado= '.$model->idempleado.' and id> '.$id)->queryScalar();
      
        if($mostrar==0 && $model->activo==1){
            return true;
        }else{
            return false;
        }
		
    }

   

}
