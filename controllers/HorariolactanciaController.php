<?php
/*
 * HorariolactanciaController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 24/01/2022
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
class HorariolactanciaController extends Controller
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
        
        $model=new Horariolactancia;

        if(isset($_POST['Horariolactancia'])){
                $model->attributes=$_POST['Horariolactancia'];
                if($model->save()){                       
                    echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {
                    echo System::hasErrors('Revise los datos! ', $model);
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
        $model->fechadesde= date("d-m-Y",strtotime( $model->fechadesde));
        $cuerpohorario=Cuerpohorariolactancia::model()->listaHorarios($model->id);
        $fechaminima= Yii::app()->rrhh
                    ->createCommand("select to_char((select dame_fechaminimacorte()),'dd-mm-YYYY')")
                    ->queryScalar(); 
        if(isset($_POST['Horariolactancia']))
        {
            $model->attributes=$_POST['Horariolactancia'];
            if($model->save()){
                 
                 $cadena=Horariolactancia::model()->actualizarDatosHorarioLactancia($model->idsubsidio, $model->id,$model->idsubsidio0->idempleado, $model->fechadesde, $_POST['gridHorasTrabajo']);
                    if ($cadena==''){
                      echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                      return;
                    
                    }
                    else {
                        echo System::hasErrors($cadena, $model);
                        return;
                    }
            }else {
                        echo System::hasErrors('Revise sus datos !!', $model);
                        return;
                    }
          }

        $this->renderPartial('update',array(
            'model'=>$model,
            'cuerpohorario'=>$cuerpohorario,
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
            $model=$this->loadModel(SeguridadModule::dec($id));
            $idempleado=$model->idsubsidio0->idempleado;
            $fechadesde=$model->fechadesde;          
            $usuario = Yii::app()->user->getName();        
            $model->safeDelete();
                      Yii::app()->rrhh
            ->createCommand("select   public.resetear_selladas_lactancia( $idempleado ,  '$fechadesde'::date,'POR ELIMINACION DE HORARIO LACTANCIA', '$usuario' )")->execute(); 
         
            self::actionAdmin();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model=new Horariolactancia('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Horariolactancia'])){
                $model->attributes=$_GET['Horariolactancia'];
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
	 * @return Horariolactancia the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Horariolactancia::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Horariolactancia $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='horariolactancia-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        /**
         * 
         * @param integer $id,id del horario 
         * retorna un interfaz para ver el horario que tiene asignado
         */
        public function actionHorarioLactancia($id)
        {
            Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);

            $model=$this->loadModel(SeguridadModule::dec($id));
            $cuerpohorario=Cuerpohorariolactancia::model()->listaHorarios($model->id);
            $this->renderPartial('horariolactancia',array(
                'model'=>$model,
                'cuerpohorario'=>$cuerpohorario
            ), false, true);
        }
         public  function actionHorarioespecial(){
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $model=new Horario;     
        $fechaminima= Yii::app()->rrhh
                    ->createCommand("select to_char((select dame_fechaminimacorte()),'dd-mm-YYYY')")
                    ->queryScalar();
        
        $listaempleado= Yii::app()->rrhh
                    ->createCommand("select e.id, p.nombrecompleto,false as seleccionar  from subsidio s inner join general.empleado e on e.id=s.idempleado inner join general.persona p on p.id=e.idpersona where s.eliminado=false and s.activo=true and fechahasta>='".$fechaminima."'  and fechahasta >=now()::date")
                    ->queryAll(); 
        if (isset( $_POST['Horariolactancia'])) {
                  
            Horariolactancia::model()->registrarHorarioEmpleado($_POST['gridHorasTrabajo'],$_POST['gridEmpleados'],$_POST['Horariolactancia']['fechadesde'],$_POST['Horariolactancia']['fechahasta']);
                           
              
                    
            echo System::dataReturn('exitosa!', array('id' => SeguridadModule::enc($model->id)));
                      return;

        }
       $this->renderPartial('horarioespecial',array(
           'model'=>$model,
           'listaempleado'=>$listaempleado,
           'fechaminima'=>$fechaminima
        ), false, true);
    }
}
