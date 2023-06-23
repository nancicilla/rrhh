<?php
/*
 * PlanillaretroactivoController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 08/02/2022
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
class PlanillaretroactivoController extends Controller
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
        
        $model=new Planillaretroactivo;
        $lista=$model->listaMes();

        if(isset($_POST['Planillaretroactivo'])){
                $model->attributes=$_POST['Planillaretroactivo'];
                $modelo= Planillaretroactivo::model()->find('t.anio='.date("Y"));
                if (!isset($modelo)){
                if($model->save()){   
                        Yii::app()->rrhh
                        ->createCommand("SELECT registrar_informaciondistribuciondominical_retroactivo() ")->execute();
                              
                    echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {
                    echo System::hasErrors('Revise los datos! ', $model);
                return;
                }}else{
                    echo System::hasErrors('Ya existe Retroactivo para este año! ', $model);
                return; 
                }
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
        $lista=$model->listaMes();
        if(isset($_POST['Planillaretroactivo']))
        {
            $model->attributes=$_POST['Planillaretroactivo'];
            
            if($model->save()){
                Yii::app()->rrhh
                        ->createCommand("SELECT registrar_informaciondistribuciondominical_retroactivo() ")->execute();
          
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }

        $this->renderPartial('update',array(
            'model'=>$model,
            'lista'=>$lista
        ), false, true);
    }
    /**
     * 
     * @param integer $id, id de la Planilla de Retroactivo
     * @return interfaz para la generacion de la planilla
     */
 public function actionGenerarPlanilla($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=$this->loadModel(SeguridadModule::dec($id));
        $model->scenario='Desea Generar la Planilla de Retroactivo ?';
        if(isset($_POST['Planillaretroactivo']))
        {
            $model->attributes=$_POST['Planillaretroactivo'];
            Yii::app()->rrhh
                        ->createCommand("SELECT registrar_informacion_retroactivo() ")->execute();
            Yii::app()->rrhh
                        ->createCommand("update planillaretroactivo set estado=1 where id=".$model->id)->execute();
                
            if(true){
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }

        $this->renderPartial('mensaje',array(
            'model'=>$model,
            
        ), false, true);
    }
     /**
      * 
      * @param integer $id, id planilla 
      * @return interfaz para dar de baja la planilla
      */
     public function actionDarbajaplanilla($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=$this->loadModel(SeguridadModule::dec($id));
        $model->scenario='Desea Dar de Baja la Planilla de Retroactivo ?';
        if(isset($_POST['Planillaretroactivo']))
        {
            $model->attributes=$_POST['Planillaretroactivo'];
            $model->estado=$model->estado-1;
                         
            if($model->save()){
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }

        $this->renderPartial('mensaje',array(
            'model'=>$model,
            
        ), false, true);
    }
    /**
     * 
     * @param integer $id, id de la planilla
     * @return interfaz para la consolidacion de la planilla de Reroactivo
     */
     public function actionConsolidarPlanilla($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=$this->loadModel(SeguridadModule::dec($id));
        $model->scenario='Desea Consolidar la Planilla de Retroactivo ?';
        if(isset($_POST['Planillaretroactivo']))
        {
            $model->attributes=$_POST['Planillaretroactivo'];
            $model->estado=2;
                         
            if($model->save()){
                Planillaretroactivo::model()->ConsolidarPlanilla($model->id,$_POST['Planillaretroactivo']['fechapago']);
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }

        $this->renderPartial('consolidar',array(
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

        $model=new Planillaretroactivo('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Planillaretroactivo'])){
                $model->attributes=$_GET['Planillaretroactivo'];
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
	 * @return Planillaretroactivo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Planillaretroactivo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Planillaretroactivo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='planillaretroactivo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        /**
         * 
         * @param integer $id, id de la planilla 
         * retorna interfaz para el Reporte de la Planilla Retroactiva    
         */
        public function actionDescargarPlanilla($id)
        {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=$this->loadModel(SeguridadModule::dec($id));
        $model->estado=true;
        $ltipocontratos = Tipocontrato::model()->findAll();
        $this->renderPartial('decargarplanilla',array(
            'model'=>$model,
            'ltipocontratos'=>$ltipocontratos
        ), false, true);
        }
        /**
         * @param interger  $_GET['Planillaretroactivo']['id'],id de la Planilla Retroactiva
         * @param integer[] $_GET['tipocontratos'], lista de contratos seleccionados
         * retorna planilla Retroactiva segun a los tipos de contratos
         */
        public function actionDescargarExcelPlanilla( ) {
          $id = $_GET['Planillaretroactivo']['id'];
          $listacontrato = $_GET['tipocontratos'];
             $tipocontratosseleccionados =''; 
        for ($i = 0; $i < count($listacontrato); $i++) {
                        $tipocontratosseleccionados = $tipocontratosseleccionados . $listacontrato[$i] . ',';
                    }
            $tipocontratosseleccionados = substr($tipocontratosseleccionados, 0, -1);

          
        $model=$this->loadModel($id);
       
        
        $datoEmpresa = Yii::app()->rrhh->createCommand("select e.*,pl.nombrer,pl.cir, 'Sucre,'||to_char(now(),'dd-mm-YYYY') as lugar from planilla pl inner join general.representante r on r.cirepresentante=pl.cir inner join general.empresa e on e.id=r.idempresa  where pl.id in(select  id from planilla where eliminado=false and mes=".$model->mesinicio." and anio=".$model->anio.")" )->queryAll()[0];
        $cabeceraPlanilla= Yii::app()->rrhh
                ->createCommand("
(select 'Nro'::text as nombre,'A8'::varchar(3) as celda)union
(select'CARNET DE IDENTIDAD'::text AS nombre ,'B8'::varchar(3) as celda)union
(select 'APELLIDOS Y NOMBRES'::text as nombre,'C8'::varchar(3) as celda)union
(select 'SEXO(F/M)'::text as nombre,'D8'::varchar(3) as celda)union
(select'OCUPACIÓN QUE DESEMPEÑA'::text as nombre,'E8'::varchar(3) as celda)union
(select 'FECHA DE INGRESO'::text as nombre,'F8'::varchar(3) as celda)union
(select'FECHA DE RETIRO'::text AS nombre ,'G8'::varchar(3) as celda)union
(select 'HABER BASICO EN LA PLANILLA DE DICIEMBRE '||(".$model->anio."-1)||' (Bs)'::text as nombre,'H8'::varchar(3) as celda)union
(select 'HABER BASICO CON INCREMENTO EN LA GESTION ".$model->anio." (Bs)'::text as nombre,'I8'::varchar(3)  as celda)union
(select * from dame_nombremeses_retroactivo(".$model->id."))union
(select 'TOTAL RETROACTIVO (Bs)'::text as nombre,'O8'::varchar(3))union
(select'AFP'::text AS nombre ,'P9'::varchar(3) as celda)union
(select 'RC-IVA'::text as nombre,'Q9'::varchar(3) as celda)union
(select 'OTROS DESCUENTOS'::text as nombre,'R9'::varchar(3) as celda)union
(select 'TOTAL DESCUENTOS (Bs)'::text as nombre,'S8'::varchar(3) as celda)union
(select'LIQUIDO PAGABLE (Bs)'::text AS nombre ,'T8'::varchar(3) as celda)union
(select 'FIRMA DEL EMPLEADO'::text as nombre,'U8'::varchar(3)as celda )  ")
                ->queryAll();
        $datoPlanilla  = Yii::app()->rrhh
                ->createCommand("select * from lista_planilla_retroactivo (".$model->id.",'$tipocontratosseleccionados'::text) ")
                ->queryAll();
     
        $cantcolAportacion = 3;
        $nombreArchivo = 'Retroactivo_'.$model->anio ;
        $numcol= 16+$model->mesfin;
        $letras=$this->dameColumna('A', $numcol);
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
        $activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 9);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $phpFontCuerpoGeneral = array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ), 'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
         $phpFontCuerpo= array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
        $phpFontCuerpoNumerico = array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ), 'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            
        );
        $phpFontCabecera = array('font' => array(
                'bold' => true,'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
         
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFontCuerpo);      
        for ($i=0;$i<count($letras);$i++){ $activeSheet->getColumnDimension($letras[$i])->setWidth(10);
         $activeSheet->getStyle($letras[$i]."8:".$letras[$i]."9")->getAlignment()->setWrapText(true);
         $activeSheet->getStyle($letras[$i]."8:".$letras[$i]."9")->applyFromArray($phpFontCabecera);
         }
        $activeSheet->getColumnDimension($letras[$i-1])->setWidth(45);
        $activeSheet->getColumnDimension('A')->setWidth(4);
        $activeSheet->getColumnDimension('C')->setWidth(35);
        $activeSheet->getColumnDimension('D')->setWidth(5);
        $activeSheet->getColumnDimension('E')->setWidth(15);
        $activeSheet
                ->getPageMargins()->setTop(0.4);
        $activeSheet
                ->getPageMargins()->setRight(0.2);
        $activeSheet
                ->getPageMargins()->setLeft(0.2);
        $activeSheet
                ->getPageMargins()->setBottom(0.8);
        $phpColor = new PHPExcel_Style_Color();
        $phpColor->setRGB('FF0000');
        $kFila = 10;
        $img = realpath(__DIR__ . '/../../../../images');
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
        $activeSheet->getRowDimension(8)->setRowHeight(30);
        $activeSheet->getRowDimension(9)->setRowHeight(50);
        $activeSheet->getRowDimension(1)->setRowHeight(18);
        $activeSheet->getRowDimension(2)->setRowHeight(18);
        $activeSheet->getRowDimension(3)->setRowHeight(18);
        $activeSheet->getRowDimension(4)->setRowHeight(18);
        $activeSheet->getRowDimension(5)->setRowHeight(18);
        $activeSheet->getRowDimension(6)->setRowHeight(18);

        //CABECERA DE LA PLANILLA

        $activeSheet->mergeCells('C1:F1');
        $activeSheet->mergeCells('C2:F2');
        $activeSheet->mergeCells('C3:F3');
        $activeSheet->mergeCells('C4:F4');
        $activeSheet->mergeCells('G1:'.$letras[$numcol-1].'1');
        $activeSheet->mergeCells('G3:'.$letras[$numcol-1].'3');
        $activeSheet->mergeCells('G4:'.$letras[$numcol-1].'4');
        $activeSheet->mergeCells('A5:'.$letras[$numcol-1].'5');
        $activeSheet->mergeCells('A6:'.$letras[$numcol-1].'6');
        $activeSheet->setCellValue('C1', 'NOMBRE O RAZÓN SOCIAL');
        $activeSheet->setCellValue('C2','TIPO DE IDENTIFICADOR');
        $activeSheet->setCellValue('C3', 'Nº DE IDENTIFICADOR');
        $activeSheet->setCellValue('C4', 'Nº DE EMPLEADOR (Caja de Salud)');
        $activeSheet->setCellValue('G1',$datoEmpresa['razonsocial']);
        $activeSheet->setCellValue('G2','X');
        $activeSheet->setCellValue('H2','NIT');
        $activeSheet->setCellValue('J2','SUB'); 
        $activeSheet->setCellValue('L2','OTRO'); 
        $activeSheet->setCellValue('G3',$datoEmpresa['nit'].' ');
        $activeSheet->setCellValue('G4',$datoEmpresa['nrempleador']);
        $activeSheet->setCellValue('A5','PLANILLA DE RETROACTIVO - INCREMENTO SALARIAL '.$model->anio);
        $activeSheet->setCellValue('A6','(En Bolivianos) ');
        $activeSheet->getStyle('A5')->getFont()->setBold(true)->setSize(14);
        $activeSheet->getStyle('A6')->getFont()->setSize(8);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $activeSheet->getStyle("A1")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(12);
        $activeSheet->getStyle("C1:C4")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(11);
        $activeSheet->getStyle("C1:C4")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("A5:A6")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("G2")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("I2")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ), 'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ), 'font' => array(
                'bold' => true,
        )));
       $activeSheet->getStyle("K2")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ), 'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ), 'font' => array(
                'bold' => true,
        )));
        for ($i=1;$i<=9;$i++)
        { 
            $letras=$this->dameColumna('A', $i);
            $activeSheet->mergeCells($letras[$i-1].'8:'.$letras[$i-1].'9'); 
        }
        $letras=$this->dameColumna('J',( $model->mesfin+1));
        $columnas=$letras;
        $activeSheet->mergeCells('J8:'.($letras[( $model->mesfin)]).'8'); 
        $activeSheet->setCellValue('J8','MONTOS (Bs)');
        $letras=$this->dameColumna('J',( $model->mesfin+2));
        $letra=$letras[( $model->mesfin+1)];
        $activeSheet->mergeCells($letras[( $model->mesfin+1)].'8:'.$letras[( $model->mesfin+1)].'9'); 
        $letras=$this->dameColumna($letra,6);
        $activeSheet->mergeCells( $letras[1].'8:'.$letras[3].'8'); 
        $activeSheet->setCellValue($letras[1].'8','DESCUENTOS (Bs)');        
        $activeSheet->mergeCells( $letras[4].'8:'.$letras[4].'9'); 
        $activeSheet->mergeCells( $letras[5].'8:'.$letras[5].'9'); 
        $activeSheet->mergeCells( $letras[6].'8:'.$letras[6].'9');
        $columnasfinal=$letras;
        $indice;
        foreach ($cabeceraPlanilla as $cp) {  
                    $activeSheet->setCellValue($cp['celda'], $cp['nombre']); 
        }
           ///CUERPO
        for ($i = 0; $i < count($datoPlanilla); $i++) {
            $activeSheet->getStyle("A".$kFila.":G". $kFila)->applyFromArray(
                        $phpFontCuerpoGeneral
            );
             $activeSheet->getRowDimension($kFila)->setRowHeight(25);
            $activeSheet->getStyle("A".$kFila.":G". $kFila)->getAlignment()->setWrapText(true);
            $activeSheet->getStyle("H".$kFila.":".$columnasfinal[6]. $kFila)->applyFromArray(
                        $phpFontCuerpoNumerico
            );
            $activeSheet->getStyle("H".$kFila.":".$columnasfinal[5]. $kFila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->setCellValue('A' . $kFila,($kFila-9));
            $activeSheet->setCellValue('B' . $kFila,$datoPlanilla[$i]['ci']);
            $activeSheet->setCellValue('C' . $kFila,$datoPlanilla[$i]['nombrecompleto']);
            $activeSheet->setCellValue('D' . $kFila,$datoPlanilla[$i]['sexo']);
            $activeSheet->setCellValue('E' . $kFila,$datoPlanilla[$i]['cargo']);
            $activeSheet->setCellValue('F' . $kFila,$datoPlanilla[$i]['fechaingreso']);
            $activeSheet->setCellValue('G' . $kFila,$datoPlanilla[$i]['fecharetiro']);
            $activeSheet->setCellValue('H' . $kFila,$datoPlanilla[$i]['haberbasicoantiguo']);
            $activeSheet->setCellValue('I' . $kFila,$datoPlanilla[$i]['haberbasiconuevo']);
            $indice=1;
            $sumaotrosbonos=0;
            
            
            $detallemontos = json_decode($datoPlanilla[$i]['detallemontos'], true);
            while ($indice <= ($model->mesfin)) {
                $activeSheet->setCellValue($columnas[$indice-1] . $kFila,$detallemontos[$indice-1]['hbasico']);
                $sumaotrosbonos+=$detallemontos[$indice-1]['totalabono'];
                $indice++;
            
            }
            $activeSheet->setCellValue($columnas[$model->mesfin].$kFila ,$sumaotrosbonos);
            $activeSheet->setCellValue($columnas[$model->mesfin+1].$kFila ,'=SUM('.$columnas[0].$kFila.':'.$columnas[$model->mesfin].$kFila.')');
            $activeSheet->setCellValue($columnas[$model->mesfin].$kFila ,$sumaotrosbonos);
            // columnas finales
            $activeSheet->setCellValue($columnasfinal[1].$kFila ,$datoPlanilla[$i]['afp']);
            $activeSheet->setCellValue($columnasfinal[2].$kFila ,$datoPlanilla[$i]['rciva']);
            $activeSheet->setCellValue($columnasfinal[3].$kFila ,$datoPlanilla[$i]['otrosdescuentos']);
            $activeSheet->setCellValue($columnasfinal[4].$kFila ,'=SUM('.$columnasfinal[1].$kFila.':'.$columnasfinal[3].$kFila.')');
            $activeSheet->setCellValue($columnasfinal[5].$kFila ,'='.$columnas[$model->mesfin+1].$kFila.'-'.$columnasfinal[4].$kFila);
         
            
            $kFila++;
        }
        $activeSheet->mergeCells( 'A'.$kFila.':G'.$kFila);
        $activeSheet->getStyle("A".$kFila.":".$columnasfinal[5]. $kFila)->applyFromArray(
                        $phpFontCuerpoNumerico
            );
        $activeSheet->getStyle("H".$kFila.":".$columnasfinal[5]. $kFila)->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle("A".$kFila.":".$columnasfinal[5]. $kFila)->getFont()->setBold(true);
         
       
        $activeSheet->setCellValue('A'.$kFila,'TOTALES');
        $activeSheet->setCellValue('H'.$kFila ,'=SUM(H10:H'.($kFila-1).')');
        $activeSheet->setCellValue('I'.$kFila ,'=SUM(I10:I'.($kFila-1).')');       
        $indice=1; 
        while ($indice <= ($model->mesfin+2)) {
                $activeSheet->setCellValue($columnas[$indice-1] . $kFila,'=SUM('.$columnas[$indice-1].'10:'.$columnas[$indice-1].($kFila-1).')');
                $indice++;
            
            }
        $activeSheet->setCellValue($columnasfinal[1].$kFila ,'=SUM('.$columnasfinal[1].'10:'.$columnasfinal[1].($kFila-1).')');
        $activeSheet->setCellValue($columnasfinal[2].$kFila ,'=SUM('.$columnasfinal[2].'10:'.$columnasfinal[2].($kFila-1).')');
        $activeSheet->setCellValue($columnasfinal[3].$kFila ,'=SUM('.$columnasfinal[3].'10:'.$columnasfinal[3].($kFila-1).')');
        $activeSheet->setCellValue($columnasfinal[4].$kFila ,'=SUM('.$columnasfinal[4].'10:'.$columnasfinal[4].($kFila-1).')');
        $activeSheet->setCellValue($columnasfinal[5].$kFila ,'=SUM('.$columnasfinal[5].'10:'.$columnasfinal[5].($kFila-1).')');
        $kFila+=6;
        $activeSheet->mergeCells('E'.$kFila.':I'.$kFila);
        $activeSheet->mergeCells('L'.$kFila.':N'.$kFila);
        $activeSheet->mergeCells('Q'.$kFila.':S'.$kFila);
        $activeSheet->mergeCells('Q'.($kFila-1).':S'.($kFila-1));
        $activeSheet->getStyle('E' . $kFila)->applyFromArray(array(
            'font' => array(
                'bold' => true
            ),'borders' => array(
                    'top' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    ),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )));
        $activeSheet->getStyle('L' . $kFila)->applyFromArray(array(
            'font' => array(
                'bold' => true
            ),'borders' => array(
                    'top' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    ),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )));
        $activeSheet->getStyle('Q' . $kFila)->applyFromArray(array(
            'font' => array(
                'bold' => true
            ),'borders' => array(
                    'top' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    ),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )));
        
        $activeSheet->getStyle('Q' . ($kFila-1))->applyFromArray(array(
          
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )));
        $activeSheet->setCellValue('E'.$kFila , 'NOMBRE DEL EMPLEADOR O REPRESENTANTE LEGAL');
        $activeSheet->setCellValue('L'.$kFila , 'FIRMA');
        $activeSheet->setCellValue('Q'.$kFila , 'LUGAR Y FECHA');
        $activeSheet->setCellValue('Q'.($kFila-1) , $datoEmpresa['lugar']);
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
     * 
     * @param string $letrai, nombre  de la columna (ejemplo,A,B,C,etc.)
     * @param int $cant, la cantidad de letras consecutivas despues de la $letrai
     * @return array de letras
     */
      public function dameColumna($letrai, $cant) {
        ///a 5  f
        ///a 5  f
        $letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $letracontante = substr($letrai, 0, -1);
        $letrainicio = substr($letrai, -1);
        $numletrai = strlen($letrai);
        $antepenultima = '';
        $vector = [];
        if ($numletrai > 1) {
            $antepenultima = substr($letrai, -2, -1);
            //echo '.antepenultima...>'.$antepenultima.'<br>';
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
//AA--->A
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
     * @param integer $_GET['id'], id planilla retroactiva 
     * retorna reporte Planilla Finiquito Retroactivo
     */
    public function actionDescargarPlanillafiniquito() {
        $id = $_GET['id'];
        $model=$this->loadModel(SeguridadModule::dec($id));
        $datoEmpresa = Yii::app()->rrhh->createCommand("select e.*,pl.nombrer,pl.cir, 'Sucre,'||to_char(now(),'dd-mm-YYYY') as lugar from planilla pl inner join general.representante r on r.cirepresentante=pl.cir inner join general.empresa e on e.id=r.idempresa  where pl.id in(select  id from planilla where eliminado=false and mes=".$model->mesinicio." and anio=".$model->anio.")" )->queryAll()[0];
        $cabeceraPlanilla= Yii::app()->rrhh
                ->createCommand("(select 'A8' as celda, 'Nro' as nombre, 1 as orden)union
(select 'C8' as celda,'Nombre Completo' as nombre, 3 as orden)union
(select 'B8' as celda,'C.I.' as nombre, 2 as orden)union
(select 'D8' as celda,'Deshaucio' as nombre, 4 as orden)union
(select 'E8' as celda,'Indemnizacion' as nombre, 5 as orden)union
(select 'F8' as celda,'Aguinaldo' as nombre, 6 as orden)union
(select 'G8' as celda,'Vacacion' as nombre, 7 as orden)union
(select 'H8' as celda,'Prima' as nombre, 8 as orden)union
(select 'I8' as celda,'Descuento RCIVA Vacacion' as nombre, 9 as orden)
union(select 'J8' as celda,'Liquido' as nombre, 10 as orden)
union(select 'K8' as celda,'Firma' as nombre, 11 as orden) order by orden asc
  ")
                ->queryAll();
        $datoPlanilla  = Yii::app()->rrhh
                ->createCommand("select * from dame_planilla_finiquitoretroactivo (".$model->id.") ")
                ->queryAll();
     
       
        $nombreArchivo = 'RetroactivoFiniquito_'.$model->anio ;
        $numcol= 11;
        $letras=$this->dameColumna('A', $numcol);
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
        $phpFontCuerpoGeneral = array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ), 'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
         $phpFontCuerpo= array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
        $phpFontCuerpoNumerico = array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ), 'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            
        );
        $phpFontCabecera = array('font' => array(
                'bold' => true,'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFontCuerpo);      
        for ($i=0;$i<count($letras)-1;$i++){ $activeSheet->getColumnDimension($letras[$i])->setWidth(15);
         $activeSheet->getStyle($letras[$i]."8:".$letras[$i]."9")->getAlignment()->setWrapText(true);
         $activeSheet->getStyle($letras[$i]."8:".$letras[$i]."9")->applyFromArray($phpFontCabecera);
         }
         $activeSheet->getColumnDimension($letras[$i-1])->setWidth(25);
        $activeSheet->getColumnDimension('A')->setWidth(4);
        $activeSheet->getColumnDimension('C')->setWidth(45);
        $activeSheet->getColumnDimension('K')->setWidth(45);
        $activeSheet
                ->getPageMargins()->setTop(0.4);
        $activeSheet
                ->getPageMargins()->setRight(0.2);
        $activeSheet
                ->getPageMargins()->setLeft(0.2);
        $activeSheet
                ->getPageMargins()->setBottom(0.8);
        $phpColor = new PHPExcel_Style_Color();
        $phpColor->setRGB('FF0000');
        $kFila = 10;
        $img = realpath(__DIR__ . '/../../../../images');
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
        $activeSheet->getRowDimension(8)->setRowHeight(20);
        $activeSheet->getRowDimension(9)->setRowHeight(20);
        $activeSheet->getRowDimension(1)->setRowHeight(18);
        $activeSheet->getRowDimension(2)->setRowHeight(18);
        $activeSheet->getRowDimension(3)->setRowHeight(18);
        $activeSheet->getRowDimension(4)->setRowHeight(18);
        $activeSheet->getRowDimension(5)->setRowHeight(18);
        $activeSheet->getRowDimension(6)->setRowHeight(18);

        //CABECERA DE LA PLANILLA

        $activeSheet->mergeCells('C1:F1');
        $activeSheet->mergeCells('C2:F2');
        $activeSheet->mergeCells('C3:F3');
        $activeSheet->mergeCells('C4:F4');
        $activeSheet->mergeCells('G1:'.$letras[$numcol-1].'1');
        $activeSheet->mergeCells('G3:'.$letras[$numcol-1].'3');
        $activeSheet->mergeCells('G4:'.$letras[$numcol-1].'4');
        $activeSheet->mergeCells('A5:'.$letras[$numcol-1].'5');
        $activeSheet->mergeCells('A6:'.$letras[$numcol-1].'6');
        $activeSheet->setCellValue('C1', 'NOMBRE O RAZÓN SOCIAL');
        $activeSheet->setCellValue('C2','TIPO DE IDENTIFICADOR');
        $activeSheet->setCellValue('C3', 'Nº DE IDENTIFICADOR');
        $activeSheet->setCellValue('C4', 'Nº DE EMPLEADOR (Caja de Salud)');
        $activeSheet->setCellValue('G1',$datoEmpresa['razonsocial']);
        $activeSheet->setCellValue('G2','NIT');         
        $activeSheet->setCellValue('G3',$datoEmpresa['nit'].' ');
        $activeSheet->setCellValue('G4',$datoEmpresa['nrempleador']);
        $activeSheet->setCellValue('A5','PLANILLA DE RETROACTIVO FINIQUITO - INCREMENTO SALARIAL '.$model->anio);
        $activeSheet->setCellValue('A6','(En Bolivianos) ');
        $activeSheet->getStyle('A5')->getFont()->setBold(true)->setSize(14);
        $activeSheet->getStyle('A6')->getFont()->setSize(8);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $activeSheet->getStyle("A1")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(12);
        $activeSheet->getStyle("C1:C4")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(11);
        $activeSheet->getStyle("C1:C4")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("A5:A6")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
        
       
        for ($i=1;$i<=11;$i++)
        { 
            $letras=$this->dameColumna('A', $i);
            $activeSheet->mergeCells($letras[$i-1].'8:'.$letras[$i-1].'9'); 
        }
       
        $indice;
        foreach ($cabeceraPlanilla as $cp) {  
                    $activeSheet->setCellValue($cp['celda'], $cp['nombre']); 
        }
           ///CUERPO
        for ($i = 0; $i < count($datoPlanilla); $i++) {
            $activeSheet->getStyle("A".$kFila.":G". $kFila)->applyFromArray(
                        $phpFontCuerpoGeneral
            );
            $activeSheet->getRowDimension($kFila)->setRowHeight(22);
            $activeSheet->getStyle("A".$kFila.":G". $kFila)->getAlignment()->setWrapText(true);
            $activeSheet->getStyle("D".$kFila.":K". $kFila)->applyFromArray(
                        $phpFontCuerpoNumerico
            );
            $activeSheet->getStyle("D".$kFila.":J". $kFila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->setCellValue('A' . $kFila,($kFila-9));
            $activeSheet->setCellValue('B' . $kFila,$datoPlanilla[$i]['ci']);
            $activeSheet->setCellValue('C' . $kFila,$datoPlanilla[$i]['nombrecompleto']);
            $activeSheet->setCellValue('D' . $kFila,$datoPlanilla[$i]['deshaucio']);
            $activeSheet->setCellValue('E' . $kFila,$datoPlanilla[$i]['indeminizacion']);
            $activeSheet->setCellValue('F' . $kFila,$datoPlanilla[$i]['aguinaldo']);
            $activeSheet->setCellValue('G' . $kFila,$datoPlanilla[$i]['vacacion']);
            $activeSheet->setCellValue('H' . $kFila,$datoPlanilla[$i]['prima']);
            $activeSheet->setCellValue('I' . $kFila,$datoPlanilla[$i]['rciva']);
            $activeSheet->setCellValue('J' . $kFila,'=sum(D'.$kFila.':H'.$kFila.')-I'.$kFila);
                      
            $kFila++;
        }
        $activeSheet->mergeCells( 'A'.$kFila.':C'.$kFila);
        $activeSheet->getStyle("A".$kFila.":J". $kFila)->applyFromArray(
                        $phpFontCuerpoNumerico
            );
        $activeSheet->getStyle("D".$kFila.":J". $kFila)->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle("A".$kFila.":J". $kFila)->getFont()->setBold(true);
         
       
        $activeSheet->setCellValue('A'.$kFila,'TOTALES');
        $activeSheet->setCellValue('D'.$kFila ,'=SUM(D10:D'.($kFila-1).')');
        $activeSheet->setCellValue('E'.$kFila ,'=SUM(E10:E'.($kFila-1).')'); 
        $activeSheet->setCellValue('F'.$kFila ,'=SUM(F10:F'.($kFila-1).')');       
        $activeSheet->setCellValue('G'.$kFila ,'=SUM(G10:G'.($kFila-1).')');
        $activeSheet->setCellValue('H'.$kFila ,'=SUM(H10:H'.($kFila-1).')'); 
        $activeSheet->setCellValue('I'.$kFila ,'=SUM(I10:I'.($kFila-1).')'); 
        $activeSheet->setCellValue('J'.$kFila ,'=SUM(J10:J'.($kFila-1).')'); 
        
         $kFila+=6;
        $activeSheet->mergeCells('B'.$kFila.':D'.$kFila);
        $activeSheet->mergeCells('F'.$kFila.':G'.$kFila);
        $activeSheet->mergeCells('I'.$kFila.':J'.$kFila);
        $activeSheet->mergeCells('I'.($kFila-1).':J'.($kFila-1));
        $activeSheet->getStyle('B' . $kFila)->applyFromArray(array(
            'font' => array(
                'bold' => true
            ),'borders' => array(
                    'top' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    ),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )));
        $activeSheet->getStyle('F' . $kFila)->applyFromArray(array(
            'font' => array(
                'bold' => true
            ),'borders' => array(
                    'top' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    ),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )));
        $activeSheet->getStyle('I' . $kFila)->applyFromArray(array(
            'font' => array(
                'bold' => true
            ),'borders' => array(
                    'top' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    ),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )));
        
        $activeSheet->getStyle('I' . ($kFila-1))->applyFromArray(array(
          
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )));
        $activeSheet->setCellValue('B'.$kFila , 'NOMBRE DEL EMPLEADOR O REPRESENTANTE LEGAL');
        $activeSheet->setCellValue('F'.$kFila , 'FIRMA');
        $activeSheet->setCellValue('I'.$kFila , 'LUGAR Y FECHA');
        $activeSheet->setCellValue('I'.($kFila-1) , $datoEmpresa['lugar']);
        $this->descargarExcel($objPHPExcel, $nombreArchivo);
    } 
    /**
     * @param integer $_GET['id'], id de la planilla retroactiva
     * retorna un reporte de planilla de Afp para la impresion
     */
    public function actionDescargarPlanillaafp( ) {
          $id = $_GET['id'];
        $model=$this->loadModel(SeguridadModule::dec($id));
       
        $pie = Yii::app()->rrhh->createCommand("select p.nombrecompleto, (select pt.nombre as puesto from general.puestotrabajo pt where pt.id=(select hc.idpuestotrabajo from general.historialestadoempleado  hee inner join contrato c on c.idhistorialestadoempleado=hee.id inner join historialcontrato hc on hc.idcontrato=c.id where hc.eliminado=false and hee.idempleado=e.id order by hc.fecharegistro desc limit 1)) from general.persona p inner join general.empleado e on e.idpersona=p.id  where p.nombrecompleto in (select nrepresentante  from general.representante where activo=true limit 1) ")->queryAll()[0];
       
         $cabeceraPlanilla= Yii::app()->rrhh
                ->createCommand("(select 'Nro'::text as nombre,'A8'::varchar(3) as celda)union
(select'C.I.'::text AS nombre ,'B8'::varchar(3) as celda)union
(select 'APELLIDOS Y NOMBRES'::text as nombre,'C8'::varchar(3) as celda)union
(select 'FECHA DE INGRESO'::text as nombre,'D8'::varchar(3) as celda)union
(select'HABER BASICO'::text as nombre,'E8'::varchar(3) as celda)union
(select 'BONO DE ANTIGUEDAD'::text as nombre,'F8'::varchar(3) as celda)union
(select'DOMINICAL'::text AS nombre ,'G8'::varchar(3) as celda)union
(select 'DISTRIBUCION DOMINICAL'::text as nombre,'H8'::varchar(3) as celda)union
(select 'HORAS EXTRAS'::text as nombre,'I8'::varchar(3)  as celda)union
(select 'OTROS BONOS'::text as nombre,'J8'::varchar(3)  as celda)union
(select 'TOTAL GANADO (Bs)'::text as nombre,'K8'::varchar(3))union
(select'AFP'::text AS nombre ,'P9'::varchar(3) as celda) ORDER BY celda asc ")
                ->queryAll();
        $tipocontratosseleccionados= Yii::app()->rrhh
                ->createCommand(" select STRING_AGG (distinct tc.id::text ,',')as id from general.tipocontrato tc inner join general.aporbetipocont abtc on abtc.idtipocontrato=tc.id where tc.eliminado=false and tc.generarcc=true and abtc.idaportacionbeneficio in (select id from general.aportacionbeneficio where eliminado=false and nombre like'%AFP APORTE TRABAJADOR%')")
                ->queryScalar();
        $datoPlanilla  = Yii::app()->rrhh
                ->createCommand("select * from lista_planilla_retroactivo (".$model->id.",'$tipocontratosseleccionados'::text) ")
                ->queryAll();
     
                $objPHPExcel = new PHPExcel();
                           $objPHPExcel->removeSheetByIndex(0);
        for ($pagina=0; $pagina <=$model->mesfin ; ++$pagina) { 
        
               
        $cantcolAportacion = 3;
        $nombreArchivo = 'AFP_Retroactivo_'.$model->anio ;
        $numcol= 16+$model->mesfin;
        $letras=$this->dameColumna('A', $numcol);
        $datoshoja=Yii::app()->rrhh
        ->createCommand("select * from dame_cabecera_mesretroactivo(".$model->id.", ".$pagina.") ")
        ->queryAll()[0];
        $objPHPExcel->createSheet($pagina); 

        $activeSheet = $objPHPExcel->setActiveSheetIndex($pagina);
        $activeSheet->setTitle($datoshoja['nombre']);
        $activeSheet->getDefaultColumnDimension()->setWidth(9.7);
        $objPHPExcel->getActiveSheet()
                        ->getPageSetup()
                        ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                $objPHPExcel->getActiveSheet()
                        ->getPageSetup()
                        ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);
            
        $activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 7);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $phpFontCuerpoGeneral = array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ), 'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
         $phpFontCuerpo= array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
        $phpFontCuerpoNumerico = array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ), 'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            
        );
        $phpFontCabecera = array('font' => array(
                'bold' => true,'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
         $phpFontPie= array('font' => array(
                'bold' => true,'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFontCuerpo);      
       
        $activeSheet->getColumnDimension('A')->setWidth(5);
        $activeSheet->getColumnDimension('B')->setWidth(13);
        $activeSheet->getColumnDimension('C')->setWidth(45);
        $activeSheet->getColumnDimension('D')->setWidth(16);
        $activeSheet->getColumnDimension('E')->setWidth(16);
        $activeSheet->getColumnDimension('F')->setWidth(16);
        $activeSheet->getColumnDimension('G')->setWidth(16);
        $activeSheet->getColumnDimension('H')->setWidth(16);
        $activeSheet->getColumnDimension('I')->setWidth(16);
        $activeSheet->getColumnDimension('J')->setWidth(16);
        $activeSheet->getColumnDimension('K')->setWidth(16);
        $activeSheet->getColumnDimension('L')->setWidth(16);
        $activeSheet->getColumnDimension('M')->setWidth(16);
        $activeSheet
                ->getPageMargins()->setTop(0.4);
        $activeSheet
                ->getPageMargins()->setRight(0.2);
        $activeSheet
                ->getPageMargins()->setLeft(0.2);
        $activeSheet
                ->getPageMargins()->setBottom(0.8);
        $phpColor = new PHPExcel_Style_Color();
        $phpColor->setRGB('FF0000');
        $kFila = 6;
        $img = realpath(__DIR__ . '/../../../../images');
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
        $objDrawingt->setWorksheet($objPHPExcel->setActiveSheetIndex($pagina));
       
        $activeSheet->getRowDimension(1)->setRowHeight(28);
        $activeSheet->getRowDimension(2)->setRowHeight(18);
        $activeSheet->getRowDimension(3)->setRowHeight(18);
        $activeSheet->getRowDimension(5)->setRowHeight(25);
        $activeSheet->getStyle("C1:C2")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("E4")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
       
        $activeSheet->getStyle('A5')->getFont()->setBold(true)->setSize(14);
        $activeSheet->getStyle('A6')->getFont()->setSize(8);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $activeSheet->getStyle("C1")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(12);
         $activeSheet->getStyle("C2")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(10);
        $activeSheet->getStyle("C1:C4")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(11);
        $activeSheet->getStyle("C1:C4")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("E4")->applyFromArray(array(
             'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ), 'font' => array(
                'bold' => true,
        ))));
        $activeSheet->getStyle("A5:A6")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->mergeCells('C1:F1');
        $activeSheet->mergeCells('C2:F2');
        $activeSheet->setCellValue('C1' , $datoshoja['titulo']);
        $activeSheet->setCellValue('C2' , $datoshoja['subtitulo']);
        if($pagina==0){
              $activeSheet->getStyle("G4")->applyFromArray(array(
             'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ), 'font' => array(
                'bold' => true,
        ))));
            $activeSheet->mergeCells('E4:G4');

            $cabeceraPlanilla= Yii::app()->rrhh
                ->createCommand("(select 'Nro'::text as nombre,'A5'::varchar(3) as celda)union
                (select'CARNET DE IDENTIDAD'::text AS nombre ,'B5'::varchar(3) as celda)union
                (select 'NOMBRE COMPLETO'::text as nombre,'C5'::varchar(3) as celda)union
                (select 'FECHA INGRESO'::text as nombre,'D5'::varchar(3) as celda)union
                (select'TOTAL GANADO'::text as nombre,'E5'::varchar(3) as celda)union
                (select 'A.F.P.'::text as nombre,'F5'::varchar(3) as celda)union
                (select'TOTAL PAGABLE RETROACTIVO'::text AS nombre ,'G5'::varchar(3) as celda)  ")
                ->queryAll();
                $letras=$this->dameColumna('A', 6);
                /// INICIO CUERPO
          $datoPlanilla  = Yii::app()->rrhh
          ->createCommand("select * from lista_planilla_retroactivo_afpglobal (".$model->id.",'$tipocontratosseleccionados'::text) ")
          ->queryAll();
          for ($i = 0; $i < count($datoPlanilla); $i++) {
            $activeSheet->getStyle("A".$kFila.":D". $kFila)->applyFromArray(
                        $phpFontCuerpoGeneral
            );
            $activeSheet->getRowDimension($kFila)->setRowHeight(22);
            $activeSheet->getStyle("A".$kFila.":D". $kFila)->getAlignment()->setWrapText(true);
            $activeSheet->getStyle("E".$kFila.":G". $kFila)->applyFromArray(
                        $phpFontCuerpoNumerico
            );
            $activeSheet->getStyle("E".$kFila.":G". $kFila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->setCellValue('A' . $kFila,($kFila-5));
            $activeSheet->setCellValue('B' . $kFila,$datoPlanilla[$i]['ci']);
            $activeSheet->setCellValue('C' . $kFila,$datoPlanilla[$i]['nombrecompleto']);
            
           
            $activeSheet->setCellValue('D' . $kFila,$datoPlanilla[$i]['fechaingreso']);
            $activeSheet->setCellValue('E' . $kFila,$datoPlanilla[$i]['totalganado']);
            $activeSheet->setCellValue('F' . $kFila,$datoPlanilla[$i]['afp']);
            $activeSheet->setCellValue('G' . $kFila,'=E'.$kFila.'-F'.$kFila);
            
                
            $kFila++;
        }
        /// FIN CUERPO  
     
        $activeSheet->mergeCells( 'A'.$kFila.':D'.$kFila);
        $activeSheet->getStyle("A".$kFila.":G". $kFila)->applyFromArray(
                        $phpFontCuerpoNumerico
            );
        $activeSheet->getStyle("E".$kFila.":G". $kFila)->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle("A".$kFila.":G". $kFila)->getFont()->setBold(true);
         
       
        $activeSheet->setCellValue('A'.$kFila,'TOTALES');
        $activeSheet->setCellValue('E'.$kFila ,'=SUM(E6:E'.($kFila-1).')');
        $activeSheet->setCellValue('F'.$kFila ,'=SUM(F6:F'.($kFila-1).')');
        $activeSheet->setCellValue('G'.$kFila ,'=SUM(G6:G'.($kFila-1).')');
       
    }else{
              $activeSheet->getStyle("M4")->applyFromArray(array(
             'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ), 'font' => array(
                'bold' => true,
        ))));
            $activeSheet->mergeCells('E4:M4');
            $cabeceraPlanilla= Yii::app()->rrhh
            ->createCommand("(select 'Nro'::text as nombre,'A5'::varchar(3) as celda)union
            (select'CARNET DE IDENTIDAD'::text AS nombre ,'B5'::varchar(3) as celda)union
            (select 'NOMBRE COMPLETO'::text as nombre,'C5'::varchar(3) as celda)union
            (select 'FECHA INGRESO'::text as nombre,'D5'::varchar(3) as celda)union
            (select'HABER BASICO'::text as nombre,'E5'::varchar(3) as celda)union
            (select'BONO DE ANTIGUEDAD'::text as nombre,'F5'::varchar(3) as celda)union
            (select'DOMINICAL'::text as nombre,'G5'::varchar(3) as celda)union
            (select'DISTRIBUCION DOMINICAL'::text as nombre,'H5'::varchar(3) as celda)union
            (select'HORAS EXTRAS'::text as nombre,'I5'::varchar(3) as celda)union
            (select'OTROS BONOS'::text as nombre,'J5'::varchar(3) as celda)union
            (select'TOTAL GANADO'::text as nombre,'K5'::varchar(3) as celda)union
            (select 'A.F.P.'::text as nombre,'L5'::varchar(3) as celda)union
            (select'TOTAL PAGABLE RETROACTIVO'::text AS nombre ,'M5'::varchar(3) as celda)  ")
            ->queryAll();
            $letras=$this->dameColumna('A', 12);  
        /// INICIO CUERPO
        /// INICIO CUERPO
        $datoPlanilla  = Yii::app()->rrhh
        ->createCommand("select * from lista_planilla_retroactivo_afp (".$model->id.",'$tipocontratosseleccionados'::text,$pagina) ")
        ->queryAll();
        for ($i = 0; $i < count($datoPlanilla); $i++) {
          $activeSheet->getStyle("A".$kFila.":D". $kFila)->applyFromArray(
                      $phpFontCuerpoGeneral
          );
          $activeSheet->getRowDimension($kFila)->setRowHeight(22);
          $activeSheet->getStyle("A".$kFila.":D". $kFila)->getAlignment()->setWrapText(true);
          $activeSheet->getStyle("E".$kFila.":M". $kFila)->applyFromArray(
                      $phpFontCuerpoNumerico
          );
          $activeSheet->getStyle("E".$kFila.":M". $kFila)->getNumberFormat()->setFormatCode('0.00');
          $activeSheet->setCellValue('A' . $kFila,($kFila-5));
          $activeSheet->setCellValue('B' . $kFila,$datoPlanilla[$i]['ci']);
          $activeSheet->setCellValue('C' . $kFila,$datoPlanilla[$i]['nombrecompleto']);
          
         
          $activeSheet->setCellValue('D' . $kFila,$datoPlanilla[$i]['fechaingreso']);
          $activeSheet->setCellValue('E' . $kFila,$datoPlanilla[$i]['haberbasico']);
          $activeSheet->setCellValue('F' . $kFila,$datoPlanilla[$i]['bantiguedad']);
          $activeSheet->setCellValue('G' . $kFila,$datoPlanilla[$i]['dominical']);
          $activeSheet->setCellValue('H' . $kFila,$datoPlanilla[$i]['ddominical']);
          $activeSheet->setCellValue('I' . $kFila,$datoPlanilla[$i]['horasextras']);
          $activeSheet->setCellValue('J' . $kFila,0);
          $activeSheet->setCellValue('L' . $kFila,$datoPlanilla[$i]['afp']);
          $activeSheet->setCellValue('K' . $kFila,'=SUM(E'.$kFila.':J'.$kFila.')');
          $activeSheet->setCellValue('M' . $kFila,'=K'.$kFila.'-L'.$kFila);
          
              
          $kFila++;
      }
      $activeSheet->mergeCells( 'A'.$kFila.':D'.$kFila);
      $activeSheet->getStyle("A".$kFila.":M". $kFila)->applyFromArray(
                      $phpFontCuerpoNumerico
          );
      $activeSheet->getStyle("E".$kFila.":M". $kFila)->getNumberFormat()->setFormatCode('0.00');
      $activeSheet->getStyle("A".$kFila.":M". $kFila)->getFont()->setBold(true);
       
     
      $activeSheet->setCellValue('A'.$kFila,'TOTALES');
      $activeSheet->setCellValue('E'.$kFila ,'=SUM(E6:E'.($kFila-1).')');
      $activeSheet->setCellValue('F'.$kFila ,'=SUM(F6:F'.($kFila-1).')');
      $activeSheet->setCellValue('G'.$kFila ,'=SUM(G6:G'.($kFila-1).')');
      $activeSheet->setCellValue('H'.$kFila ,'=SUM(H6:H'.($kFila-1).')');
      $activeSheet->setCellValue('I'.$kFila ,'=SUM(I6:I'.($kFila-1).')');
      $activeSheet->setCellValue('J'.$kFila ,'=SUM(J6:J'.($kFila-1).')'); 
      $activeSheet->setCellValue('K'.$kFila ,'=SUM(K6:K'.($kFila-1).')');
      $activeSheet->setCellValue('L'.$kFila ,'=SUM(L6:L'.($kFila-1).')'); 
      $activeSheet->setCellValue('M'.$kFila ,'=SUM(M6:M'.($kFila-1).')');       
     
  
        
        }



        $activeSheet->setCellValue('E4' , 'RETROACTIVO');
        for ($i=0;$i<count($letras);$i++){
           
            $activeSheet->getStyle($letras[$i]."5")->getAlignment()->setWrapText(true);
            $activeSheet->getStyle($letras[$i]."5")->applyFromArray($phpFontCabecera);
            }
              
            foreach ($cabeceraPlanilla as $cp) {  
                $activeSheet->setCellValue($cp['celda'], $cp['nombre']); 
    }

    $kFila+=5;
    $activeSheet->mergeCells( 'B'.$kFila.':D'.$kFila);
    $activeSheet->mergeCells( 'F'.$kFila.':G'.$kFila);
    $activeSheet->setCellValue('B'.$kFila , 'LIC. '.$pie['nombrecompleto']);
  
    if($model->fechapago==''){
        
    }else{
      $activeSheet->setCellValue('F'.$kFila ,'Sucre , '.   date ("d-m-Y",strtotime( $model->fechapago)));
   
    }
    $activeSheet->getStyle('B'.$kFila)->applyFromArray($phpFontPie);
     $activeSheet->getStyle('F'.$kFila)->applyFromArray(array(
          'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        
         )));
          
        
    $kFila++;
    $activeSheet->mergeCells( 'B'.$kFila.':D'.$kFila);
    $activeSheet->mergeCells( 'F'.$kFila.':G'.$kFila);
    $activeSheet->setCellValue('B'.$kFila , $pie['puesto']);  
    $activeSheet->setCellValue('F'.$kFila , 'FECHA DE PAGO'); 
    $activeSheet->getStyle('B'.$kFila.':'.'F'.$kFila)->applyFromArray(array(
          'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        
         )));
    


    } 
        $this->descargarExcel($objPHPExcel, 'RETROACTIVO AFP '.$model->anio);
    }
    /**
     * @param  integer $_GET['Planillaretroactivo']['id'], id planilla retroactiva
     * @param integer[] $_GET['tipocontratos'], id de los contratos 
     * @param integer $_GET['empresas'],id de las empresas sub empleadoras
     * retorna planilla de prefactura Retroactivo
     */
       public function actionDescargarExcelPlanillaPrefactura( ) {
          $id = $_GET['Planillaretroactivo']['id'];
          $listacontrato = $_GET['tipocontratos'];
          $listaempresa =$_GET['empresas'];
             $tipocontratosseleccionados ='';
             $empresasseleccionadas='';
        for ($i = 0; $i < count($listacontrato); $i++) {
                        $tipocontratosseleccionados = $tipocontratosseleccionados . $listacontrato[$i] . ',';
                    }
            $tipocontratosseleccionados = substr($tipocontratosseleccionados, 0, -1);
        for ($i = 0; $i < count( $listaempresa); $i++) {
                         $empresasseleccionadas =  $empresasseleccionadas .$listaempresa[$i] . ',';
                    }
            $empresasseleccionadas = substr($empresasseleccionadas, 0, -1);

          
        $model=$this->loadModel($id);
       
        
        $datoEmpresa = Yii::app()->rrhh->createCommand("select e.*,pl.nombrer,pl.cir, 'Sucre,'||to_char(now(),'dd-mm-YYYY') as lugar from planilla pl inner join general.representante r on r.cirepresentante=pl.cir inner join general.empresa e on e.id=r.idempresa  where pl.id in(select  id from planilla where eliminado=false and mes=".$model->mesinicio." and anio=".$model->anio.")" )->queryAll()[0];
        $cabeceraPlanilla= Yii::app()->rrhh
                ->createCommand("
(select 'Nro'::text as nombre,'A8'::varchar(3) as celda)union
(select'CARNET DE IDENTIDAD'::text AS nombre ,'B8'::varchar(3) as celda)union
(select 'APELLIDOS Y NOMBRES'::text as nombre,'C8'::varchar(3) as celda)union
(select 'SEXO(F/M)'::text as nombre,'D8'::varchar(3) as celda)union
(select'OCUPACIÓN QUE DESEMPEÑA'::text as nombre,'E8'::varchar(3) as celda)union
(select 'FECHA DE INGRESO'::text as nombre,'F8'::varchar(3) as celda)union
(select'FECHA DE RETIRO'::text AS nombre ,'G8'::varchar(3) as celda)union
(select 'HABER BASICO EN LA PLANILLA DE DICIEMBRE '||(".$model->anio."-1)||' (Bs)'::text as nombre,'H8'::varchar(3) as celda)union
(select 'HABER BASICO CON INCREMENTO EN LA GESTION ".$model->anio." (Bs)'::text as nombre,'I8'::varchar(3)  as celda)union
(select * from dame_nombremeses_retroactivo(".$model->id."))union
(select 'TOTAL RETROACTIVO (Bs)'::text as nombre,'O8'::varchar(3))union
(select'AFP'::text AS nombre ,'P9'::varchar(3) as celda)union
(select 'RC-IVA'::text as nombre,'Q9'::varchar(3) as celda)union
(select 'OTROS DESCUENTOS'::text as nombre,'R9'::varchar(3) as celda)union
(select 'TOTAL DESCUENTOS (Bs)'::text as nombre,'S8'::varchar(3) as celda)union
(select'LIQUIDO PAGABLE (Bs)'::text AS nombre ,'T8'::varchar(3) as celda)union
(select 'CAJA SEGURO SOCIAL'::text as nombre,'U8'::varchar(3)as celda ) union
(select 'AFPS'::text as nombre,'V8'::varchar(3)as celda ) 
union
(select 'SUBTOTAL APORTES PATRONALES'::text as nombre,'W8'::varchar(3)as celda )
union
(select 'GRAN TOTAL'::text as nombre,'X8'::varchar(3)as celda )
union
(select 'FEE'::text as nombre,'Y8'::varchar(3)as celda )union
(select 'TOTAL + FEE '::text as nombre,'Z8'::varchar(3)as celda )union
(select 'IMPUESTO '::text as nombre,'AA8'::varchar(3)as celda )union
(select 'TOTAL FACTURACION '::text as nombre,'AB8'::varchar(3)as celda )
")
                ->queryAll();
        $datoPlanilla  = Yii::app()->rrhh
                ->createCommand("select * from lista_planilla_prefacturaretroactivo (".$model->id.",'$tipocontratosseleccionados'::text,'$empresasseleccionadas'::text) ")
                ->queryAll();
     
        $cantcolAportacion = 3;
        $nombreArchivo = 'Retroactivo_'.$model->anio ;
        $numcol= 23+$model->mesfin;
        $letras=$this->dameColumna('A', $numcol);
       
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
        $phpFontCuerpoGeneral = array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ), 'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
         $phpFontCuerpo= array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
        $phpFontCuerpoNumerico = array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ), 'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            
        );
        $phpFontCabecera = array('font' => array(
                'bold' => true,'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
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

        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFontCuerpo);      
        for ($i=0;$i<count($letras);$i++){ $activeSheet->getColumnDimension($letras[$i])->setWidth(20);
         $activeSheet->getStyle($letras[$i]."8:".$letras[$i]."9")->getAlignment()->setWrapText(true);
         $activeSheet->getStyle($letras[$i]."8:".$letras[$i]."9")->applyFromArray($phpFontCabecera);
         }
         $activeSheet->getColumnDimension($letras[$i-1])->setWidth(45);
        $activeSheet->getColumnDimension('A')->setWidth(10);
        $activeSheet->getColumnDimension('C')->setWidth(45);
        $activeSheet->getColumnDimension('D')->setWidth(5);
        $activeSheet->getColumnDimension('G')->setWidth(30);
        $activeSheet
                ->getPageMargins()->setTop(0.4);
        $activeSheet
                ->getPageMargins()->setRight(0.2);
        $activeSheet
                ->getPageMargins()->setLeft(0.2);
        $activeSheet
                ->getPageMargins()->setBottom(0.8);
        $phpColor = new PHPExcel_Style_Color();
        $phpColor->setRGB('FF0000');
        $kFila = 10;
        $img = realpath(__DIR__ . '/../../../../images');
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
        $activeSheet->getRowDimension(8)->setRowHeight(20);
        $activeSheet->getRowDimension(9)->setRowHeight(20);
        $activeSheet->getRowDimension(1)->setRowHeight(18);
        $activeSheet->getRowDimension(2)->setRowHeight(18);
        $activeSheet->getRowDimension(3)->setRowHeight(18);
        $activeSheet->getRowDimension(4)->setRowHeight(18);
        $activeSheet->getRowDimension(5)->setRowHeight(18);
        $activeSheet->getRowDimension(6)->setRowHeight(18);

        //CABECERA DE LA PLANILLA

        $activeSheet->mergeCells('C1:F1');
        $activeSheet->mergeCells('C2:F2');
        $activeSheet->mergeCells('C3:F3');
        $activeSheet->mergeCells('C4:F4');
        $activeSheet->mergeCells('G1:'.$letras[$numcol-1].'1');
        $activeSheet->mergeCells('G3:'.$letras[$numcol-1].'3');
        $activeSheet->mergeCells('G4:'.$letras[$numcol-1].'4');
        $activeSheet->mergeCells('A5:'.$letras[$numcol-1].'5');
        $activeSheet->mergeCells('A6:'.$letras[$numcol-1].'6');
        $activeSheet->setCellValue('C1', 'NOMBRE O RAZÓN SOCIAL');
        $activeSheet->setCellValue('C2','TIPO DE IDENTIFICADOR');
        $activeSheet->setCellValue('C3', 'Nº DE IDENTIFICADOR');
        $activeSheet->setCellValue('C4', 'Nº DE EMPLEADOR (Caja de Salud)');
        $activeSheet->setCellValue('G1',$datoEmpresa['razonsocial']);
        $activeSheet->setCellValue('G2','X');
        $activeSheet->setCellValue('H2','NIT');
        $activeSheet->setCellValue('J2','SUB'); 
        $activeSheet->setCellValue('L2','OTRO'); 
        $activeSheet->setCellValue('G3',$datoEmpresa['nit'].' ');
        $activeSheet->setCellValue('G4',$datoEmpresa['nrempleador']);
        $activeSheet->setCellValue('A5','PLANILLA DE RETROACTIVO - INCREMENTO SALARIAL '.$model->anio);
        $activeSheet->setCellValue('A6','(En Bolivianos) ');
        $activeSheet->getStyle('A5')->getFont()->setBold(true)->setSize(14);
        $activeSheet->getStyle('A6')->getFont()->setSize(8);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $activeSheet->getStyle("A1")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(12);
        $activeSheet->getStyle("C1:C4")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(11);
        $activeSheet->getStyle("C1:C4")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("A5:A6")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("G2")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("I2")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ), 'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("K2")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ), 'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ), 'font' => array(
                'bold' => true,
        )));
        for ($i=1;$i<=9;$i++)
        { 
            $letras=$this->dameColumna('A', $i);
            $activeSheet->mergeCells($letras[$i-1].'8:'.$letras[$i-1].'9'); 
        }
        $letras=$this->dameColumna('J',( $model->mesfin+1));
        $columnas=$letras;
        $activeSheet->mergeCells('J8:'.($letras[( $model->mesfin)]).'8'); 
        $activeSheet->setCellValue('J8','MONTOS (Bs)');
        $letras=$this->dameColumna('J',( $model->mesfin+2));
        $letra=$letras[( $model->mesfin+1)];
        $activeSheet->mergeCells($letras[( $model->mesfin+1)].'8:'.$letras[( $model->mesfin+1)].'9'); 
        $letras=$this->dameColumna($letra,14);
        $activeSheet->mergeCells( $letras[1].'8:'.$letras[3].'8'); 
        $activeSheet->setCellValue($letras[1].'8','DESCUENTOS (Bs)');        
        $activeSheet->mergeCells( $letras[4].'8:'.$letras[4].'9'); 
        $activeSheet->mergeCells( $letras[5].'8:'.$letras[5].'9'); 
        $activeSheet->mergeCells( $letras[6].'8:'.$letras[6].'9');
        $activeSheet->mergeCells( $letras[7].'8:'.$letras[7].'9'); 
        $activeSheet->mergeCells( $letras[8].'8:'.$letras[8].'9');
        $activeSheet->mergeCells( $letras[9].'8:'.$letras[9].'9'); 
        $activeSheet->mergeCells( $letras[10].'8:'.$letras[10].'9'); 
        $activeSheet->mergeCells( $letras[11].'8:'.$letras[11].'9');
        $activeSheet->mergeCells( $letras[12].'8:'.$letras[12].'9'); 
        $activeSheet->mergeCells( $letras[13].'8:'.$letras[13].'9');
        $columnasfinal=$letras;
        $indice;
        foreach ($cabeceraPlanilla as $cp) {  
                    $activeSheet->setCellValue($cp['celda'], $cp['nombre']); 
        }
           ///CUERPO
        for ($i = 0; $i < count($datoPlanilla); $i++) {
            $activeSheet->getStyle("A".$kFila.":".$letras[13]. $kFila)->applyFromArray(
                        $phpFontCuerpoGeneral
            );
             $activeSheet->getRowDimension($kFila)->setRowHeight(22);
            $activeSheet->getStyle("A".$kFila.":".$letras[13]. $kFila)->getAlignment()->setWrapText(true);
            $activeSheet->getStyle("H".$kFila.":".$letras[13]. $kFila)->applyFromArray(
                        $phpFontCuerpoNumerico
            );
            $activeSheet->getStyle("H".$kFila.":".$columnasfinal[13]. $kFila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->setCellValue('A' . $kFila,($kFila-9));
            $activeSheet->setCellValue('B' . $kFila,$datoPlanilla[$i]['ci']);
            $activeSheet->setCellValue('C' . $kFila,$datoPlanilla[$i]['nombrecompleto']);
            $activeSheet->setCellValue('D' . $kFila,$datoPlanilla[$i]['sexo']);
            $activeSheet->setCellValue('E' . $kFila,$datoPlanilla[$i]['cargo']);
            $activeSheet->setCellValue('F' . $kFila,$datoPlanilla[$i]['fechaingreso']);
            $activeSheet->setCellValue('G' . $kFila,$datoPlanilla[$i]['fecharetiro']);
            $activeSheet->setCellValue('H' . $kFila,$datoPlanilla[$i]['haberbasicoantiguo']);
            $activeSheet->setCellValue('I' . $kFila,$datoPlanilla[$i]['haberbasiconuevo']);
            $indice=1;
            $sumaotrosbonos=0;
            
            
            $detallemontos = json_decode($datoPlanilla[$i]['detallemontos'], true);
            while ($indice <= ($model->mesfin)) {
                $activeSheet->setCellValue($columnas[$indice-1] . $kFila,$detallemontos[$indice-1]['hbasico']);
                $sumaotrosbonos+=$detallemontos[$indice-1]['totalabono'];
                $indice++;
            
            }
            $activeSheet->setCellValue($columnas[$model->mesfin].$kFila ,$sumaotrosbonos);
            $activeSheet->setCellValue($columnas[$model->mesfin+1].$kFila ,'=SUM('.$columnas[0].$kFila.':'.$columnas[$model->mesfin].$kFila.')');
            $activeSheet->setCellValue($columnas[$model->mesfin].$kFila ,$sumaotrosbonos);
            // columnas finales
            $activeSheet->setCellValue($columnasfinal[1].$kFila ,$datoPlanilla[$i]['afp']);
            $activeSheet->setCellValue($columnasfinal[2].$kFila ,$datoPlanilla[$i]['rciva']);
            $activeSheet->setCellValue($columnasfinal[3].$kFila ,$datoPlanilla[$i]['otrosdescuentos']);
            $activeSheet->setCellValue($columnasfinal[4].$kFila ,'=SUM('.$columnasfinal[1].$kFila.':'.$columnasfinal[3].$kFila.')');
            $activeSheet->setCellValue($columnasfinal[5].$kFila ,'='.$columnas[$model->mesfin+1].$kFila.'-'.$columnasfinal[4].$kFila);
            $activeSheet->setCellValue($columnasfinal[6].$kFila ,$datoPlanilla[$i]['cns']);
            $montoafp=$datoPlanilla[$i]['provivienda']+$datoPlanilla[$i]['riesgoprofesional']+$datoPlanilla[$i]['solidario'];
            $activeSheet->setCellValue($columnasfinal[7].$kFila ,$montoafp);
            $activeSheet->setCellValue($columnasfinal[8].$kFila ,'=SUM('.$columnasfinal[6].$kFila.':'.$columnasfinal[7].$kFila.')');
          
            $activeSheet->setCellValue($columnasfinal[9].$kFila ,'='.$columnasfinal[5].$kFila.'+'.$columnasfinal[8].$kFila);
            $activeSheet->setCellValue($columnasfinal[10].$kFila ,'='.$columnasfinal[9].$kFila.'*'.$datoPlanilla[$i]['fee']);
            $activeSheet->setCellValue($columnasfinal[11].$kFila ,'='.$columnasfinal[10].$kFila.'+'.$columnasfinal[9].$kFila);
            $activeSheet->setCellValue($columnasfinal[12].$kFila ,'='.$columnasfinal[11].$kFila.'*'.$datoPlanilla[$i]['impuesto']);
            $activeSheet->setCellValue($columnasfinal[13].$kFila ,'='.$columnasfinal[12].$kFila.'+'.$columnasfinal[11].$kFila);
            
            $kFila++;
        }
        $activeSheet->mergeCells( 'A'.$kFila.':G'.$kFila);
        $activeSheet->getStyle("A".$kFila.":".$letras[13]. $kFila)->applyFromArray(
                        $phpFontCuerpoNumerico
            );
        $activeSheet->getStyle("H".$kFila.":".$letras[13]. $kFila)->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle("A".$kFila.":".$letras[13]. $kFila)->getFont()->setBold(true);
         
       
        $activeSheet->setCellValue('A'.$kFila,'TOTALES');
        $activeSheet->setCellValue('H'.$kFila ,'=SUM(H10:H'.($kFila-1).')');
        $activeSheet->setCellValue('I'.$kFila ,'=SUM(I10:I'.($kFila-1).')');       
        $indice=1; 
        while ($indice <= ($model->mesfin+2)) {
                $activeSheet->setCellValue($columnas[$indice-1] . $kFila,'=SUM('.$columnas[$indice-1].'10:'.$columnas[$indice-1].($kFila-1).')');
                $indice++;
            
            }
        $activeSheet->setCellValue($columnasfinal[1].$kFila ,'=SUM('.$columnasfinal[1].'10:'.$columnasfinal[1].($kFila-1).')');
        $activeSheet->setCellValue($columnasfinal[2].$kFila ,'=SUM('.$columnasfinal[2].'10:'.$columnasfinal[2].($kFila-1).')');
        $activeSheet->setCellValue($columnasfinal[3].$kFila ,'=SUM('.$columnasfinal[3].'10:'.$columnasfinal[3].($kFila-1).')');
        $activeSheet->setCellValue($columnasfinal[4].$kFila ,'=SUM('.$columnasfinal[4].'10:'.$columnasfinal[4].($kFila-1).')');
        $activeSheet->setCellValue($columnasfinal[5].$kFila ,'=SUM('.$columnasfinal[5].'10:'.$columnasfinal[5].($kFila-1).')');
        
        $activeSheet->setCellValue($columnasfinal[6].$kFila ,'=SUM('.$columnasfinal[6].'10:'.$columnasfinal[6].($kFila-1).')');
        $activeSheet->setCellValue($columnasfinal[7].$kFila ,'=SUM('.$columnasfinal[7].'10:'.$columnasfinal[7].($kFila-1).')');
        $activeSheet->setCellValue($columnasfinal[8].$kFila ,'=SUM('.$columnasfinal[8].'10:'.$columnasfinal[8].($kFila-1).')');
        $activeSheet->setCellValue($columnasfinal[9].$kFila ,'=SUM('.$columnasfinal[9].'10:'.$columnasfinal[9].($kFila-1).')');
        $activeSheet->setCellValue($columnasfinal[10].$kFila ,'=SUM('.$columnasfinal[10].'10:'.$columnasfinal[10].($kFila-1).')');
        $activeSheet->setCellValue($columnasfinal[11].$kFila ,'=SUM('.$columnasfinal[11].'10:'.$columnasfinal[11].($kFila-1).')');
        $activeSheet->setCellValue($columnasfinal[12].$kFila ,'=SUM('.$columnasfinal[12].'10:'.$columnasfinal[12].($kFila-1).')');
        $activeSheet->setCellValue($columnasfinal[13].$kFila ,'=SUM('.$columnasfinal[13].'10:'.$columnasfinal[13].($kFila-1).')');
        
        $total= $activeSheet->getCellByColumnAndRow($numcol, $kFila)->getCalculatedValue(); 
        
        $kFila+=6;
        $activeSheet->mergeCells('E'.$kFila.':I'.$kFila);
        $activeSheet->mergeCells('L'.$kFila.':N'.$kFila);
        $activeSheet->mergeCells('Q'.$kFila.':S'.$kFila);
        $activeSheet->mergeCells('Q'.($kFila-1).':S'.($kFila-1));
        $activeSheet->getStyle('E' . $kFila)->applyFromArray(array(
            'font' => array(
                'bold' => true
            ),'borders' => array(
                    'top' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    ),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )));
        $activeSheet->getStyle('L' . $kFila)->applyFromArray(array(
            'font' => array(
                'bold' => true
            ),'borders' => array(
                    'top' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    ),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )));
        $activeSheet->getStyle('Q' . $kFila)->applyFromArray(array(
            'font' => array(
                'bold' => true
            ),'borders' => array(
                    'top' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    ),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )));
        
        $activeSheet->getStyle('Q' . ($kFila-1))->applyFromArray(array(
          
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )));
        $activeSheet->setCellValue('E'.$kFila , 'NOMBRE DEL EMPLEADOR O REPRESENTANTE LEGAL');
        $activeSheet->setCellValue('L'.$kFila , 'FIRMA');
        $activeSheet->setCellValue('Q'.$kFila , 'LUGAR Y FECHA');
        $activeSheet->setCellValue('Q'.($kFila-1) , $datoEmpresa['lugar']);
        
        
        
        $objPHPExcel->createSheet(1);        
        $activeSheet = $objPHPExcel->setActiveSheetIndex(1);
         
        $activeSheet ->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $activeSheet 
                ->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);
        $activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1,6);   
        $activeSheet->setTitle('RESUMEN');
        $activeSheet->getDefaultColumnDimension()->setWidth(9.7);
        $activeSheet->getStyle("B5:B8")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            ), 'font' => array(
                'bold' => true,
        )));
        $objDrawingt = new PHPExcel_Worksheet_Drawing();
        $objDrawingt->setName('imgNotice');
        $objDrawingt->setDescription('Noticia');
        $objDrawingt->setPath($imgot);
        $objDrawingt->setOffsetX(5);    // setOffsetX works properly
        $objDrawingt->setOffsetY(0);  //setOffsetY has no effect
        $objDrawingt->setCoordinates('A1');
        $objDrawingt->setWidthAndHeight(140, 70);
        $objDrawingt->setResizeProportional(true);
        $objDrawingt->setWorksheet($objPHPExcel->setActiveSheetIndex(1));
        $activeSheet->getColumnDimension('A')->setWidth(30);
        $activeSheet->getColumnDimension('B')->setWidth(120);
        $activeSheet->getColumnDimension('C')->setWidth(40);
        
        $activeSheet->getStyle('B5:B8')->applyFromArray($phpFontC);
        $activeSheet->getStyle('B5')->getFont()->setSize(14);
        $activeSheet->getStyle('B6:B10')->getFont()->setBold(true)->setSize(10);
        $activeSheet->getStyle('C5:C8')->getFont()->setBold(true)->setSize(10);
        $activeSheet->getStyle('C5:C8')->applyFromArray($phpFontC);
        $activeSheet->getStyle('C5:C8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
       
        $total=round( $total,2);
        $activeSheet->mergeCells('B5:C5');
        $activeSheet->setCellValue('B5' ,"RESUMEN PLANILLA PREFACTURA RETROACTIVO SOLUR S.R.L. " ); 
        $activeSheet->setCellValue('B6' ,"PRE FACTURA  PLANILLA GLOBAL  RETROACTIVO  ".$model->anio ); 
        $activeSheet->setCellValue('B8' ,"TOTAL A FACTURAR" );        
        $activeSheet->setCellValue('C6' ,$total ); 
        $activeSheet->setCellValue('C8' ,$total ); 
        $literal = $this->numeroLiteral($total);
        
        $total = explode('.', $total);
         $activeSheet->mergeCells('B10:C10');
         if(count($total)>1){
          $activeSheet->setCellValue('B10' ,'SON : '.$literal.' '.$total[1].'/100 BOLIVIANOS' );    
         }
         else{
             $activeSheet->setCellValue('B10' ,'SON : '.$literal.'00/100 BOLIVIANOS' ); 
         }
        
        
        
        
        $this->descargarExcel($objPHPExcel, $nombreArchivo);
    }
    /**
     * 
     * @param integer $id, id de la planilla 
     * retorna interfa para descargar la planilla de prefactura
     */
     public function actionDescargarPlanillaprefactura($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=$this->loadModel(SeguridadModule::dec($id));
        $model->estado=true;
        $ltipocontratos = Tipocontrato::model()->findAll();  
        $listaempresas= Empresasubempleadora::model()->findAll();

        $this->renderPartial('decargarplanillaprefactura',array(
            'model'=>$model,
            'ltipocontratos'=>$ltipocontratos,
            'listaempresas'=>$listaempresas
        ), false, true);
    }
    /**
     * 
     * @param integer $num, numero sin decimales
     * @param boolean $fem,true = hara que autocompletel el literal con la palabra "una",false=hara que autocompletel el literal con la palabra "un"
     * @param boolean $dec, true= si el numero tiene decimales,false= si el numero No tiene decimales
     * @return string con el literal correspondiente a $num  
     */    
    public function numeroLiteral($num, $fem = false, $dec = false) {
        
        $matuni[2] = "dos";
        $matuni[3] = "tres";
        $matuni[4] = "cuatro";
        $matuni[5] = "cinco";
        $matuni[6] = "seis";
        $matuni[7] = "siete";
        $matuni[8] = "ocho";
        $matuni[9] = "nueve";
        $matuni[10] = "diez";
        $matuni[11] = "once";
        $matuni[12] = "doce";
        $matuni[13] = "trece";
        $matuni[14] = "catorce";
        $matuni[15] = "quince";
        $matuni[16] = "dieciseis";
        $matuni[17] = "diecisiete";
        $matuni[18] = "dieciocho";
        $matuni[19] = "diecinueve";
        $matuni[20] = "veinte";
        $matunisub[2] = "dos";
        $matunisub[3] = "tres";
        $matunisub[4] = "cuatro";
        $matunisub[5] = "quin";
        $matunisub[6] = "seis";
        $matunisub[7] = "sete";
        $matunisub[8] = "ocho";
        $matunisub[9] = "nove";

        $matdec[2] = "veint";
        $matdec[3] = "treinta";
        $matdec[4] = "cuarenta";
        $matdec[5] = "cincuenta";
        $matdec[6] = "sesenta";
        $matdec[7] = "setenta";
        $matdec[8] = "ochenta";
        $matdec[9] = "noventa";
        $matsub[3] = 'mill';
        $matsub[5] = 'bill';
        $matsub[7] = 'mill';
        $matsub[9] = 'trill';
        $matsub[11] = 'mill';
        $matsub[13] = 'bill';
        $matsub[15] = 'mill';
        $matmil[4] = 'millones';
        $matmil[6] = 'billones';
        $matmil[7] = 'de billones';
        $matmil[8] = 'millones de billones';
        $matmil[10] = 'trillones';
        $matmil[11] = 'de trillones';
        $matmil[12] = 'millones de trillones';
        $matmil[13] = 'de trillones';
        $matmil[14] = 'billones de trillones';
        $matmil[15] = 'de billones de trillones';
        $matmil[16] = 'millones de billones de trillones';

        $num = trim((string) @$num);
        if ($num[0] == '-') {
            $neg = 'menos ';
            $num = substr($num, 1);
        } else
            $neg = '';
        while ($num[0] == '0')
            $num = substr($num, 1);
        if ($num[0] < '1' or $num[0] > 9)
            $num = '0' . $num;
        $zeros = true;
        $punt = false;
        $ent = '';
        $fra = '';
        for ($c = 0; $c < strlen($num); $c++) {
            $n = $num[$c];
            if (!(strpos(".,'''", $n) === false)) {
                if ($punt)
                    break;
                else {
                    $punt = true;
                    continue;
                }
            } elseif (!(strpos('0123456789', $n) === false)) {
                if ($punt) {
                    if ($n != '0')
                        $zeros = false;
                    $fra .= $n;
                } else
                    $ent .= $n;
            } else
                break;
        }
        $ent = '     ' . $ent;
        if ($dec and $fra and ! $zeros) {
            $fin = ' coma';
            for ($n = 0; $n < strlen($fra); $n++) {
                if (($s = $fra[$n]) == '0')
                    $fin .= ' cero';
                elseif ($s == '1')
                    $fin .= $fem ? ' una' : ' un';
                else
                    $fin .= ' ' . $matuni[$s];
            }
        } else
            $fin = '';
        if ((int) $ent === 0)
            return 'Cero ' . $fin;
        $tex = '';
        $sub = 0;
        $mils = 0;
        $neutro = false;
        while (($num = substr($ent, -3)) != '   ') {
            $ent = substr($ent, 0, -3);
            if (++$sub < 3 and $fem) {
                $matuni[1] = 'una';
                $subcent = 'as';
            } else {
                $matuni[1] = $neutro ? 'un' : 'uno';
                $subcent = 'os';
            }
            $t = '';
            $n2 = substr($num, 1);
            if ($n2 == '00') {
                
            } elseif ($n2 < 21)
                $t = ' ' . $matuni[(int) $n2];
            elseif ($n2 < 30) {
                $n3 = $num[2];
                if ($n3 != 0)
                    $t = 'i' . $matuni[$n3];
                $n2 = $num[1];
                $t = ' ' . $matdec[$n2] . $t;
            }else {
                $n3 = $num[2];
                if ($n3 != 0)
                    $t = ' y ' . $matuni[$n3];
                $n2 = $num[1];
                $t = ' ' . $matdec[$n2] . $t;
            }
            $n = $num[0];
            if ($n == 1) {
                $t = ' ciento' . $t;
            } elseif ($n == 5) {
                $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
            } elseif ($n != 0) {
                $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
            }
            if ($sub == 1) {
                
            } elseif (!isset($matsub[$sub])) {
                if ($num == 1) {
                    $t = ' mil';
                } elseif ($num > 1) {
                    $t .= ' mil';
                }
            } elseif ($num == 1) {
                $t .= ' ' . $matsub[$sub] . '?n';
            } elseif ($num > 1) {
                $t .= ' ' . $matsub[$sub] . 'ones';
            }
            if ($num == '000')
                $mils ++;
            elseif ($mils != 0) {
                if (isset($matmil[$sub]))
                    $t .= ' ' . $matmil[$sub];
                $mils = 0;
            }
            $neutro = true;
            $tex = $t . $tex;
        }
        $tex = $neg . substr($tex, 1) . $fin;
        return strtoupper($tex);
    }
    /**
     * 
     * @param integer $id, id de la planilla a consolidar
     * @return interfaz para la consolidacion de la planilla de Prefactura Retroactivo
     */
    public function actionConsolidarPrefacturaretroactivo($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=$this->loadModel(SeguridadModule::dec($id));
        $model->scenario='Desea Consolidar la Planilla de Retroactivo ?';
        if(isset($_POST['Planillaretroactivo']))
        {
            $model->attributes=$_POST['Planillaretroactivo'];
            $model->conprefactura=true;
                         
            if($model->save()){
                Planillaretroactivo::model()->ConsolidarPrefactura($model->id);
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }

        $this->renderPartial('consolidarprefactura',array(
            'model'=>$model,
            
        ), false, true);
    }
     /**
      * @param integer $_GET['id'], id de la planill
      * retorna planilla para las Afps que se presenta al ministerio
      */
      public function actionDescargarPlanillaafpministerio( ) {
          $id = $_GET['id'];
        $model=$this->loadModel(SeguridadModule::dec($id));
       
        $pie = Yii::app()->rrhh->createCommand(" select p.nombrecompleto,(select pt.nombre as puesto from general.puestotrabajo pt where pt.id=(select hc.idpuestotrabajo from general.historialestadoempleado  hee inner join contrato c on c.idhistorialestadoempleado=hee.id inner join historialcontrato hc on hc.idcontrato=c.id where hc.eliminado=false and hee.idempleado=e.id order by hc.fecharegistro desc limit 1)) from general.persona p inner join general.empleado e on e.idpersona=p.id  where p.nombrecompleto in (select nrepresentante  from general.representante where activo=true limit 1)")->queryAll()[0];
       
        
        $tipocontratosseleccionados= Yii::app()->rrhh
                ->createCommand(" select STRING_AGG (distinct tc.id::text ,',')as id from general.tipocontrato tc inner join general.aporbetipocont abtc on abtc.idtipocontrato=tc.id where tc.eliminado=false and tc.generarcc=true and abtc.idaportacionbeneficio in (select id from general.aportacionbeneficio where eliminado=false and nombre like'%AFP APORTE TRABAJADOR%')")
                ->queryScalar();
        $datoPlanilla  = Yii::app()->rrhh
                ->createCommand("select * from lista_planilla_retroactivo (".$model->id.",'$tipocontratosseleccionados'::text) ")
                ->queryAll();
     
                $objPHPExcel = new PHPExcel();
                           $objPHPExcel->removeSheetByIndex(0);
        for ($pagina=0; $pagina <$model->mesfin ; ++$pagina) { 
        
               
        $cantcolAportacion = 3;
        $nombreArchivo = 'AFP_Retroactivo_'.$model->anio ;
        $numcol= 16+$model->mesfin;
        $letras=$this->dameColumna('A', $numcol);
        $datoshoja=Yii::app()->rrhh
        ->createCommand("select * from dame_cabecera_mesretroactivo(".$model->id.", ".($pagina+1).") ")
        ->queryAll()[0];
        $objPHPExcel->createSheet($pagina); 

        $activeSheet = $objPHPExcel->setActiveSheetIndex($pagina);
        $activeSheet->setTitle($datoshoja['nombre']);
        $activeSheet->getDefaultColumnDimension()->setWidth(9.7);
        $objPHPExcel->getActiveSheet()
                        ->getPageSetup()
                        ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                $objPHPExcel->getActiveSheet()
                        ->getPageSetup()
                        ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);
            
        $activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 7);
        $htmlHelper = new \PHPExcel_Helper_HTML();
       
      
       
         $phpFontCuerpo= array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
        
        $phpFontCabecera = array('font' => array(
                'bold' => true,'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFontCuerpo); 
           
       $activeSheet->getStyle('A1:O1')->applyFromArray($phpFontCabecera);
        $activeSheet->getColumnDimension('A')->setWidth(16);
        $activeSheet->getColumnDimension('B')->setWidth(16);
        $activeSheet->getColumnDimension('C')->setWidth(16);
        $activeSheet->getColumnDimension('D')->setWidth(16);
        $activeSheet->getColumnDimension('E')->setWidth(16);
        $activeSheet->getColumnDimension('F')->setWidth(16);
        $activeSheet->getColumnDimension('G')->setWidth(16);
        $activeSheet->getColumnDimension('H')->setWidth(16);
        $activeSheet->getColumnDimension('I')->setWidth(16);
        $activeSheet->getColumnDimension('J')->setWidth(16);
        $activeSheet->getColumnDimension('K')->setWidth(16);
        $activeSheet->getColumnDimension('L')->setWidth(16);
        $activeSheet->getColumnDimension('M')->setWidth(16);
        $activeSheet
                ->getPageMargins()->setTop(0.4);
        $activeSheet
                ->getPageMargins()->setRight(0.2);
        $activeSheet
                ->getPageMargins()->setLeft(0.2);
        $activeSheet
                ->getPageMargins()->setBottom(0.8);
        $phpColor = new PHPExcel_Style_Color();
        $phpColor->setRGB('FF0000');
        $kFila = 2;
        
       
        $activeSheet->getRowDimension(1)->setRowHeight(20);
       
       
       
       
           
            $cabeceraPlanilla= Yii::app()->rrhh
            ->createCommand("(select 'TIPO DOC.'::text as nombre,'A1'::varchar(3) as celda)union
            (select'NUMERO DOCUMENTO'::text AS nombre ,'B1'::varchar(3) as celda)union
            (select'ALFANUMERICO DEL DOCUMENTO'::text AS nombre ,'C1'::varchar(3) as celda) union
            (select 'NUA / CUA'::text as nombre,'D1'::varchar(3) as celda)union
            (select 'AP. PATERNO'::text as nombre,'E1'::varchar(3) as celda)union
            (select'AP. MATERNO'::text as nombre,'F1'::varchar(3) as celda)union
            (select'AP. CASADA'::text as nombre,'G1'::varchar(3) as celda)union
            (select'PRIMER NOMBRE'::text as nombre,'H1'::varchar(3) as celda)union
            (select'SEG. NOMBRE'::text as nombre,'I1'::varchar(3) as celda)union
            (select'NOVEDAD'::text as nombre,'J1'::varchar(3) as celda)union
            (select'FECHA NOVEDAD'::text as nombre,'K1'::varchar(3) as celda)union
            (select'DIAS'::text as nombre,'L1'::varchar(3) as celda)union
            (select 'TOTAL GANADO'::text as nombre,'M1'::varchar(3) as celda)union
            (select'TIPO COTIZANTE'::text AS nombre ,'N1'::varchar(3) as celda) 
            union
            (select'TIPO ASEGURADO'::text AS nombre ,'O1'::varchar(3) as celda)")
            ->queryAll();
            $letras=$this->dameColumna('A', 12); 
            foreach ($cabeceraPlanilla as $cp) {  
                    $activeSheet->setCellValue($cp['celda'], $cp['nombre']); 
        }
        /// INICIO CUERPO
        $datoPlanilla  = Yii::app()->rrhh
        ->createCommand("select * from lista_planilla_retroactivo_afpministerio (".$model->id.",'$tipocontratosseleccionados'::text,($pagina+1)) ")
        ->queryAll();
        for ($i = 0; $i < count($datoPlanilla); $i++) {
         
          
         $activeSheet->setCellValue('A' . $kFila,$datoPlanilla[$i]['tipodoc']);
          $activeSheet->setCellValue('B' . $kFila,$datoPlanilla[$i]['ci']);
          $activeSheet->setCellValue('C' . $kFila,$datoPlanilla[$i]['alfanum']);       
          $activeSheet->setCellValue('D' . $kFila,$datoPlanilla[$i]['nua']);
          $activeSheet->setCellValue('E' . $kFila,$datoPlanilla[$i]['apellidop']);
          $activeSheet->setCellValue('F' . $kFila,$datoPlanilla[$i]['apellidom']);
          $activeSheet->setCellValue('G' . $kFila,$datoPlanilla[$i]['apellidocasada']);
          $activeSheet->setCellValue('H' . $kFila,$datoPlanilla[$i]['pnombre']);
          $activeSheet->setCellValue('I' . $kFila,$datoPlanilla[$i]['snombre']);
           $activeSheet->setCellValue('J' . $kFila,$datoPlanilla[$i]['novedad']);
          $activeSheet->setCellValue('K' . $kFila,$datoPlanilla[$i]['fechanovedad']);
          $activeSheet->setCellValue('L' . $kFila,$datoPlanilla[$i]['dias']);
          $activeSheet->setCellValue('M' . $kFila,$datoPlanilla[$i]['totalga']);
          $activeSheet->setCellValue('N' . $kFila,$datoPlanilla[$i]['cotizante']);
          $activeSheet->setCellValue('O' . $kFila,$datoPlanilla[$i]['tipoasegurado']);
          
              
          $kFila++;
      }
    
  

    } 
        $this->descargarExcel($objPHPExcel, 'RETROACTIVO AFP '.$model->anio);
    }
    /**
     * 
     * @param imteger $id, id de la planilla
     * @returna interfaz para la consolidacion de la planilla de Incremento Indemnizacion
     */
    public function actionConsolidarIncrementoIndemnizacion($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = new Planilla;
        $id = SeguridadModule::dec($id);
        $model->scenario = 'Desea Consolidar Planilla Incremento Indemnizacion?';
       
        if (isset($_POST['Planillaretroactivo'])) {
            Planillaretroactivo::model()->ConsolidarPlanillaIncrementoIndemnizacion($id);
            echo System::dataReturn('Asiento Planilla Ajuste Incremento Indemnizacion generada!! ');
            return;
        }
        $this->renderPartial('consolidarprefactura', array(
            'model' => $model,          
            
                ), false, true);
    }
}
