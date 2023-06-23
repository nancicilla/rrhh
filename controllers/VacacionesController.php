<?php
/*
 * VacacionesController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 26/02/2020
 *
 * Ultima Actualizacion: $Date: 2015-10-13 09:08:14 -0400 (mar 13 de oct de 2015) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 */
class VacacionesController extends Controller
{
	 /*
     * IMPORTANTE!!!
     * Los métodos filters(),_publicActionsList() y accessRules() deben copiarse
     * tal cual en todos los controladores del proyecto
     */
    
    /* 
     * se debe usar este método filters en todos los controladores para permitir
     * filtrar si el usuario tiene acceso a las acciones y controlador o no, 
     */
   
    public function filters()
    {
        return array_merge(
            array(
                'accessControl',
                array('CrugeUiAccessControlFilter', 'publicActions' => self::_publicActionsList()),
            )
        );
    } 
    
    /* 
     * en este array deben ir las acciones publicas del modulo, las que se 
     * pueden acceder sin necesitar permisos, por defecto todas las acciones
     * se acceden solo con autorizacion, por eso el array no tiene acciones
     */
    private function _publicActionsList()
    {
        //en este array deben ir las acciones publicas del modulo, las que se 
        //pueden acceder sin necesitar permisos, por defecto todas las acciones
        //se acceden solo con autorizacion, por eso el array no tiene acciones
        return array(
            '',          
        );
    }
    
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => self::_publicActionsList(),
                'users' => array('*'),
            ),
            array(
                'allow',
                'users' => array('@'),
            ),
            array(
                'deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Creates a new model.
     */
    public function actionCreate()
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
    
        $model=new Vacaciones;       

        if(isset($_POST['Vacaciones'])){
                $model->attributes=$_POST['Vacaciones'];
                $model->hi=$_POST['Vacaciones']['hi'];
                $model->mi=$_POST['Vacaciones']['mi'];
                $model->hs=$_POST['Vacaciones']['hs'];
                $model->ms=$_POST['Vacaciones']['ms'];
                $model->fechasolicitud=$_POST['Vacaciones']['fechasolicitud'];
                if($model->tipo==true){
                    $model->fechahasta=$model->fechadesde;
                }
                if ($model->hi<10){
                    $model->hi='0'.$model->hi;
                }
                if ($model->hs<10){
                    $model->hs='0'.$model->hs;
                }
                if ($model->mi<10){
                    $model->mi='0'.$model->mi;
                }
                if ($model->ms<10){
                    $model->ms='0'.$model->ms;
                }
                $model->horai=$model->hi.':'.$model->mi;
                $model->horaf=$model->hs.':'.$model->ms;
                if($_POST['Vacaciones']['observacion'] ==null)
                $model->observacion='';
                   else
                 $model->observacion=strtoupper($_POST['Vacaciones']['observacion']);
                  $observacion= Yii::app()->rrhh
                   ->createCommand("SELECT observacion_permisos_pvb(".$model->idempleado.",'".$model->fechadesde."'::date,'".$model->fechahasta."'::date,'".$model->tipo."'::boolean,'".$model->horai."','".$model->horaf."') as sms")
            ->queryScalar();
                if ($observacion==''){
                 $respuesta=Vacaciones::model()->registrarVacacion($model);
                if($respuesta==''){                       
                    echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {
                    echo System::hasErrors($respuesta, $model);
                return;
                }}else{
                    echo System::hasErrors($observacion, $model);
                }
        }

        $this->renderPartial('create',array(
            'model'=>$model,
        ), false, true);
    }

     /**
      * @param  string $_GET['term'], nombre completo o parte del nombre completo del empleado 
      * retorna un lista de empleados en los que en su nombre completo contenga $_GET['term']
      */
     public function actionAutocompletePersona() {
        $request = trim($_GET['term']);
        $requestMayuscula = strtoupper($request);
         if ($request != '') {
               $model=   Yii::app()->rrhh
            ->createCommand("select e.id ,  p.apellidop||' '||p.apellidom||' '||p.nombre as nombrecompleto from general.persona p inner join general.empleado e on e.idpersona=p.id right outer join general.seguimientoempleado se on se.idempleado=e.id  right outer JOIN ftbl_usuario_web_cruge_user cu  on cu.iduser=se.idcrugeuser where se.eliminado=false and  cu.username='".Yii::app()->user->getName()."' and p.nombrecompleto like '%$requestMayuscula%'  ")
            ->queryAll();
            $data = array();
            foreach ($model as $get) {
                $data[] = array(
                    'value' => $get['nombrecompleto'],
                    'id' => $get['id'],
                );
            }
            $this->layout = 'empty';
            echo CJSON::encode($data);
        }
    }
    /**
     * @param integer $_POST['ide'], id del empleado
     * retorna informacion del empleado con relacion a su vacacion(dias, fecha vacacion)
     */
    public function actionDameInformacionEmpleado()
    {   $idempleado=$_POST['ide'];   
        $usuario= $usuario= Yii::app()->user->getName();
        $resp=Yii::app()->rrhh->createCommand("select diasva,observacion from public.damediasvacacion(".$idempleado.",'$usuario') ")->queryAll();
        $fechacontratacion=Yii::app()->rrhh->createCommand("select to_char(fechavacacion,'dd-mm-YYYY') as fecha from general.historialestadoempleado where eliminado=false and idempleado=$idempleado order by id desc limit 1")->queryScalar();
        $fechaminima= Yii::app()->rrhh->createCommand("select to_char((select   damefechaminima_permisovacacion($idempleado,1)),'dd-mm-YYYY')")->queryScalar();
   
        if ($resp[0]['observacion']=='') {
          $r=Yii::app()->rrhh->createCommand("select count( damemovimiento_fecha(now():: date,$idempleado)) as r")->queryScalar();
          if ($r==0) {
            $resp[0]['observacion']='<div class="alert alert-info">NO TIENE ASIGNADO UN HORARIO...</div>';
          }
        }
        
    echo CJSON::encode( array('diasva' =>$resp[0]['diasva'],'fechacontratacion'=>$fechacontratacion ,'observacion'=>$resp[0]['observacion'],'fechaminima'=>$fechaminima  ));
    }
    /**
     * @param date $_POST['fecha'], fecha desde seleccionada por el usuario
     * @param integer $_POST['ide'], id del empleado
     * retorna la cantidad de dias a tomar segun el horario que tiene asignado el empleado sin tomar encuenta feriados  y la fecha limite a la cual puede seleccionar el usuario
     */
    public function actionDameFechaMax()
    {
        $fecha=$_POST['fecha'];   
        $ide=$_POST['ide'];
        $cantrv=Yii::app()->rrhh->createCommand("select count(fechahasta) as cantidad from general.vacaciones where idempleado=$ide and eliminado=false and  essaldo=false")->queryScalar();
        $fechaminima='';
        $resp=Yii::app()->rrhh->createCommand("select dias,fechalimite from damefecha_max_vacacion($ide,'$fecha') ")->queryAll();
        echo CJSON::encode( array('dias' =>$resp[0]['dias'] ,'fechalimite'=>$resp[0]['fechalimite'] ,'fechaminima'=>$fechaminima ));
        
    }
    /**
     * @param date $_POST['fecha'], fecha desde seleccionada por el usuario
     * @param integer $_POST['ide'], id del empleado
     * @param integer$_POST['id'], id de la vacion que se quiere actualizar
     * retorna la cantidad de dias a tomar segun el horario que tiene asignado el empleado sin tomar encuenta feriados  y la fecha limite a la cual puede seleccionar el usuario
     */
        public function actionDameFechaMax1()
    {
        $fecha=$_POST['fecha'];   
        $ide=$_POST['ide'];
        $id=$_POST['id'];
        $resp=Yii::app()->rrhh->createCommand("select diasvacacion,fechamin,fechamax from dame_fecha_max_min($id,'$fecha') ")->queryAll();
        echo CJSON::encode( array('dias' =>$resp[0]['diasvacacion'] ,'fechalimite'=>$resp[0]['fechamax'] ,'fechaminima'=>$resp[0]['fechamin']));
        
    }
    /**
     * @param date $_POST['fechadesde'] , fecha inicio de la vacacion
     * @param date $_POST['fechahasta'], fecha fin de la vacacion
     * @param integer $_POST['ide'],id del empleado 
     * retorna la cantidad de dias que se esta tomando entre las dos fecha seleccionadas
     * 
     */
    public function actionDameDiasPorTomar()
    {
        $desde=$_POST['fechadesde'];
        $hasta=$_POST['fechahasta'];
        $ide=$_POST['ide'];
        $usuario=Yii::app()->user->getName();
        $horario='';
        $resp=Yii::app()->rrhh->createCommand("select damediasvacacion_portomar($ide, '$desde' ,'$hasta','$usuario' ) as dias")->queryAll();
      
        echo CJSON::encode( array('dias' =>$resp[0]['dias'] ,'horario'=>'<div class="alert alert-info">'.$horario.'</div>' ));
        
    }
     /**
     * @param date $_POST['fechadesde'], fecha en la cual estamos analizando 
     * @param integer $_POST['idempleado'], id del empleado
     * @param integer $_POST['hi'], hora inicio del permiso
     * @param integer $_POST['mi'], minuto inicio del permiso
     * @param integer $_POST['hs'], hora fin del permiso
     * @param integer $_POST['ms'],minuto fin del permiso
     * @return la cantidad de horas por tomar segun el intervalo de hora seleccionado y segun el horario que tiene asignado el empleado
     */
    public function actionDameHorasPorTomar()
    {
       $desde=$_POST['fechadesde'];
        $hi=$_POST['hi'];
        $hs=$_POST['hs'];
        $mi=$_POST['mi'];
        $ms=$_POST['ms'];
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
        $horai=$hi.':'.$mi;
        $horas=$hs.':'.$ms;
        $ide=$_POST['idempleado'];
         $horas=Yii::app()->rrhh->createCommand(" select dame_canthorasportomar( '$horai' ,  '$horas' ,$ide,'$desde') as horas")->queryScalar();
         echo $horas;
      return;


    }
    /**
     * @param integer $_POST['idempleado'], id del empleado
     * @param date $_POST['fecha'], fecha seleccionada
     * retorna fechalimite ,horario  y la hora minima y hora maxima del turno
     */
    public function actionMostrarhorarioFecha()
    {
        $idempleado=$_POST['idempleado'];
        $fecha=$_POST['fecha'];
        $intervalohoras=Yii::app()->rrhh->createCommand("select hi,mi,hs,ms from dame_horai_horas($idempleado,'$fecha')")->queryAll();
        $ver = Yii::app()->rrhh
            ->createCommand("SELECT  dame_horario_empleado($idempleado,'$fecha'::date) as sms")
            ->queryAll();
       $resp=Yii::app()->rrhh->createCommand("select fechalimite from damefecha_max_vacacion($idempleado,'$fecha') ")->queryAll();
       $horario= '<div class="alert alert-info">'.$ver[0]['sms'].'</div>';
         echo CJSON::encode( array('fechalimite'=> $resp[0]['fechalimite'], 'horario' =>$horario ,'hi'=>$intervalohoras[0]['hi'] ,'mi'=>$intervalohoras[0]['mi'],'hs'=>$intervalohoras[0]['hs'],'ms'=>$intervalohoras[0]['ms'] ));


    }
     /**
     * Updates a particular model.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $model=Vacaciones::model()->findByPk(SeguridadModule::dec($id));
        $tipo=$model->tipo;
        $model->fechacontratacion=Yii::app()->rrhh->createCommand("select to_char(fechavacacion,'dd-mm-YYYY') as fecha from general.historialestadoempleado where eliminado=false and idempleado=".$model->idempleado." order by id desc limit 1")->queryScalar();
        $fechas=Yii::app()->rrhh->createCommand("select fechamin,fechamax from dame_fecha_max_min(".$model->id.",'".$model->fechadesde."')")->queryAll()[0];
        $ver = Yii::app()->rrhh
            ->createCommand("SELECT  dame_horario_empleado(". $model->idempleado.",'".$model->fechadesde."'::date) as sms")
            ->queryAll();
        $horario= '<div class="alert alert-info">'.$ver[0]['sms'].'</div>';
        $intervalohoras=Yii::app()->rrhh->createCommand("select hi,mi,hs,ms from dame_horai_horas($model->idempleado,'$model->fechadesde')")->queryAll();
        //$fechaminima,$fechamaxima7
        if ($fechas['fechamin']!='') {
          $model->fechaminima=date('d-m-Y',strtotime($fechas['fechamin']));  
        }
        if ($fechas['fechamax']!='') {
         $model->fechamaxima=date('d-m-Y',strtotime($fechas['fechamax']));   
        } 
        
       
        $model->fechadesde=date('d-m-Y',strtotime($model->fechadesde));
        $model->fechahasta=date('d-m-Y',strtotime($model->fechahasta));
        if($model->diasgestionactual==0){
        $horai=explode(':', $model->horai) ;
        $horaf=explode(':', $model->horaf) ;
        $model->hi=intval( $horai[0]);
        $model->mi=intval($horai[1]);
        $model->hs=intval($horaf[0]);
        $model->ms=intval($horaf[1]);}
        $usuario= $usuario= Yii::app()->user->getName();
        $resp=Yii::app()->rrhh->createCommand("select diasva,observacion from public.damediasvacacion(".$model->idempleado.",'$usuario') as f")->queryAll()[0];
        $model->diasva=$resp['diasva'];
      
       if(isset($_POST['Vacaciones']))
        {
            
            $model->attributes=$_POST['Vacaciones'];
                      
            if($model->diasgestionactual==0){
                
                
                if($model->tipo==true){
                    $model->hi=$_POST['Vacaciones']['hi'];
                    $model->mi=$_POST['Vacaciones']['mi'];
                    $model->hs=$_POST['Vacaciones']['hs'];
                    $model->ms=$_POST['Vacaciones']['ms'];
                    $model->fechahasta=$model->fechadesde;
                   
                }else{
                    
                    $model->tipo=0;
                   
                }
                if ($model->hi<10){
                    $model->hi='0'.$model->hi;
                }
                if ($model->hs<10){
                    $model->hs='0'.$model->hs;
                }
                if ($model->mi<10){
                    $model->mi='0'.$model->mi;
                }
                if ($model->ms<10){
                    $model->ms='0'.$model->ms;
                }
                $model->horai=$model->hi.':'.$model->mi;
                $model->horaf=$model->hs.':'.$model->ms;
                if($_POST['Vacaciones']['observacion'] ==null)
                $model->observacion='';
                else
                $model->observacion=strtoupper($_POST['Vacaciones']['observacion']);
                    $observacion= Yii::app()->rrhh
                    ->createCommand("SELECT observacion_permisos_pvb_update(".$model->id.",".$model->idempleado.",'".$model->fechadesde."'::date,'".$model->fechahasta."'::date,'".$model->tipo."'::boolean,'".$model->horai."','".$model->horaf."') as sms")
                    ->queryScalar();
            }else{
            $observacion='';
            
            }
                  if($observacion==''){
            $respuesta=Vacaciones::model()->actualizarVacacion($model);
            if($respuesta==''){
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors($respuesta, $model);
                return;
                  }}else{
                     echo System::hasErrors($observacion, $model);
                return; 
                  }
        }

        $this->renderPartial('update',array(
            'model'=>$model,
            'horario'=>$horario,
            'intervalohoras'=>$intervalohoras,
        ), false, true);
    }
    /**
     * 
     * @return retorna interfaz para el registro de saldo de vacacion
     */
    public function actionSaldoVacacion()
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=new Vacaciones;
        $listaempleados=  array();
        if(isset($_POST['gridEmpleados'])){
         
                if(Vacaciones::model()->registrarSaldoVacacion($_POST['gridEmpleados'])){                       
                    echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {
                    echo System::hasErrors('Revise los datosk! ', $model);
                return;
                }
        }

        $this->renderPartial('saldovacacion',array(
            'model'=>$model,
            'listaempleados'=>$listaempleados,
        ), false, true);
    }
    /**
     * retorna interfa para la adicicion de vacacion
     */
    public function actionAdicionarvacacion()
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=new Vacaciones;
        $listaempleados=  array();
        $fechaminima=Yii::app()->rrhh->createCommand("   select to_char(fechahasta+1,'dd-mm-YYYY') from planilla where eliminado=false order by id desc  limit 1")->queryScalar();
        if ($fechaminima==false){
              $fechaminima=Yii::app()->rrhh->createCommand(" select '01-'||date_part('month',now())||'-'||date_part('year',now())")->queryScalar();
        }
        if(isset($_POST['gridEmpleados'])){         
            Vacaciones::model()->adicionarVacacion($_POST['gridEmpleados'],$_POST['Vacaciones']['fechadesde'],$_POST['Vacaciones']['dias'],$_POST['Vacaciones']['observacion']);                        
                  
        }

        $this->renderPartial('adicionarvacacion',array(
            'model'=>$model,
            'listaempleados'=>$listaempleados,
             'fechaminima'=>$fechaminima,
        ), false, true);
    }
    /**
     * retorna inrerfa para el registro en bloque de vacacion
     */
    public function actionQuitarvacacion()
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $model=new Vacaciones;
        $opciones=Yii::app()->rrhh->createCommand("   select distinct  fechadesde as id, to_char(fechadesde,'dd-mm-YYYY') as fecha  from general.vacaciones where eliminado=false and diasabono>0")->queryAll();
        $fechaminima=Yii::app()->rrhh->createCommand("   select to_char(fechahasta+1,'dd-mm-YYYY') from planilla where eliminado=false order by id desc  limit 1")->queryScalar();
        if ($fechaminima==false){
              $fechaminima=Yii::app()->rrhh->createCommand(" select '01-'||date_part('month',now())||'-'||date_part('year',now())")->queryScalar();
        }
         
        if(isset($_POST['gridEmpleados'])){         
               Vacaciones::model()->quitarVacacion($_POST['gridEmpleados'],$_POST['Vacaciones']['fechadesde'],$_POST['Vacaciones']['dias'],$_POST['Vacaciones']['jornada'],$_POST['Vacaciones']['observacion']);
                        
                  
        }
          $listaempleados=array();
        $this->renderPartial('quitarvacacion',array(
            'model'=>$model,
            'opciones'=>$opciones,
            'listaempleados'=>$listaempleados,
            'fechaminima'=>$fechaminima,
        ), false, true);
    }
    /**
     * @param integer $_POST['tipo'], posibles valores   2= femenino , 3=masculino   y 4=todos
     * @param string $_POST['nombre'] nombre del formulario que hizo el llamado a la funcion
     * retorna el listado de empleados segun $_POST['tipo'] seleccionado para la adicion de vacacion
     */
    public function actionListaempleadostipo(){
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $tipo=$_POST['tipo'];
        $nombre=$_POST['nombre'];
        $cadena='';
        $estado=false;
        switch ($tipo){
            case 2:{
             $cadena="p.sexo='F' AND"; 
      
                    break;
            }
            case 3:{
                 $cadena="p.sexo='M' AND"; 
                    break;
            }
            case 4:{
                    break;
            }
        default :
            $cadena=""; 
            $estado=true;
             break;
        }
        
            $listaempleados=Yii::app()->rrhh->createCommand("   select e.id,  p.nombrecompleto , 2 as tipo from general.persona p inner join general.empleado e on e.idpersona=p.id where $cadena   e.id in (select hee.idempleado from general.historialestadoempleado hee   where   hee.eliminado=false  and hee.activo=1 and hee.id in 
            (select  (select max(id) from general.historialestadoempleado where eliminado=false and idempleado=e.id) 
            as idhistorial from general.empleado e where   e.eliminado=false)) and e.id in
           (select mp.idempleado from 
           movimientopersonal mp   where  mp.eliminado=false  and mp.id in 
            (select  (select max(mp1.id) from movimientopersonal mp1 inner join contrato c on c.id=mp1.idcontrato inner join general.tipocontrato tc on tc.id=c.idtipocontrato where mp1.eliminado=false and tc.generarcc=true  and idempleado=e.id) 
            as idmp from general.empleado e where   e.eliminado=false)) order by p.nombrecompleto asc ")->queryAll();       
        

      $this->renderPartial('_listaempleados',array(
            'nombre'=>$nombre,
            'listaempleados'=>$listaempleados,
            'estado'=>$estado
        ), false, true);
        
      
        
    }
    /**
     * @param date $_POST['fecha'], fecha inicio desde la cual se quiere asignar la vacacion
     * @param string $_POST['nombre'] , nombre del formulario que hizo el llamado a la funcion
     * @param float $_POST['dias'], cantidad de dias de vacacion 
     * @param int $_POST['jornada'], posibles valore 1= la inicio de la jornada y 2= la final de la jornada
     * @param integer $_POST['tipo'], posibles valores   2= femenino , 3=masculino   y 4=todos
     * retorna el listado de empleado segun $_POST['tipo'] seleccionado  ,con las observaciones segun corresponda
     */
