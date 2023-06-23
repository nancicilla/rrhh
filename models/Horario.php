<?php
/*
 * Horario.php
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
 
 * This is the model class for table "general.horario".
 *n
 * The followings are the available columns in table 'general.horario':
 * @property integer $id
 * @property string $nombre
 * @property string $horasmes
 * @property boolean $estado
 * @property integer $idturno
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Turno $idturno
 * @property Cuerpohorario[] $cuerpohorarios
 */
class Horario extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $horastrabajo,$horarios,$fechainicio,$listaHorarios,$idhorario,$horas,$minutos,$limpiar,$fechadesde,$fechahasta;
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
            return 'general.horario';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                   
                    array('nombre', 'length', 'max'=>100),
                    array('usuario', 'length', 'max'=>30),
                    array('horasmes, estado, fecha, eliminado', 'safe'),

                    array('nombre', 'required', 'on' => array('insert', 'update')),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, nombre,  estado, usuario, fecha,fechadesde,fechahasta, eliminado', 'safe', 'on'=>'search'),
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
                   
                    'cuerpohorarios' => array(self::HAS_MANY, 'Cuerpohorario', 'idhorario'),
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
                    'horasmes' => 'Horas al Mes',
                    'estado' => 'Vigente',
                    
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'horastrabajo'=>'Horas de Trabajo',
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
            $criteria->addSearchCondition('t.horasmes',$this->horasmes,true,'AND','ILIKE');
            $criteria->compare('t.estado',$this->estado);
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
                        'defaultOrder' => 't.nombre asc', )
            ));
    }
    /**
     * 
     * @return array, con la informacion del cuerpo del horario
     */
  public function dameHorarios()
    {
        if ($this->cuerpohorarios!=null) {
            return Cuerpohorario::model()->listaHorarios($this->id);
        }else{
         return array();
        }
        
       
    }
    /**
     * 
     * @param integer $idhorariopadre, id del horario padre
     * @param integer $idhorario, id del horario
     * @param date $fechainicio, fecha de inicio de la asignacion del horario
     */
    public function guardarlistaEmpleados($idhorariopadre, $idhorario,$fechainicio)
    {   $usuario=Yii::app()->user->getName();
        Yii::app()->rrhh
            ->createCommand("select actualizarhorarioempleado(".$idhorariopadre.",".$idhorario.",'$fechainicio','$usuario') ")
            ->execute();
       
    }
    /**
     * 
     * @param integer[,] $lista, lista de empleados 
     * @param integer $idhorario, id del horario
     */
    public function guardarlistaQuitarEmpleados($lista,$idhorario)
    {
        $cant=count($lista);
        $usuario=Yii::app()->user->getName();        
        if ($cant>0){
        for ($i=1; $i <=$cant ; $i++) { 
               
            if ($lista[$i]['id']!=='' && $lista[$i]['limpiar']=='1'&& $lista[$i]['editar']=='-1') {                      
                 Yii::app()->rrhh
            ->createCommand("select crear_horario_empleado(".$lista[$i]['id'].", ".$idhorario.",'".$lista[$i]['fechainicio']."','$usuario') ")
            ->execute();
            } 
        }
       }
        
    }
    /**
     * 
     * @param integer $idhorario, id del horario
     * @return array con la informacion de los empleados
     */
    public function listaEmpleadoQuitar($idhorario)
    {
          return Yii::app()->rrhh
                ->createCommand("((select e1.id,to_char(mp.fechaini,'dd-mm-YYYY') as fechainicio, p.nombrecompleto,case when mp.fechaini>(select  fechahasta from planilla where eliminado=false order by id desc  limit 1)  then 1 else 0 end as colorear,0 as estado,2::int as editar,false as limpiar
            from movimientopersonal mp inner join general.empleado e1 on e1.id=mp.idempleado inner join general.persona p on p.id=e1.idpersona inner join general.seguimientoempleado se on se.idempleado=e1.id inner join ftbl_usuario_web_cruge_user cu on cu.iduser=se.idcrugeuser
             where  se.eliminado=false and cu.username='".Yii::app()->user->getName()."' and p.eliminado=false and mp.eliminado=false and e1.eliminado=false and mp.idhorario= $idhorario and infohespecial='')  
             union(
           select e1.id,to_char(mp.fechaini,'dd-mm-YYYY') as fechainicio, p.nombrecompleto,case when mp.fechaini>(select  fechahasta from planilla where eliminado=false order by id desc  limit 1) then 1 else 0 end as colorear,0 as estado,2::int as editar,false as limpiar
            from movimientopersonal mp inner join general.empleado e1 on e1.id=mp.idempleado inner join general.persona p on p.id=e1.idpersona inner join general.seguimientoempleado se on se.idempleado=e1.id inner join ftbl_usuario_web_cruge_user cu on cu.iduser=se.idcrugeuser

             where  se.eliminado=false and cu.username='".Yii::app()->user->getName()."' and p.eliminado=false and mp.eliminado=false and e1.eliminado=false and mp.idhorario= $idhorario and infohespecial<>''  and mp.fechaini in( select  (select min(fechaini)
            from  movimientopersonal where eliminado=false and idempleado=t.idempleado and infohespecial=t.infohespecial)  from ( select idempleado,infohespecial from movimientopersonal where eliminado=false and  idhorario=$idhorario and infohespecial<>'' group by idempleado,infohespecial) as t)
             )

             ) order by nombrecompleto asc ")->queryAll();
      }
      /**
       * 
       * @param integer $idhorario, id del horario
       * @return array, informacion del cuerpo del horario
       */
    public function listaHorarios($idhorario)
    {
         return Cuerpohorario::model()->listaHorarios($idhorario);
    }
    /**
     * 
     * @param integer $idhorario, id del horario
     * @return integer[], cantidad de hora y minutos 
     */
    public function DameHoraMinutoHorario($idhorario)
    {
        return Yii::app()->rrhh
            ->createCommand("select * from dame_cant_horas_horario($idhorario) ")
            ->queryAll();
    }
    /**
     * 
     * @param string $horai,hora inicio del intervalo de hora
     * @param string $horas, hora fin del intervalo de hora
     * @param boolean $controlare, se controla entrada
     * @param type $controlars, se controla salida
     * @return string , concatenacion de la hora inicio y hora fin
     */
    public function ArmarNombreIntervalo($horai,$horas,$controlare,$controlars)
    {
        $cad='';
        if ($controlars==true && $controlare==true) {
          $cad=$horai.'-'.$horas.' (E/S)'; 
            return $cad;
        }else{
            if($controlare==true){
              $cad= $horai.'-'.$horas.' (E)'; 
            return $cad;

            }else{
               $cad= $horai.'-'.$horas.' (S)'; 
            return $cad;

            }

        }
    }
    /**
     * 
     * @param integer $id, id del horario
     * @return boolean, true = Se mostrara el horario  false = No se mostrara el horario
     */
    public function Mostrarelemento($id)
    {
        $horario= Movimientopersonal::model()->find('t.idhorario='.SeguridadModule::dec($id).' and t.fechaini<=now()::date');
        
        if ( count($horario)==0 ) {
         return true;
        }else{
            return false;
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
     * @return Horario the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    /**
     * 
     * @return string, en caso de que no se pueda eliminar el horario
     */
    
     protected function beforeSafeDelete() {
        $id=$this->id;     
        $respuesta=Yii::app()->rrhh
            ->createCommand("select case when (select count(*) from movimientopersonal where eliminado=false  and fechaini>( select fechahasta from planilla where eliminado=false  order by id desc limit 1 ) and idhorario=$id )>0 or $id=1 then false else true end; ")
            ->queryScalar(); 
        if ($respuesta) {
            
            return parent::beforeSafeDelete();
        } else {
            echo System::messageError('El Horario seleccionado No puede ser eliminado, porque tiene empleados asignados ... ! ');
            return;
        }
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
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }
    /**
     * 
     * @param integer $idhorarioespecial, id del horario eventual
     * @param integer[] $lista, id de los empleados
     * @param date $desde, fecha inicio (aplicacion del horario eventual)
     * @param date $hasta, fecha hasta( aplicacion del horario eventual)
     */
    public function registrarHorarioEmpleado($idhorarioespecial,$lista,$desde,$hasta)
    {       $usuario= Yii::app()->user->getName();
            for($i=1;$i<=count($lista);$i++){
              if($lista[$i]['seleccionar']=='1'){
                  Yii::app()->rrhh
                    ->createCommand("select registrar_horarioespecial(".$lista[$i]['id'].",$idhorarioespecial, '$desde' ,'$hasta' ,'$usuario')  ")
                    ->execute(); 
              }

            }
            
    }
    /**
     * 
     * @param string $letrai, nombre  de la columna (ejemplo,A,B,C,etc.)
     * @param int $cant, la cantidad de letras consecutivas despues de la $letrai
     * @return array de letras
     */
    public function dameColumna($letrai, $cant) {
        $letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $letracontante = substr($letrai, 0, -1);
        $letrainicio = substr($letrai, -1);
        $numletrai = strlen($letrai);
        $antepenultima = '';
        $vector = [];
        if ($numletrai > 1) {
            $antepenultima = substr($letrai, -2, -1);
        }
        $posicion = strpos($letras, $letrainicio);
        $conjunto = substr($letras, $posicion, $cant + 1);
        $conjunto = str_split($conjunto);
        $diferencia = $cant + 1 - count($conjunto);

        for ($i = 0; $i < count($conjunto); $i++) {
            array_push($vector, $letracontante . $conjunto[$i]);
        }
        if ($diferencia > 0) {
            if ($antepenultima == '') {
                $posicion = 0;
                $letracontante = 'A';
            } else {
                $posicion = strpos($letras, $antepenultima);
                $posicionc = strpos($letras, $letracontante);
                $letracontante = $letras[$posicionc + 1];
            }

            $conjunto = substr($letras, $posicion, $diferencia);
            $conjunto = str_split($conjunto);

            for ($i = 0; $i < count($conjunto); $i++) {
                array_push($vector, $letracontante . $conjunto[$i]);
            }
        }


        return $vector;
    }


}
