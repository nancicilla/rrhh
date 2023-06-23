<?php
/*
 * BonoliberalidadController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 25/07/2022
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
class BonoespecialController extends Controller
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
        
        $model=new Bonoespecial;
        $laportacion = Yii::app()->rrhh
                ->createCommand("select * from cabecera where eliminado=false and idplanilla =(select id from planilla where eliminado=false and estado>=3 order by id desc limit 1) and tipo =2 order by nombre asc")
                ->queryAll();
        $lbeneficio = Yii::app()->rrhh
                ->createCommand("(select nombre,nombref from cabecera where eliminado=false and idplanilla =(select id from planilla where eliminado=false and estado>=3 order by id desc limit 1) and tipo =1 and nombref<>'totalga')union
( select 'HABER BASICO'::varchar(70) as nombre,'hbasico'::varchar(70) as nombref) order by nombre asc ")->queryAll();
     
        if(isset($_POST['Bonoespecial'])){
               
                if($_POST['Bonoespecial']['opcion']!=1){
                    $_POST['Bonoespecial']['fechadesde']= new CDbExpression('NOW()::date');
                    $_POST['Bonoespecial']['fechahasta']= new CDbExpression('NOW()::date');
                }
                  $model->attributes=$_POST['Bonoespecial'];
                 
                if($model->save()){                    
                   if($model->opcion==3){
                     $model->porcentaje=$model->monto;
                     $model->monto=0;
                   //  print_r( $model->save());
                    }
                switch ($model->opcion){
                    case 1:{
                            if (isset($_POST['aportebeneficioa'])){
                    
                                    Bonoespecial::model()->guardarAporte($model->id,$_POST['aportebeneficioa'],1);
                               }
                               if (isset($_POST['aportebeneficior'])){

                                   Bonoespecial::model()->guardarAporte($model->id,$_POST['aportebeneficior'],0);
                               }
                            break;
                    }
                    case 3:{
                        
                        Bonoespecial::model()->guardarBeneficioAporte($model,$_POST['gridBeneficios'],2);
                      
                        Bonoespecial::model()->guardarBeneficioAporte($model,$_POST['gridAportaciones'],3);
                            break;
                    }
                    
                }
                    
                  Bonoespecial::model()-> RegistrarBono($model->id);
                    echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {
                   echo System::hasErrors('Revise los datos! ', $model);
                   return;
                }
        }

        $this->renderPartial('create',array(
            'model'=>$model,
            'laportebeneficioa'=>array(),
            'laportebeneficior'=>array(),
            'lbeneficio'=>$lbeneficio,
            'laportacion'=>$laportacion,
            
            
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

        if(isset($_POST['Bonoespecial']))
        {
            $model->attributes=$_POST['Bonoespecial'];
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

        $model=new Bonoespecial('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Bonoespecial'])){
                $model->attributes=$_GET['Bonoespecial'];
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
     * 
     * @param integer $id, id de la prima anual
     * retorna una interfaz en la que muestra los posibles beneficiarios
     */
    public function actionListaempleado($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $id = SeguridadModule::dec($id);
        $model = new Pagobeneficio;
        $listaempleados = Yii::app()->rrhh->createCommand("select b.id, p.nombrecompleto as empleados, case when b.estado=0 then 'RETIRADO' else 'ACTIVO' end estado from bonoespecialempleado b inner join general.empleado e on e.id=b.idempleado inner join general.persona p on p.id=e.idpersona
         where b.idbonoespecial=$id and b.eliminado=false  order by p.nombrecompleto,3 asc ")->queryAll();

        if (isset($_POST['gridListaEmpleados'])) {

            Bonoespecial::model()->GuaradarListaempleado($id, $_POST['gridListaEmpleados']);
        }
        $this->renderPartial('listaempleado', array(
            'listaempleados' => $listaempleados,
            'model' => $model
                ), false, true);
    }
    public function actionPlanilla($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $id = SeguridadModule::dec($id);
        $model = $this->loadModel($id);
        $lempresasubempleadora = Empresasubempleadora::model()->findAll();
        if (isset($_POST['gridListaEmpleados'])) {

            Bonoespecial::model()->GuaradarListaempleado($_POST['gridListaEmpleados']);
        }
        $this->renderPartial('planillaprefactura', array(
            
            'model' => $model,
            'lempresasubempleadora'=>$lempresasubempleadora
                ), false, true);
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Bonoliberalidad the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Bonoespecial::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Bonoliberalidad $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bonoespecial-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
          public function actionDescargarPrefactura() {
             $unidades=$_GET['empresasubempleadora'];
             $id=$_GET['Bonoespecial']['id'];
           
             $unidadesseleccionadas='';
             $titulo='BONOS ESPECIALES ';
             for ($i = 0; $i < count($unidades); $i++) {
                        $unidadesseleccionadas = $unidadesseleccionadas . $unidades[$i] . ',';
                    }
                    if (count($unidades)>0)
                    $unidadesseleccionadas = substr($unidadesseleccionadas, 0, -1);
                else {
                $unidadesseleccionadas=0;    
                }
        $infobono = Yii::app()->rrhh->createCommand("select  (porcentaje*100)::numeric(15,4) as porcentajemostrar, * from general.bonoespecial where id=" . $id . " ")->queryAll()[0];
        if($infobono['estado']==1){
            $titulo='BORRADOR '.$titulo;            
        }    
         $cantcolFactura=5;
        switch ($infobono['opcion']){
            case 1:{
                   
                    $cantcolBeneficio= 7;
                    $cantcolAporte=Yii::app()->rrhh
                           ->createCommand(" select count(*)+1 from aporbenebonoespecial where eliminado=false and idbonoespecial=$id")
                           ->queryScalar(); 
                    break;
            }
            case 2:{
                   
                    $cantcolBeneficio=1;
                    $cantcolAporte=0;
                    break;
            }
        case 3:{
             $cantcolBeneficio= Yii::app()->rrhh
                           ->createCommand("        select count(*)+1
from (SELECT    json_array_elements(beneficio)->>'nombre' as nombre, json_array_elements(beneficio)->>'nombref' as nombref 
   FROM GENERAL.BONOESPECIAL where id=$id)  as t")
                           ->queryScalar(); 
                    $cantcolAporte=Yii::app()->rrhh
                           ->createCommand("        select count(*)+1
from (SELECT    json_array_elements(aporte)->>'nombre' as nombre, json_array_elements(aporte)->>'nombref' as nombref 
   FROM GENERAL.BONOESPECIAL where id=$id)  as t")
                           ->queryScalar(); 
                break;
        }
            
        }           
     

        $datoEmpresa = Yii::app()->rrhh
                        ->createCommand("select * from  general.representante r inner join general.empresa e on e.id=r.idempresa where r.activo=true  " )
                        ->queryAll()[0];
        
  $datoPlanilla= $this-> dameInformacion($infobono,$unidadesseleccionadas) ;     
  $cabeceraPlanilla=$this->dameCabecera($infobono);      
  
        $cantcolGeneral =14;
                  
               
        $nombreArchivo = 'PF_' . $infobono['nombre'];
       
        $columnasGeneral = $this->dameColumna('A', $cantcolGeneral);
        $columnasBeneficio=$this->dameColumna($columnasGeneral[$cantcolGeneral], $cantcolBeneficio);
        $columnasAporte=$this->dameColumna($columnasBeneficio[$cantcolBeneficio], $cantcolAporte);
        $columnasFacturas  = $this->dameColumna($columnasAporte[$cantcolAporte], $cantcolFactura);
        $totalcolumnas=$cantcolGeneral+$cantcolFactura+$cantcolAporte+$cantcolBeneficio;
        
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
                 'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            ),
            'font' => array(
                'bold' => true,
            ),);
 $phpFontCuerpo= array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    ),
                ),
               
            );
        $activeSheet->getColumnDimension('A')->setWidth(10);
        $activeSheet->getColumnDimension('B')->setWidth(20);
        $activeSheet->getColumnDimension('C')->setWidth(20);
        $activeSheet->getColumnDimension('D')->setWidth(20);
        $activeSheet->getColumnDimension('E')->setWidth(20);
        $activeSheet->getColumnDimension('F')->setWidth(20);
        
        $activeSheet->getColumnDimension('G')->setWidth(20);
        $activeSheet->getColumnDimension('H')->setWidth(45);
        $activeSheet->getColumnDimension('I')->setWidth(20);
        $activeSheet->getColumnDimension('J')->setWidth(20);
        $activeSheet->getColumnDimension('K')->setWidth(10);
        $activeSheet->getColumnDimension('L')->setWidth(30);
        $activeSheet->getColumnDimension('M')->setWidth(20);
        
        $activeSheet->getColumnDimension('N')->setWidth(20);
        $activeSheet->getColumnDimension('O')->setWidth(20);
        $activeSheet->getColumnDimension('P')->setWidth(20);
        $activeSheet->getColumnDimension('Q')->setWidth(20);
        $activeSheet->getColumnDimension('R')->setWidth(20);
        $activeSheet->getColumnDimension('S')->setWidth(20);
        $activeSheet->getColumnDimension('T')->setWidth(20);
        $activeSheet->getColumnDimension('U')->setWidth(25);
        $activeSheet->getColumnDimension('V')->setWidth(25);
        $activeSheet->getColumnDimension('W')->setWidth(20);
        $activeSheet->getColumnDimension('X')->setWidth(20);
        $activeSheet->getColumnDimension('Y')->setWidth(20);
        $activeSheet->getColumnDimension('Z')->setWidth(20);
        $activeSheet->getColumnDimension('AA')->setWidth(20);
        $activeSheet->getColumnDimension('AB')->setWidth(20);
        $activeSheet->getColumnDimension('AC')->setWidth(20);
        $activeSheet->getColumnDimension('AD')->setWidth(20);
        $activeSheet->getColumnDimension('AE')->setWidth(20);
        $activeSheet->getColumnDimension('AF')->setWidth(20);
        $activeSheet->getColumnDimension('AG')->setWidth(20);
        $activeSheet->getColumnDimension('AH')->setWidth(20);
        $activeSheet->getColumnDimension('AI')->setWidth(20);
        $activeSheet->getColumnDimension('AJ')->setWidth(20);
        $activeSheet->getColumnDimension('AK')->setWidth(20);
        $activeSheet->getColumnDimension('AL')->setWidth(20);
        $activeSheet->getColumnDimension('AM')->setWidth(20);
        $activeSheet->getColumnDimension('AN')->setWidth(20);
        $activeSheet->getColumnDimension('AO')->setWidth(20);
        $activeSheet->getColumnDimension('AP')->setWidth(20);
        $activeSheet->getColumnDimension('AQ')->setWidth(20);
        $activeSheet->getColumnDimension('AR')->setWidth(20);
        $activeSheet->getColumnDimension('AS')->setWidth(20);
        $activeSheet->getColumnDimension('AT')->setWidth(20);
        $activeSheet->getColumnDimension('AU')->setWidth(20);
        $activeSheet->getColumnDimension('AV')->setWidth(20);
        $activeSheet->getColumnDimension('AW')->setWidth(20);
        $activeSheet->getColumnDimension('AX')->setWidth(20);
        $activeSheet->getColumnDimension('AY')->setWidth(20);
        $activeSheet->getColumnDimension('AZ')->setWidth(20);
        $activeSheet->getColumnDimension('BA')->setWidth(20);
        $activeSheet->getColumnDimension('BB')->setWidth(20);
        $activeSheet->getColumnDimension('BC')->setWidth(20);
        $activeSheet->getColumnDimension('BD')->setWidth(20);
        $activeSheet->getColumnDimension('BE')->setWidth(20);
        $activeSheet->getColumnDimension('BF')->setWidth(20);
        $activeSheet->getColumnDimension('BG')->setWidth(20);
        $activeSheet->getColumnDimension('BH')->setWidth(20);
        $activeSheet->getColumnDimension('BI')->setWidth(20);
        $activeSheet->getColumnDimension('BJ')->setWidth(20);
        $activeSheet->getColumnDimension('BK')->setWidth(20);
        $activeSheet->getColumnDimension('BL')->setWidth(20);
        $activeSheet->getColumnDimension('BM')->setWidth(20);
        $activeSheet->getColumnDimension('BN')->setWidth(20);
        $activeSheet->getColumnDimension('BO')->setWidth(20);
        $activeSheet->getColumnDimension('BP')->setWidth(20);
        $activeSheet->getColumnDimension('BQ')->setWidth(20);
        $activeSheet->getColumnDimension('BR')->setWidth(20);
        $activeSheet->getColumnDimension('BS')->setWidth(20);
        $activeSheet->getColumnDimension('BT')->setWidth(20);
        $activeSheet->getColumnDimension('BU')->setWidth(20);
        $activeSheet->getColumnDimension('BV')->setWidth(20);
        $activeSheet->getColumnDimension('BW')->setWidth(20);
        $activeSheet->getColumnDimension('BX')->setWidth(20);
        $activeSheet->getColumnDimension('BY')->setWidth(20);
        
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
        $activeSheet->mergeCells('A1:O1');
        $activeSheet->mergeCells('A2:O2');
        $activeSheet->mergeCells('A3:O3');
        $activeSheet->mergeCells('A4:O4');
        $activeSheet->mergeCells('E6:F6');
        $activeSheet->mergeCells('P1:R1');
        $activeSheet->mergeCells('P2:R2');
        $activeSheet->mergeCells('P3:R3');
        $activeSheet->mergeCells('P4:R4');
        $activeSheet->mergeCells('P5:R5');
        $activeSheet->setCellValue('A1', strtoupper("PLANILLA PREFACTURA BONO ".$infobono['nombre']." CORRESPONDIENTE A LA GESTIÓN " . $infobono['gestion'] ));
        $activeSheet->setCellValue('A3', strtoupper($datoEmpresa['cns']));
        $activeSheet->setCellValue('E5', 'Nro. Patronal:');
        $activeSheet->setCellValue('G5', $datoEmpresa['nrempleador']);
        $activeSheet->getStyle('E5:G5')->getFont()->setBold(true)->setSize(9);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $activeSheet->setCellValue('P1', $datoEmpresa['direccion']);
        $activeSheet->setCellValue('P2', "NIT:" . $datoEmpresa['nit']);
        $activeSheet->setCellValue('P3', "TEL:" . $datoEmpresa['telefono'] . "   FAX:" . $datoEmpresa['fax']);
        $activeSheet->getStyle("A1")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(12);
        $activeSheet->getStyle("A1")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("A3")->getFont()->setBold(true)
                ->setName('Times New Roman')
                ->setSize(11);
        $activeSheet->getStyle("A3")->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ), 'font' => array(
                'bold' => true,
        )));
        $activeSheet->getStyle("P1:P5")->getFont()->setBold(false)
                ->setName('Times New Roman')
                ->setSize(7);       
        $activeSheet->getStyle('A7:'. $columnasFacturas[$cantcolFactura-1].'7')->applyFromArray($phpFontC);
        $activeSheet->getStyle('A7:'.$columnasFacturas[$cantcolFactura-1].'7')->getAlignment()->setWrapText(true);
        $activeSheet->getStyle("A8:" . $columnasFacturas[$cantcolFactura-1] . '8')->applyFromArray(
                        $phpFontC
                );
            

            $activeSheet->getStyle("A7:CC7")->getAlignment()->setWrapText(true);
            $inde = 0;
            $indb = 0;
            $inda = 0;
            $indf=0;
            $activeSheet->mergeCells( 'A7:A8');
            $activeSheet->mergeCells( 'B7:B8');
            $activeSheet->mergeCells( 'C7:C8');
            $activeSheet->mergeCells( 'D7:D8');
            $activeSheet->mergeCells( 'E7:E8');
            $activeSheet->setCellValue( 'A7', 'No');
            $activeSheet->setCellValue( 'B7', 'PERD');
            $activeSheet->setCellValue( 'C7', 'REG');
            $activeSheet->setCellValue( 'D7', 'EMPRESA/CLIENTE');
            $activeSheet->setCellValue( 'E7', 'ESTADO');

            foreach ($cabeceraPlanilla as $cp) {
                if ($cp['tipo'] == 0) {
                    $activeSheet->mergeCells($columnasGeneral[$inde] . '7:' . $columnasGeneral[$inde] . '8');
                    $activeSheet->setCellValue($columnasGeneral[$inde] . '7', $cp['nombre']);
                    ++$inde;
                }
             
                if ($cp['tipo'] == 1) {
                    $activeSheet->mergeCells($columnasBeneficio[$indb] . '7:' .$columnasBeneficio[$indb] . '8');
                    $activeSheet->setCellValue($columnasBeneficio[$indb] . '7', $cp['nombre']);
                    ++$indb;
                }
                if ($cp['tipo'] == 2) {
                    $activeSheet->mergeCells($columnasAporte[$inda] . '7:' . $columnasAporte[$inda] . '8');
                 
                    $activeSheet->setCellValue($columnasAporte[$inda] . '7', $cp['nombre']);
                    ++$inda;
                }
               
                if ($cp['tipo'] == 10 ) {
                    $activeSheet->mergeCells($columnasFacturas[$indf] . '7:' . $columnasFacturas[$indf] . '8');

                    $activeSheet->setCellValue($columnasFacturas[$indf] . '7', $cp['nombre']);
                    ++$indf;
                }
             
            }        
            
                   
            $ltra = 'N';
            $ltra2 = 'O';
            
            
            ///CUERPO
            for ($i = 0; $i < count($datoPlanilla); $i++) {
                $activeSheet->getStyle($columnasGeneral[$inde] . $kFila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $deducciones = json_decode($datoPlanilla[$i]['aportes'], true); 
                if($infobono['opcion']==3){
                $beneficios = json_decode($datoPlanilla[$i]['beneficios'], true);}
                $inde = 0;
                $indb = 0;
                $inda = 0;
                $indf=0;
                $apor=0;
                $montobe = 0;
                $activeSheet->getRowDimension($kFila)->setRowHeight(17);
                $activeSheet->setCellValue( 'A'.$kFila,   $i + 1);                
                $activeSheet->getStyle("A".$kFila.":" . $columnasFacturas[$cantcolFactura-1] . $kFila)->applyFromArray(
                        $phpFontCuerpo
                );
                
                foreach ($cabeceraPlanilla as $cp) {
                  
                    if ($cp['tipo'] == 0) {       
                        if ($cp['nombre']=='Nro')
                            $activeSheet->setCellValue( 'A'.$kFila,   $i + 1);
                        else
                        $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, $datoPlanilla[$i][$cp['nombref']]);               
                        
                        ++$inde;
                    }

                    
                  
                     if ($cp['tipo'] == 10) {

                        $activeSheet->getStyle($columnasFacturas[$indf] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                        $activeSheet->getStyle($columnasFacturas[$indf] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        if($cp['nombref']=='grantotal')
                        {
                            if($cantcolAporte>0){
                                 $activeSheet->setCellValue($columnasFacturas[$indf] . $kFila, '=round(('.$columnasBeneficio[$cantcolBeneficio-1]. $kFila.'+'.$columnasAporte[$cantcolAporte -1]. $kFila.'), 2)');
                 
                            }else{
                                 $activeSheet->setCellValue($columnasFacturas[$indf] . $kFila, '=round(('.$columnasBeneficio[$cantcolBeneficio-1]. $kFila.'), 2)');
                 
                            }
                         }
                         elseif ($cp['nombref']=='fee') {
                            $activeSheet->setCellValue($columnasFacturas[$indf] . $kFila, '=round(('.$columnasFacturas[$indf-1]. $kFila.'*'.$datoPlanilla[$i] ['fee'].' ), 2)');
                      
                        }elseif($cp['nombref']=='totalfee'){
                            $activeSheet->setCellValue($columnasFacturas[$indf] . $kFila, '=round(sum('.$columnasFacturas[$indf-1]. $kFila.':'.$columnasFacturas[$indf-2]. $kFila.'), 2)');
                   
                        }elseif ($cp['nombref']=='impuesto') {
                            $activeSheet->setCellValue($columnasFacturas[$indf] . $kFila, '=round(('.$columnasFacturas[$indf-1]. $kFila.'*'.$datoPlanilla[$i] ['impuesto'].' ), 2)');
                      
                        }elseif ($cp['nombref']=='totalfacturacion') {
                            $activeSheet->setCellValue($columnasFacturas[$indf] . $kFila, '=round(sum('.$columnasFacturas[$cantcolFactura-2]. $kFila.':'.$columnasFacturas[$cantcolFactura-3]. $kFila.'), 2)');
                   
                        }                    

                        ++$indf;
                    }
                    if ($cp['tipo'] == 1) {

                        $activeSheet->getStyle($columnasBeneficio[$indb] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                        $activeSheet->getStyle($columnasBeneficio[$indb] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        
                        if($infobono['opcion']!==3){
                        $activeSheet->setCellValue($columnasBeneficio[$indb] . $kFila, '=round(sum('.$columnasBeneficio[0] . $kFila.':'.$columnasBeneficio[$indb] . $kFila.'),2)');
                        $activeSheet->setCellValue($columnasBeneficio[$indb] . $kFila, $datoPlanilla[$i][$cp['nombref']]);               
                        }else{
                                if ($cp['nombref']=='totalga')
                           {
                                 $activeSheet->setCellValue($columnasBeneficio[$indb] . $kFila, '=round(sum('.$columnasBeneficio[0] . $kFila.':'.$columnasBeneficio[$indb] . $kFila.'),2)');


                           }else{
                                $activeSheet->setCellValue($columnasBeneficio[$indb] . $kFila, round((($beneficios[0][$cp['nombref']]*$datoPlanilla[$i]['porcentaje'])/100),2));

                           }
                        }
                        
                        
                        
            
                        ++$indb;
                    }
                    if ($cp['tipo'] == 2) {

                        $activeSheet->getStyle($columnasAporte[$inda] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                        $activeSheet->getStyle($columnasAporte[$inda] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        if ($cp['nombref']=='totaldes')
                        {
                              $activeSheet->setCellValue($columnasAporte[$inda] . $kFila, '=round(sum('.$columnasAporte[0] . $kFila.':'.$columnasAporte[$inda] . $kFila.'),2)');
                 
                          
                        }else{
                             $activeSheet->setCellValue($columnasAporte[$inda] . $kFila, round((($deducciones[0][$cp['nombref']]*$datoPlanilla[$i]['porcentaje'])/100),2));
                           
                        }
                        
                        
                        
            
                        ++$inda;
                    }
                    
                  
                }           

                

                $kFila++;
            }

            $activeSheet->mergeCells('A' . $kFila . ':' . $ltra . $kFila);
            $activeSheet->getStyle('A' . $kFila)->applyFromArray($phpFont1);
            $activeSheet->getStyle($ltra2 . $kFila)->applyFromArray($phpFont1);
            $activeSheet->getStyle('P' . $kFila)->applyFromArray($phpFont1);
            $activeSheet->setCellValue('A' . $kFila, 'TOTALES');

            $activeSheet->getRowDimension($kFila)->setRowHeight(20);
            $activeSheet->setCellValue($ltra2 . $kFila, '=SUM(' . $ltra2 . '8:' . $ltra2 . ($kFila - 1) . ')');
            $activeSheet->setCellValue('P' . $kFila, '=SUM(P8:P' . ($kFila - 1) . ')');
            for ($j = 0; $j < $cantcolBeneficio; $j++) {

                $activeSheet->getStyle($columnasBeneficio[$j] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle($columnasBeneficio[$j] . $kFila)->applyFromArray($phpFont1);
                $activeSheet->setCellValue($columnasBeneficio[$j] . $kFila, '=SUM(' . $columnasBeneficio[$j]. '9:' . $columnasBeneficio[$j] . ($kFila - 1) . ')');
            }
            for ($j = 0; $j < $cantcolAporte; $j++) {

                $activeSheet->getStyle($columnasAporte[$j] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle($columnasAporte[$j] . $kFila)->applyFromArray($phpFont1);
                $activeSheet->setCellValue($columnasAporte[$j] . $kFila, '=SUM(' . $columnasAporte[$j]. '9:' . $columnasAporte[$j] . ($kFila - 1) . ')');
            }
             for ($j = 0; $j < $cantcolFactura; $j++) {

                $activeSheet->getStyle($columnasFacturas[$j] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle($columnasFacturas[$j] . $kFila)->applyFromArray($phpFont1);
                $activeSheet->setCellValue($columnasFacturas[$j] . $kFila, '=SUM(' . $columnasFacturas[$j]. '9:' . $columnasFacturas[$j] . ($kFila - 1) . ')');
            }
            $totalcolumnas=$totalcolumnas-1;
            $total= $activeSheet->getCellByColumnAndRow($totalcolumnas, $kFila)->getCalculatedValue(); 
          
        
            
          
               
        ///CUERPO       
        $kFila += 8;

        $activeSheet->setCellValue('F' . $kFila, 'GERENTE DE FINANZAS');
        $activeSheet->mergeCells('J' . $kFila . ':M' . $kFila);
        $activeSheet->setCellValue('J' . $kFila, 'GERENTE');
        $activeSheet->getStyle('F' . $kFila)->getFont()->setBold(true)->setSize(8);
        $activeSheet->getStyle('J' . $kFila)->getFont()->setBold(true)->setSize(8);
        $activeSheet->getStyle('J' . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('F' . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


        $kFila += 3;

        $activeSheet->mergeCells('D' . $kFila . ':J' . $kFila);
        $activeSheet->mergeCells('M' . $kFila . ':N' . $kFila);
        
        $objPHPExcel->createSheet($i);        
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
        $activeSheet->setCellValue('B5' ,"RESUMEN PLANILLA PREFACTURA ".$titulo." SOLUR S.R.L. " ); 
        $activeSheet->setCellValue('B6' ,"PRE FACTURA  PLANILLA GLOBAL GESTIÓN ".$infobono['gestion'] ); 
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
     * @param integer $id, id del bonoque se quiere consolidar
     * @return formualrio para la consolidacion
     */
      public function actionConsolidar($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model=$this->loadModel(SeguridadModule::dec($id));
        if (isset($_POST['Bonoespecial'])) {
            $usuario = Yii::app()->user->getName();  
            $model->attributes=$_POST['Bonoespecial'];
            $model->save();
            Yii::app()->contabilidad
                    ->createCommand("select generar_asiento_prefacturabonoespecial($model->id,'$usuario')")
                    ->execute();                   
            echo System::dataReturn('Bono Consolidado');
            return;
        }
        $this->renderPartial('consolidar', array(
            'model' => $model,
            
                ), false, true);
    }
    public function  dameCabecera($infobono) {
        
          
    
        $cabeceraPlanilla=[];
        switch ($infobono['opcion']){
            case 1:{
                   $cabeceraPlanilla = Yii::app()->rrhh
                            ->createCommand("
( select 1::int as orden, 'Nro' as nombre,'Nro' as nombref ,0::int  as tipo)   union
( select 2::int as orden, 'PERD' as nombre,'periodo' as nombref ,0::int as tipo )   union
( select 3::int as orden, 'REG' as nombre,'reg' as nombref ,0::int as tipo )   union
( select 4::int as orden, 'EMPRESA/CLIENTE' as nombre,'empresa' as nombref ,0::int as tipo )   union
( select 5::int as orden, 'ESTADO' as nombre,'estado' as nombref ,0::int as tipo)   union
( select 6::int as orden, 'C.I.' as nombre,'ci' as nombref ,0::int as tipo )   union
( select 7::int as orden, 'EXTENCION' as nombre,'expedicion' as nombref ,0::int as tipo )   union
( select 8::int as orden, 'APELLIDOS Y NOMBRES' as nombre,'nombrecompleto' as nombref ,0::int as tipo )   union
( select 9::int as orden, 'NACIONALIDAD' as nombre,'nacionalidad' as nombref ,0::int as tipo)   union
( select 10::int as orden, 'FECHA DE NACIMIENTO' as nombre,'fechanac' as nombref ,0::int as tipo)   union
( select 11::int as orden, 'SEXO' as nombre,'sexo' as nombref ,0::int as tipo)   union
( select 12::int as orden, 'OCUPACIÓN QUE DESMPEÑA' as nombre,'cargo' as nombref ,0::int as tipo)   union
( select 13::int as orden, 'FECHA INGRESO' as nombre,'fechaplanilla' as nombref ,0::int as tipo )   union
( select 14::int as orden, 'FECHA RETIRO' as nombre,'fecharetiro' as nombref ,0::int as tipo)   union
( select 15::int as orden, 'M1' as nombre,'pmes' as nombref ,1::int as tipo)   union
( select 16::int as orden, 'M2' as nombre,'smes' as nombref ,1::int as tipo )   union
( select 17::int as orden, 'M3' as nombre,'tmes' as nombref ,1::int as tipo)   union
( select 18::int as orden, 'PROMEDIO' as nombre,'promedio' as nombref ,1::int as tipo )   union
( select 19::int as orden, 'MESES TRABAJO' as nombre,'mesestrabajo' as nombref ,1::int as tipo )   union
( select 20::int as orden, 'TOTAL' as nombre,'promediotg' as nombref ,1::int as tipo)   union
( select 21::int as orden, '".$infobono['nombre'].' '.$infobono['porcentajemostrar']."%' as nombre,'total' as nombref ,1::int as tipo)   union
( select 121::int as orden, 'TOTAL DEDUCCIONES' as nombre,'totaldes' as nombref ,2::int as tipo )   union

               (select 20000::int as orden,'GRAN TOTAL' as nombre,'grantotal' as nombref,10::int as tipo)
union(select 20100::int as orden,'FEE' as nombre,'fee' as nombref,10::int as tipo)
union(select 20200::int as orden,'TOTAL + FEE' as nombre,'totalfee' as nombref,10::int as tipo)
union(select 20300::int as orden,'IMPUESTO' as nombre,'impuesto' as nombref,10::int as tipo)
union(select 20400::int as orden,'TOTAL FACTURACION' as nombre,'totalfacturacion' as nombref,10::int as tipo)
union(select (22::int+ (case when abb.estado=1 then 0::int else 1::int end))::int as orden,
case when abb.estado=1 then ( select nombre from general.aportacionbeneficio ab where ab.id=abb.idaportacionbeneficio) else 
( select ab.nombre from ftbl_impuesto ab where ab.id=abb.idaportacionbeneficio) end as nombre,

case when abb.estado=1 then ( select nombref from general.aportacionbeneficio ab where ab.id=abb.idaportacionbeneficio) else 
( select  replace(ab.nombre,' ','') from ftbl_impuesto ab where ab.id=abb.idaportacionbeneficio) end as nombref , 2::int as tipo
 from aporbenebonoespecial abb where eliminado=false and idbonoespecial=".$infobono['id']." order by 2 asc)
 order by orden,nombref asc  ")
                            ->queryAll();
                   
                break;
            }
            case 2:{
                  $cabeceraPlanilla = Yii::app()->rrhh
                            ->createCommand("( select 1::int as orden, 'Nro' as nombre,'Nro' as nombref ,0::int  as tipo)   union
( select 2::int as orden, 'PERD' as nombre,'periodo' as nombref ,0::int as tipo )   union
( select 3::int as orden, 'REG' as nombre,'reg' as nombref ,0::int as tipo )   union
( select 4::int as orden, 'EMPRESA/CLIENTE' as nombre,'empresa' as nombref ,0::int as tipo )   union
( select 5::int as orden, 'ESTADO' as nombre,'estado' as nombref ,0::int as tipo)   union
( select 6::int as orden, 'C.I.' as nombre,'ci' as nombref ,0::int as tipo )   union
( select 7::int as orden, 'EXTENCION' as nombre,'expedicion' as nombref ,0::int as tipo )   union
( select 8::int as orden, 'APELLIDOS Y NOMBRES' as nombre,'nombrecompleto' as nombref ,0::int as tipo )   union
( select 9::int as orden, 'NACIONALIDAD' as nombre,'nacionalidad' as nombref ,0::int as tipo)   union
( select 10::int as orden, 'FECHA DE NACIMIENTO' as nombre,'fechanac' as nombref ,0::int as tipo)   union
( select 11::int as orden, 'SEXO' as nombre,'sexo' as nombref ,0::int as tipo)   union
( select 12::int as orden, 'OCUPACIÓN QUE DESMPEÑA' as nombre,'cargo' as nombref ,0::int as tipo)   union
( select 13::int as orden, 'FECHA INGRESO' as nombre,'fechaplanilla' as nombref ,0::int as tipo )   union
( select 14::int as orden, 'FECHA RETIRO' as nombre,'fecharetiro' as nombref ,0::int as tipo)   union
( select 21::int as orden, '".$infobono['nombre']."' as nombre,'total' as nombref ,1::int as tipo)   union
(select 20000::int as orden,'GRAN TOTAL' as nombre,'grantotal' as nombref,10::int as tipo)
union(select 20100::int as orden,'FEE' as nombre,'fee' as nombref,10::int as tipo)
union(select 20200::int as orden,'TOTAL + FEE' as nombre,'totalfee' as nombref,10::int as tipo)
union(select 20300::int as orden,'IMPUESTO' as nombre,'impuesto' as nombref,10::int as tipo)
union(select 20400::int as orden,'TOTAL FACTURACION' as nombre,'totalfacturacion' as nombref,10::int as tipo)

 order by orden,nombref asc  ")
                            ->queryAll();
                    break;
            }default :{
                  $cabeceraPlanilla = Yii::app()->rrhh
                            ->createCommand("( select 1::int as orden, 'Nro' as nombre,'Nro' as nombref ,0::int  as tipo)   union
( select 2::int as orden, 'PERD' as nombre,'periodo' as nombref ,0::int as tipo )   union
( select 3::int as orden, 'REG' as nombre,'reg' as nombref ,0::int as tipo )   union
( select 4::int as orden, 'EMPRESA/CLIENTE' as nombre,'empresa' as nombref ,0::int as tipo )   union
( select 5::int as orden, 'ESTADO' as nombre,'estado' as nombref ,0::int as tipo)   union
( select 6::int as orden, 'C.I.' as nombre,'ci' as nombref ,0::int as tipo )   union
( select 7::int as orden, 'EXTENCION' as nombre,'expedicion' as nombref ,0::int as tipo )   union
( select 8::int as orden, 'APELLIDOS Y NOMBRES' as nombre,'nombrecompleto' as nombref ,0::int as tipo )   union
( select 9::int as orden, 'NACIONALIDAD' as nombre,'nacionalidad' as nombref ,0::int as tipo)   union
( select 10::int as orden, 'FECHA DE NACIMIENTO' as nombre,'fechanac' as nombref ,0::int as tipo)   union
( select 11::int as orden, 'SEXO' as nombre,'sexo' as nombref ,0::int as tipo)   union
( select 12::int as orden, 'OCUPACIÓN QUE DESMPEÑA' as nombre,'cargo' as nombref ,0::int as tipo)   union
( select 13::int as orden, 'FECHA INGRESO' as nombre,'fechaplanilla' as nombref ,0::int as tipo )   union
( select 14::int as orden, 'FECHA RETIRO' as nombre,'fecharetiro' as nombref ,0::int as tipo)   union
(select  
ROW_NUMBER () OVER (ORDER BY nombre)+14 as orden,t.*,1::int as tipo

from  (SELECT    json_array_elements(beneficio)->>'nombre' as nombre, json_array_elements(beneficio)->>'nombref' as nombref
 FROM GENERAL.BONOESPECIAL where id=".$infobono['id'].") as t)
union
(select  
ROW_NUMBER () OVER (ORDER BY nombre)+200 as orden,t.*,2::int as tipo

from  (SELECT    json_array_elements(aporte)->>'nombre' as nombre, json_array_elements(aporte)->>'nombref' as nombref
 FROM GENERAL.BONOESPECIAL where id=".$infobono['id'].") as t)union
 ( select 100::int as orden, 'TOTAL' as nombre,'totalga' as nombref ,1::int as tipo) union
 ( select 300::int as orden, 'TOTAL DESCUENTO' as nombre,'totaldes' as nombref ,2::int as tipo)   
union(select 20000::int as orden,'GRAN TOTAL' as nombre,'grantotal' as nombref,10::int as tipo)
union(select 20100::int as orden,'FEE' as nombre,'fee' as nombref,10::int as tipo)
union(select 20200::int as orden,'TOTAL + FEE' as nombre,'totalfee' as nombref,10::int as tipo)
union(select 20300::int as orden,'IMPUESTO' as nombre,'impuesto' as nombref,10::int as tipo)
union(select 20400::int as orden,'TOTAL FACTURACION' as nombre,'totalfacturacion' as nombref,10::int as tipo)

 order by orden,nombref asc ")
                            ->queryAll();
                break;
            }
            
        }
     
        return $cabeceraPlanilla;        
                   
    }
    public function dameInformacion($infobono,$unidadesseleccionadas) {
         $datoPlanilla=[];
        switch ($infobono['opcion']){
            case 1:{
                 $datoPlanilla = Yii::app()->rrhh
                ->createCommand("select pp.porcentaje,'SUCRE' AS reg,case when be.estado=1 then 'ACTIVO' else 'RETIRADO' end  as estado,(select fee from general.empresasubempleadora where id=pp.idempresasubempleadora)/100 as fee,(select impuesto from general.empresasubempleadora where id=pp.idempresasubempleadora)/100  as impuesto,'".$infobono['gestion']."'::varchar(15) as periodo,(select nombre from general.empresasubempleadora where id=pp.idempresasubempleadora) as empresa, case when be.estado=0 then 'RETIRADO'::varchar(30) else 'ACTIVO'::varchar(30) end as estado,p.ci,p.expedicion ,p.nombrecompleto
,(select pa.nacionalidad from general.localidad l inner join general.municipio m on m.id=l.idmunicipio inner join general.provincia pr on pr.id=m.idprovincia inner join ftbl_compra_departamento d on d.id=pr.iddepartamento inner join ftbl_compra_pais pa on pa.id=d.idpais where l.id=p.idlocalidad) AS nacionalidad,
to_char(p.fechanac,'dd/mm/YYYY') as fechanac,p.sexo,be.cargo, to_char( be.fechaplanilla,'dd/mm/YYYY') as fechaplanilla,to_char(be.fecharetiro,'dd/mm/YYYY') as fecharetiro,

((be.pmes*pp.porcentaje)/100)::numeric(12,2) as pmes,((be.smes*pp.porcentaje)/100)::numeric(12,2) as smes, ((be.tmes*pp.porcentaje)/100)::numeric(12,2)as tmes,((be.promedio*pp.porcentaje)/100)::numeric(12,2) as promedio,be.mesestrabajo,
((be.promediotg*pp.porcentaje)/100)::numeric(12,2) as promediotg,(((be.promediotg*".$infobono['porcentaje'].")*pp.porcentaje)/100)::numeric(12,2) as total,be.aportes
 from bonoespecialempleado be inner join general.empleado e on e.id=be.idempleado inner join general.persona p on p.id=e.idpersona 
inner join general.porcentajepago pp on pp.idempleado =e.id
 where be.eliminado=false and be.idbonoespecial=".$infobono['id']." and pp.id in(SELECT unnest(string_to_array(be.idporcentajepago, ','))::integer) and pp.idempresasubempleadora in($unidadesseleccionadas) order by p.nombrecompleto asc")->queryAll();

                    break;
            }
            case 2:{
                  $datoPlanilla = Yii::app()->rrhh
                ->createCommand("select pp.porcentaje,'SUCRE' AS reg,case when be.estado=1 then 'ACTIVO' else 'RETIRADO' end  as estado,(select fee from general.empresasubempleadora where id=pp.idempresasubempleadora)/100 as fee,(select impuesto from general.empresasubempleadora where id=pp.idempresasubempleadora)/100  as impuesto,'".$infobono['gestion']."'::varchar(15) as periodo,(select nombre from general.empresasubempleadora where id=pp.idempresasubempleadora) as empresa, case when be.estado=0 then 'RETIRADO'::varchar(30) else 'ACTIVO'::varchar(30) end as estado,p.ci,p.expedicion ,p.nombrecompleto
,(select pa.nacionalidad from general.localidad l inner join general.municipio m on m.id=l.idmunicipio inner join general.provincia pr on pr.id=m.idprovincia inner join ftbl_compra_departamento d on d.id=pr.iddepartamento inner join ftbl_compra_pais pa on pa.id=d.idpais where l.id=p.idlocalidad) AS nacionalidad,
to_char(p.fechanac,'dd/mm/YYYY') as fechanac,p.sexo,be.cargo, to_char( be.fechaplanilla,'dd/mm/YYYY') as fechaplanilla,to_char(be.fecharetiro,'dd/mm/YYYY') as fecharetiro,
((be.promedio*pp.porcentaje)/100)::numeric(12,2) as promedio,
((be.promediotg*pp.porcentaje)/100)::numeric(12,2) as promediotg,((be.promediotg*pp.porcentaje)/100)::numeric(12,2) as total,be.aportes
 from bonoespecialempleado be inner join general.empleado e on e.id=be.idempleado inner join general.persona p on p.id=e.idpersona 
inner join general.porcentajepago pp on pp.idempleado =e.id
 where be.eliminado=false and be.idbonoespecial=".$infobono['id']." and pp.id in(SELECT unnest(string_to_array(be.idporcentajepago, ','))::integer) and pp.idempresasubempleadora in($unidadesseleccionadas) order by p.nombrecompleto asc")->queryAll();

                    break;
            }
        default :{
             $datoPlanilla = Yii::app()->rrhh
                ->createCommand("select pp.porcentaje,'SUCRE' AS reg,case when be.estado=1 then 'ACTIVO' else 'RETIRADO' end  as estado,(select fee from general.empresasubempleadora where id=pp.idempresasubempleadora)/100 as fee,(select impuesto from general.empresasubempleadora where id=pp.idempresasubempleadora)/100  as impuesto,'".$infobono['gestion']."'::varchar(15) as periodo,(select nombre from general.empresasubempleadora where id=pp.idempresasubempleadora) as empresa, case when be.estado=0 then 'RETIRADO'::varchar(30) else 'ACTIVO'::varchar(30) end as estado,p.ci,p.expedicion ,p.nombrecompleto
,(select pa.nacionalidad from general.localidad l inner join general.municipio m on m.id=l.idmunicipio inner join general.provincia pr on pr.id=m.idprovincia inner join ftbl_compra_departamento d on d.id=pr.iddepartamento inner join ftbl_compra_pais pa on pa.id=d.idpais where l.id=p.idlocalidad) AS nacionalidad,
to_char(p.fechanac,'dd/mm/YYYY') as fechanac,p.sexo,be.cargo, to_char( be.fechaplanilla,'dd/mm/YYYY') as 
fechaplanilla,to_char(be.fecharetiro,'dd/mm/YYYY') as fecharetiro,
be.aportes,be.beneficios
 from bonoespecialempleado be inner join general.empleado e on e.id=be.idempleado inner join general.persona p on p.id=e.idpersona 
inner join general.porcentajepago pp on pp.idempleado =e.id
 where be.eliminado=false and be.idbonoespecial=".$infobono['id']." and pp.id in(SELECT unnest(string_to_array(be.idporcentajepago, ','))::integer) and pp.idempresasubempleadora in($unidadesseleccionadas) order by p.nombrecompleto asc")->queryAll();

                    break;
                break;
        }
        }
        return $datoPlanilla;
        
    }
}
