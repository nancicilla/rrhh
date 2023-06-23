<?php
/*
 * ProductoController.php
 *
 * Version 0.$Rev: 936 $
 *
 * Creacion: 17/03/2015elk
 *e
 * Ultima Actualizacion: $Date: 2018-12-19 12:00:13 -0400 (Wed, 19 Dec 2018) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 */

class ProductoController extends Controller {
    /*
     * IMPORTANTE!!!
     * Los métodos filters(),_publicActionsList() y accessRules() deben copiarse
     * tal cual en todos los controladores del proyecto
     */

    /**
     *
     * @var string  Ruta del subdirectorio dentro de assets donde creará la 
     * carpeta temporal
     */
    private $SUB_DIRECTORY = '/producto/images/';

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
     * se debe usar este método filters en todos los controladores para permitir
     * filtrar si el usuario tiene acceso a las acciones y controlador o no, 
     */
    public function filters() {
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
    private function _publicActionsList() {
        //en este array deben ir las acciones publicas del modulo, las que se 
        //pueden acceder sin necesitar permisos, por defecto todas las acciones
        //se acceden solo con autorizacion, por eso el array no tiene acciones
        return array(
            'ActualizarSaldosimportesProductosAlmacen',
        );
    }

    public function accessRules() {
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
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = new Producto;
        $no_photo = $this->NO_PHOTO_FILE;
        $productoComplementario = array();        
        $productoCaracteristica = Caracteristica::model()->obtieneCaracteristica(1);
        $productoImagen = array();
        $gridRequisito = array();
        $model->requisito = true;

        if(isset($_POST['Producto']))
        {
            $postProducto = $_POST['Producto'];
            $model->attributes = $postProducto;
            
            if (isset($_POST['Productocaracteristica'])) {
                $productoCaracteristica = $_POST['Productocaracteristica'];
            }
            if (isset($_POST['Productoimagen'])) {
                $productoImagen = $_POST['Productoimagen'];
            }
            if (isset($_POST['productoComplementario'])) {
                $productoComplementario = $_POST['productoComplementario'];
            }

            $model->validate();
            $model->stockmaximo = 0;
            $model->stockminimo = 0;
            $model->stockreposicion = 0;
            $model->puntopedido = 0;
            $model->saldo = 0;
            $model->costo = 0;
            $model->reserva = 0;
            $producto = Almacen::model()->find('codigo = ' . $_POST['Producto']['codigoAlmacen']);
            
            //INICIA historial cambios
            $arraycambios=array();
            $fechacambio = date('Y-m-d H:i:s');
            $usuariocambio = Yii::app()->user->getName();
            if($model->historialcambios!=null)
            { 
                $arraycambios=CJSON::decode($model->historialcambios,true);
                $_POST['Producto']['fechacambio']=$fechacambio;
                $_POST['Producto']['usuario']=$usuariocambio;
                array_push($arraycambios,$_POST['Producto'] );}
            else{
                $_POST['Producto']['fechacambio']=$fechacambio;
                $_POST['Producto']['usuario']=$usuariocambio;
                array_push($arraycambios, $_POST['Producto']);
            }                
            $model->historialcambios=CJSON::encode($arraycambios);
            //FIN historial cambios
            
            if($postProducto['idestadofichatecnica'] != '')
                $model->idestadofichatecnica = $postProducto['idestadofichatecnica'];
            if ($model->save()) 
            {
                if(isset($_POST['Productocaracteristica']))
                    Productocaracteristica::model()->registrarGeneral($model->id, $_POST['Productocaracteristica'], $postProducto['codigoAlmacen']);
                Productocaracteristica::model()->registrarImagen($model->id, $productoImagen, Yii::app()->session['directorioTemporal']);
                Productoproducto::model()->registrarComplementario($model->id, $productoComplementario);
                $model->registrarHijo($model->id);
                
                // -------------------------------------------------------------
                // -------------------- REGISTRA REQUISITOS --------------------
                // -------------------------------------------------------------
                if($postProducto['requisito'] == 0)
                {
                    if(isset($_POST['gridRequisito']))
                        Requisitoproducto::model()->registrarRequisitoProducto($_POST['gridRequisito'], $model->id, $postProducto['aumentarColumna']);
                }
                // -------------------------------------------------------------
                // -------------------------------------------------------------
                
                echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                $model->emptyAttributes();
                $productoCaracteristica = array();
                $productoImagen = array();
                $no_photo = $this->NO_PHOTO_FILE;
                $productoComplementario = array();
                
                $this->directorioTemporal();

                return;
            } else {
                echo System::hasErrors('Revise los datos!', $model);
                return;
            }
        } else {
            $this->directorioTemporal();
        }

        $this->renderPartial('create', array(
            'model' => $model,
            'productoCaracteristica' => $productoCaracteristica,
            'productoImagen' => $productoImagen,
            'productoComplementario' => $productoComplementario,
            'gridRequisito' => $gridRequisito,
        ), false, true);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $existeImagen = 'false';
        $auxiliar = $this->loadModel(SeguridadModule::dec($id))->isActualizable();
        if ($auxiliar != 'exito') {
            echo System::conditionOpen(false, $auxiliar);
            return;
        } else {
            $model = $this->loadModel(SeguridadModule::dec($id));
            $model->existeRelacionProduccion = false;
            
            $ordenProducto = new WSProducto;
            $respuesta = $ordenProducto->existeRelacionProducto(SeguridadModule::dec($id));
            
            switch ($respuesta) {
                case 1:
                    $model->existeRelacionProduccion = false;
                    break;

                default:
                    $model->existeRelacionProduccion = true;
                    break;
            }
            /*
             * Si es 0 quiere decir que tiene alguna relacion
             * Si es 1 entonces no existe ninguna relacion 
             * Si es -1 entonces ocurrio algún error
             */

            $productoCaracteristica = array();
            $productoImagen = array();
            $productoComplementario = array();
            
            $model->id_producto = $model->id;
            $gridRequisito = Requisitoproducto::model()->mostrarRequisitoProducto($model->id, 0);
            if(count($gridRequisito->getData()) == 0) // NO existen registros
            {
                $gridRequisito = array();
                $model->requisito = true;
            }
            else
            {
                $model->requisito = 0;
                $columnaSegunda = Requisitoproducto::model()->mostrarRequisitoProducto($model->id, 1);
                if(count($columnaSegunda->getData()) > 0)
                    $model->aumentarColumna = true;
                else
                    $model->aumentarColumna = false;
            }
            
            if (isset($_POST['Productocaracteristica'])) {
                $productoCaracteristica = $_POST['Productocaracteristica'];
            } else {
                $productoCaracteristica = Informacionproducto::model()->cargarCaracteristicaGeneral(SeguridadModule::dec($id));
            }

            if (isset($_POST['Productoimagen'])) {
                $productoImagen = $_POST['Productoimagen'];
            } else {
                if (isset($_POST['Producto'])) {
                    $productoImagen = array();
                } else {
                    $productoImagen = Productocaracteristica::model()->cargarCaracteristicaImagen(SeguridadModule::dec($id));
                    if (count($productoImagen) > 0) {
                        $existeImagen = 'true';
                    }
                }
            }

            if (isset($_POST['productoComplementario'])) {
                $productoComplementario = $_POST['productoComplementario'];
            } else {
                $productoComplementario = Productoproducto::model()->productoComplementario(SeguridadModule::dec($id));
            }

            if (isset($_POST['Producto']))
            {
                $postProducto = $_POST['Producto'];
                $model->attributes = $postProducto;
                                
                //INICIA historial cambios
                $arraycambios=array();
                $fechacambio = date('Y-m-d H:i:s');
                $usuariocambio = Yii::app()->user->getName();
                if($model->historialcambios!=null)
                { 
                    $arraycambios=CJSON::decode($model->historialcambios,true);
                    $_POST['Producto']['fechacambio']=$fechacambio;
                    $_POST['Producto']['usuario']=$usuariocambio;
                    array_push($arraycambios,$_POST['Producto'] );}
                else{
                    $_POST['Producto']['fechacambio']=$fechacambio;
                    $_POST['Producto']['usuario']=$usuariocambio;
                    array_push($arraycambios, $_POST['Producto']);
                }                
                $model->historialcambios=CJSON::encode($arraycambios);
                //FIN historial cambios
                
                $model->idestadofichatecnica = $postProducto['idestadofichatecnica'];
                $model->validate();
                if ($model->save()) {
                    Productoproducto::model()->deleteAll('idproducto =' . $model->id);
                    
                    if(isset($_POST['Productocaracteristica']))
                        Productocaracteristica::model()->registrarActualizaGeneral($model->id, $productoCaracteristica, $model->idalmacen);
                    
                    /*
                     * El usuario que esté asignado a la acción de "amparo"
                     * podrá modificar las fotos de las fichas técnicas.
                     */
                    $queryCrugeUserAction = Yii::app()->usuario_web->createCommand("
                            select userid from cruge_authassignment 
                            where userid = ".Yii::app()->user->id." AND itemname = 'editaFotosFichaTecnica' ")->queryScalar();
                    if($queryCrugeUserAction != null)
                        Productocaracteristica::model()->registrarImagen($model->id, $productoImagen, Yii::app()->session['directorioTemporal']);
                    
                    
                    if (isset($_POST['productoComplementario']))
                        Productoproducto::model()->registrarComplementario($model->id, $productoComplementario);

                    $model->actualizarHijo($model->id);
                    
                    // -------------------------------------------------------------
                    // -------------------- REGISTRA REQUISITOS --------------------
                    // -------------------------------------------------------------
                    Requisitoproducto::model()->deleteAll('idproducto = ' . $model->id);
                    if($postProducto['requisito'] == 0)
                    {
                        if(isset($_POST['gridRequisito']))
                            Requisitoproducto::model()->registrarRequisitoProducto($_POST['gridRequisito'], $model->id, $postProducto['aumentarColumna']);
                    }
                    // -------------------------------------------------------------
                    // -------------------------------------------------------------

                    $model->emptyAttributes();
                    $productoCaracteristica = array();
                    $productoImagen = array();
                    $no_photo = $this->NO_PHOTO_FILE;
                    $productoComplementario = array();
                    $this->directorioTemporal();
                    if (isset($_POST['Productoimagen'])) {
                        $productoImagen = $_POST['Productoimagen'];
                    }
                
                    echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {
                    echo System::hasErrors('Revise los datos!', $model);
                    return;
                }
            } else {
                unset(Yii::app()->session['directorioTemporal']);
                $temporal = new Temporal(AlmacenModule::getAssetFolder(), $this->SUB_DIRECTORY, $this->UPLOAD_DIRECTORY, $this->UPLOAD_FILE, $this->DELETE_FILE, $this->NO_PHOTO_FILE);
                Yii::app()->session['directorioTemporal'] = $temporal->getTempFolderUrl();
                Productocaracteristica::model()->prepararImagen(SeguridadModule::dec($id), Yii::app()->session['directorioTemporal']);
                $modeloFamilia = Familia::model()->informacionFamilia($model->idfamilia);
                $modeloClase = Clase::model()->informacionClase($model->idclase);
                $model->nombreFamilia = $modeloFamilia['nombre'];
                $model->codigoFamilia = $modeloFamilia['codigo'];
                $model->nombreCompletadoFamilia = $modeloFamilia['nombre'];
                
                $model->nombreClase = $modeloClase['nombre'];
                $model->codigoClase = $modeloClase['codigo'];
                $model->nombreCompletadoClase = $modeloClase['nombre'];
                $almacen = Almacen::model()->findByPK($model->idalmacen);
                $model->codigoAlmacen = $almacen->codigo;
            }
            $model->existeImagen = $existeImagen;
            
            $this->renderPartial('update', array(
                'model' => $model,
                'productoCaracteristica' => $productoCaracteristica,
                'productoImagen' => $productoImagen,
                'productoComplementario' => $productoComplementario,
                'gridRequisito' => $gridRequisito,
            ), false, true);
        }
    }

    /**
     * Verifica si un cliente esta bloqueado, Si el cliente ya esta bloqueado retorna la lista de clientes actualizada
     * @param type $id Identificador de cliente
     */
    public function actionEliminar($id) {
        if (!$id) {
            /* $respuestaArray=array("estado"=>-1,"descripcion"=>"No se envió el id del producto al controlador");
              echo CJSON::encode($respuestaArray);
              return; */
            echo System::messageError('No se envió el id del producto al controlador.');
            //self::actionAdmin();  
            return;
        }

        $ordenProducto = new WSProducto;
                
        $respuesta = $ordenProducto->existeRelacionProducto(SeguridadModule::dec($id));//array error:boolean; existe:existe relacion? ; mensaje
        if(!$respuesta['error']){
            if($respuesta['existe']){
                echo System::messageError($respuesta['mensaje']);
            }else{
                $modelProducto = Producto::model()->findByPk(SeguridadModule::dec($id));
                if ($modelProducto->safeDelete()) {
                    echo System::messageConfirm('El producto se eliminó corrrectamente.');
                    self::actionAdmin();
                    return;
                } else {
                    echo System::messageError('Error al eliminar el producto. Modulo Almacen');
                }
            }
        
        }
        else{
            echo System::messageError($respuesta['mensaje']);    
        }
        
       
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel(SeguridadModule::dec($id))->safeDelete();
        self::actionAdmin();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = new Producto('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Producto'])) {
            $model->attributes = $_GET['Producto'];
            if (!$model->validate()) {
                echo System::hasErrorSearch($model);
                return;
            }
        }

        $this->renderPartial('admin', array(
            'model' => $model,
                ), false, true);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Producto the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Producto::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Familia the loaded model
     * @throws CHttpException
     */
    public function loadFamiliaModel($id) {
        $model = Familia::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Producto $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'producto-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

   
   
  
  
    
    /**
     * Crea un directorio temporal
     */
    public function directorioTemporal() {
        unset(Yii::app()->session['directorioTemporal']);
        $temporal = new Temporal(AlmacenModule::getAssetFolder(), $this->SUB_DIRECTORY, $this->UPLOAD_DIRECTORY, $this->UPLOAD_FILE, $this->DELETE_FILE, $this->NO_PHOTO_FILE);
        Yii::app()->session['directorioTemporal'] = $temporal->getTempFolderUrl();
    }

   
    /**
     * Filtrar productos por nombre
     */
    public function actionSearchProductoNombre() {
        $producto = new Producto();
        $productoExcluido = null;
        $idprod = '';
        $idalm = '';
        if (isset($_POST['productoComplementario'])) {
            $productoExcluido = $this->getIdProducto($_POST['productoComplementario']);
        }
        if ($_POST['noidproducto'] !== '') {
            $idprod = SeguridadModule::dec($_POST['noidproducto']);
        }
        $arrayParametros = array(
            'nombre' => $_POST['nombre'],
            'productoExcluido' => $productoExcluido,
            'idprod' => $idprod, 
            'idalm' => $idalm
        );
                
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $producto->searchProductoNombre($arrayParametros),
            'columns' => array(array('name' => 'id', 'typeCol' => 'hidden'),
                array('name' => 'codigo', 'width' => 10),
                array('name' => 'nombre', 'width' => 50),
                array('name' => 'almacen', 'value' => '$data->idalmacen0->nombre', 'width' => 10),
            ),
        ));
    }

  
   

   
   
 
 
   
    
    /**
     * Función que obtiene los id de producto
     * @param type $item
     * @return type
     */
    public function getIdItem($item) {
        $idItem = null;
        for ($i = 1; $i < count($item) + 1; $i++) {
            $idItem[$i] = ($item[$i]['idproducto']);
        }

        return $idItem;
    }
    
    /**
     * Genera el reporte en formato pdf del stock de productos en base a la 
     * vista del cgridview de la interfaz de stock, en caso de que el reporte
     * no tenga paginas se muestra una excepción
     */

    
    /*
     * Busca productos por codigo
     */
  
  
    
  
    
    
    
    // -------------------------------------------------------------------------
    // ------------------- [ Agrupación de productos "TPV" ] -------------------
    // -------------------------------------------------------------------------
    public function actionAdminAgrupacion() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        
        $model = new Producto('searchAgrupacion');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }
        
