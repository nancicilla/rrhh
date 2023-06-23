<?php
/*
 * Vacaciones.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 18/02/2020
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
 
 * This is the model class for table "vacaciones".
 *
 * The followings are the available columns in table 'vacaciones':
 * @property integer $id
 * @property string $fechadesde
 * @property string $fechahasta
 * @property string $dias
 * @property integer $idempleado
 *
 * The followings are the available model relations:
 * @property Empleado $idempleado0
 */
class Vacaciones extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $empleado,$fechacontratacion,$fechaminima,$fechamaxima,$diasva,$hi,$hs,$mi,$ms,$hi1,$hs1,$mi1,$ms1,$jornada;
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
            return 'general.vacaciones';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idempleado,hi,hs,mi,ms', 'numerical', 'integerOnly'=>true),
                    array('fechadesde,fecha, fechahasta, dias,tipo,observacion', 'safe'),
                    array('usuario', 'length', 'max'=>30),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, fechadesde,fechahasta,fecha, fechahasta,usuario, observacion,dias,diastomados,dias,fechaav, empleado', 'safe', 'on'=>'search'),
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
     * Registro de Vacacion 
     * @param model $vacaciones, modelo relacionado con la tabla vacaciones
     * @return string, mensaje en caso de no poder hacer el registro de la Vacacion
     */
    public function registrarVacacion($vacaciones)
    {
        $hi=$vacaciones->hi;
        $hs=$vacaciones->hs;
        $mi=$vacaciones->mi;
        $ms=$vacaciones->ms; 
        if ($vacaciones->tipo=='1') {
            /// vacaciones a nivel de hora
            $vacaciones->fechahasta=$vacaciones->fechadesde;
           
        }
        $usuario= Yii::app()->user->getName();
        return Yii::app()->rrhh->createCommand("select registrar_vacacion(".$vacaciones->idempleado .",'".$vacaciones->fechadesde."'::date,'".$vacaciones->fechahasta."'::date,'".$vacaciones->fechasolicitud."'::date,'".$vacaciones->horai."'::varchar(5),'".$vacaciones->horaf."'::varchar(5),'".$vacaciones->tipo."'::boolean ,upper('".$vacaciones->observacion."'),'$usuario') as r")->queryAll()[0]['r'];  
    }
    /**
     * Registro de Saldo de Vacacion
     * @param array $lista, id de los empleados y la cantidad de saldo de vacacion
     * @return boolean
     */
    public function registrarSaldoVacacion($lista)
    { $usuario= Yii::app()->user->getName();
        $cant=count($lista);
        for ($i=1; $i <=$cant ; $i++) { 
            if ($lista[$i]['id']!=='') {
                Yii::app()->rrhh->createCommand("select registrar_saldovacacion(".$lista[$i]['id'].", ".$lista[$i]['dias'].",'$usuario')")->execute();
            }
        }
        return true;
    }
    /**
     * 
     * @param integer[] $lista, id delos empleados a los cuales se les adicionara la vacacion
     * @param date $fecha, fecha a la que se asignara la vacacion
     * @param float $dias, cantidad de dias que se le adicionara a la vacacion
     * @param string $observacion, descripcion del motivo de la adicion de la vacacion
     * @return boolean
     */
    public function adicionarVacacion($lista,$fecha,$dias,$observacion)
    { $usuario= Yii::app()->user->getName();
        $cant=count($lista);
        for ($i=1; $i <=$cant ; $i++) { 
            if ($lista[$i]['id']!=='') {
                Yii::app()->rrhh->createCommand("select registrar_adicionvacacion(".$lista[$i]['id'].",'$fecha', $dias,upper('$observacion'),'$usuario')")->execute();
            }
        }
        return true;
    }
    /**
     * Registro Grupal de Permiso a cuenta de Vacacion segun su horario
     * @param integer[] $lista, id de los empleados 
     * @param date $fecha, fecha inicio para elregistro de vacacion
     * @param float $dias, dias a tomar
     * @param integer $jornada, posibles valores 1= Tomaran al inicio de la Jornada y 2= Al final de la jornada
     * @param string $observacion, una descripcion del permiso
     * @return boolean
     */
    public function quitarVacacion($lista,$fecha,$dias,$jornada,$observacion)
    { $usuario= Yii::app()->user->getName();
        $cant=count($lista);
        for ($i=1; $i <=$cant ; $i++) { 
            if ($lista[$i]['id']!=='') {
                Yii::app()->rrhh->createCommand("select registro_grupal_bhpv(".$lista[$i]['id'].",'$fecha',$dias,$jornada,upper('$observacion'),'$usuario',13,0)")->execute();
               
            }
        }
        return true;
    }
    /**
     * Actualiza un registro de vacacion
     * @param model $vacaciones, modelo relacionado con la tabla vacaciones
     * @return type
     */
    public function actualizarVacacion($vacaciones)
    { $usuario= Yii::app()->user->getName();      
         
        if ($vacaciones->tipo=='1') {
            /// vacaciones a nivel de hora
            $hi=intval( $vacaciones->hi);
            $hs=intval($vacaciones->hs);
            $mi=intval($vacaciones->mi);
            $ms=intval($vacaciones->ms);
            if ($hi<10) {
              $hi='0'.$hi;
            }
            if ($mi<10) {
            $mi='0'.$mi;
            }
            if ($hs<10) {
              $hs='0'.$hs;
            }
            if ($ms<10) {
            $ms='0'.$ms;
            }
            $vacaciones->horai=$hi.':'.$mi;
            $vacaciones->horaf=$hs.':'.$ms;
            $vacaciones->fechahasta=$vacaciones->fechadesde;
       }

        return Yii::app()->rrhh->createCommand("select modificar_vacacion(".$vacaciones->id.",'".$vacaciones->fechadesde."'::date, '".$vacaciones->fechahasta."'::date,'".$vacaciones->horai."','".$vacaciones->horaf."','".$vacaciones->observacion."','$usuario' ) as r")->queryScalar();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'fechadesde' => 'Desde',
                    'fechahasta' => 'Hasta',
                    'dias' => 'Saldo Vacacion',
                    'idempleado' => 'Empleado',
                    'diastomados'=>'Dias Tomados',
                    'fechaav'=>'Fecha Asignacion Vacacion',
                    'observacion'=>'Detalle',
                    'horai'=>'Hora Inicial',
                    'horaf'=>'Hora Final',
                    'fechasolicitud'=>'Fecha Solicitud',
                
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
        $pfecha=   Yii::app()->rrhh
            ->createCommand("select valor as f from general.configuracion where id=26")
            ->queryScalar();       
           
        $criteria->addCondition("t.fechadesde::date > '$pfecha' ");
        $criteria->addCondition("t.essaldo=false ");
          if ($this->diastomados!=Null && floatval($this->diastomados)>0 ) {
             $criteria->addSearchCondition('t.diastomados::text',$this->diastomados,true,'AND','ILIKE');              
         }
        if ($this->dias!=Null &&  floatval($this->dias)>-1) {
              $criteria->addSearchCondition('t.dias::text',$this->dias,true,'AND','ILIKE');              
         }
          if ($this->fechaav!=Null) {
              $criteria->addCondition("t.fechaav::date = '" . $this->fechaav. "'");             
         }
         
        $criteria->addCondition("t.essaldo=false "); 
        //$criteria->addCondition("t.diasabono=0 ");   
        $criteria->compare('t.idempleado',$this->idempleado);
        $criteria->join ='right outer  JOIN general.empleado e on e.id=t.idempleado right outer  JOIN general.persona p on p.id=e.idpersona right outer join general.seguimientoempleado se on se.idempleado=e.id  right outer JOIN ftbl_usuario_web_cruge_user cu  on cu.iduser=se.idcrugeuser';
        $criteria->addCondition("cu.username = '".Yii::app()->user->getName()."'");
        $criteria->addCondition("se.eliminado::boolean =false::boolean");
        $criteria->addSearchCondition('p.nombrecompleto',$this->empleado,true,'AND','ILIKE');     
        $criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
         if ($this->fecha != Null) {
        $criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
         }
           if ($this->fechadesde != Null) {
        $criteria->addCondition("t.fechadesde::date = '" . $this->fechadesde. "'");
         }
           if ($this->fechahasta != Null) {
        $criteria->addCondition("t.fechahasta::date = '" . $this->fechahasta. "'");
         }

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                  'sort' => array(
                        'defaultOrder' => 't.fechadesde desc,t.fechahasta desc,t.horai desc,t.horaf desc,nombrecompleto asc',                      
                        'attributes' => array(
                            'idempleado'=>array(
                                'asc'=>'p.nombrecompleto asc,t.fechadesde, t.fechahasta,t.horai,t.horaf asc',
                                'desc'=>'p.nombrecompleto desc,t.fechadesde, t.fechahasta,t.horai,t.horaf asc'
                            ),
                            'fechadesde'=>array(
                                'asc'=>'t.fechadesde asc,p.nombrecompleto , t.fechahasta,t.horai,t.horaf asc',
                                'desc'=>'t.fechadesde desc,p.nombrecompleto , t.fechahasta,t.horai,t.horaf asc'
                            ),
                            'fechahasta'=>array(
                                'asc'=>'t.fechahasta asc,p.nombrecompleto , t.fechadesde,t.horai,t.horaf asc',
                                'desc'=>'t.fechahasta desc,p.nombrecompleto , t.fechadesde,t.horai,t.horaf asc'
                            ),
                            'diastomados'=>array(
                                'asc'=>'t.diastomados asc,p.nombrecompleto , t.fechadesde,t.fechahasta,t.horai,t.horaf asc',
                                'desc'=>'t.diastomados desc,p.nombrecompleto , t.fechadesde,t.fechahasta,t.horai,t.horaf asc'
                            ),
                            'fechaav'=>array(
                                'asc'=>'t.fechaav asc,p.nombrecompleto , t.fechadesde,t.fechahasta,t.horai,t.horaf asc',
                                'desc'=>'t.fechaav desc,p.nombrecompleto , t.fechadesde,t.fechahasta,t.horai,t.horaf asc'
                            ),
                            'dias'=>array(
                                'asc'=>'t.dias asc,p.nombrecompleto , t.fechadesde,t.fechahasta,t.horai,t.horaf asc',
                                'desc'=>'t.dias desc,p.nombrecompleto , t.fechadesde,t.fechahasta,t.horai,t.horaf asc'
                            ),
                            'usuario'=>array(
                                'asc'=>'t.usuario asc,p.nombrecompleto , t.fechadesde,t.fechahasta,t.horai,t.horaf asc',
                                'desc'=>'t.usuario desc,p.nombrecompleto , t.fechadesde,t.fechahasta,t.horai,t.horaf asc'
                            ),
                            'fecha'=>array(
                                'asc'=>'t.fecha asc,p.nombrecompleto , t.fechadesde,t.fechahasta,t.horai,t.horaf asc',
                                'desc'=>'t.fecha desc,p.nombrecompleto , t.fechadesde,t.fechahasta,t.horai,t.horaf asc'
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
     * @return Vacaciones the static model class
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
        $this->obervacion=strtoupper($this->observacion);
        return parent::beforeSave();            
    }
    /**
     * 
     * @return string ,mensaje en caso de no poder eliminar el Registro de Vacacion 
     */
     protected function beforeSafeDelete() {
        $usuario= Yii::app()->user->getName();
        $id=$this->id;     
        $model=Vacaciones::model()->findByPk($id);
        $respuesta=Yii::app()->rrhh
            ->createCommand("select borrar_vacacion($id,'$usuario') as r")
            ->queryScalar(); 
        $fechaplanilla=Yii::app()->rrhh
            ->createCommand("select fechahasta from planilla where eliminado=false order by id desc limit 1")
            ->queryScalar(); 
        if ($respuesta) {
            
            return parent::beforeSafeDelete();
        } else {
            if($model->diasgestionactual!=0){
               echo System::messageError('La  Vacacion no puede borrarse porque es una asignacion de dias por antiguedad... ! ');
            
            }
            elseif ($fechaplanilla>= $model->fechadesde) {
               echo System::messageError('La  Vacacion no puede borrarse porque se encuentra dentro de un Corte de Planilla ... ! ');
               
            
        }
            else
            echo System::messageError('La  Vacacion no puede borrarse porque se encuentra asociada a un finiquito ... ! ');
            return;
        }
    }
    public function ActualizarAbono($idvacacion,$diasabono,$observacion) {
        $usuario= Yii::app()->user->getName();
        Yii::app()->rrhh
            ->createCommand("select actualizar_diasabono($idvacacion,$diasabono,'$observacion','$usuario') ")
            ->execute(); 
    }


}