public function actionListaempleadosquitar(){
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $fecha=$_POST['fecha'];
        $nombre=$_POST['nombre'];
        $dias=$_POST['dias'];
        $jornada=$_POST['jornada'];
        $tipo=$_POST['tipo'];
        $cadena='';
        $usuario= Yii::app()->user->getName();
        $estado=false;
        switch ($tipo){
            case 2:{
             $cadena="p.sexo='F' AND"; 
      
                    break;
            }
            case 3:{
                 $cadena="p.sexo='M' AND"; 
                    break;
            }
            case 4:{
                    break;
            }
        default :
            $cadena=""; 
            $estado=true;
             break;
        }
     
         $listaempleados=  Yii::app()->rrhh->createCommand("select e.id, p.nombrecompleto,(case when(select public.observacion_diasdescontar("
                 . "e.id,'$fecha', $dias, $jornada,'$usuario'))='' then 2 else 3 end)as tipo
 from general.persona p inner join general.empleado e on e.idpersona=p.id where $cadena   
 e.id in  (
select hee.idempleado from general.historialestadoempleado hee inner join contrato c on c.idhistorialestadoempleado=hee.id inner join historialcontrato hc on hc.idcontrato=c.id  inner join general.tipocontrato tc on tc.id=c.idtipocontrato 
where
c.eliminado=false and hc.fecharegistro<='$fecha' and tc.generarcc=true and hee.activo=1 and
hee.id in
( select ( select max(he.id) from  general.historialestadoempleado he where he.eliminado=false  and he.idempleado=e1.id) from general.empleado e1 where e1.eliminado=false
 ) )
  order by p.nombrecompleto asc  ")->queryAll();
        $this->renderPartial('_listaempleados',array(
            'nombre'=>$nombre,
            'listaempleados'=>$listaempleados,
            'estado'=>$estado,
           
        ), false, true);
        
      
        
    }
    /**
     * Deletes safely a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {     
            $this->loadModel(SeguridadModule::dec($id))->safeDelete();      
            self::actionAdmin();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model=new Vacaciones('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Vacaciones'])){
                $model->attributes=$_GET['Vacaciones'];
                if (!$model->validate()) {
                    echo System::hasErrorSearch($model);
                    return;
                }
        }        

        $this->renderPartial('admin',array(
            'model'=>$model,
        ), false, true);
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Vacaciones the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Vacaciones::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Vacaciones $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='vacaciones-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
       /**
        * 
        * @return formulario para el reporte de vacacion
        */ 
        public function actionReportegeneralvacaciones() {
            Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
            $model=new Vacaciones;
            $listaareas= Area::model()->findAll();
            if(isset($_POST['Vacaciones'])){
                    $model->attributes=$_POST['Vacaciones'];
                   return;
            }
            $this->renderPartial('reportegeneralvacaciones',array(
                'model'=>$model,
                'listaareas'=>$listaareas
            ), false, true);
           
        }
        /**
         * @param date $_GET['fecha'], fecha hasta la cual se quiere obtener el reporte de vacaciones
         * retona reporte con el listado deempleados y la cantidad de dias que tuviesen hasta esa fecha
         * @throws CrugeException
         */
        public function actionImprimirReportegeneralvacaciones()
    {
       
        $fecha=$_GET['Vacaciones']['fechadesde'];
        $area= $_GET['area'];
        $areasseleccionadas = '';
         for ($i = 0; $i < count($area); $i++) {
                        $areasseleccionadas = $areasseleccionadas . $area[$i] . ',';
         }
        $areasseleccionadas = substr($areasseleccionadas, 0, -1);
                    $resp=  Yii::app()->rrhh
            ->createCommand("select asignar_dias_vacacion_antiguedad()")
            ->execute();
                
           $re = new JasperReport('/reports/RRHH/ReporteGeneralVacaciones', JasperReport::FORMAT_PDF, array(
                'p_fechahasta' => $fecha,
                'p_areas'=>$areasseleccionadas,
                'pUsuario'=>Yii::app()->user->getName(),
                
            ));
            $re->exec();                                
            if ($re->getPages() > 0) {
                echo $re->toPDF();
            } else {
                throw new CrugeException('El reporte no tiene páginas.', 483);
            }
            
    }
    /**
     * @param integer $_POST['ide'], id del empleado
     * @param boolean $_POST['tipo'], true= si es a nivel de horas  , false= a nivel de dia
     * retorn array con la informacion de la fecha minima y limite a la cual puede sacar la vacación 
     */
    public function actionDamefechasminimas(){
        $idempleado=$_POST['ide'];
        $tipo=$_POST['tipo'];
        $horario='';        
        $cantrv=Yii::app()->rrhh->createCommand("select count(*) as cantidad from general.vacaciones where idempleado=$idempleado and eliminado=false")->queryScalar();
        $fechaminima= Yii::app()->rrhh->createCommand("select to_char(( select    damefechaminima_permisovacacion(".$idempleado.",$tipo)),'dd-mm-YYYY')")->queryScalar();
        if($tipo==1){
             $ver = Yii::app()->rrhh
            ->createCommand("SELECT  dame_horario_empleado($idempleado,'$fechaminima'::date) as sms")
            ->queryAll();
           $horario= '<div class="alert alert-info">'.$ver[0]['sms'].'</div>';
        }
        
           $resp=Yii::app()->rrhh->createCommand("select dias,fechalimite from damefecha_max_vacacion($idempleado,'$fechaminima') ")->queryAll();
            echo CJSON::encode( array('fechalimite'=>$resp[0]['fechalimite'] ,'fechaminima'=>$fechaminima,'horario'=>$horario ));
        

    }
    /**
     * retorna reporte del ultimo permiso a cuenta de vacacion
     * @throws CrugeException
     */
    public function actionImprimirVacacionAlCrear() {
        $idvacacion = Yii::app()->rrhh
                ->createCommand("select id from general.vacaciones where eliminado=false order by id desc  limit 1")
                ->queryScalar();

        $re = new JasperReport('/reports/RRHH/ReporteSolicitudVacacion', JasperReport::FORMAT_PDF, array(
            'p_idvacacion' => $idvacacion
            
        ));
        $re->exec();
        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        }
    }
    /**
     * 
     * @param integer $id, id del permiso a cuenta de  vacacion que queremos reimprimir
     * retorna reporte del permiso a cuenta de vacacion
     * @throws CrugeException
     */
    public function actionImprimirVacacion($id) {
       $idvacacion= SeguridadModule::dec($id);
     
        $re = new JasperReport('/reports/RRHH/ReporteSolicitudVacacion', JasperReport::FORMAT_PDF, array(
            'p_idvacacion' => $idvacacion
        ));
        $re->exec();
        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        } 
    }
    /**
     * @param string $_POST['nombrecompleto'], nombre completo o parte del nombre completo
     * retorna listado de empelados cuyos nombres completos contenga a $_POST['nombrecompleto']
     */
     public function actionBuscarEmpleado()
    {
        
        $datos = Persona::model()->filtraPersonaVacacion($_POST['nombrecompleto']);
        if(count($datos->getData()) == 0)
            $datos = array(
                0 => array('nombre' => $_POST['nombrecompleto'], 'id' => '0')
            );
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $datos,
            'columns' => array(
                array('name' => 'nombrecompleto', 'header' => 'Empleado', 'value' => '$data->nombrecompleto'),
                array('name' => 'id', 'typeCol' => 'hidden', 'value' => '$data->empleados[0]->id'),
            ),
        ));
    }
     public function actionactualizarabono($id)
    {
        
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
       
        $model=$this->loadModel(SeguridadModule::dec($id));
        $fechas=Yii::app()->rrhh->createCommand("select fechamin,fechamax from dame_fecha_max_min(".$model->id.",'".$model->fechadesde."')")->queryAll()[0];
        if ($fechas['fechamin']!='') {
          $model->fechaminima=date('d-m-Y',strtotime($fechas['fechamin']));  
        }
        if ($fechas['fechamax']!='') {
         $model->fechamaxima=date('d-m-Y',strtotime($fechas['fechamax']));   
        } 
          if(isset($_POST['Vacaciones'])){
                   
                    Vacaciones::model()->ActualizarAbono($_POST['Vacaciones']['id'],$_POST['Vacaciones']['diasabono'],$_POST['Vacaciones']['observacion']);
                  //falta codificar
            }
        $this->renderPartial('actualizarabono',array(
            'model'=>$model,
        ), false, true);
    }
     public function actionReporteVacaciones()
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);    
        $model=new Vacaciones;       
        $this->renderPartial('reporteVacaciones',array(
            'model'=>$model,
        ), false, true);
    }
    public function actionDescargarReporteVacaciones() {
        $fechadesde=$_GET['Vacaciones']['fechadesde'];
        $fechahasta=$_GET['Vacaciones']['fechahasta'];
      
      
         $orden='  2 asc, 5 asc';   
        
        $datoEmpresa = Yii::app()->rrhh
                        ->createCommand("select * from general.empresa where eliminado=false " )
                        ->queryAll()[0];
        $datoPlanilla = Yii::app()->rrhh
                ->createCommand(" select to_char( v.fechadesde ,'dd-mm-YYYY') as desde,fechadesde, (select puesto from public.damepuestot('$fechadesde','$fechahasta', e.id)),to_char( v.fechahasta,'dd-mm-YYYY') as hasta,p.nombrecompleto,v.diastomados::numeric(12,4) as diastomados,v.dias::numeric(12,4) as dias , case when  (((v.fechadesde between '$fechadesde' and '$fechahasta'  ) and (v.fechahasta not between '$fechadesde' and '$fechahasta'  )) or ((v.fechadesde  not between '$fechadesde' and '$fechahasta'  ) and (v.fechahasta  between '$fechadesde' and '$fechahasta'  )) ) then 1::int else 0::int end as pintar, case when v.tipo=false then '' else v.horai end as horainicio,case when v.tipo =false then '' else horaf end as horafin ,to_char(v.fecha,'dd-mm-YYYY') as fecharegistro from general.vacaciones v 
                                 inner join general.empleado e on e.id=v.idempleado inner join general.persona  p on p.id=e.idpersona where v.eliminado=false and ((v.fechadesde  between '$fechadesde' and '$fechahasta') or (v.fechahasta  between '$fechadesde' and '$fechahasta') or (   '$fechadesde'  between v.fechadesde and v.fechahasta) or ('$fechahasta' between v.fechadesde and v.fechahasta)) and horai<>'PF' and diasgestionactual=0 and diasabono=0 and essaldo=false order by $orden ")
                ->queryAll();
       
        
       
        $nombreArchivo = 'Vacaciones' . $fechadesde.'_'.$fechahasta;
       
        
       
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);
        
        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $activeSheet->setTitle($nombreArchivo);
        $activeSheet->getDefaultColumnDimension()->setWidth(9.7);
        $activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 7);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $phpFont = array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
       
        $phpFontC = array('font' => array(
                'bold' => true,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $phpFont2 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        ));
        $phpFont3 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        ));

       

        $activeSheet->getColumnDimension('A')->setWidth(6);
        $activeSheet->getColumnDimension('B')->setWidth(45);
        $activeSheet->getColumnDimension('C')->setWidth(40);
        $activeSheet->getColumnDimension('D')->setWidth(20);
        $activeSheet->getColumnDimension('E')->setWidth(20);
        $activeSheet->getColumnDimension('F')->setWidth(20);
        $activeSheet->getColumnDimension('G')->setWidth(20);
        $activeSheet->getColumnDimension('H')->setWidth(20);
        $activeSheet->getColumnDimension('E')->setWidth(20);
        $activeSheet->getColumnDimension('F')->setWidth(20);
        $activeSheet->getColumnDimension('G')->setWidth(20);
        $activeSheet->getColumnDimension('H')->setWidth(20);
        $activeSheet->getColumnDimension('I')->setWidth(20);
        $activeSheet->getColumnDimension('J')->setWidth(20);
        $activeSheet
                ->getPageMargins()->setTop(0.8);
        $activeSheet
                ->getPageMargins()->setRight(0.2);
        $activeSheet
                ->getPageMargins()->setLeft(0.2);
        $activeSheet
                ->getPageMargins()->setBottom(0.4);
        $phpColor = new PHPExcel_Style_Color();
        $phpColor->setRGB('FF0000');
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);
        $kFila = 8;
        $img = realpath(__DIR__ . '/../../../../images'); // Provide path to your logo file

        $imgot = $img . '/logoEmpresa.png';


        $objDrawingt = new PHPExcel_Worksheet_Drawing();
        $objDrawingt->setName('imgNotice');
        $objDrawingt->setDescription('Noticia');
        $objDrawingt->setPath($imgot);
        $objDrawingt->setOffsetX(5);    // setOffsetX works properly
        $objDrawingt->setOffsetY(0);  //setOffsetY has no effect
        $objDrawingt->setCoordinates('A1');
        $objDrawingt->setWidthAndHeight(140, 70);
        $objDrawingt->setResizeProportional(true);
        $objDrawingt->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
        $activeSheet->getRowDimension(7)->setRowHeight(52);
        $activeSheet->getRowDimension(1)->setRowHeight(14);
        $activeSheet->getRowDimension(2)->setRowHeight(8);
        $activeSheet->getRowDimension(3)->setRowHeight(13);
        $activeSheet->getRowDimension(4)->setRowHeight(8);
        $activeSheet->getRowDimension(5)->setRowHeight(8);
        $activeSheet->getRowDimension(6)->setRowHeight(8);

        //CABECERA DE LA PLANILLA

        $activeSheet->mergeCells('A1:I1');
        $activeSheet->mergeCells('A2:I2');
        $activeSheet->mergeCells('A3:I3');
        $activeSheet->mergeCells('A4:I4');
       
       
        $activeSheet->setCellValue('A1', strtoupper("REPORTE VACACIONES" ));
        $activeSheet->setCellValue('A3', 'DEL '.$fechadesde.' AL '.$fechahasta);
      
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $activeSheet->setCellValue('F1', $datoEmpresa['direccion']);
        $activeSheet->setCellValue('F2', "NIT:" . $datoEmpresa['nit']);
        $activeSheet->setCellValue('F3', "TEL:" . $datoEmpresa['telefono'] . "   FAX:" . $datoEmpresa['fax']);
        $activeSheet->getStyle("A1")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(12);
        $activeSheet->getStyle("A1")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("A3")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(11);
        $activeSheet->getStyle("A3")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("P1:P5")->getFont()->setBold(false)
                ->setName('Times New Roman')
                ->setSize(7);
        // COLUMNAS STATICAS
        $activeSheet->getStyle('A7:J7')->applyFromArray($phpFontC);
        $activeSheet->getStyle("A7:J7")->getAlignment()->setWrapText(true);
        $activeSheet->setCellValue('A7','NRO' );
        $activeSheet->setCellValue('B7','APELLIDOS Y NOMBRES' );
        $activeSheet->setCellValue('C7','CARGO' );
        $activeSheet->setCellValue('D7','DEL' );
        $activeSheet->setCellValue('E7','AL' );
        $activeSheet->setCellValue('F7','HORA INICIO' );
        $activeSheet->setCellValue('G7','HORA FIN' );
        $activeSheet->setCellValue('H7','DIAS A DISFRUTAR' );
        $activeSheet->setCellValue('I7','FECHA REGISTRO' );
        $activeSheet->setCellValue('J7','SALDO DE VACACIÓN' ); 
        

        ///CUERPO
      
        for ($i =0 ; $i < count($datoPlanilla); $i++) {
            $activeSheet->getRowDimension($kFila)->setRowHeight(23);
            $activeSheet->getStyle('A' . $kFila.':J'.$kFila)->applyFromArray($phpFont2);
            if ($datoPlanilla[$i]['pintar']==1){
                $activeSheet->getStyle('D' . $kFila.':E'.$kFila)->getFill('')->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => 'F88300')
        ));
            } 
            $activeSheet->setCellValue('A'.$kFila,($i+1) );
            $activeSheet->setCellValue('B'.$kFila, $datoPlanilla[$i]['nombrecompleto']);
            $activeSheet->setCellValue('C'.$kFila,$datoPlanilla[$i]['puesto'] );
            $activeSheet->setCellValue('D'.$kFila,$datoPlanilla[$i]['desde'] );
            $activeSheet->setCellValue('E'.$kFila,$datoPlanilla[$i]['hasta']);
            $activeSheet->setCellValue('F'.$kFila,$datoPlanilla[$i]['horainicio']);
            $activeSheet->setCellValue('G'.$kFila,$datoPlanilla[$i]['horafin'] );
            $activeSheet->setCellValue('H'.$kFila,$datoPlanilla[$i]['diastomados'] );
            $activeSheet->setCellValue('I'.$kFila,$datoPlanilla[$i]['fecharegistro'] );
           $activeSheet->setCellValue('J'.$kFila,$datoPlanilla[$i]['dias'] );    
           
            $kFila++;
        }
        
        
            $activeSheet->setAutoFilter('A7:J'.($kFila-1));
       
        
       
       
        $this->descargarExcel($objPHPExcel, $nombreArchivo);
        
    }
     public function actionDescargarReporteGeneralVacacionXLS() {
         $fecha=$_GET['Vacaciones']['fechadesde'];
         $areas=$_GET['area'];
        $areasseleccionadas =''; 
        for ($i = 0; $i < count($areas); $i++) {
                        $areasseleccionadas = $areasseleccionadas . $areas[$i] . ',';
                    }
                    $areasseleccionadas = substr($areasseleccionadas, 0, -1);


        $nombreAreas = Yii::app()->rrhh
                        ->createCommand("SELECT string_agg(nombre,',') from general.area where id in($areasseleccionadas)" )
                        ->queryScalar();
        $datoEmpresa = Yii::app()->rrhh
                        ->createCommand("select e.*,r.* from   general.representante r  inner join general.empresa e on e.id=r.idempresa
where r.activo=true" )
                        ->queryAll()[0];
        $datoPlanilla = Yii::app()->rrhh
                ->createCommand("select * from public.cuerpo_rep_vacaciongeneral('$fecha','$areasseleccionadas') ")
                ->queryAll();
        $cabeceraPlanilla = Yii::app()->rrhh
                ->createCommand("(select 1::int as orden, 'Nro' as  nombre, 'Nro' as nombref )union
(select 2::int as orden, 'NOMBRE COMPLETO' as  nombre, 'nombrecompleto' as nombref )union
(select 3::int as orden, 'FECHA VACACION' as  nombre, 'fechavacacion' as nombref )union
(select 4::int as orden, 'DIAS' as  nombre, 'dias' as nombref )union
(select 5::int as orden, 'DUODECIMAS' as  nombre, 'diasconduodecima' as nombref )union
(select 6::int as orden, 'TOTAL' as  nombre, 'total' as nombref )
order by orden asc  ")
                ->queryAll();
      
        $nombreArchivo = 'RVacAFecha_' . $fecha;
        $cantcolGeneral = 5;
        $numcol = $cantcolGeneral ;
        $columnascabecera =  $this->dameColumna('A', $numcol);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $activeSheet->setTitle($nombreArchivo);
        $activeSheet->getDefaultColumnDimension()->setWidth(9.7);
        $activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 7);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $phpFont = array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
        $phpFont1 = array('font' => array(
                'bold' => true,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            )
        );
        $phpFontC = array('font' => array(
                'bold' => true,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $phpFont2 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        ));
        $phpFont3 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        ));

        $phpFontP = array(
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
            ),);

        $activeSheet->getColumnDimension('A')->setWidth(10);
        $activeSheet->getColumnDimension('B')->setWidth(50);
        $activeSheet->getColumnDimension('C')->setWidth(20);
        $activeSheet->getColumnDimension('D')->setWidth(20);
        $activeSheet->getColumnDimension('E')->setWidth(20);
        $activeSheet->getColumnDimension('F')->setWidth(20);
        $activeSheet->getColumnDimension('G')->setWidth(11);
        $activeSheet->getColumnDimension('H')->setWidth(6);
        $activeSheet
                ->getPageMargins()->setTop(0.8);
        $activeSheet
                ->getPageMargins()->setRight(0.2);
        $activeSheet
                ->getPageMargins()->setLeft(0.2);
        $activeSheet
                ->getPageMargins()->setBottom(0.4);
        $phpColor = new PHPExcel_Style_Color();
        $phpColor->setRGB('FF0000');
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);
        $kFila = 8;
        $img = realpath(__DIR__ . '/../../../../images'); // Provide path to your logo file

        $imgot = $img . '/logoEmpresa.png';


        $objDrawingt = new PHPExcel_Worksheet_Drawing();
        $objDrawingt->setName('imgNotice');
        $objDrawingt->setDescription('Noticia');
        $objDrawingt->setPath($imgot);
        $objDrawingt->setOffsetX(5);    // setOffsetX works properly
        $objDrawingt->setOffsetY(0);  //setOffsetY has no effect
        $objDrawingt->setCoordinates('A1');
        $objDrawingt->setWidthAndHeight(140, 70);
        $objDrawingt->setResizeProportional(true);
        $objDrawingt->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
        $activeSheet->getRowDimension(7)->setRowHeight(52);
        $activeSheet->getRowDimension(1)->setRowHeight(14);
        $activeSheet->getRowDimension(2)->setRowHeight(8);
        $activeSheet->getRowDimension(3)->setRowHeight(13);
        $activeSheet->getRowDimension(4)->setRowHeight(20);
        $activeSheet->getRowDimension(5)->setRowHeight(10);
        $activeSheet->getRowDimension(6)->setRowHeight(10);

        //CABECERA DE LA PLANILLA

        $activeSheet->mergeCells('A1:'.$columnascabecera[$numcol] .'1');
        $activeSheet->mergeCells('A2:'.$columnascabecera[$numcol] .'2');
        $activeSheet->mergeCells('A3:'.$columnascabecera[$numcol] .'3');
        $activeSheet->mergeCells('A4:'.$columnascabecera[$numcol] .'4');
        $activeSheet->mergeCells($columnascabecera[$numcol-3] .'1:'.$columnascabecera[$numcol-1].'1');
        $activeSheet->mergeCells($columnascabecera[$numcol-3] .'2:'.$columnascabecera[$numcol-1].'2');
        $activeSheet->mergeCells($columnascabecera[$numcol-3] .'3:'.$columnascabecera[$numcol-1].'3');
        $activeSheet->mergeCells($columnascabecera[$numcol-3] .'4:'.$columnascabecera[$numcol-1].'4');
         
       
        $activeSheet->setCellValue('A1', strtoupper('REPORTE VACACIONES A FECHA  "' . $fecha . '"'));
        $activeSheet->setCellValue('A3', strtoupper($nombreAreas));
        $activeSheet->getStyle('A5' )->getFill('')->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array('rgb' => 'F88300')
                            ));
        $activeSheet->setCellValue('B5', 'vacación programada o en curso' );
      
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $activeSheet->setCellValue($columnascabecera[$numcol-3].'1', $datoEmpresa['direccion']);
        $activeSheet->setCellValue($columnascabecera[$numcol-3].'2', "NIT:" . $datoEmpresa['nit']);
        $activeSheet->setCellValue($columnascabecera[$numcol-3].'3', "TEL:" . $datoEmpresa['telefono'] . "   FAX:" . $datoEmpresa['fax']);
        $activeSheet->getStyle("A1")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(12);
        $activeSheet->getStyle("A1")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("A3")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(11);
        $activeSheet->getStyle("A3")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("P1:P5")->getFont()->setBold(false)
                ->setName('Times New Roman')
                ->setSize(7);
        // COLUMNAS STATICAS
        $columnasGeneral = $this->dameColumna('A', $cantcolGeneral);
        $activeSheet->getStyle("A7:CC7")->getAlignment()->setWrapText(true);
      
        $indb = 0;
       $activeSheet->getStyle('A7:F7')->applyFromArray($phpFontC);
        foreach ($cabeceraPlanilla as $cp) {
               $activeSheet->setCellValue($columnasGeneral[$indb] . '7', $cp['nombre']);
               
                ++$indb;   
               
            
        }


        ///CUERPO
        for ($i = 0; $i < count($datoPlanilla); $i++) {
            
            $inde = 0;
           
            foreach ($cabeceraPlanilla as $cp) {
                $activeSheet->getRowDimension($kFila)->setRowHeight(23);
                  $activeSheet->getStyle('D'.$kFila.':F'.$kFila )->getNumberFormat()->setFormatCode('0.00');
                    $activeSheet->getStyle($columnasGeneral[$inde] . $kFila)->applyFromArray($phpFont2);
                    if ($cp['nombref'] === 'Nro') {
                        $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, $i + 1);
                    } else {
                        if ($cp['nombref'] === 'dias' && $datoPlanilla[$i]['color']==1 ) {
                             $activeSheet->getStyle('D' . $kFila)->getFill('')->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array('rgb' => 'F88300')
                            ));
                            $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila,$datoPlanilla[$i][$cp['nombref']]);
                        }  else if ($cp['nombref'] === 'fechavacacion') {
                            $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, date("d/m/Y", strtotime($datoPlanilla[$i][$cp['nombref']])));
                        } else {
                            $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila,$datoPlanilla[$i][$cp['nombref']]);
                        }
                    }

                    ++$inde;
               

               
            }
            

            $kFila++;
        }
        
     

        
       
       
        $this->descargarExcel($objPHPExcel, $nombreArchivo);
    }
     /**
     * 
     * @param object $objPHPExcel, con la informacion del archivo que se desea generar
     * @param string $nombreArchivo, nombre del archivo con el que se va generar el archivo xls
     */
    private function descargarExcel($objPHPExcel, $nombreArchivo) {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $nombreArchivo . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setPreCalculateFormulas(true);
        $objWriter->save('php://output');
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
