<?php
/*
 * PermisoController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 12/04/2019
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
class PermisoController extends Controller
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
        
        $model=new Permiso;

        if(isset($_POST['Permiso'])){
            $model->attributes=$_POST['Permiso'];
            $model->descripcion=$_POST['Permiso']['descripcion'];
            $model->idempleado=$_POST['Permiso']['idempleado']; 
            $model->horai=$this->verificar($_POST['Permiso']['hi']).':'.$this->verificar($_POST['Permiso']['mi']);
            $model->horaf=$this->verificar($_POST['Permiso']['hs']).':'.$this->verificar($_POST['Permiso']['ms']);
            $model->tipo=$_POST['Permiso']['tipo'];
            if ($_POST['Permiso']['tipo']=='1') {
                $model->fechaf= $model->fechai;
            }
            $observacion= Yii::app()->rrhh
                   ->createCommand("SELECT observacion_permisos_pvb(".$model->idempleado.",'".$model->fechai."'::date,'".$model->fechaf."'::date,'".$model->tipo."'::boolean,'".$model->horai."','".$model->horaf."') as sms")
            ->queryScalar();
            if($observacion==''){
            $usuario=Yii::app()->user->getName();
            $ver = Yii::app()->rrhh
                   ->createCommand("SELECT fv_registrar_permiso(".$model->idempleado.",".$model->idtipopermiso.",'".$model->fechai."'::date,'".$model->fechaf."'::date,upper('".$model->descripcion."'),'".$usuario."','".$model->horai."','".$model->horaf."','".$model->tipo."'::boolean) as sms")
            ->queryAll();
            if($ver[0]['sms']==''){
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            }
            else {
                echo System::hasErrors($ver[0]['sms'], $model);
                return;
            }}else{
                echo System::hasErrors($observacion, $model);
                return;
            }
        }

        $this->renderPartial('create',array(
            'model'=>$model,
        ), false, true);
    }

    /**
     * Updates a particular model.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=$this->loadModel(SeguridadModule::dec($id));
        $horai=explode(':',$model->horai);
        $horaf=explode(':',$model->horaf);
        $model->hi=intval($horai[0]);
        $model->mi=intval($horai[1]);
        $model->hs=intval($horaf[0]);
        $model->ms=intval($horaf[1]);  
        $model->fechai=date ("d-m-Y",strtotime( $model->fechai));
        $model->fechaf=date ("d-m-Y",strtotime( $model->fechaf));
        $intervalohoras=Yii::app()->rrhh->createCommand("select hi,mi,hs,ms from dame_horai_horas(".$model->idempleado.",'".$model->fechai."')")->queryAll()[0];
        $fechaminima= Yii::app()->rrhh->createCommand("select to_char(( select    damefechaminima_permisovacacion()),'dd-mm-YYYY')")->queryScalar();
   
        if(isset($_POST['Permiso']))
        {
            $model->attributes=$_POST['Permiso'];
            $model->hi=$_POST['Permiso']['hi'];
            $model->mi=$_POST['Permiso']['mi'];
            $model->hs=$_POST['Permiso']['hs'];
            $model->ms=$_POST['Permiso']['ms'];
            if($model->tipo=='1'){
                $model->fechaf=$model->fechai;
            }else{
                $model->tipo='0';
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
           $observacion= Yii::app()->rrhh
                    ->createCommand("SELECT observacion_permisos_pvb_update(".$model->id.",".$model->idempleado.",'".$model->fechai."'::date,'".$model->fechaf."'::date,'".$model->tipo."'::boolean,'".$model->horai."','".$model->horaf."') as sms")
                    ->queryScalar();
        if( $observacion==''){
                $resp=Permiso::model()->actualizar_permiso($model->id,$model->fechai,$model->fechaf,$model->horai,$model->horaf,$model->descripcion,$model->idtipopermiso);

                   if($resp==''){
                     echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                     return;
                 } else {
                     echo System::hasErrors($resp, $model);
                     return;
                 }
             }else{
                 echo System::hasErrors($observacion, $model);
                     return;
             }
        }
        $this->renderPartial('update',array(
            'model'=>$model,
            'intervalohoras'=>$intervalohoras,
            'fechaminima'=>$fechaminima
        ), false, true);
    }

    /**
     * Deletes safely a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
            $usuario= Yii::app()->user->getName();
            $id=SeguridadModule::dec($id);
            Yii::app()->rrhh
                ->createCommand("select dar_baja_permiso($id,'$usuario')")
                ->execute();
            self::actionAdmin();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model=new Permiso('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Permiso'])){
                $model->attributes=$_GET['Permiso'];
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
	 * @return Permiso the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Permiso::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Permiso $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='permiso-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        /**
         * @param integer $_POST['ide'] , id del empleado
         * @param boolean $_POST['tipo'], true= el permiso que va a sacar es a nivel de hora , false = el permiso que va a sacar es a nivel de dia
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
     * @param integer $_POST['idempleado'], id del empleado
     * @param date $_POST['fecha'], fecha la que se quiere analizar
     * retorna object, con la informacion 
     */
     public function actionMostrarhorario()
    {
        $idempleado=$_POST['idempleado'];
        $fecha=$_POST['fecha'];
        $intervalohoras=Yii::app()->rrhh->createCommand("select hi,mi,hs,ms from dame_horai_horas($idempleado,'$fecha')")->queryAll();
         $ver = Yii::app()->rrhh
            ->createCommand("SELECT  dame_horario_empleado($idempleado,'$fecha'::date) as sms")
            ->queryAll();
        $horario= '<div class="alert alert-info">'.$ver[0]['sms'].'</div>';
         echo CJSON::encode( array( 'horario' =>$horario ,'hi'=>$intervalohoras[0]['hi'] ,'mi'=>$intervalohoras[0]['mi'],'hs'=>$intervalohoras[0]['hs'],'ms'=>$intervalohoras[0]['ms'] ));



    }
     public function verificar($valor)
    {
        if ($valor<10) {
                    $valor='0'.intval($valor);
                }
          return $valor;      
    }
     public function actionImprimirPermisoAlCrear() {
        $idpermiso = Yii::app()->rrhh
                ->createCommand("select id from permiso where eliminado=false order by id desc  limit 1")
                ->queryScalar();

         $re = new JasperReport('/reports/RRHH/ReporteSolicitudPermiso', JasperReport::FORMAT_PDF, array(
            'p_idpermiso' => $idpermiso
        ));
        $re->exec();
        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        }
    }
    public function actionImprimirPermiso($id) {
        $idpermiso= SeguridadModule::dec($id);
     
        $re = new JasperReport('/reports/RRHH/ReporteSolicitudPermiso', JasperReport::FORMAT_PDF, array(
            'p_idpermiso' => $idpermiso
        ));
        $re->exec();
        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        } 
    }
     public function actionConstancia()
    {
       $id=$_POST['id'];       
       $model=$this->loadModel(SeguridadModule::dec($id));   
       $model->conconstancia=!$model->conconstancia;
       $model->save();
      
    }
     public function actionReportepermisosinconstancia()
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=new Permiso;
       
        if(isset($_POST['Permiso']))
        {
            Yii::app()->rrhh
                    ->createCommand("update permiso set conconstancia=".$_POST['Permiso']['conconstancia']."::boolean where id=".$model->id)
                    ->execute();
            echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
            return;
                 
            
        }
        $this->renderPartial('reporteconstancia',array(
            'model'=>$model,
            
        ), false, true);
    }
    public function actionImprimirReportePermisoSinConstancia() {
       
        $fechadesde=$_GET['Permiso']['fechai'];
        $fechahasta=$_GET['Permiso']['fechaf'];
        
        $re = new JasperReport('/reports/RRHH/PermisosSinConstancia', JasperReport::FORMAT_PDF, array(
            'p_fechadesde' => $fechadesde,
            'p_fechahasta'=>$fechahasta,
            'pUsuario' => Yii::app()->user->getName(),
        ));
        $re->exec();
        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        }  
    }
    public function actionRegistrogrupal() {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $model=new Permiso;
        $fechaminima=Yii::app()->rrhh->createCommand("   select to_char(fechahasta+1,'dd-mm-YYYY') from planilla where eliminado=false order by id desc  limit 1")->queryScalar();
        if ($fechaminima==false){
              $fechaminima=Yii::app()->rrhh->createCommand(" select '01-'||date_part('month',now())||'-'||date_part('year',now())")->queryScalar();
        }
         
        if(isset($_POST['gridEmpleados'])){         
            Permiso::model()->RegistroGrupal($_POST['gridEmpleados'],$_POST['Permiso']['fechai'],$_POST['Permiso']['dias'],$_POST['Permiso']['jornada'],$_POST['Permiso']['observacion'],$_POST['Permiso']['idtipopermiso']);
                        
                  
        }
        $listaempleados=array();
        $this->renderPartial('registrogrupal',array(
            'model'=>$model,
            'listaempleados'=>$listaempleados,
            'fechaminima'=>$fechaminima,
        ), false, true);
    }
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
public function actionListaempleadosregistrogrupal(){
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
        
      
        
        $listaempleados=  Yii::app()->rrhh->createCommand("select e.id, p.nombrecompleto,(case when(select public.observacion_diasdescontarpermiso("
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
}
