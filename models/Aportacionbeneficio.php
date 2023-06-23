<?php
/*
 * Aportacionbeneficio.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 17/06/2019
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
 
 * This is the model class for table "general.aportacionbeneficio".
 *
 * The followings are the available columns in table 'general.aportacionbeneficio':
 * @property integer $id
 * @property string $nombre
 * @property string $nombref
 * @property string $nombrefaportacion
 * @property string $porcentaje
 * @property boolean $aplica
 * @property string $descripcion
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 * @property integer $tipo
 * @property boolean $estado
 *
 * The followings are the available model relations:
 * @property Aporbetipocont[] $aporbetipoconts
 */
class Aportacionbeneficio extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public$cuenta,$mes;
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
            return 'general.aportacionbeneficio';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('tipo', 'numerical', 'integerOnly'=>true),
                    array('nombre, nombref, usuario', 'length', 'max'=>100),
                    array('nombrefaportacion, porcentaje', 'length', 'max'=>100),
                    array(' descripcion, fecha, eliminado, estado,esagrupador', 'safe'),
                    array('tipo,nombre,porcentaje,enplanilla,esagrupador,descripcion,orden','required','on'=>array('update')),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, nombre, nombref, nombrefaportacion, porcentaje,esagrupador,idaportacionbeneficiopadre, descripcion, usuario, fecha, eliminado,idcuenta,cuenta, tipo, estado', 'safe', 'on'=>'search'),
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
                    'idaportacionbeneficiopadre0' => array(self::BELONGS_TO, 'Aportacionbeneficio', 'idaportacionbeneficiopadre'),
                    'aporbetipoconts' => array(self::HAS_MANY, 'Aporbetipocont', 'idaportacionbeneficio'),
                     'aportacionbeneficioareas' => array(self::HAS_MANY, 'Aportacionbeneficioarea', 'idaportacionbeneficio'),
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
                    'nombref' => 'Nombref',
                    'esagrupador'=>'Es Agrupador',
                    'nombrefaportacion' => 'Nombrefaportacion',
                    'porcentaje' => 'Porcentaje',
                    'enplanilla' => 'Se Genera en',
                    'descripcion' => 'Descripción',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'tipo' => 'Tipo',
                    'estado' => 'Estado',
                    'idaportacionbeneficiopadre'=>'Agrupado en...'
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
		$criteria->addSearchCondition('t.nombref',$this->nombref,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.nombrefaportacion',$this->nombrefaportacion,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.porcentaje',$this->porcentaje,true,'AND','ILIKE');	
		$criteria->addSearchCondition('t.descripcion',$this->descripcion,true,'AND','ILIKE');		
		$criteria->compare('t.esagrupador',$this->esagrupador);
		$criteria->compare('t.estado',$this->estado);
                $criteria->select=array("t.id,t.nombre,t.estado,t.esagrupador,t.idaportacionbeneficiopadre,t.porcentaje,case when t.enplanilla=true then 'Planilla General' else   case when t.tipo=1 then 'Planilla General' else 'Planilla Individual' end  end AS enplanilla ,case t.tipo when 1 then 'VACACIÓN' when 2 then 'BONO' when 3 then 'APORTE IMPOSITIVO' else 'APORTE CONSENSUADO'end as tipo,t.descripcion");


            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                    'sort' => array(
                        'defaultOrder' => 't.nombre asc',      
                       )
            ));
    }
    /**
     * 
     * @return lista de areas asociadas a la aportacion o beneficio
     */
    public function dameAreas()
    {
        if ($this->aportacionbeneficioareas!=null) {
            return Aportacionbeneficioarea::model()->listaAreas($this->id);
        }else{
         return array();
        }
        
       
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
     * @return Aportacionbeneficio the static model class
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
		$this->nombref=strtoupper($this->nombref);
		$this->porcentaje=strtoupper($this->porcentaje);
		$this->descripcion=strtoupper($this->descripcion);
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }


}
