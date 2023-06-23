<?php
/*
 * AreaController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 29/03/2019
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
class AreaController extends Controller
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
       
        $model=new Area;

        if(isset($_POST['Area'])){
                $model->attributes=$_POST['Area'];
                 if ($_POST['Area']['cuenta']=='') {
                $model->idcuenta=null;
            }else{
                 $model->idcuenta=$_POST['Area']['idcuenta'];                
            }
            
             
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
        $model->scenario='update';
        if(isset($_POST['Area']))
        {
             
            $model->attributes=$_POST['Area'];
            if ($_POST['Area']['cuenta']=='') {
                $model->idcuenta=null;
            }else{
                $model->idcuenta=$_POST['Area']['idcuenta'];
            }
          
            if($model->save()){
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
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

        $model=new Area('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Area'])){
                $model->attributes=$_GET['Area'];
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
     * @param string $_GET['term']
     * retorna , listado de unidades que contenga en su nombre los caracteres enviados en la variable $_GET['term'] 
     */
   public function actionAutocompleteUnidad() {
        $request = trim($_GET['term']);
        $requestMayuscula = strtoupper($request);
        if ($request != '') {
            $model = Unidad::model()->findAll(array("condition" => "nombre like '%$requestMayuscula%' ", "order" => "nombre"));
            $data = array();
            foreach ($model as $get) {
                $data[] = array(
                    'value' => $get->nombre,
                    'id' => $get->id,
                );
            }
            $this->layout = 'empty';
            echo CJSON::encode($data);
        }
    }
     /**
      * @param string $_POST['area']
      * retorna , listado de areas que contenga en su nombre los caracteres enviados en la variable $_POST['area'] 
     */
     public function actionBuscarArea()
    {
        
        $datos = Area::model()->filtraArea($_POST['area']);
        if(count($datos->getData()) == 0)
            $datos = array(
                0 => array('nombre' => $_POST['area'], 'id' => '0')
            );
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $datos,
            'columns' => array(
                array('name' => 'area', 'header' => 'Areas', 'value' => '$data->nombre'),
                array('name' => 'idarea', 'typeCol' => 'hidden', 'value' => '$data->id'),
             //   array('name' => 'idtipobancoHidden', 'typeCol' => 'hidden', 'value' => '-1'),
            ),
        ));
    }
    /**
     * @param string $_POST['cuenta']
     * retorna, un listado de cuentas contenga en su nombre o numero los caracteres enviados en la variable $_POST['cuenta']
     */
     public function actionBuscarCuenta()
    {
        
        $datos = Cuenta::model()->filtraCuenta($_POST['cuenta']);
        if(count($datos->getData()) == 0)
            $datos = array(
                0 => array('nombre' => $_POST['cuenta'], 'id' => '0')
            );
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $datos,
            'columns' => array(
                array('name' => 'cuenta', 'header' => 'Cuentas', 'value' => 'str_replace(".","",$data->numero)." - ". $data->nombre'),
                array('name' => 'idcuenta', 'typeCol' => 'hidden', 'value' => '$data->id'),
             //   array('name' => 'idtipobancoHidden', 'typeCol' => 'hidden', 'value' => '-1'),
            ),
        ));
    }
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Area the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Area::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Area $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='area-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        /**
         * @param string $_GET['term'] 
         * retorna, un listado de areas contenga en su nombre  los caracteres enviados en la variable $_GET['term']   
         */
        public function actionAutocompleteArea() {
        $request = trim($_GET['term']);
        $requestMayuscula = strtoupper($request);
        if ($request != '') {
            $model = Area::model()->findAll(array("condition" => " t.nombre like '%$requestMayuscula%'"));
            $data = array();
            foreach ($model as $get) {
                $data[] = array(
                    'value' =>$get->nombre,
                    'id' => $get->id,
                );
            }
            $this->layout = 'empty';
            echo CJSON::encode($data);
        }
    }
}
