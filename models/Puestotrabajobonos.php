<?php
/*
 * Puestotrabajobonos.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 21/10/2019
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
 
 * This is the model class for table "general.puestotrabajobonos".
 *
 * The followings are the available columns in table 'general.puestotrabajobonos':
 * @property integer $id
 * @property integer $idbonos
 * @property integer $idpuestotrabajo
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 * @property string $valor
 *
 * The followings are the available model relations:
 * @property Bonos $idbonos
 * @property Puestotrabajo $idpuestotrabajo
 */
class Puestotrabajobonos extends CActiveRecord
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
            return 'general.puestotrabajobonos';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idbonos, idpuestotrabajo', 'numerical', 'integerOnly'=>true),
                    array('usuario', 'length', 'max'=>30),
                    array('fecha, eliminado, valor', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, idbonos, idpuestotrabajo, usuario, fecha, eliminado, valor', 'safe', 'on'=>'search'),
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
                    'idbonos0' => array(self::BELONGS_TO, 'Bonos', 'idbonos'),
                    'idpuestotrabajo0' => array(self::BELONGS_TO, 'Puestotrabajo', 'idpuestotrabajo'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'idbonos' => 'Idbonos',
                    'idpuestotrabajo' => 'Idpuestotrabajo',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'valor' => 'Valor',
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
		$criteria->compare('t.idbonos',$this->idbonos);
		$criteria->compare('t.idpuestotrabajo',$this->idpuestotrabajo);
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->addSearchCondition('t.valor',$this->valor,true,'AND','ILIKE');

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
     * @return Puestotrabajobonos the static model class
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
     * @param integer $id, id del bono
     * @param boolean $estado, true= el Bono se Calcula Mediante una Funcion, false= Bono con Monto Fijo
     * @param integer[] $lista, id de los puesto de trabajo a los que se relacionara el pago del Bono
     */
    public function guardarPuestostrabajo($id,$estado,$lista)
    {
    
     $cant=count($lista);
      $pt= Puestotrabajobonos::model()->findAll('t.idbonos='.$id); 
      foreach ($pt as $p) {
          $p->eliminado=true;
          $p->save();
      }     
      for ($i=1; $i <=$cant ; $i++) { 
        if ($lista[$i]['idpuestotrabajo']!='') {          
          $pt= new Puestotrabajobonos;
          $pt->idbonos=$id;
          $pt->idpuestotrabajo=intval($lista[$i]['idpuestotrabajo']);
          
          if ($estado=='0') {
          $pt->valor = floatval($lista[$i]['valor']);
           // 
          }
          $pt->save();
        }
      }

    }
    /**
     * 
     * @param integer $idbonos, id del Bono 
     * @return \CActiveDataProvider
     */
   public function listaPuestotrabajo($idbonos)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.idbonos = ".$idbonos);
        
        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.id asc',
            )
        ));
    }
}
