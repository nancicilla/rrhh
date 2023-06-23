<?php
/*
 * AsistenciaController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 26/06/2019
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
class AsistenciaController extends Controller
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
     * Crea una un nuevo corte de planilla en funcion a las fechas de la planilla anterior
     */
    public function actionCreate()
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=new Asistencia;
        $fecha = Yii::app()->rrhh
            ->createCommand("select to_char((fechahasta+1),'DD-MM-YYYY') AS fecha   from asistencia  where estado=1 and eliminado=false limit 1 ")
            ->queryAll();
        $model->fechaic= Yii::app()->rrhh
            ->createCommand("select  to_char( dame_fechaminima(),'DD-MM-YYYY') as fecha")
            ->queryScalar();   

        $model->fechamin=date("d-m-Y",mktime(0, 0, 0, date("m")-3, 1,   date("Y")));
        $model->fechamax=date("d-m-Y",mktime(0, 0, 0, date("m"), date("d"),   date("Y")));
        if (count($fecha)==0 ) {                
             $model->scenario='mostrar';          
              
        }else{
               $model->fechadesde=$fecha[0]['fecha'];           

        }   
       

        if(isset($_POST['Asistencia'])){
             
                if ($model->fechadesde=='') {
                  $model->fechadesde=$_POST['Asistencia']['fechadesde'];
               
                }
                $usuario= Yii::app()->user->getName();


                $resp=  Yii::app()->rrhh
                  ->createCommand("select crear_corte('".$model->fechadesde."'::date,'".$_POST['Asistencia']['fechahasta']."'::date,'".$model->fechaic."'::date,'".$_POST['Asistencia']['fechafc']."'::date,true,'$usuario') as sms")
                  ->queryAll();
             echo System::hasErrors($resp[0]['sms'], $model);
                return;
        }

        $this->renderPartial('create',array(
            'model'=>$model,
        ), false, true);
    }

    /**
     * Actualiza datos del corte de planilla
     */
    public function actionActualizar()
    {
       Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $asistencia=Yii::app()->rrhh
        ->createCommand("select  *   from asistencia where eliminado=false and  estado=1 order by fechaic asc  limit 1")
        ->queryAll();

       $model=  Asistencia::model()->find('t.estado=1 ' , array('order'=>'t.fechaic asc','limit' => 1));
       if (!is_null($model)) {
          $date = date_create($model->fechadesde);
          $model->fechadesde= date_format($date, 'd-m-Y');
          $date = date_create($model->fechahasta);
          $model->fechahasta= date_format($date, 'd-m-Y');
          $date = date_create($model->fechafc);
          $model->fechafc= date_format($date, 'd-m-Y');
          $fecha = Yii::app()->rrhh
            ->createCommand("select to_char((fechahasta+1),'DD-MM-YYYY') AS fecha   from asistencia  where estado=2 and eliminado=false limit 1 ")
            ->queryAll(); 
          $date = date_create($asistencia[0]['fechaic']);
          $model->fechaic= date_format($date, 'd-m-Y');
          $model->fechamin=date("d-m-Y",mktime(0, 0, 0, date("m")-3, 1,   date("Y")));
          $model->fechamax=date("d-m-Y",mktime(0, 0, 0, date("m"), date("d"),   date("Y")));
            if (count($fecha)==0) {               
                $model->scenario='mostrar';
            
            }else{
                $model->fechadesde=$fecha[0]['fecha'];
            }   
       
       
        }
        if(isset($_POST['Asistencia'])){
           
           if ($model->fechadesde=='') {
                  $model->fechadesde=$_POST['Asistencia']['fechadesde'];
           }
            $resp=  Yii::app()->rrhh
            ->createCommand("select crear_corte('".$model->fechadesde."'::date,'".$_POST['Asistencia']['fechahasta']."'::date,'".$model->fechaic."'::date,'".$_POST['Asistencia']['fechafc']."'::date ,false) as sms")
            ->queryAll();               
        }
        $this->renderPartial('update',array(
            'model'=>$model,
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

        $model=new Asistencia('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Asistencia'])){
                $model->attributes=$_GET['Asistencia'];
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
     * @param integer $_POST['valor'], cantidad de dias que se le pagara al empleado en la planilla actual
     * @param integer $_POST['id'],el id de asistencia del empleado para la planilla actual
     */
    public function actionActualizardia()
    {
       return     Yii::app()->rrhh
            ->createCommand("update asistencia set dias=".$_POST['valor'].' where id='.SeguridadModule::dec($_POST['id']))
            ->execute();
    }
     /**
     * @param integer $_POST['valor'], factor de descuento que se le hara al  empleado en la planilla actual
     * @param integer $_POST['id'],el id de asistencia del empleado para la planilla actual
     */
     public function actionActualizarFactorDescuentoFalta()
    {
       return     Yii::app()->rrhh
            ->createCommand("update asistencia set factordescuentofalta=".$_POST['valor'].' where id='.SeguridadModule::dec($_POST['id']))
            ->execute();
    }
   /**
    * @param integer $_POST['tipoentrada'], cuyos posibles valores son 0=puntual, 11=tiempo adicional,2=atraso justificado,3=atraso personal ,8=horas a favor
    * @param integer $_POST['idtipocategoriaentrada'],funciona como filtro para el retorno del listado de elementos que pertenecen a la misma categoria
    */
    public function actionBuscarTipoentrada()
    {
        
       $datos = Tipo::model()->filtraTipo($_POST['tipoentrada'],$_POST['idtipocategoriaentrada']);
        if(count($datos->getData()) == 0)
            $datos = array(
                0 => array('nombre' => $_POST['tipoentrada'], 'idtipoentrada' => '0')
            );
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $datos,
            'columns' => array(
                array('name' => 'tipoentrada', 'header' => 'Tipos', 'value' => '$data->nombre'),
                array('name' => 'idtipoentrada', 'typeCol' => 'hidden', 'value' => '$data->id'),
            ),
        ));
    }
     /**
    * @param integer $_POST['tiposalida'], cuyos posibles valores son 0=puntual, 11=tiempo adicional,4=Salida antes justificada,5=salida antes personal ,8=horas a favor
    * @param integer $_POST['idtipocategoriasalida'],funciona como filtro para el retorno del listado de elementos que pertenecen a la misma categoria
    */
    public function actionBuscarTiposalida()
    {
        
        $datos = Tipo::model()->filtraTipo($_POST['tiposalida'],$_POST['idtipocategoriasalida']);
        if(count($datos->getData()) == 0)
            $datos = array(
                0 => array('nombre' => $_POST['tiposalida'], 'idtiposalida' => '0')
            );
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $datos,
            'columns' => array(
                array('name' => 'tiposalida', 'header' => 'Tipos', 'value' => '$data->nombre'),
                array('name' => 'idtiposalida', 'typeCol' => 'hidden', 'value' => '$data->id'),
            ),
        ));
    }
    

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Asistencia the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Asistencia::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Asistencia $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='asistencia-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        /**
         * 
         * @param string $_POST['columna'] ,nombre de la columna
         * @param float $_POST['valor'],valor al que se actualizara la columna
         * @param integer $_POST['id'],el id asientencia relacionado del empleado para la planilla actual
         */
        public function actionActualizarvalor()
            {
               return     Yii::app()->rrhh
                    ->createCommand("update asistencia set ".$_POST['columna']."=".$_POST['valor'].' where id='.SeguridadModule::dec($_POST['id']))
                    ->execute();
            }
}
