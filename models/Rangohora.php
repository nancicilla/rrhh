<?php
/*
 * Rangohora.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 04/04/2019
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
 
 * This is the model class for table "general.rangohora".
 *
 * The followings are the available columns in table 'general.rangohora':
 * @property integer $id
 * @property string $turno
 * @property string $horai
 * @property string $horas
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 */
class Rangohora extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $hi=7;
    public $mi=0;
    public   $hs=11;
    public $ms=0;
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
            return 'general.rangohora';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('turno', 'length', 'max'=>60),
                    array('horai, horas', 'length', 'max'=>5),
                    array('usuario', 'length', 'max'=>30),
                    array('fecha, eliminado', 'safe'),
                    array('controlarentrada,controlarsalida', 'required', 'on' => array('insert', 'update')),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, turno, horai, horas, usuario, fecha, eliminado', 'safe', 'on'=>'search'),
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
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'turno' => 'Turno',
                    'horai' => 'Hora Entrada',
                    'horas' => 'Hora Salida',
                    'controlarsalida'=>'Controlar Salida?',
                    'controlarentrada'=>'Controlar Entrada?',
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
		$criteria->addSearchCondition('t.turno',$this->turno,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.horai',$this->horai,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.horas',$this->horas,true,'AND','ILIKE');
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
                        'defaultOrder' => 't.horai,t.horas,t.turno asc', )
            ));
    }
    /**
     * 
     * @param time $hi, hora inicio del turno
     * @param time $hs, hora fin del turno
     * @param boolean $controlarentrada, si se va o no a controlar la hora de entrada del turno
     * @param boolean $controlarsalida,si se va o no a controlar la hora de salida del turno
     * @return boolean, true = si Ya extiste ese turno, false=Noexiste ese turno
     */
    public function validar($hi,$hs,$controlarentrada,$controlarsalida)
    {
        return  
            Yii::app()->rrhh
            ->createCommand("select validar_intervalohora('$hi','$hs','$controlarentrada'::boolean,'$controlarsalida'::boolean) as ver ")
            ->queryScalar();
    }
    /**
     * 
     * @param integer $id, id relacionado con el turno
     * @param time $hi, hora iicio del turno
     * @param time $hs, hora fin del turno
     * @param boolean $controlarentrada,si se va o no a controlar la hora de entrada del turno
     * @param boolean $controlarsalida,si se va o no a controlar la hora de salida del turno
     * @return boolean, true= si se puede Actualiza con esos valores, false= No se puede Actualizar con esos Valores 
     */
    public function validarupdate($id, $hi,$hs,$controlarentrada,$controlarsalida)
    {
        return  
            Yii::app()->rrhh
            ->createCommand("select validar_intervalohoraupdate($id,'$hi','$hs','$controlarentrada'::boolean,'$controlarsalida'::boolean) as ver ")
            ->queryScalar();
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
     * @return Rangohora the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    /**
     * 
     * @param string $nombre, horas o parte de las horas inicio fin del turno
     * @return \CActiveDataProvider
     */
    public function filtraHora($nombre)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("concat(t.horai,'-',t.horas) ilike '%".$nombre."%'");
        $criteria->order=' t.horai,t.horas asc';
        $criteria->select=array("id","concat(horai,'-',horas,' (',case when controlarentrada=true and controlarsalida=true then 'E/S' when controlarentrada=true then'E' else 'S'end,')') as horai"); 
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
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
		$this->turno=strtoupper($this->turno);
		$this->horai=strtoupper($this->horai);
		$this->horas=strtoupper($this->horas);
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }
    /**
     * 
     * @return boolean, true= si el turno esta relacionado con un horario,false = si No lo esta
     */
    public function tieneHorario() {
        $retorno = 0;

        if ($this->id != "") {
            $retorno = Cuerpohorario::model()->exists('idrangohora=' . $this->id);
        }
        return $retorno;
    }

    /**
     * Sentencias antes de ejecutar metodo delete
     * @return CActiveRecord con la tupla a eliminarse
     */
    protected function beforeSafeDelete() {
        if ($this->tieneHorario()) {
            echo System::messageError('El Intervalo de Hora  no puede ser eliminada ,hay Horarios que hacen referencia a este Intervalo de hora');
            return;
        } else {
            return parent::beforeSafeDelete();
        }
    }


}
