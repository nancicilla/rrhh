<?php
/*
 * SeguimientoempleadoController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 15/06/2021
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
class SeguimientoempleadoController extends Controller
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
        
        $model=new Seguimientoempleado;

        if(isset($_POST['Seguimientoempleado'])){
                $model->attributes=$_POST['Seguimientoempleado'];
              
                $model->registrarSeguimiento($model->idcrugeuser, $_POST['gridEmpleados']);
                 echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
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
        $id=SeguridadModule::dec($id);
      
        $model= new Seguimientoempleado;
       
        $lista= Yii::app()->rrhh
                        ->createCommand("select e.id,p.nombrecompleto ,2 as estado from general.persona p inner join general.empleado e on e.idpersona=p.id inner join general.seguimientoempleado s on s.idempleado=e.id inner join ftbl_usuario_web_cruge_user cu on cu.iduser=s.idcrugeuser 
        where p.eliminado=false and e.eliminado=false and s.eliminado=false and s.idcrugeuser =(select idcrugeuser from  general.seguimientoempleado where id=$id)  order by p.nombrecompleto asc")->queryAll();
        
        if(isset($_POST['Seguimientoempleado']))
        {
            $model->attributes=$_POST['Seguimientoempleado'];
            $model->guardarCambios($id, $_POST['gridEmpleados']);
            echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
        }

        $this->renderPartial('update',array(
            'model'=>$model,
            'lista'=>$lista
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

        $model=new Seguimientoempleado('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Seguimientoempleado'])){
                $model->attributes=$_GET['Seguimientoempleado'];
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
	 * @return Seguimientoempleado the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Seguimientoempleado::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Seguimientoempleado $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='seguimientoempleado-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        /**
         * @param string $_GET['term'], nombre o parte del nombre de usuario
         * retorna lista de usuarios que contenga en su nombre $_GET['term']
         */
        public function actionAutocompleteUsuario(){
            $request = trim($_GET['term']);
            $request = strtolower($request);
            if ($request != '') {
                $usuarios= Yii::app()->rrhh
                            ->createCommand("select iduser as id,username as value from ftbl_usuario_web_cruge_user where username like'%$request%' ")->queryAll();


                $this->layout = 'empty';
                echo CJSON::encode($usuarios);
            }
    }
    /**
     * @param string $_POST['nombrecompleto'], nombre completo o parte del nombre completo del empleado
     * retorna lista de empleado que contengan en su nombre comple a $_POST['nombrecompleto']
     */
     public function actionBuscarEmpleado()
    {
        
        $datos = Persona::model()->filtraPersonaAutSeguimiento($_POST['nombrecompleto']);
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
}
