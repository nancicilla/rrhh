<?php
/*
 * PersonaController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 31/03/2019
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

class PersonaController extends Controller
{
       private $SUB_DIRECTORY = '/persona/images/';

    /**
     *
     * @var string  nombre del directorio donde se subiran los archivos      
     */
    private $UPLOAD_DIRECTORY = '/uploads';

    /**
     *
     * @var string  nombre del utilizado para subir archivos     
     */
    public $UPLOAD_FILE = '/upload.php';

    /**
     *
     * @var string  nombre del utilizado para eliminar archivos subidos     
     */
    public $DELETE_FILE = '/delete.php';

    /**
     *
     * @var string  nombre del archivo imagen utilizado cuando no cuente con ninguna imagen    
     */
    public $NO_PHOTO_FILE = '/no_photo_small.png';
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
     public function verificar($valor)
    {
        if ($valor<10) {
                    $valor='0'.intval($valor);
                }
          return $valor;      
    }

    public function actionView($id)
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
       // $model = $this->loadModel(SeguridadModule::dec($id));
        $model=Empleado::model()->find('t.idpersona='.SeguridadModule::dec($id),array('order'=>'t.id DESC limit 1'));
        $modeleu=new Entregauniforme;         
        $listauniformes = Entregauniforme::model()->listaUniformes($model->id);
        $modeleud=new Entregauniforme; 
        $model->scenario = 'view';
        $bandera =0;
        if (isset($_POST['gridDevolucion'])) {
         
            if ($_POST['Persona']['fechadevolucion']!='') {
                 
                 
                  Entregauniforme::model()->guardarDebolucionUniforme($model->id,$_POST['gridDevolucion'],$_POST['Persona']['fechadevolucion'],$_POST['Persona']['descripcion_devolucion']);
            }
           $bandera++;
     
        
        }
         if (isset($_POST['Persona'])) {
         
            if ($_POST['Persona']['fechaentrega']!='') {
            $modeleu->fechaentrega=$_POST['Persona']['fechaentrega'];
            $modeleu->descripcion_entrega=strtoupper( $_POST['Persona']['descripcion_entrega']);
            $modeleu->fechadevolucion=null;
            $modeleu->idempleado=$model->id;
            $modeleu->save();    
            }
   
               $bandera++;
        
        }
        if($bandera>0){
           
                    
          echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
        }

        $this->renderPartial('_asignar', array(
            'model' => $model,
            'modeleu'=>$modeleu,
            'listauniformes'=>$listauniformes,
             'modeleud'=>$modeleud,
            
            ), false, true);
    }

    /**
     * Creates a new model.
     */
    public function actionCreate()
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
       $model=new Persona;
       $modele= new Empleado;       
       $direccion= new Direccion;       
       $fotoPersona = array();   
       $secciones=array();
       $modelc= new Contrato;
       $modelmp= new  Movimientopersonal;
       $modeld=array();
       $lista=array();
       $listahorario=array();
       $modelns= new Nivelsalarial();
       $modelhistorial= new Historialestadoempleado;
       $historialContrato= new Historialcontrato;
       $no_photo = $this->NO_PHOTO_FILE;
        $sueldos=  Yii::app()->rrhh
                ->createCommand("select id, nombre||'('||sueldo||' Bs.)' as sueldo from general.nivelsalarial where eliminado =false")
                ->query();
        if(isset($_POST['Persona'])){
            if ( $_POST['Persona']['idhorario']!='' &&$_POST['Persona']['idnivelsalarial']!='' && $_POST['Persona']['fechaantiguedad']!='' && $_POST['Persona']['fechaplanilla']!='' && $_POST['Persona']['fechaultidemnizacion']!=''){
            $per=Persona::model()->find("t.ci='".$_POST['Persona']['ci']."'");
            if (count($per)==0) {
                $model->attributes=$_POST['Persona'];
                $idm=$_POST['Persona']['idmunicipio'];
                   if($idm==''){
                       $municipio= new Municipio;
                       $municipio->nombre=strtoupper($_POST['Persona']['municipio']);
                       $municipio->save();
                       $idm=$municipio->id;
                     
                   }
                                
               if ($model->idlocalidad=='') 
               {
                   
                   
                     $localidad= new Localidad;
                       $localidad->nombre=strtoupper($_POST['Persona']['localidad']);
                       $localidad->idmunicipio=$idm;
                       $localidad->save();
                       $model->idlocalidad=$localidad->id;
                   
               }
                $direccion->attributes=$_POST['Persona'];
                $direccion->save();
                //if (isset($_POST['fotoPersona'])) {         
                if (true) {
                                   $fotoPersona = $_POST['fotoPersona'];                  
                    $model->iddireccion=$direccion->id;
                    $model->nombrecompleto=trim(strtoupper($model->apellidop).' '.strtoupper($model->apellidom).' '.strtoupper($model->nombre));
                    $model->complementoci=strtoupper($_POST['Persona']['complementoci']);
                    /*
                        DESCOMENTAR LA SIGUENTE FILA PARA EL REGISTRO DE LA FOTOGRAFIA
                    -------------------------*/
                  //  $nombreArchivo=Persona::model()->registrarImagen( $fotoPersona, Yii::app()->session['directorioTemporal'],$model->id);
                    //$model->foto=$nombreArchivo;
                    $model->save();
                               $nombreArchivo=Persona::model()->registrarImagen( $fotoPersona, Yii::app()->session['directorioTemporal'],$model->id);
                            $model->foto=$nombreArchivo;
                    $model->save();
                            $modele->attributes=$_POST['Persona'];
                    $modele->codrciva=$_POST['Persona']['codrciva'];
                    if($_POST['Persona']['idafp'] == '')
                        $modele->idafp=null;
                    else
                        $modele->idafp=$_POST['Persona']['idafp'];
                       
                        if($model->save()){  
                            $modele->idpersona=$model->id;
                           if ( $modele->save()){
                            $idempleado=$modele->id;
                            $modelc->attributes=$_POST['Persona'];
                            $historialContrato->attributes=$_POST['Persona'];
                            //$modelc->fechai=$_POST['Persona']['fechaplanilla'];
                            $modelc->save();
                            $modelmp->attributes=$_POST['Persona'];
                            $modelmp->fechaini=$_POST['Persona']['fechaplanilla'];
                            $modelmp->idempleado=$idempleado;
                          
                            $modelmp->estado=true;                   
                            if($modelmp->save()){

                            }else{
                                echo System::hasErrors('La persona-movimiento ya existe!!! ', $modelmp);
                                return;

                            }
                            
                            Yii::app()->rrhh
                                ->createCommand("select registrar_historialempleado (".$idempleado.", ".$modelc->id.",'".$_POST['Persona']['fechaplanilla']."'::date,'".$_POST['Persona']['fechaantiguedad']."'::date,'".$_POST['Persona']['fechaultidemnizacion']."'::date,'".$_POST['Persona']['fechafincontrato']."',".$_POST['Persona']['idnivelsalarial'].",".$_POST['Persona']['idpuestotrabajo'].",'".Yii::app()->user->getName()."')")
                                    ->execute();
                           
                                Dependiente::model()->registrarDependientes($model,$_POST['gridDependientes']);
                                Porcentajepago::model()->registrarPorcentajes($modele->id,$_POST['Persona']['fechaplanilla'],$_POST['gridPorcentajespago']);
                                
                                Yii::app()->rrhh
                                ->createCommand(" select public.migrar_selladas_tmp(".$model->ci."::int,'".$_POST['Persona']['fechaplanilla']."'::date,now()::date)")
                                ->execute();
                                Yii::app()->rrhh
                                ->createCommand(" select registrarusuario('".$model->ci."','".$model->nombre."','".$model->apellidop."')")
                                ->execute();                                       
                                echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                            return;
                        }else {
                         
                           echo System::hasErrors('Revise los datos empleado! ', $modele);
                            return;
                        }
                            
                        } else {
                            echo System::hasErrors('Revise los datos.! ', $model);
                            return;
                            }
            }
            else{
                echo System::hasErrors('No se pudo subir la  foto! ', $model);
                return;

            }
            }else{
               
                echo System::hasErrors('Revise los datos! ', $model);
                return;

            }
        }else{
            echo System::hasErrors('La persona ya existe!!! ', $model);
                return;
        }


    
        }else {
              $this->directorioTemporal(); 
        
/*
DESCMENTAR LA SIGUIENTE FILA PARA REGISTRAR FOTOGRAFIA
--------------------------
           $this->directorioTemporal();  */
        }

        $this->renderPartial('create',array(
            'model'=>$model,
            'fotoPersona'=>$fotoPersona,
            'direccion'=>$direccion,
            'secciones'=>$secciones,
            'modelc'=>$modelc,
            'listahorario'=>$listahorario,
            'puestotrabajos'=>array(),
            'modelns'=>$modelns,
            'modeld'=>$modeld,
            'modelmp'=>$modelmp,
            'sueldos'=>$sueldos,
            'modele'=>$modele,
            'modelhistorial'=>$modelhistorial,
            'lista'=>$lista,
            'historialContrato'=>$historialContrato
                    ), false, true);
    }
    
  
    /**
     * Updates a particular model.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {

        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
          $existeImagen = 'false';
        $model=$this->loadModel(SeguridadModule::dec($id));
        $model->fechanac= date ("d-m-Y",strtotime( $model->fechanac));
        $modele=$model->empleados[0];
        $modele->ultimaevaluacion= Yii::app()->rrhh->createCommand("select evaluacion from( select (json_array_elements( evaluacion)->>'fecha')::timestamp as fecha,json_array_elements( evaluacion)->>'evaluacion' as evaluacion from general.empleado where id=".$modele->id." ) as t order by t.fecha desc limit 1 ")->queryScalar();
        
        $model->codrciva=$modele->codrciva;
        $modeld=Dependiente::model()->listaDependiente($model->id);
        $lista= Porcentajepago::model()->listaPagos($modele->id);
        if( empty( $model->iddireccion0)){
           $direccion=new Direccion; 
        }else{
            $direccion=$model->iddireccion0;
        }
        
        
        $model->scenario='update';
        $model->localidad= $model->idlocalidad0->nombre;
        $model->municipio=$model->idlocalidad0->idmunicipio0->nombre;
        $model->idmunicipio=$model->idlocalidad0->idmunicipio0->id;
        //  $productoImagen = Productocaracteristica::model()->cargarCaracteristicaImagen(SeguridadModule::dec($id));
                   
        $fotoPersona = array();
        $modelmp=$modele->dameMovimiento();
        
        $criteria=new CDbCriteria;
        $criteria->compare('t.idempleado',$modele->id);
        $criteria->order='t.id desc';
        $criteria->limit='1';
        $modelhistorial=Historialestadoempleado::model()->find($criteria);
        $modelhistorial->fechaantiguedad= date ("d-m-Y",strtotime( $modelhistorial->fechaantiguedad));
        $modelhistorial->fechaplanilla= date ("d-m-Y",strtotime( $modelhistorial->fechaplanilla));
        $modelhistorial->fechaultidemnizacion= date ("d-m-Y",strtotime( $modelhistorial->fechaultidemnizacion));
        $modelhistorial->fechafincontrato= date ("d-m-Y",strtotime( $modelhistorial->fechafincontrato));
        $listabono=Yii::app()->rrhh
            ->createCommand("select eb.id,b.nombre,eb.monto::numeric(12,2) from general.bono b inner join empleadobono eb on eb.idbono=b.id where b.eliminado=false and eb.eliminado=false and eb.idempleado=".$modele->id)
            ->queryAll();
        $lista= Porcentajepago::model()->listaPagosfecha($modele->id); 
        if($modelhistorial->activo==1){
        $modelc= Contrato::model()->find('t.idhistorialestadoempleado='.$modelhistorial->id);}
        else{
            $criteria=new CDbCriteria;
            $criteria->compare('t.idempleado',$modele->id);
            $criteria->addCondition("t.id < ".$modelhistorial->id);
            $criteria->order='t.id desc';
            $criteria->limit='1';
            $modelhistoriala=Historialestadoempleado::model()->find($criteria);
            $modelc= Contrato::model()->find('t.idhistorialestadoempleado='.$modelhistoriala->id);
        }
       /* if (isset($modelc->fechai)) {
          $modelc->fechai=date ("d-m-Y",strtotime( $modelc->fechai));
        }*/
        if (isset($modele->fechaingreso)) {
          $modele->fechaingreso=date ("d-m-Y",strtotime( $modele->fechaingreso));
        }
        $historialContrato=$modelc->dameHistorialContrato();   
        $modelns=$historialContrato->idnivelsalarial0;
        $historialContrato->nivelsalarial=$historialContrato->idnivelsalarial0->sueldo.' Bs.('.$historialContrato->idnivelsalarial0->nombre.')';
        $puestotrabajos=$historialContrato->damePuestotrabajo();
        $listahorario=$modelmp->dameHorarios();
        if (count($listahorario)==0) {
         $modelmp->idhorario=null;
        }
        
        $sueldos=  Yii::app()->rrhh
            ->createCommand("select id, nombre||'('||sueldo||' Bs.)' as sueldo from general.nivelsalarial where eliminado =false order by general.nivelsalarial.sueldo asc")
            ->query();
        
           if ($puestotrabajos[0]->idseccion0!=null) {
             $model->unidad=$puestotrabajos[0]->idseccion0->idarea0->idunidad0;
             $model->area=$puestotrabajos[0]->idseccion0->idarea0;
             $model->idseccion=$puestotrabajos[0]->idseccion;
             $criteria=new CDbCriteria;
             $criteria->compare('t.idarea',$puestotrabajos[0]->idseccion0->idarea);
             $criteria->order='t.nombre asc';
             $secciones= Seccion::model()->findAll($criteria);
               // $model->area='sasa';
               }else{
                 $model->area='ssss';
                 $model->idseccion='ss';
                
                 $secciones= array();
    

           }
       
         
       
          /*
   $hmaux=$this->horasMes(3,$model->empleados[0]->id);
          //echo ;
          $vec=explode(',', $hmaux[0]['cantidadhoras']);
          $model->hmes= substr($vec[0],1 );
          $model->minmes=substr($vec[1],0,-1 );*/
          $model->hmes= 'MODIFICAR ';
          $model->minmes='MODIFICAR';
  
     
    
   array_push($fotoPersona,array('id'=>$model->id,'archivo'=>'uploads/'.$model->foto));


        if(isset($_POST['Persona']))
        {
             $model->attributes=$_POST['Persona'];
              $idm=$_POST['Persona']['idmunicipio'];
                   if($idm==''){
                       $municipio= new Municipio;
                       $municipio->nombre=strtoupper($_POST['Persona']['municipio']);
                       $municipio->save();
                       $idm=$municipio->id;
                     
                   }
                                
               if ($model->idlocalidad=='') 
               {           
                     $localidad= new Localidad;
                       $localidad->nombre=strtoupper($_POST['Persona']['localidad']);
                       $localidad->idmunicipio=$idm;
                       $localidad->save();
                       $model->idlocalidad=$localidad->id;
                   
               }
             
             
           
            $model->complementoci=strtoupper($_POST['Persona']['complementoci']);
            $model->nombrecompleto=trim(strtoupper($model->apellidop).' '.strtoupper($model->apellidom).' '.strtoupper($model->nombre));
             if($_POST['Persona']['telefono']!=''){
                 $model->telefono=$_POST['Persona']['telefono'];
             }
            if($model->save()){
                $direccion->attributes=$_POST['Persona'];
                  if($_POST['Persona']['zona']!=''){
                 $direccion->zona=$_POST['Persona']['zona'];
             }
                $direccion->save();
                if (empty( $model->iddireccion0)){
                    $model->iddireccion=$direccion->id;
                    $model->save();
                }
                $analizarsellada=$modele->analizarsellada;
                $modele->attributes=$_POST['Persona'];
                
                $modele->codrciva=$_POST['Persona']['codrciva'];
                if($_POST['Persona']['idafp'] == '')
                        $modele->idafp=null;
                    else
                     $modele->idafp=$_POST['Persona']['idafp'];
                
                $modele->save();
                $modele->registrarEvaluacion($_POST['Persona']['observacion']);
                if($analizarsellada!=$modele->analizarsellada){
                Yii::app()->rrhh->createCommand("select  actualizar_selladas( ".$modele->id.",'".$modele->usuario."') ")->execute();
                }
               if($_POST['Persona']['fechafincontrato']!=='31-12-1969')
                {
                    Yii::app()->rrhh
                    ->createCommand("update general.historialestadoempleado set fechafincontrato='".$_POST['Persona']['fechafincontrato']."' where id=".$modelc->idhistorialestadoempleado)
                    ->execute();
                }else
                {
                    Yii::app()->rrhh
                    ->createCommand("update general.historialestadoempleado set fechafincontrato=null where id=".$modelc->idhistorialestadoempleado)
                    ->execute();
                }
                /*
                DESCOMETAR LA SIGUIENTE LINEA PARA LA MODIFICACION DE FOTOGRAFIA
---------------------------------------
 if (isset($_POST['fotoPersona'])) {
                    $fotoPersona = $_POST['fotoPersona'];
              
                    

           
                  */
                  $fotoPersona = $_POST['fotoPersona'];
                  if (true) {
                    
  
       # code...
   
                  /*
DESCOMENTAR PARA LA MODIFICACION DE FOTOGRAFIA
------------------------------------
                    $fotoPersona = $_POST['fotoPersona'];
                   */
                    $nombreArchivo=Persona::model()->registrarImagen( $fotoPersona, Yii::app()->session['directorioTemporal'],$model->id);
                    $model->foto=$nombreArchivo;
                
                  
                   if($model->save()){   
                        $modelmp->attributes=$_POST['Persona'];
                        Dependiente::model()->actualizarDependientes($model,$_POST['gridDependientes']);
                        $modelmp->save();
                        Porcentajepago::model()->registrarPorcentajes($modele->id,'',$_POST['gridPorcentajespago']);
                                    
                        echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {
                        echo System::hasErrors('Revise los datos! ', $model);
                return;
                }
            }
            else{
                echo System::hasErrors('No se pudo subir laden foto! ', $model);
                return;

            }
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
            
        }else{
             
           /*
DESCOMENTAR LAS SIGUIENTES LINEAS PARA LA MODIFICACION DE LA FOTOGRAFIA
           ------------------------------------ */
              /*unset(Yii::app()->session['directorioTemporal']);
                $temporal = new Temporal(RrhhModule::getAssetFolder(), $this->SUB_DIRECTORY, $this->UPLOAD_DIRECTORY, $this->UPLOAD_FILE, $this->DELETE_FILE, $this->NO_PHOTO_FILE);
                Yii::app()->session['directorioTemporal'] = $temporal->getTempFolderUrl();*/
               $this->directorioTemporal();
                 Persona::model()->prepararImagen(SeguridadModule::dec($id), Yii::app()->session['directorioTemporal']);
                 $fotoPersona=Persona::model()->cargarImagen(SeguridadModule::dec($id));
                 
             
        }
      
        $this->renderPartial('update',array(
            'model'=>$model,
            'fotoPersona'=>$fotoPersona,
            'direccion'=>$direccion,
            'secciones'=>$secciones,
            'modelc'=>$modelc,
            'listahorario'=>$listahorario,
            'puestotrabajos'=>$puestotrabajos,
            'modelns'=>$modelns,
            'modeld'=>$modeld,
            'modelmp'=> $modelmp,
            'sueldos'=>$sueldos,
            'modele'=>$modele,
            'modelhistorial'=>$modelhistorial,
            'historialContrato'=>$historialContrato,
            'listabono'=>$listabono,
             'lista'=>$lista   
        ), false, true);
    }
    public function actionDameAutocomplete()
    {
        $idm= $_POST['idm'];

       // $model=new Persona;
        $this->renderPartial('_autocompletelocalidad',array(
            'model'=>$_POST['model'],
             'idm'=>$idm,
            
        ), false, true);
    }
    public function horasMes($mes,$ide)
    {
        $db = Yii::app()->rrhh;;

// retorna un conjunto de filas. Cada fila es un array asociativo de columnas de nombres y valores.
// un array vacío es retornado si no hay resultados
$hm = $db->createCommand('SELECT  cantidadhoras('.$mes.','.$ide.')')->queryAll();
return $hm;
    }
public function actionImprimirVacacionesEmpleado($id)
{
    /*solo en factura TCPDF
SeguridadModule::dec($id)
    */
/*
echo  SeguridadModule::dec($id);
     return;*/
       $re = new JasperReport('/reports/RRHH/DetalleVacacionesEmpleado', JasperReport::FORMAT_PDF, array(
            'p_idpersona' => SeguridadModule::dec($id), 
            'pUsuario'=>Yii::app()->user->getName(),
            
        ));
        $re->exec();                                
        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        }
        
}
    /**
     * Deletes safely a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {

            //$model=$this->loadModel();
           // $idp=
            $db = Yii::app()->rrhh;;

// retorna un conjunto de filas. Cada fila es un array asociativo de columnas de nombres y valores.
// un array vacío es retornado si no hay resultados
 $db->createCommand('SELECT  dar_baja_empleado('.SeguridadModule::dec($id).')')->queryAll();

              // $model=$this->loadModel(SeguridadModule::dec($_GET['id']));
           /*var_dump( $model->empleados[0]);
           return;*/
         //  var_dump($model);

          /*  $empleado= $model->empleados;
            var_dump($empleado);
            echo '---ide->'.$empleado[0]->id.'<------';*/
          //  var_dump($empleado);
           // if ($empleado->movimientopersonal!=null) {/*
            /*
               $movimientopersonal=$empleado->movimientopersonal[0];
            $movimientopersonal->eliminado=true;
            $movimientopersonal->save();
            
            $empleado->eliminado=true;
            $empleado->save();
            $model->eliminado=true;
            $model->save();
            self::actionAdmin();*/
            self::actionAdmin();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model=new Persona('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Persona'])){
                $model->attributes=$_GET['Persona'];
                if (!$model->validate()) {
                    echo System::hasErrorSearch($model);
                    return;
                }
        }        

        $this->renderPartial('admin',array(
            'model'=>$model,
        ), false, true);
    }
     public function actionAutocompleteMunicipio() {
        $request = trim($_GET['term']);
        $requestMayuscula = strtoupper($request);
        if ($request != '') {
            $model = Municipio::model()->findAll(array("condition" => " t.nombre like '%$requestMayuscula%'"));
            $data = array();
          //  echoCJSON::encode($model);
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
   public function actionAutocompleteLocalidad() {
        $request = trim($_GET['term']);
        $requestMayuscula = strtoupper($request);
        if ($request != '') {
            $model = Localidad::model()->findAll(array("condition" => " t.nombre like '%$requestMayuscula%' and t.idmunicipio=".$_GET['idmunicipio']));
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
      
  public function directorioTemporal() {
    
        unset(Yii::app()->session['directorioTemporal']);
        $temporal = new Temporal(RrhhModule::getAssetFolder(), $this->SUB_DIRECTORY, $this->UPLOAD_DIRECTORY, $this->UPLOAD_FILE, $this->DELETE_FILE, $this->NO_PHOTO_FILE);
        Yii::app()->session['directorioTemporal'] = $temporal->getTempFolderUrl();

    }
    public function actionBuscarUniforme()
    {
        
        $datos = Uniforme::model()->filtraUniforme($_POST['uniforme']);
        if(count($datos->getData()) == 0)
            $datos = array(
                0 => array('nombre' => $_POST['uniforme'], 'iduniforme' => '0')
            );
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $datos,
            'columns' => array(
                array('name' => 'uniforme', 'header' => 'Lista Uniforme', 'value' => '$data->nombre'),
                array('name' => 'iduniforme', 'typeCol' => 'hidden', 'value' => '$data->id'),
             //   array('name' => 'idtipobancoHidden', 'typeCol' => 'hidden', 'value' => '-1'),
            ),
        ));
    }
     public function actionBuscarDia()
    {
        
        $datos = Dia::model()->filtraDia($_POST['dia']);
        if(count($datos->getData()) == 0)
            $datos = array(
                0 => array('nombre' => $_POST['dia'], 'id' => '0')
            );
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $datos,
            'columns' => array(
                array('name' => 'dia', 'header' => 'Dias', 'value' => '$data->nombre'),
                array('name' => 'iddia', 'typeCol' => 'hidden', 'value' => '$data->id'),
             //   array('name' => 'idtipobancoHidden', 'typeCol' => 'hidden', 'value' => '-1'),
            ),
        ));
    }
     public function actionBuscarDiad()
    {
        
        $datos = Dia::model()->filtraDia($_POST['diad']);
        if(count($datos->getData()) == 0)
            $datos = array(
                0 => array('nombre' => $_POST['diad'], 'id' => '0')
            );
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $datos,
            'columns' => array(
                array('name' => 'diad', 'header' => 'Dias', 'value' => '$data->nombre'),
                array('name' => 'iddiad', 'typeCol' => 'hidden', 'value' => '$data->id'),
             
            ),
        ));
    }
     
     public function actionBuscarTalla()
    {
        
        $datos = Talla::model()->filtraTalla($_POST['talla']);
        if(count($datos->getData()) == 0)
            $datos = array(
                0 => array('nombre' => $_POST['talla'], 'idtalla' => '0')
            );
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $datos,
            'columns' => array(
                array('name' => 'talla', 'header' => 'Tallas', 'value' => '$data->nombre ." (".$data->sigla.")"'),
                array('name' => 'idtalla', 'typeCol' => 'hidden', 'value' => '$data->id'),
            ),
        ));
    }
    public function actionBuscarParentesco()
    {
        
        $datos = Parentesco::model()->filtraParentesco($_POST['parentesco']);
        if(count($datos->getData()) == 0)
            $datos = array(
                0 => array('nombre' => $_POST['parentesco'], 'idparentesco' => '0')
            );
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $datos,
            'columns' => array(
                array('name' => 'parentesco', 'header' => 'Parentesco', 'value' => '$data->parentescod'),
                array('name' => 'idparentesco', 'typeCol' => 'hidden', 'value' => '$data->id'),
             //   array('name' => 'idtipobancoHidden', 'typeCol' => 'hidden', 'value' => '-1'),
            ),
        ));
    }
   public function actionBuscarEmpresasubempleadora()
    {
        $cadenaempresas=''; 
        $grilla=$_POST['gridPorcentajespago'];
        for($i=1;$i<count($grilla);$i++){
            if($grilla[$i]['idempresasubempleadora']!=''){
                $cadenaempresas.=$grilla[$i]['idempresasubempleadora'].',';
            }
        }
        $tamano=strlen($cadenaempresas);
        if($tamano>0){
            $cadenaempresas= substr($cadenaempresas,0, $tamano-1);
        }
        else{
            $cadenaempresas='0';
        }
       
        $datos = Empresasubempleadora::model()->filtraEmpresa($_POST['empresasubempleadora'],$cadenaempresas);
        if(count($datos->getData()) == 0)
            $datos = array(
                0 => array('nombre' => $_POST['empresasubempleadora'], 'id' => '0')
            );
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $datos,
            'columns' => array(
                array('name' => 'empresasubempleadora', 'header' => 'Empresas', 'value' => '$data->nombre'),
                array('name' => 'idempresasubempleadora', 'typeCol' => 'hidden', 'value' => '$data->id'),
             //   array('name' => 'idtipobancoHidden', 'typeCol' => 'hidden', 'value' => '-1'),
            ),
        ));
    }
    public function actionPermiso($id)
    {
       Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);        
        $model=$this->loadModel(SeguridadModule::dec($_GET['id']));
        $modelp=new Permiso; 
        $fechaminima= Yii::app()->rrhh->createCommand("select   to_char( (select damefechaminima_permisovacacion(".$model->empleados[0]->id.",1)),'dd-mm-YYYY')")->queryScalar();
    
        $model->scenario='Permiso';
       
        if(isset($_POST['Persona']))
        {
          
            $modelp->attributes=$_POST['Persona'];
            $modelp->descripcion=$_POST['Persona']['descripcion'];
            $modelp->idempleado=$model->empleados[0]->id; 
            $modelp->horai=$this->verificar($_POST['Persona']['hi']).':'.$this->verificar($_POST['Persona']['mi']);
            $modelp->horaf=$this->verificar($_POST['Persona']['hs']).':'.$this->verificar($_POST['Persona']['ms']);
            $modelp->tipo=$_POST['Persona']['tipo'];
            if ($_POST['Persona']['tipo']=='1') {
                $modelp->fechaf= $modelp->fechai;//ate("d-m-Y");
            }
        
   
            $usuario=Yii::app()->user->getName();
            $ver = Yii::app()->rrhh
                   ->createCommand("SELECT fv_registrar_permiso(".$modelp->idempleado.",".$modelp->idtipopermiso.",'".$modelp->fechai."'::date,'".$modelp->fechaf."'::date,upper('".$modelp->descripcion."'),'".$usuario."','".$modelp->horai."','".$modelp->horaf."','".$modelp->tipo."'::boolean) as sms")
            ->queryAll();
            if($ver[0]['sms']==''){
                echo System::dataReturn('', array('id' => SeguridadModule::enc($modelp->id)));
                return;
            }
            else {
                echo System::hasErrors($ver[0]['sms'], $modelp);
                return;
            }
        }

        $this->renderPartial('permiso',array(
            'model'=>$model,
            'modelp'=>$modelp,
            'fechaminima'=>$fechaminima

        ), false, true);
    }
    public function actionReincorporacionEmpleado($id)
    {
       Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);        
       $id= SeguridadModule::dec($id);
       $empleado=Persona::model()->find('t.id='.$id)->empleados[0];
       $empleado->ultimaevaluacion= Yii::app()->rrhh->createCommand("select evaluacion from( select (json_array_elements( evaluacion)->>'fecha')::timestamp as fecha,json_array_elements( evaluacion)->>'evaluacion' as evaluacion from general.empleado where id=".$empleado->id." ) as t order by t.fecha desc limit 1 ")->queryScalar();
        
       $model=new Movimientopersonal;
       $model->scenario='Reincorporacion';
       $listabono=Yii::app()->rrhh
            ->createCommand("select eb.id,b.nombre,eb.monto::numeric(12,2) from general.bono b inner join empleadobono eb on eb.idbono=b.id where b.eliminado=false and eb.eliminado=false and eb.idempleado=".$empleado->id)
            ->queryAll();
     
      
       $movimientoa= Yii::app()->rrhh
           ->createCommand("select id ,idhorario from movimientopersonal where eliminado=false and idempleado= ".$empleado->id.' order by id desc')
           ->queryAll()[0];
          
       $fecha=Yii::app()->rrhh
       ->createCommand("select to_char( (fechahasta +'1 day'::interval)::date,'dd-mm-YYYY') as fecha from planilla WHERE eliminado=false  order by id desc limit 1")
       ->queryScalar();
       $model->idempleado=$empleado->id;
       $model->area=Yii::app()->rrhh
           ->createCommand("select a.id  from general.historialestadoempleado hee  inner join contrato c on c.idhistorialestadoempleado =hee.id inner join historialcontrato hc on hc.idcontrato =c.id inner join general.puestotrabajo pt on pt.id=hc.idpuestotrabajo inner join general.seccion s on s.id=pt.idseccion inner join general.area a on a.id=s.idarea  where pt.eliminado=false and s.eliminado=false and  hee.eliminado=false and hee.id=( select  he.id from general.historialestadoempleado he  where he.eliminado=false and he.idempleado=".$empleado->id." and he.activo=1 order by id desc limit 1) order by hc.fecharegistro desc limit 1")
           ->queryScalar();
          $model->unidad=Yii::app()->rrhh
           ->createCommand("select a.idunidad  from general.historialestadoempleado hee  inner join contrato c on c.idhistorialestadoempleado =hee.id inner join historialcontrato hc on hc.idcontrato =c.id inner join general.puestotrabajo pt on pt.id=hc.idpuestotrabajo inner join general.seccion s on s.id=pt.idseccion inner join general.area a on a.id=s.idarea  where pt.eliminado=false and s.eliminado=false and  hee.eliminado=false and hee.id=( select  he.id from general.historialestadoempleado he  where he.eliminado=false and he.idempleado=".$empleado->id." and he.activo=1 order by id desc limit 1) order by hc.fecharegistro desc limit 1")
           ->queryScalar();
      $secciones=Yii::app()->rrhh
           ->createCommand("select  id,nombre from general.seccion where eliminado=false and idarea in (select a.id  from general.historialestadoempleado hee  inner join contrato c on c.idhistorialestadoempleado =hee.id inner join historialcontrato hc on hc.idcontrato =c.id inner join general.puestotrabajo pt on pt.id=hc.idpuestotrabajo inner join general.seccion s on s.id=pt.idseccion inner join general.area a on a.id=s.idarea  where pt.eliminado=false and s.eliminado=false and  hee.eliminado=false and hee.id=( select  he.id from general.historialestadoempleado he  where he.eliminado=false and he.idempleado=".$empleado->id." and he.activo=1 order by id desc limit 1) order by hc.fecharegistro desc limit 1 )")
           ->query();
      $model->seccion=Yii::app()->rrhh
           ->createCommand("select s.id  from general.historialestadoempleado hee  inner join contrato c on c.idhistorialestadoempleado =hee.id inner join historialcontrato hc on hc.idcontrato =c.id inner join general.puestotrabajo pt on pt.id=hc.idpuestotrabajo inner join general.seccion s on s.id=pt.idseccion   where  s.eliminado=false and  hee.eliminado=false and hee.id=( select  he.id from general.historialestadoempleado he  where he.eliminado=false and he.idempleado=".$empleado->id." and he.activo=1 order by id desc limit 1) order by hc.fecharegistro desc limit 1")
           ->queryScalar();
       $model->tipocontrato=Yii::app()->rrhh
           ->createCommand("select c.idtipocontrato  from general.historialestadoempleado hee  inner join contrato c on c.idhistorialestadoempleado =hee.id   where   hee.eliminado=false and hee.id=( select  he.id from general.historialestadoempleado he  where he.eliminado=false and he.idempleado=".$empleado->id." and he.activo=1 order by id desc limit 1) order by c.id desc limit 1")
           ->queryScalar();
       $model->puestoactual=Yii::app()->rrhh
           ->createCommand("select hc.idpuestotrabajo from general.historialestadoempleado hee  inner join 
contrato c on c.idhistorialestadoempleado =hee.id inner join historialcontrato hc on  hc.idcontrato=c.id  where   hee.eliminado=false and hee.id=( select  he.id from general.historialestadoempleado he  where he.eliminado=false and he.idempleado=".$empleado->id."
 and he.activo=1 order by id desc limit 1) order by hc.fecharegistro desc limit 1")
           ->queryScalar();
       $model->nivelsalarialid=Yii::app()->rrhh
           ->createCommand("select hc.idnivelsalarial from general.historialestadoempleado hee  inner join 
contrato c on c.idhistorialestadoempleado =hee.id inner join historialcontrato hc on  hc.idcontrato=c.id  where   hee.eliminado=false and hee.id=( select  he.id from general.historialestadoempleado he  where he.eliminado=false and he.idempleado=".$empleado->id."
 and he.activo=1 order by id desc limit 1) order by hc.fecharegistro desc limit 1")
           ->queryScalar();
       $areas=Yii::app()->rrhh
           ->createCommand("select id,nombre from general.area where idunidad in (select a.idunidad  from general.historialestadoempleado hee  inner join contrato c on c.idhistorialestadoempleado =hee.id inner join historialcontrato hc on hc.idcontrato =c.id inner join general.puestotrabajo pt on pt.id=hc.idpuestotrabajo inner join general.seccion s on s.id=pt.idseccion inner join general.area a on a.id=s.idarea  where pt.eliminado=false and s.eliminado=false and  hee.eliminado=false and hee.id=( select  he.id from general.historialestadoempleado he  where he.eliminado=false and he.idempleado=".$empleado->id." and he.activo=1 order by id desc limit 1) order by hc.fecharegistro desc limit 1)")->query();
       $puestostrabajos=Yii::app()->rrhh
           ->createCommand("select id,nombre from general.puestotrabajo where idseccion in (select s.id  from general.historialestadoempleado hee  inner join contrato c on c.idhistorialestadoempleado =hee.id inner join historialcontrato hc on hc.idcontrato =c.id inner join general.puestotrabajo pt on pt.id=hc.idpuestotrabajo inner join general.seccion s on s.id=pt.idseccion   where  s.eliminado=false and  hee.eliminado=false and hee.id=( select  he.id from general.historialestadoempleado he  where he.eliminado=false and he.idempleado=".$empleado->id." and he.activo=1 order by id desc limit 1) order by hc.fecharegistro desc limit 1)")->query();
       //$listaHorarios = array( );
       $sueldos=  Yii::app()->rrhh
           ->createCommand("select id, nombre||'('||sueldo||' Bs.)' as sueldo from general.nivelsalarial where eliminado =false")
           ->query();
       if(isset($movimientoa['idhorario'])){
          $model->idhorario=$movimientoa['idhorario']; 
           $Horarios= Horario::model()->listaHorarios($movimientoa['idhorario']);
       }else{
           $Horarios=array();
       }
       $model->idhorario=$movimientoa['idhorario'];
        
       if(isset($_POST['Persona'])){
           $existe=Movimientopersonal::model()->find("t.idempleado=".$empleado->id." and  t.fechaini='".$_POST['Persona']['fechaini']."'");
           if (count($existe)==0) {
               $model->attributes=$_POST['Persona'];
               $model->idempleado=$empleado->id;             
               $contrato=new Contrato;
               $contrato->idtipocontrato=$_POST['Persona']['tipocontrato'];
               $contrato->save();
              
               $fechanatiguedad=$model->fecha;
               if($model->save()){ 
                  Yii::app()->rrhh->createCommand("select registrar_historialempleado (".$model->idempleado.", ".$contrato->id.",'".$model->fechaini."'::date,'".$fechanatiguedad."'::date,'".$model->fechaini."'::date,'".$_POST['Persona']['fechafincontrato']."',".$_POST['Persona']['nivelsalarialid'].",".$_POST['Persona']['puestoactual'].",'".Yii::app()->user->getName()."')")
                                    ->execute();
                   Persona::model()->GuardarCambioBono($_POST['gridListabono'],$empleado->id);                   
                   echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                   return;
               } else {
                   echo System::hasErrors('Revise los datos! ', $model);
               return;
               }}else{
                    echo System::hasErrors('Ya existe un movimiento en esta fecha! ', $model->fechaini);
               }
       }

       $this->renderPartial('reincorporacionempleado',array(
           'model'=>$model,
           'areas'=>$areas,
           'secciones'=>$secciones,
           'sueldos'=>$sueldos,
           'puestotrabajos'=>$puestostrabajos,
           'Horarios'=>$Horarios,
           'fecha'=>$fecha,
           'listabono'=>$listabono,
           'modele'=>$empleado,
           
         

       ), false, true);
    }
    public function actionRetiroEmpleado($id)
    {
       Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);        
        $model=$this->loadModel(SeguridadModule::dec($_GET['id']));
        $idempleado=$model->empleados[0]->id;
        $ver = Yii::app()->rrhh
            ->createCommand("select to_char(now()::date,'dd-mm-YYYY' )as fecha, to_char(fechavacacion::date,'dd-mm-YYYY' )as fechavacacion, to_char(fechaantiguedad,'dd-mm-YYYY') as fechaantiguedad,activo ,fechaultidemnizacion,fechaplanilla from general.historialestadoempleado where idempleado= ".$idempleado." and eliminado=false order by id desc limit 1")
            ->queryAll();
        $fechaminima= Yii::app()->rrhh
                ->createCommand("select  to_char( fechahasta,'dd-mm-YYYY') from planilla where eliminado=false and estado>=3 order by id desc limit 1"  )
                ->queryScalar();
       
        $modele=new Historialestadoempleado;
        $modele->fechaultidemnizacion= $ver[0]['fechaultidemnizacion'];
        $modele->fechaantiguedad= $ver[0]['fechaantiguedad'];
        $modele->fecharetiro=$ver[0]['fecha'];
        $modele->fechavacacion=$ver[0]['fechavacacion'];
        $modele->activo=$ver[0]['activo'];       
        $modele->idempleado=$idempleado;       
          
        if(isset($_POST['Persona']))
        {
         $modele->attributes=$_POST['Persona']; 
         $modele->activo=1-$modele->activo;        
         $modele->fechaantiguedad=$ver[0]['fechaantiguedad'];         
         $modele->fechaplanilla=$ver[0]['fechaplanilla'];
         $modele->idtiporetiro=$_POST['Persona']['idtiporetiro'];       
            if($modele->save()){
                 $estado=Yii::app()->rrhh->createCommand("select public.estado_generar_finiquito($idempleado,'".$modele->fecharetiro."')  ")
                        ->queryScalar();
                 
                    if($estado==true){
                         Persona::model()->RealizarPagoBeneficio($modele->id,$_POST['Persona']['idformapago'],$_POST['Persona']['descripcionformapago'],$_POST['Persona']['montorciva'],$_POST['Persona']['consegundoaguinaldo'],$_POST['gridAbonos'],$_POST['gridAportaciones']);
                        
                    }
                
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            }
            else {
                echo System::hasErrors('Revise los datos!!', $modele);
                return;
            }
        }

        $this->renderPartial('finiquitoempleado',array(
            'model'=>$model,
            'modele'=>$modele,
            'fechaminima'=>$fechaminima

        ), false, true);
    }
     public function actionRetiroEmpleadosinfiniquito($id)
    {
       Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);        
        $model=$this->loadModel(SeguridadModule::dec($_GET['id']));
        $idempleado=$model->empleados[0]->id;
        $ver = Yii::app()->rrhh
            ->createCommand("select to_char(now()::date,'dd-mm-YYYY' )as fecha, to_char(fechavacacion::date,'dd-mm-YYYY' )as fechavacacion, to_char(fechaantiguedad,'dd-mm-YYYY') as fechaantiguedad,activo ,fechaultidemnizacion,fechaplanilla from general.historialestadoempleado where idempleado= ".$idempleado." and eliminado=false order by id desc limit 1")
            ->queryAll();
       
        $modele=new Historialestadoempleado;
        $modele->fechaultidemnizacion= $ver[0]['fechaultidemnizacion'];
        $modele->fechaantiguedad= $ver[0]['fechaantiguedad'];
        $modele->fecharetiro=$ver[0]['fecha'];
        $modele->fechavacacion=$ver[0]['fechavacacion'];
        $modele->activo=$ver[0]['activo'];       
        $modele->idempleado=$idempleado;       
          
        if(isset($_POST['Persona']))
        {
         $modele->attributes=$_POST['Persona']; 
         $modele->activo=1-$modele->activo;        
         $modele->fechaantiguedad=$ver[0]['fechaantiguedad'];         
         $modele->fechaplanilla=$ver[0]['fechaplanilla'];    
            if($modele->save()){
                
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            }
            else {
                echo System::hasErrors('Revise los datos!!', $modele);
                return;
            }
        }

        $this->renderPartial('retirarempleado',array(
            'model'=>$model,
            'modele'=>$modele,

        ), false, true);
    }
    public function actionDeduccion($id)
    {
       Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);        
        $model=$this->loadModel(SeguridadModule::dec($_GET['id']));
        $modeld=new Empleadodeducciones;
        //$fecha =date("d-m-Y");
        /*$modelp->fechaf=date("d-m-Y");
        $modelp->fechai=date("d-m-Y"); 
*/

        
        $model->scenario='Deducciones';
        /*
          echo System::hasErrors('Revise los datos! ', $modelp);
                return;*/
        if(isset($_POST['Persona']))
        {
          
            $modeld->attributes=$_POST['Persona'];
            $modeld->idempleado=$model->empleados[0]->id; 
           
           
        
   
    
            if( $modeld->save()){
                echo System::dataReturn('', array('id' => SeguridadModule::enc($modeld->id)));
                return;
            }
            else {
                echo System::hasErrors('Revise los datos! ', $modeld);
                return;
            }
        }

        $this->renderPartial('deducciones',array(
            'model'=>$model,
            'modeld'=>$modeld,

        ), false, true);
    }
      
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Persona the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Persona::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
    public function actionMostrarhorario()
    {
        $idp=$_POST['idp'];
        $fecha=$_POST['fecha'];
         $ver = Yii::app()->rrhh
            ->createCommand("SELECT  dame_horario_empleado1(".$_POST['idp'].",'$fecha'::date) as sms")
            ->queryAll();
        $horario= '<div class="alert alert-info">'.$ver[0]['sms'].'</div>';
        $intervalohoras=Yii::app()->rrhh->createCommand("select hi,mi,hs,ms from dame_horai_horas1($idp,'$fecha')")->queryAll();
       
         echo CJSON::encode( array('horario' =>$horario ,'hi'=>$intervalohoras[0]['hi'] ,'mi'=>$intervalohoras[0]['mi'],'hs'=>$intervalohoras[0]['hs'],'ms'=>$intervalohoras[0]['ms'] ));



    }

	/**
	 * Performs the AJAX validation.
	 * @param Persona $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='persona-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
  public function actionNuevoContrato($id)
    {   Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $id= SeguridadModule::dec($id);
        $empleado=Persona::model()->find('t.id='.$id)->empleados[0];
        $model=new Movimientopersonal;
        $historialContrato= new Historialcontrato;
        $movimientoa= Yii::app()->rrhh
            ->createCommand("select id ,idhorario from movimientopersonal where eliminado=false and idempleado= ".$empleado->id.' order by id desc')
            ->queryAll()[0];
        $fecha=Yii::app()->rrhh
        ->createCommand("select to_char( (fechahasta +'1 day'::interval)::date,'dd-mm-YYYY') as fecha from planilla WHERE ELIMINADO=FALSE  and estado>2 order by id desc limit 1")
        ->queryScalar();
        $model->idempleado=$empleado->id;
        $model->area=Yii::app()->rrhh
            ->createCommand("select s.idarea  from general.historialestadoempleado hee inner join contrato c on c.idhistorialestadoempleado=hee.id inner join historialcontrato   hc on hc.idcontrato=c.id

inner join general.puestotrabajo pt on pt.id=hc.idpuestotrabajo inner join general.seccion s on s.id=pt.idseccion 
  where pt.eliminado=false and s.eliminado=false and hc.eliminado=false and hee.id in
( select max(he.id) from  general.historialestadoempleado he  where he.eliminado=false and he.activo=1 and he.idempleado=".$empleado->id."  ) order by hc.fecharegistro desc limit 1")
            ->queryScalar();
           $model->unidad=Yii::app()->rrhh
            ->createCommand("select a.idunidad  from general.historialestadoempleado hee inner join contrato c on c.idhistorialestadoempleado=hee.id inner join historialcontrato   hc on hc.idcontrato=c.id

inner join general.puestotrabajo pt on pt.id=hc.idpuestotrabajo inner join general.seccion s on s.id=pt.idseccion  inner join general.area a on a.id=s.idarea
  where pt.eliminado=false and s.eliminado=false and hc.eliminado=false and hee.id in
( select max(he.id) from  general.historialestadoempleado he  where he.eliminado=false and he.activo=1 and he.idempleado=".$empleado->id."  ) order by hc.fecharegistro desc limit 1")
            ->queryScalar();
       $secciones=Yii::app()->rrhh
            ->createCommand("select  id,nombre from general.seccion where eliminado=false and idarea =".$model->area)
            ->query();
       $model->seccion=Yii::app()->rrhh
            ->createCommand("select pt.idseccion  from general.historialestadoempleado hee inner join contrato c on c.idhistorialestadoempleado=hee.id inner join historialcontrato   hc on hc.idcontrato=c.id inner join general.puestotrabajo pt on pt.id=hc.idpuestotrabajo 
  where pt.eliminado=false  and hc.eliminado=false and hee.id in ( select max(he.id) from  general.historialestadoempleado he  where he.eliminado=false and he.activo=1 and he.idempleado=".$empleado->id."  ) order by hc.fecharegistro desc limit 1")
            ->queryScalar();
        $model->tipocontrato=Yii::app()->rrhh
            ->createCommand("select c.idtipocontrato  from general.historialestadoempleado hee inner join contrato c on c.idhistorialestadoempleado=hee.id   where  hee.id in ( select max(he.id) from  general.historialestadoempleado he  where he.eliminado=false and he.activo=1 and he.idempleado=".$empleado->id."  ) order by c.id desc limit 1")
            ->queryScalar();
        $areas=Yii::app()->rrhh
            ->createCommand("select id,nombre from general.area where idunidad =".$model->unidad)
            ->query();
        $puestostrabajos=Yii::app()->rrhh
            ->createCommand("select id,nombre from general.puestotrabajo where idseccion= ".$model->seccion)
            ->query();
        //$listaHorarios = array( );
        $sueldos=  Yii::app()->rrhh
            ->createCommand("select id, nombre||'('||sueldo||' Bs.)' as sueldo from general.nivelsalarial where eliminado =false")
            ->query();
        if(isset($movimientoa['idhorario'])){
           $model->idhorario=$movimientoa['idhorario']; 
            $Horarios= Horario::model()->listaHorarios($movimientoa['idhorario']);
        }else{
            $Horarios=array();
        }
        $model->idhorario=$movimientoa['idhorario'];
         
        if(isset($_POST['Persona'])){
            $fecha=$_POST['Persona']['fechaini'];
            $existe=Yii::app()->rrhh
            ->createCommand("select count(*) from contrato c inner join
 historialcontrato hc on hc.idcontrato =c.id where hc.eliminado=false 
 and hc.fecharegistro='".$fecha."'::date  and c.idhistorialestadoempleado = (select max(id) from general.historialestadoempleado where eliminado=false and activo=1 and idempleado=".$empleado->id.")")->queryScalar();
      
            if ($existe==0  ) {
        
    $usuario=Yii::app()->user->getName();
                
                 Yii::app()->rrhh
            ->createCommand("select nuevo_contrato(".$empleado->id.",'".$_POST['Persona']['fechaini']."'::date,".$_POST['Persona']['idpuestotrabajo'].", ".$_POST['Persona']['idnivelsalarial']." ,".$_POST['Persona']['tipocontrato'].",'$usuario' ) ")
            ->execute();
                if(true){ 
             //   Horario::model()->registrarHT( $_POST['gridHorasTrabajo'],$model->id);                    
                    echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {
                    echo System::hasErrors('Revise los datos! ', $model);
                return;
                }}else{
                    if (count($existe)!=0)
                     echo System::hasErrors('Ya existe un movimiento en esta fecha! ', $model->fechaini);
                
                     if ($cantcontrato>1)
                     echo System::hasErrors('Llego al limite de contratos en el mes! ', $model->fechaini);
              
                }
        }

        $this->renderPartial('nuevocontrato',array(
            'model'=>$model,
            'areas'=>$areas,
            'secciones'=>$secciones,
            'sueldos'=>$sueldos,
            'puestotrabajos'=>$puestostrabajos,
            'historialContrato'=>$historialContrato,
            'fecha'=>$fecha

        ), false, true);
    }

  public function actionNuevoHorario($id)
  {   Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
      $id= SeguridadModule::dec($id);
      $empleado=Persona::model()->find('t.id='.$id)->empleados[0];
      $model=new Movimientopersonal;
      $movimientoa= Yii::app()->rrhh
          ->createCommand("select id  ,case when fechaini<=(select fechahasta from planilla where eliminado=false order by id desc limit 1) then to_char(((select fechahasta+1 from planilla where eliminado=false order by id desc limit 1)),'dd-mm-YYYY') else to_char( (fechaini +'1 day'::interval)::date,'dd-mm-YYYY') end as fecha ,idhorario from movimientopersonal where eliminado=false and idempleado= ".$empleado->id.' order by fechaini desc limit 1')
          ->queryAll()[0];
      $fecha=$movimientoa['fecha'];
      $model->idempleado=$empleado->id;
    
     
      if(isset($movimientoa['idhorario'])){
         $model->idhorario=$movimientoa['idhorario']; 
          $Horarios= Horario::model()->listaHorarios($movimientoa['idhorario']);
      }else{
          $Horarios=array();
      }
       
      if(isset($_POST['Persona'])){
          $existe=Movimientopersonal::model()->find("t.idempleado=".$empleado->id." and  t.fechaini='".$_POST['Persona']['fechaini']."'");
          if (count($existe)==0) {
              $model->attributes=$_POST['Persona'];              
            
              
              if(true){ 
                 $usuario=Yii::app()->user->getName();
            Yii::app()->rrhh
            ->createCommand("select actualizar_horario_empleado(".$model->idempleado.", ".$model->idhorario.",'".$model->fechaini."','$usuario') ")
            ->execute();                   
                  echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                  return;
              } else {
                  echo System::hasErrors('Revise los datos! ', $model);
              return;
              }}else{
                   echo System::hasErrors('Ya existe un movimiento en esta fecha! ', $model->fechaini);
              }
      }

      $this->renderPartial('nuevohorario',array(
          'model'=>$model,         
          'fecha'=>$fecha,
          'Horarios'=>$Horarios

      ), false, true);
  }
public function actionBoletaEmpleado()
{
  Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);        
    $model=$this->loadModel(SeguridadModule::dec($_GET['id']));
    $model->ci=$model->ci;
    $planillas = Yii::app()->rrhh
->createCommand("select  p.id, p.nombre as gestion from planilla p where p.eliminado=false and p.porsistema=true order by p.id desc ")
->queryAll();

      
 
  
  $this->renderPartial('boletaempleado',array(
      'model'=>$model,
      'planillas'=>$planillas
  ), false, true);
       
     
}
    public function actionImprimirBoletaEmpleado()
    {
       
         $ci=$_GET['ci'];
         $idplanilla=$_GET['idplanilla'];

                
           $re = new JasperReport('/reports/RRHH/ReporteBoletaEmpleado', JasperReport::FORMAT_PDF, array(
                'p_idplanilla' => $idplanilla,
                'p_ci'=>''.$ci, 
                'pUsuario'=>Yii::app()->user->getName(),
                
            ));
            $re->exec();                                
            if ($re->getPages() > 0) {
                echo $re->toPDF();
            } else {
                throw new CrugeException('El reporte no tiene páginas.', 483);
            }
            
    }
     public function actionReporteBancoHoraHistorial($id)
{  
        $persona= Persona::model()->find('t.id='.SeguridadModule::dec($id));
        $re = new JasperReport('/reports/RRHH/ReporteBancoHorasCorteAsistencia', JasperReport::FORMAT_PDF, array(
            'p_idempleado' => $persona->empleados[0]->id, 
             'p_eshistorial'=>true,
            'pUsuario'=>Yii::app()->user->getName(),
            
        ));
        $re->exec();                                
        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        }
        
}
public function actionDamefechasminimas(){
        
        $model=$this->loadModel($_POST['ide']);
        $idempleado=$model->empleados[0]->id; 
        $tipo=$_POST['tipo'];
        $horario='';
        $fechaminima= Yii::app()->rrhh->createCommand(" select to_char((select    damefechaminima_permisovacacion(".$idempleado.",$tipo)),'dd-mm-YYYY')")->queryScalar();
        
        if($tipo==1){
             $ver = Yii::app()->rrhh
            ->createCommand("SELECT  dame_horario_empleado($idempleado,'$fechaminima'::date) as sms")
            ->queryAll();
           $horario= '<div class="alert alert-info">'.$ver[0]['sms'].'</div>';
        }
        
            echo CJSON::encode( array('fechaminima'=>$fechaminima,'horario'=>$horario ));
        
            return;
    }
    public function actionEliminarEmpleado($id) {
          Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
      $id= SeguridadModule::dec($id);
      $model=Persona::model()->find('t.id='.$id);       
      if(isset($_POST['Persona'])){
          $respuesta=Persona::model()->EliminarEmpleado($id);
          if ($respuesta=='') {
                        
              echo System::dataReturn('Eliminación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                  return;
              }else{
                   echo System::hasErrors($respuesta, $model->id);
                   return;
              }
      }

      $this->renderPartial('eliminarempleado',array(
          'model'=>$model,     

      ), false, true);
    }
    public function actionAnalizarselladaPermiso() {
      $idempleado= $_POST['idempleado'];     
      $respuesta= Yii::app()->rrhh->createCommand(" select analizarsellada_permiso($idempleado)")->queryScalar();
      echo $respuesta;
      return ;        
    }
    public function actionImprimirKardexEmpleado($id)
{
    
       $re = new JasperReport('/reports/RRHH/KardexTrabajador', JasperReport::FORMAT_PDF, array(
            'p_idpersona' => SeguridadModule::dec($id), 
            'pUsuario'=>Yii::app()->user->getName(),
            
        ));
        $re->exec();                                
        if ($re->getPages() > 0) {
            echo $re->toPDF();
        } else {
            throw new CrugeException('El reporte no tiene páginas.', 483);
        }
        
}
        
}
