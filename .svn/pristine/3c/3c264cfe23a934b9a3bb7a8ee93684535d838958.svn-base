<?php
/*
 * Deducciones.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 27/10/2019
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
 
 * This is the model class for table "general.deducciones".
 *
 * The followings are the available columns in table 'general.deducciones':
 * @property integer $id
 * @property string $nombre
 * @property string $nombref
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 * @property boolean $mensual
 * @property string $valor
 */
class Deducciones extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $ci,$total,$cuenta,$estilo;
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
            return 'general.deducciones';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('nombref', 'length', 'max'=>60),
                    array('usuario', 'length', 'max'=>30),

               array('iddeduccionpadre', 'numerical', 'integerOnly' => true),
                    array('nombre,esagrupador, porfucion,fecha,idcuenta,cuenta, eliminado', 'safe'),
                     array('nombre,porfucion,esagrupador,mostrardetallado,estado', 'required', 'on' => array('insert', 'update')),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, nombre,  usuario,cuenta,idcuenta,esagrupador, fecha, eliminado', 'safe', 'on'=>'search'),
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
                    'iddeduccionpadre0' => array(self::BELONGS_TO, 'Deducciones', 'iddeduccionpadre'),
                    'deduccionesareas' => array(self::HAS_MANY, 'Deduccionesarea', 'iddeduccion'),
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
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'mensual' => 'Mensual',
                    'valor' => 'Valor',
                    'iddeduccionpadre' => 'Agrupado en ...',
                    'ci'=>'C.I.',
                     'idcuenta'=>'Cuenta',
                    'total'=>'Total',
                    'esagrupador'=>'Es Agrupador?'
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
            $criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
             if ($this->fecha != Null) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
             }
             if ($this->cuenta!=null) {
             $criteria->addCondition("t.idcuenta in ( select id from  ftbl_moodle_cuenta where nombre like'%".strtoupper($this->cuenta)."%' or REPLACE (numero, '.', '') like'".strtoupper($this->cuenta)."%' )");
            }		
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
     * @return Deducciones the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
   public function registrarTmpPulperia($lista)
   {
       $cant=count($lista);
       for ($i=1; $i <=$cant ; $i++) { 
           $tmpp=new Tmppulperia;
           $tmpp->ci= intval( $lista[$i]['ci']);
           $tmpp->monto= floatval($lista[$i]['total']);
           $tmpp->save();
       }
       return Yii::app()->rrhh
            ->createCommand("select  registrar_pulperia()")
            ->execute();
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
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }
    /**
     * 
     * @return lista de areas asociadas a la aportacion o beneficio
     */
    public function dameAreas()
    {
       
            return Deduccionesarea::model()->listaAreas($this->id);
        
        
       
    }


}
