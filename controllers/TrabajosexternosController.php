<?php
/*
 * TrabajosexternosController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 26/10/2021
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
class TrabajosexternosController extends Controller
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
        
        $model=new Trabajosexternos;

        if(isset($_POST['Trabajosexternos'])){
                $model->attributes=$_POST['Trabajosexternos'];
                $model->hi=$_POST['Trabajosexternos']['hi'];
                $model->mi=$_POST['Trabajosexternos']['mi'];
                $model->hs=$_POST['Trabajosexternos']['hs'];
                $model->ms=$_POST['Trabajosexternos']['ms'];
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
                $model->horainicio=$model->hi.':'.$model->mi;
                $model->horafin=$model->hs.':'.$model->ms;
                if($_POST['Trabajosexternos']['descripcion'] ==null)
                $model->descripcion='';
                   else
                 $model->descripcion=strtoupper($_POST['Trabajosexternos']['descripcion']);
                  $observacion= Yii::app()->rrhh
                   ->createCommand("SELECT observacion_permisos_pvb(".$model->idempleado.",'".$model->fechadesde."'::date,'".$model->fechahasta."'::date,'".$model->tipo."'::boolean,'".$model->horainicio."','".$model->horafin."') as sms")
            ->queryScalar();
                if ($observacion==''){
                    Trabajosexternos::model()->registrarTrabajoExterno($model);
                if(true){                       
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
     * Updates a particular model.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=$this->loadModel(SeguridadModule::dec($id));
        $tipo=$model->tipo;
        $fecha=Yii::app()->rrhh->createCommand("select  public.dame_fechaminima()")->queryScalar();
        $ver = Yii::app()->rrhh
            ->createCommand("SELECT  dame_horario_empleado(". $model->idempleado.",'".$model->fechadesde."'::date) as sms")
            ->queryAll();
        $horario= '<div class="alert alert-info">'.$ver[0]['sms'].'</div>';
        $intervalohoras=Yii::app()->rrhh->createCommand("select hi,mi,hs,ms from dame_horai_horas($model->idempleado,'$model->fechadesde')")->queryAll();
        $model->fechadesde=date('d-m-Y',strtotime($model->fechadesde));
        $model->fechahasta=date('d-m-Y',strtotime($model->fechahasta));
        $horai=explode(':', $model->horainicio) ;
        $horaf=explode(':', $model->horafin) ;
        $model->hi=intval($horai[0]);
        $model->mi=intval($horai[1]);
        $model->hs=intval($horaf[0]);
        $model->ms=intval($horaf[1]);

        if(isset($_POST['Trabajosexternos']))
        {
            $model->attributes=$_POST['Trabajosexternos'];
             
                if($model->tipo==true){
                    $model->hi=$_POST['Trabajosexternos']['hi'];
                    $model->mi=$_POST['Trabajosexternos']['mi'];
                    $model->hs=$_POST['Trabajosexternos']['hs'];
                    $model->ms=$_POST['Trabajosexternos']['ms'];
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
                $model->horainicio=$model->hi.':'.$model->mi;
                $model->horafin=$model->hs.':'.$model->ms;
                if($_POST['Trabajosexternos']['descripcion'] ==null)
                $model->descripcion='';
                else
                $model->descripcion=strtoupper($_POST['Trabajosexternos']['descripcion']);
                    $observacion= Yii::app()->rrhh
                    ->createCommand("SELECT observacion_permisos_pvb_update(".$model->id.",".$model->idempleado.",'".$model->fechadesde."'::date,'".$model->fechahasta."'::date,'".$model->tipo."'::boolean,'".$model->horainicio."','".$model->horafin."') as sms")
                    ->queryScalar();
                if ($observacion==''){    
                  $respuesta=  Trabajosexternos::model()->actualizarTrabajoexterno($model);
                    if($respuesta==''){
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors($respuesta, $model);
                return;
                  }
                }
                else{
                   echo System::hasErrors($observacion, $model);
                return;
                }
        }

        $this->renderPartial('update',array(
            'model'=>$model,
            'horario'=>$horario,
            'fechaminima'=>$fecha,
            'intervalohoras'=>$intervalohoras
        ), false, true);
    }

    /**
     * Deletes safely a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
     public function actionDelete($id)
    {   $usuario= Yii::app()->user->getName();
        $id=SeguridadModule::dec($id);
         
         Yii::app()->rrhh
                ->createCommand("select dar_baja_trabajoexterno($id,'$usuario')")
                ->execute();
        self::actionAdmin();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model=new Trabajosexternos('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Trabajosexternos'])){
                $model->attributes=$_GET['Trabajosexternos'];
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
	 * @return Trabajosexternos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Trabajosexternos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Trabajosexternos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='trabajosexternos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        /**
         * @param integer $_POST['ide'], id del empleado
         * retorna la fecha minima a la que podemos registrar un nuevo registro a cuenta de trabajo externo
         */
        public function actionDameInformacionEmpleado()
        {   $idempleado=$_POST['ide'];   
            $fechaminima= Yii::app()->rrhh->createCommand("select to_char((select   damefechaminima_permisovacacion($idempleado,1)),'dd-mm-YYYY')")->queryScalar();
            $r=Yii::app()->rrhh->createCommand("select count( damemovimiento_fecha(now():: date,$idempleado)) as r")->queryScalar();
              if ($r==0) {
                $resp[0]['observacion']='<div class="alert alert-info">NO TIENE ASIGNADO UN HORARIO...</div>';
              }

             echo CJSON::encode( array('fechaminima'=>$fechaminima  ));
        }
        /**
         * @param integer $_POST['idempleado'], id del empleado
         * @param date $_POST['fecha'], fecha  de la que estamos analizando
         * retorna array , con la informacion del horario asignado en la fecha $_POST['fecha'] y los minutos minimos y maximos que tiene en esa jornada
         */
    public function actionMostrarhorarioFecha()
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
}
