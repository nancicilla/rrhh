<?php
/*
 * Entradasalida.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 01/08/2019
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
 
 * This is the model class for table "general.entradasalida".
 *
 * The followings are the available columns in table 'general.entradasalida':
 * @property integer $id
 * @property integer $idempleado
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 * @property string $hmin
 * @property integer $autorizado
 * @property string $es
 * @property boolean $estado
 * @property integer $idtipo
 *
 * The followings are the available model relations:
 * @property Empleado $idempleado
 * @property Tipo $idtipo
 */
class Entradasalida extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $mostrartodo;
    public $empleado;
    public $intervalo,$ci,$horainfo,$minutoinfo,$minutos,$fechaparametro,$hi,$mi,$fechadesde,$fechahasta,$fechamin,$area,$cargo,$tipoobservacion,$horaasistida,$minsalida,$minatraso,$horaextra,$mostrarfalta,$horastrabajadas,$evento,$tipoevento,$cambiara,$seccion,$intervaloini,$intervalofin,$tipocontrato;
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
            return 'entradasalida';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
    
            return array(
                    array('idempleado, idtipoentrada,idtiposalida,hminentrada,hminsalida', 'numerical', 'integerOnly'=>true),
                    array('usuario', 'length', 'max'=>30),                  
                    array('fecha,fechaparametro, eliminado, entrada,salida,tipocontrato', 'safe'),
                    array('fechaparametro, idempleado,hi,mi', 'required', 'on' => array('insert')),
                    array(' idempleado', 'required', 'on' => array('update')),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, empleado, usuario, fecha,fechahasta, eliminado,entrada,salida,tipocontrato', 'safe', 'on'=>'search'),
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
                    'idempleado' => 'Empleado',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'entrada' => 'Entrada',
                    'salida' => 'Salida',
                    'fechadesde'=>'Desde',
                    'fechahasta'=>'Hasta',
                    'horastrabajadas'=>'Horas Trabajadas'
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
        
        $criteria->join = "right outer  JOIN  general.empleado e on e.id=t.idempleado right outer  JOIN general.persona p on p.id=e.idpersona ";
         $criteria->addCondition("e.eliminado=false");
        if ($this->fecha != Null && $this->fechahasta != Null) {
             
	  $criteria->addCondition("t.fecha::date between '" . $this->fecha. "'::date and '".$this->fechahasta."'::date");
         }
         if ($this->empleado!='') {
             $criteria->addCondition("p.nombrecompleto like'%".strtoupper($this->empleado)."%'");        
         }
        $criteria->select='t.* ,p.nombrecompleto';       
        return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                 'sort' => array(
                        'defaultOrder' => 't.fecha desc,t.id desc ', 
                     'attributes' => array(
                            'idempleado'=>array(
                                'asc'=>'p.nombrecompleto asc,t.id desc',
                                'desc'=> 'p.nombrecompleto desc,t.id desc'                       
                                
                            ),
                         'fecha'=>array(
                             'asc'=>'t.fecha asc,t.id desc',
                             'desc'=>'t.fecha desc,t.id desc'
                         ),
                         'entrada'=>array(
                             'asc'=>'t.entrada asc',
                             'desc'=>'t.entrada desc'
                         ),
                         'salida'=>array(
                             'asc'=>'t.salida asc',
                             'desc'=>'t.salida desc'
                         )
                     ))
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
     * @return Entradasalida the static model class
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
		// $this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }
    /**
     * 
     * @param date $fecha, fecha seleccionada
     * @param integer $hora, valor de la la hora en formato de 24, del 0 a 23
     * @param integer $minm, minutos de 0 a 59
     * @param integer $idempleado, id del empleado
     * @return string, cadena vacia si e caso no se pudo registrar la sellada manual  caso contrario muestra el mensaje explicando el motivo por el cual no se registro la sellada manual
     */
    public function registrarEntradaSalida($fecha,$hora,$min,$idempleado)
    {
          $usuario=Yii::app()->user->getName(); 
         $respuesta= Yii::app()->rrhh
            ->createCommand("select validar_horario_fecha($idempleado,'$fecha') as r ")
            ->queryScalar();
         
            if ($respuesta=='') {
                    $ci= Yii::app()->rrhh
                    ->createCommand("select p.ci::int from general.persona p inner join general.empleado e on e.idpersona=p.id  where e.id=$idempleado")
                    ->queryScalar();
                     $minentreselladas= Yii::app()->rrhh
                    ->createCommand("select valor from general.configuracion where id=10")
                    ->queryScalar();
                     $respuesta= Yii::app()->rrhh
            ->createCommand("select case when( select count(*) from public.entradasalida where eliminado=false and idempleado=$idempleado and fecha='$fecha'::date and ((  entrada is not null and   '$hora:$min'::time  between entrada-(''''||$minentreselladas||''' min')::interval and entrada+(''''||$minentreselladas||''' min')::interval )  or ( salida is not null and  '$hora:$min'::time between salida-(''''||$minentreselladas||''' min')::interval and salida+(''''||$minentreselladas||''' min')::interval )))=0 then ''::text else 'La Sellada No fue registrada, debe haber un intervalo de $minentreselladas min. entre selladas '::text end ")
            ->queryScalar();
            if($respuesta==''){             
                Yii::app()->rrhh
            ->createCommand("select registrar_sellada( '$fecha','$hora:$min'::time,$ci,true,'$usuario','$usuario') ")
            ->execute();
            }
            
            }
            return $respuesta;
          
    }
    /**
     * 3;"Atraso Personal"
2;"Atraso Justificado"
11;"Tiempo Adicional"
8;"Horas a Favor"
4;"Salida Antes Autorizada"
5;"Salida Antes Personal"

     */
    /**
     * 
     * @param string $es, tiene dos posibles valores E= entrada y S=salida
     * @param integer $cambiara,  es un tipo de sellada posibles valores son 11=tiempo adicional,3= atraso persona,2= atraso justificado, 8=horas a favor, 4= salida antes justificada  y 5= salida antes personal
     * @param array $lista,  informacion de los empleados de los cuales se hara el cambio del tipo de sellada y minutos 
     * @return string
     */
    public function cambiarEntradaSalidaGrupo($es,$cambiara,$lista) {
    $cantidad=count($lista);
     $usuario=Yii::app()->user->getName();
    for($i=1;$i<=$cantidad;$i++){
        if($lista[$i]['identradasalida']!='' && $lista[$i]['difhentrada']!='' && $lista[$i]['difmentrada']!=''){
           
               if(($lista[$i]['difhentrada']*60+$lista[$i]['difmentrada'])!=$lista[$i]['difentradaoriginal']){
                    Yii::app()->rrhh ->createCommand(" select  actualizar_minuto(".$lista[$i]['identradasalida'].", ".($lista[$i]['difhentrada']*60+$lista[$i]['difmentrada'])." , '$es' ,'$usuario')") ->execute();
                    }
                    if($lista[$i]['otrotipocolumna']==''){
                        $lista[$i]['otrotipocolumna']=0;
                    }
                    if($es=='E'){
                    Yii::app()->rrhh ->createCommand(" select  actualizar_tiposellada(".$lista[$i]['identradasalida'].", $cambiara , ".$lista[$i]['otrotipocolumna']." ,'$usuario')") ->execute();
                     Yii::app()->rrhh ->createCommand(" update entradasalida set observacionentrada='".$lista[$i]['observacionentrada']."' where id= ".$lista[$i]['identradasalida']) ->execute();
                   
                    }
                    else{
                       Yii::app()->rrhh ->createCommand(" select  actualizar_tiposellada(".$lista[$i]['identradasalida']." , ".$lista[$i]['otrotipocolumna'].", $cambiara ,'$usuario')") ->execute();
                      Yii::app()->rrhh ->createCommand(" update entradasalida set observacionsalida='".$lista[$i]['observacionentrada']."' where id= ".$lista[$i]['identradasalida']) ->execute();
                   
                    }
        
               }
    }
    return'';    
    }
    /**
     * 
     * @param integer $id, id de la sellada a dar de baja
     * @return boolean , true= si se mostrar el boton en el administrador  , false= si NO se mostrara el boton en el administrador
     */
    public function MostrarBajasellada($id) { 
        $model=Entradasalida::model()->findByPk(SeguridadModule::dec($id));
        if($model->salida!=null && $model->entrada!=null)
            return true;
        else
            return false;
    }
    /**
     * 
     * @param integer $id, id de la sellada a dar de baja
     * @param string $es, los posibles valores son E=entrada y S=salida
     */
    public function bajasellada($id,$es) {
          $usuario=Yii::app()->user->getName();
          Yii::app()->rrhh
            ->createCommand("select dar_bajasellada( $id,'$es','$usuario') ")
            ->execute();
        
    }
    /**
     * 
     * @param integer $ci, ci del empleado
     * @return string, informando  la hora del registro
     */
    public function registrarTeletrabajo($ci) {
         $usuario=Yii::app()->user->getName();
         return Yii::app()->rrhh
            ->createCommand("select registrar_teletrabajo( $ci::int,'$usuario') ")
            ->queryScalar();
    }
   

}
