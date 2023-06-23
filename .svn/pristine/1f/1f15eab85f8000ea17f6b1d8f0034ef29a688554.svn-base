<?php
/*
 * Empleadobono.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 23/04/2019
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
 
 * This is the model class for table "general.empleadobono".
 *
 * The followings are the available columns in table 'general.empleadobono':
 * @property integer $id
 * @property integer $mes
 * @property integer $idbono
 * @property integer $idempleado
 * @property double $monto
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Empleado $idempleado
 * @property Bono $idbono
 */
class Empleadobono extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public  $ci,$estado;
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
            return 'empleadobono';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('mes, idbono, idempleado', 'numerical', 'integerOnly'=>true),
                    array('monto', 'numerical'),
                    array('usuario', 'length', 'max'=>30),
                    array('fecha, eliminado', 'safe'),
                    array('idbono,idempleado','required','on'=>array('insert','update')),

                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, mes, idbono, idempleado, monto, usuario, fecha, eliminado', 'safe', 'on'=>'search'),
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
                    'idbono' => array(self::BELONGS_TO, 'Bono', 'idbono'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'mes' => 'Mes',
                    'idbono' => 'Idbono',
                    'idempleado' => 'Idempleado',
                    'monto' => 'Monto',
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
		$criteria->compare('t.mes',$this->mes);
		$criteria->compare('t.idbono',$this->idbono);
		$criteria->compare('t.idempleado',$this->idempleado);
		$criteria->compare('t.monto',$this->monto);
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                  'sort' => array(
                        'defaultOrder' => 't.fechai,t.fechaf,t.horai,t.horaf asc',                      
                        'attributes' => array()
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
     * @return Empleadobono the static model class
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
     * Registro del Bono
     * @param integer $id, id del bono
     * @param string $usuario, el usuario que esta haciendo el registro 
     * @param  string $descripcion, descripcion de la asignacion del bono
     * @param float $monto, monto que se esta asignando
     * @param string $emplados, ci de los empleados a asignar el bono
     * @return boolean
     */
    public function registrarEmpleadoBono($id,$usuario,$descripcion,$monto,$emplados)
    {
        

        $cant=count($emplados);
        Yii::app()->rrhh->createCommand('update empleadobono set eliminado=true  where idbono='.$id)->execute();
        
         $fecha=new CDbExpression('NOW()');
        for ($i=1; $i <=$cant ; $i++) { 
            if($emplados[$i]["ci"]!==''){

            $idempleado=Yii::app()->rrhh->createCommand("select  e.id from general.empleado e inner join general.persona p on p.id=e.idpersona where p.ci||(case when p.complementoci<>'' then '-'||p.complementoci else '' end)='".$emplados[$i]["ci"]."'::text")->queryScalar();
            
            if($idempleado!==FALSE){$eb=new Empleadobono;
            $eb->idbono=$id;
            $eb->idempleado=intval( $idempleado);
            $eb->monto=floatval($emplados[$i]["monto"]);            
            $eb->fecha=$fecha;  
            $eb->usuario=$usuario;          
            
            if ($eb->save()) {
               //echo 'se guardo correctament...<br>';
            }else{
                print_r($eb);
            }}
        }
        }
        return true;
    }
/**
 * 
 * @param integer $idbono, id del bono
 * @return \CActiveDataProvider, lista de empleados vinvulados con el bono
 */
 public function listaBonoAsignado($idbono)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.idbono = ".$idbono);
        $criteria->join = "right  JOIN general.empleado e  ON e.id= t.idempleado  right  JOIN general.persona p on p.id=e.idpersona";
        $criteria->order = 'p.nombrecompleto asc';
        $criteria->select="t.*,p.ci||(case when p.complementoci<>'' then '-'||p.complementoci else '' end) as ci ,-1::int as estado";
        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.id asc',
            )
        ));
    }
}
