<?php
/*
 * TmpentradasalidaController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 23/12/2019
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
class TmpentradasalidaController extends Controller
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
        
        $model=new Tmpentradasalida;
        $lista=array();

        if(isset($_POST['gridListaImportacion'])){
                Tmpentradasalida::model()->registrarAsistencia($_POST['gridListaImportacion']);

                /*
                if($model->save()){                       
                    echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {
                    echo System::hasErrors('Revise los datos! ', $model);
                return;
                }*/
        }

        $this->renderPartial('create',array(
            'model'=>$model,
            'lista'=>$lista
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

        if(isset($_POST['Tmpentradasalida']))
        {
            $model->attributes=$_POST['Tmpentradasalida'];
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
     * guarda fisicamente el archivo a subir
     */
public function actionSubirArchivoExcel() {
        ob_start();
        $callback = &$_REQUEST['fd-callback'];
        
        // Upload data can be POST'ed as raw form data or uploaded via <iframe> and <form>
        // using regular multipart/form-data enctype (which is handled by PHP $_FILES).
        if (!empty($_FILES['fd-file']) and is_uploaded_file($_FILES['fd-file']['tmp_name'])) {
            // Regular multipart/form-data upload.
            $name = $_FILES['fd-file']['name'];
            $data = file_get_contents($_FILES['fd-file']['tmp_name']);
        } else {
            // Raw POST data.
            $name = urldecode(@$_SERVER['HTTP_X_FILE_NAME']);
            $data = file_get_contents("php://input");
            $nameFile = explode('.', $name);
            $nameSaveTemp = 'protected/modules/rrhh/tmp/PulperiaUpload' . rand(100, 999999) . '.' . $nameFile[sizeof($nameFile) - 1];
            file_put_contents($nameSaveTemp, file_get_contents("php://input"));
        }
        
        header('Content-Type: text/plain; charset=utf-8');
        echo $ddd = self::cargarExcelaGrid($nameSaveTemp);
        unlink($nameSaveTemp);
    }
     /**
     * 
     * @param file $inputFileName,archivo con la informacion de empleados ,montos a asignar al bono
     * @return lista de empleados del archivo 
     */
    public function cargarExcelaGrid($inputFileName) {
        include('protected/extensions/PHPExcel/Classes/PHPExcel/IOFactory.php');
        
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": '.$e->getMessage());
        }
        //PHPExcel_Shared_Date::isDateTime($cell)
        // $this->startTime = date('d.m.Y h:m',    PHPExcel_Shared_Date::ExcelToPHP($startTime)); 
      
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        
        $lista = array();
        $errorFormato = '';
        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray('A' . $row . ':' . 'B' . $row, null, true, false);
            //$rowData[0][1]
            $lista[] = array(
                'ci' => $rowData[0][1],
                 
                'sellada' => PHPExcel_Style_NumberFormat:: toFormattedString ($rowData[0][0], "D/M/YYYY H:i ")
               
            );
        }
        
        return $this->renderPartial('_tabla', array('lista' => $lista), true) .
                '<div class="errorFormato" style="display:none">' . $errorFormato . '</div>';
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

        $model=new Tmpentradasalida('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Tmpentradasalida'])){
                $model->attributes=$_GET['Tmpentradasalida'];
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
	 * @return Tmpentradasalida the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Tmpentradasalida::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Tmpentradasalida $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tmpentradasalida-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
