<?php
/*
 * EmpleadoController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 20/08/2019
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
class EmpleadoController extends Controller
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
        
        $model=new Empleado;

        if(isset($_POST['Empleado'])){
                $model->attributes=$_POST['Empleado'];
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
        $this->renderPartial('update',array(
           

        ), false, true);
    }
    
/**
 *@param string  $_GET['term'], parte delnombre completo del empleado 
 * retorna un listado de empleados al que se le esta haciendo el seguimineto y que contengan en su nombre completo el valor de $_GET['term']
 */
   public function actionAutocompletePersona() {
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
     * Deletes safely a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
      
    }
 
    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model=new Empleado('search');
        $model->unsetAttributes();  // clear any default values
        $model->fecha=date('d-m-Y', strtotime('-1 day'));
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Empleado'])){
                $model->attributes=$_GET['Empleado'];
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
     * @return Empleado the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=Empleado::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Empleado $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='empleado-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    /**
     * retorna un formulario para generar el reporte de cumpleañero del mes seleccionado
     */
    public function actionReportecumpleanerodelmes()
    {   
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $model=new Empleado;
        $this->renderPartial('cumpleanieros',array(
            'model'=>$model,
        ), false, true);
        
    }
    /**
     * @param integer $_GET['Empleado']['mes'],cuyos valores esta entre 1 y 12
     * retorna un repore con el listado de empleados activos que cumplan años en el mes seleccionado 
     * @throws CrugeException
     */
    public function actionImprimirreportecumpleanierodelmes() {
        $mes = $_GET['Empleado']['mes'];
        if($mes==''){
            $mes=0;
        }
        $re = new JasperReport('/reports/RRHH/ReporteCumpleanieroDelMes', JasperReport::FORMAT_PDF, array(
            'p_mes' => $mes,             
           
           'pUsuario'=>Yii::app()->user->getName()
            
        ));
        $re->exec();                                
        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        }
    }
    /**
     * retorna un reporte con el personal activo clasificados por las areas a la que pertenecen
     */
    public function actionReportelistaempleados() {
      
       $re = new JasperReport('/reports/RRHH/ListaEmpleados', JasperReport::FORMAT_PDF, array(
            'pUsuario'=>Yii::app()->user->getName()            
        ));
        $re->exec();                                
        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        } 
    }
    /**
     * retorna un reporte  con informacion del empleado  y de sus dependientes en caso de tenerlos
     */
    public function actionReportedatosempleados() {
      
       $re = new JasperReport('/reports/RRHH/DatosEmpleados', JasperReport::FORMAT_PDF, array(
            'pUsuario'=>Yii::app()->user->getName()            
        ));
        $re->exec();                                
        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        } 
    }
    /**
     * 
     * retorna un formulario para la seleccion de opciones para mostrar en el kardex( ,falta,atraso,vacacion,etc.)
     */
    public function actionKardexempleado()
    {   
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $model=new Empleado;
        $this->renderPartial('kardexempleado',array(
            'model'=>$model,
        ), false, true);
        
    }
    /**
     * retorna un formulario para la generacion del reporte de horarios que tiene asignado
     */
     public function actionHorarioempleado()
    {   
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $model=new Empleado;
        $this->renderPartial('horarioempleado',array(
            'model'=>$model,
        ), false, true);
        
    }
    /**
     * @param date $_GET['Empleado']['fechadesde'] ,fecha desde la cual queremos el reporte
     * @param date $_GET['Empleado']['fechahasta'] , fecha hasta la cual queremos el reporte
     * @param integer $_GET['Empleado']['id'],id del empleado seleccionado 
     * @param integer[] $_GET['beneficio'] , variable que contiene la lista de opciones para el reporte cuyos valores posibles son :
     * 10=Horas en Contra,12=Falta,13=Vacacion,6=Permiso c/goce,3=Atraso Personal,2=Atraso Justificado,4=Salida Antes Autorizada y 5=Salida Antes Personal
     * retorna un reporte con las opciones seleccionadas
     */
     public function actionImprimirkardexempleado() {
        $fechadesde = $_GET['Empleado']['fechadesde'];
        $fechahasta = $_GET['Empleado']['fechahasta'];
        $idempleado=$_GET['Empleado']['id'];$cadenatipo='';
        if($idempleado ==null){
            $idempleado=0;
        }

        if (isset($_GET['beneficio'])){
        $tipos=$_GET['beneficio'];
          for ($i = 0; $i < count($tipos); $i++) {
                        $cadenatipo = $cadenatipo . $tipos[$i] . ',';
                    }
        }
        else{
            $cadenatipo='';
            $tipos='';
        }
        
       
                    if(count($tipos)>1)
                    $cadenatipo = substr($cadenatipo, 0, -1);  
                    
       $re = new JasperReport('/reports/RRHH/KardexEmpleado', JasperReport::FORMAT_PDF, array(
            'pUsuario'=>Yii::app()->user->getName() ,
            'p_fechadesde'=>$fechadesde,
            'p_fechahasta'=>$fechahasta,
             'p_tipos'=>$cadenatipo,
             'p_idempleado'=>$idempleado
        ));
        $re->exec();                                
        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        } 
    }
   /**
    * retorna un formulario para la generacion del reporte de asistencia
    */
    public function actionAsistenciaempleado()
    {   
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $model=new Empleado;
        $this->renderPartial('asistenciaempleado',array(
            'model'=>$model,
        ), false, true);
        
    }
    /**
     * @param date  $_GET['Empleado']['fechadesde'], fecha desde la cual queremos el reporte
     * @param date $_GET['Empleado']['fechahasta'], fecha hasta la cual queremos el reporte
     * @param integer $_GET['Empleado']['id'],id relacionda con el empleado
     * retorna un reporte con la asistencia del empleado
     */
     public function actionImprimirasistenciaempleado() {
        $fechadesde = $_GET['Empleado']['fechadesde'];
        $fechahasta = $_GET['Empleado']['fechahasta'];
        $idempleado=$_GET['Empleado']['id'];                   
        $re = new JasperReport('/reports/RRHH/DetalleAsistenciaEmpleado', JasperReport::FORMAT_PDF, array(
            'pUsuario'=>Yii::app()->user->getName() ,
            'p_fechadesde'=>$fechadesde,
            'p_fechahasta'=>$fechahasta,
             'p_idempleado'=>$idempleado
        ));
        $re->exec();                                
        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        } 
    }
    /**
     * retorna un formulario con la lista de tipos de contratos 
     */
     public function actionFamiliaresedades()
    {   
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $model=new Empleado;
        $ltipocontratos = Tipocontrato::model()->findAll();
        $this->renderPartial('familiaresedades',array(
            'model'=>$model,
            'ltipocontratos'=>$ltipocontratos
        ), false, true);
        
    }
    /**
     * @param integer $_GET['Empleado']['id'], id del empleado 
     * @param integer[] $_GET['beneficio'], lista de opciones seleccionadas , cuyos posibles valores a contener  son:2=HIJA,4=HIJO y 29=ESPOSA
     * @param integer[] $_GET['tipocontrato'], lista de contratos vigentes
     * retorna un reporte en formato pdf, con la informacion del/los empleado(s) con sus edades y las edades de sus dependientes en caso de tenerlos 
     */
     public function actionImprimirfamiliaresedades() {
      
        $idempleado=$_GET['Empleado']['id'];
        $cadenatipocontrato='';
        $cadenatipo='';
        if ($idempleado=='') 
        $idempleado=0;
        
        if (isset($_GET['beneficio'])){
            
            $tipos=$_GET['beneficio'];
            for ($i = 0; $i < count($tipos); $i++) {
                        $cadenatipo = $cadenatipo . $tipos[$i] . ',';
                    }
             if(count($tipos)>0)
                    $cadenatipo = substr($cadenatipo, 0, -1);                
            }
        else{
            $cadenatipo='0';
            
        }
         if (isset($_GET['tipocontrato'])){
            
            $tipos=$_GET['tipocontrato'];
            for ($i = 0; $i < count($tipos); $i++) {
                        $cadenatipocontrato = $cadenatipocontrato . $tipos[$i] . ',';
                    }
             if(count($tipos)>0)
                    $cadenatipocontrato = substr($cadenatipocontrato, 0, -1);  
               
        }
        else{
           $cadenatipocontrato='0';         
            
        }
                 
                
       $re = new JasperReport('/reports/RRHH/FamiliaresEdades', JasperReport::FORMAT_PDF, array(
            'pUsuario'=>Yii::app()->user->getName() ,
            'p_tipos'=>$cadenatipo,
            'p_idempleado'=>$idempleado,
            'p_tipocontratos'=>$cadenatipocontrato
           
        ));
        $re->exec();                                
        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        } 
    }
     /**
     * @param integer $_GET['Empleado']['id'], id del empleado 
     * @param integer[] $_GET['beneficio'], lista de opciones seleccionadas , cuyos posibles valores a contener  son:2=HIJA,4=HIJO y 29=ESPOSA
     * @param integer[] $_GET['tipocontrato'], lista de contratos vigentes
     * retorna un reporte en formato xls, con la informacion del/los empleado(s) con sus edades y las edades de sus dependientes en caso de tenerlos 
     */
      public function actionImprimirfamiliaresedadesxls() {
      
        $idempleado=$_GET['Empleado']['id'];
        $cadenatipo='';
        if ($idempleado=='') 
        $idempleado=0;        
        if (isset($_GET['beneficio'])){
            
            $tipos=$_GET['beneficio'];
            for ($i = 0; $i < count($tipos); $i++) {
                        $cadenatipo = $cadenatipo . $tipos[$i] . ',';
                    }
             if(count($tipos)>0)
                    $cadenatipo = substr($cadenatipo, 0, -1);  
        }
        else{
            $cadenatipo='0';
            
        }
        $fecha = Yii::app()->rrhh->createCommand("select to_char(now()::date,'dd-mm-YYYY') ")->queryScalar();
        $nombreArchivo = 'Familiares_Edades_' . $fecha;
        $listaempleados=Yii::app()->rrhh->createCommand("select * from reporte_cabecera_familiaresedades($idempleado)")->queryAll();
        $objPHPExcel = new PHPExcel();
        $phpFont = array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
        $phpFontC = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
           
            'font' => array(
                'bold' => true,
            )
        );
         $phpFonttitulo = array(           
            
             'font' => array(
                'size' => 9,
                'name' => 'Times New Roman',
                  'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
          $phpFontSubtitulo = array(           
            
             'font' => array(
                'size' => 7,
                'name' => 'Times New Roman',
                  'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
         $phpFont3 = array(
            
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        ));
         $phpFont2 = array(
              'font' => array(
                
                  'bold' => true,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        ));
        
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);
        $objPHPExcel->removeSheetByIndex(0);
        $objPHPExcel->createSheet(0);        
        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $activeSheet ->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $activeSheet 
                ->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);
        $activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1,6);        
        $activeSheet->getPageMargins()->setTop(0.3);
        $activeSheet->getPageMargins()->setRight(0.2);
        $activeSheet->getPageMargins()->setLeft(0.2);
        $activeSheet->getPageMargins()->setBottom(0.8);
        $activeSheet->getRowDimension(1)->setRowHeight(20);
        $activeSheet->setTitle($nombreArchivo);
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);
        $activeSheet->getColumnDimension('A')->setWidth(45);
        $activeSheet->getColumnDimension('B')->setWidth(15);
        $activeSheet->getColumnDimension('C')->setWidth(40);
        $activeSheet->getColumnDimension('D')->setWidth(17);
        $activeSheet->getColumnDimension('E')->setWidth(10);
        $img = realpath(__DIR__.'/../../../../images' ); // Provide path to your logo file
        $imgot = $img . '/logoEmpresa.png';
        $objDrawingt = new PHPExcel_Worksheet_Drawing();
        $objDrawingt->setName('imgNotice');
        $objDrawingt->setDescription('Noticia');
        $objDrawingt->setPath($imgot);
        $objDrawingt->setOffsetX(5);    // setOffsetX works properly
        $objDrawingt->setOffsetY(0);  //setOffsetY has no effect
        $objDrawingt->setCoordinates('A1');
        $objDrawingt->setWidthAndHeight(140, 70);
        $objDrawingt->setResizeProportional(true);
        $objDrawingt->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
        
        $activeSheet->getRowDimension(1)->setRowHeight(10);
        $activeSheet->getRowDimension(2)->setRowHeight(10);
        $activeSheet->getRowDimension(3)->setRowHeight(10);
        $activeSheet->getRowDimension(4)->setRowHeight(10);

        //CABECERA DE LA PLANILLA

        $activeSheet->mergeCells('A1:E1');
        $activeSheet->mergeCells('A2:E2');
        $activeSheet->mergeCells('A3:E3');
        $activeSheet->mergeCells('A4:E4');
        $activeSheet->mergeCells('A4:E4');
        $kFila = 7;
        $activeSheet->getStyle('A2')->applyFromArray($phpFonttitulo);
        $activeSheet->getStyle('A3')->applyFromArray($phpFontSubtitulo);
        $activeSheet->getStyle('A4')->applyFromArray($phpFontSubtitulo);
        $activeSheet->setCellValue('A2','FAMILIARES Y EDADES');
        $activeSheet->setCellValue('A3','REPORTE AL  '.$fecha);
        
        $activeSheet->getStyle("A".($kFila-1))->applyFromArray($phpFontC);
        $activeSheet->getStyle("B".($kFila-1))->applyFromArray($phpFontC);
        $activeSheet->getStyle("C".($kFila-1))->applyFromArray($phpFontC);
        $activeSheet->getStyle("D".($kFila-1))->applyFromArray($phpFontC);
        $activeSheet->getStyle("E".($kFila-1))->applyFromArray($phpFontC);

        $activeSheet->setCellValue('A'.($kFila-1), 'NOMBRE');
        $activeSheet->setCellValue('B'.($kFila-1), 'PARENTESCO');
        $activeSheet->setCellValue('C'.($kFila-1), 'FAMILIAR DE');        
        $activeSheet->setCellValue('D'.($kFila-1), 'FECHA DE NAC. ');
        $activeSheet->setCellValue('E'.($kFila-1), 'EDAD');
        
         for ($j=0;$j<count($listaempleados);$j++){
            $activeSheet->getRowDimension(($kFila))->setRowHeight(20);
            $activeSheet->getStyle('A'.  $kFila.':E'. $kFila)->applyFromArray($phpFont2);
            
            $activeSheet->setCellValue('A' .  $kFila, $listaempleados[$j]['nombrecompleto']);
            $activeSheet->setCellValue('D' .  $kFila, $listaempleados[$j]['fechanacimiento']);
            $activeSheet->getStyle('E' . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->setCellValue('E' . $kFila, $listaempleados[$j]['edad']);
            ++$kFila;  
            $datos=Yii::app()->rrhh->createCommand("select  * from reporte_cuerpo_familiaresedades(".$listaempleados[$j]['id'].",'". $listaempleados[$j]['sexo'] ."','".$cadenatipo."'  )")->queryAll();
            for($k=0;$k<count($datos);++$k){
                  $activeSheet->getRowDimension($kFila)->setRowHeight(20);
            $activeSheet->getStyle('A'.  $kFila.':E'.$kFila)->applyFromArray($phpFont3);            
            $activeSheet->setCellValue('A' .  $kFila, $datos[$k]['nombredependiente']);
            $activeSheet->setCellValue('B' .  $kFila, $datos[$k]['parentesco']);
            $activeSheet->setCellValue('C' .  $kFila, $listaempleados[$j]['nombrecompleto']);
            $activeSheet->setCellValue('D' .  $kFila, $datos[$k]['fechanacimiento']);
            $activeSheet->getStyle('E' . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->setCellValue('E' . $kFila, $datos[$k]['edad']);
              ++$kFila;  
            }
            
             
         }
                    
                
      $this->descargarExcel($objPHPExcel, $nombreArchivo);
    }
    /**
     * 
     * @param object $objPHPExcel, con la informacion del archivo que se desea generar
     * @param string $nombreArchivo, nombre del archivo con el que se va generar el archivo xls
     */
   private function descargarExcel($objPHPExcel, $nombreArchivo) {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $nombreArchivo . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setPreCalculateFormulas(true);
        $objWriter->save('php://output');
    }
    /**
     * @param date  $_GET['Empleado']['fechadesde'], fecha desde la cual queremos el reporte
     * @param date $_GET['Empleado']['fechahasta'], fecha hasta la cual queremos el reporte
     * @param integer $_GET['Empleado']['id'],id relacionda con el empleado
     * retorna un reporte con los horarios que se le asignaron entre las fechas seleccionadas
     */
    public function actionImprimirhorarioempleado() {
        $fechadesde = $_GET['Empleado']['fechadesde'];
        $fechahasta = $_GET['Empleado']['fechahasta'];
        $idempleado=$_GET['Empleado']['id'];
        if($idempleado==''){
            $idempleado=0;
        }
        $re = new JasperReport('/reports/RRHH/HorarioEmpleado', JasperReport::FORMAT_PDF, array(
            'pUsuario'=>Yii::app()->user->getName() ,
            'p_fechadesde'=>$fechadesde,
            'p_fechahasta'=>$fechahasta,
            'p_idempleado'=>$idempleado
        ));
        $re->exec();                                
        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        }    
    }
    /**
    * retorna un formulario para la generacion del reporte de asistencia
    */
    public function actionReportePromedioPersonal()
    {   
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $model=new Empleado;
        $ltipocontratos = Tipocontrato::model()->findAll();
        $criteria=new CDbCriteria;       
        $criteria->addCondition("t.estado>=3");
        $criteria->order='t.id desc';
        $criteria->limit=1;
        $planilla= Planilla::model()->find($criteria);
        $fechamax=date ("d-m-Y",strtotime( $planilla->fechahasta));
        $this->renderPartial('reportepromediopersonal',array(
            'model'=>$model,
            'ltipocontratos' => $ltipocontratos,
            'fechamaxima'=>$fechamax
        ), false, true);
        
    }
    public function actionImprimirReportePromedioPersonal() {
        $fechadesde = $_GET['Empleado']['fechadesde'];
        $fechahasta = $_GET['Empleado']['fechahasta']; 
        $tipocontratos= $_GET['tipocontrato'];
        $tipocontratosseleccionados = '';
         for ($i = 0; $i < count($tipocontratos); $i++) {
                        $tipocontratosseleccionados = $tipocontratosseleccionados . $tipocontratos[$i] . ',';
                    }
        $tipocontratosseleccionados = substr($tipocontratosseleccionados, 0, -1);  
        $datoEmpresa = Yii::app()->rrhh->createCommand("select * from  general.empresa en " )
                        ->queryAll()[0];
      $datoPlanilla = Yii::app()->rrhh
                ->createCommand(" select * from dame_promedio_personal (  '".$fechadesde."', '".$fechahasta."','".$tipocontratosseleccionados."') ")
                ->queryAll();
        
     $cabeceraPlanillaPrincipal = Yii::app()->rrhh
                ->createCommand(" select * from ((select 1::int as orden,'AREA'::varchar(50)as nombre, 'nombrearea'::varchar(50) as nombref , 0::int tipo,1::int as cantidad) union

(select (ROW_NUMBER ()OVER (ORDER BY nombre))+5 as orden ,nombre ,(replace(nombre,' ','')) as nombref, 1::int tipo ,
( select count(*) from (select
distinct e.id from general.historialestadoempleado hee inner join
general.empleado e on e.id=hee.idempleado

inner join contrato c on c.idhistorialestadoempleado=hee.id
where c.idtipocontrato=tc.id and e.id in(
(select hee.idempleado
from
general.historialestadoempleado hee
where hee.eliminado=false and (hee.activo=1 or (hee.activo=0 and fecharetiro between '$fechadesde'::date and '$fechahasta'::date)) and hee.id in

( select ( select id from general.historialestadoempleado he where he.eliminado=false and he.idempleado=e1.id and
(( fecharetiro between '$fechadesde'::date and '$fechahasta'::date) or ( fecharetiro<'$fechadesde'::date)) order by id desc limit 1) from general.empleado e1 ))
)) as t ) as cantidad from general.tipocontrato tc where eliminado=false and id in($tipocontratosseleccionados) order by nombre asc)

union
(select 200::int as orden,'PROMEDIO '::varchar(50)as nombre, 'promediomujeres'::varchar(50) as nombref, 0::int tipo,1::int as cantidad) union
(select 300::int as orden,'PROMEDIO TOTAL GANADO'::varchar(50)as nombre, 'promediovarones'::varchar(50) as nombref, 0::int tipo,1::int as cantidad)) as t where t.cantidad>0 order by orden asc 
 ")
                ->queryAll();     
        
      
   $cabeceraPlanilla = Yii::app()->rrhh
                ->createCommand(" select * from((select 1::int as orden,'AREA'::varchar(50)as nombre, 
                    'nombrearea'::varchar(50) as nombref , 0::int tipo, 1::int as cantidad) union

(select (ROW_NUMBER ()OVER (ORDER BY nombre))+5 as orden ,nombre ,(replace(nombre,' ','')) as nombref, 1::int tipo ,( select count(*)   from (select
  distinct p.nombrecompleto,p.sexo from general.historialestadoempleado hee inner join 
  general.empleado e on e.id=hee.idempleado 
            inner join general.persona p  on p.id=e.idpersona 
             inner join contrato c on c.idhistorialestadoempleado=hee.id
            where  c.idtipocontrato=tc.id and e.id in(
                 (select hee.idempleado
       from 
       general.historialestadoempleado hee 
       where hee.eliminado=false  and (hee.activo=1 or (hee.activo=0 and fecharetiro between '$fechadesde'::date and '$fechahasta'::date)) and hee.id in

       ( select  ( select  id from general.historialestadoempleado he  where he.eliminado=false and he.idempleado=e1.id  and
        (( fecharetiro between '$fechadesde'::date and '$fechahasta'::date)  or (   fecharetiro<'$fechadesde'::date)) order by id desc limit 1) from general.empleado e1 ))
  )) as t ) as cantidad from general.tipocontrato  tc where eliminado=false and id in($tipocontratosseleccionados)  order by nombre asc) 
     
union 
    

(select 200::int as orden,'PROMEDIO '::varchar(50)as nombre, 'promediomujeres'::varchar(50) as nombref, 0::int tipo,1::int as cantidad) union
(select 201::int as orden,'PROMEDIO  TOTAL GANADO'::varchar(50)as nombre, 'promediovarones'::varchar(50) as nombref, 0::int tipo,1::int as cantidad) union 
(select 202::int as orden,'PROMEDIO TOTAL GANADO '::varchar(50)as nombre, 'promediotgmujeres'::varchar(50) as nombref, 0::int tipo,1::int as cantidad)union (select 203::int as orden,'PROMEDIO TOTAL GANADO '::varchar(50)as nombre, 'promediotgvarones'::varchar(50) as nombref, 0::int tipo,1::int as cantidad) ) as t where t.cantidad>0
 order by orden asc  ")
                ->queryAll();   
        $nombreArchivo = 'PROMEDIO_' . $fechadesde.'_'.$fechahasta;
        $numcol = Yii::app()->rrhh
                ->createCommand("select  (count(*)+5)*2 from general.tipocontrato where  eliminado=false  and id in(select  id  from(select  tc.id,
( select count(*)   from (select
  distinct c.idtipocontrato from general.historialestadoempleado hee inner join 
  general.empleado e on e.id=hee.idempleado 
         
             inner join contrato c on c.idhistorialestadoempleado=hee.id
            where  c.idtipocontrato=tc.id and e.id in(
                 (select hee.idempleado
       from 
       general.historialestadoempleado hee 
       where hee.eliminado=false  and (hee.activo=1 or (hee.activo=0 and fecharetiro between '$fechadesde'::date and '$fechahasta'::date)) and hee.id in

       ( select  ( select  id from general.historialestadoempleado he  where he.eliminado=false and he.idempleado=e1.id  and
        (( fecharetiro between '$fechadesde'::date and '$fechahasta'::date)  or (   fecharetiro<'$fechadesde'::date)) order by id desc limit 1) from general.empleado e1 ))
  )) as t ) as cantidad from general.tipocontrato  tc where eliminado=false and id in($tipocontratosseleccionados)  ) as t2 where t2.cantidad>0 )  ")
                ->queryScalar();
        $columnascabecera = $this->dameColumna('A', $numcol);
       
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);

        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $activeSheet->setTitle($nombreArchivo);
        $activeSheet->getDefaultColumnDimension()->setWidth(9.7);
        $activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 7);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $phpFont = array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
        $phpFont1 = array('font' => array(
                'bold' => true,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            )
        );
        $phpFontC = array('font' => array(
                'bold' => true,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $phpFont2 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        ));
        $phpFont3 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        ));

        $phpFontP = array(
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
            ),);  
        
       
        $activeSheet
                ->getPageMargins()->setTop(0.8);
        $activeSheet
                ->getPageMargins()->setRight(0.2);
        $activeSheet
                ->getPageMargins()->setLeft(0.2);
        $activeSheet
                ->getPageMargins()->setBottom(0.4);
        $phpColor = new PHPExcel_Style_Color();
        $phpColor->setRGB('FF0000');
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);
        $kFila = 9;
        $img = realpath(__DIR__ . '/../../../../images'); // Provide path to your logo file

        $imgot = $img . '/logoEmpresa.png';


        $objDrawingt = new PHPExcel_Worksheet_Drawing();
        $objDrawingt->setName('imgNotice');
        $objDrawingt->setDescription('Noticia');
        $objDrawingt->setPath($imgot);
        $objDrawingt->setOffsetX(5);    // setOffsetX works properly
        $objDrawingt->setOffsetY(0);  //setOffsetY has no effect
        $objDrawingt->setCoordinates('A1');
        $objDrawingt->setWidthAndHeight(140, 70);
        $objDrawingt->setResizeProportional(true);
        $objDrawingt->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
        $activeSheet->getRowDimension(7)->setRowHeight(52);
        $activeSheet->getRowDimension(1)->setRowHeight(14);
        $activeSheet->getRowDimension(2)->setRowHeight(8);
        $activeSheet->getRowDimension(3)->setRowHeight(13);
        $activeSheet->getRowDimension(4)->setRowHeight(8);
        $activeSheet->getRowDimension(5)->setRowHeight(8);
        $activeSheet->getRowDimension(6)->setRowHeight(8);

        //CABECERA DE LA PLANILLA

        $activeSheet->mergeCells('A1:'.$columnascabecera[$numcol-4] .'1');
        $activeSheet->mergeCells('A2:'.$columnascabecera[$numcol-4] .'2');
        $activeSheet->mergeCells('A3:'.$columnascabecera[$numcol-4] .'3');
        $activeSheet->mergeCells('A4:'.$columnascabecera[$numcol-4] .'4');
        $activeSheet->mergeCells('A5:'.$columnascabecera[$numcol-4] .'5');
        $activeSheet->mergeCells($columnascabecera[$numcol-3] .'1:'.$columnascabecera[$numcol-1].'1');
        $activeSheet->mergeCells($columnascabecera[$numcol-3] .'2:'.$columnascabecera[$numcol-1].'2');
        $activeSheet->mergeCells($columnascabecera[$numcol-3] .'3:'.$columnascabecera[$numcol-1].'3');
        $activeSheet->mergeCells($columnascabecera[$numcol-3] .'4:'.$columnascabecera[$numcol-1].'4');
        $activeSheet->mergeCells($columnascabecera[$numcol-3] .'5:'.$columnascabecera[$numcol-1].'5');
       
       
        $activeSheet->setCellValue('A1', strtoupper("PROMEDIO PERSONAL "));
       $activeSheet->setCellValue('A3', strtoupper("DEL ".$fechadesde.' AL '.$fechahasta));
       
     
        $htmlHelper = new \PHPExcel_Helper_HTML();
         $activeSheet->getStyle("A1")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(12);
        $activeSheet->getStyle("A1")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("A3:A5")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(11);
        
        $activeSheet->getStyle("A3:A5")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("P1:P5")->getFont()->setBold(false)
                ->setName('Times New Roman')
                ->setSize(7);
        // COLUMNAS STATICAS
        $columnas = $this->dameColumna('A', $numcol);
        $activeSheet->getStyle('A7:'.$columnas[$numcol-5].'7')->applyFromArray($phpFontC);
        $activeSheet->getStyle("A7:".$columnas[$numcol-5]."7")->getAlignment()->setWrapText(true);
        $activeSheet->getStyle('A8:'.$columnas[$numcol-5].'8')->applyFromArray($phpFontC);
        $activeSheet->getStyle("A8:".$columnas[$numcol-5]."8")->getAlignment()->setWrapText(true);
        $ind = 0;
        $indaux=0;
        
        foreach ($cabeceraPlanillaPrincipal as $cp) {
           
             $activeSheet->getColumnDimension($columnas[$indaux])->setWidth(16);
             $activeSheet->getColumnDimension($columnas[$indaux+1])->setWidth(16);
             $activeSheet->mergeCells($columnas[$indaux].'7:'.$columnas[$indaux+1].'7');
             $activeSheet->setCellValue($columnas[$indaux] . '7', $cp['nombre']);
             ++$ind;
             $indaux=$indaux+2;
           
              
            
        }
        // sub cabecera
        $ind = 0;
        $indaux=0;
        
        foreach ($cabeceraPlanillaPrincipal as $cp) {
           
             if ($indaux>1){
               
                 $activeSheet->setCellValue($columnas[$indaux] . '8', 'MUJERES');
                 $activeSheet->setCellValue($columnas[$indaux+1] . '8', 'VARONES');
             
             }else{
                  $activeSheet->mergeCells($columnas[$indaux].'8:'.$columnas[$indaux+1].'8');
             }
             
             ++$ind;
             $indaux=$indaux+2;
           
              
            
        }
        
        ///CUERPO
        
        for ($i = 0; $i < count($datoPlanilla); $i++) {
           
            $ind = 0;
            $indaux=0;
            $indice=0;
            $promedio = json_decode($datoPlanilla[$i]['promediocontrato'], true);
            foreach ($cabeceraPlanilla as $cp) {
                
                $activeSheet->getRowDimension($kFila)->setRowHeight(25);
                $activeSheet->getStyle('A'.$kFila)->applyFromArray($phpFont2);
                $activeSheet->getStyle("A".$kFila)->getAlignment()->setWrapText(true);
                $activeSheet->getStyle('B'.$kFila.':'.$columnas[$numcol-5].$kFila)->applyFromArray($phpFont3);
                $activeSheet->getStyle($columnas[$numcol-6] . $kFila.':'.$columnas[$numcol] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                
                if ($cp['tipo']==1){
                        $baux = false;
                        $promediomujeres= 0;
                        $promediovarones=0;
                        $lista = $promedio;
                       
                        for ($j = 0; $j < count($lista); $j++) {
                            
                            
                                if ($lista[$j]['tipocontrato'] == $cp['nombref']) {
                                    $promediomujeres = $lista[$j]['F'];
                                    $promediovarones=$lista[$j]['M'];
                                    $baux = true;
                                    break;
                                }
                            
                            if ($baux == true) {
                                break;
                            }
                        }
                    
                    
                 $activeSheet->setCellValue($columnas[$indaux] . $kFila, $promediomujeres);
                 $activeSheet->setCellValue($columnas[$indaux+1] . $kFila, $promediovarones);
                 $indice=$indaux;
             }
             elseif ($cp['nombref']!=='nombrearea' && $cp['tipo']=='0') {
                   $activeSheet->setCellValue($columnas[$indice+2] . $kFila, $datoPlanilla[$i][$cp['nombref']]);
               $indice=$indice+1;
            }
             else{
                   $activeSheet->mergeCells($columnas[0].$kFila.':'.$columnas[$indaux+1].$kFila);
                    $activeSheet->setCellValue($columnas[0] . $kFila, $datoPlanilla[$i][$cp['nombref']]);
             }
//       

             
             $indaux=$indaux+2;
             
                
                
            }
            

            $kFila++;
        }       
        $this->descargarExcel($objPHPExcel, $nombreArchivo);
         
    }
    /**
     * 
     * @param string $letrai, nombre  de la columna (ejemplo,A,B,C,etc.)
     * @param int $cant, la cantidad de letras consecutivas despues de la $letrai
     * @return array de letras
     */
    public function dameColumna($letrai, $cant) {
        $letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $letracontante = substr($letrai, 0, -1);
        $letrainicio = substr($letrai, -1);
        $numletrai = strlen($letrai);
        $antepenultima = '';
        $vector = [];
        if ($numletrai > 1) {
            $antepenultima = substr($letrai, -2, -1);
        }
        $posicion = strpos($letras, $letrainicio);
        $conjunto = substr($letras, $posicion, $cant + 1);
        $conjunto = str_split($conjunto);
        $diferencia = $cant + 1 - count($conjunto);

        for ($i = 0; $i < count($conjunto); $i++) {
            array_push($vector, $letracontante . $conjunto[$i]);
        }
        if ($diferencia > 0) {
            if ($antepenultima == '') {
                $posicion = 0;
                $letracontante = 'A';
            } else {
                $posicion = strpos($letras, $antepenultima);
                $posicionc = strpos($letras, $letracontante);
                $letracontante = $letras[$posicionc + 1];
            }

            $conjunto = substr($letras, $posicion, $diferencia);
            $conjunto = str_split($conjunto);

            for ($i = 0; $i < count($conjunto); $i++) {
                array_push($vector, $letracontante . $conjunto[$i]);
            }
        }


        return $vector;
    }
    /**
    * retorna un formulario para la generacion del reporte de asistencia
    */
    public function actionReporteAntiguedadPersonal()
    {   
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $model=new Empleado;
        $ltipocontratos = Tipocontrato::model()->findAll();
        $lareas = Area::model()->findAll();
        $this->renderPartial('reporteantiguedadpersonal',array(
            'model'=>$model,
            'ltipocontratos' => $ltipocontratos,
            'lareas'=>$lareas
        ), false, true);
        
    }
    /**
     * @param date  $_GET['Empleado']['fechadesde'], fecha desde la cual queremos el reporte
     * @param date $_GET['Empleado']['fechahasta'], fecha hasta la cual queremos el reporte
     * @param integer $_GET['Empleado']['id'],id relacionda con el empleado
     * retorna un reporte con los horarios que se le asignaron entre las fechas seleccionadas
     */
    public function actionImprimirReporteAntiguedadPersonal() {
        $fechadesde = $_GET['Empleado']['fechadesde'];
        $tipocontratos= $_GET['tipocontrato'];
        $areas= $_GET['area'];
        $tipocontratosseleccionados = '';
        $areasseleccionadas='';
         for ($i = 0; $i < count($tipocontratos); $i++) {
                        $tipocontratosseleccionados = $tipocontratosseleccionados . $tipocontratos[$i] . ',';
                    }
        $tipocontratosseleccionados = substr($tipocontratosseleccionados, 0, -1); 
       for ($i = 0; $i < count($areas); $i++) {
                        $areasseleccionadas = $areasseleccionadas . $areas[$i] . ',';
                    }
        $areasseleccionadas = substr($areasseleccionadas, 0, -1); 
       
        $re = new JasperReport('/reports/RRHH/ReporteAntiguedadPersonal', JasperReport::FORMAT_PDF, array(
            'pUsuario'=>Yii::app()->user->getName() ,
            'p_fechadesde'=>$fechadesde,
            'p_tipocontratos'=>$tipocontratosseleccionados,
            'p_areas'=>$areasseleccionadas
        ));
        $re->exec();                                
        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        }    
    }
     public function actionReporteHorasefectivas()
    {   
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $model=new Empleado;
        $listaareas = Area::model()->findAll();
        $criteria=new CDbCriteria;       
        $criteria->addCondition("t.estado>=3");
        $criteria->order='t.id desc';
        $criteria->limit=1;
        $planilla= Planilla::model()->find($criteria);
        $fechamax=date ("d-m-Y",strtotime( $planilla->fechafc));
        $ltipocontratos = Tipocontrato::model()->findAll();
        $listatipo=Yii::app()->rrhh->createCommand("(select id,nombre from general.tipopermiso where eliminado=false) union
                (select 200::int as id, 'VACACIONES'::varchar(60) as nombre ) union ( select 201::int as id,'BANCO HORAS'::varchar(60) as nombre ) order by nombre asc " )
                        ->queryAll();
        $this->renderPartial('reportehoraefectivas',array(
            'model'=>$model,
            'listaareas' => $listaareas,
            'listatipo'=>$listatipo,
            'ltipocontratos'=>$ltipocontratos,
            'fechamaxima'=>$fechamax
        ), false, true);
        
    }
    public function actionImprimirReporteHorasefectivas() {
        $fechadesde = $_GET['Empleado']['fechadesde'];
        $fechahasta = $_GET['Empleado']['fechahasta'];
        $sexo= $_GET['Empleado']['sexo'];
        $areas= $_GET['area'];
        $tipopermiso=$_GET['tipo'];
        $tipocontratos= $_GET['tipocontrato'];
        $espormes=$_GET['Empleado']['mes'];
        $areasseleccionadas = '';
        $tipopermisoseleccionado = '';
         
        $tipocontratosseleccionados = '';
        $cantidad=count($areas)*5+10;
         for ($i = 0; $i <count($tipocontratos); $i++) {
                        $tipocontratosseleccionados = $tipocontratosseleccionados . $tipocontratos[$i] . ',';
                        
                    }
        $tipocontratosseleccionados = substr($tipocontratosseleccionados, 0, -1);
        for ($i = 0; $i < count($areas); $i++) {
                        $areasseleccionadas = $areasseleccionadas . $areas[$i] . ',';
                    }
        $areasseleccionadas= substr($areasseleccionadas, 0, -1);
    
   
        for ($i = 0; $i < count($tipopermiso); $i++) {
                        $tipopermisoseleccionado = $tipopermisoseleccionado . $tipopermiso[$i] . ',';
                    }
        $tipopermisoseleccionado= substr($tipopermisoseleccionado, 0, -1); 
        $datoEmpresa = Yii::app()->rrhh->createCommand("select * from  general.empresa en limit 1 " )->queryRow();
        $nombrecolumna='';
        if ($espormes==0){
            $datoPlanilla = Yii::app()->rrhh
                    ->createCommand(" select  * from horasefectivames('$fechadesde'::date, '$fechahasta'::date ,'$sexo'::varchar(20), '$areasseleccionadas','$tipopermisoseleccionado','$tipocontratosseleccionados')")
                    ->queryAll();
            $nombrecolumna='MESES';
            
        }
        else
        {
            $datoPlanilla = Yii::app()->rrhh
                ->createCommand(" select  * from horasefectivasemana('$fechadesde'::date, '$fechahasta'::date ,'$sexo'::varchar(20), '$areasseleccionadas','$tipopermisoseleccionado','$tipocontratosseleccionados')")
                ->queryAll();
            $nombrecolumna='SEMANAS';
            
        }
            
       $titulo = Yii::app()->rrhh
                ->createCommand("select  STRING_AGG ( nombre, ',' order by nombre asc ) from general.area where id in ($areasseleccionadas) ")
                ->queryScalar();
      
     
        
     $cabeceraPlanilla = Yii::app()->rrhh
                ->createCommand(" 
                ( select 0::int id , '$nombrecolumna':: varchar(60) as nombre, 'messemana'::varchar(60) as nombref,1::int as orden,0::int as  tipo ) 
               union
                ( select 0::int id , 'FERIADOS':: varchar(60) as nombre, 'feriados'::varchar(60) as nombref,3::int as orden ,0::int as  tipo )  
                union

                (select id, nombre, replace(nombre,' ','')::varchar(60) as nombref ,ROW_NUMBER () OVER (ORDER BY nombre asc) ::int +3 AS orden ,1::int as  tipo from general.tipopermiso
                 where eliminado=false and id in($tipopermisoseleccionado))union (select  0::int as id, 'VACACIÓN'::varchar(60),'VACACION'::varchar(60) as nombref,201::int tipo ,1::int as  tipo WHERE 200 IN( $tipopermisoseleccionado ) )

                union

                (select  0::int as id, 'BANCO HORAS'::varchar(60),'BANCOHORAS'::varchar(60) as nombref,200::int as orden ,1::int as  tipo  WHERE 201 IN( $tipopermisoseleccionado ) )
                union
                ( select 0::int id , 'TOTAL HRS.  NO TRABAJADAS':: varchar(60) as nombre, 'horasnotrabajadas'::varchar(60) as nombref,205::int as orden,3::int as  tipo )
                 union
                ( select 0::int id , 'HORAS PROGRAMADAS':: varchar(60) as nombre, 'horasprogramadas'::varchar(60) as nombref,206::int as orden,0::int as  tipo )
                
                union
                ( select 0::int id , 'TOTAL HRS. EFECTIVAS TRABAJADAS':: varchar(60) as nombre, 'totalhorasefectivas'::varchar(60) as nombref,207::int as orden ,3::int as  tipo ) 
                union
                ( select 0::int id , 'HORAS NO TRBAJADAS POR PERSONA':: varchar(60) as nombre, 'horasnotrabajadaspersona'::varchar(60) as nombref,208::int as orden ,3::int as  tipo )
                                union
                ( select 0::int id , 'DIAS NO TRABAJADO POR PERSONA':: varchar(60) as nombre, 'diasnotrabajadospersona'::varchar(60) as nombref,209::int as orden ,3::int as  tipo )
                  order by orden asc, tipo asc")
                ->queryAll();
        $nombreArchivo = 'HRS_EFECT' . $fechadesde.'_'.$fechahasta;
        $numcol = Yii::app()->rrhh
                ->createCommand("select  count(*) from (
                ( select 0::int id , 'MESES':: varchar(60) as nombre ) 
               union
                ( select 0::int id , 'FERIADOS':: varchar(60) as nombre )  
                union

                (select id, nombre from general.tipopermiso
                 where eliminado=false and id in($tipopermisoseleccionado))union "
                        . " (select  0::int as id, 'VACACIÓN'::varchar(60)  WHERE 200 IN( $tipopermisoseleccionado ) )

                union

                (select  0::int as id, 'BANCO HORAS'::varchar(60) where 201 IN( $tipopermisoseleccionado ) )
                union
                ( select 0::int id , 'TOTAL HRS.  NO TRABAJADAS':: varchar(60) as nombre  )
                 union
                ( select 0::int id , 'HORAS PROGRAMADAS':: varchar(60) as nombre )
                
                union
                ( select 0::int id , 'TOTAL HRS. EFECTIVAS TRABAJADAS':: varchar(60) as nombre  ) 
                union
                ( select 0::int id , 'HORAS NO TRBAJADAS POR PERSONA':: varchar(60) as nombre  )
                                union
                ( select 0::int id , 'DIAS NO TRABAJADO POR PERSONA':: varchar(60) as nombre   )
                   ) as t")
                ->queryScalar();
        $columnas = $this->dameColumna('A', $numcol);
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);

        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $activeSheet->setTitle($nombreArchivo);
        $activeSheet->getDefaultColumnDimension()->setWidth(9.7);
        $activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 7);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $phpFont = array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
        $phpFont1 = array('font' => array(
                'bold' => true,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            )
        );
        $phpFontC = array('font' => array(
                'bold' => true,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $phpFont2 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        ));
        $phpFont3 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        ));

        $phpFontP = array(
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
            ),);       
       
        $activeSheet->getPageMargins()->setTop(0.8);
        $activeSheet->getPageMargins()->setRight(0.2);
        $activeSheet->getPageMargins()->setLeft(0.2);
        $activeSheet->getPageMargins()->setBottom(0.4);
        $phpColor = new PHPExcel_Style_Color();
        $phpColor->setRGB('FF0000');
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);
        $kFila = 8;
        $img = realpath(__DIR__ . '/../../../../images'); // Provide path to your logo file
        $imgot = $img . '/logoEmpresa.png';
        $objDrawingt = new PHPExcel_Worksheet_Drawing();
        $objDrawingt->setName('imgNotice');
        $objDrawingt->setDescription('Noticia');
        $objDrawingt->setPath($imgot);
        $objDrawingt->setOffsetX(5);    // setOffsetX works properly
        $objDrawingt->setOffsetY(0);  //setOffsetY has no effect
        $objDrawingt->setCoordinates('A1');
        $objDrawingt->setWidthAndHeight(140, 70);
        $objDrawingt->setResizeProportional(true);
        $objDrawingt->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
        $activeSheet->getRowDimension(7)->setRowHeight(52);
        $activeSheet->getRowDimension(1)->setRowHeight(14);
        $activeSheet->getRowDimension(2)->setRowHeight(8);
       
        $activeSheet->getRowDimension(3)->setRowHeight($cantidad);
        $activeSheet->getRowDimension(4)->setRowHeight(8);
        $activeSheet->getRowDimension(5)->setRowHeight(20);
        $activeSheet->getRowDimension(6)->setRowHeight(8);

        //CABECERA DE LA PLANILLA
      
        $activeSheet->mergeCells('B1:'.$columnas[$numcol-1] .'1');
        $activeSheet->mergeCells('B2:'.$columnas[$numcol-1] .'2');
        $activeSheet->mergeCells('B3:'.$columnas[$numcol-1] .'3');
        $activeSheet->mergeCells('B4:'.$columnas[$numcol-1] .'4');
        $activeSheet->mergeCells('B5:'.$columnas[$numcol-1] .'5');
        $activeSheet->mergeCells($columnas[$numcol-3] .'1:'.$columnas[$numcol-1].'1');
        $activeSheet->mergeCells($columnas[$numcol-3] .'2:'.$columnas[$numcol-1].'2');
        $activeSheet->mergeCells($columnas[$numcol-3] .'3:'.$columnas[$numcol-1].'3');
        $activeSheet->mergeCells($columnas[$numcol-3] .'4:'.$columnas[$numcol-1].'4');
        $activeSheet->mergeCells($columnas[$numcol-3] .'5:'.$columnas[$numcol-1].'5');       
        $activeSheet->setCellValue('B1', strtoupper("HORAS EFECTIVAS  "));
        $activeSheet->setCellValue('B3', $titulo);
        $activeSheet->setCellValue('B5', strtoupper("DEL ".$fechadesde.' AL '.$fechahasta));
        $activeSheet->getStyle("B3")->getAlignment()->setWrapText(true);  
        $htmlHelper = new \PHPExcel_Helper_HTML();
         $activeSheet->getStyle("B1")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(12);
        $activeSheet->getStyle("B1")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("B3:B5")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(11);
        
        $activeSheet->getStyle("B3:B5")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
      
        // COLUMNAS STATICAS
     
        $ind = 0;
        $indaux=0;
        $activeSheet->getStyle('A7:'.$columnas[$numcol-1].'7')->applyFromArray($phpFontC);
        $activeSheet->getStyle("A7:".$columnas[$numcol-1]."7")->getAlignment()->setWrapText(true);
        foreach ($cabeceraPlanilla as $cp) {
           
             $activeSheet->getColumnDimension($columnas[$ind+1])->setWidth(16);
             $activeSheet->setCellValue($columnas[$ind] . '7', $cp['nombre']);
             ++$ind;
           
           
              
            
        }
        $activeSheet->getColumnDimension('A')->setWidth(40);
      
        
        ///CUERPO
        
       for ($i = 0; $i < count($datoPlanilla); $i++) {
           
            $ind = 0;
          
            $lista = json_decode($datoPlanilla[$i]['permisos'], true);
            foreach ($cabeceraPlanilla as $cp) {
                $activeSheet->getRowDimension($kFila)->setRowHeight(25); 
                $activeSheet->getStyle('A'.$kFila.':'.$columnas[$numcol-1].$kFila)->applyFromArray($phpFont3);
                $activeSheet->getStyle('B'. $kFila.':'.$columnas[$numcol] . $kFila)->getNumberFormat()->setFormatCode('0.00');
            
                if ($cp['tipo']==1){
                        $baux = false;
                        $valor=$lista[0][$cp['nombref']];
                      
                    
                    
                 $activeSheet->setCellValue($columnas[$ind] . $kFila, $valor);
                 
             }
             elseif ($cp['tipo']=='0') {
                 $activeSheet->setCellValue($columnas[$ind] . $kFila, $datoPlanilla[$i][$cp['nombref']]);
               
            }
             else{
                 if($cp['nombref']=='horasnotrabajadas'){
                     $activeSheet->setCellValue($columnas[$ind] . $kFila,'=sum('.$columnas[1].$kFila.':'.$columnas[$ind-1].$kFila.')');
                 }
                 elseif ($cp['nombref']=='totalhorasefectivas') {
                  $activeSheet->setCellValue($columnas[$ind] . $kFila,'='.$columnas[$ind-1].$kFila.' - '.$columnas[$ind-2].$kFila);
         
             }
             elseif ($cp['nombref']=='horasnotrabajadaspersona') {
             $activeSheet->setCellValue($columnas[$ind] . $kFila,'=round('.$columnas[$ind-3].$kFila.'/'.$datoPlanilla[$i]['cantidadempleados'].',2)');
         
         }
             else{
                      $activeSheet->setCellValue($columnas[$ind] . $kFila,'=round('.$columnas[$ind-1].$kFila.' / '.$datoPlanilla[$i]['jornadalaboralpromedio'].',2)');
                 }
                 
                   
             }
           
             $ind=$ind+1;
             
                
                
            }
            

            $kFila++;
            
        }   
               $activeSheet->mergeCells('A'.$kFila.':'.$columnas[$numcol-3] .$kFila);
               $activeSheet->setCellValue('A'.$kFila,'TOTALES');
                $activeSheet->setCellValue($columnas[$numcol-2].$kFila,'=sum('.$columnas[$numcol-2].'8:'.$columnas[$numcol-2].$kFila.')');
               $activeSheet->setCellValue($columnas[$numcol-1].$kFila,'=sum('.$columnas[$numcol-1].'8:'.$columnas[$numcol-1].$kFila.')');
               $activeSheet->getStyle('A'.$kFila.':'.$columnas[$numcol-1].$kFila)->applyFromArray($phpFont3)->getFont()->setBold(true);
                $activeSheet->getStyle("A".$kFila)->getFont()->setBold(true);
               
        $this->descargarExcel($objPHPExcel, $nombreArchivo);
         
    }
    public function actionIndiceDesersion() {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $model=new Empleado;
        $gestion= Yii::app()->rrhh
                ->createCommand("select id,case when esquema='public' and (date_part('year',inicio)=date_part('year',fin)) then date_part('year',fin)::text when esquema='public'  then  (date_part('year',inicio)||'-'||date_part('year',fin)) else esquema end as esquema  from general.gestion where valida=true")
                ->queryAll();
        $ltipocontratos = Tipocontrato::model()->findAll();
        $this->renderPartial('indicedesersion',array(
            'model'=>$model,
            'gestion'=>$gestion,
            'ltipocontratos'=>$ltipocontratos
        ), false, true); 
    }
    public function actionDescargarReporteIndiceDesersion() {
        $desde=$_GET['Empleado']['fechadesde'];
        $hasta=$_GET['Empleado']['fechahasta'];
        $tipocontratos=$_GET['tipocontrato'];
        $tipocontratosseleccionados='';
        
        for ($i = 0; $i < count($tipocontratos); $i++) {
                        $tipocontratosseleccionados = $tipocontratosseleccionados . $tipocontratos[$i] . ',';
                    }
                    $tipocontratosseleccionados = substr($tipocontratosseleccionados, 0, -1);

                   
        $datoEmpresa = Yii::app()->rrhh
                        ->createCommand("select * from general.empresa where eliminado=false " )
                        ->queryAll()[0];
        $nombreMeses = Yii::app()->rrhh
                ->createCommand(" select dame_nombremesesgestion() as nombre ")
                ->queryAll();
        $numeroColumnas = Yii::app()->rrhh
                ->createCommand(" select count(*)*4 from general.gestion where  id between $desde and $hasta ")
                ->queryScalar();
        $gestiones = Yii::app()->rrhh
                ->createCommand(" select id, case when esquema='public' and (date_part('year',inicio)=date_part('year',fin)) then date_part('year',fin)::text when esquema='public' then  (date_part('year',inicio)||'-'||date_part('year',fin)) else esquema end as esquema from general.gestion where valida=true and id between $desde and $hasta order by id asc ")
                ->queryAll();
        $numeroColumnas=$numeroColumnas+1;
        $columnas= $this->dameColumna('A', $numeroColumnas);         
        $subTitulo = Yii::app()->rrhh
                ->createCommand("  select  string_agg(anio::text,' AL ') from   ((select  date_part('year',inicio) as anio from general.gestion where id =$desde) union(select  date_part('year',fin) as anio from general.gestion where id = $hasta)) as t ")
                ->queryScalar();
        $subTitulo2 = Yii::app()->rrhh
                ->createCommand("  select  string_agg(nombre::text,',') from general.tipocontrato where id in  ($tipocontratosseleccionados)  ")
                ->queryScalar();
       $listaEmpleados = Yii::app()->rrhh
                ->createCommand("select *,(select nombre from general.tipocontrato where id=idtipocontrato) as contrato from(select p.nombrecompleto,to_char(fechaplanilla,'dd-mm-YYYY') as fechaingreso, to_char(fecharetiro,'dd-mm-YYYY') as fecharetiro,
(select puesto from  public.damepuestot( hee.fechaplanilla, hee.fecharetiro, hee.idempleado)) ,  ( select c.idtipocontrato from  contrato c  inner join historialcontrato hc  on c.id =hc.idcontrato  where     c.eliminado=false and c.idhistorialestadoempleado=(case when hee.activo=0 then ( select  he.id from general.historialestadoempleado he where he.eliminado=false and he.idempleado=hee.idempleado and he.id<hee.id order by he.id desc limit 1)else hee.id end )  and hc.fecharegistro<=( select fin from general.gestion where id=$hasta) order by fecharegistro desc limit 1)
    from general.historialestadoempleado hee  inner join  general.empleado e on e.id=hee.idempleado  inner join general.persona p on p.id=e.idpersona where hee.eliminado=false and hee.fecharetiro between (select inicio from general.gestion where id=$desde) and (select fin from general.gestion where id=$hasta) and hee.activo=0  order by p.nombrecompleto asc ) as t where t.idtipocontrato in ($tipocontratosseleccionados)  ")
                ->queryAll();     
        
        $nombreArchivo = 'Indice '.$subTitulo ;
       
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);
        
        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $activeSheet->setTitle($nombreArchivo);
        $activeSheet->getDefaultColumnDimension()->setWidth(9.7);
        $activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 7);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $phpFont = array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
       
        $phpFontC = array('font' => array(
                'bold' => true,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $phpFont2 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        ));
        $phpFont3 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        ));

       

        $activeSheet->getColumnDimension('A')->setWidth(40);
        
        $activeSheet
                ->getPageMargins()->setTop(0.8);
        $activeSheet
                ->getPageMargins()->setRight(0.2);
        $activeSheet
                ->getPageMargins()->setLeft(0.2);
        $activeSheet
                ->getPageMargins()->setBottom(0.4);
        $phpColor = new PHPExcel_Style_Color();
        $phpColor->setRGB('FF0000');
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);
        $kFila = 9;
        $img = realpath(__DIR__ . '/../../../../images'); // Provide path to your logo file

        $imgot = $img . '/logoEmpresa.png';


        $objDrawingt = new PHPExcel_Worksheet_Drawing();
        $objDrawingt->setName('imgNotice');
        $objDrawingt->setDescription('Noticia');
        $objDrawingt->setPath($imgot);
        $objDrawingt->setOffsetX(5);    // setOffsetX works properly
        $objDrawingt->setOffsetY(0);  //setOffsetY has no effect
        $objDrawingt->setCoordinates('A1');
        $objDrawingt->setWidthAndHeight(140, 70);
        $objDrawingt->setResizeProportional(true);
        $objDrawingt->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
        $activeSheet->getRowDimension(7)->setRowHeight(40);
        $activeSheet->getRowDimension(1)->setRowHeight(14);
        $activeSheet->getRowDimension(2)->setRowHeight(8);
        $activeSheet->getRowDimension(3)->setRowHeight(13);
        $activeSheet->getRowDimension(4)->setRowHeight(15);
        $activeSheet->getRowDimension(5)->setRowHeight(25);
        $activeSheet->getRowDimension(8)->setRowHeight(40);

        //CABECERA DE LA PLANILLA

        $activeSheet->mergeCells('A1:'.$columnas[$numeroColumnas-1].'1');
        $activeSheet->mergeCells('A2:'.$columnas[$numeroColumnas-1].'2');
        $activeSheet->mergeCells('A3:'.$columnas[$numeroColumnas-1].'3');
        $activeSheet->mergeCells('A4:'.$columnas[$numeroColumnas-1].'4');
        $activeSheet->mergeCells('A5:'.$columnas[$numeroColumnas-1].'5');
        $activeSheet->mergeCells('A6:'.$columnas[$numeroColumnas-1].'6');
        $activeSheet->setCellValue('A1', strtoupper("ÍNDICE DE DESERCIÓN" ));
        $activeSheet->setCellValue('A3', 'DEL '.$subTitulo);
        $activeSheet->setCellValue('A5', $subTitulo2);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $activeSheet->setCellValue('F1', $datoEmpresa['direccion']);
        $activeSheet->setCellValue('F2', "NIT:" . $datoEmpresa['nit']);
        $activeSheet->setCellValue('F3', "TEL:" . $datoEmpresa['telefono'] . "   FAX:" . $datoEmpresa['fax']);
        $activeSheet->getStyle("A1")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(14);
        $activeSheet->getStyle("A1")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("A3")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(12);
        $activeSheet->getStyle("A3:A5")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("A5")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(10);
        
        $activeSheet->getStyle("P1:P5")->getFont()->setBold(false)
                ->setName('Times New Roman')
                ->setSize(7);
        // CABECERA  Y SUBCABECERA
        $activeSheet->getStyle('A7:'.$columnas[$numeroColumnas-1].'7')->applyFromArray($phpFontC);
        $activeSheet->getStyle("A7:".$columnas[$numeroColumnas-1]."7")->getAlignment()->setWrapText(true);
        $activeSheet->getStyle('A8:'.$columnas[$numeroColumnas-1].'8')->applyFromArray($phpFontC);
        $activeSheet->getStyle("A8:".$columnas[$numeroColumnas-1]."8")->getAlignment()->setWrapText(true);
        $activeSheet->getStyle("A5")->getAlignment()->setWrapText(true);
        
        $inicio=1;
        
         for($i=0;$i< count($gestiones);$i++){
             $kFila=9;
             $activeSheet->getColumnDimension('A')->setWidth(30);
             $activeSheet->mergeCells($columnas[$inicio].'7:'.$columnas[$inicio+3].'7');
             $activeSheet->setCellValue($columnas[$inicio].'7',$gestiones[$i]['esquema'] );
             $activeSheet->getColumnDimension($columnas[$inicio])->setWidth(20);
             $activeSheet->getColumnDimension($columnas[$inicio+1])->setWidth(20);
             $activeSheet->getColumnDimension($columnas[$inicio+2])->setWidth(20);
             $activeSheet->getColumnDimension($columnas[$inicio+3])->setWidth(20);
             $activeSheet->setCellValue($columnas[$inicio].'8','MUJERES' );
             $activeSheet->setCellValue($columnas[$inicio+1].'8','VARONES' );
             $activeSheet->setCellValue($columnas[$inicio+2].'8','RETIROS' );
             $activeSheet->setCellValue($columnas[$inicio+3].'8','NRO. PERSONAS' );
              /// cuerpo
              $cuerpo = Yii::app()->rrhh
                ->createCommand(" select * from  dame_retiradogestion(".$gestiones[$i]['id'].",'$tipocontratosseleccionados')  ")
                ->queryAll();
               for($j=0;$j<count($cuerpo);$j++){
                    $activeSheet->setCellValue($columnas[$inicio].$kFila ,$cuerpo[$j]['cantmujeres'] );
                    $activeSheet->setCellValue($columnas[$inicio+1].$kFila,$cuerpo[$j]['cantvarones'] );
                    $activeSheet->setCellValue($columnas[$inicio+2].$kFila,'='.$columnas[$inicio+1].$kFila.'+'.$columnas[$inicio].$kFila );
                    $activeSheet->setCellValue($columnas[$inicio+3].$kFila,$cuerpo[$j]['totalpersonal'] );
                    $kFila++;
               }
                $activeSheet->mergeCells($columnas[$inicio].$kFila.':'.$columnas[$inicio+1].$kFila);
                $activeSheet->setCellValue($columnas[$inicio+2].$kFila,'=sum('.$columnas[$inicio+2].'9:'.$columnas[$inicio+2].$kFila.')' );
                $activeSheet->setCellValue($columnas[$inicio+3].$kFila,'=sum('.$columnas[$inicio+3].'9:'.$columnas[$inicio+3].$kFila.')' );
                $kFila++;
                $activeSheet->mergeCells($columnas[$inicio].$kFila.':'.$columnas[$inicio+2].$kFila);
                $activeSheet->setCellValue($columnas[$inicio+3].$kFila,'=round('.$columnas[$inicio+2].($kFila-1).'/'.$columnas[$inicio+3].($kFila-1).',3)' );
                
                
             $inicio+=4;
         }
         $kFila=9;
       

        ///CUERPO
      
        for ($i =0 ; $i < count($nombreMeses); $i++) {
            $activeSheet->getRowDimension($kFila)->setRowHeight(23);
            $activeSheet->getStyle('B' . $kFila.':'.$columnas[$numeroColumnas-1].$kFila)->applyFromArray($phpFont2);
            $activeSheet->setCellValue('A'.$kFila,$nombreMeses[$i]['nombre'] );   
           
            $kFila++;
        }
        $activeSheet->getStyle('B' . $kFila.':'.$columnas[$numeroColumnas-1].$kFila)->applyFromArray($phpFont2);
        $activeSheet->getStyle('A' . $kFila.':'.$columnas[$numeroColumnas-1].$kFila)->getFont()->setBold(true);
        $activeSheet->setCellValue('A'.$kFila,'PROMEDIO ANUAL' );
        $kFila++;
        $activeSheet->getStyle('A' . $kFila.':'.$columnas[$numeroColumnas-1].$kFila)->getFont()->setBold(true);
        $activeSheet->setCellValue('A'.$kFila,'ÍNDICE DE DESERCIÓN' );
        $activeSheet->getStyle('B' . $kFila.':'.$columnas[$numeroColumnas-1].$kFila)->applyFromArray($phpFont2);
        $activeSheet->getStyle('A9:A'.$kFila)->applyFromArray($phpFont3);
        $kFila+=5;   
        
        $activeSheet->mergeCells('A'.$kFila.':B'.($kFila+1));
        $activeSheet->mergeCells('A'.$kFila.':B'.$kFila);  
        $activeSheet->mergeCells('E'.$kFila.':F'.$kFila); 
        $activeSheet->mergeCells('E'.$kFila.':F'.($kFila+1));   
        $activeSheet->mergeCells('C'.$kFila.':D'.$kFila);
        $activeSheet->mergeCells('G'.$kFila.':H'.($kFila+1));
        $activeSheet->mergeCells('G'.$kFila.':H'.$kFila);  
        $activeSheet->getStyle('A'.$kFila.':H'.$kFila)->applyFromArray($phpFontC);
        $activeSheet->getStyle('A'.$kFila.':H'.$kFila)->getAlignment()->setWrapText(true);
        $activeSheet->setCellValue('A'.$kFila,'APELLIDOS Y NOMBRES' );   
        $activeSheet->setCellValue('C'.$kFila,'FECHAS' ); 
        $activeSheet->setCellValue('E'.$kFila,'CARGO' ); 
        $activeSheet->setCellValue('G'.$kFila,'TIPO DE CONTRATO' ); 
        $kFila++;
        $activeSheet->setCellValue('C'.$kFila,'INGRESO' );
        $activeSheet->setCellValue('D'.$kFila,'CONCLUSIÓN' );
        $activeSheet->getStyle('C'.$kFila.':D'.$kFila)->applyFromArray($phpFontC);
        $activeSheet->getStyle('C'.$kFila.':D'.$kFila)->getAlignment()->setWrapText(true);
        $kFila++;
        for ($i =0 ; $i < count($listaEmpleados); $i++) {
           
            $activeSheet->getStyle('A' . $kFila.':B'.$kFila)->applyFromArray($phpFont3);
            $activeSheet->getStyle('C' . $kFila.':D'.$kFila)->applyFromArray($phpFont2);
            $activeSheet->getStyle('E' . $kFila.':H'.$kFila)->applyFromArray($phpFont3);
            $activeSheet->mergeCells('A'.$kFila.':B'.$kFila);
            $activeSheet->mergeCells('E'.$kFila.':F'.$kFila);
            $activeSheet->mergeCells('G'.$kFila.':H'.$kFila);
            $activeSheet->setCellValue('A'.$kFila,$listaEmpleados[$i]['nombrecompleto'] );
            $activeSheet->setCellValue('C'.$kFila,$listaEmpleados[$i]['fechaingreso'] );
            $activeSheet->setCellValue('D'.$kFila,$listaEmpleados[$i]['fecharetiro'] );
            $activeSheet->setCellValue('E'.$kFila,$listaEmpleados[$i]['puesto'] );
            $activeSheet->setCellValue('G'.$kFila,$listaEmpleados[$i]['contrato'] );
            $kFila++;
        }
        $this->descargarExcel($objPHPExcel, $nombreArchivo);
        
    }
    public function actionReporteParaContrato() {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $model=new Empleado;
        $criteria=new CDbCriteria;             
        $criteria->order='t.nombre asc';
        $criteria->addCondition("t.enplanilla = true");
        $criteria->addCondition("t.idbonopadre is null");
        $criteria->addCondition("t.estado=true");
        $ltipocontratos = Tipocontrato::model()->findAll();
        $listaBonos = Bono::model()->findAll($criteria);
        $this->renderPartial('reporteparacontrato',array(
            'model'=>$model,
            'ltipocontratos'=>$ltipocontratos,
            'listaBonos'=>$listaBonos
        ), false, true); 
    }
    public function actionDescargarReporteIParaContrato() {
        $desde=$_GET['Empleado']['fechadesde'];
        $hasta=$_GET['Empleado']['fechahasta'];
        $tipocontratos=$_GET['tipocontrato'];
        $bonos=json_decode($_GET['tipo']);
        $tipocontratosseleccionados='';
        $bonosseleccionados='';
        
        for ($i = 0; $i < count($tipocontratos); $i++) {
                        $tipocontratosseleccionados = $tipocontratosseleccionados . $tipocontratos[$i] . ',';
                    }
                    $tipocontratosseleccionados = substr($tipocontratosseleccionados, 0, -1);
                   
                    foreach ($bonos as $b) {
                        if ($b->estado == '1') {
                           
                          $bonosseleccionados =$bonosseleccionados . $b->id.",";
                           
                        }
                    }
                    $bonosseleccionados = substr($bonosseleccionados, 0, -1);

                   
        $datoEmpresa = Yii::app()->rrhh
                        ->createCommand("select *,to_char(now(),'dd-mm-YYYY HH24:MI:SS') as fechareporte from general.empresa where eliminado=false " )
                        ->queryAll()[0];
        $listaBonos = Yii::app()->rrhh
                ->createCommand(" select id, nombre, nombref from general.bono where id in($bonosseleccionados)  order by nombre asc ")
                ->queryAll();
        $numeroColumnas = Yii::app()->rrhh
                ->createCommand(" select count(*) from general.bono where id in($bonosseleccionados) ")
                ->queryScalar()+10;    
        $columnas= $this->dameColumna('A', $numeroColumnas);         
       
        $subTituloContratos = Yii::app()->rrhh
                ->createCommand("  select  string_agg(nombre::text,',') from general.tipocontrato where id in  ($tipocontratosseleccionados)  ")
                ->queryScalar();
        //// AQUI ME QUEDE 
        $listaEmpleados = Yii::app()->rrhh
                ->createCommand("select *,(select nombre from general.tipocontrato where id=idtipocontrato) as contrato from
(select p.id ,( select  lista_bono_paracontrato(e.id,'$hasta'::date,'$bonosseleccionados'::text)) as bonos,(select count(*) from general.dependiente where eliminado=false and heredero=true and idpersona=p.id) as cantdependientes, case when p.complementoci='' then p.ci::text else p.ci||'-'||p.complementoci end  as ci,(select calle||' # '||numero from general.direccion d where  d.id=p.iddireccion) as direccion, p.nombrecompleto,to_char(fechaplanilla,'dd-mm-YYYY') as fechaingreso, to_char(fechafincontrato,'dd-mm-YYYY') as fechafincontrato,(select puesto from  public.damepuestot( hee.fechaplanilla, hee.fecharetiro,     hee.idempleado)) ,
    ( select c.idtipocontrato from 
 contrato c  inner join historialcontrato hc  on c.id=hc.idcontrato where hc.eliminado=false and  c.idhistorialestadoempleado=hee.id and fecharegistro<=
    '$hasta'::date order by hc.fecharegistro desc limit 1), public.damehaberb( '$desde','$hasta',hee.idempleado )as hb from general.historialestadoempleado hee  
inner join  general.empleado e on e.id=hee.idempleado inner join general.persona p on p.id=e.idpersona where hee.eliminado=false and hee.fechaplanilla between '$desde' and '$hasta' and hee.activo=1  order by p.nombrecompleto asc 
) as t where t.idtipocontrato in($tipocontratosseleccionados) ")
                ->queryAll();
       
        $nombreArchivo = 'PC_'.$desde.'_'.$hasta ;
       
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);
        
        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $activeSheet->setTitle($nombreArchivo);
        $activeSheet->getDefaultColumnDimension()->setWidth(9.7);
        $activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 7);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $phpFont = array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
       
        $phpFontC = array('font' => array(
                'bold' => true,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $phpFont2 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        ));
        $phpFont3 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        ));

       

        $activeSheet->getColumnDimension('A')->setWidth(45);
        $activeSheet->getColumnDimension('B')->setWidth(35);
        $activeSheet->getColumnDimension('C')->setWidth(45);
        $activeSheet->getColumnDimension('D')->setWidth(20);
        $activeSheet->getColumnDimension('E')->setWidth(35);
        $activeSheet->getColumnDimension('F')->setWidth(15);
        $activeSheet->getColumnDimension('G')->setWidth(15);
        $activeSheet->getColumnDimension('H')->setWidth(15);
        $activeSheet->getColumnDimension('I')->setWidth(15);
        $activeSheet->getColumnDimension('J')->setWidth(15);
        
        
        $activeSheet
                ->getPageMargins()->setTop(0.8);
        $activeSheet
                ->getPageMargins()->setRight(0.2);
        $activeSheet
                ->getPageMargins()->setLeft(0.2);
        $activeSheet
                ->getPageMargins()->setBottom(0.4);
        $phpColor = new PHPExcel_Style_Color();
        $phpColor->setRGB('FF0000');
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);
        $kFila = 9;
        $img = realpath(__DIR__ . '/../../../../images'); // Provide path to your logo file

        $imgot = $img . '/logoEmpresa.png';


        $objDrawingt = new PHPExcel_Worksheet_Drawing();
        $objDrawingt->setName('imgNotice');
        $objDrawingt->setDescription('Noticia');
        $objDrawingt->setPath($imgot);
        $objDrawingt->setOffsetX(5);    // setOffsetX works properly
        $objDrawingt->setOffsetY(0);  //setOffsetY has no effect
        $objDrawingt->setCoordinates('A1');
        $objDrawingt->setWidthAndHeight(140, 70);
        $objDrawingt->setResizeProportional(true);
        $objDrawingt->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
        $activeSheet->getRowDimension(7)->setRowHeight(40);
        $activeSheet->getRowDimension(1)->setRowHeight(14);
        $activeSheet->getRowDimension(2)->setRowHeight(8);
        $activeSheet->getRowDimension(3)->setRowHeight(13);
        $activeSheet->getRowDimension(4)->setRowHeight(15);
        $activeSheet->getRowDimension(5)->setRowHeight(25);
        $activeSheet->getRowDimension(8)->setRowHeight(40);

        //CABECERA DE LA PLANILLA

        $activeSheet->mergeCells('A1:'.$columnas[$numeroColumnas-1].'1');
        $activeSheet->mergeCells('A2:'.$columnas[$numeroColumnas-1].'2');
        $activeSheet->mergeCells('A3:'.$columnas[$numeroColumnas-1].'3');
        $activeSheet->mergeCells('A4:'.$columnas[$numeroColumnas-1].'4');
        $activeSheet->mergeCells('A5:'.$columnas[$numeroColumnas-1].'5');
        $activeSheet->mergeCells('A6:'.$columnas[$numeroColumnas-1].'6');
        $activeSheet->setCellValue('A1', strtoupper("REPORTE PARA CONTRATO" ));
        $activeSheet->setCellValue('A3', 'DEL '.$desde.' AL '.$hasta);
        $activeSheet->setCellValue('A5', $subTituloContratos);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $activeSheet->setCellValue('F1', $datoEmpresa['direccion']);
        $activeSheet->setCellValue('F2', "NIT:" . $datoEmpresa['nit']);
        $activeSheet->setCellValue('F3', "TEL:" . $datoEmpresa['telefono'] . "   FAX:" . $datoEmpresa['fax']);
        $activeSheet->getStyle("A1")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(14);
        $activeSheet->getStyle("A1")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("A3")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(12);
        $activeSheet->getStyle("A3:A5")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("A5")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(10);
        
        $activeSheet->getStyle("P1:P5")->getFont()->setBold(false)
                ->setName('Times New Roman')
                ->setSize(7);
        // CABECERA  Y SUBCABECERA
        $activeSheet->mergeCells('A7:D7');
        $activeSheet->mergeCells('E7:G7');
        $activeSheet->setCellValue('E7','HEREDEROS' );
        $activeSheet->mergeCells('J7:'.$columnas[$numeroColumnas-1].'7');
        
        $activeSheet->setCellValue('J7','SUELDO' );
        $activeSheet->getStyle('A7:'.$columnas[$numeroColumnas-1].'7')->applyFromArray($phpFontC);
        $activeSheet->getStyle("A7:".$columnas[$numeroColumnas-1]."7")->getAlignment()->setWrapText(true);
        
        $activeSheet->getStyle('A8:'.$columnas[$numeroColumnas-1].'8')->applyFromArray($phpFontC);
        $activeSheet->getStyle("A8:".$columnas[$numeroColumnas-1]."8")->getAlignment()->setWrapText(true);
        $activeSheet->setCellValue('A8','APELLIDOS Y NOMBRES' );
        $activeSheet->setCellValue('B8','CARGO' );
        $activeSheet->setCellValue('C8','DIRECCIÓN' );
        $activeSheet->setCellValue('D8','CÉDULA DE IDENTIDAD' );
        $activeSheet->setCellValue('E8','APELLIDOS Y NOMBRES' );
        $activeSheet->setCellValue('F8','EDAD' );
        $activeSheet->setCellValue('G8','PARENTESCO' );
        $activeSheet->setCellValue('H8','FECHA INICIO DEL CONTRATO' );
        $activeSheet->setCellValue('I8','FECHA FIN DEL CONTRATO' );
        $activeSheet->setCellValue('J8','HABER BÁSICO' );
        for($i=0;$i<$numeroColumnas-10;$i++){
             $activeSheet->setCellValue( $columnas[$i+10].'8',$listaBonos[$i]['nombre'] );
             $activeSheet->getColumnDimension($columnas[$i+10])->setWidth(15);
        }
        for ($i=0;$i<count($listaEmpleados);$i++)
        {
              $bonoempleado = json_decode($listaEmpleados[$i]['bonos'], true);
            if(($listaEmpleados[$i]['cantdependientes'])>=2){
                 $activeSheet->getStyle('A' . $kFila.':I'.($kFila+$listaEmpleados[$i]['cantdependientes']-1))->applyFromArray($phpFont3);
             $activeSheet->getStyle('J' . $kFila.':'.$columnas[$numeroColumnas-1].($kFila+$listaEmpleados[$i]['cantdependientes']-1))->applyFromArray($phpFont2);
              
             $activeSheet->mergeCells('A'.$kFila.':A'.($kFila+$listaEmpleados[$i]['cantdependientes']-1));
             $activeSheet->mergeCells('B'.$kFila.':B'.($kFila+$listaEmpleados[$i]['cantdependientes']-1));
             $activeSheet->mergeCells('C'.$kFila.':C'.($kFila+$listaEmpleados[$i]['cantdependientes']-1)); 
             $activeSheet->mergeCells('D'.$kFila.':D'.($kFila+$listaEmpleados[$i]['cantdependientes']-1));
             $activeSheet->mergeCells('H'.$kFila.':H'.($kFila+$listaEmpleados[$i]['cantdependientes']-1)); 
             $activeSheet->mergeCells('I'.$kFila.':I'.($kFila+$listaEmpleados[$i]['cantdependientes']-1)); 
             for ($k=9;$k<$numeroColumnas;$k++){
                 $activeSheet->mergeCells($columnas[$k].$kFila.':'.$columnas[$k].($kFila+$listaEmpleados[$i]['cantdependientes']-1));
             }
            
             
             
            }
             $activeSheet->getStyle('J' . $kFila.':'.$columnas[$numeroColumnas-1].$kFila)->getNumberFormat()->setFormatCode('0.00');
             $activeSheet->getStyle('A' . $kFila.':I'.$kFila)->applyFromArray($phpFont3);
             $activeSheet->getStyle('J' . $kFila.':'.$columnas[$numeroColumnas-1].$kFila)->applyFromArray($phpFont2);
             $activeSheet->setCellValue('A'.$kFila,$listaEmpleados[$i]['nombrecompleto'] );
             $activeSheet->setCellValue('B'.$kFila,$listaEmpleados[$i]['puesto'] );
             $activeSheet->setCellValue('C'.$kFila,$listaEmpleados[$i]['direccion']);
             $activeSheet->setCellValue('D'.$kFila,$listaEmpleados[$i]['ci'] );
             $activeSheet->setCellValue('H'.$kFila,$listaEmpleados[$i]['fechaingreso'] );
             $activeSheet->setCellValue('I'.$kFila,$listaEmpleados[$i]['fechafincontrato'] );
             $activeSheet->setCellValue('J'.$kFila,$listaEmpleados[$i]['hb'] );
              for ($k=10;$k<$numeroColumnas;$k++){
                $nombreBono=$listaBonos[$k-10]['nombref'] ;
                $activeSheet->setCellValue($columnas[$k].$kFila,$bonoempleado[0][$nombreBono]);
             }
             $lista = Yii::app()->rrhh
                ->createCommand("select nombrec, ( extract(YEAR FROM age('".$listaEmpleados[$i]['fechaingreso']."'::date,fechanacr))::int) as edad,(select parentescod from general.parentesco where id=d.idparentesco) from general.dependiente d where eliminado=false  and d.heredero=true and idpersona= ".$listaEmpleados[$i]['id'])
                ->queryAll();
         
            for($j=0;$j<count($lista);$j++){
                $activeSheet->setCellValue('E'.$kFila,$lista[$j]['nombrec'] );
                $activeSheet->setCellValue('F'.$kFila,$lista[$j]['edad'] );
                $activeSheet->setCellValue('G'.$kFila,$lista[$j]['parentescod'] );
                $kFila++;
            }
              if(count($lista)==0){
              $kFila++;}
        }
        
      
        
        $this->descargarExcel($objPHPExcel, $nombreArchivo);
        
    }
}