        if (isset($_GET['Producto'])) {
            $model->attributes = $_GET['Producto'];
            if (!$model->validate()) {
                echo System::hasErrorSearch($model);
                return;
            }
        }
        
        $this->renderPartial('_agrupacionAdmin', array(
            'model' => $model
        ), false, true);
    }
    public function actionAgrupacionProductoCreate() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        
        $model = new Producto;
        $model->scenario = 'registraAgrupacion';
        $gridAgrupacionproducto = array();
        
        if(isset($_POST['Agrupacion']))
        {
            $postAgrupacion = $_POST['Agrupacion'];
            $model->producto = $postAgrupacion['producto'];
            
            if($model->validate())
            {
                if(!isset($_POST['gridAgrupacionproducto']))
                {
                    echo System::hasErrors('La lista de productos NO contiene productos! ');
                    return;
                }
                $gridAgrupacionproducto = $_POST['gridAgrupacionproducto'];
                
                for($i = 1; $i <= count($gridAgrupacionproducto); $i++)
                {
                    $idproducto = $gridAgrupacionproducto[$i]['idproducto'];
                    if($idproducto > 0)
                    {
                        $modelo = new Agrupacionproducto;
                        $modelo->idproductogrupo = $postAgrupacion['idproductogrupo'];
                        $modelo->pesopromedio = $postAgrupacion['pesopromedio']==''? 0 : $postAgrupacion['pesopromedio'];
                        $modelo->idproducto = $gridAgrupacionproducto[$i]['idproducto'];
                        $modelo->save();
                    }
                }
                $modelProducto = Producto::model()->find('id = '.$postAgrupacion['idproductogrupo']);
                $modelProducto->scenario = 'actualizaProductoGrupo';
                $modelProducto->grupo = true;
                $modelProducto->pesopromedio = $postAgrupacion['pesopromedio']==''? 0 : $postAgrupacion['pesopromedio'];
                $modelProducto->save();
                
                echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }
        
        $this->renderPartial('_agrupacionForm', array(
            'model' => $model,
            'gridAgrupacionproducto' => $gridAgrupacionproducto,
        ), false, true);
    }
    public function actionAgrupacionProductoUpdate($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        
        $model = $this->loadModel(SeguridadModule::dec($id));
        $model->scenario = 'actualizaAgrupacion';
        $gridAgrupacionproducto = Agrupacionproducto::model()->obtenerProductosHijos($model->id);
        $model->producto = '('.$model->codigo.') '.$model->nombre;
        $model->idproductogrupo = $model->id;
        $model->pesopromedio = $model->pesopromedio;
        
        if(isset($_POST['Agrupacion']))
        {
            $postAgrupacion = $_POST['Agrupacion'];
            $model->producto = $postAgrupacion['producto'];
            
            echo System::hasErrors('Opción NO...habilitado! ');
            return;
            
            if($model->validate())
            {
                if(!isset($_POST['gridAgrupacionproducto']))
                {
                    echo System::hasErrors('La lista de productos NO contiene productos! ');
                    return;
                }
                $gridAgrupacionproducto = $_POST['gridAgrupacionproducto'];
                
                for($i = 1; $i <= count($gridAgrupacionproducto); $i++)
                {
                    $idproducto = $gridAgrupacionproducto[$i]['idproducto'];
                    if($idproducto > 0)
                    {
                        $modelo = new Agrupacionproducto;
                        $modelo->idproductogrupo = $postAgrupacion['idproductogrupo'];
                        $modelo->idproducto = $gridAgrupacionproducto[$i]['idproducto'];
                        $modelo->save();
                    }
                }
                $modelProducto = Producto::model()->find('id = '.$postAgrupacion['idproductogrupo']);
                $modelProducto->scenario = 'actualizaProductoGrupo';
                $modelProducto->grupo = true;
                $modelProducto->save();
                
                echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }
        
        $this->renderPartial('_agrupacionForm', array(
            'model' => $model,
            'gridAgrupacionproducto' => $gridAgrupacionproducto,
        ), false, true);
    }
    public function actionAutocompleteProductoPadre() {
        $request = trim($_GET['term']);
        $requestMayuscula = strtoupper($request);
        if($request != '') {
            $model = Producto::model()->muestraProductoPadre($requestMayuscula);
            $data = array();
            foreach($model as $get) {
                $data[] = array(
                    'id' => $get->id,
                    'value' => '('.$get->codigo.') '.$get->nombre,
                    'precio' => $get->precio,
                );
            }
            $this->layout = 'empty';
            echo CJSON::encode($data);
        }
    }
    public function actionBuscarProductoCodigoNombre() {
        $itemExcluido = null;
        if(!isset($_POST['precio']))
        {
            echo 'El precio del producto Grupo No existe! ';
            return;
        }
        if($_POST['precio'] == '')
        {
            echo 'El precio del producto Grupo No existe! ';
            return;
        }
        if(isset($_POST['gridAgrupacionproducto'])) {
            $itemExcluido = $this->getIdItem($_POST['gridAgrupacionproducto']);
        }
        $valor = isset($_POST['codigo'])? $_POST['codigo'] : $_POST['nombre'];
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => Producto::model()->searchProductoAgrupacion($valor, $itemExcluido, $_POST['precio'], $_POST['idproductoPadre']),
            'columns' => array(
                array('name' => 'idproducto', 'typeCol' => 'hidden', 'value' => '$data->id'),
                array('name' => 'codigo', 'value' => '$data->codigo','width' => 20),
                array('name' => 'nombre', 'value' => '$data->nombre','width' => 64),
                array('header' => 'Udd', 'name' => 'unidad', 'value' => '$data->idunidad0->simbolo', 'width' => 8),
                array('name' => 'precio', 'value' => '$data->precio', 'width' => 8),
            ),
        ));
    }
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    
}