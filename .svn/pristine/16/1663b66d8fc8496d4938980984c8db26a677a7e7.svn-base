<?php
/*
 * DependienteController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 08/05/2019
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
class DependienteController extends Controller
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
        
        $model=new Dependiente;
        $listadeducciones=array();
        $fecha=Yii::app()->rrhh
        ->createCommand("select case when estado=1 then to_char(fechadesde,'dd-mm-YYYY') else to_char(fechahasta+1,'dd-mm-YYYY') end  from planilla where eliminado=false order by id desc limit 1
        ")
        ->queryScalar();
        if ($fecha==null){
            $fecha=date("d-m-Y");
        }    
        if(isset($_POST['Dependiente'])){
                $model->attributes=$_POST['Dependiente'];
                if(Dependiente::model()->registrarDeduccionesEmpleado ($_POST['Dependiente']['deduccion'],$_POST['Dependiente']['fecha'],$_POST['Dependiente']['fechafin'],$_POST['Dependiente']['descripcion'],$_POST['gridListaDeduccion'])){                       
                    echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {
                    echo System::hasErrors('Revise los datos! ', $model);
                return;
                }
        }

        $this->renderPartial('create',array(
            'model'=>$model,
            'fecha'=>$fecha,
            'listadeducciones'=>$listadeducciones
        ), false, true);
    }
    /**
     * @param string $_POST['nombrecompleto'], parte del nombre completo del empleado
     * retorna un listado de empleados que contengan en su nombre completo el vlor del la variable $_POST['nombrecompleto']
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
                array('name' => 'ci', 'typeCol' => 'hidden', 'value' => '$data->ci.($data->complementoci==""?"":"-".$data->complementoci)'),
             //   array('name' => 'idtipobancoHidden', 'typeCol' => 'hidden', 'value' => '-1'),
            ),
        ));
    }

    /**
     * Updates a particular model.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=$this->loadModel(SeguridadModule::dec($id));

        if(isset($_POST['Dependiente']))
        {
            $model->attributes=$_POST['Dependiente'];
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
            $nameSaveTemp = 'protected/modules/rrhh/tmp/DeduccionesUpload' . rand(100, 999999) . '.' . $nameFile[sizeof($nameFile) - 1];
            file_put_contents($nameSaveTemp, file_get_contents("php://input"));
        }
        
        header('Content-Type: text/plain; charset=utf-8');
        echo $ddd = self::cargarExcelaGrid($nameSaveTemp);
        unlink($nameSaveTemp);
    }
    /**
     * 
     * @param file $inputFileName, archivo con la informacion de empleados (nombre,ci,monto)
     * @return la lista de empleados del archivo
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
        
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        
        $listadeducciones = array();
        $errorFormato = '';
        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray('A' . $row . ':' . 'C' . $row, null, true, false);
             $estado=Yii::app()->rrhh
        ->createCommand(" select case when (select hee.activo from general.historialestadoempleado hee inner join general.empleado e on e.id=hee.idempleado inner join general.persona p on p.id=e.idpersona where hee.eliminado=false and case when  complementoci='' then ci::text else ci||'-'||complementoci end ='".$rowData[0][1]."' order by hee.id desc limit 1)=1 then -1 else 
2 end  ")
        ->queryScalar();
            $listadeducciones[] = array(
                'nombrecompleto'=>$rowData[0][0],
                'ci' => $rowData[0][1],
                'monto' => $rowData[0][2],
                'estado'=>$estado
               
            );
        }
        
        return $this->renderPartial('listadeducciones', array('listadeducciones' => $listadeducciones), true) .
                '<div class="errorFormato" style="display:none">' . $errorFormato . '</div>';
    }


    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model=new Dependiente('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Dependiente'])){
                $model->attributes=$_GET['Dependiente'];
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
	 * @return Dependiente the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Dependiente::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Dependiente $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='dependiente-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
