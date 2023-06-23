<?php
/*
 * Cuerpohorario.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 21/02/2020
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
 
 * This is the model class for table "general.cuerpohorario".
 *
 * The followings are the available columns in table 'general.cuerpohorario':
 * @property integer $id
 * @property integer $idrangohora
 * @property integer $idhorario
 * @property integer $iddia
 * @property integer $iddiad
 * @property boolean $estado
 * @property string $fechaiseq
 * @property string $mindescanso
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Rangohora $idrangohora
 * @property Horario $idhorario
 * @property Dia $iddia
 * @property Dia $iddiad
 */
class Cuerpohorario extends CActiveRecord
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
            return 'general.cuerpohorario';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idrangohora, idhorario, iddia, iddiad', 'numerical', 'integerOnly'=>true),
                    array('usuario', 'length', 'max'=>30),
                    array('estado, fechaiseq, mindescanso, fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, idrangohora, idhorario, iddia, iddiad, estado, fechaiseq, mindescanso, usuario, fecha, eliminado', 'safe', 'on'=>'search'),
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
                    'idrangohora0' => array(self::BELONGS_TO, 'Rangohora', 'idrangohora'),
                    'idhorario0' => array(self::BELONGS_TO, 'Horario', 'idhorario'),
                    'iddia0' => array(self::BELONGS_TO, 'Dia', 'iddia'),
                    'iddiad0' => array(self::BELONGS_TO, 'Dia', 'iddiad'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'idrangohora' => 'Idrangohora',
                    'idhorario' => 'Idhorario',
                    'iddia' => 'Iddia',
                    'iddiad' => 'Iddiad',
                    'estado' => 'Estado',
                    'fechaiseq' => 'Fechaiseq',
                    'mindescanso' => 'Mindescanso',
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
		$criteria->compare('t.idrangohora',$this->idrangohora);
		$criteria->compare('t.idhorario',$this->idhorario);
		$criteria->compare('t.iddia',$this->iddia);
		$criteria->compare('t.iddiad',$this->iddiad);
		$criteria->compare('t.estado',$this->estado);
		$criteria->addSearchCondition('t.fechaiseq',$this->fechaiseq,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.mindescanso',$this->mindescanso,true,'AND','ILIKE');
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
     * 
     * @param integer $idhorario , id del horario
     * @return \CActiveDataProvider ,informacion del cuerpo de horario
     */
  public function listaHorarios($idhorario)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.idhorario = ".$idhorario);
        
        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.id asc',
            )
        ));
    }
    /**
     *  regitra informacion en el cuerpo del horario 
     * @param integer $idhorario, id del horario
     * @param array $horastrabajo, informacion del dia_desde , dia_hasta , rango de horas y si es con intercalacion de semana
     */
      public function registrarListaHorario($idhorario,$horastrabajo)
  {
      $cant=count($horastrabajo);    
     
      for ($i=1; $i <=$cant ; $i++) { 
        if ($horastrabajo[$i]['idrangohora']!='') {          
          $horario= new Cuerpohorario;
          $horario->idhorario=$idhorario;
          $horario->idrangohora=intval($horastrabajo[$i]['idrangohora']);
          $horario->iddia=intval($horastrabajo[$i]['iddia']);
          $horario->iddiad=intval($horastrabajo[$i]['iddiad']);
          $horario->estado=intval($horastrabajo[$i]['estado']);
          $horario->mindescanso=intval($horastrabajo[$i]['mindescanso']);
          if ($horastrabajo[$i]['estado']=='1') {
          $fecha = strtotime($horastrabajo[$i]['fechaiseq']);
            $horario->fechaiseq=date('Y-m-d',$fecha );
          }
          $horario->save();
        }
      }

      
    
     

      
  }
/**
 * actualiza la informcion del cuerpo del horario
 * @param modelo $horario, informacion de la tabla horario
 * @param array $horastrabajo, con la informacion del cuerpo de horario
 */
  public function actualizarListaHorario($horario,$horastrabajo)
{
      $cant=count($horastrabajo);
    
      $horariosmp=$horario->cuerpohorarios;
      
      foreach ($horariosmp as $h) {
          $h->eliminado=true;
          $h->save();
      }      
      for ($i=1; $i <=$cant ; $i++) { 
            if ($horastrabajo[$i]['idrangohora']!='') {
          $chorario= new Cuerpohorario;
          $chorario->idhorario=$horario->id;
          $chorario->idrangohora=intval($horastrabajo[$i]['idrangohora']);
          $chorario->iddia=intval($horastrabajo[$i]['iddia']);
          $chorario->iddiad=intval($horastrabajo[$i]['iddiad']);
          $chorario->estado=intval($horastrabajo[$i]['estado']);
           $chorario->mindescanso=intval($horastrabajo[$i]['mindescanso']);
          if ($horastrabajo[$i]['estado']=='1') {
            $fecha = strtotime($horastrabajo[$i]['fechaiseq']);


            $chorario->fechaiseq=date('Y-m-d',$fecha );
          }

          $chorario->save();
        }

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
     * @return Cuerpohorario the static model class
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


}
