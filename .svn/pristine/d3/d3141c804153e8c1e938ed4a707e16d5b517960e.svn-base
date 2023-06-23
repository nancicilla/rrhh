<?php
/*
 * BonosController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 21/10/2019
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
class BonosController extends Controller
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
        
        $model=new Bonos;
        $listaPuesto = array();
        if(isset($_POST['Bonos'])){
                $model->attributes=$_POST['Bonos'];
                if ($_POST['Bonos']['cuenta']=='') {
                    $model->idcuenta=null;
                }else{
                    $model->idcuenta=$_POST['Bonos']['idcuenta'];

                }
                if ($_POST['Bonos']['idbonospadre']=='') {
                    $model->idbonospadre=null;
                }else{
                    $model->idbonospadre=$_POST['Bonos']['idbonospadre'];

                }
             $model->estado=true;
             $aux= str_replace(' ','',$model->nombre);
             $aux=str_replace('-','',$aux);
             $model->nombref=$aux;
             $model->nombrefbono='calcular_'.$aux;
                if($model->save()){  
                 Puestotrabajobonos::model()->guardarPuestostrabajo($model->id,$model->estado,$_POST['gridPuestoTrabajo']);                     
                    echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {
                    echo System::hasErrors('Revise los datos! ', $model);
                return;
                }
        }

        $this->renderPartial('create',array(
            'model'=>$model,
            'listaPuesto'=>$listaPuesto,
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
        $listaPuesto= Puestotrabajobonos::model()->listaPuestotrabajo($model->id);
        if(isset($_POST['Bonos']))
        {
             $model->attributes=$_POST['Bonos'];
             $aux= str_replace(' ','',$model->nombre);
             $aux=str_replace('-','',$aux);
             $model->nombref=$aux;
             $model->nombrefbono='calcular_'.$aux;
             if ($_POST['Bonos']['cuenta']=='') {
                $model->idcuenta=null;
             }else{
                $model->idcuenta=$_POST['Bonos']['idcuenta'];

             }
             if ($_POST['Bonos']['idbonospadre']=='') {
                    $model->idbonospadre=null;
                }else{
                    $model->idbonospadre=$_POST['Bonos']['idbonospadre'];

                }
            if($model->save()){

                Puestotrabajobonos::model()->guardarPuestostrabajo($model->id,$model->estado,$_POST['gridPuestoTrabajo']);
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }

        $this->renderPartial('update',array(
            'model'=>$model,
            'listaPuesto'=>$listaPuesto,
        ), false, true);
    }
    /**
     * @param string $_POST['puesto'], nombre del puesto de trabajo 
     * retorna un listado de puesto de trabajo que contengan en su nombre el valor de la variable $_POST['puesto']
     */
    public function actionBuscarPuestotrabajo()
    {
        
        $datos = Puestotrabajo::model()->filtraPuestoTrabajo($_POST['puesto']);
        if(count($datos->getData()) == 0)
            $datos = array(
                0 => array('nombre' => $_POST['puesto'], 'id' => '0')
            );
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $datos,
            'columns' => array(
                array('name' => 'puesto', 'header' => 'Puestos de Trabajo', 'value' => '$data->nombre." (".$data->idseccion0->idarea0->idunidad0->nombre." - ".$data->idseccion0->idarea0->nombre." - ".$data->idseccion0->nombre.")" '),
                array('name' => 'idpuestotrabajo', 'typeCol' => 'hidden', 'value' => '$data->id'),
             
            ),
        ));
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

        $model=new Bonos('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Bonos'])){
                $model->attributes=$_GET['Bonos'];
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
	 * @return Bonos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Bonos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Bonos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bonos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
