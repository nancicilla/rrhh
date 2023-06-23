<?php
/*
 * EntradasalidaController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 15/08/2019
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
class EntradasalidaController extends Controller
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
        
        $model=new Entradasalida;
        $fechaminima=Yii::app()->rrhh->createCommand("select to_char((fechafc +1),'dd-mm-YYYY') as fecha from planilla where eliminado=false order by id desc limit 1")->queryScalar();
 
   
        if(isset($_POST['Entradasalida'])){
            
                $model->attributes=$_POST['Entradasalida'];
               
          $respuesta=  Entradasalida::model()->registrarEntradaSalida($_POST['Entradasalida']['fechaparametro'],$_POST['Entradasalida']['hi'],$_POST['Entradasalida']['mi'],$_POST['Entradasalida']['idempleado']);
          if ($respuesta=='') {
              echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
          }else{
            echo System::hasErrors($respuesta, $model);
                return;
          }
                 
               
        }

        $this->renderPartial('create',array(
            'model'=>$model,
            'fechaminima'=>$fechaminima
        ), false, true);
    }

    /**
     * Updates a particular model.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
       
      
     
        $model= new Entradasalida;
        

        $this->renderPartial('update',array(
            'model'=>$model,
            'horarios'=>$horarios,
              'listaentradasalida'=>$entradassalidas,
        ), false, true);
    }

    /**
     * Deletes safely a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
      
       $dato= explode(' ',$id) ;
       $id=SeguridadModule::dec($dato[0]);
       $usuario=Yii::app()->user->getName();
       Yii::app()->rrhh ->createCommand("select public.dar_bajasellada($id ,'E',  '$usuario') ") ->execute();
           
       $model=$this->loadModel($id);      
       $model->eliminado=true;
       $model->save();
            self::actionAdmin();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model=new Entradasalida('search');

        $model->unsetAttributes();  // clear any default values
      
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Entradasalida'])){
                $model->attributes=$_GET['Entradasalida'];
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
  * retorna un formulario para la importacion de selladas
  */
     public function actionImportarasistencia()
     {
        $model= new Tmpentradasalida;
        $lista = array( );
        if (isset($_POST['gridListaImportacion'])) {
            Tmpentradasalida::model()->registrarAsistencia($_POST['gridListaImportacion']);
        }
        $this->renderPartial('_frmImportar',array(
            'model'=>$model,
            'lista'=>$lista,
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
            $nameSaveTemp = 'protected/modules/rrhh/tmp/ESUpload' . rand(100, 999999) . '.' . $nameFile[sizeof($nameFile) - 1];
            file_put_contents($nameSaveTemp, file_get_contents("php://input"));
        }
        
        header('Content-Type: text/plain; charset=utf-8');
        echo $ddd = self::cargarExcelaGrid($nameSaveTemp);
        unlink($nameSaveTemp);
    }
    /**
     * 
     * @param file $inputFileName,archivo con la informacion de empleados y su sellada
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
        
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        
        $lista = array();
        $errorFormato = '';
        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray('A' . $row . ':' . 'B' . $row, null, true, false);
            $f=(string) $rowData[0][0]; //strftime("%d de %B de %Y", strtotime($rowData[0][0]));
            $lista[] = array(
                'sellada' =>  $f ,
                'ci' => $rowData[0][1],
               
            );
        }
        
        return $this->renderPartial('_tablaAsistencia', array('lista' => $lista), true) .
                '<div class="errorFormato" style="display:none">' . $errorFormato . '</div>';
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Entradasalida the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Entradasalida::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Entradasalida $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='entradasalida-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
    }
   
    

    private function descargarExcel($objPHPExcel, $nombreArchivo)
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$nombreArchivo.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setPreCalculateFormulas(true);
        $objWriter->save('php://output');
    }
    /**
     * 
     * retorna fromulario de seguimiento avanzado de asistencia 
     */
    public function actionSeguimiento()
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=new Entradasalida;
        $model->fechadesde=date('d-m-Y');
        $model->fechahasta=date('d-m-Y');
        $model->mostrartodo=false;
        $ltipocontratos = Tipocontrato::model()->findAll();
        
         $listaempleado= Yii::app()->rrhh
                ->createCommand("select t.nombrecompleto as id,t.nombrecompleto  from (select p.nombrecompleto as id,p.nombrecompleto ,case when 
                    ( hee.activo=0 and hee.fecharetiro =now()::date   )then 'R' when (hee.activo=1 and hee.fecharetiro<=now()::date)then 'A' else '' end  as estado from general.persona p inner join general.empleado e1 on p.id=e1.idpersona 
                    inner join general.historialestadoempleado hee on hee.idempleado=e1.id where
                    hee.eliminado=false  and e1.analizarsellada=true and  hee.id in(
                    select ((select max(id) from general.historialestadoempleado he where he.eliminado=false and he.idempleado=e.id  and fecharetiro<=now()::date       ) 
                    )from general.empleado e )) as t where t.estado='A' order by nombrecompleto asc ")
                ->queryAll();
          $listacontratos=Yii::app()->rrhh
        ->createCommand("select STRING_AGG (id::text, ',') from general.tipocontrato where eliminado=false  ")
        ->queryScalar();
        $lista=Yii::app()->rrhh
        ->createCommand("select nombrecompleto,fecha,identradasalida,entrada,difentrada,idtipoentrada,horarelacionadaentrada, tipoentrada,entradamanual,horarelacionadaespecialentrada,  observacionentrada,salida,difsalida,idtiposalida,horarelacionadasalida, tiposalida,salidamanual,idtipocategoriaentrada,idtipocategoriasalida ,horarelacionadaespecialsalida,  observacionsalida from  dame_seguimento_asistencia_entre_fechas_tipo (now()::date,now()::date ,'','','',14,false,'$listacontratos'::text) order by fecha::date,entrada desc
        ")
        ->queryAll();
        
     
        if(isset($_POST['Entradasalida'])){
            
                $model->attributes=$_POST['Entradasalida'];
               
          $respuesta=  Entradasalida::model()->registrarEntradaSalida($_POST['Entradasalida']['fechaparametro'],$_POST['Entradasalida']['hi'],$_POST['Entradasalida']['mi'],$_POST['Entradasalida']['idempleado']);
          if ($respuesta=='') {
              echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
          }else{
            echo System::hasErrors($respuesta, $model);
                return;
          }
                 
               
        }

        $this->renderPartial('seguimiento',array(
            'model'=>$model,
            'lista'=>$lista,
            'listaempleado'=>$listaempleado,
            'ltipocontratos'=>$ltipocontratos
        ), false, true);
    }
    /**
   
     * retorna formulario de asistencia para las jefes de area
     */
    public function actionCambiarevento()
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=new Entradasalida;
        $model->fechadesde=date('d-m-Y');
        $model->fechahasta=date('d-m-Y');
        $usuario=Yii::app()->user->getName();       
        $lista=array();
        if(isset($_POST['Entradasalida'])){           
            
            $model->attributes=$_POST['Entradasalida'];              
               
            $respuesta=  Entradasalida::model()->cambiarEntradaSalidaGrupo($_POST['Entradasalida']['evento'],$_POST['Entradasalida']['cambiara'],$_POST['gridLista']);
          if ($respuesta=='') {
                     echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                return;
          }else{
            echo System::hasErrors($respuesta, $model);
                return;
          }
                 
               
        }

        $this->renderPartial('cambiarevento',array(
            'model'=>$model,
            'lista'=>$lista
        ), false, true);
    }
    /**
     * @param string $_POST['opcion'], posibles valores ,entrada,salida,fecha
     * @param string $_POST['orden'], posibles valores asc o desc
     * @param date $_POST['desde'] ,fecha desde 
     * @param date $_POST['hasta'], fecha hasta
     * @param integer $_POST['area'],id del area seleccionada
     * @param string $_POST['cargo'], nombre o parte del nombre del cargo vigente
     * @param string $_POST['empleado'], nombre completo del empleado
     * @param integer $_POST['tipoobservacion'],cuyos valores posibles son : 14=Análisis de Asistencia,15=Análisis de Asistencia y Ausencias,3=Atraso Personal,2=Atraso Justificado,17=Turno Incompleto,12=Falta,8=Horas a Favor,4=Salida Antes Autorizada,5=Salida Antes Personal y 11=Tiempo Adicional

     * retorna la lista de asistencia de los empleados entre la fecha desde y hasta, con los parametros anteriores
     */
   public function actionDamelistaasistenciatipo()
   {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
         $opcion=$_POST['opcion'];
         $orden=$_POST['orden'];
         $tipocontrato=$_POST['tipocontrato'];
         if($tipocontrato!==''){
             $tipocontrato= substr($tipocontrato, 0, -1);
         }else{
             $tipocontrato='0';
         }
         $lista=Yii::app()->rrhh
        ->createCommand("select nombrecompleto,fecha,identradasalida,entrada,difentrada,idtipoentrada,horarelacionadaentrada,idtipocategoriaentrada , tipoentrada,entradamanual,horarelacionadaespecialentrada, observacionentrada,salida,difsalida,idtiposalida,horarelacionadasalida,tiposalida,idtipocategoriasalida,salidamanual ,horarelacionadaespecialsalida,  observacionsalida from  dame_seguimento_asistencia_entre_fechas_tipo
         ('".$_POST['desde']."'::date,'".$_POST['hasta']."'::date ,'".$_POST['area']."','".$_POST['cargo']."','".$_POST['empleado']."',".$_POST['tipoobservacion'].",'".$_POST['mostrartodo']."'::boolean,'$tipocontrato'::text) order by $opcion  $orden ")
        ->queryAll();
         $this->renderPartial('_formtiposeguimiento',array(       
            'lista'=>$lista,
            'nombre'=>$_POST['nombre'],
        ), false, true); 
   }
   /**
    *@param string $_POST['entrada'],cuyos posibles valores son: E=entrada o S=salida
    * @param  integer $_POST['min'], la diferencia de minutos de la sellada de entrada con el la hora de entreda del turno
    * @param integer $_POST['identradasalida'],id de la sellada de entrada
    */
   public function actionActualizarminutossellada()
   {
       $es=$_POST['entrada'];
       $min=$_POST['min'];
       $id=$_POST['identradasalida'];
       if ($id!=''){
       $usuario=Yii::app()->user->getName();
       Yii::app()->rrhh ->createCommand(" select  actualizar_minuto($id, $min , '$es' ,'$usuario')") ->execute();
       }
    

    }/**
     * @param integer $_POST['tipoentrada'],posibles valores son : 0=puntual,2=Atraso Justificado,3=Atraso Personal,4=Salida Antes Autorizada,5=Salida Antes Personal,8=Horas a Favor y 11=Tiempo Adicional
     * @param time $_POST['horaentrada'],sellada de entrada
     * @param time $_POST['horasalida'], sellada de salida
     * @param integer $_POST['identradasalida'], id de las selladas de entrada y salida
     */
    public function actionActualizartiposellada()
    {
        $tipoentrada=$_POST['tipoentrada'];
        $horaentrada=$_POST['horaentrada'];
        $horasalida=$_POST['horasalida'];
        if ($_POST['tiposalida']!="")
        $tiposalida=$_POST['tiposalida'];
        else
        $tiposalida=0;
        
        $id=$_POST['identradasalida'];
        if ($id!=''){
        
        $usuario=Yii::app()->user->getName();
        Yii::app()->rrhh ->createCommand(" select  actualizar_tiposelladaavanzado($id, $tipoentrada , $tiposalida,'$horaentrada'::text,'$horasalida'::text ,'$usuario')") ->execute();
        }
      
   
     
    }
    /**
     * @param string $_POST['entrada'],cuyos posibles valores son: E=entrada o S=salida
     * @param time $_POST['hora'],la nueva hora a actualizar
     * @param integer $_POST['identradasalida'],id de la la hora que se quiere modificar
     */
    public function actionActualizarhorasellada()
   {
       $es=$_POST['entrada'];
       $hora=$_POST['hora'];
       $id=$_POST['identradasalida'];
       if ($id!=''){
       $usuario=Yii::app()->user->getName();
       Yii::app()->rrhh->createCommand("select actualizar_hora($id, '$hora'::time,'$es','$usuario') ") ->execute();
       
       }
    }
    /**
     * @param object $_GET['Entradasalida'],contiene todas las configuraciones que se se ven en la interfaz de seguimiento avanzado
    
     * retorna un reporte en base a los parametros que se pasan en $_GET['Entradasalida']
     */
     public function actionReporteasistencia()
{       $getDato = $_GET['Entradasalida'];
        $fechadesde = $getDato['fechadesde'];
        $fechahasta = $getDato['fechahasta'];
        $p_conpersonalretirado=$getDato['mostrartodo'];
        $cadenatipocontrato='';
        $tipos='';
        if (isset($_GET['tipocontrato'])){
            
        $tipos=$_GET['tipocontrato'];
          for ($i = 0; $i < count($tipos); $i++) {
                        $cadenatipocontrato = $cadenatipocontrato. $tipos[$i] . ',';
                    }
                     $cadenatipocontrato = substr($cadenatipocontrato, 0, -1); 
        }else{
            $cadenatipocontrato='0';
        }     
       
      
       
        
        if  (isset( $getDato['area'])){
            $area = trim( strtoupper( $getDato['area']));
            if ($area==''){
                $area='*';
            }
        }else
        {$area='*';

        }
        if (isset(  $getDato['cargo'])){
            $cargo =trim(strtoupper( $getDato['cargo']));
            if ($cargo==''){
                $cargo='*';
            }
        }else
        {
            $cargo = '*';
        }
        if (isset($getDato['empleado'])){
            $empleado =trim( strtoupper( $getDato['empleado']));
            if ($empleado==''){
                $empleado='*';
            }
        }else
        { 
            $empleado = '*';

        }       
        
        $idtipo=$getDato['tipoobservacion'];
        $horasasitidas=$getDato['horaasistida'];
        $horaextra=$getDato['horaextra'];
        $minatraso=$getDato['minatraso'];
        $minsalida=$getDato['minsalida'];
        $usuario=Yii::app()->user->getName();
       
       $re = new JasperReport('/reports/RRHH/ReporteAsistencia', JasperReport::FORMAT_PDF, array(
            'p_fechadesde' => $fechadesde,             
            'p_fechahasta'=>$fechahasta,           
            'p_cargo'=>$cargo,
            'p_area'=>$area,
            'p_empleado'=> $empleado,
            'p_tipo'=>$idtipo,
           'p_horasasistidas'=>$horasasitidas,           
           'p_horaextra'=>$horaextra,
           'p_minatraso'=>$minatraso,
           'p_minsalida'=>$minsalida,
           'p_conpersonalretirado'=>$p_conpersonalretirado,
           'p_tipocontrato'=>$cadenatipocontrato,
           'pUsuario'=>$usuario
            
        ));
        $re->exec();                                
        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        }
        
}
 /**
  * @param string $_GET['term'],nombre completo o parte del nombre completo del empleado
  * retorna un listado de empleados cuyos nombres completo contenga a $_GET['term']
  */  
 public function actionAutocompleteEmpleado() {
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
     * @param date $_GET['Entradasalida']['fechadesde'], fecha desde la cual se quiere el reporte 
     * @param date $_GET['Entradasalida']['fechahasta'], fecha hasta la cual se quiere el reporte
     *  retorna un reporte(xls) de asientencia de todos los empleados vigentes 
     */
    public function actionDescargarExcelReporteHorasAsistidas()
    {
        $fechadesde=$_GET['Entradasalida']['fechadesde'];
        $fechahasta=$_GET['Entradasalida']['fechahasta'];
        $fila=4;
        $nombre='Ejemplo';
        $cadenatipocontrato='';
        $tipos='';
        if (isset($_GET['tipocontrato'])){
            
        $tipos=$_GET['tipocontrato'];
          for ($i = 0; $i < count($tipos); $i++) {
                        $cadenatipocontrato = $cadenatipocontrato. $tipos[$i] . ',';
                    }
                     $cadenatipocontrato = substr($cadenatipocontrato, 0, -1); 
        }else{
            $cadenatipocontrato='0';
        }
        $datos=Yii::app()->rrhh
        ->createCommand("select * from lista_asistencia_entrefechas('$fechadesde' ,'$fechahasta','$cadenatipocontrato')   ")
        ->queryAll();

   
    $nombreArchivo='Horas_'.$fechadesde.'_'.$fechahasta;
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->removeSheetByIndex(0);
    $objPHPExcel->createSheet(0);
    $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
    $activeSheet->setTitle($nombreArchivo);
    $activeSheet->getDefaultColumnDimension()->setWidth(14);
    $htmlHelper = new \PHPExcel_Helper_HTML();
    $phpFont = array('font'  => array(
                'size'  => 8,
                'name'  => 'Times New Roman',
                 ),
                'alignment' => array(
                          'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                          'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER     
                      ),
                      );
               $phpFontP = array('font'  => array(
                'size'  => 14,
                'name'  => 'Times New Roman',
                 ),
                'alignment' => array(
                          'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                          'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER     
                      ),
                'font'  => array(
          'bold'  => true,)
                      );
        $phpColor= array(
          'type' => PHPExcel_Style_Fill::FILL_SOLID,
          'startcolor' => array(
               'rgb' => '#00ccff'
          ),
          'font'  => array(
              'bold'  => true,)
      );
         $phpFontC=array(



                      'font'  => array(
          'bold'  => true,


      )
                  );
     $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);

      $activeSheet->getColumnDimension('A')->setWidth(13);
      $activeSheet->getColumnDimension('B')->setWidth(40);
      $activeSheet->getColumnDimension('C')->setWidth(13);
      $activeSheet->getColumnDimension('D')->setWidth(13);
      $activeSheet->getColumnDimension('E')->setWidth(13);
      $activeSheet->getColumnDimension('F')->setWidth(13);
      $activeSheet->getColumnDimension('G')->setWidth(13);
      $activeSheet->getColumnDimension('H')->setWidth(13);
      $activeSheet->getColumnDimension('I')->setWidth(13);
      $activeSheet->mergeCells('A1:H1'); 
      $activeSheet->getStyle("A1")->applyFromArray($phpFontP); 
      $activeSheet->mergeCells('A2:H2');     
      $activeSheet->getStyle("A3:H3")->applyFromArray($phpFontP); 
      $activeSheet->setCellValue('A1','ASISTENCIA DEL  '.$fechadesde.'  AL  '.$fechahasta  );
      $activeSheet->setCellValue('A3','C.I.');      
      $activeSheet->setCellValue('B3','Nombre Completo');   
      $activeSheet->setCellValue('C3','Fecha');
      $activeSheet->setCellValue('D3','Entrada');
      $activeSheet->setCellValue('E3','Salida');
      $activeSheet->setCellValue('F3','Tiempo');
      $activeSheet->setCellValue('G3','Horas');
      $activeSheet->setCellValue('H3','Minutos');
      $cant=count($datos);

     for ($i=0; $i <$cant ; $i++) { 
       if($datos[$i]['nombrecompleto']!=$nombre){
          
           
           $nombre=$datos[$i]['nombrecompleto'];
       }
      $activeSheet->setCellValue('A'.$fila,$datos[$i]['ci'] );          
      $activeSheet->setCellValue('B'.$fila,$datos[$i]['nombrecompleto'] ); 
      $activeSheet->setCellValue('C'.$fila,$datos[$i]['fecha'] ); 
      $activeSheet->setCellValue('D'.$fila,$datos[$i]['entrada'] ); 
      $activeSheet->setCellValue('E'.$fila,$datos[$i]['salida'] ); 
      $activeSheet->setCellValue('F'.$fila,$datos[$i]['tiempo'] ); 
      $activeSheet->setCellValue('G'.$fila,$datos[$i]['horas'] ); 
      $activeSheet->setCellValue('H'.$fila,$datos[$i]['minutos'] ); 
     
      $fila+=1;
      
     }
     $this->descargarExcel($objPHPExcel, $nombreArchivo); 
    }
    /**
     * retorna un el formulario para el repote de asistencia
     */
    public function actionReporteHorasAsistidas()
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $model=new Entradasalida;
        $ltipocontratos = Tipocontrato::model()->findAll();
        $this->renderPartial('asistencia',array(
            'model'=>$model,
            'ltipocontratos'=>$ltipocontratos
        ), false, true);
    }
    /**
     * @param string $_POST['tipo'],posibles valores E=entrada o S=salida
     * retorna un listado de tipos de selladas que pertenecen a $_POST['tipo']
     */
    public function actionDamelistatipo() {
        $tipo=$_POST['tipo'];
        $lista=Yii::app()->rrhh->createCommand(" select * from  general.tipo where eliminado=false and tipo like '%$tipo%' order by nombre asc")->queryAll(); 
        $this->renderPartial('_lista',array(
            'lista'=>$lista,
                    ), false, true);
        
    }
    /**
     * @param string $_POST['tipo'],posibles valores E=entrada o S=salida 
     * retorna un listado de tipos de selladas que pertenecen a $_POST['tipo'] sin  $_POST['tipo']
     */
    public function actionDamelistacambiara() {
        $tipo=$_POST['tipo'];
        $evento=$_POST['evento'];
        $lista=Yii::app()->rrhh->createCommand(" select * from  dame_opciones_cambiarevento($evento,'$tipo')")->queryAll();  
        	
         return $this->renderPartial('_lista',array(
            'lista'=>$lista,
                    ), false, true); 
        
    }
    /**
     * @param string $_POST['tipo'], posibles calores E= entrada o S=salida
     * @param  string $_POST['orden'], orden asc o desc ya sea de nombre o fecha(segun se seleccione en la cabecera de la grilla)
     * @param integer $_POST['evento'],el id de los tipo de eventos segun a $_POST['tipo'] si tipo es $_POST['tipo']=E , los posibles valores son: 3=Atraso Personal,2=Atraso Justificado,11=Tiempo Adicional y 8=Horas a Favor y si $_POST['tipo']=S los posibles valores son:11=Tiempo Adicional,8=Horas a Favor,4=Salida Antes Autorizada y 5=Salida Antes Personal
     * @param integer $_POST['area'], id del area seleccionado
     * @param date $_POST['desde'], fecha desde
     * @param date $_POST['hasta'],fecha hasta
     * @param string $_POST['nombre'],nombre del formulario
     * @param integer $_POST['intervaloini'], minutos desde el cual se quiere filtrar 
     * @param integer $_POST['intervalofin'], minutos hasta el cual se quiere filtrar 
     * @param integer $_POST['empleado'], id del empleado
     * @return la lista de asistencia segun los parametros pasados
     */
    public  function  actionDametabla(){
        $tipo=$_POST['tipo'];
        $usuario=Yii::app()->user->getName();
        $orden=$_POST['orden'];
       
          if ($tipo=='E'){
           $columnaselladas='entrada'; 
           $hmincolumna='hminentrada';
           $tipocolumna='idtipoentrada';
           $otrotipocolumna='idtiposalida';
           $observacioncolumna='observacionentrada';
           
        }else{
            $columnaselladas='salida'; 
            $hmincolumna='hminsalida';
            $tipocolumna='idtiposalida';
            $otrotipocolumna='idtipoentrada';
            $observacioncolumna='observacionsalida';
            $orden=str_replace("entrada", "salida", $orden);
        }
        $evento=$_POST['evento'];
        $area=$_POST['area'];
        $desde=$_POST['desde'];
        $hasta=$_POST['hasta'];
        $nombre=$_POST['nombre'];
        $intervaloini=$_POST['intervaloini'];
        $intervalofin=$_POST['intervalofin'];
        $empleado=$_POST['empleado'];
         $cadena='';
         if ($area==''){
             $filtro='';
         }
         else{
           $filtro=" and s.idarea=".$area  ;
         }
         if ($empleado!=''){
             $filtroempleado=' and e.id='.$empleado;
         }else{ $filtroempleado='';}
         if($intervalofin==''&& $intervaloini==''){
            $cadena='';
          
         } elseif ($intervalofin!=''&& $intervaloini!='') {
            // desde aqui me falta modificar la consulta
            $cadena=' es.'.$hmincolumna.' between '.$intervaloini.' and '.$intervalofin.' and  ';
        }
        elseif ($intervaloini!='') {
         $cadena=' es.'.$hmincolumna.'>='.$intervaloini.'  and';
        }else{
              $cadena=' es.'.$hmincolumna.'<='.$intervalofin.' and ';
        }
         if ($orden==''){
             $orden="es.".$hmincolumna." desc  ,p.nombrecompleto  asc";
         }
         else{
             $orden.=" , es.".$hmincolumna." desc"  ;
         }
        
        $listaselladas=Yii::app()->rrhh
                                ->createCommand(" select es.id as identradasalida ,
 (select idcategoriatipo from general.tipo where id=$tipocolumna), 
     p.nombrecompleto,to_char(es.fecha,'dd-mm-YYYY') as fecha, es.".$columnaselladas." as entrada, 
 (es.".$hmincolumna."/60) as difhentrada,(es.".$hmincolumna."-((es.".$hmincolumna."/60)*60)) as difmentrada,es.".$hmincolumna." as difentradaoriginal,
 ( select t.nombre from general.tipo t where eliminado=false and t.id=$evento) as tipoentrada,
     es.".$tipocolumna." as idtipoentrada,es.".$otrotipocolumna." as 
 otrotipocolumna ,es.".$observacioncolumna." as observacionentrada from general.persona p inner join general.empleado e 
 on e.idpersona=p.id inner join entradasalida es on es.idempleado=e.id where $cadena es.eliminado=false and es.fecha between   '$desde' and '$hasta' and 
 es.".$tipocolumna."=$evento and es.".$hmincolumna.">0 and p.eliminado=false $filtroempleado  and e.eliminado=false and e.id in 
 (
 select hee.idempleado from general.historialestadoempleado hee inner join contrato c on c.idhistorialestadoempleado=hee.id inner join historialcontrato hc on hc.idcontrato=c.id 
inner join general.puestotrabajo pt on pt.id=hc.idpuestotrabajo inner join general.seccion s on s.id=pt.idseccion 
inner join general.seguimientoempleado se on se.idempleado=hee.idempleado inner join 
 ftbl_usuario_web_cruge_user cu on cu.iduser=se.idcrugeuser 
where    c.eliminado=false and hc.eliminado=false   $filtro and  se.eliminado=false and cu.username='$usuario' 

and  hee.id  in (select (select max(hee.id) from general.historialestadoempleado hee where hee.eliminado=false and hee.activo=1 and hee.idempleado=e1.id and hee.fechaplanilla <=now()::date) from general.empleado e1)
) 
 order by $orden ")
                                                                   ->queryAll();   
                                                          
       return $this->renderPartial('_selladas',array(
            'nombre'=>$nombre,
             'selladas'=>$listaselladas
                    ), false, true); 
    }
    /**
     * 
     * @param integer $id, id de la sellada de entrada/salida
     * @return formulario para la seleccion de que sellada va a ser eliminada
     */
    public function actionBajasellada($id)
   {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $model=$this->loadModel(SeguridadModule::dec($id));
        if(isset($_POST['Entradasalida'])){

                $model->attributes=$_POST['Entradasalida'];           
                $respuesta=  Entradasalida::model()->bajasellada($model->id,$_POST['Entradasalida']['evento']);
                if ($respuesta=='') {
                    echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                          return;
                }else{
                  echo System::hasErrors($respuesta, $model);
                      return;
                }

           
    }

    $this->renderPartial('bajasellada',array(
       
        'model'=>$model,
    ), false, true); 
    
   }
   /**
    * da una eliminacion logica de la sellada que no tiene salida
    */
   public function actionBajaselladasinsalida() {
       $id=SeguridadModule::dec($_POST['id']);  
       $evento='E';
       if (isset($_POST['evento']))
       $evento=$_POST['evento'];
       $usuario=Yii::app()->user->getName();
       Yii::app()->rrhh ->createCommand("select public.dar_bajasellada($id ,'$evento',  '$usuario') ") ->execute();
     
       self::actionAdmin(); 
     
   }
   /**
    * @param string $_POST['observacion'],la nueva observacion que se asignara a la entrada o salida
    * @param string $_POST['entrada'], posibles valores E=entrada o S=salida
    * @param integer $_POST['identradasalida'], id de la sellada a la cual se quiere asignar la nueva observacion
    */
   public function actionActualizarobservacion() {
       $observacion=$_POST['observacion'];
       $entrada=$_POST['entrada'];
       $id=$_POST['identradasalida'];
        if ($id!=''){
            $usuario=Yii::app()->user->getName();
         if($entrada=='E'){
              Yii::app()->rrhh ->createCommand(" update entradasalida set observacionentrada='$observacion',usuario='$usuario'  where id=$id") ->execute();
       
         }else{
              Yii::app()->rrhh ->createCommand(" update entradasalida set observacionsalida='$observacion',usuario='$usuario'  where id=$id") ->execute();
        
         }
        
        } 
   }
   /**
    * 
    * @return formulario para el registro de teletrabajo
    */
   public function actionRegistrarTeletrabajo()
   {
    Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
    $model=new Entradasalida;   
    if(isset($_POST['Entradasalida'])){
        
            $ci=$_POST['Entradasalida']['ci'];           
            $respuesta=  Entradasalida::model()->registrarTeletrabajo($ci);
            if ($respuesta!='No existe registro con ese numero de Carnet') {

               echo System::dataReturn($respuesta, array('id' => ''));
                      return;
            }else{
              echo System::hasErrors($respuesta, $model);
                  return;
            }
             
           
    }

    $this->renderPartial('registrarteletrabajo',array(
       
        'model'=>$model,
    ), false, true); 
    
   }
   /**
    * @param string  $_GET['term'],nombre completo o paracial del empleado
    * @param  integer $_GET['area'], id del area 
    * retorna un listado de personas que contengan en su nombre completo el valor de $_GET['term'] y que pertenescan a $_GET['area']  
    */
    public function actionAutocompletePersona() {
        $request = trim($_GET['term']);
        $area=$_GET['area'];
     
        $requestMayuscula = strtoupper($request);
        if ($request != '') {
               if($area==''){
               $model=   Yii::app()->rrhh
            ->createCommand("select e.id ,  p.apellidop||' '||p.apellidom||' '||p.nombre as nombrecompleto from general.persona p inner join general.empleado e on e.idpersona=p.id right outer join general.seguimientoempleado se on se.idempleado=e.id  right outer JOIN ftbl_usuario_web_cruge_user cu  on cu.iduser=se.idcrugeuser where se.eliminado=false and  cu.username='".Yii::app()->user->getName()."' and p.nombrecompleto like '%$requestMayuscula%' and e.id in (  (select e.id from general.historialestadoempleado hee inner join  general.empleado e on e.id=hee.idempleado   where hee.eliminado=false  and hee.activo=1 and hee.id in (select  (select max(id) from general.historialestadoempleado where eliminado=false and idempleado=e.id) as idhistorial from general.empleado e where   e.eliminado=false)) 
            )   ")
               ->queryAll();}
               else{
                   
                     $model=   Yii::app()->rrhh
            ->createCommand(" select e.id , p.apellidop||' '||p.apellidom||' '||p.nombre as nombrecompleto from general.persona p 
                            inner join general.empleado e on e.idpersona=p.id inner join general.historialestadoempleado hee on hee.idempleado=e.id inner join contrato c on hee.id=c.idhistorialestadoempleado  inner join historialcontrato hc on hc.idcontrato =c.id inner join general.puestotrabajo pt on  pt.id=hc.idpuestotrabajo inner join general.seccion s on s.id=pt.idseccion  right outer join general.seguimientoempleado se on se.idempleado=e.id right outer JOIN  ftbl_usuario_web_cruge_user cu on cu.iduser=se.idcrugeuser where se.eliminado=false and s.idarea=$area and hc.id in  ( (select hc.id               from contrato c inner join historialcontrato hc on c.id=hc.idcontrato where hc.eliminado=false               and c.eliminado=false  and c.idhistorialestadoempleado=               (case when hee.activo=0 then(select he.id from general.historialestadoempleado he where he.eliminado=false and hee.idempleado=he.idempleado and he.id<hee.id order by he.id desc limit 1) else hee.id end)                  order by fecharegistro desc limit 1)              ) and cu.username='".Yii::app()->user->getName()."'  and p.nombrecompleto ilike '%$requestMayuscula%' and e.id in ( (select e.id from general.historialestadoempleado hee inner join general.empleado e on e.id=hee.idempleado where hee.eliminado=false and hee.activo=1 and hee.id in (select (select max(id) from general.historialestadoempleado where eliminado=false and idempleado=e.id) as idhistorial from general.empleado e where e.eliminado=false)))  ")
               ->queryAll(); 
               }
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
     * @param boolean $_POST['opcion'] ,true= con personal retirado y false = sin personal retirado 
     * retorna un listado de empleados  con la opcion seleccionada
     */
    public function actionDameListaOpcionSeguimiento() {
     $opcion =$_POST['opcion'];
     $hasta=$_POST['hasta'];
     $desde=$_POST['desde'];
     $tipocontratos=$_POST['tipocontrato'];
     if($tipocontratos==''){
         $tipocontratos='0';
     }else{
         $tipocontratos= substr($tipocontratos,0,-1);
     }
     if($opcion==1){
            $listaempleado= Yii::app()->rrhh
                ->createCommand("select t.nombrecompleto as id,t.nombrecompleto  from (select p.nombrecompleto as id,p.nombrecompleto ,
                   (select c.idtipocontrato from contrato c inner join historialcontrato hc on hc.idcontrato=c.id 
   where c.idhistorialestadoempleado=(case when hee.activo=1 then hee.id else
 ( select he.id from general.historialestadoempleado he where he.eliminado=false and he.idempleado=hee.idempleado and he.id<hee.id  order by he.id desc limit 1) end ) and hc.fecharegistro <='$hasta' order by hc.fecharegistro desc limit 1
)
                    from general.persona p inner join general.empleado e1 on p.id=e1.idpersona 
                    inner join general.historialestadoempleado hee on hee.idempleado=e1.id where
                    hee.eliminado=false  and e1.analizarsellada=true  and    hee.id in( select ((select max(id) from general.historialestadoempleado he where he.eliminado=false and he.idempleado=e.id  )                               )from general.empleado e )) as t  where t.idtipocontrato in($tipocontratos)  order by nombrecompleto asc ")
                ->queryAll();
           
            
     }else{
            $listaempleado= Yii::app()->rrhh
                ->createCommand("select t.nombrecompleto as id,t.nombrecompleto  from (select p.nombrecompleto as id,p.nombrecompleto ,(select c.idtipocontrato from contrato c inner join historialcontrato hc on hc.idcontrato=c.id 
   where c.idhistorialestadoempleado=hee.id and hc.fecharegistro <='$hasta' order by hc.fecharegistro desc limit 1
)
                                from general.persona p inner join general.empleado e1 on p.id=e1.idpersona inner join general.historialestadoempleado hee on hee.idempleado=e1.id where  hee.eliminado=false  and e1.analizarsellada=true and hee.activo=1 and    hee.id in(
                                  select ((select max(id) from general.historialestadoempleado he where he.eliminado=false and he.idempleado=e.id   ) 
                                  )from general.empleado e )) as t where t.idtipocontrato in($tipocontratos) order by nombrecompleto asc ")->queryAll();
     
            
     }
   
     $cadena='<option value=""></option>';
     foreach ($listaempleado as $l){
        
         $cadena.='<option value="'.$l['nombrecompleto'].'">'.$l['nombrecompleto'].'</option>';
     }
     echo $cadena;
    }
     public function actionDameHorarioEmpleado()
    {
   

        $idempleado=$_POST['ide'];   
        $fecha=$_POST['fecha'];
        $resp=Yii::app()->rrhh->createCommand("select dame_selladas_dia_empleado('".$fecha."', ".$idempleado.") as f")->queryAll();
        echo $resp[0]['f'];

    }  
 
}
