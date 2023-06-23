<?php
/*
 * PlanillaController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 30/04/2021
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
class PlanillaController extends Controller
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
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = new Planilla;
        $encargado = Yii::app()->rrhh
                        ->createCommand("SELECT encargadoplanilla, cargoencargado FROM  GENERAL.EMPRESA WHERE ELIMINADO=FALSE order by id desc limit 1 ")->queryAll();
       $model->encargadoplanilla=$encargado[0]['encargadoplanilla'];
       $model->cargoencargado=$encargado[0]['cargoencargado'];
        $cant = Yii::app()->rrhh
                        ->createCommand("select   count(*) as cant   from planilla  where  eliminado=false and porsistema=true  ")->queryScalar();
        if ($cant > 0) {
            ///hay cortes anteriores
            $estado = Yii::app()->rrhh
                            ->createCommand("select  estado   from planilla  where  eliminado=false order by id desc limit 1  ")->queryScalar();
            if ($estado >=3) {
                /// mostrarmos los nuevos cortes
                $fecha = Yii::app()->rrhh
                        ->createCommand("select to_char((fechahasta+1),'DD-MM-YYYY') AS fecha ,  to_char((fechafc+1),'DD-MM-YYYY') as fechafc from planilla  where  eliminado=false order by id desc limit 1 ")
                        ->queryAll();
                $model->fechaic = $fecha[0]['fechafc'];
                $model->fechadesde = $fecha[0]['fecha'];
                //////////fin mostramos nuevos corte
            } else {
                $model->scenario = 'proceso';
            }
            ///fin hay cortes anteriores
        } else {
            $model->scenario = 'mostrar';
            $model->fechaic = Yii::app()->rrhh
                    ->createCommand("select  to_char( dame_fechaminima(),'DD-MM-YYYY') as fecha")
                    ->queryScalar();
        }
        $fecha = Yii::app()->rrhh
                ->createCommand("select to_char((fechahasta+1),'DD-MM-YYYY') AS fecha   from planilla  where  eliminado=false limit 1 ")
                ->queryAll();
        $model->fechaic = Yii::app()->rrhh
                ->createCommand("select  to_char( dame_fechaminimacorte(),'DD-MM-YYYY') as fecha")
                ->queryScalar();
        $model->fechamin = date("d/m/Y", mktime(0, 0, 0, date("m") - 3, 1, date("Y")));
        $model->fechamax = date("d/m/Y", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
        $listafiniquitos=$this->listafiniquitossinconsolidar();


        if (isset($_POST['Planilla'])) {
            if ($model->scenario == 'proceso') {
                echo System::hasErrors('NO SE PUEDE CREAR MIENTRAS NO SE CONSOLIDE LA PLANILLA...', $model);
                return;
            } else {

                if ($model->fechadesde == '') {
                    $model->fechadesde = $_POST['Planilla']['fechadesde'];
                }
                if ($model->fechaic == '') {
                    $model->fechaic = $_POST['Planilla']['fechaic'];
                }

                $usuario = Yii::app()->user->getName();
            $resp=  Yii::app()->rrhh
            ->createCommand("select crear_corte('".strtoupper( $_POST['Planilla']['encargadoplanilla'])."'::varchar(200),'".strtoupper( $_POST['Planilla']['cargoencargado'])."'::varchar(100), '".$model->fechadesde."'::date,'".$_POST['Planilla']['fechahasta']."'::date,'".$model->fechaic."'::date,'".$_POST['Planilla']['fechafc']."'::date,true,'".strtoupper( $_POST['Planilla']['nombre'])."'::varchar(100),'$usuario'::varchar(40)) as sms")
            ->queryAll();
             echo System::hasErrors($resp[0]['sms'], $model);

                return;
            }
        }
        $this->renderPartial('create', array(
            'model' => $model,
            'listafiniquitos'=>$listafiniquitos,
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
        $date = date_create($model->fechadesde);
        $model->fechadesde= date_format($date, 'd-m-Y');
        $date = date_create($model->fechahasta);
        $model->fechahasta= date_format($date, 'd-m-Y');
        $date = date_create($model->fechafc);
        $model->fechafc= date_format($date, 'd-m-Y');
        $date = date_create($model->fechaic);        
        $model->fechaic= date_format($date, 'd-m-Y');
          

        if(isset($_POST['Planilla']))
        {
             $usuario= Yii::app()->user->getName();
                   $resp=  Yii::app()->rrhh
            ->createCommand("select crear_corte('".$model->fechadesde."'::date,'".$_POST['Planilla']['fechahasta']."'::date,'".$model->fechaic."'::date,'".$_POST['Planilla']['fechafc']."'::date ,false,'".strtoupper( $_POST['Planilla']['nombre'])."','$usuario') as sms")
            ->queryAll();   
        }

        $this->renderPartial('update',array(
            'model'=>$model,
        ), false, true);
    }
     /**
      * 
      * @param integer $id, elimina el corte con el $id y volviendo los datos a un estado antes del corte 
      */
      public function actionDelete($id) {
        $usuario = Yii::app()->user->getName();
        Yii::app()->rrhh
                ->createCommand("select regenerarcorte('$usuario')")
                ->query();
        self::actionAdmin();
    }
    /**
     * 
     * @param integer $id, id de la planilla que se quiere dar de baja
     * @return formulario para dar de baja la planilla 
     */
    public function actionPlanilla($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = new Planilla;
        $model->nombre = 'Desea dar de Baja Planilla?';
        if (isset($_POST['Planilla'])) {

            $cadena = Yii::app()->rrhh
                    ->createCommand("select  string_agg(t.nombre,',' order by t.nombre asc) from  (select distinct tpb.nombre from general.pagobeneficio pb inner join general.tipopagobeneficio tpb on tpb.id=pb.idtipopagobeneficio where pb.eliminado=false and pb.listaplanilla like '%'||( select id from planilla where eliminado=false  order by id desc limit 1 )||'%') as t")
                    ->queryScalar();

            if ($cadena == false || $cadena == null) {
                $usuario = Yii::app()->user->getName();
                Yii::app()->contabilidad
                        ->createCommand("select regenerarplanilla('$usuario')")
                        ->query();
                   

                     
                echo System::dataReturn('Planilla dada de Baja');
                return;
            } else
                echo System::hasErrors('Revise los datos! la Planilla  se encuentra asociada en un ' . $cadena, $model);
            return;
        }
        $this->renderPartial('mensaje', array(
            'model' => $model,
            'listafiniquitos'=>'',
                ), false, true);
    }
    /**
     * 
     * @param integer $id, id de la planilla que se quiere consolidar
     * @return formualrio para la consolidacion
     */
    public function actionConsolidar($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = new Planilla;
        $id=SeguridadModule::dec($id);
        $model->nombre = 'Desea Consolidar Planilla?';
        $listafiniquitos=$this->listafiniquitossinconsolidar();
        if (isset($_POST['Planilla'])) {        
            
            $usuario = Yii::app()->user->getName();           
            $respuesta=Yii::app()->contabilidad
                    ->createCommand("select registrar_asiento($id,'$usuario')")
                    ->queryScalar();
            if($respuesta==''){
             Yii::app()->rrhh
                    ->createCommand("select public.actualizar_boltetas()")
                    ->execute();
             echo System::dataReturn('Planilla Consolidada');
            return;
            }else{
                 echo System::hasErrors( $respuesta, $model);
            return;  
            }   
           

                   
            
        }
        $this->renderPartial('mensaje', array(
            'model' => $model,
            'listafiniquitos'=>$listafiniquitos,
            
                ), false, true);
    }
    /**
     * 
     * @param integer $id, id de la planilla de indemnizacion a consolidar
     * @return formulario para la cosolidacion de la indemnizacion
     */
    public function actionConsolidarIndemnizacion($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = new Planilla;
         $id = SeguridadModule::dec($id);

        $model->nombre = 'Desea Consolidar Planilla de Indemnizacion?';
        $listafiniquitos=$this->listafiniquitossinconsolidar();
        $listaretirados=Yii::app()->rrhh
                ->createCommand(" select  e.id,p.nombrecompleto,false as estado  from general.persona p inner join general.empleado e on e.idpersona=p.id inner join general.historialestadoempleado hee on hee.idempleado=e.id inner join general.pagobeneficio pb on pb.idhistorialestadoempleado=hee.id  where hee.eliminado=false and pb.idtipopagobeneficio=2  and hee.activo=0 and hee.fecharetiro between (select fechadesde from planilla where id=$id) and (select fechahasta from planilla where id=$id)")
                ->queryAll();
        if (isset($_POST['Planilla'])) {
            Planilla::model()->ConsolidarIndemnizacion($id,$_POST['gridEmpleados']);
            echo System::dataReturn('Planilla Indemnizacion Consolidada');
            return;
        }
        $this->renderPartial('retirados', array(
            'model' => $model,
            'listafiniquitos'=>$listafiniquitos,
            'listaretirados'=>$listaretirados
            
                ), false, true);
    }

    /**
     * 
     * @param integer $id, id del corte de planilla para la generacion de la planilla
     * @return formulario
     */
    public function actionGplanilla($id) {

        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = new Planilla;
        $model->nombre = 'Desea Generar Planilla?';
        $listafiniquitos=$this->listafiniquitossinconsolidar();
        if (isset($_POST['Planilla'])) {
            $usuario = Yii::app()->user->getName();
            $datoPlanilla = Yii::app()->rrhh
                    ->createCommand(" select * from faportacionesbeneficiospl('$usuario',1,'1',1,'true'::boolean)")
                    ->queryAll();
            $cantdatos = count($datoPlanilla);
            if ($cantdatos > 1 || ($datoPlanilla[0]['observacion'] == '' && ($cantdatos = 1))) {
                echo "<h6>Creación  exitosa!</h6>";
                echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo $datoPlanilla[0]['observacion'];
                echo System::hasErrors($datoPlanilla[0]['observacion'], $model);
                return;
            }
        }
        $this->renderPartial('mensaje', array(
            'model' => $model,
            'listafiniquitos'=>$listafiniquitos,
                ), false, true);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model=new Planilla('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Planilla'])){
                $model->attributes=$_GET['Planilla'];
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
     * @param integer $id, id de la planilla 
     * retorna, reporte de bolestas de todos los empleados
     */
    public function actionImprimirBoletas($id) {
       $p_idplanilla = SeguridadModule::dec($id);
     
        $re = new JasperReport('/reports/RRHH/ReporteBoletasEmpleado', JasperReport::FORMAT_PDF, array(
            'p_idplanilla' => $p_idplanilla,
            'pUsuario' => Yii::app()->user->getName(),
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
     * @param type $id, id de la planilla 
     * retorna formulario para la generacion de los diferentes tipos de reportes
     */
    public function actionGenerarPlanilla($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = $this->loadModel(SeguridadModule::dec($_GET['id']));

        $model->separarNombre = true;
        $lareas = Area::model()->findAll();
        $lunidad = Unidad::model()->findAll();
        $ltipocontratos = Tipocontrato::model()->findAll();
        $laportacion = Yii::app()->rrhh
                ->createCommand("select * from cabecera where eliminado=false and idplanilla =".$model->id." and tipo =2 order by nombre asc")
                ->queryAll();
        $lbeneficio = Yii::app()->rrhh
                ->createCommand("select * from cabecera where eliminado=false and idplanilla =".$model->id." and tipo =1 and nombref<>'totalga' order by nombre asc")->queryAll();
        if (isset($_POST['Planilla'])) {
            
        }

        $this->renderPartial('generarplanilla', array(
            'laportacion' => $laportacion,
            'lbeneficio' => $lbeneficio,
            'lareas' => $lareas,
            'lunidad'=>$lunidad,           
            'ltipocontratos' => $ltipocontratos,
            'model' => $model
                ), false, true);
    }
  
    /**
     * @param integer $_GET['Planilla']['id'], id de la planilla 
     * @param intger  $_GET['Planilla']['opcionafp'] , id de las afp ,posibles valores 1= AFP Prevision y 2=AFP Futuro
     * @param integer  $_GET['Planilla']['tipoindemnizacion'], id de la indemnizacion cuyos valores posibles 20= Indemnizacion y 34 =Indemnizacion Litigio
     * @param integer[] $_GET['Planilla']['opciones'],posibles valores 1-7, 
     * 1= Opcion en Blanco(el usuario podra seleccionar las poartciones y beneficios deseado)
     * 2=Planilla General (podra seleccionar entre las areas vigentes
     * 3=Planilla a Caja
     * 4=Planilla a las afps segun  $_GET['Planilla']['opcionafp'] seleccionada
     * 5=Planilla de Descuento
     * 6=Planilla de indemnizacion segun  $_GET['Planilla']['tipoindemnizacion'] seleccionada
     * 7= Planilla de Otros Bonos 
     * @return reporte en formato xls, se
     */
    public function actionDescargarExcelPlanilla() {
        $idplanilla = $_GET['Planilla']['id'];
       
        switch ($_GET['Planilla']['opciones']) {
            case '3':
                return $this->DescargarPlanillaCNS($idplanilla,$_GET['tipocontratos']);
                break;
            case '4':
                return $this->DescargarPlanillaAFP($idplanilla, $_GET['Planilla']['opcionafp']);
                break;
            case '6':
                return $this->DescargarIndemnizacionAguinaldos($idplanilla, $_GET['Planilla']['tipoindemnizacion']);
                break;
            case '7':
                return $this->DescargarOtrosBonos($idplanilla);
                break; 
            case '8':
                return $this->DescargarPlanillaRCIVA($idplanilla);
                break;
            case '9':
                return $this->DescargarPlanillaRCIVACsv($idplanilla);
                break; 

            default:
                return $this->planillaExcel($idplanilla, $_GET['area'], $_GET['tipocontratos'], json_decode($_GET['gridBeneficios']), json_decode($_GET['gridAportaciones']), $_GET['Planilla']['descripcion'], $_GET['Planilla']['separarNombre'], $_GET['Planilla']['ordenarNombre'], $_GET['Planilla']['mostrarAportacionDesglosada'], $_GET['Planilla']['mostrarBeneficioDesglosada'], $_GET['Planilla']['opciones'], $_GET['Planilla']['opcionDescuento']);
                break;
        }
    }
   /**
    * 
    * @param integer $id, id de la planilla que queremos imprimir
    * @param integer[] $areas, id de las areas seleccionadas 
    * @param integer[] $tipocontratos, id de los contratos seleccionados
    * @param integer[] $listaBeneficio, id de los beneficios seleccionados
    * @param integer[] $listaAportacion, id de las aportaciones seleccionadas
    * @param string $nombrep, nombre de la planilla
    * @param boolean $separarPorNombre , true = mostrar nombre completo separado en columanas  ,false= mostra nombre completo en una columna
    * @param boolean $ordenarPorNombre, true=si se va ordenar por nombre ,false = si se va ordenar por apellido
    * @param boolean $mostrarAportacionDesglosada, true=si la aportaciones se van a mostrar desglosada false= si la aportacion no se va a mostrar desglosada
    * @param boolean $mostrarBeneficioDesglosada,true=si el beneficio se van a mostrar desglosada false= si el beneficio no se va a mostrar desglosada
    * @param integer $opcion ,1=opcion en blanco,2=Planilla General
    * @param type $opciondescuento
    * @return int
    */
   public function planillaExcel($id, $areas, $tipocontratos, $listaBeneficio, $listaAportacion, $nombrep, $separarPorNombre, $ordenarPorNombre, $mostrarAportacionDesglosada, $mostrarBeneficioDesglosada, $opcion, $opciondescuento) {
        $bandera = 1;
        $columnaextra = false;
        $nombrecolumnaextra = '';
        $cadenab = '';
        $cadenaa = '';
        $cantcolAportacion = 1;
        $cantcolBeneficio = 1;
        $cantb = count($listaBeneficio);
        $canta = count($listaAportacion);
        $areaselecionadas = '';
        $p_cantidada = count($areas);
        $p_orden = 14; // 
        $aumentar = 0;
        $tipocontratosseleccionados = '';
      
        switch ($opcion) {
            case '1': {
                    ///------INICIO OPCION EN BLANCO
                    for ($i = 0; $i < count($areas); $i++) {
                        $areaselecionadas = $areaselecionadas . $areas[$i] . ',';
                    }
                    $areaselecionadas = substr($areaselecionadas, 0, -1);       

                    $tipocontratosseleccionados = Yii::app()->rrhh
                            ->createCommand("select string_agg(id::text, ',' order by id asc) from general.tipocontrato where  eliminado=false and generarcc=true ")
                            ->queryScalar();

                    foreach ($listaBeneficio as $b) {
                        if ($b->estado == '1') {
                            $cadenab = $cadenab . "'" . $b->nombre . "',";
                            ++$cantcolBeneficio;
                            if ($b->nombre == 'HORAS EXTRAS')
                                $aumentar = 1;
                        }
                    }
                    $cantcolBeneficio += $aumentar;
                    $cadenab .= $cadenab . "'TOTAL GANADO'";
                    foreach ($listaAportacion as $a) {
                        if ($a->estado == '1') {
                            $cadenaa = $cadenaa . "'" . $a->nombre . "',";
                            ++$cantcolAportacion;
                        }
                    }
                    $cadenaa = $cadenaa . "'TOTAL DESCUENTOS'";
                   
                   
                    ///------FIN OPCION EN BLANCO
                }

                break;

            case '2': {
                    ///--------INICIO PLANILLA GENERAL(TODAS LAS AREAS-BENEFICIOS-APORTACIONES)
                    // 
                    for ($i = 0; $i < count($tipocontratos); $i++) {
                        $tipocontratosseleccionados = $tipocontratosseleccionados . $tipocontratos[$i] . ',';
                    }
                    $tipocontratosseleccionados = substr($tipocontratosseleccionados, 0, -1);

                    $listaareas = Yii::app()->rrhh
                                    ->createCommand("select string_agg(id::text, ',' order by id asc) as areas,count(*) as cant from general.area where eliminado=false ")
                                    ->queryAll()[0];
                    $areaselecionadas = $listaareas['areas'];
                    $p_cantidada = $listaareas['cant'];
                    $listaa = Yii::app()->rrhh
                                    ->createCommand("select string_agg(chr(39)||nombre||chr(39), ',' )  as aportaciones,count(*) as cant from cabecera where eliminado=false and idplanilla=$id and tipo =2")
                                    ->queryAll()[0];
                    $cadenaa = $listaa['aportaciones'];
                    $cantcolAportacion = $listaa['cant'];
                    $listabe = Yii::app()->rrhh->createCommand("select string_agg(chr(39)||nombre||chr(39), ',' )  as beneficios,count(*) as cant from cabecera where eliminado=false and idplanilla=$id and tipo =1")->queryAll()[0];
                    $cadenab = $listabe['beneficios'];
                    $cantcolBeneficio = $listabe['cant'] + 1;
                    $mostrarAportacionDesglosada = false;
                    $mostrarBeneficioDesglosada = false;
                    ///--------FIN PLANILLA GENERAL(TODAS LAS AREAS-BENEFICIOS-APORTACIONES)
                }

                break;
          

            default: {
                    ///----INICIO PLANILLA DESCUENTOS
                    $p_orden = 6;
                    $ordenarNombre = false;
                    $separarPorNombre=false;

                    for ($i = 0; $i < count($tipocontratos); $i++) {
                        $tipocontratosseleccionados = $tipocontratosseleccionados . $tipocontratos[$i] . ',';
                        
                    }
                    $tipocontratosseleccionados = substr($tipocontratosseleccionados, 0, -1);
                    $tipocontratosseleccionados= Yii::app()->rrhh
                                    ->createCommand("select STRING_AGG (id::text, ','   ) from general.tipocontrato where eliminado=false and  (id in(
select distinct idtipocontrato from general.aporbetipocont where eliminado=false and idaportacionbeneficio  in(select id from general.aportacionbeneficio where eliminado=false and tipo=3)) and id in($tipocontratosseleccionados)) ")
                                    ->queryScalar();

                    $listaareas = Yii::app()->rrhh
                                    ->createCommand("select string_agg(id::text, ',' order by id asc) as areas,count(*) as cant from general.area where eliminado=false ")
                                    ->queryAll()[0];
                    $areaselecionadas = $listaareas['areas'];
                    $p_cantidada = $listaareas['cant'];
                    $listabe = array();
                    $cadenab = "''";
                    $cantcolBeneficio = 0;
                    $mostrarAportacionDesglosada = true;
                    $mostrarBeneficioDesglosada = false;
                    if ($opciondescuento == 1) {

                        $listaa = Yii::app()->rrhh
                                        ->createCommand("select string_agg(chr(39)||nombre||chr(39), ',' )  as aportaciones,count(*)-1 as cant from cabecera where eliminado=false and idplanilla=$id and tipo in(2,5)")
                                        ->queryAll()[0];
                        $cadenaa = $listaa['aportaciones'];
                    } else {

                        $listaa = Yii::app()->rrhh
                                        ->createCommand("select string_agg(chr(39)||nombre||chr(39), ',' )  as aportaciones,count(*)-1 as cant from cabecera where  eliminado=false and  idplanilla=$id and tipo in(2,5) and nombre<>'AFP APORTE TRABAJADOR'")
                                        ->queryAll()[0];
                        $cadenaa = $listaa['aportaciones'];
                    }
                    $cantcolAportacion = $listaa['cant'];
                    ///----FIN PLANILLA DESCUENTOS
                }
                break;
        }
        $usuario = Yii::app()->user->getName();
        $fecha = Yii::app()->rrhh
                ->createCommand("select anio ,(select public.dame_nombremes(mes)) as nombremes, mes,( to_char(fechadesde, 'DD-MM-YYYY')||'_' || to_char(fechahasta, 'DD-MM-YYYY')) as fecha  from planilla where id=" . $id . " ")
                ->queryAll();
        $mes = $fecha[0]['mes'];
        $anio = $fecha[0]['anio'];
        $nombre = $fecha[0]['fecha'];
        $datoEmpresa = Yii::app()->rrhh
                ->createCommand("select e.razonsocial,e.nit,e.nrempleadormt,nrempleador,pl.nombrer,pl.cir from planilla pl inner join general.representante r on r.cirepresentante=pl.cir inner join general.empresa e on e.id=r.idempresa  where pl.id=" . $id)
                ->queryAll();
        $cantAux = Yii::app()->rrhh
                ->createCommand("select count(*) as cant from cuerpo where idplanilla=$id and tipo=1 ")
                ->queryScalar();
        if ($ordenarPorNombre == true) {
            ////--inicio--ordernar por nombre (planilla mes anterior)---////
            $datoPlanilla = Yii::app()->rrhh
                    ->createCommand(" select c.general as ge,c.beneficio as be,c.aporte as ap from cuerpo c ,json_array_elements(c.general) elemento where c.eliminado=false and c.idplanilla=$id and c.tipo=1 and c.area in($areaselecionadas)  and c.idtipocontrato in($tipocontratosseleccionados)   order by elemento->>'nombre',elemento->>'apellidop',elemento->>'apellidom'  asc ")
                    ->queryAll();
            if ($separarPorNombre == true) {
                //---incio--separado por nombre (pma)--true----///
                if ($mostrarAportacionDesglosada == true) {
                    $cabeceraPlanilla = Yii::app()->rrhh
                            ->createCommand("( select c1.ordenalternativo as orden, c1.nombre,c1.nombref ,c1.tipo from  cabecera c1  where c1.eliminado=false and (orden<$p_orden or orden=9) and  c1.tipo=0 and nombre not in('APELLIDOS Y NOMBRES','NOMBRES Y APELLIDOS')  )
                  union (select c.orden, c.nombre,c.nombref ,c.tipo from planilla pl inner join cabecera c on c.idplanilla=pl.id  where c.eliminado=false and c.nombre in(" . $cadenab . ") and c.tipo IN(1,4) and   pl.id=$id)
                  union (select c.orden, c.nombre,c.nombref ,c.tipo from planilla pl inner join cabecera c on c.idplanilla=pl.id  where c.eliminado=false and c.nombre in(" . $cadenaa . ") and c.nombre not in(select json_array_elements(elemento->'detalleagrupados')->>'grupo' as g from cuerpo cu ,json_array_elements(cu.aporte) elemento where idplanilla=$id and tipo=1 order by id asc limit 1
                  )  and c.tipo =2 and   pl.id=$id) 
                  union (select c.orden, c.nombre,c.nombref ,c.tipo from planilla pl inner join cabecera c on c.idplanilla=pl.id  where c.eliminado=false and c.nombre in(" . $cadenaa . ") and c.tipo =5 and   pl.id=$id) 
                  order by orden asc  ")
                            ->queryAll();

                    # code...
                } else {
                    $cabeceraPlanilla = Yii::app()->rrhh
                            ->createCommand("( select c1.ordenalternativo as orden, c1.nombre,c1.nombref ,c1.tipo from  cabecera c1  where c1.eliminado=false and (orden<$p_orden or orden=9) and  c1.tipo=0 and nombre not in('APELLIDOS Y NOMBRES','NOMBRES Y APELLIDOS')  )
                    union (select c.orden, c.nombre,c.nombref ,c.tipo from planilla pl inner join cabecera c on c.idplanilla=pl.id  where c.eliminado=false and c.nombre in(" . $cadenab . ") and c.tipo IN(1,4) and   pl.id=$id)
                    union (select c.orden, c.nombre,c.nombref ,c.tipo from planilla pl inner join cabecera c on c.idplanilla=pl.id  where c.eliminado=false and c.nombre in(" . $cadenaa . ") and c.tipo =2  and   pl.id=$id) order by orden asc  ")
                            ->queryAll();
                }

                $cantcolGeneral = Yii::app()->rrhh
                        ->createCommand("select count(*) as cant from  cabecera c1  where  c1.eliminado=false and (orden<$p_orden or orden=9) and c1.tipo=0 and nombre not in('APELLIDOS Y NOMBRES','NOMBRES Y APELLIDOS') ")
                        ->queryScalar();
                //---fin--separado por nombre (pma)----true--///
            } else {
                //---incio--separado por apellido (pma)--true----///
                if ($mostrarAportacionDesglosada == true) {
                    $cabeceraPlanilla = Yii::app()->rrhh
                            ->createCommand("( select c1.ordenalternativo as orden, c1.nombre,c1.nombref ,c1.tipo from  cabecera c1  where c1.eliminado=false and (orden<$p_orden or orden=9) and  c1.tipo=0 and nombre not in('APELLIDOS Y NOMBRES','APELLIDO PATERNO','APELLIDO MATERNO','NOMBRES')  )
                  union (select c.orden, c.nombre,c.nombref ,c.tipo from planilla pl inner join cabecera c on c.idplanilla=pl.id  where c.eliminado=false and c.nombre in(" . $cadenab . ") and c.tipo IN(1,4) and   pl.id=$id)
                  union (select c.orden, c.nombre,c.nombref ,c.tipo from planilla pl inner join cabecera c on c.idplanilla=pl.id  where c.eliminado=false and c.nombre in(" . $cadenaa . ") and c.nombre not in(select json_array_elements(elemento->'detalleagrupados')->>'grupo' as g from cuerpo cu ,json_array_elements(cu.aporte) elemento where idplanilla=$id and tipo=1 order by id asc limit 1
                  ) and c.tipo =2 and   pl.id=$id)
                  union (select c.orden, c.nombre,c.nombref ,c.tipo from planilla pl inner join cabecera c on c.idplanilla=pl.id  where c.eliminado=false and c.nombre in(" . $cadenaa . ") and c.tipo =5 and   pl.id=$id)
                  order by orden asc  ")
                            ->queryAll();
                } else {
                    $cabeceraPlanilla = Yii::app()->rrhh
                            ->createCommand("( select c1.ordenalternativo as orden, c1.nombre,c1.nombref ,c1.tipo from  cabecera c1  where c1.eliminado=false and (orden<$p_orden or orden=9) and  c1.tipo=0 and nombre not in('APELLIDOS Y NOMBRES','APELLIDO PATERNO','APELLIDO MATERNO','NOMBRES')  )
                  union (select c.orden, c.nombre,c.nombref ,c.tipo from planilla pl inner join cabecera c on c.idplanilla=pl.id  where c.eliminado=false and c.nombre in(" . $cadenab . ") and c.tipo IN(1,4) and   pl.id=$id)
                  union (select c.orden, c.nombre,c.nombref ,c.tipo from planilla pl inner join cabecera c on c.idplanilla=pl.id  where c.eliminado=false and c.nombre in(" . $cadenaa . ") and c.tipo =2  and   pl.id=$id) order by orden asc  ")
                            ->queryAll();
                }

                $cantcolGeneral = Yii::app()->rrhh
                        ->createCommand("select count(*) as cant from  cabecera c1  where c1.eliminado=false and (orden<$p_orden or orden=9) and  c1.tipo=0 and nombre not in('APELLIDOS Y NOMBRES','APELLIDO PATERNO','APELLIDO MATERNO','NOMBRES') ")
                        ->queryScalar();

                //---fin--separado por apellido (pma)----true--///
            }

            ////--fin--ordernar por nombre (planilla mes anterior)---////
        } else {
            /////-++++++++++++++++--inicio--ordenar por apellido-(planilla mes anterior)---/////
            $datoPlanilla = Yii::app()->rrhh
                    ->createCommand("select general as ge,beneficio as be,aporte as ap from cuerpo where eliminado=false and idplanilla =$id and tipo=1  and area in($areaselecionadas) and idtipocontrato in($tipocontratosseleccionados) order by id asc")
                    ->queryAll();
            if ($separarPorNombre == true) {
                //---incio--separado por nombre (pma)-- ordenar por apellido----///
                if ($mostrarAportacionDesglosada == true) {
                    $cabeceraPlanilla = Yii::app()->rrhh
                            ->createCommand("( select c1.orden, c1.nombre,c1.nombref ,c1.tipo from  cabecera c1  where c1.eliminado=false and (orden<$p_orden or orden=9) and c1.eliminado=false and  c1.tipo=0 and nombre not in('APELLIDOS Y NOMBRES','NOMBRES Y APELLIDOS')  )
                union (select c.orden, c.nombre,c.nombref ,c.tipo from planilla pl inner join cabecera c on c.idplanilla=pl.id where c.nombre in(" . $cadenaa . ")and c.tipo in(2,5) and c.idplanilla=$id and c.eliminado=false )
                union (select c.orden, c.nombre,c.nombref ,c.tipo from planilla pl inner join cabecera c on c.idplanilla=pl.id where c.nombre in(" . $cadenab . ")and  c.tipo in(1,4)and c.idplanilla=$id  and c.eliminado=false )
                order by orden asc  ")
                            ->queryAll();
                } else {
                    $cabeceraPlanilla = Yii::app()->rrhh
                            ->createCommand("( select c1.orden,c1.nombre,c1.nombref ,c1.tipo from  cabecera c1  where c1.eliminado=false and (orden<$p_orden or orden=9)  and  c1.tipo=0 and nombre not in('APELLIDOS Y NOMBRES','NOMBRES Y APELLIDOS')  )
                union (select c.orden, c.nombre,c.nombref ,c.tipo from planilla pl inner join cabecera c on c.idplanilla=$id where c.nombre in(" . $cadenaa . ")and c.eliminado=false )
                union (select c.orden, c.nombre,c.nombref ,c.tipo from planilla pl inner join cabecera c on c.idplanilla=$id  where c.nombre in(" . $cadenab . ")and c.eliminado=false )
                 order by orden asc  ")
                            ->queryAll();
                }
                $cantcolGeneral = Yii::app()->rrhh
                        ->createCommand("select count(*) as cant from  cabecera c1  where c1.eliminado=false and (orden<$p_orden or orden=9) and  c1.tipo=0 and nombre not in('APELLIDOS Y NOMBRES','NOMBRES Y APELLIDOS') ")
                        ->queryScalar();
                //---fin--separado por nombre (pma)---- ordenar por apellido--///
            } else {
                //---incio--UNIDO por apellido (pma)-- ordenar por apellido----///    
                if ($mostrarAportacionDesglosada == true) {
                    $cabeceraPlanilla = Yii::app()->rrhh
                            ->createCommand("( select c1.orden, c1.nombre,c1.nombref ,c1.tipo,c1.grupo from  cabecera c1  where c1.eliminado=false and (orden<$p_orden or orden=9) and  c1.tipo=0 and nombre not in('APELLIDO PATERNO','APELLIDO MATERNO','NOMBRES','NOMBRES Y APELLIDOS')  )
                union (select c.orden, c.nombre,c.nombref ,c.tipo,c.grupo from planilla pl inner join cabecera c on c.idplanilla=pl.id  where c.nombre in(" . $cadenab . ") and c.tipo IN(1,4) and c.eliminado=false and   pl.id=$id)
                union (select c.orden, c.nombre,c.nombref ,c.tipo,c.grupo from planilla pl inner join cabecera c on c.idplanilla=pl.id  where c.nombre in(" . $cadenaa . ") and c.eliminado=false  and c.nombref not in(select grupo from cabecera where idplanilla=$id)  and c.tipo in(2,5) and   pl.id=$id)
                order by orden asc  ")
                            ->queryAll();
                } else {
                    $cabeceraPlanilla = Yii::app()->rrhh
                            ->createCommand("( select c1.orden, c1.nombre,c1.nombref ,c1.tipo from  cabecera c1  where (orden<$p_orden or orden=9) and c1.eliminado=false and  c1.tipo=0 and nombre not in('APELLIDO PATERNO','APELLIDO MATERNO','NOMBRES','NOMBRES Y APELLIDOS')  )
                union (select c.orden, c.nombre,c.nombref ,c.tipo from planilla pl inner join cabecera c on c.idplanilla=pl.id  where c.nombre in(" . $cadenab . ") and c.tipo IN(1,4)and c.eliminado=false and   pl.id=$id)
                union (select c.orden, c.nombre,c.nombref ,c.tipo from planilla pl inner join cabecera c on c.idplanilla=pl.id  where c.nombre in(" . $cadenaa . ") and c.tipo =2 and c.eliminado=false and  pl.id=$id) order by orden asc  ")
                            ->queryAll();
                }
                $cantcolGeneral = Yii::app()->rrhh
                        ->createCommand("select count(*) as cant from  cabecera c1  where (orden<$p_orden or orden=9) and c1.eliminado=false  and  c1.tipo=0 and nombre not in('APELLIDO PATERNO','APELLIDO MATERNO','NOMBRES','NOMBRES Y APELLIDOS') ")
                        ->queryScalar();

                //---fin--UNIDO por apellido (pma)---- ordenar por apellido--///
            }
            /////--fin---ordenar por apellido-(planilla mes anterior)---/////                
        }
        $cantdatos = count($datoPlanilla);


        if ($cantdatos == $cantAux && $ordenarPorNombre == false && $opcion != '5') {
            $datoPlanillaD = Yii::app()->rrhh
                    ->createCommand(" select general as ge,beneficio as be,aporte as ap from cuerpo where eliminado=false and idplanilla=$id and tipo=2")
                    ->queryAll();
            $cabeceraPlanillaD = Yii::app()->rrhh
                    ->createCommand("select c1.id, c1.nombre,c1.nombref ,c1.tipo from  cabecera c1  where  c1.eliminado=false and c1.tipo=3 order by id asc ")
                    ->queryAll();
        } else {
            $datoPlanillaD = array();
            $cabeceraPlanillaD = array();
        }

        if ($bandera == 1) {
            # code...

            $nombreArchivo = 'Planilla_' . $nombre;


            $cantcol = $cantcolGeneral + $cantcolBeneficio + $cantcolAportacion;
          
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()
                    ->getPageSetup()
                    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $objPHPExcel->getActiveSheet()
                    ->getPageSetup()
                    ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);

            $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
            $activeSheet->setTitle($nombreArchivo);

            $activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 9);
            $htmlHelper = new \PHPExcel_Helper_HTML();

            if ($opcion == 5) {
                $phpFont = array('font' => array(
                        'size' => 7.5,
                        'name' => 'Times New Roman',
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    ),
                );
                $activeSheet->getDefaultColumnDimension()->setWidth(13);
                $activeSheet->getColumnDimension('A')->setWidth(5);

                if ($separarPorNombre == FALSE) {
                    $activeSheet->getColumnDimension('B')->setWidth(14);
                    $activeSheet->getColumnDimension('D')->setWidth(38);
                    $activeSheet->getColumnDimension('C')->setWidth(45);
                    $ltra = 'D';
                    $ltra2 = 'E';
                } else {
                    $ltra = 'F';
                    $ltra2 = 'G';
                    $activeSheet->getColumnDimension('B')->setWidth(12);
                    $activeSheet->getColumnDimension('C')->setWidth(16);
                    $activeSheet->getColumnDimension('D')->setWidth(20);
                    $activeSheet->getColumnDimension('E')->setWidth(25);
                    $activeSheet->getColumnDimension('F')->setWidth(35);
                }
            } else {

                $activeSheet->getDefaultColumnDimension()->setWidth(14);
                $phpFont = array('font' => array(
                        'size' => 10,
                        'name' => 'Times New Roman',
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                );
                if ($separarPorNombre == FALSE) {
                    $activeSheet->getColumnDimension('G')->setWidth(35);
                    $activeSheet->getColumnDimension('C')->setWidth(45);
                    $ltra = 'J';
                    $ltra2 = 'K';
                } else {
                    $ltra = 'L';
                    $ltra2 = 'M';
                    $activeSheet->getColumnDimension('C')->setWidth(27);
                    $activeSheet->getColumnDimension('D')->setWidth(27);
                    $activeSheet->getColumnDimension('E')->setWidth(27);
                    $activeSheet->getColumnDimension('I')->setWidth(35);
                }
            }

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

            $phpFont2 = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    ),
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_NONE
                ),
                'font' => array(
                    'bold' => true,
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
                'font' => array(
                    'bold' => true,
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            ));
            $phpFontC = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    ),
                ),
                 'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'font' => array(
                    'bold' => true,
                ),
            );
             $phpFontCuerpo= array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    ),
                ),
               
            );
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
            $activeSheet->getPageMargins()->setTop(0.4);
            $activeSheet->getPageMargins()->setRight(0.2);
            $activeSheet->getPageMargins()->setLeft(0.2);
            $activeSheet->getPageMargins()->setBottom(0.4);
            $phpColor = new PHPExcel_Style_Color();
            $phpColor->setRGB('FF0000');
            $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);
            
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
            
            $kFila = 10;
            $activeSheet->getRowDimension(8)->setRowHeight(45);

            $activeSheet->getRowDimension(1)->setRowHeight(1);
            $activeSheet->getRowDimension(2)->setRowHeight(1);
            $activeSheet->getRowDimension(3)->setRowHeight(1);
            $totalcolumnas=$cantcolGeneral+$cantcolBeneficio+$cantcolAportacion;
            $columnascabecera=$this->dameColumna('A', $totalcolumnas);
            
            $columnasGeneral = $this->dameColumna('A', $cantcolGeneral);
            $columnasBeneficio = $this->dameColumna($columnasGeneral[$cantcolGeneral], $cantcolBeneficio);
            $columnasAportaciones = $this->dameColumna($columnasBeneficio[$cantcolBeneficio], $cantcolAportacion);
            $lpf = $this->dameColumna($columnasAportaciones[$cantcolAportacion], 1);
            
            $activeSheet->mergeCells('A4:'.$lpf[1].'4');
            $activeSheet->mergeCells('A5:'.$lpf[1].'5');
            $activeSheet->getStyle("A4:".$lpf[1]."5")->applyFromArray(array(
                'font' => array(
                    'size' => 16,
                    'name' => 'Times New Roman',
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),));
            $activeSheet->getStyle("A4")->getFont()->setBold(true);
            $activeSheet->setCellValue('A4', strtoupper($nombrep));
            $activeSheet->setCellValue('A5', '(En Bolivianos)');
            // COLUMNAS STATICAS
            

            if ($cantcolBeneficio > 0) {
                $activeSheet->getColumnDimension($lpf[1])->setWidth(25);
                $activeSheet->getStyle("A8:" . $lpf[1] . '8')->applyFromArray(
                        $phpFontC
                );
                $activeSheet->getStyle("A9:" . $lpf[1] . '9')->applyFromArray(
                        $phpFontC
                );
            } else {
                $activeSheet->getColumnDimension($lpf[0])->setWidth(25);
                $activeSheet->getStyle("A8:" . $lpf[0] . '8')->applyFromArray(
                        $phpFontC
                );
                $activeSheet->getStyle("A9:" . $lpf[0] . '9')->applyFromArray(
                        $phpFontC
                );
                $lpf = $this->dameColumna($columnasAportaciones[$cantcolAportacion - 1], 1);
            }

            $activeSheet->getStyle("A8:CC8")->getAlignment()->setWrapText(true);
            $inde = 0;
            $indb = 0;
            $inda = 0;

            foreach ($cabeceraPlanilla as $cp) {
                if ($cp['tipo'] == 0) {
                    $activeSheet->mergeCells($columnasGeneral[$inde] . '8:' . $columnasGeneral[$inde] . '9');
                    $activeSheet->setCellValue($columnasGeneral[$inde] . '8', $cp['nombre']);
                    ++$inde;
                }
                if ($cp['tipo'] == 1) {
                    if ($cp['nombref'] == 'HORAEXTRAP') {
                        $activeSheet->mergeCells($columnasBeneficio[$indb] . '8:' . $columnasBeneficio[$indb + 1] . '8');
                        $activeSheet->setCellValue($columnasBeneficio[$indb] . '8', $cp['nombre']);
                        $activeSheet->setCellValue($columnasBeneficio[$indb] . '9', 'Horas');
                        ++$indb;
                        $activeSheet->setCellValue($columnasBeneficio[$indb] . '9', 'Monto');
                        $columnaextra = true;
                        $nombrecolumnaextra = $columnasBeneficio[$indb];
                    } else {
                        $activeSheet->setCellValue($columnasBeneficio[$indb] . '8', $cp['nombre']);
                        $activeSheet->mergeCells($columnasBeneficio[$indb] . '8:' . $columnasBeneficio[$indb] . '9');
                    }


                    ++$indb;
                }
                if ($cp['tipo'] == 2) {
                    $activeSheet->mergeCells($columnasAportaciones[$inda] . '8:' . $columnasAportaciones[$inda] . '9');

                    $activeSheet->setCellValue($columnasAportaciones[$inda] . '8', $cp['nombre']);
                    ++$inda;
                }
                if ($cp['tipo'] == 4) {
                    $activeSheet->mergeCells($columnasBeneficio[$indb] . '8:' . $columnasBeneficio[$indb] . '9');

                    $activeSheet->setCellValue($columnasBeneficio[$indb] . '8', $cp['nombre']);
                    ++$indb;
                }
                if ($cp['tipo'] == 5) {
                    $activeSheet->mergeCells($columnasAportaciones[$inda] . '8:' . $columnasAportaciones[$inda] . '9');

                    $activeSheet->setCellValue($columnasAportaciones[$inda] . '8', $cp['nombre']);
                    ++$inda;
                }
            }

           
            if ($cantcolBeneficio > 0) {
                $activeSheet->mergeCells($columnasAportaciones[$cantcolAportacion] . '8:' . $columnasAportaciones[$cantcolAportacion] . '9');
                
                $activeSheet->mergeCells($lpf[0] . '8:' . $lpf[0] . '9');

                $activeSheet->setCellValue($columnasAportaciones[$cantcolAportacion] . '8', 'TOTAL DESCUENTOS');
                $activeSheet->setCellValue($lpf[0] . '8', 'LIQUIDO PAGABLE');
            }
            $activeSheet->mergeCells($lpf[1] . '8:' . $lpf[1] . '9');
            $activeSheet->setCellValue($lpf[1] . '8', 'FIRMA');

            $activeSheet->getStyle($lpf[0] . '6')->applyFromArray($phpFont3);
            $activeSheet->getStyle($lpf[0] . '7')->applyFromArray($phpFont3);
            $activeSheet->getStyle($lpf[1] . '6')->applyFromArray($phpFont3);
            $activeSheet->getStyle($lpf[1] . '7')->applyFromArray($phpFont3);
            $activeSheet->setCellValue($lpf[0] . '6', 'MES');
            $activeSheet->setCellValue($lpf[0] . '7', 'AÑO');
            if ($mes != '') {
                
                $activeSheet->setCellValue($lpf[1] . '6', $fecha[0]['nombremes']);
            }
            $activeSheet->setCellValue($lpf[1] . '7', $anio);
            ///CUERPO
            for ($i = 0; $i < count($datoPlanilla); $i++) {
                $activeSheet->getStyle($columnasGeneral[$inde] . $kFila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $general = json_decode($datoPlanilla[$i]['ge'], true);
                $beneficio = json_decode($datoPlanilla[$i]['be'], true);
                $aporte = json_decode($datoPlanilla[$i]['ap'], true);
                $inde = 0;
                $indb = 0;
                $inda = 0;
                $montobe = 0;
                $montoa = 0;
                $activeSheet->getRowDimension($kFila)->setRowHeight(17);
                
                foreach ($cabeceraPlanilla as $cp) {
                     $activeSheet->getStyle("A".$kFila.":" . $lpf[1] . $kFila)->applyFromArray(
                        $phpFontCuerpo
                );
                    if ($cp['tipo'] == 0) {

                        if ($cp['nombref'] === 'nro') {
                            $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, $i + 1);
                        } else {
                            if ($cp['nombref'] === 'hbasico') {
                                //$montobe=$general[0][$cp['nombref']];
                                $activeSheet->getStyle($columnasGeneral[$inde] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                                $activeSheet->getStyle($columnasGeneral[$inde] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                                $montobe = $general[0]['hbasicoreal'];
                                $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, $general[0]['hbasicoreal']);
                            } else if ($cp['nombref'] === 'fechai') {
                                $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, date("d/m/Y", strtotime($general[0][$cp['nombref']])));
                            }else if ($cp['nombref'] === 'fechanac') {
                                $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, date("d/m/Y", strtotime($general[0][$cp['nombref']])));
                            }
                            else {
                                $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, $general[0][$cp['nombref']]);
                            }
                        }
                        ++$inde;
                    }

                    if ($cp['tipo'] == 1) {
                        $activeSheet->getStyle($columnasBeneficio[$indb] . $kFila)->getNumberFormat()->setFormatCode('0.00');

                        $activeSheet->getStyle($columnasBeneficio[$indb] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


                        if ($cp['nombref'] == 'totalga') {
                            $activeSheet->setCellValue($columnasBeneficio[$indb] . $kFila, $montobe);
                        } else if ($cp['nombref'] == 'HORAEXTRAP') {

                            $montobe += $beneficio[0][$cp['nombref']];
                            $baux = false;
                            $valor = -1;
                            $lb = $beneficio[0]['detallehe'];
                            $canthoras = $lb[0]['canthoras'];

                            $activeSheet->setCellValue($columnasBeneficio[$indb] . $kFila, round($canthoras, 2));
                            ++$indb;
                            $activeSheet->setCellValue($columnasBeneficio[$indb] . $kFila, round($beneficio[0][$cp['nombref']], 2));
                            $activeSheet->getStyle($columnasBeneficio[$indb] . $kFila)->getNumberFormat()->setFormatCode('0.00');

                            $activeSheet->getStyle($columnasBeneficio[$indb] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        } else {
                            $montobe += $beneficio[0][$cp['nombref']];
                            $activeSheet->setCellValue($columnasBeneficio[$indb] . $kFila, round($beneficio[0][$cp['nombref']], 2));
                        }

                        ++$indb;
                    }
                    if ($cp['tipo'] == 2) {

                        $activeSheet->getStyle($columnasAportaciones[$inda] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                        $activeSheet->getStyle($columnasAportaciones[$inda] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        if ($cp['nombref'] == 'totaldes') {
                            $activeSheet->setCellValue($columnasAportaciones[$inda] . $kFila, round($montoa, 2));
                        } else {
                            $montoa += $aporte[0][$cp['nombref']];

                            $activeSheet->setCellValue($columnasAportaciones[$inda] . $kFila, round($aporte[0][$cp['nombref']], 2));
                        }

                        ++$inda;
                    }
                    if ($cp['tipo'] == 4) {
                        // desglose de grupo de bonos
                       $activeSheet->getStyle($columnasAportaciones[$inda] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                        $activeSheet->getStyle($columnasAportaciones[$inda] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        $baux = false;
                        $valor = -1;
                        $laa = $beneficio[0]['listadetallebono'];
                        for ($j = 0; $j < count($laa); $j++) {
                            $l = $laa[$j]['listab'];
                            for ($k = 0; $k < count($l); $k++) {
                                if ($l[$k]['nombre'] == $cp['nombre']) {
                                    $valor = $l[$k]['valor'];
                                    $baux = true;
                                    break;
                                }
                            }
                            if ($baux == true) {
                                break;
                            }
                        }

                        $montobe += $valor;

                        $activeSheet->getStyle($columnasBeneficio[$indb] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                        $activeSheet->setCellValue($columnasBeneficio[$indb] . $kFila, $valor);
                        ++$indb;
                    }
                    if ($cp['tipo'] == 5) {
                        $activeSheet->getStyle($columnasAportaciones[$inda] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                        $activeSheet->getStyle($columnasAportaciones[$inda] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        $baux = false;
                        $valor = -1;
                        $laa = $aporte[0]['detalleagrupados'];
                        for ($j = 0; $j < count($laa); $j++) {
                            $l = $laa[$j]['lista'];
                            for ($k = 0; $k < count($l); $k++) {
                                if ($l[$k]['nombre'] == $cp['nombre']) {
                                    $valor = $l[$k]['valor'];
                                    $baux = true;
                                    break;
                                }
                            }
                            if ($baux == true) {
                                break;
                            }
                        }
                        $montoa += $valor;
            
                        //deglose de las aportaciones
                        $activeSheet->getStyle($columnasAportaciones[$inda] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                        $activeSheet->setCellValue($columnasAportaciones[$inda] . $kFila, $valor);
                        ++$inda;
                    }
                }
                $activeSheet->getStyle($lpf[0] . $kFila)->applyFromArray($phpFont2);


                if ($cantcolBeneficio > 0) {

                    $activeSheet->setCellValue($lpf[0] . $kFila, '=' . $columnasBeneficio[$cantcolBeneficio - 1] . $kFila . '-' . $columnasAportaciones[$cantcolAportacion - 1] . $kFila);
                    $activeSheet->getStyle($lpf[1] . $kFila)->applyFromArray($phpFont3);
                } else {
                    $activeSheet->getStyle($lpf[1] . $kFila)->applyFromArray($phpFont2);
                }

                $kFila++;
            }

            $activeSheet->mergeCells('A' . $kFila . ':' . $ltra . $kFila);
            $activeSheet->getStyle('A' . $kFila)->applyFromArray($phpFont1);
            $activeSheet->getStyle($ltra2 . $kFila)->applyFromArray($phpFont1);
            $activeSheet->setCellValue('A' . $kFila, 'TOTALES');

            $activeSheet->getRowDimension($kFila)->setRowHeight(20);
            $activeSheet->setCellValue($ltra2 . $kFila, '=SUM(' . $ltra2 . '9:' . $ltra2 . ($kFila - 1) . ')');

            for ($j = 0; $j < $cantcolBeneficio; $j++) {
                $activeSheet->getStyle($columnasBeneficio[$j] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle($columnasBeneficio[$j] . $kFila)->applyFromArray($phpFont1);
                $activeSheet->setCellValue($columnasBeneficio[$j] . $kFila, '=SUM(' . $columnasBeneficio[$j] . '9:' . $columnasBeneficio[$j] . ($kFila - 1) . ')');
            }
            for ($j = 0; $j < $cantcolAportacion; $j++) {

                $activeSheet->getStyle($columnasAportaciones[$j] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle($columnasAportaciones[$j] . $kFila)->applyFromArray($phpFont1);
                $activeSheet->setCellValue($columnasAportaciones[$j] . $kFila, '=SUM(' . $columnasAportaciones[$j] . '9:' . $columnasAportaciones[$j] . ($kFila - 1) . ')');
            }
            $activeSheet->getColumnDimension($lpf[1])->setWidth(25);

            $activeSheet->getStyle($lpf[0] . $kFila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle($lpf[0] . $kFila)->applyFromArray($phpFont1);
            $activeSheet->setCellValue($lpf[0] . $kFila, '=SUM(' . $lpf[0] . '9:' . $lpf[0] . ($kFila - 1) . ')');
            if ($cantcolBeneficio > 0) {
                $activeSheet->getStyle($columnasBeneficio[$cantcolBeneficio - 1] . '9:' . $columnasBeneficio[$cantcolBeneficio - 1] . ($kFila - 1))->applyFromArray(array('borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '000000')
                        ),
                    ),
                    'fill' => array('type' => PHPExcel_Style_Fill::FILL_NONE),));
            }
            $activeSheet->getStyle($columnasAportaciones[$cantcolAportacion - 1] . '9:' . $columnasAportaciones[$cantcolAportacion - 1] . ($kFila - 1))->applyFromArray(array('borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    ),
                ),
                'fill' => array('type' => PHPExcel_Style_Fill::FILL_NONE),));
            $filaD = $kFila + 6;
                       /*
            /////////////////////////////////INICIO TABLA DEPENDIENTE //////////////////////

            if (count($datoPlanillaD) > 0) {


                $activeSheet->mergeCells('A' . $filaD . ':J' . $filaD);
                $activeSheet->setCellValue('A' . $filaD, 'PERSONAS CON DISCAPACIDAD');
                $activeSheet->getStyle('A' . ($filaD))->getFont()->setBold(true);
                $filaD = $filaD + 2;
                $activeSheet->getStyle("A" . $filaD . ":CC" . $filaD)->getAlignment()->setWrapText(true);
                $ind = 1;
                $activeSheet->getRowDimension($filaD)->setRowHeight(45);
                $columnasD = ['A', 'B', 'C', 'D', 'F', 'H', 'J'];
                $activeSheet->mergeCells('D' . $filaD . ':E' . $filaD);
                $activeSheet->mergeCells('F' . $filaD . ':G' . $filaD);
                $activeSheet->mergeCells('H' . $filaD . ':I' . $filaD);
                $activeSheet->mergeCells('J' . $filaD . ':L' . $filaD);
                $activeSheet->getStyle("A" . $filaD . ":J" . $filaD)->applyFromArray(
                        $phpFontC
                );
                $activeSheet->setCellValue($columnasD[0] . $filaD, 'Nº');
                foreach ($cabeceraPlanillaD as $cp) {
                    $activeSheet->setCellValue($columnasD[$ind] . $filaD, $cp['nombre']);
                    ++$ind;
                }
                ++$filaD;
                $nro = 1;
                //CUERPO DE LA TABLA
                for ($i = 0; $i < count($datoPlanillaD); $i++) {
                    /////parte general

                    $general = json_decode($datoPlanillaD[$i]['ge'], true);
                    $ind = 1;

                    $activeSheet->mergeCells('D' . $filaD . ':E' . $filaD);
                    $activeSheet->mergeCells('F' . $filaD . ':G' . $filaD);
                    $activeSheet->mergeCells('H' . $filaD . ':I' . $filaD);
                    $activeSheet->mergeCells('J' . $filaD . ':L' . $filaD);
                    $activeSheet->getStyle("A" . $filaD . ":J" . $filaD)->applyFromArray(array('borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN,
                                'color' => array('rgb' => '000000')
                            ),)));
                    $activeSheet->setCellValue('A' . $filaD, $nro);
                    foreach ($cabeceraPlanillaD as $cp) {

                        $activeSheet->setCellValue($columnasD[$ind] . $filaD, $general[0][$cp['nombref']]);

                        ++$ind;
                    }
                    ++$nro;

                    $filaD++;
                }
                $filaD = $filaD + 4;
            }
            $filaD = $filaD + 3;
            */
            $activeSheet->getStyle('C' . ($filaD - 1))->applyFromArray(array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )));
            $activeSheet->mergeCells('E' . ($filaD - 1) . ':G' . ($filaD - 1));
            $activeSheet->getStyle('E' . ($filaD - 1))->applyFromArray(array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )));
            $activeSheet->mergeCells('H' . ($filaD - 1) . ':J' . ($filaD - 1));
            $activeSheet->setCellValue('C' . ($filaD - 1), 'Lic. ' . $datoEmpresa[0]['nombrer']);
            $activeSheet->setCellValue('E' . ($filaD - 1), $datoEmpresa[0]['cir']);

            $activeSheet->mergeCells('E' . $filaD . ':G' . $filaD);
            $activeSheet->mergeCells('I' . $filaD . ':K' . $filaD);
            $activeSheet->getStyle('C' . $filaD)->applyFromArray($phpFontP);
            $activeSheet->getStyle('E' . $filaD)->applyFromArray($phpFontP);
            $activeSheet->getStyle('I' . $filaD)->applyFromArray($phpFontP);
            
            $activeSheet->setCellValue('C' . $filaD, 'NOMBRE DEL EMPLEADOR O REPRESENTANTE LEGAL');
            $activeSheet->setCellValue('E' . $filaD, 'Nº DE DOCUMENTO DE IDENTIDAD');
            $activeSheet->setCellValue('I' . $filaD, 'FIRMA');
            $activeSheet->getStyle( $lpf[0]. '9')->applyFromArray($phpFontC);
            $this->descargarExcel($objPHPExcel, $nombreArchivo);
        } else {
            return $bandera;
        }
    }

    /**
     * 
     * @param integer $id, id de la planilla
     * @param integer[] $tipocontratos , id de los contratos
     * retorna  planilla en formato xls para la Caja
     */
    public function DescargarPlanillaCNS($id,$tipocontratos) {
        $tipocontratosseleccionados =''; 
        for ($i = 0; $i < count($tipocontratos); $i++) {
                        $tipocontratosseleccionados = $tipocontratosseleccionados . $tipocontratos[$i] . ',';
                    }
                    $tipocontratosseleccionados = substr($tipocontratosseleccionados, 0, -1);


        $fecha = Yii::app()->rrhh
                ->createCommand("select anio, case mes when 1 then'ENERO' when 2 then 'FEBRERO'when 3 then 'MARZO' when 4 then 'ABRIL'when 5 then 'MAYO'when 6 then'JUNIO'when 7 then 'JULIO' when 8 then 'AGOSTO' when 9 then 'SEPTIEMBRE'when 10 then 'OCTUBRE'when 11 then 'NOVIEMBRE' else 'DICIEMBRE' end as mes ,( to_char(fechadesde, 'DD-MM-YYYY')||'_' || to_char(fechahasta, 'DD-MM-YYYY')) as fecha  from planilla where id=" . $id . " ")
                ->queryAll();
        $mes = $fecha[0]['mes'];
        $anio = $fecha[0]['anio'];
        $nombre = $fecha[0]['fecha'];
        $datoEmpresa = Yii::app()->rrhh
                        ->createCommand("select e.*,pl.nombrer,pl.cir from planilla pl inner join general.representante r on r.cirepresentante=pl.cir inner join general.empresa e on e.id=r.idempresa  where pl.id=" . $id)
                        ->queryAll()[0];
        $datoPlanilla = Yii::app()->rrhh
                ->createCommand("select *,(select  (totaldes::numeric(12,2)-afp::numeric(12,2))  from  (select  json_array_elements(aporte)->>'totaldes' as totaldes, json_array_elements(aporte)->>'AFPAPORTETRABAJADOR' as afp
 from cuerpo where eliminado=false and id=c.id) as t)::numeric as totaldessinafp  from cuerpo c  where eliminado=false and idplanilla=$id and tipo=1 and  (idtipocontrato in(select idtipocontrato from general.aporbetipocont atc  where atc.idaportacionbeneficio in (11,25) and atc.eliminado=false ) and idtipocontrato in($tipocontratosseleccionados)) order by id asc ")
                ->queryAll();
        $cabeceraPlanilla = Yii::app()->rrhh
                ->createCommand("
( select c1.ordenalternativo as orden, c1.nombre,c1.nombref ,c1.tipo from  cabecera c1  where  c1.eliminado=false and c1.tipo=0 and nombre not in('NOMBRES','APELLIDO PATERNO','APELLIDO MATERNO','NOMBRES Y APELLIDOS','FECHA DE NACIMIENTO','HORAS PAGADAS(DIA)')  )
      union (select c.orden, c.nombre,c.nombref ,c.tipo from planilla pl inner join cabecera c on c.idplanilla=pl.id  where  c.eliminado=false and c.tipo=1 and   c.nombre not in('BONO NOCTURNO') 
      and pl.id=$id)  union  ( select c1.orden as orden, c1.nombre,c1.nombref ,c1.tipo from  cabecera c1 inner join planilla pl on pl.id=c1.idplanilla  where  c1.eliminado=false and c1.tipo=2 and   
      pl.id=$id and c1.nombre  in('AFP APORTE TRABAJADOR','TOTAL DESCUENTOS')  )
      union( select (select c1.orden+1 from   cabecera c1 inner join planilla pl on pl.id=c1.idplanilla  where  c1.eliminado=false and c1.tipo=2 and   
      pl.id=$id and c1.nombre  in('AFP APORTE TRABAJADOR')) as orden, 'OTROS DESCUENTOS'::varchar(70) nombre,'totaldessinafp'::varchar(70) asnombref , 2::INT tipo )  
      order by orden asc   ")
                ->queryAll();
        $cantcolBeneficio = Yii::app()->rrhh
                ->createCommand("
       (select count(*) as cant from planilla pl inner join cabecera c on c.idplanilla=pl.id  where  c.eliminado=false and c.tipo=1 and   c.nombre not in('BONO NOCTURNO') and pl.id=$id)
        ")
                ->queryScalar();
        $cantcolAportacion = 3;
        $nombreArchivo = $datoEmpresa['nombrecaja'].'_' . $mes.'_'.$anio;
        $cantcolGeneral = 9;
        $numcol = $cantcolGeneral + $cantcolBeneficio + $cantcolAportacion + 1;
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

        $activeSheet->getColumnDimension('A')->setWidth(4);
        $activeSheet->getColumnDimension('C')->setWidth(45);
        $activeSheet->getColumnDimension('D')->setWidth(5);
        $activeSheet->getColumnDimension('B')->setWidth(9);
        $activeSheet->getColumnDimension('E')->setWidth(5);
        $activeSheet->getColumnDimension('F')->setWidth(35);
        $activeSheet->getColumnDimension('G')->setWidth(11);
        $activeSheet->getColumnDimension('H')->setWidth(6);
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
        $activeSheet->getRowDimension(3)->setRowHeight(13);
        $activeSheet->getRowDimension(4)->setRowHeight(8);
        $activeSheet->getRowDimension(5)->setRowHeight(8);
        $activeSheet->getRowDimension(6)->setRowHeight(8);

        //CABECERA DE LA PLANILLA

        $activeSheet->mergeCells('A1:'.$columnascabecera[$numcol-4] .'1');
        $activeSheet->mergeCells('A2:'.$columnascabecera[$numcol-4] .'2');
        $activeSheet->mergeCells('A3:'.$columnascabecera[$numcol-4] .'3');
        $activeSheet->mergeCells('A4:'.$columnascabecera[$numcol-4] .'4');
        $activeSheet->mergeCells($columnascabecera[$numcol-3] .'1:'.$columnascabecera[$numcol-1].'1');
        $activeSheet->mergeCells($columnascabecera[$numcol-3] .'2:'.$columnascabecera[$numcol-1].'2');
        $activeSheet->mergeCells($columnascabecera[$numcol-3] .'3:'.$columnascabecera[$numcol-1].'3');
        $activeSheet->mergeCells($columnascabecera[$numcol-3] .'4:'.$columnascabecera[$numcol-1].'4');
        $activeSheet->mergeCells($columnascabecera[$numcol-3] .'5:'.$columnascabecera[$numcol-1].'5');
       
       
        $activeSheet->setCellValue('A1', strtoupper("PLANILLA DE SUELDOS CORRESPONDIENTE AL MES DE " . $mes . " " . $anio));
        $activeSheet->setCellValue('A3', strtoupper($datoEmpresa['cns']));
        $activeSheet->setCellValue('E5', 'Nro. Patronal:');
        $activeSheet->setCellValue('G5', $datoEmpresa['nrempleador']);
        $activeSheet->getStyle('E5:G5')->getFont()->setBold(true)->setSize(9);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $activeSheet->setCellValue($columnascabecera[$numcol-3].'1', $datoEmpresa['direccion']);
        $activeSheet->setCellValue($columnascabecera[$numcol-3].'2', "NIT:" . $datoEmpresa['nit']);
        $activeSheet->setCellValue($columnascabecera[$numcol-3].'3', "TEL:" . $datoEmpresa['telefono'] . "   FAX:" . $datoEmpresa['fax']);
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
        // COLUMNAS STATICAS
        $columnasGeneral = $this->dameColumna('A', $cantcolGeneral);
        $columnasBeneficio = $this->dameColumna($columnasGeneral[$cantcolGeneral], $cantcolBeneficio);
        $columnasAportaciones = $this->dameColumna($columnasBeneficio[$cantcolBeneficio], $cantcolAportacion);
        $lpf = $this->dameColumna($columnasAportaciones[$cantcolAportacion], 1);
        $activeSheet->getStyle('A7:' . $lpf[0] . '7')->applyFromArray($phpFontC);
        $activeSheet->getStyle("A7:CC7")->getAlignment()->setWrapText(true);
        $inde = 0;
        $indb = 0;
        $inda = 0;
        foreach ($cabeceraPlanilla as $cp) {
            if ($cp['tipo'] == 0) {

                if ($cp['nombref'] == 'nac')
                    $activeSheet->setCellValue($columnasGeneral[$inde] . '7', substr($cp['nombre'], 0, 3));
                else
                    $activeSheet->setCellValue($columnasGeneral[$inde] . '7', $cp['nombre']);


                ++$inde;
            }
            if ($cp['tipo'] == 1) {
                $activeSheet->setCellValue($columnasBeneficio[$indb] . '7', $cp['nombre']);

                ++$indb;
            }
            if ($cp['tipo'] == 2) {         
            $activeSheet->setCellValue($columnasAportaciones[$inda] . '7', $cp['nombre']);
             ++$inda;
            }
               
            
        }

        $activeSheet->setCellValue($lpf[0] . '7', 'LIQUIDO PAGABLE');

        ///CUERPO
        for ($i = 0; $i < count($datoPlanilla); $i++) {
            $general = json_decode($datoPlanilla[$i]['general'], true);
            $beneficio = json_decode($datoPlanilla[$i]['beneficio'], true);
            $aporte = json_decode($datoPlanilla[$i]['aporte'], true);
            $inde = 0;
            $indb = 0;
            $inda = 0;
            $montobe = 0;
            $montoa = 0;
            foreach ($cabeceraPlanilla as $cp) {
                $activeSheet->getRowDimension($kFila)->setRowHeight(23);
                if ($cp['tipo'] == 0) {
                    $activeSheet->getStyle($columnasGeneral[$inde] . $kFila)->applyFromArray($phpFont2);
                    if ($cp['nombref'] === 'nro') {
                        $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, $i + 1);
                    } else {
                        if ($cp['nombref'] === 'hbasico') {
                            //$montobe=$general[0][$cp['nombref']];
                            $activeSheet->getStyle($columnasGeneral[$inde] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                            $activeSheet->getStyle($columnasGeneral[$inde] . $kFila)->applyFromArray($phpFont3);
                            $montobe = $general[0]['hbasicoreal'];
                            $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, $general[0]['hbasicoreal']);
                        } else if ($cp['nombref'] === 'nac') {
                            $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, substr($general[0][$cp['nombref']], 0, 3));
                        } else if ($cp['nombref'] === 'ci') {
                            $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, $general[0]['ci']);
                        } else if ($cp['nombref'] === 'fechai') {
                            $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, date("d/m/Y", strtotime($general[0][$cp['nombref']])));
                        } else {
                            $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, $general[0][$cp['nombref']]);
                        }
                    }

                    ++$inde;
                }
                if ($cp['tipo'] == 1) {
                    $activeSheet->getStyle($columnasBeneficio[$indb] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                    $activeSheet->getStyle($columnasBeneficio[$indb] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    if ($cp['nombref'] == 'totalga') {
                        $activeSheet->setCellValue($columnasBeneficio[$indb] . $kFila, $montobe);
                    } else {
                        $montobe += $beneficio[0][$cp['nombref']];
                        $activeSheet->setCellValue($columnasBeneficio[$indb] . $kFila, round($beneficio[0][$cp['nombref']], 2));
                    }

                    $activeSheet->getStyle($columnasBeneficio[$indb] . $kFila)->applyFromArray($phpFont3);
                    ++$indb;
                }
                if ($cp['tipo'] == 2) {
                    $activeSheet->getStyle($columnasAportaciones[$inda] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                    $activeSheet->getStyle($columnasAportaciones[$inda] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    if ($cp['nombref'] == 'totaldessinafp') {
                        $activeSheet->setCellValue($columnasAportaciones[$inda] . $kFila, round($datoPlanilla[$i]['totaldessinafp'], 2));
                    } else {
                       
                        $activeSheet->setCellValue($columnasAportaciones[$inda] . $kFila, round($aporte[0][$cp['nombref']], 2));
                    }
                    $activeSheet->getStyle($columnasAportaciones[$inda] . $kFila)->applyFromArray($phpFont3);

                    ++$inda;
                }
            }
            $activeSheet->getStyle($lpf[0] . $kFila)->applyFromArray($phpFont2);
            $activeSheet->setCellValue($lpf[0] . $kFila, '=' . $columnasBeneficio[$cantcolBeneficio - 1] . $kFila . '-' . $columnasAportaciones[$cantcolAportacion - 1] . $kFila);
            $activeSheet->getStyle($lpf[0] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


            $kFila++;
        }
        $ltra = 'H';
        $ltra2 = 'I';
        $activeSheet->mergeCells('A' . $kFila . ':' . $ltra . $kFila);
        $activeSheet->getRowDimension($kFila)->setRowHeight(30);
        $activeSheet->getStyle('A' . $kFila)->applyFromArray($phpFont1);
        $activeSheet->getStyle($ltra2 . $kFila)->applyFromArray($phpFont1);
        $activeSheet->setCellValue('A' . $kFila, 'TOTALES');
        $activeSheet->setCellValue($ltra2 . $kFila, '=SUM(' . $ltra2 . '8:' . $ltra2 . ($kFila - 1) . ')');
        for ($j = 0; $j < $cantcolBeneficio; $j++) {
            $activeSheet->getStyle($columnasBeneficio[$j] . $kFila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle($columnasBeneficio[$j] . $kFila)->applyFromArray($phpFont1);
            $activeSheet->setCellValue($columnasBeneficio[$j] . $kFila, '=SUM(' . $columnasBeneficio[$j] . '8:' . $columnasBeneficio[$j] . ($kFila - 1) . ')');
        }
        for ($j = 0; $j < $cantcolAportacion; $j++) {
            $activeSheet->getStyle($columnasAportaciones[$j] . $kFila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle($columnasAportaciones[$j] . $kFila)->applyFromArray($phpFont1);
            $activeSheet->setCellValue($columnasAportaciones[$j] . $kFila, '=SUM(' . $columnasAportaciones[$j] . '8:' . $columnasAportaciones[$j] . ($kFila - 1) . ')');
        }
        $activeSheet->getColumnDimension($lpf[1])->setWidth(25);
        $activeSheet->getStyle($lpf[0] . $kFila)->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle($lpf[0] . $kFila)->applyFromArray($phpFont1);
        $activeSheet->setCellValue($lpf[0] . $kFila, '=SUM(' . $lpf[0] . '8:' . $lpf[0] . ($kFila - 1) . ')');
        $numero = round($activeSheet->getCellByColumnAndRow(($cantcolBeneficio + 8), ($kFila))->getCalculatedValue(), 2);

        $activeSheet->getStyle($columnasBeneficio[$cantcolBeneficio - 1] . '9:' . $columnasBeneficio[$cantcolBeneficio - 1] . ($kFila - 1))->applyFromArray(array('borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_NONE),));

        $activeSheet->getStyle($columnasAportaciones[$cantcolAportacion - 1] . '9:' . $columnasAportaciones[$cantcolAportacion - 1] . ($kFila - 1))->applyFromArray(array('borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_NONE),));

        $kFila += 8;

        $activeSheet->setCellValue('F' . $kFila, $datoEmpresa['cargoencargado']);
        $activeSheet->mergeCells('J' . $kFila . ':M' . $kFila);
        $activeSheet->setCellValue('J' . $kFila, 'GERENTE');
        $activeSheet->getStyle('F' . $kFila)->getFont()->setBold(true)->setSize(8);
        $activeSheet->getStyle('J' . $kFila)->getFont()->setBold(true)->setSize(8);
        $activeSheet->getStyle('J' . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('F' . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


        $kFila += 3;

        $activeSheet->mergeCells('D' . $kFila . ':J' . $kFila);
        $activeSheet->mergeCells('M' . $kFila . ':N' . $kFila);
        $activeSheet->setCellValue('D' . $kFila, '* TOTAL GANADO PARA APORTES A LA CAJA '.$datoEmpresa['piecajasaluda']);
        $activeSheet->getStyle('D' . $kFila . ':Z' . $kFila)->getFont()->setSize(8);
        $activeSheet->setCellValue('M' . $kFila, $numero);
        $activeSheet->setCellValue('L' . $kFila, 'Bs.');
        $activeSheet->getStyle('L' . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('M' . $kFila)->getFont()->setBold(true);
        $kFila += 2;
        $activeSheet->getStyle('F' . $kFila . ':Z' . $kFila)->getFont()->setSize(8);
        $activeSheet->setCellValue('F' . $kFila, 'SON:');
        $activeSheet->getStyle('F' . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->mergeCells('G' . $kFila . ':Q' . $kFila);
         $numero = explode('.', $numero);
        $literal = $this->numeroLiteral($numero[0]);
        if (count($numero)>1){
           $activeSheet->setCellValue('G' . $kFila, $literal . ' ' . $numero[1] . '/BOLIVIANOS');
  
        }else{
             $activeSheet->setCellValue('G' . $kFila, $literal . ' 00/BOLIVIANOS');

        }
       
       
        $this->descargarExcel($objPHPExcel, $nombreArchivo);
    }
    /**
     * 
     * @param integer $p_idplanilla, id de la planilla
     * @param integer $opcion, posibles valores 1=Afp Prevision y 2= Afp Futuro
     * retorna planilla para la AFP segun la opcion seleccionada
     */
    public function DescargarPlanillaAFP($p_idplanilla, $opcion) {
        $cabecera = Yii::app()->rrhh
                        ->createCommand("select * from planilla where id=$p_idplanilla")
                        ->queryAll()[0];

        $datos = Yii::app()->rrhh
                ->createCommand("select optafp,tipodoc,ci,alfanum,matriculaseguro,apellidop,apellidom,apellidocasada,primernombre,segundonombre,novedad,
case when t.fechanovedad<>'' then to_char(t.fechanovedad::date,'YYYYmmdd') else t.fechanovedad end as fechanovedad,
dias,tg,afp,cotizante,tipocotizante
 from (select ((json_array_elements(general)->>'optafp')::int)as optafp,
((json_array_elements(general)->>'tipodoc')::text)as tipodoc,
((json_array_elements(general)->>'nci')::text)::int as ci,
(json_array_elements(general)->>'alfanum')::text as alfanum ,
(select p.numafp from general.persona p inner join general.empleado e on e.idpersona=p.id where e.id=c.idempleado)::text as matriculaseguro,
(json_array_elements(general)->>'apellidop')::text apellidop,
(json_array_elements(general)->>'apellidom')::text as apellidom,
(json_array_elements(general)->>'apellidocasada')::text as apellidocasada ,
(json_array_elements(general)->>'pnombre')::text as primernombre,
(json_array_elements(general)->>'snombre')::text as segundonombre,
(json_array_elements(general)->>'novedad')::text as novedad,

 (json_array_elements(general)->>'fechanovedad') as fechanovedad,
 (json_array_elements(general)->>'diasafp')::text as dias,
 (json_array_elements(beneficio)->>'totalga')::text as tg,
 ((json_array_elements(aporte)->>'AFPAPORTETRABAJADOR')::text)::numeric as afp,
 (json_array_elements(general)->>'cotizante')::text as cotizante,
 (json_array_elements(general)->>'tipocotizante')::text as tipocotizante from cuerpo c where eliminado=false and idplanilla=$p_idplanilla and   idtipocontrato in(select distinct idtipocontrato from 
general.aporbetipocont atc inner join general.aportacionbeneficio ab on ab.id=atc.idaportacionbeneficio
 where  ab.idaportacionbeneficiopadre in (select id from general.aportacionbeneficio where NOMBREF='AFPAPORTETRABAJADOR') and  atc.eliminado=false )  ) as t  where t.afp>0  and t.optafp=$opcion order by t.ci asc ")
                ->queryAll();


        $datos = Yii::app()->rrhh
                ->createCommand("select distinct  optafp,tipodoc,ci,alfanum,matriculaseguro,apellidop,apellidom,apellidocasada,primernombre,segundonombre,novedad,
case when t.fechanovedad<>'' then to_char(t.fechanovedad::date,'YYYYmmdd') else t.fechanovedad end as fechanovedad,
 ( case when t.fechanovedad=''  then 
(select sum(tt.dias) from (
select (json_array_elements(general)->>'diasafp')::int as dias  from cuerpo where eliminado=false and idempleado=t.idempleado and idplanilla=$p_idplanilla
 ) tt )else t.dias end ) as dias,( case when t.fechanovedad=''  then 
(select sum(tt.tg) from (
select (json_array_elements(beneficio)->>'totalga')::numeric(12,2) as tg  from cuerpo where eliminado=false and idempleado=t.idempleado and idplanilla=$p_idplanilla
 ) tt )else t.tg end ) as tg ,( case when t.fechanovedad=''  then 
(select sum(tt.afp) from (
select (json_array_elements(aporte)->>'AFPAPORTETRABAJADOR')::numeric as afp  from cuerpo where eliminado=false and idempleado=t.idempleado and idplanilla=$p_idplanilla
 ) tt )else t.afp end ) as afp,cotizante,tipocotizante
 from (
 
 select ((json_array_elements(general)->>'optafp')::int)as optafp,
((json_array_elements(general)->>'tipodoc')::text)as tipodoc,
((json_array_elements(general)->>'nci')::text)::int as ci,
(json_array_elements(general)->>'alfanum')::text as alfanum ,
(select p.numafp from general.persona p inner join general.empleado e on e.idpersona=p.id where e.id=c.idempleado)::text as matriculaseguro,
(json_array_elements(general)->>'apellidop')::text apellidop,
(json_array_elements(general)->>'apellidom')::text as apellidom,
(json_array_elements(general)->>'apellidocasada')::text as apellidocasada ,
(json_array_elements(general)->>'pnombre')::text as primernombre,
(json_array_elements(general)->>'snombre')::text as segundonombre,
(json_array_elements(general)->>'novedad')::text as novedad,

 (json_array_elements(general)->>'fechanovedad') as fechanovedad,
 (json_array_elements(general)->>'diasafp')::int as dias,
 (json_array_elements(beneficio)->>'totalga')::numeric(12,2) as tg,
 ((json_array_elements(aporte)->>'AFPAPORTETRABAJADOR')::text)::numeric as afp,
 (json_array_elements(general)->>'cotizante')::text as cotizante,
 (json_array_elements(general)->>'tipocotizante')::text as tipocotizante,idempleado from cuerpo c where eliminado=false and idplanilla=$p_idplanilla and   idtipocontrato in(select distinct idtipocontrato from 
general.aporbetipocont atc inner join general.aportacionbeneficio ab on ab.id=atc.idaportacionbeneficio
 where  ab.idaportacionbeneficiopadre in (select id from general.aportacionbeneficio where NOMBREF='AFPAPORTETRABAJADOR') and  atc.eliminado=false ) 
  ) as t  where t.afp>0  and t.optafp=$opcion order by t.ci asc ")
                ->queryAll();

        $mes = strtoupper(strftime("%B", DateTime::createFromFormat('!m', $cabecera['mes'])->getTimestamp()));

        $nombreArchivo = 'AFP_' . $cabecera['fechadesde'] . '_' . $cabecera['fechahasta'];

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->removeSheetByIndex(0);
        $objPHPExcel->createSheet(0);
        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $activeSheet->setTitle($nombreArchivo);
        $activeSheet->getDefaultColumnDimension()->setWidth(14);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $phpFont = array('font' => array(
                'size' => 10,
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
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_NONE
            ),
            'font' => array(
                'bold' => true,
            )
        );
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);

        $activeSheet->getColumnDimension('A')->setWidth(13);
        $activeSheet->getColumnDimension('B')->setWidth(13);
        $activeSheet->getColumnDimension('C')->setWidth(13);
        $activeSheet->getColumnDimension('D')->setWidth(13);
        $activeSheet->getColumnDimension('E')->setWidth(13);
        $activeSheet->getColumnDimension('F')->setWidth(13);
        $activeSheet->getColumnDimension('G')->setWidth(13);
        $activeSheet->getColumnDimension('H')->setWidth(13);
        $activeSheet->getColumnDimension('I')->setWidth(13);
        $activeSheet->getColumnDimension('J')->setWidth(13);
        $activeSheet->getColumnDimension('K')->setWidth(13);
        $activeSheet->getColumnDimension('L')->setWidth(13);
        $activeSheet->getColumnDimension('M')->setWidth(13);
        $activeSheet->getColumnDimension('N')->setWidth(13);
        $activeSheet->getColumnDimension('O')->setWidth(13);

/////////
        $activeSheet->getStyle("A1")->applyFromArray($phpFontC);
        $activeSheet->getStyle("B1")->applyFromArray($phpFontC);
        $activeSheet->getStyle("C1")->applyFromArray($phpFontC);
        $activeSheet->getStyle("D1")->applyFromArray($phpFontC);
        $activeSheet->getStyle("E1")->applyFromArray($phpFontC);
        $activeSheet->getStyle("F1")->applyFromArray($phpFontC);
        $activeSheet->getStyle("G1")->applyFromArray($phpFontC);
        $activeSheet->getStyle("H1")->applyFromArray($phpFontC);
        $activeSheet->getStyle("I1")->applyFromArray($phpFontC);
        $activeSheet->getStyle("J1")->applyFromArray($phpFontC);
        $activeSheet->getStyle("K1")->applyFromArray($phpFontC);
        $activeSheet->getStyle("L1")->applyFromArray($phpFontC);
        $activeSheet->getStyle("M1")->applyFromArray($phpFontC);
        $activeSheet->getStyle("N1")->applyFromArray($phpFontC);
        $activeSheet->getStyle("O1")->applyFromArray($phpFontC);

        $activeSheet->setCellValue('A1', 'TIPO DOC.');
        $activeSheet->setCellValue('B1', 'NUMERO DOCUMENTO');
        $activeSheet->setCellValue('C1', 'ALFANUMERICO DEL DOCUMENTO');
        $activeSheet->setCellValue('D1', 'NUA / CUA');
        $activeSheet->setCellValue('E1', 'AP. PATERNO');
        $activeSheet->setCellValue('F1', 'AP. MATERNO');
        $activeSheet->setCellValue('G1', 'AP. CASADA');
        $activeSheet->setCellValue('H1', 'PRIMER NOMBRE');
        $activeSheet->setCellValue('I1', 'SEG. NOMBRE');
        $activeSheet->setCellValue('J1', 'NOVEDAD');
        $activeSheet->setCellValue('K1', 'FECHA NOVEDAD');
        $activeSheet->setCellValue('L1', 'DIAS');
        $activeSheet->setCellValue('M1', 'TOTAL GANADO');
        $activeSheet->setCellValue('N1', 'TIPO COTIZANTE');
        $activeSheet->setCellValue('O1', 'TIPO ASEGURADO');
        $kFila = 2;
        $cant = count($datos);
        for ($i = 0; $i < $cant; $i++) {
            $activeSheet->setCellValue('A' . ($i + 2), $datos[$i]['tipodoc']);
            $activeSheet->setCellValue('B' . ($i + 2), $datos[$i]['ci']);
            $activeSheet->setCellValue('C' . ($i + 2), $datos[$i]['alfanum']);
            $activeSheet->setCellValue('D' . ($i + 2), $datos[$i]['matriculaseguro']);
            $activeSheet->setCellValue('E' . ($i + 2), $datos[$i]['apellidop']);
            $activeSheet->setCellValue('F' . ($i + 2), $datos[$i]['apellidom']);
            $activeSheet->setCellValue('G' . ($i + 2), $datos[$i]['apellidocasada']);
            $activeSheet->setCellValue('H' . ($i + 2), $datos[$i]['primernombre']);
            $activeSheet->setCellValue('I' . ($i + 2), $datos[$i]['segundonombre']);
            $activeSheet->setCellValue('J' . ($i + 2), $datos[$i]['novedad']);
            $activeSheet->setCellValue('K' . ($i + 2), $datos[$i]['fechanovedad']);
            $activeSheet->setCellValue('L' . ($i + 2), $datos[$i]['dias']);
            $activeSheet->setCellValue('M' . ($i + 2), $datos[$i]['tg']);
            $activeSheet->setCellValue('N' . ($i + 2), $datos[$i]['cotizante']);
            $activeSheet->setCellValue('O' . ($i + 2), $datos[$i]['tipocotizante']);
        }


        $this->descargarExcel($objPHPExcel, $nombreArchivo);
    }
 /**
  * 
  * @param integer $p_idplanilla, id de la planilla
  * @param integer $p_idtipoindemnizacion, id de la indemnizacion, posible valores 20=Indemnizacion y 34= indemnizacion litigio
  * @return planilla en formato xls del calculo de la prevision de indemnizacion segun $p_idtipoindemnizacion  seleccionada
  */   
 public function DescargarIndemnizacionAguinaldos($p_idplanilla, $p_idtipoindemnizacion) {

        $planillaactual=  Yii::app()->rrhh
                ->createCommand("select mes from planilla where  id=$p_idplanilla")
                ->queryScalar();
        if($planillaactual==12){
            return $this->DescargarIndemnizacionAguinaldosMesDiciembre($p_idplanilla, $p_idtipoindemnizacion);
        }else{
            return $this->DescargarIndemnizacionAguinaldosMes($p_idplanilla, $p_idtipoindemnizacion);
        }
        

    }
    /**
     * 
     * @param integer $p_idplanilla, id de la planilla
     * @param integer $p_idtipoindemnizacion, id de la indemnizacion, posible valores 20=Indemnizacion y 34= indemnizacion litigio
     * retorna planilla de caluclo de prevision de indemnizacion especial para diciembre
     */
     public function DescargarIndemnizacionAguinaldosMesDiciembre($p_idplanilla, $p_idtipoindemnizacion) {

        $planillaactual=  Yii::app()->rrhh
                ->createCommand("select id,mes,to_char(fechadesde,'DD-MM-YYYY') as fechadesde,to_char(fechahasta,'DD-MM-YYYY') as fechahasta,case when bindemnizacion is null then null  else ( select(json_array_elements(bindemnizacion)->>'$p_idtipoindemnizacion')::numeric(12,2)from planilla where id=$p_idplanilla) end as bindemnizacion ,
        case when  bprimeraguinaldo is null then null else ( select(json_array_elements(bprimeraguinaldo)->>'$p_idtipoindemnizacion')::numeric(12,2)from planilla where id=$p_idplanilla) end as bprimeraguinaldo,
        case when bsegundoaguinaldo is null then  null else ( select(json_array_elements(bsegundoaguinaldo)->>'$p_idtipoindemnizacion')::numeric(12,2)from planilla where id=$p_idplanilla) end as bsegundoaguinaldo 
        from planilla  where  id=$p_idplanilla")
                ->queryAll();
                    
        $listaplanillas = Yii::app()->rrhh
                ->createCommand("select id,mes,to_char(fechadesde,'DD/MM/YYYY') as fechadesde,to_char(fechahasta,'DD/MM/YYYY') as fechahasta         
        from planilla  where eliminado=false and id<$p_idplanilla order by id desc limit 3")
                ->queryAll();
       
        $datos = Yii::app()->rrhh
                ->createCommand("select t.id, t.nombrearea, t.factor,t.empleado,to_char(t.fechauia::date,'dd/mm/YYYY')AS fechauia ,t.factorprimeraguinaldo,t.factorsegundoaguinaldo,t.tg1,t.tg2,t.tg3,t.tg4,t.promedioaguinaldo,t.promedioindemnizacion,CASE WHEN t.cancelacionporretiro= false then 'Sin Cancelar' else 'Cancelado' end as estado,t.cancelacionporretiro ,case when t.novedad='R' then (select pb.consegundoaguinaldo from general.historialestadoempleado hee inner join general.pagobeneficio pb on pb.idhistorialestadoempleado=hee.id
 where pb.eliminado=false and hee.eliminado=false and pb.idtipopagobeneficio=2 and   hee.idempleado=t.idempleado order by hee.id desc limit 1) else false end  as consegundoaguinaldo   from 
(select c.id,c.idempleado,  a.nombre as nombrearea, (json_array_elements(c.general)->>'factor') as factor,
(json_array_elements(c.general)->>'novedad') as novedad,(json_array_elements(c.general)->>'nombrec') as empleado,
(json_array_elements(c.general)->>'fechaultidemnizacion')::date as fechauia,
(json_array_elements(c.informacionindemnizacionaguinaldo)->>'PRIMERAGUINALDO') AS factorprimeraguinaldo,
(json_array_elements(c.informacionindemnizacionaguinaldo)->>'SEGUNDOAGUINALDO') as factorsegundoaguinaldo  
,
( select (json_array_elements(c1.informacionindemnizacionaguinaldo)->>'totalganado1')::numeric(12,2)  from cuerpo c1 where c1.eliminado=false and c1.idplanilla=".$listaplanillas[0]['id']." and c1.idempleado=c.idempleado) AS tg1  ,
( select (json_array_elements(c1.informacionindemnizacionaguinaldo)->>'totalganado2')::numeric(12,2) from cuerpo c1 where c1.eliminado=false and c1.idempleado=c.idempleado and c1.idplanilla=".$listaplanillas[0]['id'].") AS tg2 ,
(select (json_array_elements(c1.informacionindemnizacionaguinaldo)->>'totalganado3')::numeric(12,2)  from cuerpo c1 where eliminado=false and c1.idempleado=c.idempleado and c1.idplanilla=".$listaplanillas[0]['id'].") AS tg3 ,
(select (json_array_elements(c1.informacionindemnizacionaguinaldo)->>'promedio')::numeric(12,2) from cuerpo c1 where c1.eliminado=false and c1.idplanilla=".$listaplanillas[0]['id']."  and c1.idempleado=c.idempleado ) AS promedioaguinaldo    ,
(json_array_elements(c.informacionindemnizacionaguinaldo)->>'totalganado3')::numeric(12,2) as tg4,
(json_array_elements(c.informacionindemnizacionaguinaldo)->>'promedio')::numeric(12,2) as promedioindemnizacion,

        (json_array_elements(c.general)->>'fechanovedad') as fnovedad ,c.cancelacionporretiro from cuerpo c inner join general.area a on a.id=c.area 
        where c.eliminado=false and c.enplanillaindemnizacion=true and idplanilla=$p_idplanilla and c.idtipocontrato in( select abtc.idtipocontrato from general.aporbetipocont abtc inner join general.aportacionbeneficio ab on ab.id=abtc.idaportacionbeneficio where abtc.eliminado=false and ab.id=$p_idtipoindemnizacion)  
         ) t order by id asc   ")
                ->queryAll();
        

        $nombreArchivo = 'CIA_' . $planillaactual[0]['fechadesde'] . '_' . $planillaactual[0]['fechahasta'];

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->removeSheetByIndex(0);
        $objPHPExcel->createSheet(0);
        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $activeSheet->setTitle($nombreArchivo);
        $activeSheet->getDefaultColumnDimension()->setWidth(14);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $phpFont = array('font' => array(
                'size' => 8,
                'name' => 'Times New Roman',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
        );
        $phpFontP = array('font' => array(
                'size' => 14,
                'name' => 'Times New Roman',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'font' => array(
                'bold' => true,)
        );

        $phpFontC = array(
            'font' => array(
                'bold' => true,
            ), 'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);
        $activeSheet->getRowDimension(4)->setRowHeight(40);
        $activeSheet->getStyle("A4:Q4")->getAlignment()->setWrapText(true);
        $activeSheet->getColumnDimension('A')->setWidth(10);
        $activeSheet->getColumnDimension('B')->setWidth(40);
        $activeSheet->getColumnDimension('C')->setWidth(40);
        $activeSheet->getColumnDimension('D')->setWidth(13);
        $activeSheet->getColumnDimension('E')->setWidth(13);
        $activeSheet->getColumnDimension('F')->setWidth(13);
        $activeSheet->getColumnDimension('G')->setWidth(13);
        $activeSheet->getColumnDimension('H')->setWidth(13);
        $activeSheet->getColumnDimension('I')->setWidth(13);
        $activeSheet->getColumnDimension('J')->setWidth(13);
        $activeSheet->getColumnDimension('K')->setWidth(13);
        $activeSheet->getColumnDimension('L')->setWidth(13);
        $activeSheet->getColumnDimension('M')->setWidth(13);
        $activeSheet->getColumnDimension('N')->setWidth(13);
        $activeSheet->getColumnDimension('O')->setWidth(13);
        $activeSheet->getColumnDimension('P')->setWidth(13);
        $activeSheet->getColumnDimension('Q')->setWidth(13);
        $activeSheet->getColumnDimension('R')->setWidth(13);
        $activeSheet->getColumnDimension('S')->setWidth(13);
        $activeSheet->getColumnDimension('T')->setWidth(13);
        $activeSheet->getColumnDimension('U')->setWidth(13);
        $activeSheet->getColumnDimension('V')->setWidth(13);
        $activeSheet->getColumnDimension('W')->setWidth(13);
        $activeSheet->getColumnDimension('X')->setWidth(13);
        $activeSheet->getColumnDimension('Y')->setWidth(13);
        $activeSheet->getColumnDimension('Z')->setWidth(13);

        $activeSheet->getStyle("A1")->applyFromArray($phpFontP);
        $activeSheet->getStyle("A2")->applyFromArray($phpFontP);
        $activeSheet->getStyle("J3")->applyFromArray($phpFontC);
        $activeSheet->getStyle("L3")->applyFromArray($phpFontC);
        $activeSheet->getStyle("N3")->applyFromArray($phpFontC);
        $activeSheet->getStyle("P3")->applyFromArray($phpFontC);
        $activeSheet->getStyle("A4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("B4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("C4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("D4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("E4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("F4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("G4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("H4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("I4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("J4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("K4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("L4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("M4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("N4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("O4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("P4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("Q4")->applyFromArray($phpFontC);

        $activeSheet->mergeCells('A1:N1');
        $activeSheet->mergeCells('A2:N2');
        $activeSheet->setCellValue('A1', 'PLANILLA DE PREVISION DE INDEMNIZACION Y AGUINALDOS');
        $activeSheet->setCellValue('A2', '(al ' . $planillaactual[0]['fechahasta'] . ')');
        $activeSheet->mergeCells('L3:M3');
        $activeSheet->mergeCells('A3:k3');
        $activeSheet->setCellValue('L3', 'INDEMNIZACION');
        $activeSheet->mergeCells('N3:O3');
        $activeSheet->setCellValue('N3', 'PRIMER AGUINALDO');
        $activeSheet->mergeCells('P3:Q3');
        $activeSheet->setCellValue('P3', 'SEGUNDO AGUINALDO');
        $activeSheet->setCellValue('A4', 'Nº');
        $activeSheet->setCellValue('B4', 'EMPLEADO');
        $activeSheet->setCellValue('C4', 'AREA');
        $activeSheet->setCellValue('D4', 'ESTADO');

        $mes = strtoupper(strftime("%B", DateTime::createFromFormat('!m', $listaplanillas[2]['mes'])->getTimestamp()));
        $activeSheet->setCellValue('E4', $mes);
        $mes = strtoupper(strftime("%B", DateTime::createFromFormat('!m', $listaplanillas[1]['mes'])->getTimestamp()));
        $activeSheet->setCellValue('F4', $mes);
        $mes = strtoupper(strftime("%B", DateTime::createFromFormat('!m', $listaplanillas[0]['mes'])->getTimestamp()));
        $activeSheet->setCellValue('G4', $mes);
        $mes = strtoupper(strftime("%B", DateTime::createFromFormat('!m', $planillaactual[0]['mes'])->getTimestamp()));
        $activeSheet->setCellValue('H4', $mes);
        $activeSheet->setCellValue('I4', 'PROMEDIO AGUINALDO');
        $activeSheet->setCellValue('J4', 'PROMEDIO INDEMNIZACION');
        $activeSheet->setCellValue('K4', 'FECHA ULTIMA INDEMNIZACION');
        $activeSheet->setCellValue('L4', 'FACTOR');
        $activeSheet->setCellValue('M4', 'TOTAL');
        $activeSheet->setCellValue('N4', 'FACTOR');
        $activeSheet->setCellValue('O4', 'TOTAL');
        $activeSheet->setCellValue('P4', 'FACTOR');
        $activeSheet->setCellValue('Q4', 'TOTAL');
        //cod , empleado ,cargo  ,tg1 ,tg2 ,tg3 ,factor ,dia ,mes ,anio 
        $cant = count($datos);
        $totalindemnizacionpagada=0;
        $totalprimeraguinaldopagado=0;
        $totalsegundoaguinaldopagado=0;
        for ($i = 0; $i < $cant; $i++) {

            $activeSheet->setCellValue('A' . ($i + 5), ($i + 1));
            $activeSheet->setCellValue('B' . ($i + 5), $datos[$i]['empleado']);
            $activeSheet->setCellValue('C' . ($i + 5), $datos[$i]['nombrearea']);
            $activeSheet->setCellValue('D' . ($i + 5), $datos[$i]['estado']);     
            

            $activeSheet->getStyle('E' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('F' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('G' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('H' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->setCellValue('E' . ($i + 5), $datos[$i]['tg1']);
            $activeSheet->setCellValue('F' . ($i + 5), $datos[$i]['tg2']);
            $activeSheet->setCellValue('G' . ($i + 5), $datos[$i]['tg3']);
            $activeSheet->setCellValue('H' . ($i + 5), $datos[$i]['tg4']);
            $activeSheet->setCellValue('I' . ($i + 5), $datos[$i]['promedioaguinaldo']);
            $activeSheet->getStyle('I' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->setCellValue('J' . ($i + 5), $datos[$i]['promedioindemnizacion']);
            $activeSheet->getStyle('J' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->setCellValue('K' . ($i + 5), $datos[$i]['fechauia']);
            $primer = round($datos[$i]['factorprimeraguinaldo'] * $datos[$i]['promedioaguinaldo'], 2);
            $segundo = round($datos[$i]['factorsegundoaguinaldo'] * $datos[$i]['promedioaguinaldo'], 2);
            $inde = round($datos[$i]['factor'] * $datos[$i]['promedioindemnizacion'], 2);
            if($datos[$i]['cancelacionporretiro']==true){
                if($planillaactual[0]['bindemnizacion']!=0){
                    $totalindemnizacionpagada+=$inde;}
                if($planillaactual[0]['bprimeraguinaldo']!=0){
                   $totalprimeraguinaldopagado+=$primer;  
                }
               if( $datos[$i]['consegundoaguinaldo']==true ){
                   $totalsegundoaguinaldopagado+=$segundo;
               
               
               }
            }
            $activeSheet->setCellValue('L' . ($i + 5), $datos[$i]['factor']);
            $activeSheet->getStyle('M' . ($i + 5))->getNumberFormat();
            $activeSheet->getStyle('N' . ($i + 5))->getNumberFormat();
            $activeSheet->getStyle('O' . ($i + 5))->getNumberFormat();
            $activeSheet->getStyle('Q' . ($i + 5))->getNumberFormat();
            $activeSheet->setCellValue('M' . ($i + 5), $inde);
            $activeSheet->setCellValue('N' . ($i + 5), $datos[$i]['factorprimeraguinaldo']);
            $activeSheet->getStyle('O' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->setCellValue('O' . ($i + 5), $primer);
            $activeSheet->setCellValue('P' . ($i + 5), $datos[$i]['factorsegundoaguinaldo']);
            $activeSheet->setCellValue('Q' . ($i + 5), $segundo);
        }
        $activeSheet->getStyle('M' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('M' . ($i + 5), '=SUM(M4:M' . ($i + 4) . ')');
        $activeSheet->getStyle('O' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('O' . ($i + 5), '=SUM(O4:O' . ($i + 4) . ')');
        $activeSheet->getStyle('Q' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('Q' . ($i + 5), '=SUM(Q4:Q' . ($i + 4) . ')');
        $activeSheet->getStyle('M' . ($i + 5))->applyFromArray($phpFontC);
        $activeSheet->getStyle('O' . ($i + 5))->applyFromArray($phpFontC);
        $activeSheet->getStyle('Q' . ($i + 5))->applyFromArray($phpFontC);
        $activeSheet->mergeCells('A' . ($i + 5) . ':I' . ($i + 5));
        $activeSheet->getStyle('L' . ($i + 5))->getFont()->setBold(true);
        $activeSheet->getStyle('L' . ($i + 6))->getFont()->setBold(true);
        $activeSheet->getStyle('L' . ($i + 7))->getFont()->setBold(true);
        $activeSheet->getStyle('L' . ($i + 8))->getFont()->setBold(true);
        $activeSheet->setCellValue('L' . ($i + 5), 'TOTAL');
        $activeSheet->setCellValue('L' . ($i + 6), 'SALDO CUENTA');
        $activeSheet->setCellValue('L' . ($i + 7), 'CANCELADO');
        $activeSheet->getStyle('M' . ($i + 6))->getNumberFormat()->setFormatCode('0.00');
         $activeSheet->getStyle('M' . ($i + 7))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('M' . ($i + 6), $planillaactual[0]['bindemnizacion']);
        $activeSheet->setCellValue('M' . ($i + 7), $totalindemnizacionpagada);
        $activeSheet->setCellValue('L' . ($i + 8), 'DIFERENCIA');
        $activeSheet->getStyle('M' . ($i + 7))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('M' . ($i + 8), '=M' . ($i + 5) . '-M' . ($i + 6).'-'.$totalindemnizacionpagada);
        $activeSheet->getStyle('N' . ($i + 5))->getFont()->setBold(true);
        $activeSheet->getStyle('N' . ($i + 6))->getFont()->setBold(true);
        $activeSheet->getStyle('N' . ($i + 7))->getFont()->setBold(true);
        $activeSheet->getStyle('N' . ($i + 8))->getFont()->setBold(true);
        $activeSheet->setCellValue('N' . ($i + 5), 'TOTAL');
        $activeSheet->setCellValue('N' . ($i + 6), 'SALDO CUENTA');
        $activeSheet->setCellValue('N' . ($i + 7), 'CANCELADO');
         $activeSheet->setCellValue('N' . ($i + 8), 'DIFERENCIA');
        $activeSheet->getStyle('O' . ($i + 6))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('O' . ($i + 6), $planillaactual[0]['bprimeraguinaldo']);
         $activeSheet->setCellValue('O' . ($i + 7), $totalprimeraguinaldopagado);
        $activeSheet->setCellValue('O' . ($i + 8), 'DIFERENCIA');
        $activeSheet->getStyle('O' . ($i + 7))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('O' . ($i + 8), '=O' . ($i + 5) . '-O' . ($i + 6).'-'.$totalprimeraguinaldopagado);
        $activeSheet->getStyle('P' . ($i + 5))->getFont()->setBold(true);
        $activeSheet->getStyle('P' . ($i + 6))->getFont()->setBold(true);
        $activeSheet->getStyle('P' . ($i + 7))->getFont()->setBold(true);
        $activeSheet->getStyle('P' . ($i + 8))->getFont()->setBold(true);

        $activeSheet->setCellValue('P' . ($i + 5), 'TOTAL');
        $activeSheet->setCellValue('P' . ($i + 6), 'SALDO CUENTA');
        $activeSheet->setCellValue('P' . ($i + 7), 'CANCELADO');
        $activeSheet->setCellValue('P' . ($i + 8), 'DIFERENCIA');
        $activeSheet->getStyle('Q' . ($i + 6))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('Q' . ($i + 7))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('Q' . ($i + 6), $planillaactual[0]['bsegundoaguinaldo']);
        $activeSheet->setCellValue('Q' . ($i + 7),$totalsegundoaguinaldopagado);
        $activeSheet->getStyle('Q' . ($i + 7))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('Q' . ($i + 8), '=Q' . ($i + 5) . '-Q' . ($i + 6).'-'.$totalsegundoaguinaldopagado);
    
        ///////////////////////////
        $this->descargarExcel($objPHPExcel, $nombreArchivo);
    }
    /**
     * 
     * @param integer $p_idplanilla, id de la planilla
     * @param integer $p_idtipoindemnizacion, id de la indemnizacion, posible valores 20=Indemnizacion y 34= indemnizacion litigio
     * retorna planilla de calculo de Indemnizacion para cualquier mes ,menos Diciembre
     */
    public function DescargarIndemnizacionAguinaldosMes($p_idplanilla, $p_idtipoindemnizacion) {

        $planillaactual=  Yii::app()->rrhh
                ->createCommand("select id,mes,anio,to_char(fechadesde,'DD-MM-YYYY') as fechadesde,to_char(fechahasta,'DD-MM-YYYY') as fechahasta,case when bindemnizacion is null then null  else ( select(json_array_elements(bindemnizacion)->>'$p_idtipoindemnizacion')::numeric(12,2)from planilla where id=$p_idplanilla) end as bindemnizacion ,
        case when  bprimeraguinaldo is null then null else ( select(json_array_elements(bprimeraguinaldo)->>'$p_idtipoindemnizacion')::numeric(12,2)from planilla where id=$p_idplanilla) end as bprimeraguinaldo,
        case when bsegundoaguinaldo is null then  null else ( select(json_array_elements(bsegundoaguinaldo)->>'$p_idtipoindemnizacion')::numeric(12,2)from planilla where id=$p_idplanilla) end as bsegundoaguinaldo 
        from planilla  where  id=$p_idplanilla")
                ->queryAll();
       $conRetroactivo = Yii::app()->rrhh
                ->createCommand("select case  when mesfin=".$planillaactual[0]['mes']."  then true else false end from planillaretroactivo where eliminado=false and anio=".$planillaactual[0]['anio'])
                ->queryScalar();
        $listaplanillas = Yii::app()->rrhh
                ->createCommand("select id,mes,to_char(fechadesde,'DD/MM/YYYY') as fechadesde,to_char(fechahasta,'DD/MM/YYYY') as fechahasta         
        from planilla  where eliminado=false and id<=$p_idplanilla order by id desc limit 3")
                ->queryAll();
      // if ($conRetroactivo==true){
             $datos = Yii::app()->rrhh
                ->createCommand("select t.id, t.nombrearea, t.factor,t.empleado,to_char(t.fechauia::date,'dd/mm/YYYY')AS fechauia ,t.factorprimeraguinaldo,t.factorsegundoaguinaldo,t.tg1,t.tg2,t.tg3,((case when t.tg1retroactivo is null or tg1=0 then 0 else t.tg1retroactivo  end )+t.tg1) as tg1conretroactivo,( (case when t.tg2retroactivo is null or tg2=0 then 0 else t.tg2retroactivo end  )+t.tg2) as tg2conretroactivo,(t.tg3retroactivo+t.tg3) as tg3conretroactivo,

t.promedio,(t.promedio+(( (case when t.tg1retroactivo is null or tg1=0 then 0 else t.tg1retroactivo end)+( case when tg2retroactivo is null or tg2=0 then 0 else t.tg2retroactivo end)+tg3retroactivo)::numeric/t.factorpromedio)::numeric(12,2)) as promedioconretroactivo,CASE WHEN t.cancelacionporretiro= false then 'Sin Cancelar' else 'Cancelado' end as estado,t.cancelacionporretiro ,t.factorpromedio,case when t.novedad='R' then (select pb.consegundoaguinaldo from general.historialestadoempleado hee inner join general.pagobeneficio pb on pb.idhistorialestadoempleado=hee.id
 where pb.eliminado=false and hee.eliminado=false and pb.idtipopagobeneficio=2 and   hee.idempleado=t.idempleado order by hee.id desc limit 1) else false end  as consegundoaguinaldo  from 
 (select c.id,c.idempleado,  a.nombre as nombrearea, (json_array_elements(c.general)->>'factor') as factor,(json_array_elements(c.general)->>'novedad') as novedad,(json_array_elements(c.general)->>'nombrec') as empleado,(json_array_elements(c.general)->>'fechaultidemnizacion')::date as fechauia,(json_array_elements(c.informacionindemnizacionaguinaldo)->>'PRIMERAGUINALDO') AS factorprimeraguinaldo,(json_array_elements(c.informacionindemnizacionaguinaldo)->>'SEGUNDOAGUINALDO') as factorsegundoaguinaldo  ,(json_array_elements(c.informacionindemnizacionaguinaldo)->>'totalganado1')::numeric(12,2) AS tg1  ,(json_array_elements(c.informacionindemnizacionaguinaldo)->>'totalganado2')::numeric(12,2) AS tg2 ,(json_array_elements(c.informacionindemnizacionaguinaldo)->>'totalganado3')::numeric(12,2) AS tg3 ,(json_array_elements(c.informacionindemnizacionaguinaldo)->>'promedio')::numeric(12,2) AS promedio    ,

        (json_array_elements(c.general)->>'fechanovedad') as fnovedad ,c.cancelacionporretiro,
         (json_array_elements(c.informacionindemnizacionaguinaldo)->>'factorpromedio')::numeric(12,2) as factorpromedio,
         (
select (json_array_elements(informacionretroactivo)->>'totalga')::numeric(12,2) as tg1retroactivo from cuerpo where eliminado=false and idempleado=c.idempleado and idplanilla=".$listaplanillas[2]['id']."),
(
select (json_array_elements(informacionretroactivo)->>'totalga')::numeric(12,2) as tg2retroactivo from cuerpo where eliminado=false and idempleado=c.idempleado and idplanilla=".$listaplanillas[1]['id']."),
(
select (json_array_elements(informacionretroactivo)->>'totalga')::numeric(12,2) as tg3retroactivo from cuerpo where eliminado=false and idempleado=c.idempleado and idplanilla=".$listaplanillas[0]['id'].")
         from cuerpo c inner join general.area a on a.id=c.area 
        where c.eliminado=false and c.enplanillaindemnizacion=true and idplanilla=$p_idplanilla  and c.idtipocontrato in( select abtc.idtipocontrato from general.aporbetipocont abtc inner join general.aportacionbeneficio ab on ab.id=abtc.idaportacionbeneficio where 
        abtc.eliminado=false and ab.id=$p_idtipoindemnizacion)   ) t order by id asc  ")
                ->queryAll();
       
        $nombreArchivo = 'CIA_' . $planillaactual[0]['fechadesde'] . '_' . $planillaactual[0]['fechahasta'];
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->removeSheetByIndex(0);
        $objPHPExcel->createSheet(0);
        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $activeSheet->setTitle($nombreArchivo);
        $activeSheet->getDefaultColumnDimension()->setWidth(14);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $phpFont = array('font' => array(
                'size' => 8,
                'name' => 'Times New Roman',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
        );
        $phpFontP = array('font' => array(
                'size' => 14,
                'name' => 'Times New Roman',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'font' => array(
                'bold' => true,)
        );

        $phpFontC = array(
            'font' => array(
                'bold' => true,
            )
        );
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);

        $activeSheet->getColumnDimension('A')->setWidth(10);
        $activeSheet->getColumnDimension('B')->setWidth(40);
        $activeSheet->getColumnDimension('C')->setWidth(40);
        $activeSheet->getColumnDimension('D')->setWidth(13);
        $activeSheet->getColumnDimension('E')->setWidth(13);
        $activeSheet->getColumnDimension('F')->setWidth(13);
        $activeSheet->getColumnDimension('G')->setWidth(13);
        $activeSheet->getColumnDimension('H')->setWidth(13);
        $activeSheet->getColumnDimension('I')->setWidth(13);
        $activeSheet->getColumnDimension('J')->setWidth(13);
        $activeSheet->getColumnDimension('K')->setWidth(13);
        $activeSheet->getColumnDimension('L')->setWidth(13);
        $activeSheet->getColumnDimension('M')->setWidth(13);
        $activeSheet->getColumnDimension('N')->setWidth(13);
        $activeSheet->getColumnDimension('O')->setWidth(13);
        $activeSheet->getColumnDimension('P')->setWidth(13);
        $activeSheet->getColumnDimension('Q')->setWidth(13);
        $activeSheet->getColumnDimension('R')->setWidth(13);
        $activeSheet->getColumnDimension('S')->setWidth(13);
        $activeSheet->getColumnDimension('T')->setWidth(13);
        $activeSheet->getColumnDimension('U')->setWidth(13);
        $activeSheet->getColumnDimension('V')->setWidth(13);
        $activeSheet->getColumnDimension('W')->setWidth(13);
        $activeSheet->getColumnDimension('X')->setWidth(13);

        $activeSheet->getStyle("A1")->applyFromArray($phpFontP);
        $activeSheet->getStyle("A2")->applyFromArray($phpFontP);
        $activeSheet->getStyle("J3")->applyFromArray($phpFontC);
        $activeSheet->getStyle("L3")->applyFromArray($phpFontC);
        $activeSheet->getStyle("N3")->applyFromArray($phpFontC);
        $activeSheet->getStyle("O3")->applyFromArray($phpFontC);
        $activeSheet->getStyle("A4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("B4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("C4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("D4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("E4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("F4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("G4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("H4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("I4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("J4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("K4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("L4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("M4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("N4")->applyFromArray($phpFontC);
        $activeSheet->getStyle("O4")->applyFromArray($phpFontC);

        $activeSheet->mergeCells('A1:N1');
        $activeSheet->mergeCells('A2:N2');
        $activeSheet->setCellValue('A1', 'PLANILLA DE PREVISION DE INDEMNIZACION Y AGUINALDOS');
        $activeSheet->setCellValue('A2', '(al ' . $listaplanillas[0]['fechahasta'] . ')');
        $activeSheet->mergeCells('J3:K3');
        $activeSheet->mergeCells('A3:H3');
        $activeSheet->setCellValue('J3', 'INDEMNIZACION');
        $activeSheet->mergeCells('L3:M3');
        $activeSheet->setCellValue('L3', 'PRIMER AGUINALDO');
        $activeSheet->mergeCells('N3:O3');
        $activeSheet->setCellValue('N3', 'SEGUNDO AGUINALDO');
        $activeSheet->setCellValue('A4', 'Nº');
        $activeSheet->setCellValue('B4', 'EMPLEADO');
        $activeSheet->setCellValue('C4', 'AREA');
        $activeSheet->setCellValue('D4', 'ESTADO');

        $mes = strtoupper(strftime("%B", DateTime::createFromFormat('!m', $listaplanillas[2]['mes'])->getTimestamp()));
        $activeSheet->setCellValue('E4', $mes);
        $mes = strtoupper(strftime("%B", DateTime::createFromFormat('!m', $listaplanillas[1]['mes'])->getTimestamp()));
        $activeSheet->setCellValue('F4', $mes);
        $mes = strtoupper(strftime("%B", DateTime::createFromFormat('!m', $listaplanillas[0]['mes'])->getTimestamp()));
        $activeSheet->setCellValue('G4', $mes);
        $activeSheet->setCellValue('H4', 'PROMEDIO');
        $activeSheet->setCellValue('I4', 'FECHA ULTIMA INDEMNIZACION-AGUINALDOS');
        $activeSheet->setCellValue('J4', 'FACTOR');
        $activeSheet->setCellValue('K4', 'TOTAL');
        $activeSheet->setCellValue('L4', 'FACTOR');
        $activeSheet->setCellValue('M4', 'TOTAL');
        $activeSheet->setCellValue('N4', 'FACTOR');
        $activeSheet->setCellValue('O4', 'TOTAL');
        //cod , empleado ,cargo  ,tg1 ,tg2 ,tg3 ,factor ,dia ,mes ,anio 
        $cant = count($datos);
        $totalindemnizacionpagada=0;
        $totalprimeraguinaldopagado=0;
        $totalsegundoaguinaldopagado=0;
        for ($i = 0; $i < $cant; $i++) {

            $activeSheet->setCellValue('A' . ($i + 5), ($i + 1));
            $activeSheet->setCellValue('B' . ($i + 5), $datos[$i]['empleado']);
            $activeSheet->setCellValue('C' . ($i + 5), $datos[$i]['nombrearea']);
            $activeSheet->setCellValue('D' . ($i + 5), $datos[$i]['estado']);     
            

            $activeSheet->getStyle('E' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('F' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('G' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->setCellValue('E' . ($i + 5), $datos[$i]['tg1']);
            $activeSheet->setCellValue('F' . ($i + 5), $datos[$i]['tg2']);
            $activeSheet->setCellValue('G' . ($i + 5), $datos[$i]['tg3']);
            $activeSheet->setCellValue('H' . ($i + 5), $datos[$i]['promedio']);
            $activeSheet->getStyle('H' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->setCellValue('I' . ($i + 5), $datos[$i]['fechauia']);
            $primer = round($datos[$i]['factorprimeraguinaldo'] * $datos[$i]['promedio'], 2);
            $segundo = round($datos[$i]['factorsegundoaguinaldo'] * $datos[$i]['promedio'], 2);
            $inde = round($datos[$i]['factor'] * $datos[$i]['promedio'], 2);
            if($datos[$i]['cancelacionporretiro']==true){
                 if($planillaactual[0]['bindemnizacion']!=0){
                    $totalindemnizacionpagada+=$inde;}
                if($planillaactual[0]['bprimeraguinaldo']!=0){
                   $totalprimeraguinaldopagado+=$primer;  
                }
               if( $datos[$i]['consegundoaguinaldo']==true){
                   $totalsegundoaguinaldopagado+=$segundo;
               
               
               }
               
            }
            $activeSheet->setCellValue('J' . ($i + 5), $datos[$i]['factor']);
            $activeSheet->getStyle('K' . ($i + 5))->getNumberFormat();
            $activeSheet->getStyle('L' . ($i + 5))->getNumberFormat();
            $activeSheet->getStyle('M' . ($i + 5))->getNumberFormat();
            $activeSheet->setCellValue('K' . ($i + 5), $inde);

            $activeSheet->setCellValue('L' . ($i + 5), $datos[$i]['factorprimeraguinaldo']);
            $activeSheet->getStyle('M' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->setCellValue('M' . ($i + 5), $primer);
            $activeSheet->setCellValue('N' . ($i + 5), $datos[$i]['factorsegundoaguinaldo']);
            $activeSheet->getStyle('N' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->setCellValue('O' . ($i + 5), $segundo);
        }
        $activeSheet->getStyle('K' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('K' . ($i + 5), '=SUM(K4:K' . ($i + 4) . ')');
        $activeSheet->getStyle('M' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('M' . ($i + 5), '=SUM(M4:M' . ($i + 4) . ')');
        $activeSheet->getStyle('O' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('O' . ($i + 5), '=SUM(O4:O' . ($i + 4) . ')');
        $activeSheet->getStyle('K' . ($i + 5))->applyFromArray($phpFontC);
        $activeSheet->getStyle('M' . ($i + 5))->applyFromArray($phpFontC);
        $activeSheet->getStyle('O' . ($i + 5))->applyFromArray($phpFontC);
        $activeSheet->mergeCells('A' . ($i + 5) . ':I' . ($i + 5));
        $activeSheet->getStyle('J' . ($i + 5))->getFont()->setBold(true);
        $activeSheet->getStyle('J' . ($i + 6))->getFont()->setBold(true);
        $activeSheet->getStyle('J' . ($i + 7))->getFont()->setBold(true);
        $activeSheet->getStyle('J' . ($i + 8))->getFont()->setBold(true);
        $activeSheet->setCellValue('J' . ($i + 5), 'TOTAL');
        $activeSheet->setCellValue('J' . ($i + 6), 'SALDO CUENTA');
        $activeSheet->setCellValue('J' . ($i + 7), 'CANCELADO');
        $activeSheet->getStyle('K' . ($i + 6))->getNumberFormat()->setFormatCode('0.00');
         $activeSheet->getStyle('K' . ($i + 7))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('K' . ($i + 6), $planillaactual[0]['bindemnizacion']);
        $activeSheet->setCellValue('K' . ($i + 7), $totalindemnizacionpagada);
        $activeSheet->setCellValue('J' . ($i + 8), 'DIFERENCIA');
        $activeSheet->getStyle('K' . ($i + 7))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('K' . ($i + 8), '=K' . ($i + 5) . '-K' . ($i + 6).'-'.$totalindemnizacionpagada);
        $activeSheet->getStyle('L' . ($i + 5))->getFont()->setBold(true);
        $activeSheet->getStyle('L' . ($i + 6))->getFont()->setBold(true);
        $activeSheet->getStyle('L' . ($i + 7))->getFont()->setBold(true);
        $activeSheet->getStyle('L' . ($i + 8))->getFont()->setBold(true);
        $activeSheet->setCellValue('L' . ($i + 5), 'TOTAL');
        $activeSheet->setCellValue('L' . ($i + 6), 'SALDO CUENTA');
        $activeSheet->setCellValue('L' . ($i + 7), 'CANCELADO');
         $activeSheet->setCellValue('L' . ($i + 8), 'DIFERENCIA');
        $activeSheet->getStyle('M' . ($i + 6))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('M' . ($i + 6), $planillaactual[0]['bprimeraguinaldo']);
         $activeSheet->setCellValue('M' . ($i + 7), $totalprimeraguinaldopagado);
        $activeSheet->setCellValue('M' . ($i + 8), 'DIFERENCIA');
        $activeSheet->getStyle('M' . ($i + 7))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('M' . ($i + 8), '=M' . ($i + 5) . '-M' . ($i + 6).'-'.$totalprimeraguinaldopagado);
        $activeSheet->getStyle('N' . ($i + 5))->getFont()->setBold(true);
        $activeSheet->getStyle('N' . ($i + 6))->getFont()->setBold(true);
        $activeSheet->getStyle('N' . ($i + 7))->getFont()->setBold(true);
        $activeSheet->getStyle('N' . ($i + 8))->getFont()->setBold(true);

        $activeSheet->setCellValue('N' . ($i + 5), 'TOTAL');
        $activeSheet->setCellValue('N' . ($i + 6), 'SALDO CUENTA');
        $activeSheet->setCellValue('N' . ($i + 7), 'CANCELADO');
        $activeSheet->setCellValue('N' . ($i + 8), 'DIFERENCIA');
        $activeSheet->getStyle('O' . ($i + 6))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('O' . ($i + 7))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('O' . ($i + 6), $planillaactual[0]['bsegundoaguinaldo']);
        $activeSheet->setCellValue('O' . ($i + 7),$totalsegundoaguinaldopagado);
        
        $activeSheet->getStyle('O' . ($i + 7))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('O' . ($i + 8), '=O' . ($i + 5) . '-O' . ($i + 6).'-'.$totalsegundoaguinaldopagado);
        
        if($conRetroactivo==true){
                $objPHPExcel->createSheet(1);        
                $activeSheet = $objPHPExcel->setActiveSheetIndex(1);

                $activeSheet ->getPageSetup()
                        ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
                $activeSheet 
                        ->getPageSetup()
                        ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);
                $activeSheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1,6);   
                $activeSheet->setTitle('Indemnizacion con Incremento');
                $activeSheet->getDefaultColumnDimension()->setWidth(9.7);
                $activeSheet->getStyle("A4:V4")->getAlignment()->setWrapText(true);
                $activeSheet->getRowDimension(4)->setRowHeight(30);
        $activeSheet->getColumnDimension('A')->setWidth(10);
        $activeSheet->getColumnDimension('B')->setWidth(40);
        $activeSheet->getColumnDimension('C')->setWidth(40);
        $activeSheet->getColumnDimension('D')->setWidth(13);
        $activeSheet->getColumnDimension('E')->setWidth(13);
        $activeSheet->getColumnDimension('F')->setWidth(13);
        $activeSheet->getColumnDimension('G')->setWidth(13);
        $activeSheet->getColumnDimension('H')->setWidth(13);
        $activeSheet->getColumnDimension('I')->setWidth(13);
        $activeSheet->getColumnDimension('J')->setWidth(13);
        $activeSheet->getColumnDimension('K')->setWidth(13);
        $activeSheet->getColumnDimension('L')->setWidth(13);
        $activeSheet->getColumnDimension('M')->setWidth(13);
        $activeSheet->getColumnDimension('N')->setWidth(13);
        $activeSheet->getColumnDimension('O')->setWidth(13);
        $activeSheet->getColumnDimension('P')->setWidth(13);
        $activeSheet->getColumnDimension('Q')->setWidth(13);
        $activeSheet->getColumnDimension('R')->setWidth(13);
        $activeSheet->getColumnDimension('S')->setWidth(13);
        $activeSheet->getColumnDimension('T')->setWidth(13);
        $activeSheet->getColumnDimension('U')->setWidth(13);
        $activeSheet->getColumnDimension('V')->setWidth(13);
        $activeSheet->getColumnDimension('W')->setWidth(13);
        $activeSheet->getColumnDimension('X')->setWidth(13);

        $activeSheet->getStyle("A1")->applyFromArray($phpFontP);
        $activeSheet->getStyle("A2")->applyFromArray($phpFontP);
        $activeSheet->getStyle("Q3")->applyFromArray($phpFontC);
        $activeSheet->getStyle("T3")->applyFromArray($phpFontC);
        $activeSheet->getStyle("N3")->applyFromArray($phpFontC);
        $activeSheet->getStyle("O3")->applyFromArray($phpFontC);
        $activeSheet->getStyle("A4:V4")->applyFromArray($phpFontC);
      

        $activeSheet->mergeCells('A1:N1');
        $activeSheet->mergeCells('A2:N2');
        $activeSheet->setCellValue('A1', 'PLANILLA DE PREVISION DE INDEMNIZACION Y AGUINALDOS CON INCREMENTO');
        $activeSheet->setCellValue('A2', '(al ' . $listaplanillas[0]['fechahasta'] . ')');
        $activeSheet->mergeCells('N3:P3');
        $activeSheet->mergeCells('A3:H3');
        $activeSheet->setCellValue('N3', 'INDEMNIZACION');
        $activeSheet->mergeCells('Q3:S3');
        $activeSheet->setCellValue('Q3', 'PRIMER AGUINALDO');
        $activeSheet->mergeCells('T3:V3');
        $activeSheet->setCellValue('T3', 'SEGUNDO AGUINALDO');
        $activeSheet->setCellValue('A4', 'Nº');
        $activeSheet->setCellValue('B4', 'EMPLEADO');
        $activeSheet->setCellValue('C4', 'AREA');
        $activeSheet->setCellValue('D4', 'ESTADO');

        $mes = strtoupper(strftime("%B", DateTime::createFromFormat('!m', $listaplanillas[2]['mes'])->getTimestamp()));
        $activeSheet->setCellValue('E4', $mes);
        $activeSheet->setCellValue('F4', $mes.' CON INCREMENTO');        
        $mes = strtoupper(strftime("%B", DateTime::createFromFormat('!m', $listaplanillas[1]['mes'])->getTimestamp()));
        $activeSheet->setCellValue('G4', $mes);
        $activeSheet->setCellValue('H4', $mes.' CON INCREMENTO');
        $mes = strtoupper(strftime("%B", DateTime::createFromFormat('!m', $listaplanillas[0]['mes'])->getTimestamp()));
        
        $activeSheet->setCellValue('I4', $mes);
        $activeSheet->setCellValue('J4', $mes.' CON INCREMENTO');
        $activeSheet->setCellValue('K4', 'PROMEDIO');
        $activeSheet->setCellValue('L4', 'PROMEDIO CON INCREMENTO ');
        $activeSheet->setCellValue('M4', 'FECHA ULTIMA INDEMNIZACION-AGUINALDOS');
        $activeSheet->setCellValue('N4', 'FACTOR');
        $activeSheet->setCellValue('O4', 'TOTAL');
        $activeSheet->setCellValue('P4', 'TOTAL CON INCREMENTO');
        $activeSheet->setCellValue('Q4', 'FACTOR');
        $activeSheet->setCellValue('R4', 'TOTAL');
        $activeSheet->setCellValue('S4', 'TOTAL CON INCREMENTO');
        $activeSheet->setCellValue('T4', 'FACTOR');
        $activeSheet->setCellValue('U4', 'TOTAL');
        $activeSheet->setCellValue('V4', 'TOTAL CON INCREMENTO');
        //cod , empleado ,cargo  ,tg1 ,tg2 ,tg3 ,factor ,dia ,mes ,anio 
      
        $totalindemnizacionpagada=0;
        $totalprimeraguinaldopagado=0;
        $totalsegundoaguinaldopagado=0;
        $totalindemnizacionpagadaR=0;
        $totalprimeraguinaldopagadoR=0;
        $totalsegundoaguinaldopagadoR=0;
        for ($i = 0; $i < $cant; $i++) {

            $activeSheet->setCellValue('A' . ($i + 5), ($i + 1));
            $activeSheet->setCellValue('B' . ($i + 5), $datos[$i]['empleado']);
            $activeSheet->setCellValue('C' . ($i + 5), $datos[$i]['nombrearea']);
            $activeSheet->setCellValue('D' . ($i + 5), $datos[$i]['estado']);     
            

            $activeSheet->getStyle('E' . ($i + 5).':L'.($i + 5))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('O' . ($i + 5).':P'.($i + 5))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('R' . ($i + 5).':S'.($i + 5))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('U' . ($i + 5).':V'.($i + 5))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->setCellValue('E' . ($i + 5), $datos[$i]['tg1']);
            $activeSheet->setCellValue('F' . ($i + 5), $datos[$i]['tg1conretroactivo']);
            $activeSheet->setCellValue('G' . ($i + 5), $datos[$i]['tg2']);
            $activeSheet->setCellValue('H' . ($i + 5), $datos[$i]['tg2conretroactivo']);
            $activeSheet->setCellValue('I' . ($i + 5), $datos[$i]['tg3']);
            $activeSheet->setCellValue('J' . ($i + 5), $datos[$i]['tg3conretroactivo']);
            $activeSheet->setCellValue('K' . ($i + 5), $datos[$i]['promedio']);
            $activeSheet->setCellValue('L' . ($i + 5), $datos[$i]['promedioconretroactivo']);
            $activeSheet->setCellValue('M' . ($i + 5), $datos[$i]['fechauia']);
            $primer = round($datos[$i]['factorprimeraguinaldo'] * $datos[$i]['promedio'], 2);
            $segundo = round($datos[$i]['factorsegundoaguinaldo'] * $datos[$i]['promedio'], 2);
            $inde = round($datos[$i]['factor'] * $datos[$i]['promedio'], 2);
            $primerR = round($datos[$i]['factorprimeraguinaldo'] * $datos[$i]['promedioconretroactivo'], 2);
            $segundoR = round($datos[$i]['factorsegundoaguinaldo'] * $datos[$i]['promedioconretroactivo'], 2);
            $indeR = round($datos[$i]['factor'] * $datos[$i]['promedioconretroactivo'], 2);
            if($datos[$i]['cancelacionporretiro']==true){
                 if($planillaactual[0]['bindemnizacion']!=0){
                    $totalindemnizacionpagada+=$inde;
                    $totalindemnizacionpagadaR+=$indeR;
                    
                 }
                if($planillaactual[0]['bprimeraguinaldo']!=0){
                   $totalprimeraguinaldopagado+=$primer;  
                   $totalprimeraguinaldopagadoR+=$primerR;  
                }
               if( $datos[$i]['consegundoaguinaldo']==true){
                   $totalsegundoaguinaldopagado+=$segundo;
                   $totalsegundoaguinaldopagadoR+=$segundoR;
               
               
               }
               
            }
            $activeSheet->setCellValue('N' . ($i + 5), $datos[$i]['factor']);
            $activeSheet->getStyle('O' . ($i + 5))->getNumberFormat();
            $activeSheet->getStyle('L' . ($i + 5))->getNumberFormat();
            $activeSheet->getStyle('M' . ($i + 5))->getNumberFormat();
            $activeSheet->setCellValue('O' . ($i + 5), $inde);
            $activeSheet->setCellValue('P' . ($i + 5), $indeR);

            $activeSheet->setCellValue('Q' . ($i + 5), $datos[$i]['factorprimeraguinaldo']);
            $activeSheet->getStyle('M' . ($i + 5))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->setCellValue('R' . ($i + 5), $primer);
            $activeSheet->setCellValue('S' . ($i + 5), $primerR);
            $activeSheet->setCellValue('T' . ($i + 5), $datos[$i]['factorsegundoaguinaldo']);
            $activeSheet->setCellValue('U' . ($i + 5), $segundo);
            $activeSheet->setCellValue('V' . ($i + 5), $segundoR);
        }
        $activeSheet->getStyle('O' . ($i + 5).':P'.($i + 5))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('O' . ($i + 5), '=SUM(O4:O' . ($i + 4) . ')');
        $activeSheet->setCellValue('P' . ($i + 5), '=SUM(P4:P' . ($i + 4) . ')');
        $activeSheet->getStyle('R' . ($i + 5).':S'.($i + 5))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('R' . ($i + 5), '=SUM(R4:R' . ($i + 4) . ')');
        $activeSheet->setCellValue('S' . ($i + 5), '=SUM(S4:S' . ($i + 4) . ')');
        $activeSheet->getStyle('U' . ($i + 5).':V'.($i + 5))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('U' . ($i + 5), '=SUM(U4:U' . ($i + 4) . ')');
        $activeSheet->setCellValue('V' . ($i + 5), '=SUM(V4:V' . ($i + 4) . ')');
        $activeSheet->getStyle('O' . ($i + 5).':P'.($i + 5))->applyFromArray($phpFontC);
        $activeSheet->getStyle('R' . ($i + 5).':S'.($i + 5))->applyFromArray($phpFontC);
        $activeSheet->getStyle('U' . ($i + 5).':V'.($i + 5))->applyFromArray($phpFontC);
        $activeSheet->mergeCells('A' . ($i + 5) . ':M' . ($i + 5));
        $activeSheet->getStyle('N' . ($i + 5))->getFont()->setBold(true);
        $activeSheet->getStyle('N' . ($i + 6))->getFont()->setBold(true);
        $activeSheet->getStyle('N' . ($i + 7))->getFont()->setBold(true);
        $activeSheet->getStyle('N' . ($i + 8))->getFont()->setBold(true);
        $activeSheet->getStyle('N' . ($i + 9))->getFont()->setBold(true);
        $activeSheet->setCellValue('N' . ($i + 5), 'TOTAL');
        $activeSheet->setCellValue('N' . ($i + 6), 'SALDO CUENTA');
        $activeSheet->setCellValue('N' . ($i + 7), 'CANCELADO');
        $activeSheet->setCellValue('N' . ($i + 8), 'DIFERENCIA');
        $activeSheet->setCellValue('N' . ($i + 9), 'AJUSTE');
        $activeSheet->getStyle('O' . ($i + 6).':P'.($i+6))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('O' . ($i + 7).':P'.($i+7))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('O' . ($i + 8).':P'.($i+8))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('O' . ($i + 6), $planillaactual[0]['bindemnizacion']);
        $activeSheet->setCellValue('P' . ($i + 6), $planillaactual[0]['bindemnizacion']);
        $activeSheet->setCellValue('O' . ($i + 7), $totalindemnizacionpagada); 
        $activeSheet->setCellValue('P' . ($i + 7), $totalindemnizacionpagadaR); 
        $activeSheet->setCellValue('O' . ($i + 8), '=O' . ($i + 5) . '-O' . ($i + 6).'-'.$totalindemnizacionpagada);
        $activeSheet->setCellValue('P' . ($i + 8), '=P' . ($i + 5) . '-P' . ($i + 6).'-'.$totalindemnizacionpagadaR);
        $activeSheet->setCellValue('P' . ($i + 9), '=P' . ($i + 8) . '-O' . ($i + 8));
        
        
        $activeSheet->getStyle('Q' . ($i + 5))->getFont()->setBold(true);
        $activeSheet->getStyle('Q' . ($i + 6))->getFont()->setBold(true);
        $activeSheet->getStyle('Q' . ($i + 7))->getFont()->setBold(true);
        $activeSheet->getStyle('Q' . ($i + 8))->getFont()->setBold(true);
        $activeSheet->getStyle('Q' . ($i + 9))->getFont()->setBold(true);
        $activeSheet->setCellValue('Q' . ($i + 5), 'TOTAL');
        $activeSheet->setCellValue('Q' . ($i + 6), 'SALDO CUENTA');
        $activeSheet->setCellValue('Q' . ($i + 7), 'CANCELADO');
        $activeSheet->setCellValue('Q' . ($i + 8), 'DIFERENCIA');
        $activeSheet->setCellValue('Q' . ($i + 9), 'AJUSTE');
        $activeSheet->getStyle('R' . ($i + 6).':S'.($i+6))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('R' . ($i + 6), $planillaactual[0]['bprimeraguinaldo']);
        $activeSheet->setCellValue('S' . ($i + 6), $planillaactual[0]['bprimeraguinaldo']);
        $activeSheet->setCellValue('R' . ($i + 7), $totalprimeraguinaldopagado);
        $activeSheet->getStyle('R' . ($i + 7))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('R' . ($i + 8), '=R' . ($i + 5) . '-R' . ($i + 6).'-'.$totalprimeraguinaldopagado);
        
        $activeSheet->setCellValue('S' . ($i + 7), $totalprimeraguinaldopagadoR);
        $activeSheet->getStyle('S' . ($i + 7))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('S' . ($i + 8), '=S' . ($i + 5) . '-S' . ($i + 6).'-'.$totalprimeraguinaldopagadoR);
        $activeSheet->setCellValue('S' . ($i + 9), '=S' . ($i + 8) . '-R' . ($i + 8));
        
        
        $activeSheet->getStyle('T' . ($i + 5))->getFont()->setBold(true);
        $activeSheet->getStyle('T' . ($i + 6))->getFont()->setBold(true);
        $activeSheet->getStyle('T' . ($i + 7))->getFont()->setBold(true);
        $activeSheet->getStyle('T' . ($i + 8))->getFont()->setBold(true);
        $activeSheet->getStyle('T' . ($i + 9))->getFont()->setBold(true);
        $activeSheet->setCellValue('T' . ($i + 5), 'TOTAL');
        $activeSheet->setCellValue('T' . ($i + 6), 'SALDO CUENTA');
        $activeSheet->setCellValue('T' . ($i + 7), 'CANCELADO');
        $activeSheet->setCellValue('T' . ($i + 8), 'DIFERENCIA');
        $activeSheet->setCellValue('T' . ($i + 9), 'AJUSTE');
        $activeSheet->getStyle('U' . ($i + 6).':V'.($i+6))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('U' . ($i + 7).':V'.($i+7))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('U' . ($i + 8).':V'.($i+8))->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->setCellValue('U' . ($i + 6), $planillaactual[0]['bsegundoaguinaldo']);
        $activeSheet->setCellValue('U' . ($i + 7),$totalsegundoaguinaldopagado);        
        $activeSheet->setCellValue('U' . ($i + 8), '=U' . ($i + 5) . '-U' . ($i + 6).'-'.$totalsegundoaguinaldopagado);
        
        $activeSheet->setCellValue('V' . ($i + 6), $planillaactual[0]['bsegundoaguinaldo']);
        $activeSheet->setCellValue('V' . ($i + 7),$totalsegundoaguinaldopagado);        
        $activeSheet->setCellValue('V' . ($i + 8), '=V' . ($i + 5) . '-V' . ($i + 6).'-'.$totalsegundoaguinaldopagadoR);
        $activeSheet->setCellValue('V' . ($i + 9), '=V' . ($i + 8) . '-U' . ($i + 8));
       
        
               }
    
        ///////////////////////////
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
     * @param boolean $_POST['estado'],true= si queremos ver las aportacion desglosada , false=si No queremos ver las aportaciones desglosadas
     * @param string $_POST['nombre'], nombre de la interfaz que hace el llamado a esta funcion
     * @param integer $_POST['id'], id de la planilla de la cual queremos ver sus aportaciones
     * @return object[], con el id y el nombre de la aportacion
     */
    public function actionDameListaAportaciones() {
        $estado = $_POST['estado'];
        $nombre = $_POST['nombre'];
        $id=$_POST['id'];
        if ($estado == 'true') {
            $laportacion = Yii::app()->rrhh
                    ->createCommand("select * from ((select id ,  nombre ,  nombref ,  tipo ,  idplanilla ,  usuario ,  fecha ,  eliminado ,  orden ,  grupo,  ordenalternativo ,  nombrealternativo ,  enplanilla ,  aportacionbeneficio::text  from cabecera where eliminado=false and idplanilla =$id and tipo =5 )union(select id ,  nombre ,  nombref ,  tipo ,  idplanilla ,  usuario ,  fecha ,  eliminado ,  orden ,  grupo,  ordenalternativo ,  nombrealternativo ,  enplanilla ,  aportacionbeneficio::text from cabecera where eliminado=false and idplanilla =$id and tipo =2 and nombref<>'totaldes' and   nombre not in (select grupo from cabecera where idplanilla=$id and eliminado=false)  )) t order by t.nombre asc")
                    ->queryAll();
        } else {
            $laportacion = Yii::app()->rrhh
                    ->createCommand("select * from cabecera where eliminado=false and idplanilla =$id and tipo =2 and nombref<>'totaldes' order by nombre asc")
                    ->queryAll();
        }
        return $this->renderPartial('_tablaAportaciones', array(
                    'laportacion' => $laportacion,
                    'nombre' => $nombre,
                        ), false, true);
    }
     /**
     * @param boolean $_POST['estado'],true= si queremos ver los beneficio desglosados , false=si No queremos ver los beneficios desglosados
     * @param string $_POST['nombre'], nombre de la interfaz que hace el llamado a esta funcion
     * @param integer $_POST['id'], id de la planilla de la cual queremos ver sus beneficios
     * @return object[], con el id y el nombre del beneficio
     */        
    public function actionDameListaBeneficios() {
        $estado = $_POST['estado'];
        $nombre = $_POST['nombre'];
        $id=$_POST['id'];
        if ($estado == 'true') {
            $lbeneficio = Yii::app()->rrhh
                    ->createCommand("select * from ((select id ,  nombre ,  nombref,  tipo ,  idplanilla ,  usuario ,  fecha,  eliminado ,  orden ,  grupo ,  ordenalternativo ,  nombrealternativo ,  enplanilla,  aportacionbeneficio ::text aportacionbeneficio  from cabecera where eliminado=false and idplanilla =$id and tipo =4 )union(select id ,  nombre ,  nombref,  tipo ,  idplanilla ,  usuario ,  fecha,  eliminado ,  orden ,  grupo ,  ordenalternativo ,  nombrealternativo ,  enplanilla,  aportacionbeneficio ::text aportacionbeneficio  from cabecera where eliminado=false and idplanilla =$id and tipo =1 and nombref<>'totalga' and  nombre not   in (select grupo from cabecera where tipo=4 and  idplanilla=$id and eliminado=false) )) t order by t.nombre asc")
                    ->queryAll();
        } else {
            $lbeneficio = Yii::app()->rrhh
                    ->createCommand("select id ,  nombre ,  nombref,  tipo ,  idplanilla ,  usuario ,  fecha,  eliminado ,  orden ,  grupo ,  ordenalternativo ,  nombrealternativo ,  enplanilla,  aportacionbeneficio ::text aportacionbeneficio  from cabecera where eliminado=false and idplanilla =$id and tipo =1 and nombref<>'totalga' order by nombre asc")
                    ->queryAll();
        }
        return $this->renderPartial('_tablaBeneficio', array(
                    'lbeneficio' => $lbeneficio,
                    'nombre' => $nombre,
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
     * @return string , de lista de finiquitos por consolidar
     */
    public function listafiniquitossinconsolidar() {
        $listafiniquitos=Yii::app()->rrhh->createCommand("
        select  STRING_AGG ('<li>'||p.nombrecompleto ||' Finiquito al '||to_char(hee.fecharetiro,'dd-mm-YYYY')||'</li>','<br>' order by p.nombrecompleto asc) from general.persona p inner join general.empleado e on e.idpersona=p.id inner join general.historialestadoempleado hee on hee.idempleado=e.id inner join general.pagobeneficio pb on pb.idhistorialestadoempleado=hee.id
        where hee.eliminado=false and pb.idtipopagobeneficio=2 and pb.estado=1 and hee.activo=0 and hee.fecharetiro>(select fechahasta from planilla where eliminado=false and estado=3  order by id desc limit 1)  and hee.id  in (select  (select max(id) from general.historialestadoempleado where eliminado=false and idempleado=e.id) as idhistorial from general.empleado e where   e.eliminado=false)
       ")->queryScalar();
         if ($listafiniquitos==!false ){
             $listafiniquitos='<div class="alert alert-info"><h4>Finiquitos sin Consolidar</h4><ul>'.$listafiniquitos.'</ul></div>';
         }
        return $listafiniquitos;
    }
    /**
     * 
     * @param integer $p_idplanilla, id de la planilla 
     * retorna planilla de Otros Bonos que no se muestran en planilla(pendiente)
     */
    public function DescargarOtrosBonos($p_idplanilla) {
      $cabecera = Yii::app()->rrhh->createCommand("select *, case mes when 1 then'ENERO' when 2 then 'FEBRERO'when 3 then 'MARZO' when 4 then 'ABRIL'when 5 then 'MAYO'when 6 then'JUNIO'when 7 then 'JULIO' when 8 then 'AGOSTO' when 9 then 'SEPTIEMBRE'when 10 then 'OCTUBRE'when 11 then 'NOVIEMBRE' else 'DICIEMBRE' end as nmes  from planilla where id=$p_idplanilla")->queryAll()[0];
        $nombreArchivo = 'BONOS_' . $cabecera['fechadesde'] . '_' . $cabecera['fechahasta'];
        $listabonos=Yii::app()->rrhh->createCommand("select nombre,nombref,tipo from cabecera where eliminado=false and idplanilla =$p_idplanilla and enplanilla=false and grupo=''")->queryAll();
        $numeroHoja=0;
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
        
        
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);
         $objPHPExcel->removeSheetByIndex(0);
        for($i=0;$i<count($listabonos);$i++){      
        
        $objPHPExcel->createSheet($i);        
        $activeSheet = $objPHPExcel->setActiveSheetIndex($i);
         
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
        $activeSheet->setTitle($listabonos[$i]['nombre']);
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);
        $activeSheet->getColumnDimension('A')->setWidth(4);
        $activeSheet->getColumnDimension('B')->setWidth(43);
        $activeSheet->getColumnDimension('C')->setWidth(10);
        $activeSheet->getColumnDimension('D')->setWidth(33);
        $activeSheet->getColumnDimension('E')->setWidth(12);
        $activeSheet->getColumnDimension('F')->setWidth(10);
        $activeSheet->getColumnDimension('G')->setWidth(30);
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
        $objDrawingt->setWorksheet($objPHPExcel->setActiveSheetIndex($i));
        
        $activeSheet->getRowDimension(1)->setRowHeight(10);
        $activeSheet->getRowDimension(2)->setRowHeight(10);
        $activeSheet->getRowDimension(3)->setRowHeight(10);
        $activeSheet->getRowDimension(4)->setRowHeight(10);

        //CABECERA DE LA PLANILLA

        $activeSheet->mergeCells('A1:G1');
        $activeSheet->mergeCells('A2:G2');
        $activeSheet->mergeCells('A3:G3');
        $activeSheet->mergeCells('A4:G4');
        $activeSheet->mergeCells('A4:G4');
        $kFila = 7;
        $activeSheet->getStyle('A2')->applyFromArray($phpFonttitulo);
        $activeSheet->getStyle('A3')->applyFromArray($phpFontSubtitulo);
        $activeSheet->getStyle('A4')->applyFromArray($phpFontSubtitulo);
        $activeSheet->setCellValue('A2','PLANILLA '.$listabonos[$i]['nombre']);
        $activeSheet->setCellValue('A3','CORRESPONDIENTE AL MES DE '.$cabecera['nmes'].' '.$cabecera['anio']);
        
        $activeSheet->setCellValue('A4','(Bolivianos)');
        $activeSheet->getStyle("A".($kFila-1))->applyFromArray($phpFontC);
        $activeSheet->getStyle("B".($kFila-1))->applyFromArray($phpFontC);
        $activeSheet->getStyle("C".($kFila-1))->applyFromArray($phpFontC);
        $activeSheet->getStyle("D".($kFila-1))->applyFromArray($phpFontC);
        $activeSheet->getStyle("E".($kFila-1))->applyFromArray($phpFontC);
        $activeSheet->getStyle("F".($kFila-1))->applyFromArray($phpFontC);
        $activeSheet->getStyle("G".($kFila-1))->applyFromArray($phpFontC);

        $activeSheet->setCellValue('A'.($kFila-1), 'Nº');
        $activeSheet->setCellValue('B'.($kFila-1), 'APELLIDOS Y NOMBRES');
        $activeSheet->setCellValue('C'.($kFila-1), 'C.I.');        
        $activeSheet->setCellValue('D'.($kFila-1), 'CARGO');
        $activeSheet->setCellValue('E'.($kFila-1), 'F. INGRESO');
        $activeSheet->setCellValue('F'.($kFila-1), 'MONTO');
        $activeSheet->setCellValue('G'.($kFila-1), 'FIRMA');
        
        if($listabonos[$i]['tipo']==10)
        {$datos = Yii::app()->rrhh
                ->createCommand("select t.ci,t.nombrecompleto,to_char(t.fechaingreso,'dd/mm/YYYY')as fechaingreso,t.cargo,t.monto from (select  ((json_array_elements(general)->>'nci')::text)::int as ci,(json_array_elements(general)->>'nombrec')::text as nombrecompleto,(json_array_elements(general)->>'cargo')::text as cargo,(json_array_elements(general)->>'fechai')::date as fechaingreso,(json_array_elements(beneficio)->>'".$listabonos[$i]['nombref']."')::numeric(12,2) as monto from cuerpo 
                where eliminado=false and idplanilla=$p_idplanilla and idtipocontrato in( select tc.id from general.tipocontrato tc where eliminado=false and generarcc=true) )t where t.monto>0 order by t.nombrecompleto asc")
                ->queryAll();
        }else{
          $datos = Yii::app()->rrhh
                ->createCommand("select ci,nombrecompleto,to_char(fechaingreso,'dd/mm/YYYY') as fechaingreso,monto,cargo
 from(select  ((json_array_elements(general)->>'nci')::text)::int as ci,
(json_array_elements(general)->>'nombrec')::text as nombrecompleto,
(json_array_elements(general)->>'cargo')::text as cargo,
(json_array_elements(general)->>'fechai')::date as fechaingreso,
(json_array_elements(beneficio)->>'".$listabonos[$i]['nombref']."')::numeric(12,2) as monto
from cuerpo c
                where eliminado=false and 
                 idplanilla=$p_idplanilla and idtipocontrato in( select tc.id from general.tipocontrato tc where eliminado=false and generarcc=true)) t1 where t1.monto>0 order by t1.nombrecompleto asc")
                ->queryAll();
        }
        $cant = count($datos);
        for ($j = 0; $j < $cant; $j++) {
             $activeSheet->getRowDimension(($j+$kFila))->setRowHeight(20);
            $activeSheet->getStyle('A'. ($j + $kFila).':G'.($j + $kFila))->applyFromArray($phpFont3);
            $activeSheet->setCellValue('A' . ($j + $kFila), $j+1);
            $activeSheet->setCellValue('B' . ($j + $kFila), $datos[$j]['nombrecompleto']);
            $activeSheet->setCellValue('C' . ($j + $kFila), $datos[$j]['ci']);
            $activeSheet->setCellValue('D' . ($j + $kFila), $datos[$j]['cargo']);
            $activeSheet->setCellValue('E' . ($j + $kFila), $datos[$j]['fechaingreso']);            
            $activeSheet->getStyle('F'. ($j + $kFila))->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('F'. ($j + $kFila))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->setCellValue('F' . ($j + $kFila), $datos[$j]['monto']);
            
        }
       
        
        }
          $this->descargarExcel($objPHPExcel, $nombreArchivo);
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Planilla the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Planilla::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Planilla $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='planilla-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        /**
         * 
         * @return type@param integer[] $_GET['empresasubempleadora'], id de las empresas sub empleadoras
         * @param integer $_GET['Planilla']['id'], id de la planilla  de la cual queremos el reporte de la Prefactura
         * @param integer $_GET['Planilla']['opciones'], posibles valores 1= Prefactura de Sueldos ,2= Prefactura de Lactancia y 3= Prefactura de Otros Bonos
         * retorna , planilla de la $_GET['Planilla']['opciones'] seleccionada
         */
        public function actionDescargarPrefactura() {
            $unidades=$_GET['empresasubempleadora'];
            $id=$_GET['Planilla']['id'];
            $opciones=$_GET['Planilla']['opciones'];
            if ($opciones==1){
                 return $this->DescargarPrefacturaSueldos($id, $unidades);
             }
            elseif ($opciones==2) {
             return $this->DescargarPrefacturaLactancia($id, $unidades);
             }
            elseif ($opciones==3) {
                 return $this->DescargarPrefacturaOtrosBonos($id, $unidades);
             }
        }/**
         * 
         * @param integer $id, id de la planilla 
         * @param integer[] $unidades, id de las empresas sub empleadoras
         * retorna planilla de prefactura de Sueldos 
         */
         public function DescargarPrefacturaSueldos($id,$unidades) {
             
             $unidadesseleccionadas='';
             $titulo='SUELDOS Y SALARIOS ';
             for ($i = 0; $i < count($unidades); $i++) {
                        $unidadesseleccionadas = $unidadesseleccionadas . $unidades[$i] . ',';
                    }
                    if (count($unidades)>0)
                    $unidadesseleccionadas = substr($unidadesseleccionadas, 0, -1);
                else {
                $unidadesseleccionadas=0;    
                }
        $fecha = Yii::app()->rrhh
                ->createCommand("select anio,asientosueldogenerado, case mes when 1 then'ENERO' when 2 then 'FEBRERO'when 3 then 'MARZO' when 4 then 'ABRIL'when 5 then 'MAYO'when 6 then'JUNIO'when 7 then 'JULIO' when 8 then 'AGOSTO' when 9 then 'SEPTIEMBRE'when 10 then 'OCTUBRE'when 11 then 'NOVIEMBRE' else 'DICIEMBRE' end as mes ,( to_char(fechadesde, 'DD-MM-YYYY')||'_' || to_char(fechahasta, 'DD-MM-YYYY')) as fecha ,fechadesde,fechahasta 
 
   from planilla where id=" . $id . " ")
                ->queryAll();
        if($fecha[0]['asientosueldogenerado']==false){
            $titulo='BORRADOR '.$titulo;            
        }        
        $idplanillaanterior= Yii::app()->rrhh
                ->createCommand("select id from planilla where eliminado=false and id<$id order by id desc limit 1 ")
                ->queryScalar();
        $mes = $fecha[0]['mes'];
        $anio = $fecha[0]['anio'];
        $nombre = $fecha[0]['fecha'];
        $datoEmpresa = Yii::app()->rrhh
                        ->createCommand("select e.*,pl.nombrer,pl.cir from planilla pl inner join general.representante r on r.cirepresentante=pl.cir inner join general.empresa e on e.id=r.idempresa  where pl.id=" . $id)
                        ->queryAll()[0];
        $datoPlanilla = Yii::app()->rrhh
                ->createCommand("select t.id,t.porcentaje, t.nci as ci  ,split_part(t.ci,'-',2) as extension ,
    (select nombre from general.empresasubempleadora where id =t.idempresasubempleadora)as unidad,t.totalga
,case when t.novedad='' or t.novedad='I' then 'ACTIVO' else 'NO ACTIVO' end as novedad,case when t.afp=0 then 0 else 1 end  aportaafp,t.cargo,t.tipocontrato,
( select (ts.valor*t.porcentaje)/100  from (select json_array_elements(t.solidario)->>'nombre' as nombre,(json_array_elements(t.solidario)->>'valor')::numeric(12,2) as valor) as ts where ts.nombre='AFPAPORTESOLIDARIOLABORAL') as solidario
,(t.totalga::numeric(12,2)+
(t.montoindemnizacion+t.montoprimeraguinaldo+t.montosegundoaguinaldo)
+(t.provivienda+t.riegoprofesional+fondosolidario+t.cns)+t.otrosgastos )::numeric(12,2) as grantotal
,((t.totalga::numeric(12,2)+(t.montoindemnizacion+t.montoprimeraguinaldo+t.montosegundoaguinaldo)+(t.provivienda+t.riegoprofesional+fondosolidario+t.cns)::numeric(12,2) +t.otrosgastos )* ffee )::numeric(12,2) as fee,

((t.totalga::numeric(12,2)+(t.montoindemnizacion+t.montoprimeraguinaldo+t.montosegundoaguinaldo)+(t.provivienda+t.riegoprofesional+fondosolidario+t.cns) +t.otrosgastos ) +
+(t.totalga::numeric(12,2)+(t.montoindemnizacion+t.montoprimeraguinaldo+t.montosegundoaguinaldo)+(t.provivienda+t.riegoprofesional+fondosolidario+t.cns)::numeric(12,2)+t.otrosgastos )*ffee)::numeric(12,2) as totalfee


,
(((t.totalga::numeric(12,2)+(t.montoindemnizacion+t.montoprimeraguinaldo+t.montosegundoaguinaldo)+(t.provivienda+t.riegoprofesional+fondosolidario+t.cns)+t.otrosgastos ) +
+ (t.totalga::numeric(12,2)+(t.montoindemnizacion+t.montoprimeraguinaldo+t.montosegundoaguinaldo)+(t.provivienda+t.riegoprofesional+fondosolidario+t.cns)::numeric(12,2)+t.otrosgastos )*ffee)::numeric(12,2)* fimpuesto)::numeric(12,2) as impuesto,

(
(((t.totalga::numeric(12,2)+(t.montoindemnizacion+t.montoprimeraguinaldo+t.montosegundoaguinaldo)+(t.provivienda+t.riegoprofesional+fondosolidario+t.cns) +t.otrosgastos) +
+ (t.totalga::numeric(12,2)+(t.montoindemnizacion+t.montoprimeraguinaldo+t.montosegundoaguinaldo)+(t.provivienda+t.riegoprofesional+fondosolidario+t.cns)::numeric(12,2)+t.otrosgastos )*ffee)::numeric(12,2) +
(((t.totalga::numeric(12,2)+(t.montoindemnizacion+t.montoprimeraguinaldo+t.montosegundoaguinaldo)+(t.provivienda+t.riegoprofesional+fondosolidario+t.cns) +t.otrosgastos ) +
+ (t.totalga::numeric(12,2)+(t.montoindemnizacion+t.montoprimeraguinaldo+t.montosegundoaguinaldo)+(t.provivienda+t.riegoprofesional+fondosolidario+t.cns)::numeric(12,2) +t.otrosgastos)*ffee)::numeric(12,2)* fimpuesto)::numeric(12,2) )

)::numeric(12,2) as totalfacturacion,(t.provivienda+t.riegoprofesional+fondosolidario)as afps,ffee ,fimpuesto 


,(t.provivienda+t.riegoprofesional+fondosolidario+t.cns)as subtotalafp,t.montoindemnizacion as indemnizacion,
t.montosegundoaguinaldo as segundoaguinaldo,t.montoprimeraguinaldo as primeraguinaldo,
(t.montoprimeraguinaldo+t.montoindemnizacion+t.montosegundoaguinaldo) as subtotalprovisiones
,t.totaldes,t.cns,t.afp,t.general,t.beneficio,t.aporte ,t.hbasico,t.otrosgastos
 from ( select  t1.idc,t1.id,t1.idempresasubempleadora,t1.ci,t1.nci,t1.novedad,((t1.totalga::numeric*t1.porcentaje)/100)::numeric(12,2) as totalga,((t1.afp*t1.porcentaje)/100)::numeric(12,2) as afp,t1.cargo,t1.tipocontrato,((t1.hbasico::numeric*t1.porcentaje)/100)::numeric(12,2) as hbasico,((t1.bantiguedad::numeric*t1.porcentaje)/100)::numeric(12,2) as bantiguedad ,
t1.solidario, ((t1.totaldes*t1.porcentaje)/100)::numeric(12,2) as totaldes,((t1.cns*t1.porcentaje)/100)::numeric(12,2) as cns,((t1.provivienda*t1.porcentaje)/100)::numeric(12,2) as provivienda,
((t1.riegoprofesional*t1.porcentaje)/100)::numeric(12,2) as riegoprofesional,((t1.fondosolidario*t1.porcentaje)/100)::numeric(12,2) as fondosolidario,((t1.montoindemnizacion*t1.porcentaje)/100) as montoindemnizacion,
((t1.montosegundoaguinaldo*t1.porcentaje)/100)::numeric(12,2) as montosegundoaguinaldo,((t1.montoprimeraguinaldo* t1.porcentaje)/100)::numeric(12,2) as montoprimeraguinaldo,t1.ffee,t1.fimpuesto,t1.general,t1.aporte,t1.beneficio,t1.porcentaje,((t1.otrosgastos*t1.porcentaje)/100)::numeric(12,2) as otrosgastos
 from(select c.id as idc, c.idempleado as id,a.idempresasubempleadora, json_array_elements(general)->>'nci' as nci,
json_array_elements(general)->>'ci' as ci,
json_array_elements(general)->>'novedad' as novedad,
json_array_elements(beneficio)->>'totalga' as totalga,
(json_array_elements(aporte)->>'AFPAPORTETRABAJADOR')::numeric(12,2) as afp,
json_array_elements(general)->>'cargo' as cargo, ( select nombre from general.tipocontrato where id=idtipocontrato) as tipocontrato,
json_array_elements(general)->>'hbasico' as hbasico,
json_array_elements(beneficio)->>'BONODEANTIGUEDAD' as bantiguedad,
(json_array_elements(aporte)->'AFPAPORTETRABAJADORdep') as solidario,
(json_array_elements(aporte)->>'totaldes')::numeric(12,2) as totaldes,
(json_array_elements(aporte)->>'APORTEACNS')::numeric(12,2) as cns,
(json_array_elements(aporte)->>'AFPPATRONALPROVIVIENDA')::numeric(12,2) as provivienda,
(json_array_elements(aporte)->>'AFPPATRONALRIESGOPROFESIONA')::numeric(12,2) as riegoprofesional,
(json_array_elements(aporte)->>'AFPPATRONALSOLIDARIO')::numeric(12,2) as fondosolidario,
(json_array_elements(aporte)->>'otrosgastos')::numeric(12,2) as otrosgastos,
( select  dame_indemnizacion_global(c.id,a.idempresasubempleadora) ) as montoindemnizacion ,
(select  dame_segundoaguinaldo_global(c.id,a.idempresasubempleadora) ) as montosegundoaguinaldo ,
(select dame_aguinaldo_global(c.id,a.idempresasubempleadora) ) as montoprimeraguinaldo,((select dame_fee_planilla ($id,a.idempresasubempleadora))/100) as ffee ,((select dame_impuesto_planilla ($id,a.idempresasubempleadora))/100) as fimpuesto,general,aporte,beneficio,a.porcentaje
 from  (SELECT unnest(
  string_to_array(c.idporcentajepago, ',')
)::int as idporcentajepagoempresa ,* from  cuerpo c where eliminado=false and idplanilla =$id and  tipo=1 ) c inner join general.porcentajepago a on a.id=c.idporcentajepagoempresa where c.tipo=1   AND c.idtipocontrato in(SELECT id FROM GENERAL.TIPOCONTRATO WHERE GENERARCC=TRUE
) and c.eliminado=false  and a.idempresasubempleadora in($unidadesseleccionadas)  and c.idplanilla=$id)  as t1 )as t order by t.idc asc

")                ->queryAll();
        
                   
        
       
        $cantcolAportacion = 0;
        $listabe = Yii::app()->rrhh->createCommand("select string_agg(chr(39)||nombre||chr(39), ',' )  as beneficios,count(*) as cant from cabecera where eliminado=false and idplanilla=$id and tipo =1")->queryAll()[0];
        $cadenab = $listabe['beneficios'];
        $cantcolBeneficio = $listabe['cant'] + 1;
      
        $cabeceraPlanilla = Yii::app()->rrhh
                            ->createCommand("(  select c1.orden,case when c1.nombre='Nº' then 'C.I.' when c1.nombre='C.I.' then'EXTENCION' else c1.nombre end as nombre, case when c1.nombre='Nº' then 'ci' when c1.nombre='C.I.' then'extension' else c1.nombref end  AS nombref ,c1.tipo from  cabecera c1  where c1.eliminado=false and  c1.idplanilla is null and  c1.tipo in(0,10) and nombre not in('NOMBRES Y APELLIDOS','APELLIDO MATERNO','APELLIDO PATERNO','NOMBRES')    )
                union (select c.orden, c.nombre,c.nombref ,c.tipo from planilla pl inner join cabecera c on c.idplanilla=pl.id  where c.nombre in(" . $cadenab . ")and c.eliminado=false and c.tipo IN(1,4) and   pl.id=$id)  order by orden asc  ")
                            ->queryAll();
                  
                   
        $cantcolGeneral = Yii::app()->rrhh
                        ->createCommand("select count(*) as cant from  cabecera c1  where c1.eliminado=false AND c1.idplanilla is null  and  c1.tipo =0 and nombre not in('NOMBRES Y APELLIDOS','APELLIDO MATERNO','APELLIDO PATERNO','NOMBRES') ")
                        ->queryScalar();
        $cantcolGeneral+=1;
        $cantcolFactura = Yii::app()->rrhh
                        ->createCommand("select count(*) as cant from  cabecera c1  where c1.eliminado=false AND c1.idplanilla is null  and  c1.tipo =10  ")
                        ->queryScalar();
                    $general = json_decode($datoPlanilla[0]['general'], true);
                  
               
        $nombreArchivo = 'PREFACTURA' . $nombre;
       
        $columnasGeneral = $this->dameColumna('F', $cantcolGeneral);
        $columnasBeneficio = $this->dameColumna($columnasGeneral[$cantcolGeneral-1], $cantcolBeneficio);
        $columnasAportaciones = $this->dameColumna($columnasBeneficio[$cantcolBeneficio], $cantcolAportacion);
        $columnasFacturas = $this->dameColumna($columnasAportaciones[$cantcolAportacion], $cantcolFactura);
       
        $totalcolumnas=$cantcolGeneral+$cantcolAportacion+$cantcolBeneficio+$cantcolFactura+3;
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
        // COPIA FIEL DE LA PLANILLA GENERAL
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
        $activeSheet->setCellValue('A1', strtoupper("PLANILLA PREFACTURA ".$titulo." CORRESPONDIENTE AL MES DE " . $mes . " " . $anio));
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
                    if ($cp['nombref'] == 'HORAEXTRAP') {
                        $activeSheet->mergeCells($columnasBeneficio[$indb] . '7:' . $columnasBeneficio[$indb + 1] . '7');
                        $activeSheet->setCellValue($columnasBeneficio[$indb] . '7', $cp['nombre']);
                        $activeSheet->setCellValue($columnasBeneficio[$indb] . '8', 'Horas');
                        ++$indb;
                        $activeSheet->setCellValue($columnasBeneficio[$indb] . '8', 'Monto');
                        $columnaextra = true;
                        $nombrecolumnaextra = $columnasBeneficio[$indb];
                    } else {
                        
                        $activeSheet->mergeCells($columnasBeneficio[$indb] . '7:' . $columnasBeneficio[$indb] . '8');
                        $activeSheet->setCellValue($columnasBeneficio[$indb] . '7', $cp['nombre']);
                    }

                    ++$indb;
                }
                if ($cp['tipo'] == 2) {
                    $activeSheet->mergeCells($columnasAportaciones[$inda] . '7:' . $columnasAportaciones[$inda] . '8');

                    $activeSheet->setCellValue($columnasAportaciones[$inda] . '7', $cp['nombre']);
                    ++$inda;
                }
                if ($cp['tipo'] == 10) {
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
                $general = json_decode($datoPlanilla[$i]['general'], true);
                $beneficio = json_decode($datoPlanilla[$i]['beneficio'], true);
                $aporte = json_decode($datoPlanilla[$i]['aporte'], true);
                $inde = 0;
                $indb = 0;
                $inda = 0;
                $indf=0;
                $montobe = 0;
                $montoa = 0;
                $activeSheet->getRowDimension($kFila)->setRowHeight(17);
                $activeSheet->setCellValue( 'A'.$kFila,   $i + 1);
                $activeSheet->setCellValue( 'B'.$kFila,  $anio);
                $activeSheet->setCellValue( 'C'.$kFila, 'SUCRE');
                $activeSheet->setCellValue( 'D'.$kFila,  $datoPlanilla[$i]['unidad']);
                $activeSheet->setCellValue( 'E'.$kFila, $datoPlanilla[$i]['novedad']);
                $activeSheet->getStyle("A".$kFila.":" . $columnasFacturas[$cantcolFactura-1] . $kFila)->applyFromArray(
                        $phpFontCuerpo
                );
                
                foreach ($cabeceraPlanilla as $cp) {
                  
                    if ($cp['tipo'] == 0) {       
                            if ($cp['nombref'] === 'hbasico') {
                                //$montobe=$general[0][$cp['nombref']];
                                $activeSheet->getStyle($columnasGeneral[$inde] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                                $activeSheet->getStyle($columnasGeneral[$inde] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                                $montobe = $datoPlanilla[$i]['hbasico'];
                                $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, $datoPlanilla[$i]['hbasico']);
                            }else if($cp['nombref'] === 'extension'){
                                $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, $datoPlanilla[$i] ['extension']);
                            }
                            else if($cp['nombref'] === 'ci'){
                                $activeSheet->setCellValue( $columnasGeneral[$inde].$kFila, $datoPlanilla[$i]['ci']);
                            }
                             else if($cp['nombref'] === 'dias'){
                                $activeSheet->setCellValue( $columnasGeneral[$inde].$kFila,round(((( $general[0][$cp['nombref']])*$datoPlanilla[$i]['porcentaje'])/100),0));
                            }
                            else if ($cp['nombref'] === 'fechai') {
                                $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, date("d/m/Y", strtotime($general[0][$cp['nombref']])));
                            }else if ($cp['nombref'] === 'fechanac') {
                                $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, date("d/m/Y", strtotime($general[0][$cp['nombref']])));
                            } else {//G1
                                $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, $general[0][$cp['nombref']]);
                            }
                        
                        ++$inde;
                    }

                    if ($cp['tipo'] == 1) {
                        $activeSheet->getStyle($columnasBeneficio[$indb] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                        $activeSheet->getStyle($columnasBeneficio[$indb] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        if ($cp['nombref'] == 'totalga') {
                            $activeSheet->setCellValue($columnasBeneficio[$indb] . $kFila, $montobe);
                        } else if ($cp['nombref'] == 'HORAEXTRAP') {
                            $montoporcentaje= round((($beneficio[0][$cp['nombref']]*$datoPlanilla[$i]['porcentaje'])/100),2);
                            $montobe += $montoporcentaje;
                            $baux = false;
                            $valor = -1;
                            $lb = $beneficio[0]['detallehe'];
                            $canthoras = ($lb[0]['canthoras']*$datoPlanilla[$i]['porcentaje'])/100;
                            $activeSheet->setCellValue($columnasBeneficio[$indb] . $kFila, round($canthoras, 2));
                            ++$indb;
                            $activeSheet->setCellValue($columnasBeneficio[$indb] . $kFila, $montoporcentaje);
                            $activeSheet->getStyle($columnasBeneficio[$indb] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                            $activeSheet->getStyle($columnasBeneficio[$indb] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        } else {
                            $montoporcentaje= round((($beneficio[0][$cp['nombref']]*$datoPlanilla[$i]['porcentaje'])/100),2);
                             
                            $montobe += $montoporcentaje;
                            $activeSheet->setCellValue($columnasBeneficio[$indb] . $kFila, $montoporcentaje);
                        }

                        ++$indb;
                    }
                    if ($cp['tipo'] == 2) {

                        $activeSheet->getStyle($columnasAportaciones[$inda] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                        $activeSheet->getStyle($columnasAportaciones[$inda] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        if ($cp['nombref'] == 'totaldes') {
                            $activeSheet->setCellValue($columnasAportaciones[$inda] . $kFila, round($montoa, 2));
                        } else {
                            $montoporcentaje= round((($aporte[0][$cp['nombref']]*$datoPlanilla[$i]['porcentaje'])/100),2);
                             
                            $montoa += $montoporcentaje;

                            $activeSheet->setCellValue($columnasAportaciones[$inda] . $kFila, $montoporcentaje);
                        }

                        ++$inda;
                    }
                   
                     if ($cp['tipo'] == 10) {

                        $activeSheet->getStyle($columnasFacturas[$indf] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                        $activeSheet->getStyle($columnasFacturas[$indf] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $activeSheet->setCellValue($columnasFacturas[$indf] . $kFila, round($datoPlanilla[$i] [$cp['nombref']], 2));
                        

                        ++$indf;
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
                $activeSheet->setCellValue($columnasBeneficio[$j] . $kFila, '=SUM(' . $columnasBeneficio[$j] . '9:' . $columnasBeneficio[$j] . ($kFila - 1) . ')');
            }
            for ($j = 0; $j < $cantcolAportacion; $j++) {

                $activeSheet->getStyle($columnasAportaciones[$j] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle($columnasAportaciones[$j] . $kFila)->applyFromArray($phpFont1);
                $activeSheet->setCellValue($columnasAportaciones[$j] . $kFila, '=SUM(' . $columnasAportaciones[$j] . '9:' . $columnasAportaciones[$j] . ($kFila - 1) . ')');
            }
             for ($j = 0; $j < $cantcolFactura; $j++) {

                $activeSheet->getStyle($columnasFacturas[$j] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle($columnasFacturas[$j] . $kFila)->applyFromArray($phpFont1);
                $activeSheet->setCellValue($columnasFacturas[$j] . $kFila, '=SUM(' . $columnasFacturas[$j]. '9:' . $columnasFacturas[$j] . ($kFila - 1) . ')');
            }
            
            $total= $activeSheet->getCellByColumnAndRow($totalcolumnas, $kFila)->getCalculatedValue(); 
            
            if ($cantcolBeneficio > 0) {
                $activeSheet->getStyle($columnasBeneficio[$cantcolBeneficio - 1] . '9:' . $columnasBeneficio[$cantcolBeneficio - 1] . ($kFila - 1))->applyFromArray(array('borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '000000')
                        ),
                    ),
                    'fill' => array('type' => PHPExcel_Style_Fill::FILL_NONE),));
            }
                 
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
        $activeSheet->setCellValue('B6' ,"PRE FACTURA  PLANILLA GLOBAL  ".$mes." ".$anio ); 
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
     * @param type $id
     * @throws CrugeException@param integer $id, id de la planilla
     * retorna reporte formato pdf , con el resumen de asientencia con los cuales se calculo la planilla
     */
     public function actionImprimirResumenAsistencia($id) {
       $p_idplanilla = SeguridadModule::dec($id);
     
        $re = new JasperReport('/reports/RRHH/ReporteAsistenciaCorte', JasperReport::FORMAT_PDF, array(
            'p_idplanilla' => $p_idplanilla,
            'pUsuario' => Yii::app()->user->getName(),
        ));
        $re->exec();
        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        }
    }/**
     * 
     * @param integer $id, id de la planilla
     * @param integer[], id de las empresas sub empleadoras
     * retorna planilla de prefactura de lactancia
     */
    public function DescargarPrefacturaLactancia($id,$unidades) {
             $unidadesseleccionadas='';
             $titulo='LACTANCIA';
             for ($i = 0; $i < count($unidades); $i++) {
                        $unidadesseleccionadas = $unidadesseleccionadas . $unidades[$i] . ',';
                    }
                    if (count($unidades)>0)
                    $unidadesseleccionadas = substr($unidadesseleccionadas, 0, -1);
                else {
                $unidadesseleccionadas=0;    
                }       


        $fecha = Yii::app()->rrhh
                ->createCommand("select asientolactanciagenerado, rciva, anio, case mes when 1 then'ENERO' when 2 then 'FEBRERO'when 3 then 'MARZO' when 4 then 'ABRIL'when 5 then 'MAYO'when 6 then'JUNIO'when 7 then 'JULIO' when 8 then 'AGOSTO' when 9 then 'SEPTIEMBRE'when 10 then 'OCTUBRE'when 11 then 'NOVIEMBRE' else 'DICIEMBRE' end as mes ,( to_char(fechadesde, 'DD-MM-YYYY')||'_' || to_char(fechahasta, 'DD-MM-YYYY')) as fecha,fee, impuesto ,fechadesde,fechahasta 
 from planilla where id=" . $id . " ")
                ->queryAll();
        if($fecha[0]['asientolactanciagenerado']==false){
            $titulo='BORRADOR '.$titulo;
        }
        $mes = $fecha[0]['mes'];
        $anio = $fecha[0]['anio'];
        $nombre = $fecha[0]['fecha'];
        $datoEmpresa = Yii::app()->rrhh
                        ->createCommand("select e.*,pl.nombrer,pl.cir from planilla pl inner join general.representante r on r.cirepresentante=pl.cir inner join general.empresa e on e.id=r.idempresa  where pl.id=" . $id)
                        ->queryAll()[0];
        
        
        $datoPlanilla = Yii::app()->rrhh
                ->createCommand(" select p.ci||' '||p.complementoci as ci,((select pa.nacionalidad from general.localidad l inner join general.municipio m on m.id=l.idmunicipio inner join general.provincia pr on pr.id=m.idprovincia inner join ftbl_compra_departamento d on d.id=pr.iddepartamento inner join ftbl_compra_pais pa on pa.id=d.idpais where l.id=p.idlocalidad) ) as nacionalidad ,p.expedicion as expedido,p.nombrecompleto,l.idunidad, case when l.estado=true then 'ACTIVO' else 'NO ACTIVO'end as estado,
l.contrato,((l.montolactancia*pp.porcentaje)/100)::numeric(12,2) as montolactancia,((l.montonatalidad))::numeric(12,2) as montonatalidad,(select nombre from general.empresasubempleadora where id=pp.idempresasubempleadora) as unidad,

((select dame_fee_planilla ($id,pp.idempresasubempleadora))/100) as fee,((select dame_impuesto_planilla ($id,pp.idempresasubempleadora))/100) as impuesto
 from planillalactancia l inner join (SELECT unnest(
  string_to_array(c.idporcentajepago, ',')
)::int as idporcentajepagoempresa ,c.idempleado,c.eliminado,c.idplanilla  from  cuerpo c where eliminado=false and idplanilla =$id and  tipo=1 ) c on c.idempleado=l.idempleado  inner join general.empleado e on e.id=l.idempleado inner join general.persona p on p.id=e.idpersona inner join 
 general.porcentajepago pp on pp.id=c.idporcentajepagoempresa
 where c.eliminado=false and c.idplanilla=$id and l.eliminado=false and l.idplanilla=$id and pp.idempresasubempleadora in($unidadesseleccionadas) order by nombrecompleto asc")
                ->queryAll(); 
       
      
        $cabeceraPlanilla = Yii::app()->rrhh
                            ->createCommand("(select 'CODIGO(CI)' AS nombre, 1 as orden)union(select 'Nro'as nombre ,2 as orden)union
(select 'PERD' AS nombre, 3 as orden)union(select 'REG'as nombre ,4 as orden)union
(select 'EMPRESA/CLIENTE' AS nombre, 5 as orden)union(select 'ESTADO'as nombre ,6 as orden)union
(select 'NRO CI.' AS nombre, 7 as orden)union(select 'EXTENCION'as nombre ,8 as orden)union
(select 'APELLIDOS Y NOMBRES' AS nombre, 9 as orden)union(select 'NACIONALIDAD'as nombre ,10 as orden)union
(select 'MODALIDAD DE CONTRATO' AS nombre, 11 as orden)union(select 'SUBSIDIO'as nombre ,12 as orden)union
(select '87% POR FACTURA SUBSIDIO' AS nombre, 13 as orden)union
(select 'BONO NATALIDAD' AS nombre, 14 as orden)union(select 'TOTAL SUBSIDIOS'as nombre ,15 as orden)union
(select 'FEE'as nombre ,16 as orden)union
(select 'TOTAL + FEE' AS nombre, 17 as orden)union(select 'IMPUESTO'as nombre ,18 as orden)union
(select 'GRAN TOTAL' AS nombre, 19 as orden) ORDER BY orden asc  ") ->queryAll();
                  
                   
        $cantcolGeneral = 19;
        
                    
               
        $nombreArchivo = 'SUBSIDIO_' . $nombre;
   
        $columnasGeneral = $this->dameColumna('A', $cantcolGeneral);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);

        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);

        $activeSheet->setTitle('PREFACTURA SUBSIDIO');
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
        $activeSheet->getColumnDimension('A')->setWidth(20);
        $activeSheet->getColumnDimension('B')->setWidth(10);
        $activeSheet->getColumnDimension('C')->setWidth(20);
        $activeSheet->getColumnDimension('D')->setWidth(20);
        $activeSheet->getColumnDimension('E')->setWidth(20);
        $activeSheet->getColumnDimension('F')->setWidth(20);
        // COPIA FIEL DE LA PLANILLA GENERAL
        $activeSheet->getColumnDimension('G')->setWidth(20);
        $activeSheet->getColumnDimension('H')->setWidth(15);
        $activeSheet->getColumnDimension('I')->setWidth(45);
        $activeSheet->getColumnDimension('J')->setWidth(20);
        $activeSheet->getColumnDimension('K')->setWidth(35);
        $activeSheet->getColumnDimension('L')->setWidth(20);
        $activeSheet->getColumnDimension('M')->setWidth(20);
        $activeSheet->getColumnDimension('N')->setWidth(20);
        $activeSheet->getColumnDimension('O')->setWidth(20);
        $activeSheet->getColumnDimension('P')->setWidth(20);
        $activeSheet->getColumnDimension('Q')->setWidth(20);
        $activeSheet->getColumnDimension('R')->setWidth(20);
        $activeSheet->getColumnDimension('S')->setWidth(20);
        
       
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
        $activeSheet->setCellValue('A1', strtoupper("PLANILLA PREFACTURA ".$titulo." CORRESPONDIENTE AL MES DE " . $mes . " " . $anio));
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
    
            

            $activeSheet->getStyle("A7:S7")->getAlignment()->setWrapText(true);
            $inde = 0;
           
         

            foreach ($cabeceraPlanilla as $cp) {
           
                    $activeSheet->mergeCells($columnasGeneral[$inde] . '7:' . $columnasGeneral[$inde] . '8');
                    $activeSheet->setCellValue($columnasGeneral[$inde] . '7', $cp['nombre']);
                    ++$inde; 
               
              
             
            }           
           $activeSheet->getStyle('A7:S7')->applyFromArray($phpFontC);
            ///CUERPO
            for ($i = 0; $i < count($datoPlanilla); $i++) {
                    $activeSheet->getStyle('A' . $kFila.':S'.$kFila)->applyFromArray($phpFontCuerpo);
                     $activeSheet->getStyle('L' . $kFila.':S'.$kFila)->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            ), ));
                $activeSheet->setCellValue('A' . $kFila, $datoPlanilla[$i] ['ci']);
                $activeSheet->setCellValue('B' . $kFila, ($i+1));
                $activeSheet->setCellValue('C' . $kFila, $anio);
                $activeSheet->setCellValue('D' . $kFila, 'SUCRE');
                $activeSheet->setCellValue('E' . $kFila, $datoPlanilla[$i] ['unidad']);
                $activeSheet->setCellValue('F' . $kFila, $datoPlanilla[$i] ['estado']);
                $activeSheet->setCellValue('G' . $kFila, $datoPlanilla[$i] ['ci']);
                $activeSheet->setCellValue('H' . $kFila, $datoPlanilla[$i] ['expedido']);
                $activeSheet->setCellValue('I' . $kFila, $datoPlanilla[$i] ['nombrecompleto']);
                $activeSheet->setCellValue('J' . $kFila, $datoPlanilla[$i] ['nacionalidad']);
                $activeSheet->setCellValue('K' . $kFila, $datoPlanilla[$i] ['contrato']);
                $activeSheet->setCellValue('L' . $kFila, $datoPlanilla[$i] ['montolactancia']);
                $activeSheet->setCellValue('N' . $kFila, $datoPlanilla[$i] ['montonatalidad']);
                $activeSheet->getStyle('L' . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('M' . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('N' . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('O' . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('P' . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('Q' . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('R' . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('S' . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->setCellValue('M'. $kFila,  '=(L'. $kFila .' * ' . round(( (100-$fecha[0]['rciva'])/100),2) .')');
                $activeSheet->setCellValue('O'. $kFila, '=SUM(M' . $kFila . ':N' . $kFila .')');
                    
                $activeSheet->setCellValue('P' . $kFila, '=ROUND((O'. $kFila . '* '.$datoPlanilla[$i] ['fee'].'),2)');
                $activeSheet->setCellValue('Q' . $kFila, '=P'.$kFila.'+O'.$kFila);
                $activeSheet->setCellValue('R' . $kFila, '=ROUND((Q'.$kFila.'* '.$datoPlanilla[$i] ['impuesto'].'),2)');
                $activeSheet->setCellValue('S' . $kFila, '=R'.$kFila.' + Q'.$kFila);
                             
                $kFila++;
            }
                $activeSheet->getStyle('L' . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('M' . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('N' . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('O' . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('P' . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('Q' . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('R' . $kFila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('S' . $kFila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->mergeCells('A' . $kFila . ':K'. $kFila);
            $activeSheet->getStyle('A' . $kFila)->applyFromArray($phpFont1);
            $activeSheet->getStyle('L' . $kFila.':S'.$kFila)->applyFromArray($phpFont1);
            $activeSheet->setCellValue('A' . $kFila, 'TOTALES');

            $activeSheet->getRowDimension($kFila)->setRowHeight(20);
       
            $activeSheet->setCellValue('L' . $kFila, '=SUM(L8:L' . ($kFila - 1) . ')');
            $activeSheet->setCellValue('M' . $kFila, '=SUM(M8:M' . ($kFila - 1) . ')');
            $activeSheet->setCellValue('N' . $kFila, '=SUM(N8:N' . ($kFila - 1) . ')');
            $activeSheet->setCellValue('O' . $kFila, '=SUM(O8:O' . ($kFila - 1) . ')');
            $activeSheet->setCellValue('P' . $kFila, '=SUM(P8:P' . ($kFila - 1) . ')');
            $activeSheet->setCellValue('Q' . $kFila, '=SUM(Q8:Q' . ($kFila - 1) . ')');
            $activeSheet->setCellValue('R' . $kFila, '=SUM(R8:R' . ($kFila - 1) . ')');
            $activeSheet->setCellValue('S' . $kFila, '=SUM(S8:S' . ($kFila - 1) . ')');            
            $total= $activeSheet->getCellByColumnAndRow(18, $kFila)->getCalculatedValue();      
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
        $activeSheet->setCellValue('B5' ,"RESUMEN PREFACTURA ".$titulo." SOLUR S.R.L. " ); 
        $activeSheet->setCellValue('B6' ,"PRE FACTURA ".$mes." SUBSIDIO  ".$anio ); 
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
     * retorna interfaz para reporte de prefactura
     */
    public function actionPrefactura() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = new Planilla;
        $lempresasubempleadora = Empresasubempleadora::model()->findAll();
       
       
        $this->renderPartial('prefactura', array(
            'model' => $model,
           'lempresasubempleadora'=>$lempresasubempleadora,
                ), false, true);
    }
    /**
     * 
     * @param integer $id, id de la planilla
     * retorna interfaz para la consolidacion de la planilla de prefactura
     */
    public function actionConsolidarPrefacturaSueldos($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = new Planilla;
        $id = SeguridadModule::dec($id);
        $model->nombre = 'Desea Consolidar Planilla Prefactura de Sueldos? --->'.$id;
       
        if (isset($_POST['Planilla'])) {
            Planilla::model()->ConsolidarPrefacturaSueldos($id);
            echo System::dataReturn('Planilla Prefactura de Sueldos Consolidada');
            return;
        }
        $this->renderPartial('consolidarPrefactura', array(
            'model' => $model,          
            
                ), false, true);
    }
    /**
     * 
     * @param imteger $id, id de la planilla
     * @returna interfa para la consolidacion de la planilla de Otros Bonos Prefactura
     */
    public function actionConsolidarPrefacturaBonos($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = new Planilla;
        $id = SeguridadModule::dec($id);
        $model->nombre = 'Desea Consolidar Planilla Prefactura de Otros Bonos?';
       
        if (isset($_POST['Planilla'])) {
            Planilla::model()->ConsolidarPrefacturaBonos($id);
            echo System::dataReturn('Planilla Prefactura de Bonos Consolidada');
            return;
        }
        $this->renderPartial('consolidarPrefactura', array(
            'model' => $model,          
            
                ), false, true);
    }
    /**
     * 
     * @param integer $id, id de la planilla
     * @return interfaz para la consolidacion de la planilla de Prefactura de Lactancia
     */
    public function actionConsolidarPrefacturaLactancia($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = new Planilla;
        $id = SeguridadModule::dec($id);
        $model->nombre = 'Desea Consolidar Planilla Prefactura de Lactancia? ';
        
        if (isset($_POST['Planilla'])) {
            Planilla::model()->ConsolidarPrefacturaLactancia($id);
            echo System::dataReturn('Planilla Prefactura de Lactancia Consolidada');
            return;
        }
        $this->renderPartial('consolidarPrefactura', array(
            'model' => $model,
      
                ), false, true);
    } 
    /**
     * 
     * retorna interfaz para el reporte de domical perdido 
     */
     public function actionReportedominicalperdido()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = new Planilla;
        if (isset($_POST['Planilla'])) {
            if ($model->scenario == 'proceso') {
                return;
            } else {
                echo System::hasErrors($resp[0]['sms'], $model);

                return;
            }
        }
        $this->renderPartial('dominicalperdido', array(
            'model' => $model,
                ), false, true);
    }
    /**
     * 
     * @param integer $_GET['Planilla']['id'], id de la planilla
     * @param integer $_GET['Planilla']['idempleado'], id del empleado( cuando id=0 retorna el listado de todos los empleados que perdieron dominical)
     * retorna reporte con el listado de empleados con el resumen por semana el motivo de la perdida del respectivo dominical 
     */
     public function actionImprimirReporteDominicalperdido() {
        $p_idplanilla = $_GET['Planilla']['id'];
        $p_idempleado=$_GET['Planilla']['idempleado'];
        if($p_idempleado==''){
            $p_idempleado=0;
        }     
        
        $re = new JasperReport('/reports/RRHH/DominicalPerdido', JasperReport::FORMAT_PDF, array(
            'p_idplanilla' => $p_idplanilla,
            'p_idempleado' =>$p_idempleado,
            'pUsuario' => Yii::app()->user->getName(),
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
     * retorna interfaz para la seleccion de la planilla de la cual queremos la distribucion de dominical
     */
     public function actionReportedistribuciondominical()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = new Planilla;
        if (isset($_POST['Planilla'])) {
            if ($model->scenario == 'proceso') {
                return;
            } else {
                echo System::hasErrors($resp[0]['sms'], $model);

                return;
            }
        }
        $this->renderPartial('distribuciondominical', array(
            'model' => $model,
                ), false, true);
    }
    /**
     * @param integer $_GET['Planilla']['id'], id de la planilla
     * retorna reporte de empleados a los que se les distribuyo el domminical por semana
     */
     public function actionImprimirReporteDistribuciondominical() {
        $p_idplanilla = $_GET['Planilla']['id'];       
        $re = new JasperReport('/reports/RRHH/DistribucionDominical', JasperReport::FORMAT_PDF, array(
            'p_idplanilla' => $p_idplanilla,
            'pUsuario' => Yii::app()->user->getName(),
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
     * @param integer $id, id planilla
     * @param integer $unidades, id empresa sub empleadoras
     * retorna planilla prefactura otros bonos (bonos que no salen en la planilla de Sueldos y Salarios)
     */
     public function DescargarPrefacturaOtrosBonos($id,$unidades) {
             
             $unidadesseleccionadas='';
             $titulo='OTROS BONOS ';
             for ($i = 0; $i < count($unidades); $i++) {
                        $unidadesseleccionadas = $unidadesseleccionadas . $unidades[$i] . ',';
                    }
                    if (count($unidades)>0)
                    $unidadesseleccionadas = substr($unidadesseleccionadas, 0, -1);
                else {
                $unidadesseleccionadas=0;    
                }
        $fecha = Yii::app()->rrhh
                ->createCommand("select anio,asientootrosbonosgenerado, case mes when 1 then'ENERO' when 2 then 'FEBRERO'when 3 then 'MARZO' when 4 then 'ABRIL'when 5 then 'MAYO'when 6 then'JUNIO'when 7 then 'JULIO' when 8 then 'AGOSTO' when 9 then 'SEPTIEMBRE'when 10 then 'OCTUBRE'when 11 then 'NOVIEMBRE' else 'DICIEMBRE' end as mes ,( to_char(fechadesde, 'DD-MM-YYYY')||'_' || to_char(fechahasta, 'DD-MM-YYYY')) as fecha ,fechadesde,fechahasta 
 
   from planilla where id=" . $id . " ")
                ->queryAll();
        if($fecha[0]['asientootrosbonosgenerado']==false){
            $titulo='BORRADOR '.$titulo;            
        }        
  
         $cantcolFactura=5;
         $cantcolBeneficio= Yii::app()->rrhh
                ->createCommand("select count(*) as cant from cabecera where idplanilla=$id and enplanilla=false and eliminado=false and grupo=''")
                ->queryScalar()+1;
         $cantcolAporte=Yii::app()->rrhh
                ->createCommand(" select count(*) from(select distinct (json_array_elements( aportacionbeneficio)->>'id')::int from cabecera where idplanilla=$id and enplanilla=false and eliminado=false and grupo='' and aportacionbeneficio::text<>'[]') as t")
                ->queryScalar();
         if ($cantcolAporte>0){
             $cantcolAporte=$cantcolAporte+1;
         }
         
        $mes = $fecha[0]['mes'];
        $anio = $fecha[0]['anio'];
        $nombre = $fecha[0]['fecha'];
        $datoEmpresa = Yii::app()->rrhh
                        ->createCommand("select e.*,pl.nombrer,pl.cir from planilla pl inner join general.representante r on r.cirepresentante=pl.cir inner join general.empresa e on e.id=r.idempresa  where pl.id=" . $id)
                        ->queryAll()[0];
        
        $datoPlanilla = Yii::app()->rrhh
                ->createCommand("select t.idc,t.id,t.unidad,t.nci as ci,split_part(t.extension,'-',2) as extension,case when (t.novedad='' or t.novedad='I') then 'ACTIVO' else 'NO ACTIVO' end novedad,t.cargo,t.tipocontrato,t.ffee,t.fimpuesto,t.general,t.beneficio,t.porcentaje from(select c.id as idc, c.idempleado as id,(select nombre from general.empresasubempleadora where id =a.idempresasubempleadora)as unidad, json_array_elements(general)->>'nci' as nci,
     (json_array_elements(general)->>'ci') as extension,

json_array_elements(general)->>'novedad' as novedad,
json_array_elements(beneficio)->>'totalga' as totalga,
json_array_elements(general)->>'cargo' as cargo, 
( select nombre from general.tipocontrato where id=idtipocontrato) as tipocontrato,


((select dame_fee_planilla ($id,a.idempresasubempleadora))/100) as ffee ,((select dame_impuesto_planilla ($id,a.idempresasubempleadora))/100) as fimpuesto,general,beneficio,a.porcentaje
 from  (SELECT unnest(
  string_to_array(c.idporcentajepago, ',')
)::int as idporcentajepagoempresa ,* from  cuerpo c where eliminado=false and idplanilla =$id and  tipo=1 ) c inner join general.porcentajepago a on a.id=c.idporcentajepagoempresa 
 where c.tipo=1   AND c.idtipocontrato in(SELECT id FROM GENERAL.TIPOCONTRATO WHERE GENERARCC=TRUE
) and c.eliminado=false and c.idempleado in(select  lista_prefactura_otrosbonos($id) and a.idempresasubempleadora in($unidadesseleccionadas)  and c.idplanilla=$id) as t")
             ->queryAll();    
                   
        
  
          
  
      
        $cabeceraPlanilla = Yii::app()->rrhh
                            ->createCommand("(  select c1.orden,case when c1.nombre='Nº' then 'C.I.' when c1.nombre='C.I.' then'EXTENCION' else c1.nombre end as nombre,
 case when c1.nombre='Nº' then 'ci' when c1.nombre='C.I.' then'extension' else c1.nombref end  AS nombref ,c1.tipo from  cabecera c1  where c1.eliminado=false and  c1.idplanilla is null and  c1.tipo =0 
and nombre not in('NOMBRES Y APELLIDOS','APELLIDO MATERNO','APELLIDO PATERNO','NOMBRES','HORAS PAGADAS(DIA)','DIAS PAGADOS(MES)','HABER BASICO')    )union
               (select 200::int as orden,'GRAN TOTAL' as nombre,'grantotal' as nombref,10::int as tipo)
union(select 201::int as orden,'FEE' as nombre,'fee' as nombref,10::int as tipo)
union(select 202::int as orden,'TOTAL + FEE' as nombre,'totalfee' as nombref,10::int as tipo)
union(select 203::int as orden,'IMPUESTO' as nombre,'impuesto' as nombref,10::int as tipo)
union(select 204::int as orden,'TOTAL FACTURACION' as nombre,'totalfacturacion' as nombref,10::int as tipo)
union(select orden,nombre,nombref,tipo from cabecera where idplanilla=$id  and enplanilla=false and eliminado=false and grupo='' )
union(select * from cabecera_prefacturaotrosbonos($id))
union( select c.orden,'TOTAL' as nombre,'total' as nombre,1::int as tipo from cabecera c where c.eliminado=false and c.idplanilla=$id and c.nombref='totalga')
  order by orden asc  ")
                            ->queryAll();
                  
                   
        $cantcolGeneral = Yii::app()->rrhh
                        ->createCommand("select count(*) as cant from  cabecera c1  where c1.eliminado=false AND c1.idplanilla is null  and  c1.tipo =0 and nombre not in('NOMBRES Y APELLIDOS','APELLIDO MATERNO','APELLIDO PATERNO','NOMBRES','HORAS PAGADAS(DIA)','DIAS PAGADOS(MES)','HABER BASICO') ")
                        ->queryScalar()+1;
                  
               
        $nombreArchivo = 'PF_BONOS_' . $nombre;
       
        $columnasGeneral = $this->dameColumna('F', $cantcolGeneral);
        $columnasBeneficio=$this->dameColumna($columnasGeneral[$cantcolGeneral-1], $cantcolBeneficio);
        $columnasAporte=$this->dameColumna($columnasBeneficio[$cantcolBeneficio], $cantcolAporte);
        $columnasFacturas  = $this->dameColumna($columnasAporte[$cantcolAporte], $cantcolFactura);
        $totalcolumnas=$cantcolGeneral+$cantcolFactura+3+$cantcolAporte+$cantcolBeneficio;
        
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
        // COPIA FIEL DE LA PLANILLA GENERAL
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
        $activeSheet->setCellValue('A1', strtoupper("PLANILLA PREFACTURA ".$titulo." CORRESPONDIENTE AL MES DE " . $mes . " " . $anio));
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
             
                if ($cp['tipo'] == 1||$cp['tipo'] == 6) {
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
            
                   
            $ltra = 'M';
            $ltra2 = 'N';
            
            
            ///CUERPO
            for ($i = 0; $i < count($datoPlanilla); $i++) {
                $activeSheet->getStyle($columnasGeneral[$inde] . $kFila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $general = json_decode($datoPlanilla[$i]['general'], true);
                $beneficio = json_decode($datoPlanilla[$i]['beneficio'], true);
                
                $inde = 0;
                $indb = 0;
                $inda = 0;
                $indf=0;
                $montobe = 0;
                $activeSheet->getRowDimension($kFila)->setRowHeight(17);
                $activeSheet->setCellValue( 'A'.$kFila,   $i + 1);
                $activeSheet->setCellValue( 'B'.$kFila,  $anio);
                $activeSheet->setCellValue( 'C'.$kFila, 'SUCRE');
                $activeSheet->setCellValue( 'D'.$kFila,  $datoPlanilla[$i]['unidad']);
                $activeSheet->setCellValue( 'E'.$kFila, $datoPlanilla[$i]['novedad']);
                $activeSheet->getStyle("A".$kFila.":" . $columnasFacturas[$cantcolFactura-1] . $kFila)->applyFromArray(
                        $phpFontCuerpo
                );
                
                foreach ($cabeceraPlanilla as $cp) {
                  
                    if ($cp['tipo'] == 0) {       
                           if($cp['nombref'] === 'extension'){
                                $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, $datoPlanilla[$i] ['extension']);
                            }
                            else if($cp['nombref'] === 'ci'){
                                $activeSheet->setCellValue( $columnasGeneral[$inde].$kFila, $datoPlanilla[$i]['ci']);
                            }
                             else if($cp['nombref'] === 'dias'){
                                $activeSheet->setCellValue( $columnasGeneral[$inde].$kFila,round(((( $general[0][$cp['nombref']])*$datoPlanilla[$i]['porcentaje'])/100),0));
                            }
                            else if ($cp['nombref'] === 'fechai') {
                                $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, date("d/m/Y", strtotime($general[0][$cp['nombref']])));
                            }else if ($cp['nombref'] === 'fechanac') {
                                $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, date("d/m/Y", strtotime($general[0][$cp['nombref']])));
                            } else {//G1
                                $activeSheet->setCellValue($columnasGeneral[$inde] . $kFila, $general[0][$cp['nombref']]);
                            }
                        
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
                                  } elseif ($cp['nombref']=='fee') {
                         $activeSheet->setCellValue($columnasFacturas[$indf] . $kFila, '=round(('.$columnasFacturas[$indf-1]. $kFila.'*'.$datoPlanilla[$i] ['ffee'].' ), 2)');
                      
                        }elseif($cp['nombref']=='totalfee'){
                            $activeSheet->setCellValue($columnasFacturas[$indf] . $kFila, '=round(sum('.$columnasFacturas[$indf-1]. $kFila.':'.$columnasFacturas[$indf-2]. $kFila.'), 2)');
                   
                        }elseif ($cp['nombref']=='impuesto') {
                         $activeSheet->setCellValue($columnasFacturas[$indf] . $kFila, '=round(('.$columnasFacturas[$indf-1]. $kFila.'*'.$datoPlanilla[$i] ['fimpuesto'].' ), 2)');
                      
                        }elseif ($cp['nombref']=='totalfacturacion') {
                          $activeSheet->setCellValue($columnasFacturas[$indf] . $kFila, '=round(sum('.$columnasFacturas[$cantcolFactura-2]. $kFila.':'.$columnasFacturas[$cantcolFactura-3]. $kFila.'), 2)');
                   
                        }
                        

                        ++$indf;
                    }
                    if ($cp['tipo'] == 6||$cp['tipo'] == 1) {

                        $activeSheet->getStyle($columnasBeneficio[$indb] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                        $activeSheet->getStyle($columnasBeneficio[$indb] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        if ($cp['nombref']!=='total')
                        {
                            $monto=(($beneficio[0] [$cp['nombref']])*$datoPlanilla[$i]['porcentaje'])/100;
                            $activeSheet->setCellValue($columnasBeneficio[$indb] . $kFila, round($monto, 2));
                        }else{
                            $activeSheet->setCellValue($columnasBeneficio[$indb] . $kFila, '=round(sum('.$columnasBeneficio[0] . $kFila.':'.$columnasBeneficio[$indb] . $kFila.'),2)');
                        }
                        
                        
                        
            
                        ++$indb;
                    }
                    if ($cp['tipo'] == 2) {

                        $activeSheet->getStyle($columnasAporte[$inda] . $kFila)->getNumberFormat()->setFormatCode('0.00');
                        $activeSheet->getStyle($columnasAporte[$inda] . $kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        if ($cp['nombref']!=='totalaporte')
                        {
                            $monto=Yii::app()->rrhh
                        ->createCommand("select dame_aporteotrobono(".$datoPlanilla[$i]['idc'].",".$cp['nombref'].") ")
                        ->queryScalar();
                            $monto=($monto*$datoPlanilla[$i]['porcentaje'])/100;
                            $activeSheet->setCellValue($columnasAporte[$inda] . $kFila, round($monto, 2));
                        }else{
                            $activeSheet->setCellValue($columnasAporte[$inda] . $kFila, '=round(sum('.$columnasAporte[0] . $kFila.':'.$columnasAporte[$inda] . $kFila.'),2)');
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
        $activeSheet->setCellValue('B6' ,"PRE FACTURA  PLANILLA GLOBAL  ".$mes." ".$anio ); 
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
    public function DescargarPlanillaRCIVA($id) {
      
        $informacion = Yii::app()->rrhh
                ->createCommand("select anio ,case when mes<10 then '0'||mes else mes::text end numeromes ,mes as nmes, case mes when 1 then'ENERO' when 2 then 'FEBRERO'when 3 then 'MARZO' when 4 then 'ABRIL'when 5 then 'MAYO'when 6 then'JUNIO'when 7 then 'JULIO' when 8 then 'AGOSTO' when 9 then 'SEPTIEMBRE'when 10 then 'OCTUBRE'when 11 then 'NOVIEMBRE' else 'DICIEMBRE' end as mes ,( to_char(fechadesde, 'DD-MM-YYYY')||'_' || to_char(fechahasta, 'DD-MM-YYYY')) as fecha,fechadesde,fechahasta ,rciva from planilla where id=" . $id . " ")
                ->queryAll()[0];
        $mes = $informacion['mes'];
        $anio = $informacion['anio'];
        $nombre = $informacion['fecha'];
        $datoEmpresa = Yii::app()->rrhh
                        ->createCommand("select e.*,pl.nombrer,pl.cir from planilla pl inner join general.representante r on r.cirepresentante=pl.cir inner join general.empresa e on e.id=r.idempresa  where pl.id=" . $id)
                        ->queryAll()[0];
      $datoPlanilla = Yii::app()->rrhh
                ->createCommand("select anio,periodo,codigo,nombres,apellidop,apellidom,ci,tipo,novedad,  dosminimos,  form110,case when saldoanterior is null then 0 else saldoanterior end as saldoanterior
,(case when actanterior is null then 0 else actanterior end -case when saldoanterior is null then 0 else saldoanterior end) as act,case when actanterior is null then 0 else actanterior end as actanterior 

 ,impuesto  ,
 case when ( select  saldo from general.formulario110 where eliminado=false and idempleado=t.idempleado and fechapresentacion<=('".$informacion['fechadesde']."'::date-1) order by fecha desc limit 1) is null then 0
  else ( select  saldo from general.formulario110 where eliminado=false and idempleado=t.idempleado and fechapresentacion<=('".$informacion['fechadesde']."'::date-1) order by fechapresentacion desc , fecha desc limit 1) end as saldo ,  
  (totalganado-afp) as liquido,bonos,beneficio
  from (
select c.idempleado,$anio as anio, ".$informacion['nmes']." as periodo,e.codrciva as codigo , p.nombre as nombres,p.apellidop,p.apellidom,p.ci,'CI'::varchar(2) as tipo,
json_array_elements(general)->>'nomvedad' as novedad ,(select  dame_montoneto_rciva('".$informacion['fechadesde']."', '".$informacion['fechahasta']."',c.idempleado)) as montoingreso,
(select monto*2 from planillaretroactivo where eliminado=false and anio<=$anio order by id desc limit 1) as dosminimos,
(select  montopresentado_formulario110( '".$informacion['fechadesde']."', '".$informacion['fechahasta']."' ,c.idempleado)) as form110,
( select  saldo from general.formulario110   where eliminado=false and idempleado=e.id and fechapresentacion <=('".$informacion['fechadesde']."'::date-1) and id<(select  id from general.formulario110   where eliminado=false and idempleado=e.id and fechapresentacion =('".$informacion['fechadesde']."'::date-1) and (montodescontado=0 and montopresentado=0 ) ) order by fechapresentacion desc, fecha desc limit 1 ) as saldoanterior,
(select  saldo from general.formulario110   where eliminado=false and idempleado=e.id and fechapresentacion =('".$informacion['fechadesde']."'::date-1) and (montodescontado=0 and montopresentado=0 ) ) as actanterior,

(json_array_elements(aporte)->>'RCIVA')::numeric(12) as impuesto,
(json_array_elements(c.beneficio)->>'totalga')::numeric(12,2) as totalganado,c.beneficio  as beneficio,
(json_array_elements(c.aporte)->>'AFPAPORTETRABAJADOR')::numeric(12,2) as afp,(select  dame_bonostributaria('".$informacion['fechadesde']."', '".$informacion['fechahasta']."',c.idempleado) ) as bonos

 from cuerpo c inner join general.empleado e on e.id=c.idempleado inner join general.persona p on p.id =e.idpersona where c.eliminado=false and c.idplanilla=$id and c.idtipocontrato in(

select abc.idtipocontrato from general.aportacionbeneficio ab inner join general.aporbetipocont abc on abc.idaportacionbeneficio=ab.id  where ab.id=5
and abc.eliminado=false
) )as t order by t.nombres asc,t.apellidop asc,t.apellidom asc")
                ->queryAll();
        $cabeceraPlanilla = Yii::app()->rrhh
                ->createCommand(" (select 1::int as orden,'AÑO'::varchar(50)as nombre, 'anio'::varchar(50) as nombref, 1::int opcion  )union
(select 2::int as orden,'PERIODO'::varchar(50)as nombre, 'periodo'::varchar(50) as nombref , 1::int opcion  )union
(select 3::int as orden,'CODIGO DEPENDIENTE RC-IVA'::varchar(50)as nombre, 'codigo'::varchar(50) as nombref , 1::int opcion  )union
(select 4::int as orden,'NOMBRES'::varchar(50)as nombre, 'nombres'::varchar(50) as nombref  , 1::int opcion )union
(select 5::int as orden,'PRIMER APELLIDO'::varchar(50)as nombre, 'apellidop'::varchar(50) as nombref  , 1::int opcion )union
(select 6::int as orden,'SEGUNDO APELLIDO'::varchar(50)as nombre, 'apellidom'::varchar(50) as nombref , 1::int opcion  )union
(select 7::int as orden,'CI'::varchar(50)as nombre, 'ci'::varchar(50) as nombref  , 1::int opcion )union
(select 8::int as orden,'TIPO DE DOCUMENTO'::varchar(50)as nombre, 'tipo'::varchar(50) as nombref , 1::int opcion  )union
(select 9::int as orden,'NOVEDAD'::varchar(50)as nombre, 'novedad'::varchar(50) as nombref  , 1::int opcion )union
(select 10::int as orden,'LIQUIDO'::varchar(50)as nombre, 'liquido'::varchar(50) as nombref  , 1::int opcion )union
(select (ROW_NUMBER ()OVER (ORDER BY nombre))+10 as orden  ,nombre, nombref , 0::int as opcion from cabecera where eliminado=false and idplanilla=$id and tipo=6 and grupo='') union

(select (ROW_NUMBER ()OVER (ORDER BY nombre))+100 as orden , nombre as nombre, replace(nombre,' ','')::varchar(50) as nombref , 2::int opcion  from  general.bonoespecial  WHERE eliminado=false AND fechapago
 between '".$informacion['fechadesde']."' and '".$informacion['fechahasta']."' order by nombre asc)union
(select ( select count(*)+14 from general.bonoespecial where eliminado=false and fechapago between '".$informacion['fechadesde']."' and '".$informacion['fechahasta']."') as orden,'PRIMA ANUAL'::varchar(50),'prima'::varchar(50) as nombref, 2::int opcion  from 
general.pagobeneficio where eliminado=false and idtipopagobeneficio =4 and fechapago between '".$informacion['fechadesde']."' and '".$informacion['fechahasta']."' limit 1)union
(select 200::int as orden,'MONTO INGRESO NETO'::varchar(50)as nombre, 'montoingreso'::varchar(50) as nombref  , 3::int opcion )union
(select 201::int as orden,'DOS SALARIOS MINIMOS NACIONALES'::varchar(50)as nombre, 'dosminimos'::varchar(50) as nombref , 1::int opcion  )union
(select 202::int as orden,'IMPORTE SUJETO A IMPUESTO'::varchar(50)as nombre, 'importeimpuesto'::varchar(50) as nombref   , 3::int opcion)union
(select 203::int as orden,'IMPUESTO RC-IVA'::varchar(50)as nombre, 'impuestorciva'::varchar(50) as nombref   , 3::int opcion)union
(select 204::int as orden,'13% DE DOS SALARIOS MINIMOS'::varchar(50)as nombre, 'trecesalario'::varchar(50) as nombref  , 3::int opcion )union
(select 205::int as orden,'IMPUESTO NETO RC-IVA'::varchar(50)as nombre, 'impuestoneto'::varchar(50) as nombref   , 3::int opcion)union
(select 206::int as orden,'FORM 110'::varchar(50)as nombre, 'form110'::varchar(50) as nombref   , 1::int opcion)union
(select 207::int as orden,'SALDO A FAVOR DEL FISCO'::varchar(50)as nombre, 'saldofisco'::varchar(50) as nombref  , 3::int opcion  )union
(select 208::int as orden,'SALDO A FAVOR DEP.'::varchar(50)as nombre, 'saldodep'::varchar(50) as nombref   , 3::int opcion)union
(select 209::int as orden,'SALDO ANTERIOR'::varchar(50)as nombre, 'saldoanterior'::varchar(50) as nombref  , 1::int opcion )union
(select 210::int as orden,'ACT.'::varchar(50)as nombre, 'act'::varchar(50) as nombref   , 1::int opcion)union
(select 211::int as orden,'SALDO ANTERIOR ACT.'::varchar(50)as nombre, 'actanterior'::varchar(50) as nombref , 3::int opcion  )union
(select 212::int as orden,'SALDO UTILIZADO'::varchar(50)as nombre, 'saldoutilizado'::varchar(50) as nombref   , 3::int opcion)union
(select 213::int as orden,'IMPUESTO RC-IVA RETENIDO'::varchar(50)as nombre, 'impuesto'::varchar(50) as nombref  , 3::int opcion )union
(select 214::int as orden,'SALDO SIGUIENTE MES'::varchar(50)as nombre, 'saldo'::varchar(50) as nombref  , 3::int opcion ) order by orden asc
 ")
                ->queryAll();
     
        $nombreArchivo = 'PLA_' . $datoEmpresa['nit'].'_'.$anio.'_'. $informacion['numeromes'];
        
        $numcol = Yii::app()->rrhh
                ->createCommand("select sum(cantidad)+28 from((select count(*)  as cantidad ,1::int as opcion from  general.bonoespecial  WHERE eliminado=false AND fechapago between '".$informacion['fechadesde']."' and '".$informacion['fechahasta']."' )
                    union (select 1::int as cantidad ,2::int as opcion from  general.pagobeneficio where eliminado=false and idtipopagobeneficio =4 and fechapago between '".$informacion['fechadesde']."' and '".$informacion['fechahasta']."' limit 1)
                    union ( select count(*) as cantidad, 3::int as opcion from cabecera where eliminado=false and idplanilla=$id and tipo=6 and grupo='')     
                        ) as t  ")
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
           );
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

       
        $activeSheet->getColumnDimension('A')->setWidth(10);
        $activeSheet->getColumnDimension('B')->setWidth(10);
        $activeSheet->getColumnDimension('C')->setWidth(20);
        $activeSheet->getColumnDimension('D')->setWidth(30);
        $activeSheet->getColumnDimension('E')->setWidth(25);
        $activeSheet->getColumnDimension('F')->setWidth(25);
        $activeSheet->getColumnDimension('G')->setWidth(15);
        $activeSheet->getColumnDimension('H')->setWidth(10);
        $activeSheet->getColumnDimension('I')->setWidth(10);
        for($i=9;$i<$numcol;$i++){
             $activeSheet->getColumnDimension($columnascabecera[$i])->setWidth(20);
        }       
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
             
        $activeSheet->setCellValue('A1', strtoupper("PLANILLA TRIBUTARIA CORRESPONDIENTE AL MES DE " . $mes . " " . $anio));
        $activeSheet->setCellValue('A3', strtoupper($datoEmpresa['cns']));
        $activeSheet->setCellValue('A5', 'NIT : '.$datoEmpresa['nit']);
       
     
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
        $activeSheet->getStyle('A7:'.$columnascabecera[$numcol-1].'7')->applyFromArray($phpFontC);
        $activeSheet->getStyle("A7:".$columnascabecera[$numcol-1]."7")->getAlignment()->setWrapText(true);
        $ind = 0;
        
        foreach ($cabeceraPlanilla as $cp) {
            $activeSheet->setCellValue($columnas[$ind] . '7', $cp['nombre']);
            ++$ind;            
            
        }

        
        ///CUERPO
       $activeSheet->setCellValue($columnas[16] . 10,$columnas[16]);
                  
       for ($i = 0; $i < count($datoPlanilla); $i++) {
             $bonos = json_decode($datoPlanilla[$i]['bonos'], true);
              $ind = 0;
              $activeSheet->getStyle($columnas[9].$kFila.':'.$columnas[$numcol].$kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
              $activeSheet->getStyle($columnas[0].$kFila.':'.$columnas[8].$kFila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
               $beneficio = json_decode($datoPlanilla[$i]['beneficio'], true);
            foreach ($cabeceraPlanilla as $cp) {
                $activeSheet->getRowDimension($kFila)->setRowHeight(23);
               
                    $activeSheet->getStyle($columnas[$ind] . $kFila)->applyFromArray($phpFont2);
                    
                    if($cp['opcion']==0){
                         $montobe = $beneficio[0][$cp['nombref']];
                         $activeSheet->setCellValue($columnas[$ind] . $kFila, $montobe);
              
                    }elseif ($cp['opcion']==1) {
                       
                    if (($cp['nombref']=='dosminimos'))
                    {   
                         $activeSheet->setCellValue($columnas[$ind] . $kFila, "=IF(".$columnas[$ind-1] .($kFila)."<".$datoPlanilla[$kFila-8][$cp['nombref']].",(".$columnas[$ind-1] .($kFila)."),".$datoPlanilla[$kFila-8][$cp['nombref']].")");
               
                    }else{
                         $activeSheet->setCellValue($columnas[$ind] . $kFila, $datoPlanilla[$kFila-8][$cp['nombref']]);
                    }
                       
                    
                  } elseif ($cp['opcion']==2) {
                      $monto=($bonos[0] [$cp['nombref']]);
                            
                         $activeSheet->setCellValue($columnas[$ind] . $kFila,$monto);
                   
                  }
                  else{
                       
                       
                        switch ($cp['nombref']){
                            case 'montoingreso':{
                                  $activeSheet->setCellValue($columnas[$ind] . $kFila,"=round(sum(J".($kFila).":".$columnas[$ind-1].($kFila) ."),0)");
                   
                                break;
                            }
                            case 'importeimpuesto':{
                                 $activeSheet->setCellValue($columnas[$ind] . $kFila,"=".$columnas[$ind-2] .($kFila)."-".$columnas[$ind-1].($kFila) );
                            break;
                            }
                            
                            case "impuestorciva":{
                               $activeSheet->setCellValue($columnas[$ind] . $kFila,"=round((".$columnas[$ind-1] .($kFila)."* ".$informacion['rciva'].")/100,0)" );
                          
                                break;
                            }
                            case "trecesalario":{
                                
                             //   $activeSheet->setCellValue($columnas[$ind] . $kFila,"=round((".$columnas[$ind-3] .($kFila)."* ".$informacion['rciva'].")/100,0)" );
                                                                                                                            //=IF(R14>0, (ROUND((P14* 13)/100)~0),0)            
                            $activeSheet->setCellValue($columnas[$ind] . $kFila,"=IF(".$columnas[$ind-1] .($kFila).">0,((".$columnas[$ind-3] .($kFila)." * ".$informacion['rciva'].")/100),0)" );
                          
                                break;
                            }
                            case "impuestoneto":{
                                
                                $activeSheet->setCellValue($columnas[$ind] . $kFila,"=IF(".$columnas[$ind-2] .($kFila).">".$columnas[$ind-1] .($kFila).",(".$columnas[$ind-2] .($kFila)."-".$columnas[$ind-1] .($kFila)."),0)" );
                          
                                break;
                            }
                            case "saldofisco" :{
                                                                                        //=IF(O10>P10,O10-P10,0)
                                $activeSheet->setCellValue($columnas[$ind] . $kFila,"=IF(".$columnas[$ind-2] .($kFila).">".$columnas[$ind-1] .($kFila).",(".$columnas[$ind-2] .($kFila)."-".$columnas[$ind-1] .($kFila)."),0)" );
                          
                                break;
                            }
                            case "saldodep":{
                                 $activeSheet->setCellValue($columnas[$ind] . $kFila,"=IF(".$columnas[$ind-2] .($kFila).">".$columnas[$ind-3] .($kFila).",(".$columnas[$ind-2] .($kFila)."-".$columnas[$ind-3] .($kFila)."),0)" );
                          
                                break;
                            }
                            case "actanterior":{
                                 $activeSheet->setCellValue($columnas[$ind] . $kFila,"=".$columnas[$ind-2] .($kFila)."+".$columnas[$ind-1] .($kFila) );
                          
                                break;
                            }
                            case "saldoutilizado":{
                                                                                                                             //                                                                                                             Q=5	R=4 U=1

                                $activeSheet->setCellValue($columnas[$ind] . $kFila,"=IF(".$columnas[$ind-4] .($kFila)."+".$columnas[$ind-1] .($kFila)."=0,0,IF(".$columnas[$ind-5] .($kFila).">(".$columnas[$ind-4] .($kFila)."+".$columnas[$ind-1] .($kFila)."),(".$columnas[$ind-4] .($kFila)."+".$columnas[$ind-1] .($kFila)."),".$columnas[$ind-5] .($kFila)."))");
                          
                                break;
                            }
                            case "impuesto":{
                                $activeSheet->setCellValue($columnas[$ind] . $kFila,"=".$columnas[$ind-6] .($kFila)."-".$columnas[$ind-1] .($kFila) );
                          
                                    break;
                            }
                             case "saldo":{
                                $activeSheet->setCellValue($columnas[$ind] . $kFila,"=".$columnas[$ind-6] .($kFila)."+".$columnas[$ind-3] .($kFila)."-".$columnas[$ind-2] .($kFila) );
                          
                                    break;
                            }
                            default:{
                                break;
                            }
                            
                        }
                }
                   

                    ++$ind;        
                
                
            }           

            $kFila++;
        }
       


      
      
       
       
        $this->descargarExcel($objPHPExcel, $nombreArchivo);
    }
    /**
     * 
     * @param object $objPHPExcel, con la informacion del archivo que se desea generar
     * @param string $nombreArchivo, nombre del archivo con el que se va generar el archivo csv
     */
    private function descargarCsv($objPHPExcel, $nombreArchivo) {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $nombreArchivo . '.csv"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
        $objWriter->setDelimiter(';');         
        $objWriter->setPreCalculateFormulas(true);
        $objWriter->save('php://output');
    }
        public function DescargarPlanillaRCIVACsv($id) {
      
        $informacion = Yii::app()->rrhh
                ->createCommand("select anio ,case when mes<10 then '0'||mes else mes::text end numeromes,mes as nmes, case mes when 1 then'ENERO' when 2 then 'FEBRERO'when 3 then 'MARZO' when 4 then 'ABRIL'when 5 then 'MAYO'when 6 then'JUNIO'when 7 then 'JULIO' when 8 then 'AGOSTO' when 9 then 'SEPTIEMBRE'when 10 then 'OCTUBRE'when 11 then 'NOVIEMBRE' else 'DICIEMBRE' end as mes ,( to_char(fechadesde, 'DD-MM-YYYY')||'_' || to_char(fechahasta, 'DD-MM-YYYY')) as fecha,fechadesde,fechahasta ,rciva from planilla where id=" . $id . " ")
                ->queryAll()[0];
        $datoEmpresa = Yii::app()->rrhh
                        ->createCommand("select e.*,pl.nombrer,pl.cir from planilla pl inner join general.representante r on r.cirepresentante=pl.cir inner join general.empresa e on e.id=r.idempresa  where pl.id=" . $id)
                        ->queryAll()[0];
        $mes = $informacion['mes'];
        $anio = $informacion['anio'];
        $nombre = $informacion['fecha'];
       
      $datoPlanilla = Yii::app()->rrhh
                ->createCommand("select anio,periodo,codigo,nombres,apellidop,apellidom,ci,tipo,novedad,  montoingreso, case when montoingreso> dosminimos then dosminimos else montoingreso end as dosminimos,
                    (montoingreso-case when montoingreso> dosminimos then dosminimos else montoingreso end) as montosujetoimpuesto,  form110,case when saldoanterior is null then 0 else saldoanterior end as saldoanterior
                ,(case when actanterior is null then 0 else actanterior end -case when saldoanterior is null then 0 else saldoanterior end) as act,case when actanterior is null then 0 else actanterior end as actanterior 

                 ,impuesto  ,
                 case when ( select  saldo from general.formulario110 where eliminado=false and idempleado=t.idempleado and fechapresentacion<=('".$informacion['fechadesde']."'::date-1) order by fecha desc limit 1) is null then 0
                  else ( select  saldo from general.formulario110 where eliminado=false and idempleado=t.idempleado and fechapresentacion<=('".$informacion['fechadesde']."'::date-1) order by fechapresentacion desc , fecha desc limit 1) end as saldo ,  
                  case  activo when 1 then 'I'::char(1) when 0 then'D'::char(1) else 'V'::char(1) end as activo

                  from (
                select c.idempleado,$anio as anio, ".$informacion['nmes']." as periodo,e.codrciva as codigo , p.nombre as nombres,p.apellidop,p.apellidom,p.ci,'CI'::varchar(2) as tipo,
                json_array_elements(general)->>'nomvedad' as novedad ,(select  dame_montoneto_rciva('".$informacion['fechadesde']."'::date, '".$informacion['fechahasta']."'::date,c.idempleado)) as montoingreso,
                (select (monto*2)::int from planillaretroactivo where eliminado=false and anio<=$anio order by id desc limit 1) as dosminimos,
                (select  montopresentado_formulario110( '".$informacion['fechadesde']."'::date, '".$informacion['fechahasta']."'::date ,c.idempleado)) as form110,
                ( select  saldo from general.formulario110   where eliminado=false and idempleado=e.id and fechapresentacion <=('".$informacion['fechadesde']."'::date-1) and id<(select  id from general.formulario110   where eliminado=false and idempleado=e.id and fechapresentacion =('".$informacion['fechadesde']."'::date-1) and (montodescontado=0 and montopresentado=0 ) ) order by fechapresentacion desc, fecha desc limit 1 ) as saldoanterior,
                (select  saldo from general.formulario110   where eliminado=false and idempleado=e.id and fechapresentacion =('".$informacion['fechadesde']."'::date-1) and (montodescontado=0 and montopresentado=0 ) ) as actanterior,

                (json_array_elements(aporte)->>'RCIVA')::numeric(12) as impuesto,
              

                ( select  activo  from general.historialestadoempleado hee where hee.eliminado=false  and hee.idempleado =c.idempleado and hee.fecharetiro between '".$informacion['fechadesde']."'::date and '".$informacion['fechahasta']."'::date  order by hee.id desc limit 1 ) as activo

                 from cuerpo c inner join general.empleado e on e.id=c.idempleado inner join general.persona p on p.id =e.idpersona where c.eliminado=false and c.idplanilla=$id and c.idtipocontrato in(

                select abc.idtipocontrato from general.aportacionbeneficio ab inner join general.aporbetipocont abc on abc.idaportacionbeneficio=ab.id  where ab.id=5
                and abc.eliminado=false
                ) )as t order by t.nombres asc,t.apellidop asc,t.apellidom asc")
                ->queryAll();
        
        $nombreArchivo = 'PLA_' . $datoEmpresa['nit'].'_'.$anio.'_'. $informacion['numeromes'];
   
       
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);

        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $activeSheet->setTitle($nombreArchivo);
   
        $phpFont = array('font' => array(
                'size' => 7.5,
                'name' => 'Times New Roman',
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );
       
       
        $activeSheet->getColumnDimension('A')->setWidth(10);
        $activeSheet->getColumnDimension('B')->setWidth(10);
        $activeSheet->getColumnDimension('C')->setWidth(20);
        $activeSheet->getColumnDimension('D')->setWidth(30);
        $activeSheet->getColumnDimension('E')->setWidth(25);
        $activeSheet->getColumnDimension('F')->setWidth(25);
        $activeSheet->getColumnDimension('G')->setWidth(15);
        $activeSheet->getColumnDimension('H')->setWidth(10);
        $activeSheet->getColumnDimension('I')->setWidth(10);
              
        
        ///CUERPO
                  
       for ($i = 0; $i < count($datoPlanilla); $i++) {
             $activeSheet->setCellValue( 'A'.($i+1), $datoPlanilla[$i]['anio']);
             $activeSheet->setCellValue( 'B'.($i+1), $datoPlanilla[$i]['periodo']);
             $activeSheet->setCellValue( 'C'.($i+1), $datoPlanilla[$i]['codigo']);
             $activeSheet->setCellValue( 'D'.($i+1), $datoPlanilla[$i]['nombres']);
             $activeSheet->setCellValue( 'E'.($i+1), $datoPlanilla[$i]['apellidop']);
             $activeSheet->setCellValue( 'F'.($i+1), $datoPlanilla[$i]['apellidom']);
             $activeSheet->setCellValue( 'G'.($i+1), $datoPlanilla[$i]['ci']);
             $activeSheet->setCellValue( 'H'.($i+1), 'CI');
             $activeSheet->setCellValue( 'I'.($i+1), $datoPlanilla[$i]['activo']);
             $activeSheet->setCellValue( 'J'.($i+1), $datoPlanilla[$i]['montoingreso']);
             $activeSheet->setCellValue( 'K'.($i+1), $datoPlanilla[$i]['dosminimos']);
             $activeSheet->setCellValue( 'L'.($i+1), $datoPlanilla[$i]['montosujetoimpuesto']);
             $impuesto=round(($datoPlanilla[$i]['montosujetoimpuesto']*$informacion['rciva'])/100,0);
             $activeSheet->setCellValue( 'M'.($i+1), $impuesto);
             $treceminimo=0;
             if($impuesto>0){
                 $treceminimo=round(($datoPlanilla[$i]['dosminimos']*$informacion['rciva'])/100,0);
             }
             $activeSheet->setCellValue( 'N'.($i+1), $treceminimo);
             
             $impuestoneto=0;
             if($impuesto>$treceminimo){
                 $impuestoneto=$impuesto-$treceminimo;
             }
             $activeSheet->setCellValue( 'O'.($i+1), $impuestoneto);
             
             
             $activeSheet->setCellValue( 'P'.($i+1),$datoPlanilla[$i]['form110']);
             $saldofisco=0;
             if($impuestoneto>$datoPlanilla[$i]['form110']){
                 $saldofisco=$impuestoneto-$datoPlanilla[$i]['form110'];
             }
             $saldodependientiente=0;
             if($datoPlanilla[$i]['form110']>$impuestoneto){
                 $saldodependientiente=$datoPlanilla[$i]['form110']-$impuestoneto;
             }
             $activeSheet->setCellValue( 'Q'.($i+1), $saldofisco);
             $activeSheet->setCellValue( 'R'.($i+1), $saldodependientiente);
             $activeSheet->setCellValue( 'S'.($i+1), $datoPlanilla[$i]['saldoanterior']);
             $activeSheet->setCellValue( 'T'.($i+1), $datoPlanilla[$i]['act']);
             $activeSheet->setCellValue( 'U'.($i+1), $datoPlanilla[$i]['actanterior']);
             if($saldodependientiente+$datoPlanilla[$i]['actanterior']){
                 $saldoutilizado=0;
             }
             elseif ($saldofisco>($saldodependientiente+$datoPlanilla[$i]['actanterior'])) {
                $saldoutilizado=$saldodependientiente+$datoPlanilla[$i]['actanterior'];
             }else{
                $saldoutilizado= $saldofisco;
            }
                            //=+Q10-V10
             $impuestoretenido=$saldofisco-$saldoutilizado;
             
             $activeSheet->setCellValue( 'W'.($i+1), $saldoutilizado);
             $activeSheet->setCellValue( 'V'.($i+1), $impuestoretenido);
             $saldosiguientemes=$saldodependientiente+$datoPlanilla[$i]['actanterior']-$impuestoretenido;
             $activeSheet->setCellValue( 'X'.($i+1), 0);
             $activeSheet->setCellValue( 'Y'.($i+1),0);
             $activeSheet->setCellValue( 'Z'.($i+1), 0);
             $activeSheet->setCellValue( 'AA'.($i+1),0);
             $activeSheet->setCellValue( 'AB'.($i+1), 0);
             $activeSheet->setCellValue( 'AC'.($i+1), $saldosiguientemes);
             $activeSheet->setCellValue( 'AD'.($i+1), 0);
             
            

        }
       


      
      
       
       
        $this->descargarCsv($objPHPExcel, $nombreArchivo);
    }
    
}
