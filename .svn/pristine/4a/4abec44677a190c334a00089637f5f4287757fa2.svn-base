<?php
/*
 * Dependiente.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 08/05/2019
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
 
 * This is the model class for table "general.dependiente".
 *
 * The followings are the available columns in table 'general.dependiente':
 * @property integer $id
 * @property string $ci
 * @property string $nombrec
 * @property string $fechanac
 * @property string $parentesco
 * @property boolean $discapacidad
 * @property integer $idpersona
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Persona $idpersona
 */
class Dependiente extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $deduccion,$descripcion,$fechafin;
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
            return 'general.dependiente';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idpersona,idparentesco,deduccion', 'numerical', 'integerOnly'=>true),
                    array('ci', 'length', 'max'=>20),
                    array('nombrec', 'length', 'max'=>60),
                    array('usuario', 'length', 'max'=>30),
                    array('fechanac,descripcion, discapacidad,heredero, fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, ci, nombrec, fechanacr,descripcion, deduccion, discapacidad, idpersona, usuario, fecha, eliminado', 'safe', 'on'=>'search'),
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
                    'idpersona0' => array(self::BELONGS_TO, 'Persona', 'idpersona'),
                     'idparentesco0' => array(self::BELONGS_TO, 'Parentesco', 'idparentesco'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'ci' => 'Ci',
                    'nombrec' => 'Nombrec',
                    'fechanacr' => 'Fechanac',
                    'idparentesco' => 'Parentesco',
                    'discapacidad' => 'Discapacidad',
                    'idpersona' => 'Idpersona',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'deduccion'=>'Deduccion'
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
		$criteria->addSearchCondition('t.ci',$this->ci,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.nombrec',$this->nombrec,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.fechanac',$this->fechanac,true,'AND','ILIKE');
                $criteria->compare('t.discapacidad',$this->discapacidad);
		$criteria->compare('t.idpersona',$this->idpersona);
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null)
         {
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
     * @param integer $iddeducciones, id de la deducicion
     * @param date $fechar, fecha a la que se tomara encuenta en el momento de generar las aportaciones en la planilla
     * @param date $fechafin, fecha hasta la que se considerara para la replica del registro( solo se consiera el mes  el dia ya esta dado por $fechar)
     * @param type $descripcion, descripcion de la deduccion
     * @param string[]  $lista , lista de ci de los empleados
     * @return boolean
     */
     public function registrarDeduccionesEmpleado ($iddeducciones,$fechar ,$fechafin,$descripcion,$lista)
    {
       $usuario= Yii::app()->user->getName();
        $cant=count($lista);
        for ($i=1; $i <=$cant ; $i++) { 
            if ($lista[$i]['ci']!='' &&  $lista[$i]['monto']!='0'  ) {
              Yii::app()->rrhh
            ->createCommand(" select registrar_empleado_deducciones('".$lista[$i]['ci']."',$iddeducciones ,".$lista[$i]['monto'].",'$descripcion' ,'$fechar'::date,'$fechafin'::date,'$usuario')")
            ->execute();   
            }
        }
    return true;
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
     * @return Dependiente the static model class
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
    /**
     * registra dependientes vinculado con las personas
     * @param model $persona , modelo de la tabla persona
     * @param array $dependientes, contiene la informacion de los dependientes
     */
     public function registrarDependientes($persona,$dependientes)
    {
         /*maticulaseguro,celular*/
        $cant=count($dependientes);
         for ($i=1; $i <=$cant ; $i++) { 
         if($dependientes[$i]['nombrec']!='' && $dependientes[$i]['fechanacr']!=''){
         $d=new Dependiente;
         $d->ci=$dependientes[$i]['ci'];
         $d->nombrec=$dependientes[$i]['nombrec'];
         $d->fechanacr=$dependientes[$i]['fechanacr'];
         $d->maticulaseguro=$dependientes[$i]['maticulaseguro'];
         $d->celular=$dependientes[$i]['celular'];
         $id=Parentesco::model()->dameIdParentesco($dependientes[$i]['parentesco'],$persona->sexo);
         $d->idparentesco=$id;
         $d->discapacidad=$dependientes[$i]['discapacidad'];
         $d->heredero=$dependientes[$i]['heredero'];
         $d->idpersona=$persona->id;
         if (!$d->save()) {
               print_r($d);
           }  
        }
    }
    }
    /**
     * actualiza la informcion de los dependientes
     * @param model $persona, modelo de la tabla persona
     * @param array $dependientes, informacion de los dependiente
     */
    public function actualizarDependientes($persona,$dependientes)
    {
          $cant=count($dependientes);
        $ldependiente=$persona->dependientes;
        foreach ($ldependiente as $d) {
            $d->eliminado=true;
            $d->save();
        }

        for ($i=1; $i <=$cant ; $i++) { 
          if ($dependientes[$i]['nombrec']!='' && $dependientes[$i]['fechanacr']!='') {
         $d=new Dependiente;
         $d->ci=$dependientes[$i]['ci'];
         $d->nombrec=$dependientes[$i]['nombrec'];
         $d->fechanacr=$dependientes[$i]['fechanacr'];        
         $d->discapacidad=$dependientes[$i]['discapacidad'];
         $d->maticulaseguro=$dependientes[$i]['maticulaseguro'];
         $d->celular=$dependientes[$i]['celular'];
         $d->heredero=$dependientes[$i]['heredero'];
         $id=Parentesco::model()->dameIdParentesco($dependientes[$i]['parentesco'],$persona->sexo);
          $d->idparentesco=$id;
         $d->idpersona=$persona->id;
         if (!$d->save()) {
               print_r($d);
           }  
        }
        }
    }
    /**
     * 
     * @param integer $idpersona, id de la persona
     * @return \CActiveDataProvider, retorna la informacion de los dependientes vivulado con la persona
     */
    public function listaDependiente($idpersona)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.idpersona = ".$idpersona);
        
        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.id asc',
            )
        ));
    }
    public function beforeSave() {
		$this->ci=strtoupper($this->ci);
		$this->nombrec=strtoupper($this->nombrec);
		
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }


}
