<?php
/*
 * Historialbancohoras.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 02/10/2020
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
 
 * This is the model class for table "general.historialbancohoras".
 *
 * The followings are the available columns in table 'general.historialbancohoras':
 * @property integer $id
 * @property integer $canthoras
 * @property boolean $essaldo
 * @property string $descripcion
 * @property integer $multiplo
 * @property integer $idempleado
 * @property integer $identradasalida
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 * @property integer $canthorasfavor
 * @property integer $canthorascontra
 * @property string $fechadesde
 * @property string $fechahasta
 * @property string $horainicio
 * @property string $horafin
 * @property string $fechacierre
 *
 * The followings are the available model relations:
 * @property Empleado $idempleado
 */
class Historialbancohoras extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $empleado,$hi,$mi,$hs,$ms,$mostrar,$canthoras,$jornada,$observacion;
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
            return 'general.historialbancohoras';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array(' multiplo, idempleado, identradasalida', 'numerical', 'integerOnly'=>true),
                    array('usuario', 'length', 'max'=>30),
                    array('horainicio, horafin', 'length', 'max'=>5),
                    array('essaldo, descripcion, fecha, eliminado,fechahasta, fechadesde,fechasolicitud, fechacierre,tipo', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id,  essaldo, descripcion, multiplo,empleado, idempleado,fechasolicitud, identradasalida, usuario, fecha, eliminado, cantminfavor, cantmincontra, fechadesde, fechahasta, horainicio, horafin, fechacierre,tipo', 'safe', 'on'=>'search'),
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
                    'essaldo' => 'Essaldo',
                    'descripcion' => 'Descripcion',
                    'multiplo' => 'Multiplo',
                    'idempleado' => 'Empleado',
                    'identradasalida' => 'Identradasalida',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'cantminfavor' => 'Min. a Favor',
                    'cantmincontra' => 'Min. en Contra',
                    'fechadesde' => 'Desde',
                    'fechahasta' => 'Hasta',
                    'horainicio' => 'Horainicio',
                    'horafin' => 'Horafin',
                    'fechacierre' => 'Fechacierre',
                    'fechasolicitud'=>'Fecha Solicitud'
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
		$criteria->addSearchCondition('t.descripcion',$this->descripcion,true,'AND','ILIKE');
		$criteria->compare('t.multiplo',$this->multiplo);
                $criteria->join = "right outer  JOIN  (select id from general.historialbancohoras where identradasalida is null and eliminado=false and fechacierre is null and fechadesde is not null ) r ON r.id= t.id right outer  JOIN general.empleado  e on e.id=t.idempleado right outer  JOIN general.persona p on p.id=e.idpersona right outer join general.seguimientoempleado se on se.idempleado=e.id  right outer JOIN ftbl_usuario_web_cruge_user cu  on cu.iduser=se.idcrugeuser";
                $criteria->addCondition("cu.username = '".Yii::app()->user->getName()."'");
                $criteria->addCondition("se.eliminado::boolean =false::boolean");
                $criteria->select ='t.*';
                $criteria->addSearchCondition('p.nombrecompleto',$this->empleado,true,'AND','ILIKE');
                $criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
                    $criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->compare('t.cantminfavor',$this->cantminfavor);
		$criteria->compare('t.cantmincontra',$this->cantmincontra);
		$criteria->addSearchCondition('t.fechadesde',$this->fechadesde,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.fechahasta',$this->fechahasta,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.horainicio',$this->horainicio,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.horafin',$this->horafin,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.fechacierre',$this->fechacierre,true,'AND','ILIKE');
 
            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                  'sort' => array(
                        'defaultOrder' => 't.fechadesde desc,t.fechahasta desc,t.horainicio desc,t.horafin desc,p.nombrecompleto ASC',                      
                        'attributes' => array(
                            'idempleado'=>array(
                                'asc'=>'p.nombrecompleto asc ,t.fechadesde,t.fechahasta,t.horainicio,t.horafin  asc',
                                'desc'=>'p.nombrecompleto desc ,t.fechadesde,t.fechahasta,t.horainicio,t.horafin  asc'
                            ),
                            'fechadesde'=>array(
                                'asc'=>'t.fechadesde asc, p.nombrecompleto , t.fechahasta, t.horainicio,t.horafin asc ',
                                'desc'=>'t.fechadesde desc, p.nombrecompleto , t.fechahasta, t.horainicio,t.horafin asc'
                            ),
                            'fechahasta'=>array(
                                'asc'=>'t.fechahasta asc, p.nombrecompleto , t.fechadesde, t.horainicio,t.horafin asc ',
                                'desc'=>'t.fechahasta desc, p.nombrecompleto , t.fechadesde, t.horainicio,t.horafin asc'
                            ),
                            'horainicio'=>array(
                                'asc'=>'t.horainicio asc, p.nombrecompleto , t.fechadesde, t.fechahasta,t.horafin asc ',
                                'desc'=>'t.horainicio desc, p.nombrecompleto , t.fechadesde, t.fechahasta,t.horafin asc'
                            ),
                            'cantminfavor'=>array(
                                'asc'=>'t.cantminfavor asc, p.nombrecompleto , t.fechadesde, t.fechahasta,t.horainicio ,t.horafin asc ',
                                'desc'=>'t.cantminfavor desc, p.nombrecompleto , t.fechadesde, t.fechahasta,t.horainicio,t.horafin asc'
                            ),
                            'cantmincontra'=>array(
                                'asc'=>'t.cantmincontra asc, p.nombrecompleto , t.fechadesde, t.fechahasta,t.horainicio ,t.horafin asc ',
                                'desc'=>'t.cantmincontra desc, p.nombrecompleto , t.fechadesde, t.fechahasta,t.horainicio,t.horafin asc'
                            ), 
                            'descripcion'=>array(
                                'asc'=>'t.descripcion asc, p.nombrecompleto , t.fechadesde, t.fechahasta,t.horainicio ,t.horafin asc ',
                                'desc'=>'t.descripcion desc, p.nombrecompleto , t.fechadesde, t.fechahasta,t.horainicio,t.horafin asc'
                            ),
                            'usuario'=>array(
                                'asc'=>'t.usuario asc, p.nombrecompleto , t.fechadesde, t.fechahasta,t.horainicio ,t.horafin asc ',
                                'desc'=>'t.usuario desc, p.nombrecompleto , t.fechadesde, t.fechahasta,t.horainicio,t.horafin asc'
                            ),
                            
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
     * @return Historialbancohoras the static model class
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
		$this->descripcion=strtoupper($this->descripcion);
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
		$this->horainicio=strtoupper($this->horainicio);
		$this->horafin=strtoupper($this->horafin);
        return parent::beforeSave();            
    }
    /**
     * 
     * @param integer $idempleado, id del empleado
     * @param date $fechadesde, fecha desde 
     * @param date $fechahasta, fecha hasta 
     * @param date $fechasolicitud, fecha a la que se hizo la solicitud
     * @param time $horainicio, hora inicio 
     * @param time $horafin,hora fin
     * @param boolean $tipo, true= si es a nivel de hora , false= si es anivel de dia
     * @param string $observacion, descripcion del permiso a cuenta de horas
     * @return string , mensaje en caso de solapamiento
     */
    public function registrar_enbancohoras($idempleado ,$fechadesde ,$fechahasta,$fechasolicitud ,$horainicio ,$horafin ,$tipo,$observacion )
    {
          $usuario=  Yii::app()->user->getName();
         
          if ($tipo==1)
          { 
                 
                  $fechahasta=$fechadesde;
          }
          
        $resp=Yii::app()->rrhh->createCommand("select  registrar_bancohoras($idempleado,'$fechadesde'::date,'$fechahasta'::date,'$fechasolicitud'::date,'$horainicio'::varchar(5),'$horafin'::varchar(5),'$tipo'::boolean,'$observacion'::text,'$usuario') as resp")->queryAll()[0];
        return $resp['resp'];
        

    }
    /**
     * 
     * @param integer $id, id del registro en banco de horas
     * @param date $fechadesde, fecha desde 
     * @param date $fechahasta, fecha hasta 
     * @param date $fechasolicitud, fecha a la que se hizo la solicitud
     * @param time $horainicio, hora inicio 
     * @param time $horafin,hora fin
     * @param boolean $tipo, true= si es a nivel de hora , false= si es anivel de dia
     * @param string $observacion, descripcion del permiso a cuenta de horas
     * @return string , mensaje en caso de solapamiento
     */
    public function actualizar_enbancohoras($id ,$fechadesde ,$fechahasta,$fechasolicitud,$horainicio ,$horafin ,$tipo,$observacion )
    {
          $usuario=  Yii::app()->user->getName();
                   
          $resp=Yii::app()->rrhh->createCommand("select  actualizar_bancohoras($id,'$fechadesde'::date,'$fechahasta'::date,'$fechasolicitud'::date,'$horainicio'::varchar(5),'$horafin'::varchar(5),'$tipo'::boolean,'$observacion'::text,'$usuario') as resp")->queryAll()[0];
        return $resp['resp'];
        

    }
    /**
     * 
     * @param date $fecha, fecha de registro
     * @param string $descripcion, descripcion de saldo
     * @param integer[,]$lista, id de los empleado y la cantidad de horas
     * @return boolean
     */
    public function registrarSaldoHistorialBancoHoras($fecha,$descripcion, $lista)
    {
        $usuario=  Yii::app()->user->getName();
        $cant=count($lista);
        $ok=true;
        for($i=1;$i<=$cant;$i++){
                if ($lista[$i]['id']!='')
                Yii::app()->rrhh->createCommand("select  registrar_horasfavor_bancohoras(".$lista[$i]['id'].",".$lista[$i]['horas'].",'$fecha'::date,'$descripcion'::text,'$usuario'::varchar(30)) ")->execute();
       
        }
        return $ok;
    }
    /**
     * 
     * @return string, en caso de no poder eliminar el permiso a cuenta de banco de hora
     */
  protected function beforeSafeDelete() {
        $usuario= Yii::app()->user->getName();
        $id=$this->id;             
        $fechaplanilla=Yii::app()->rrhh
            ->createCommand("select fechahasta from planilla where eliminado=false order by id desc limit 1")
            ->queryScalar(); 
        if ($fechaplanilla<$this->fechadesde) {           
            
             return  parent::beforeSafeDelete();;
        } else {
           
            echo System::messageError('El Permiso no puede borrarse porque se encuentra asociado a un Corte de Planilla ... ! ');
            return;
        }
    }
    /**
     * 
     * @param lista $lista lista de empleados a los cuales vamos a registrar en bloque a cuenta de Banco Horas
     * @param date $fecha fecha a la que registraremos el permiso
     * @param numeric $dias cantidad de dias a registrar
     * @param int $jornada nos permite saber si los registros se haran al inicio o al final de la jornada
     * @param text $observacion texto general que ira en todos los permisos
     * @return boolean
     */
    public function RegistroGrupal($lista,$fecha,$dias,$jornada,$observacion)
    { $usuario= Yii::app()->user->getName();
        $cant=count($lista);
        for ($i=1; $i <=$cant ; $i++) { 
            if ($lista[$i]['id']!=='') {
               Yii::app()->rrhh->createCommand("select registro_grupal_bhpv(".$lista[$i]['id'].",'$fecha',$dias,$jornada,upper('$observacion'),'$usuario',10,0)")->execute();
               
                
            }
        }
        return true;
    }
}
