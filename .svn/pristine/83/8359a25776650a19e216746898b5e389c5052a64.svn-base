<?php

/*
 * PagobeneficioController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 18/06/2020
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

class PagobeneficioController extends Controller {
    /*
     * IMPORTANTE!!!
     * Los métodos filters(),_publicActionsList() y accessRules() deben copiarse
     * tal cual en todos los controladores del proyecto
     */

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
            '',
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
     */
    public function actionCreate() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = new Pagobeneficio;
        $model->fechasolicitud = null;

        if (isset($_POST['Pagobeneficio'])) {


            $model->attributes = $_POST['Pagobeneficio'];
            $respuesta = Pagobeneficio::model()->RegistrarQuinquenio($model->idhistorialestadoempleado, $model->fechasolicitud, $model->numpago, $_POST['Pagobeneficio']['idformapago'], $_POST['Pagobeneficio']['descripcionformapago']);
            if (true) {
                echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors($respuesta, $model);
                return;
            }
        }

        $this->renderPartial('create', array(
            'model' => $model,
                ), false, true);
    }

    /**
     * Updates a particular model.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = $this->loadModel(SeguridadModule::dec($id));
        $model->fechasolicitud = date("d-m-Y", strtotime($model->fechasolicitud));
        if (isset($_POST['Pagobeneficio'])) {

            $model->fechasolicitud = $_POST['Pagobeneficio']['fechasolicitud'];


            if ($model->save()) {
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }

        $this->renderPartial('update', array(
            'model' => $model,
                ), false, true);
    }
    /**
     * 
     * @param type $id, id del finiquito a modificar
     * @return intefaz con la informacion del finiquito
     */
    public function actionModificarParametrosFiniquito($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = $this->loadModel(SeguridadModule::dec($id));
        $idbeneficio = 0;
        $idprciva = 0;
        $listadeducciones = Yii::app()->rrhh
                ->createCommand("select id,descripcion,monto  from general.otrasdeduccionesbonificaciones where eliminado=false and tipo='D' and idpagobeneficio=" . $model->id)
                ->queryAll();
        $beneficio = Yii::app()->rrhh
                ->createCommand("select id, descripcion,monto  from general.otrasdeduccionesbonificaciones where eliminado=false and tipo='A' and idpagobeneficio=" . $model->id)
                ->queryAll();

        $prciva = Yii::app()->rrhh
                ->createCommand("select id, monto  from general.otrasdeduccionesbonificaciones where eliminado=false and tipo='R' and idpagobeneficio=" . $model->id)
                ->queryAll();

        $datosretiro = Yii::app()->rrhh
                ->createCommand("select idtiporetiro,fecharetiro from general.historialestadoempleado  where  id =(select idhistorialestadoempleado from general.pagobeneficio where id=" . $model->id . ")")
                ->queryAll();
        $model->idtiporetiro = $datosretiro[0]['idtiporetiro'];
        $model->fecharetiro = date("d-m-Y", strtotime($datosretiro[0]['fecharetiro']));
        $fechaminima= Yii::app()->rrhh
                ->createCommand("select  to_char( fechahasta,'dd-mm-YYYY') from planilla where id =( select split_part(listaplanilla,',',1)::int from general.pagobeneficio where id=".$model->id.")"  )
                ->queryScalar();
        if (count($prciva) > 0) {
            $idprciva = $prciva[0]['id'];
            $model->prciva = $prciva[0]['monto'];
        } else {
            $model->prciva = 0;
        }

        if (isset($_POST['Pagobeneficio'])) {

            Pagobeneficio::model()->ActualizarParametros($model->id, $idprciva, $_POST['Pagobeneficio']['prciva'], $_POST['gridAbonos'], $_POST['gridAportaciones'], $_POST['Pagobeneficio']['idtiporetiro'], $_POST['Pagobeneficio']['fecharetiro'], $_POST['Pagobeneficio']['idformapago'], $_POST['Pagobeneficio']['infoadicionalformapago']);
            if (true) {
                echo System::dataReturn('Parametros Modificados Correctamente...');

                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }

        $this->renderPartial('modificarParametros', array(
            'model' => $model,
            'listadeducciones' => $listadeducciones,
            'beneficios' => $beneficio,
            'fechaminima'=>$fechaminima
                ), false, true);
    }
    /**
     * 
     * @param integer $id, id del aguinaldo 
     * @return interfaz par la modificacion de la fecha de pago del aguinaldo de navidad
     */
    public function actionActualizarAguinaldonavidad($id) {
            Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
            $model = $this->loadModel(SeguridadModule::dec($id));
            $model->fechapago=date ("d-m-Y",strtotime( $model->fechapago));
            $fecha=$model->fechapago;
            $model->fechasolicitud = null;
            if (isset($_POST['Pagobeneficio'])) {
                $model->attributes = $_POST['Pagobeneficio'];
                $respuesta = Pagobeneficio::model()->ActualizarAguinaldoNavidad($fecha,$model->fechapago);
                if (true) {
                    echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {
                    echo System::hasErrors($respuesta, $model);
                    return;
                }
            }

            $this->renderPartial('actualizaraguinaldonavidad', array(
                'model' => $model,
                    ), false, true);
     }
     /**
      * 
      * @param integer $id, id del aguinaldo 
      * @return interfaz par la modificacion de la fecha de pago y porcentaje  del segundo aguinaldo 
      */
      public function actionActualizarSegundoAguinaldo($id) {
             Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
             $model = $this->loadModel(SeguridadModule::dec($id));
             $model->fechapago=date ("d-m-Y",strtotime( $model->fechapago));
             $fecha=$model->fechapago;
             $model->porcentaje=$model->diasvacacion;
             $model->fechasolicitud = null;
             if (isset($_POST['Pagobeneficio'])) {
                 $model->attributes = $_POST['Pagobeneficio'];
                 $respuesta = Pagobeneficio::model()->ActualizarSegundoAguinaldo($fecha,$model->fechapago,$_POST['Pagobeneficio']['porcentaje']);
                 if (true) {
                    echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
                  } else {
                     echo System::hasErrors($respuesta, $model);
                     return;
                    }
                }

             $this->renderPartial('actualizarsegundoaguinaldo', array(
                    'model' => $model,
                        ), false, true);
      }
     /**
      * 
      * @param integer $id , id del aguinaldo
      * @return  interfaz para la consolidacion
      */
      public function actionConsolidarAguinaldo($id) {
         Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
                    $model = $this->loadModel(SeguridadModule::dec($id));

                    if (isset($_POST['Pagobeneficio'])) {
                        $model->attributes = $_POST['Pagobeneficio'];
                        $respuesta = Pagobeneficio::model()->ConsolidarAguinaldo($model->fechapago,$model->idtipopagobeneficio);
                        if (true) {
                            echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                            return;
                        } else {
                            echo System::hasErrors($respuesta, $model);
                            return;
                        }
                    }

                    $this->renderPartial('consolidaraguinaldo', array(
                        'model' => $model,
                            ), false, true);
      }
      /**
       * 
       * @return interfa para el registro de aguinaldo de navidad
       */
      public function actionAguinaldonavidad() {
                Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
                $model = new Pagobeneficio;
                $model->fechasolicitud = null;

                if (isset($_POST['Pagobeneficio'])) {


                    $model->attributes = $_POST['Pagobeneficio'];
                    $respuesta = Pagobeneficio::model()->RegistrarAguinaldoNavidad($model->fechapago);
                    if ($respuesta =='') {
                        echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                        return;
                    } else {
                        echo System::hasErrors($respuesta, $model);
                        return;
                    }
                }

                $this->renderPartial('aguinaldonavidad', array(
                    'model' => $model,
                        ), false, true);
            }
/**
 * 
 * @return interfaz para el registro de segundo aguinaldo
 */
    public function actionSegundoaguinaldo() {
        
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = new Pagobeneficio;
        $model->fechasolicitud = null;
        if (isset($_POST['Pagobeneficio'])) {
            $model->attributes = $_POST['Pagobeneficio'];
            $respuesta = Pagobeneficio::model()->RegistrarSegundoaguinaldo($model->fechapago,$_POST['Pagobeneficio']['porcentaje']);
            if ($respuesta=='') {
                echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors($respuesta, $model);
                return;
            }
        }

        $this->renderPartial('segundoaguinaldo', array(
            'model' => $model,
                ), false, true);
    }
/**
 * 
 * @return interfaz para el registr de la prima anual(sujeto a cambios)
 */
    public function actionPrima() {

        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = new Pagobeneficio;
        $model->fechasolicitud = null;
        $model->estado = Yii::app()->rrhh
                        ->createCommand("select  case when (select count(*) from general.pagobeneficio where eliminado=false and idtipopagobeneficio=4 )=0 or  (select estado from general.pagobeneficio where eliminado=false and idtipopagobeneficio=4 order by id desc limit 1 )=2 then 2 else 1 end as estado  ")
                        ->queryScalar();


        if (isset($_POST['Pagobeneficio'])) {
            if ($model->estado == 1) {
                return;
            } else {

                $model->attributes = $_POST['Pagobeneficio'];

                $respuesta = Pagobeneficio::model()->RegistrarPrimaanual($model->fechadesde, $model->fechahasta, $model->gestion, $model->monto);

                if ($respuesta=='') {
                    echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {
                    echo System::hasErrors($respuesta, $model);
                    return;
                }
            }
        }

        $this->renderPartial('prima', array(
            'model' => $model,
                ), false, true);
    }

    /**
     * Deletes safely a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel(SeguridadModule::dec($id));
        $model = $this->loadModel(SeguridadModule::dec($id));        
        if ($model->idtipopagobeneficio == 4) {
            //  prima anual
            $usuario = Yii::app()->user->getName();
            Yii::app()->rrhh
                    ->createCommand(" select dar_baja_prima_anual(" . $model->id . ",'$usuario') ")
                    ->execute();
            self::actionAdminprimaanual();
        } else if ($model->idtipopagobeneficio == 1) {
            // quinquenios         
        
            Yii::app()->rrhh
                    ->createCommand("update general.historialestadoempleado set fechaultidemnizacion='".$model->fechadesde . "'::date  where id=" . $model->idhistorialestadoempleado . "
            ")
                    ->execute();
            $model->eliminado = true;
            $model->save();
            echo "si se elimino";
            self::actionAdmin();
        } else if ($model->idtipopagobeneficio == 2) {
            //finiquito
            $usuario = Yii::app()->user->getName();
            Yii::app()->rrhh
                    ->createCommand(" select dar_baja_finiquito(" . $model->id . ",'$usuario') ")
                    ->execute();
            self::actionAdminfiniquito();
        } else {
            ///para aguinaldo de navidadpo
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = new Pagobeneficio('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Pagobeneficio'])) {
            $model->attributes = $_GET['Pagobeneficio'];
            if (!$model->validate()) {
                echo System::hasErrorSearch($model);
                return;
            }
        }

        $this->renderPartial('admin', array(
            'model' => $model,
                ), false, true);
    }

    public function actionAdminaguinaldonavidad() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = new Pagobeneficio('searchaguinaldonavidad');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Pagobeneficio'])) {
            $model->attributes = $_GET['Pagobeneficio'];
            if (!$model->validate()) {
                echo System::hasErrorSearch($model);
                return;
            }
        }

        $this->renderPartial('adminaguinaldonavidad', array(
            'model' => $model,
                ), false, true);
    }

    public function actionAdminsegundoaguinaldo() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = new Pagobeneficio('searchsegundoaguinaldo');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Pagobeneficio'])) {
            $model->attributes = $_GET['Pagobeneficio'];
            if (!$model->validate()) {
                echo System::hasErrorSearch($model);
                return;
            }
        }

        $this->renderPartial('adminsegundoaguinaldo', array(
            'model' => $model,
                ), false, true);
    }

    public function actionAdminprimaanual() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = new Pagobeneficio('searchprimaanual');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Pagobeneficio'])) {
            $model->attributes = $_GET['Pagobeneficio'];
            if (!$model->validate()) {
                echo System::hasErrorSearch($model);
                return;
            }
        }

        $this->renderPartial('adminprimaanual', array(
            'model' => $model,
                ), false, true);
    }

    public function actionAdminfiniquito() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = new Pagobeneficio('searchfiniquito');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Pagobeneficio'])) {
            $model->attributes = $_GET['Pagobeneficio'];
            if (!$model->validate()) {
                echo System::hasErrorSearch($model);
                return;
            }
        }

        $this->renderPartial('adminfiniquito', array(
            'model' => $model,
                ), false, true);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Pagobeneficio the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Pagobeneficio::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Pagobeneficio $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pagobeneficio-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    /**
     * @param string $_GET['term'] , nombre completo o parte del nombre del empleado
     * return lista de empleado cuyos nombres contengan a $_GET['term']
     */
    public function actionAutocompletePersona() {
        $request = trim($_GET['term']);
        $requestMayuscula = strtoupper($request);
        if ($request != '') {
            $lista = Yii::app()->rrhh->CreateCommand("select p.nombre,p.apellidop,p.apellidom,hee.id from general.historialestadoempleado hee inner join general.empleado e on e.id=hee.idempleado inner join general.persona p on p.id=e.idpersona where p.nombrecompleto like'%" . $requestMayuscula . "%'  and hee.id in (select distinct ( select max(id) from general.historialestadoempleado where eliminado=false and idempleado= he.idempleado ) from general.historialestadoempleado he  where he.eliminado=false   )")
                    ->queryAll();
            $data = array();
            for ($i = 0; $i < count($lista); $i++) {

                $data[] = array(
                    'value' => $lista[$i]['apellidop'] . ' ' . $lista[$i]['apellidom'] . ' ' . $lista[$i]['nombre'],
                    'id' => $lista[$i]['id'],
                );
            }
            $this->layout = 'empty';
            echo CJSON::encode($data);
        }
    }
    /**
     * @param integer $_POST['ids'], id relacionado con  el empleado activo
     * retorna interfaz para el registro de quinquenio
     */
    public function actionSolicitudquinquenio() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $idhee = $_POST['ids'];
        $obs = '';

        $datos = Yii::app()->rrhh
                        ->createCommand("select (select max(id) from general.pagobeneficio where eliminado=false and idtipopagobeneficio=1 and idhistorialestadoempleado=$idhee ) as id, trunc(extract(YEAR FROM age (now()::date ,(select fechaultidemnizacion from general.historialestadoempleado where id=$idhee and eliminado=false  order by id desc limit 1)))/5) as cantidad
        ")
                        ->queryAll()[0];
        if ($datos['id'] == null) {
            $model = new Pagobeneficio;
            $model->estado = 1;
        } else {
            $model = $model = Pagobeneficio::model()->findByPk($datos['id']);
            $model->fechasolicitud = null;
            if ($model->estado == 1) {
                $obs = 'Tiene Quinquenio por consolida...';
            }
        }

        $model->numeroquinquenios = $datos['cantidad'];

        $this->renderPartial('_solicitudquinquenio', array(
            'model' => $model,
            'observacion' => $obs,
                ), false, true);
    }
    /**
     * 
     * @param integer $id, id de la prima anual
     * retorna una interfa en la que muestra los posibles beneficiarios
     */
    public function actionListaempleadoprimaanual($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $id = SeguridadModule::dec($id);
        $model = new Pagobeneficio;
        $listaempleados = Yii::app()->rrhh->createCommand("select pb.id,p.nombrecompleto as empleados,(case hee.activo when 0 then 'Retirado'else 'Vigente'end ) as estado from general.pagobeneficio pb inner join general.historialestadoempleado hee on hee.id=pb.idhistorialestadoempleado inner join general.empleado e on e.id=hee.idempleado inner join general.persona p on p.id=e.idpersona where pb.eliminado=false and pb.idtipopagobeneficio=4 and fechadesde=(select fechadesde from general.pagobeneficio where id=" . $id . ") and fechahasta=( select fechahasta from general.pagobeneficio where id=" . $id . " ) order by p.nombrecompleto ,hee.id asc    ")->queryAll();

        if (isset($_POST['gridListaEmpleados'])) {
            Pagobeneficio::model()->GuaradarListaempleadoPrima($_POST['gridListaEmpleados']);
        }
        $this->renderPartial('listaempleadosprima', array(
            'listaempleados' => $listaempleados,
            'model' => $model
                ), false, true);
    }
    /**
     * 
     * @param integer $idempleado, id del empleado
     * retorna el finiquito que se acaba de crear
     */
    public function actionImprimirFiniquitoAlCrear($idempleado) {
        $idempleado=Persona::model()->findAllByPk(SeguridadModule::dec($idempleado))[0]->empleados[0]->id;
        $id = Pagobeneficio::model()->getLastFiniquito($idempleado);
        $this->actionDescargarFiniquito(SeguridadModule::enc($id));
    }
    /**
     * 
     * @param integer $id, id relacionado con el finiquito
     * retorna reporte del finiquito que se quiere
     */
    public function actionDescargarFiniquito($id) {

        $id = SeguridadModule::dec($id);
        $re = new JasperReport('/reports/RRHH/ReporteFiniquito', JasperReport::FORMAT_PDF, array(
            'p_idpagobeneficio' => $id
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
   * @param integer $id, id de la baja 
   * retorna interfaz para generar el repor de la baja
   */
  public function actionDescargarBajaCNS($id) {
    Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model=$this->loadModel(SeguridadModule::dec($id));
        $model->fechapago='';
        
        
        $this->renderPartial('bajaCNS',array(
            'model'=>$model
          
        ), false, true);

        
}
/**
 * 
 * @param integer[] $info,$info[0]=id relacionado con la baja que se quire y $info[1]= fecha presentacion
 * retorna el reportde la baja
 */
public function actionImprimirBajaCNS($info){
  $info= explode(' ', $info);
    $re = new JasperReport('/reports/RRHH/ReporteBajaCNS', JasperReport::FORMAT_PDF, array(
                'p_idpagobeneficio' => SeguridadModule::dec($info[0]),
                'p_fechapresentacion'=>"'".$info[1]."'"
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
     * @param integer $id, id relacionado con el quinquenio
     * retorna reporte pdf del quinquenio
     * 
     */
    public function actionDescargarReporteQuinquenio($id)
        {

        $id=SeguridadModule::dec($id); 


           $re = new JasperReport('/reports/RRHH/ReporteQuinquenio', JasperReport::FORMAT_PDF, array(
                'p_idpagobeneficio'=> $id            
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
     * @param integer $id, id relacionado con el quinquenio
     * retorna reporte xls del quinquenio
     */
    public function actionDescargarBoletaQuinquenio($id)
    {
         $id=SeguridadModule::dec($id);
        $fila=16;
        $nombre='Ejemplo';
        $datosempleado=Yii::app()->rrhh
        ->createCommand("select e.id,p.apellidop ||substring(p.nombre from 1 for 1) as iniciales,p.ci||'-'||p.expedicion as ci,p.ci as nci,p.nombrecompleto,p.sexo,(
            select pa.nacionalidad from general.localidad l inner join general.municipio m on m.id=l.idmunicipio inner join general.provincia pr on pr.id=m.idprovincia inner join ftbl_compra_departamento d on d.id=pr.iddepartamento inner join ftbl_compra_pais pa on pa.id=d.idpais where l.id=p.idlocalidad),to_char(p.fechanac,'dd-mm-YYYY') as fechanac,he.fechaultidemnizacion from general.persona p inner join general.empleado e on e.idpersona=p.id inner join general.historialestadoempleado he on he.idempleado=e.id inner join general.pagobeneficio pb on pb.idhistorialestadoempleado=he.id where pb.id= ".$id)
        ->queryAll()[0];
        
        $datosquinquenio=Yii::app()->rrhh->createCommand(" select numpago,to_char(fechasolicitud,'dd-mm-YYYY') as solicitud,to_char(fechadesde,'dd-mm-YYYY') as desde,to_char(fechahasta,'dd-mm-YYYY') as hasta,date_part('year',fechahasta )-date_part('year',fechadesde) as anios,split_part(listaplanilla,',',1)::int as idplanilla,listaplanilla ,monto from general.pagobeneficio where id=".$id)
        ->queryAll()[0];
        if($datosquinquenio['listaplanilla']!=''){
        $cempleado=Yii::app()->rrhh
        ->createCommand("select distinct ( select sum(t.hbasico::numeric(12,2)) from ( select json_array_elements(general)->>'hbasicoreal' as hbasico from cuerpo where idplanilla=".$datosquinquenio['idplanilla']." and idempleado=".$datosempleado['id'].") t),
to_char((json_array_elements(general)->>'fechai')::date,'dd-mm-YYYY') as fechai,json_array_elements(general)->>'cargo' as cargo from cuerpo where idplanilla= ".$datosquinquenio['idplanilla'] ." and idempleado=".$datosempleado['id'])
        ->queryAll()[0];
        $datoEmpresa=Yii::app()->rrhh
        ->createCommand("select e.razonsocial,e.nit,e.nrempleadormt,nrempleador,pl.nombrer,pl.cir from planilla pl inner join general.representante r on r.cirepresentante=pl.cir inner join general.empresa e on e.id=r.idempresa  where pl.id=".$datosquinquenio['idplanilla'])
        ->queryAll()[0]; 

        $datos=Yii::app()->rrhh
        ->createCommand("select distinct c1.idplanilla,( select sum(t.hb::numeric(12,2)) from ( select json_array_elements(c.general)->>'hbasicoreal' as hb from cuerpo c where c.idplanilla=c1.idplanilla and c.idempleado=c1.idempleado) t) as hbasico,
(select case when mes=1 then'Enero' when mes=2 then 'Febrero' when mes=3 then 'Marzo' when mes=4 then 'Abril' when mes=5 then 'Mayo' when mes=6 then 'Junio' when mes=7 then 'Julio' when mes=8 then 'Agosto' when mes=9 then 'Septiembre' when mes=10 then 'Octubre' when mes=11 then 'Noviembre' else 'Diciembre' end as mes from planilla where id =c1.idplanilla)
,( select sum(t.ba::numeric(12,2)) from  ( select  json_array_elements(c.beneficio)->>'BONODEANTIGUEDAD' as ba from cuerpo c where c.idplanilla=c1.idplanilla and c.idempleado=c1.idempleado) t) as antiguedad,
(select sum(t.d::numeric(12,2)) from ( select json_array_elements(c.beneficio)->>'DOMINICAL' as d from cuerpo  c where c.idplanilla=c1.idplanilla and c.idempleado=c1.idempleado) t) as dominical,
( select sum(t.h::numeric(12,2)) from ( select json_array_elements(c.beneficio)->>'HORAEXTRAP' as h from cuerpo c where c.idplanilla=c1.idplanilla and c.idempleado=c1.idempleado) t )as extra,
( select sum(t.b::numeric(12,2)) from ( select json_array_elements(c.beneficio)->>'otrosbonos' as b from cuerpo c where c.idplanilla=c1.idplanilla and c.idempleado=c1.idempleado) t )as otrob,
(select sum(t.ca::numeric(12,2)) from ( select json_array_elements(c.beneficio)->>'BONOCATEGORIZACION' as ca  from cuerpo c where c.idplanilla=c1.idplanilla and c.idempleado=c1.idempleado) t)as categorizacion,
(select sum(t.tg::numeric(12,2)) from ( select  json_array_elements(c.beneficio)->>'totalga' as tg from cuerpo c where c.idplanilla=c1.idplanilla and c.idempleado=c1.idempleado) t) as tg from cuerpo c1 where c1.idplanilla in(".$datosquinquenio['listaplanilla'].") and c1.tipo=1 and c1.idempleado=".$datosempleado['id']." order by c1.idplanilla asc")
        ->queryAll();

        }else{
        $datoEmpresa=Yii::app()->rrhh
        ->createCommand("select e.razonsocial,e.nit,e.nrempleadormt,nrempleador,r.cirepresentante as cir from  general.representante r  inner join general.empresa e on e.id=r.idempresa  where e.id=1")
        ->queryAll()[0]; 
        $cempleado=Yii::app()->rrhh
        ->createCommand("select pb.cargo,hee.fechaplanilla as fechai from general.pagobeneficio pb inner join general.historialestadoempleado hee on hee.id=pb.idhistorialestadoempleado where pb.id=".$id)
        ->queryAll()[0];
        $datos=Yii::app()->rrhh
        ->createCommand("(select 1 as id,''::text as ci, ''::text as hbasico,''::text as mes,''::text as antiguedad,''::text as dominical, ''::text as extra ,''::text as otrob,''::text as categorizacion, ''::text as tg )union(select 2 as id,''::text as ci, ''::text as hbasico,''::text as mes,''::text as antiguedad,''::text as dominical, ''::text as extra ,''::text as otrob,''::text as categorizacion, ''::text as tg ) union(select 3 as id,''::text as ci, ''::text as hbasico,''::text as mes,''::text as antiguedad,''::text as dominical, ''::text as extra ,''::text as otrob,''::text as categorizacion, ''::text as tg )    ")
        ->queryAll();

   
        }

        $nombreArchivo = 'BoletaQuinquenio_' . $datosquinquenio['numpago'] . '_' . $datosempleado['iniciales'];

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->removeSheetByIndex(0);
        $objPHPExcel->createSheet(0);
        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $activeSheet->setTitle($nombreArchivo);
        $activeSheet->getDefaultColumnDimension()->setWidth(14);
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
        $phpColor = array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '#00ccff'
            ),
            'font' => array(
                'bold' => true,)
        );
        $phpFontC = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'font' => array(
                'bold' => true,
            )
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
        $phpFontCuadricula = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
        );
        $phpFontCuadriculan = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'font' => array(
                'bold' => true,
            )
        );
        $activeSheet->getRowDimension('15')->setRowHeight(40);
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);

        $activeSheet->getColumnDimension('A')->setWidth(25);
        $activeSheet->getColumnDimension('B')->setWidth(25);
        $activeSheet->getColumnDimension('C')->setWidth(25);
        $activeSheet->getColumnDimension('D')->setWidth(25);
        $activeSheet->getColumnDimension('E')->setWidth(25);
        $activeSheet->getColumnDimension('F')->setWidth(25);
        $activeSheet->getColumnDimension('G')->setWidth(25);
        $activeSheet->getColumnDimension('H')->setWidth(25);
        $activeSheet->getColumnDimension('I')->setWidth(25);



        /////////
        $activeSheet->mergeCells('A1:B1');
        $activeSheet->mergeCells('C1:D1');
        $activeSheet->getStyle("A1")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("C1")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("A2")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("C2")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("A3")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("B3")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("C3")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("D3")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("A4")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("B4")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("C4")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("D4")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("A5")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("B5")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("C5")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("D5")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("A6")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("B6")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("C6")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("D6")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("A7")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("B7")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("C7")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("D7")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("A8")->applyFromArray($phpFontCuadricula);

        $activeSheet->getStyle("A9")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("B9")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("C9")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("D9")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("A9")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("B9")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("C9")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("D9")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("A10")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("B10")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("C10")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("D10")->applyFromArray($phpFontCuadricula);

        $activeSheet->getStyle('A1')->getFont()->setBold(true);


        $activeSheet->getStyle("A2")->getFont()->setBold(true);
        $activeSheet->getStyle("A2")->applyFromArray($phpFontCuadricula);
        $activeSheet->getStyle("A3")->getFont()->setBold(true);
        $activeSheet->getStyle("C3")->getFont()->setBold(true);
        $activeSheet->getStyle("A4")->getFont()->setBold(true);
        $activeSheet->getStyle("A5")->getFont()->setBold(true);
        $activeSheet->getStyle("C5")->getFont()->setBold(true);
        $activeSheet->getStyle("A6")->getFont()->setBold(true);
        $activeSheet->getStyle("C6")->getFont()->setBold(true);
        $activeSheet->getStyle("A7")->getFont()->setBold(true);
        $activeSheet->getStyle("C7")->getFont()->setBold(true);

        $activeSheet->getStyle("A9")->getFont()->setBold(true);
        $activeSheet->getStyle("C9")->getFont()->setBold(true);
        $activeSheet->getStyle("A10")->getFont()->setBold(true);
        $activeSheet->getStyle("C10")->getFont()->setBold(true);
        $activeSheet->mergeCells('A2:B2');
        $activeSheet->setCellValue('A1', 'NOMBRE O RAZÓN SOCIAL');
        $activeSheet->setCellValue('C1', $datoEmpresa['razonsocial']);

        $activeSheet->setCellValue('A2', 'Nº EMPLEADOR MINISTERIO DE TRABAJO');
        $activeSheet->setCellValue('C2', $datoEmpresa['nrempleadormt']);

        $activeSheet->setCellValue('A3', 'Nº DE NIT');
        $activeSheet->setCellValue('B3', $datoEmpresa['nit']);
        $activeSheet->setCellValue('C3', 'Nº DE EMPLEADOR (Seguro Salud)');
        $activeSheet->setCellValue('D3', $datoEmpresa['nrempleador']);
        $activeSheet->mergeCells('B4:D4');
        $activeSheet->setCellValue('A4', 'NOMBRE DEL TRABAJADOR');
        $activeSheet->setCellValue('B4', $datosempleado['nombrecompleto']);
        $activeSheet->setCellValue('A5', 'CI TRABAJADOR');
        $activeSheet->setCellValue('B5', $datosempleado['ci']);
        $activeSheet->setCellValue('C5', 'FECHA DE NACIMIENTO');
        $activeSheet->setCellValue('D5', $datosempleado['fechanac']);
        $activeSheet->setCellValue('A6', 'SEXO');
        $activeSheet->setCellValue('B6', $datosempleado['sexo']);
        $activeSheet->setCellValue('C6', 'CARGO');
        $activeSheet->setCellValue('D6', $cempleado['cargo']);
        $activeSheet->setCellValue('A7', 'FECHA DE INGRESO');
        $activeSheet->setCellValue('B7', $cempleado['fechai']);
        $activeSheet->setCellValue('C7', 'NACIONALIDAD');
        $activeSheet->setCellValue('D7', $datosempleado['nacionalidad']);
        $activeSheet->mergeCells('A8:D8');
        $activeSheet->getStyle("A8")->applyFromArray($phpFontP);
        $activeSheet->setCellValue('A8', 'PERIODO AL QUE CORRESPONDE EL QUINQUENIO');
        $activeSheet->setCellValue('A9', 'FECHA INICIAL');
        $activeSheet->setCellValue('B9', $datosquinquenio['desde']);
        $activeSheet->setCellValue('C9', 'FECHA FINAL');
        $activeSheet->setCellValue('D9', $datosquinquenio['hasta']);
        $activeSheet->setCellValue('A10', 'FECHA SOLICITUD');
        $activeSheet->setCellValue('B10', $datosquinquenio['solicitud']);
        $activeSheet->setCellValue('C10', 'AÑOS');
        $activeSheet->setCellValue('D10', $datosquinquenio['anios']);
        $activeSheet->mergeCells('A11:I11');

        $activeSheet->setCellValue('A11', 'PLANILLA DE QUINQUENIO');
        $activeSheet->getStyle("A11")->getFont()->setSize(16);
        $activeSheet->getStyle("A11")->applyFromArray($phpFontP);
        $activeSheet->mergeCells('A12:I12');

        $activeSheet->getStyle("A12")->applyFromArray($phpFontP);
        $activeSheet->getStyle("A15")->applyFromArray($phpFontC);
        $activeSheet->getStyle("B15")->applyFromArray($phpFontC);
        $activeSheet->getStyle("C15")->applyFromArray($phpFontC);
        $activeSheet->getStyle("D15")->applyFromArray($phpFontC);
        $activeSheet->getStyle("E15")->applyFromArray($phpFontC);
        $activeSheet->getStyle("F15")->applyFromArray($phpFontC);
        $activeSheet->getStyle("G15")->applyFromArray($phpFontC);
        $activeSheet->getStyle("H15")->applyFromArray($phpFontC);
        $activeSheet->getStyle("I15")->applyFromArray($phpFontC);
        $activeSheet->setCellValue('A12', '(En Bolivianos)');
        $activeSheet->getStyle("A15:I15")->getAlignment()->setWrapText(true);
        $activeSheet->setCellValue('A15', 'MES');
        $activeSheet->setCellValue('B15', 'Haber Básico');
        $activeSheet->setCellValue('C15', 'Bono de Antigüedad');
        $activeSheet->setCellValue('D15', 'Bono de Producción');
        $activeSheet->setCellValue('E15', 'Subsidio de Frontera');
        $activeSheet->setCellValue('F15', 'Trabajo Extraordinario y Nocturno');
        $activeSheet->setCellValue('G15', 'Pago Dominical y Domingo Trabajado');
        $activeSheet->setCellValue('H15', 'Otros Bonos');
        $activeSheet->setCellValue('I15', 'Total Ganado'); 
        if ($datosquinquenio['listaplanilla'] != '') {

            $cant = count($datos);

            for ($i = 0; $i < $cant; $i++) {
                $activeSheet->getStyle("A" . $fila)->applyFromArray($phpFontCuadricula);
                $activeSheet->getStyle("B" . $fila)->applyFromArray($phpFontCuadricula);
                $activeSheet->getStyle("C" . $fila)->applyFromArray($phpFontCuadricula);
                $activeSheet->getStyle("D" . $fila)->applyFromArray($phpFontCuadricula);
                $activeSheet->getStyle("E" . $fila)->applyFromArray($phpFontCuadricula);
                $activeSheet->getStyle("F" . $fila)->applyFromArray($phpFontCuadricula);
                $activeSheet->getStyle("G" . $fila)->applyFromArray($phpFontCuadricula);
                $activeSheet->getStyle("H" . $fila)->applyFromArray($phpFontCuadricula);
                $activeSheet->getStyle("I" . $fila)->applyFromArray($phpFontCuadricula);
                $activeSheet->setCellValue('A' . $fila, $datos[$i]['mes']);
                $activeSheet->getStyle('B' . $fila)->getNumberFormat()->setFormatCode('0.00');

                $activeSheet->getStyle('B' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $activeSheet->getStyle('C' . $fila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('C' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $activeSheet->getStyle('D' . $fila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('D' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $activeSheet->getStyle('E' . $fila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('E' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $activeSheet->getStyle('F' . $fila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('F' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $activeSheet->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('G' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $activeSheet->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('H' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $activeSheet->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('0.00');
                $activeSheet->getStyle('I' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $activeSheet->setCellValue('B' . $fila, $datos[$i]['hbasico']);
                $activeSheet->setCellValue('C' . $fila, $datos[$i]['antiguedad']);
                $activeSheet->setCellValue('D' . $fila, '0.00');
                $activeSheet->setCellValue('E' . $fila, '0.00');
                $activeSheet->setCellValue('F' . $fila, $datos[$i]['extra']);
                $activeSheet->setCellValue('G' . $fila, $datos[$i]['dominical']);
                $otrob = $datos[$i]['otrob'] + $datos[$i]['categorizacion'];
                $activeSheet->setCellValue('H' . $fila, $otrob);
                $activeSheet->setCellValue('I' . $fila, $datos[$i]['tg']);
                $fila += 1;
            }
        }
        $activeSheet->getStyle("A19")->applyFromArray($phpFontCuadriculan);
        $activeSheet->getStyle("A20")->applyFromArray($phpFontCuadriculan);
        $activeSheet->getStyle("B20")->applyFromArray($phpFontCuadriculan);
        $activeSheet->getStyle("B19")->applyFromArray($phpFontCuadriculan);
        $activeSheet->getStyle("C19")->applyFromArray($phpFontCuadriculan);
        $activeSheet->getStyle("D19")->applyFromArray($phpFontCuadriculan);
        $activeSheet->getStyle("E19")->applyFromArray($phpFontCuadriculan);
        $activeSheet->getStyle("F19")->applyFromArray($phpFontCuadriculan);
        $activeSheet->getStyle("G19")->applyFromArray($phpFontCuadriculan);
        $activeSheet->getStyle("H19")->applyFromArray($phpFontCuadriculan);
        $activeSheet->getStyle("I19")->applyFromArray($phpFontCuadriculan);
        $activeSheet->getStyle('B19')->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('B19')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('C19')->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('C19')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('D19')->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('D19')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('E19')->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('E19')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('F19')->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('F19')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('G19')->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('G19')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('H19')->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('H19')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('I19')->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('I19')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('B20')->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('B20')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $activeSheet->setCellValue('A19', 'PROMEDIO');
        $promedio = round((($activeSheet->getCellByColumnAndRow(1, 16)->getValue() + $activeSheet->getCellByColumnAndRow(1, 17)->getValue() + $activeSheet->getCellByColumnAndRow(1, 18)->getValue()) / 3), 2);
        $activeSheet->setCellValue('B19', $promedio);
        $promedio = round((($activeSheet->getCellByColumnAndRow(2, 16)->getValue() + $activeSheet->getCellByColumnAndRow(2, 17)->getValue() + $activeSheet->getCellByColumnAndRow(2, 18)->getValue()) / 3), 2);

        $activeSheet->setCellValue('C19', $promedio);

        $promedio = round((($activeSheet->getCellByColumnAndRow(3, 16)->getValue() + $activeSheet->getCellByColumnAndRow(3, 17)->getValue() + $activeSheet->getCellByColumnAndRow(3, 18)->getValue()) / 3), 2);
        $activeSheet->setCellValue('D19', $promedio);
        $promedio = round((($activeSheet->getCellByColumnAndRow(4, 16)->getValue() + $activeSheet->getCellByColumnAndRow(4, 17)->getValue() + $activeSheet->getCellByColumnAndRow(4, 18)->getValue()) / 3), 2);
        $activeSheet->setCellValue('E19', $promedio);
        $promedio = round((($activeSheet->getCellByColumnAndRow(5, 16)->getValue() + $activeSheet->getCellByColumnAndRow(5, 17)->getValue() + $activeSheet->getCellByColumnAndRow(5, 18)->getValue()) / 3), 2);
        $activeSheet->setCellValue('F19', $promedio);
        $promedio = round((($activeSheet->getCellByColumnAndRow(6, 16)->getValue() + $activeSheet->getCellByColumnAndRow(6, 17)->getValue() + $activeSheet->getCellByColumnAndRow(6, 18)->getValue()) / 3), 2);
        $activeSheet->setCellValue('G19', $promedio);
        $promedio = round((($activeSheet->getCellByColumnAndRow(7, 16)->getValue() + $activeSheet->getCellByColumnAndRow(7, 17)->getValue() + $activeSheet->getCellByColumnAndRow(7, 18)->getValue()) / 3), 2);
        $activeSheet->setCellValue('H19', $promedio);
        $promedio = round((($activeSheet->getCellByColumnAndRow(8, 16)->getValue() + $activeSheet->getCellByColumnAndRow(8, 17)->getValue() + $activeSheet->getCellByColumnAndRow(8, 18)->getValue()) / 3), 2);
        $activeSheet->setCellValue('I19', $promedio);
        $activeSheet->setCellValue('A20', 'QUIQUENIO A PAGAR');
        if ($datosquinquenio['listaplanilla'] == '') {
            $activeSheet->setCellValue('B20', $datosquinquenio['monto']);
        } else {
            $activeSheet->setCellValue('B20', '=I19*D10');
        }

        $activeSheet->mergeCells('A25:C25');
        $activeSheet->getStyle('A25')->applyFromArray($phpFontP);
        $activeSheet->getStyle('F25')->applyFromArray($phpFontP);
        $activeSheet->setCellValue('A25', 'NOMBRE Y FIRMA DEL EMPLEADOR O REPRESENTANTE LEGAL');
        $activeSheet->mergeCells('F25:I25');
        $activeSheet->setCellValue('F25', 'NOMBRE Y FIRMA DEL TRABAJADOR');
        $this->descargarExcel($objPHPExcel, $nombreArchivo);
    
    
        }
     /**
     * 
     * @param object $objPHPExcel, con la informacion del archivo que se desea generar
     * @param string $nombreArchivo, nombre del archivo con el que se va generar el archivo xls
     */
    public function descargarExcel($objPHPExcel, $nombreArchivo) {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $nombreArchivo . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setPreCalculateFormulas(true);
        $objWriter->save('php://output');
    }
    /**
     * 
     * @param integer $id, id del quinquenio
     * @return interfaz para la consolidacion del quinquenio
     */
    public function actionConsolidarQuinquenio($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = Pagobeneficio::model()->find('t.id=' . SeguridadModule::dec($id));
        $model->scenario = 'Desea Consolidar Quinquenio?';
        if (isset($_POST['Pagobeneficio'])) {
            $usuario = Yii::app()->user->getName();          
            Yii::app()->contabilidad
                                ->createCommand("select consolidar_quinquenio(" . $model->id . ",'" . $_POST['Pagobeneficio']['fechapago'] . "'::date,'$usuario')")
                    ->execute();
       
           
           
            echo System::dataReturn('Quinquenio Consolidado');
            return;
        }
        $this->renderPartial('mensaje', array(
            'model' => $model,
                ), false, true);
    }
    /**
     * 
     * @param integer $id, id del finiquito
     * @return interfaz para la consolidacion del finiquito
     */
    public function actionConsolidarFiniquito($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = Pagobeneficio::model()->find('t.id=' . SeguridadModule::dec($id));
        $model->scenario = 'Desea Consolidar el Finiquito?';
        if (isset($_POST['Pagobeneficio'])) {
            $usuario = Yii::app()->user->getName();
            Yii::app()->contabilidad
                    ->createCommand("select consolidar_finiquito(" . $model->id . ",'" . $_POST['Pagobeneficio']['fechapago'] . "'::date,'$usuario')")
                    ->execute();
           
            
            echo System::dataReturn('Finiquito Consolidado');
            return;
        }
        $this->renderPartial('mensaje', array(
            'model' => $model,
                ), false, true);
    }
/**
 * 
 * @param integer $id , id  relacionado con el aguinaldo
 * @param integer[] $listacontratos, lista de id de los contratos
 * retorna un reporte xls para impresion  de la informacion de los aguinaldos del los empleados que su tipo de contrato este en  $listacontratos 
 */
function PlanillaAguinaldoNavidad($id,$listacontratos) {        
        $fila = 8;
        $datoEmpresa = Yii::app()->rrhh
                        ->createCommand("select e.razonsocial,e.nit,e.nrempleadormt,nrempleador,pl.nombrer,pl.cir,pl.anio,to_char(now()::date,'dd-mm-YYYY') as hoy from planilla pl inner join general.representante r on r.cirepresentante=pl.cir inner join general.empresa e on e.id=r.idempresa  where pl.id in ( select split_part(listaplanilla,',',1)::int  from general.pagobeneficio where id=" . $id . ")")
                        ->queryAll()[0];
        $datos = Yii::app()->rrhh
                ->createCommand("select * from dame_lista_aguinaldo_navidad(" . $id . ",'$listacontratos')")
                ->queryAll();

        $nombreArchivo = 'A_Navidad_' . $datoEmpresa['anio'];

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->removeSheetByIndex(0);
        $objPHPExcel->createSheet(0);
        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);
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
        $phpColor = array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '#00ccff'
            ),
            'font' => array(
                'bold' => true,)
        );
        $phpFontC = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'font' => array(
                'bold' => true,
            )
        );
        $phpFontP = array(
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
            ),);
           $phpFontPie = array(
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
        $phpFontCuadricula = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
        );
        $phpFontCuadriculan = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'font' => array(
                'bold' => true,
            )
        );
        $activeSheet->getRowDimension('7')->setRowHeight(50);
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);
        $img = realpath(__DIR__ . '/../../../../images'); // Provide path to your logo file

        $imgot = $img . '/logoEmpresa.png';
        $objDrawingt = new PHPExcel_Worksheet_Drawing();
        $objDrawingt->setName('imgNotice');
        $objDrawingt->setDescription('Noticia');
        $objDrawingt->setPath($imgot);
        $objDrawingt->setOffsetX(5);    // setOffsetX works properly
        $objDrawingt->setOffsetY(0);  //setOffsetY has no effect
        $objDrawingt->setCoordinates('N1');
        $objDrawingt->setWidthAndHeight(140, 70);
        $objDrawingt->setResizeProportional(true);
        $objDrawingt->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
        $activeSheet->getColumnDimension('A')->setWidth(5);
        $activeSheet->getColumnDimension('B')->setWidth(12);
        $activeSheet->getColumnDimension('C')->setWidth(40);
        $activeSheet->getColumnDimension('D')->setWidth(11);
        $activeSheet->getColumnDimension('E')->setWidth(11);
        $activeSheet->getColumnDimension('F')->setWidth(5);
        $activeSheet->getColumnDimension('G')->setWidth(30);
        $activeSheet->getColumnDimension('H')->setWidth(10);
        $activeSheet->getColumnDimension('I')->setWidth(10);
        $activeSheet->getColumnDimension('J')->setWidth(10);
        $activeSheet->getColumnDimension('K')->setWidth(10);
        $activeSheet->getColumnDimension('L')->setWidth(10);
        $activeSheet->getColumnDimension('M')->setWidth(10);
        $activeSheet->getColumnDimension('N')->setWidth(10);
        $activeSheet->getColumnDimension('O')->setWidth(10);
        $activeSheet->getColumnDimension('P')->setWidth(10);
        $activeSheet->getColumnDimension('Q')->setWidth(10);
        $activeSheet->getColumnDimension('R')->setWidth(10);
        $activeSheet
                ->getPageMargins()->setTop(0.4);
        $activeSheet
                ->getPageMargins()->setRight(0.2);
        $activeSheet
                ->getPageMargins()->setLeft(0.2);
        $activeSheet
                ->getPageMargins()->setBottom(0.8);

        $activeSheet->mergeCells('A1:E1');
        $activeSheet->mergeCells('A2:E2');
        $activeSheet->mergeCells('D1:Q1');
        $activeSheet->mergeCells('D2:Q2');
        $activeSheet->mergeCells('D3:Q3');
        $activeSheet->mergeCells('D4:Q4');
        $activeSheet->mergeCells('B5:Q5');
        $activeSheet->mergeCells('A4:Q4');
        $activeSheet->mergeCells('A5:Q5');
       
        $activeSheet->getStyle('A1')->getFont()->setBold(true);
        $activeSheet->getStyle("A2")->getFont()->setBold(true);
        $activeSheet->getStyle('B3')->getFont()->setBold(true);
        $activeSheet->getStyle("B4")->getFont()->setBold(true);

        $activeSheet->setCellValue('A1', 'NOMBRE O RAZÓN SOCIAL : '.$datoEmpresa['razonsocial'] );
      

        $activeSheet->setCellValue('A2', 'Nº EMPLEADOR MINISTERIO DE TRABAJO : '.$datoEmpresa['nrempleadormt']);
        

     


        $activeSheet->setCellValue('A4', 'PLANILLA DE PAGO DE AGUINALDOS ');
        $activeSheet->setCellValue('A5', 'Correspondientes al mes de : Diciembre gestión '.$datoEmpresa['anio']);
        $activeSheet->getStyle("A4")->getFont()->setSize(14);
        $activeSheet->getStyle("A5")->getFont()->setSize(10);
        $activeSheet->getStyle('A4' )->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('A5' )->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $activeSheet->getStyle("A4")->applyFromArray($phpFontP);
 
        $activeSheet->getStyle("A7:R7")->applyFromArray($phpFontC);

        $activeSheet->setCellValue('A12', '(En Bolivianos)');
        $activeSheet->getStyle("A7:S7")->getAlignment()->setWrapText(true);
        $activeSheet->setCellValue('A7', 'Nº');
        $activeSheet->setCellValue('B7', 'Carnet de Identidad');
        $activeSheet->setCellValue('C7', 'Nombre Completo');      
        $activeSheet->setCellValue('D7', 'Nacionalidad');
        $activeSheet->setCellValue('E7', 'Fecha de Naciemiento');
        $activeSheet->setCellValue('F7', 'Sexo');
        $activeSheet->setCellValue('G7', 'Ocupación que Desempeña');
        $activeSheet->setCellValue('H7', 'Fecha de Ingreso');
        $activeSheet->setCellValue('I7', 'Promedio del haber básico');
        $activeSheet->setCellValue('J7', 'Promedio del bono de antigüedad');
        $activeSheet->setCellValue('K7', 'Promedio del bono de producción');
        $activeSheet->setCellValue('L7', 'Promedio del subsidio de frontera');
        $activeSheet->setCellValue('M7', 'Promedio trabajo extraordinario y nocturno');
        $activeSheet->setCellValue('N7', 'Promedio pago dominical y domingo trabajado');
        $activeSheet->setCellValue('O7', 'Promedio otros bonos');
        $activeSheet->setCellValue('P7', 'Promedio total ganado');
        $activeSheet->setCellValue('Q7', 'Meses trabajados');
        $activeSheet->setCellValue('R7', 'Total ganado después de duodécimas');
      //  $activeSheet->setCellValue('S7', 'FIRMA DEL EMPLEADO');        
        $cant = count($datos);

        for ($i = 0; $i < $cant; $i++) {
            $activeSheet->getRowDimension($fila)->setRowHeight(22);
            $activeSheet->getStyle("C".$fila)->getAlignment()->setWrapText(true);
            $activeSheet->getStyle("G".$fila)->getAlignment()->setWrapText(true);
            $activeSheet->getStyle("A" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("B" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("C" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("D" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("E" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("F" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("G" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("H" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("I" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("J" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("K" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("L" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("M" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("N" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("O" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("P" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("Q" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("R" . $fila)->applyFromArray($phpFontCuadricula);
           // $activeSheet->getStyle("S" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->setCellValue('A' . $fila, $i + 1);
            $activeSheet->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('I' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('J' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $activeSheet->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('K' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('L' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('M' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('N' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('O' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('P' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('P' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('Q' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('Q' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('R' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('R' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
           
            $activeSheet->setCellValue('B' . $fila, $datos[$i]['ci']);
            $activeSheet->setCellValue('C' . $fila, $datos[$i]['nombrec']);
            $activeSheet->setCellValue('D' . $fila, $datos[$i]['nacionalidad']);
            $activeSheet->setCellValue('E' . $fila, $datos[$i]['fechanac']);
            $activeSheet->setCellValue('F' . $fila, $datos[$i]['sexo']);
            $activeSheet->setCellValue('G' . $fila, $datos[$i]['cargo']);
            $activeSheet->setCellValue('H' . $fila, $datos[$i]['fechaingreso']);
            $activeSheet->setCellValue('I' . $fila, $datos[$i]['hbasico']);
            $activeSheet->setCellValue('J' . $fila, $datos[$i]['antiguedad']);
            $activeSheet->setCellValue('K' . $fila, $datos[$i]['bonoproduccion']);
            $activeSheet->setCellValue('L' . $fila, $datos[$i]['frontera']);
            $activeSheet->setCellValue('M' . $fila, $datos[$i]['extra']);
            $activeSheet->setCellValue('N' . $fila, $datos[$i]['dominical']);
            $activeSheet->setCellValue('O' . $fila, $datos[$i]['otrob']);
            $activeSheet->setCellValue('P' . $fila, $datos[$i]['promedio']);
            $activeSheet->setCellValue('Q' . $fila, $datos[$i]['cantmes']);
            $activeSheet->setCellValue('R' . $fila, $datos[$i]['totalganadonav']);


            $fila += 1;
        }
         $activeSheet->getStyle("G11:G".$fila)->getAlignment()->setWrapText(true);
        $activeSheet->mergeCells('A' . $fila . ':H' . $fila);
        $activeSheet->setCellValue('A' . $fila, 'TOTALES');
        $activeSheet->getStyle("A" . $fila . ':H' . $fila)->applyFromArray($phpFontCuadriculan);
        $activeSheet->getStyle("I" . $fila . ':R' . $fila)->applyFromArray($phpFontCuadriculan);
        $activeSheet->getStyle('I' . $fila . ':R' . $fila)->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('A' . $fila )->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('I' . $fila . ':R' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('A' . $fila )->getFont()->setBold(true);
        $activeSheet->getStyle('I' . $fila . ':R' . $fila)->getFont()->setBold(true);
        $activeSheet->setCellValue('I' . $fila, '=SUM(I8:I' . ($fila - 1) . ')');
        $activeSheet->setCellValue('J' . $fila, '=SUM(J8:J' . ($fila - 1) . ')');
        $activeSheet->setCellValue('K' . $fila, '=SUM(K8:K' . ($fila - 1) . ')');
        $activeSheet->setCellValue('L' . $fila, '=SUM(L8:L' . ($fila - 1) . ')');
        $activeSheet->setCellValue('M' . $fila, '=SUM(M8:M' . ($fila - 1) . ')');
        $activeSheet->setCellValue('N' . $fila, '=SUM(N8:N' . ($fila - 1) . ')');
        $activeSheet->setCellValue('O' . $fila, '=SUM(O8:O' . ($fila - 1) . ')');
        $activeSheet->setCellValue('P' . $fila, '=SUM(P8:P' . ($fila - 1) . ')');
        $activeSheet->setCellValue('Q' . $fila, '=SUM(Q8:Q' . ($fila - 1) . ')');
        $activeSheet->setCellValue('R' . $fila, '=SUM(R8:R' . ($fila - 1) . ')');
        $fila += 5;
        $activeSheet->mergeCells('C' . $fila . ':E' . $fila);
        $activeSheet->mergeCells('G' . $fila . ':H' . $fila);
        $activeSheet->mergeCells('J' . $fila . ':K' . $fila);
        $activeSheet->getStyle('C' . $fila)->applyFromArray($phpFontPie);
        $activeSheet->getStyle('G' . $fila)->applyFromArray($phpFontPie);
        $activeSheet->getStyle('J' . $fila)->applyFromArray($phpFontPie);
        $activeSheet->getStyle('M' . $fila )->getFont()->setBold(true);
        $activeSheet->setCellValue('C' . $fila, 'NOMBRE DEL EMPLEADOR O REPRESENTANTE LEGAL');
        $activeSheet->setCellValue('G' . $fila, 'Nº DE DOCUMENTO DE IDENTIDAD');
        $activeSheet->setCellValue('J' . $fila, 'FIRMA');
        $activeSheet->setCellValue('M' . $fila, 'FECHA: ');
        $activeSheet->setCellValue('N' . $fila, $datoEmpresa['hoy']);


        $this->descargarExcel($objPHPExcel, $nombreArchivo);
    }
    /**
    * 
    * @param integer $id , id  relacionado con el aguinaldo
    * @param integer[] $listacontratos, lista de id de los contratos
    * retorna un reporte xls para la presentacion al miniterio de trabajo  de la informacion de los aguinaldos del los empleados que su tipo de contrato este en  $listacontratos 
    */
    function PlanillaAguinaldoNavidadMinisterio($id,$listacontratos) {

       
        $fila = 2;
        $nombre = 'Ejemplo';
        $datoEmpresa = Yii::app()->rrhh
                        ->createCommand("select e.razonsocial,e.nit,e.nrempleadormt,nrempleador,pl.nombrer,pl.cir,pl.anio,to_char(now()::date,'dd-mm-YYYY') as hoy from planilla pl inner join general.representante r on r.cirepresentante=pl.cir inner join general.empresa e on e.id=r.idempresa  where pl.id in ( select split_part(listaplanilla,',',1)::int  from general.pagobeneficio where id=$id  )")
                        ->queryAll()[0];
        $datos = Yii::app()->rrhh
                ->createCommand("select * from dame_lista_aguinaldo_navidad_ministerio( $id,'$listacontratos' )")
                ->queryAll();
       
        $nombreArchivo = 'Aguinaldo_Ministerio' . $datoEmpresa['anio'];
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
        $phpColor = array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '#00ccff'
            ),
            'font' => array(
                'bold' => true,)
        );
        $phpFontC = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'font' => array(
                'bold' => true,
            )
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
        $phpFontCuadricula = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
        );
        $phpFontCuadriculan = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'font' => array(
                'bold' => true,
            )
        );
        $activeSheet->getRowDimension('1')->setRowHeight(40);
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);

        $activeSheet->getColumnDimension('A')->setWidth(5);
        $activeSheet->getColumnDimension('B')->setWidth(25);
        $activeSheet->getColumnDimension('C')->setWidth(25);
        $activeSheet->getColumnDimension('D')->setWidth(25);
        $activeSheet->getColumnDimension('E')->setWidth(25);
        $activeSheet->getColumnDimension('F')->setWidth(25);
        $activeSheet->getColumnDimension('G')->setWidth(25);
        $activeSheet->getColumnDimension('H')->setWidth(25);
        $activeSheet->getColumnDimension('I')->setWidth(25);
        $activeSheet->getColumnDimension('J')->setWidth(5);
        $activeSheet->getColumnDimension('K')->setWidth(25);
        $activeSheet->getColumnDimension('L')->setWidth(25);
        $activeSheet->getColumnDimension('M')->setWidth(25);
        $activeSheet->getColumnDimension('N')->setWidth(25);
        $activeSheet->getColumnDimension('O')->setWidth(25);
        $activeSheet->getColumnDimension('P')->setWidth(25);
        $activeSheet->getColumnDimension('Q')->setWidth(25);
        $activeSheet->getColumnDimension('R')->setWidth(25);
        $activeSheet->getColumnDimension('S')->setWidth(25);
        $activeSheet->getColumnDimension('T')->setWidth(25);
        $activeSheet->getColumnDimension('U')->setWidth(25);
        $activeSheet->getColumnDimension('V')->setWidth(25);
        $activeSheet->getColumnDimension('W')->setWidth(25);
        $activeSheet->getColumnDimension('X')->setWidth(25);
        $activeSheet->getColumnDimension('Y')->setWidth(25);
        $activeSheet->getColumnDimension('Z')->setWidth(25);
        $activeSheet->getColumnDimension('AA')->setWidth(25);
        $activeSheet->getColumnDimension('AB')->setWidth(25);
        $activeSheet->getColumnDimension('AC')->setWidth(25);
        $activeSheet->getColumnDimension('AD')->setWidth(25);
        $activeSheet->getColumnDimension('AE')->setWidth(25);
        $activeSheet->getColumnDimension('AF')->setWidth(25);
        $activeSheet->getColumnDimension('AG')->setWidth(25);
        $activeSheet->getColumnDimension('AH')->setWidth(25);


        $activeSheet->getStyle('A1:AH1')->getFont()->setBold(true);
       

        $activeSheet->getStyle("A1:AH1")->getAlignment()->setWrapText(true);
        $activeSheet->setCellValue('A1', 'Nro');
        $activeSheet->setCellValue('B1', 'Tipo de documento de identidad');
        $activeSheet->setCellValue('C1', 'Número de documento de identidad');
        $activeSheet->setCellValue('D1', 'Lugar de expedición');
        $activeSheet->setCellValue('E1', 'Fecha de nacimiento');
        $activeSheet->setCellValue('F1', 'Apellido Paterno');
        $activeSheet->setCellValue('G1', 'Apellido Materno');
        $activeSheet->setCellValue('H1', 'Nombres');
        $activeSheet->setCellValue('I1', 'País de nacionalidad');
        $activeSheet->setCellValue('J1', 'Sexo');        
        $activeSheet->setCellValue('K1', 'Jubilado');
        $activeSheet->setCellValue('L1', '¿Aporta a la AFP?');
        $activeSheet->setCellValue('M1', '¿Persona con discapacidad?');
        $activeSheet->setCellValue('N1', 'Tutor de persona con discapacidad');
        $activeSheet->setCellValue('O1', 'Fecha de ingreso');       
        $activeSheet->setCellValue('P1', 'Fecha de retiro');
        $activeSheet->setCellValue('Q1', 'Motivo retiro');
        $activeSheet->setCellValue('R1', 'Caja de salud');
        $activeSheet->setCellValue('S1', 'AFP a la que aporta');        
        $activeSheet->setCellValue('T1', 'NUA/CUA');
        $activeSheet->setCellValue('U1', 'Sucursal o ubicación adicional');
        $activeSheet->setCellValue('V1', 'Clasificación laboral');
        $activeSheet->setCellValue('W1', 'Cargo');
        $activeSheet->setCellValue('X1', 'Modalidad de contrato');
        $activeSheet->setCellValue('Y1', 'Promedio haber básico');
        $activeSheet->setCellValue('Z1', 'Promedio bono de antigüedad');
        $activeSheet->setCellValue('AA1', 'Promedio bono producción');
        $activeSheet->setCellValue('AB1', 'Promedio subsidio frontera');
        $activeSheet->setCellValue('AC1', 'Promedio trabajo extraordinario y nocturno');
        $activeSheet->setCellValue('AD1', 'Promedio pago dominical trabajado');
        $activeSheet->setCellValue('AE1', 'Promedio otros bonos');
        $activeSheet->setCellValue('AF1', 'Promedio total ganado');
        $activeSheet->setCellValue('AG1', 'Meses trabajados');
        $activeSheet->setCellValue('AH1', 'Total ganado después de duodécimas');
       //cod , empleado ,cargo  ,tg1 ,tg2 ,tg3 ,factor ,dia ,mes ,anio 
        $cant = count($datos);

        for ($i = 0; $i < $cant; $i++) {
            $activeSheet->getStyle("A" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("B" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("C" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("D" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("E" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("F" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("G" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("H" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("I" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("J" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("K" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("L" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("M" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("N" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("O" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("P" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("Q" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("R" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("S" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("T" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("U" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("V" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("W" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("X" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("Y" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("Z" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("AA" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("AB" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("AC" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("AD" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("AE" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("AF" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("AG" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("AH" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->setCellValue('A' . $fila, $i + 1);
            $activeSheet->getStyle('Y' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('Y' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $activeSheet->getStyle('Z' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('Z' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $activeSheet->getStyle('AA' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('AA' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('AB' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('AB' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('AC' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('AC' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('AD' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('AD' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('AE' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('AE' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('AF' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('AF' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('AG' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('AG' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('AH' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('AH' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
          
            $activeSheet->setCellValue('B' . $fila, 'CI');
            $activeSheet->setCellValue('C' . $fila, $datos[$i]['ci']);
            $activeSheet->setCellValue('D' . $fila, $datos[$i]['expedicion']);
            $activeSheet->setCellValue('E' . $fila, $datos[$i]['fechanac']);
            $activeSheet->setCellValue('F' . $fila, $datos[$i]['apellidop']);
            $activeSheet->setCellValue('G' . $fila, $datos[$i]['apellidom']);
            $activeSheet->setCellValue('H' . $fila, $datos[$i]['nombrec']);
            $activeSheet->setCellValue('I' . $fila, $datos[$i]['nacionalidad']);           
            $activeSheet->setCellValue('J' . $fila, $datos[$i]['sexo']);
            $activeSheet->setCellValue('K' . $fila, $datos[$i]['jubilado']);
            $activeSheet->setCellValue('L' . $fila, $datos[$i]['aportaafp']);
            $activeSheet->setCellValue('M' . $fila, $datos[$i]['tienediscapacidad']);
            $activeSheet->setCellValue('N' . $fila, $datos[$i]['tutor']);
            $activeSheet->setCellValue('O' . $fila, $datos[$i]['fechaingreso']);
            $activeSheet->setCellValue('P' . $fila, $datos[$i]['fecharetiro']);
            $activeSheet->setCellValue('Q' . $fila, $datos[$i]['motivo']);
            $activeSheet->setCellValue('R' . $fila, $datos[$i]['caja']);
            $activeSheet->setCellValue('S' . $fila, $datos[$i]['afpaporta']);           
            $activeSheet->setCellValue('T' . $fila, $datos[$i]['nua']);
            $activeSheet->setCellValue('U' . $fila, $datos[$i]['sucursal']);
            $activeSheet->setCellValue('V' . $fila, $datos[$i]['clasificacionlaboral']);
            $activeSheet->setCellValue('W' . $fila, $datos[$i]['cargo']);
            $activeSheet->setCellValue('X' . $fila, $datos[$i]['modalidadcontrato']); 
            $activeSheet->setCellValue('Y' . $fila, $datos[$i]['hbasico']);
            $activeSheet->setCellValue('Z' . $fila, $datos[$i]['antiguedad']);
            $activeSheet->setCellValue('AA' . $fila, $datos[$i]['bonoproduccion']);
            $activeSheet->setCellValue('AB' . $fila, $datos[$i]['frontera']);
            $activeSheet->setCellValue('AC' . $fila, $datos[$i]['extra']);
            $activeSheet->setCellValue('AD' . $fila, $datos[$i]['dominical']);
            $activeSheet->setCellValue('AE' . $fila, $datos[$i]['otrob']);
            $activeSheet->setCellValue('AF' . $fila, $datos[$i]['promedio']);
            $activeSheet->setCellValue('AG' . $fila, $datos[$i]['cantmes']);
            $activeSheet->setCellValue('AH' . $fila, $datos[$i]['totalganadonav']);
            $fila += 1;
        }
        $this->descargarExcel($objPHPExcel, $nombreArchivo);
    }
    /**
     * 
     * @param type $id
     */
   /* function actionBoletaSegundoAguinaldo($id) {

        $model = $this->loadModel(SeguridadModule::dec($id));
        $fila = 11;
        $nombre = 'Ejemplo';

        $datoEmpresa = Yii::app()->rrhh
                        ->createCommand("select e.razonsocial,e.nit::text,e.nrempleadormt,nrempleador,pl.nombrer,pl.cir,pl.anio,to_char(now()::date,'dd-mm-YYYY') as hoy from planilla pl inner join general.representante r on r.cirepresentante=pl.cir inner join general.empresa e on e.id=r.idempresa  where pl.id in ( select split_part(listaplanilla,',',1)::int  from general.pagobeneficio where id=" . $model->id . ")")
                        ->queryAll()[0];
        $datos = Yii::app()->rrhh
                ->createCommand("select * from dame_lista_segundo_aguinaldo(" . $model->id . ")")
                ->queryAll();

        $nombreArchivo = 'S_Aguinaldo_' . $datoEmpresa['anio'];

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
        $phpColor = array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '#00ccff'
            ),
            'font' => array(
                'bold' => true,)
        );
        $phpFontC = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'font' => array(
                'bold' => true,
            )
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
        $phpFontCuadricula = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
        );
        $phpFontCuadriculan = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'font' => array(
                'bold' => true,
            )
        );
        $activeSheet->getRowDimension('10')->setRowHeight(40);
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);

        $activeSheet->getColumnDimension('A')->setWidth(5);
        $activeSheet->getColumnDimension('B')->setWidth(12);
        $activeSheet->getColumnDimension('C')->setWidth(30);
        $activeSheet->getColumnDimension('D')->setWidth(14);
        $activeSheet->getColumnDimension('E')->setWidth(22);
        $activeSheet->getColumnDimension('F')->setWidth(30);
        $activeSheet->getColumnDimension('G')->setWidth(13);
        $activeSheet->getColumnDimension('H')->setWidth(13);
        $activeSheet->getColumnDimension('I')->setWidth(13);
        $activeSheet->getColumnDimension('J')->setWidth(12);
        $activeSheet->getColumnDimension('K')->setWidth(12);




        /////////
        $activeSheet->mergeCells('A1:E1');
        $activeSheet->mergeCells('A2:E2');
        $activeSheet->mergeCells('A3:E3');
        $activeSheet->mergeCells('A4:E4');
        $activeSheet->mergeCells('F1:U1');
        $activeSheet->mergeCells('F2:U2');
        $activeSheet->mergeCells('F3:U3');
        $activeSheet->mergeCells('F4:U4');
        $activeSheet->mergeCells('A5:X5');
        $activeSheet->mergeCells('A6:X6');
        $activeSheet->mergeCells('A7:X7');
        $activeSheet->mergeCells('A8:X8');
        $activeSheet->mergeCells('A9:X9');

        $activeSheet->getStyle('A1')->getFont()->setBold(true);
        $activeSheet->getStyle("A2")->getFont()->setBold(true);
        $activeSheet->getStyle('A3')->getFont()->setBold(true);
        $activeSheet->getStyle("A4")->getFont()->setBold(true);

        $activeSheet->setCellValue('A1', 'NOMBRE O RAZÓN SOCIAL');
        $activeSheet->setCellValue('F1', $datoEmpresa['razonsocial']);

        $activeSheet->setCellValue('A2', 'Nº EMPLEADOR MINISTERIO DE TRABAJO');
        $activeSheet->setCellValue('F2', $datoEmpresa['nrempleadormt']);

        $activeSheet->setCellValue('A3', 'Nº DE NIT');
        $nit = $datoEmpresa['nit'] . ' ';
        $activeSheet->setCellValue('F3', $nit);
        $activeSheet->setCellValue('A4', 'Nº DE EMPLEADOR (Seguro Salud)');
        $activeSheet->setCellValue('F4', $datoEmpresa['nrempleador']);


        $activeSheet->setCellValue('A6', 'PLANILLA DE PAGO DE AGUINALDO POR MES');
        $activeSheet->setCellValue('A7', '(En Bolivianos)');
        $activeSheet->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle("A6")->getFont()->setSize(16);
        $activeSheet->getStyle("A6")->applyFromArray($phpFontP);
        $activeSheet->getStyle("A12")->applyFromArray($phpFontP);
        $activeSheet->getStyle("A10:K10")->applyFromArray($phpFontC);

        $activeSheet->setCellValue('A12', '(En Bolivianos)');
        $activeSheet->getStyle("A10:K10")->getAlignment()->setWrapText(true);

        $activeSheet->setCellValue('A10', 'Nº');
        $activeSheet->setCellValue('B10', 'CARNET DE IDENTIDAD');
        $activeSheet->setCellValue('C10', 'NOMBRE COMPLETO');
        $activeSheet->setCellValue('D10', 'SEXO');
        $activeSheet->setCellValue('E10', 'NACIONALIDAD');
        $activeSheet->setCellValue('F10', 'OCUPACIÓN QUE DESEMPEÑA');
        $activeSheet->setCellValue('G10', 'FECHA DE INGRESO');
        $activeSheet->setCellValue('H10', 'FECHA RETIRO');
        $activeSheet->setCellValue('I10', 'MESES TRABAJADOS');
        $activeSheet->setCellValue('J10', 'Promedio total ganado
      (De la Planilla de Aguinaldo)');
        $activeSheet->setCellValue('K10', 'LIQUIDO PAGABLE');



        //cod , empleado ,cargo  ,tg1 ,tg2 ,tg3 ,factor ,dia ,mes ,anio 
        $cant = count($datos);

        for ($i = 0; $i < $cant; $i++) {
            $activeSheet->getStyle("A" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("B" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("C" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("D" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("E" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("F" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("G" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("H" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("I" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("J" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("K" . $fila)->applyFromArray($phpFontCuadricula);

            $activeSheet->setCellValue('A' . $fila, $i + 1);
            $activeSheet->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('I' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('J' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('K' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->setCellValue('B' . $fila, $datos[$i]['ci']);
            $activeSheet->setCellValue('C' . $fila, $datos[$i]['nombrec']);
            $activeSheet->setCellValue('D' . $fila, $datos[$i]['sexo']);
            $activeSheet->setCellValue('E' . $fila, $datos[$i]['nacionalidad']);
            $activeSheet->setCellValue('F' . $fila, $datos[$i]['cargo']);
            $activeSheet->setCellValue('G' . $fila, $datos[$i]['fechaingreso']);
            $activeSheet->setCellValue('H' . $fila, $datos[$i]['fecharetiro']);
            $activeSheet->setCellValue('I' . $fila, $datos[$i]['meses']);
            $activeSheet->setCellValue('J' . $fila, $datos[$i]['totalga']);
            $activeSheet->setCellValue('K' . $fila, $datos[$i]['liquido']);
            $fila += 1;
        }
        $activeSheet->mergeCells('A' . $fila . ':L' . $fila);
        $activeSheet->setCellValue('A' . $fila, 'TOTALES');
        $activeSheet->getStyle("A" . $fila . ':K' . $fila)->applyFromArray($phpFontCuadriculan);
        $activeSheet->getStyle('J' . $fila . ':K' . $fila)->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('J' . $fila . ':K' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('A' . $fila . ':K' . $fila)->getFont()->setBold(true);

        $activeSheet->setCellValue('J' . $fila, '=SUM(J11:J' . ($fila - 1) . ')');
        $activeSheet->setCellValue('K' . $fila, '=SUM(K11:K' . ($fila - 1) . ')');

        $fila += 5;
        $activeSheet->mergeCells('C' . $fila . ':G' . $fila);
        $activeSheet->mergeCells('J' . $fila . ':L' . $fila);
        $activeSheet->mergeCells('O' . $fila . ':Q' . $fila);
        $activeSheet->mergeCells('T' . $fila . ':U' . $fila);
        $activeSheet->getStyle('C' . $fila)->applyFromArray($phpFontP);
        $activeSheet->getStyle('J' . $fila)->applyFromArray($phpFontP);
        $activeSheet->getStyle('O' . $fila)->applyFromArray($phpFontP);
        $activeSheet->getStyle('S' . $fila)->applyFromArray($phpFontP);
        $activeSheet->setCellValue('C' . $fila, 'NOMBRE DEL EMPLEADOR O REPRESENTANTE LEGAL');
        $activeSheet->setCellValue('J' . $fila, 'Nº DE DOCUMENTO DE IDENTIDAD');
        $activeSheet->setCellValue('O' . $fila, 'FIRMA');
        $activeSheet->setCellValue('S' . $fila, 'FECHA: ');
        $activeSheet->setCellValue('T' . $fila, $datoEmpresa['hoy']);


        $this->descargarExcel($objPHPExcel, $nombreArchivo);
    }
*/
    /**
     * 
     * @param integer $id , id relacionado con la prima anual
     */
   
    /**
     * 
     * @param integer $id, id relacionado con el aguinaldo de navidad
     * retorna reporte de boletas de aguinaldo de navidad
     */
    public function actionImprimirBoletaAguinaldoNavidad($id)
   {
          $id = SeguridadModule::dec($id);     
          $re = new JasperReport('/reports/RRHH/ReporteBoletaAguinaldoNavidad', JasperReport::FORMAT_PDF, array(
               'p_idpagobeneficio' => $id
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
     * @param integer $id, id relacionado con el segundo aguinaldo 
     * retorna reporte de boletas de segundo aguinaldo
     */
    public function actionImprimirBoletaSegundoAguinaldo($id)
{
       $id = SeguridadModule::dec($id);    
       $re = new JasperReport('/reports/RRHH/ReporteBoletaSegundoAguinaldo', JasperReport::FORMAT_PDF, array(
            'p_idpagobeneficio' => $id
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
     * @param integer $id, id relacionado con la prima anual
     * retorna reporte con las boletas de la prima anual
     */
    public function actionImprimirBoletaPrimaAnual($id) {
       
        $id = SeguridadModule::dec($id);

        $re = new JasperReport('/reports/RRHH/ReporteBoletaPrimaAnual', JasperReport::FORMAT_PDF, array(
            'p_idpagobeneficio' => $id
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
     * @param integer $id, id de la prima anual a consolidar
     * @return interfa para la consolidacion de la prima anual
     */
    public function actionConsolidarprimaanual($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
        $model = $this->loadModel(SeguridadModule::dec($id));
        //consolidarPrimaAnual
        if (isset($_POST['Pagobeneficio'])) {
          
            $usuario = Yii::app()->user->getName();
            Yii::app()->contabilidad
                    ->createCommand("select registrar_asiento_prima_anual(" . $model->id . ",'".$_POST['Pagobeneficio']['fechapago']."','$usuario')")
                    ->execute();
            
            echo System::dataReturn('Prima Anual Consolidada');
            return;
        }
        $this->renderPartial('consolidarPrimaAnual', array(
            'model' => $model,
                ), false, true);
    }
    /**
     * 
     * @return string , con  los finiquitos sin consolidar si esque los hubiera
     */
    public function actionDameListaPlanillaFiniquito() {
        $fecharetiro = $_POST['fecharetiro'];
        $idempleado=$_POST['idempleado'];
        $meses = Yii::app()->rrhh->createCommand(" select string_agg( '<li>'|| t.nombre,'</li>') as mes from (select nombre from planilla pl inner join cuerpo c on c.idplanilla=pl.id where c.eliminado=false and pl.eliminado=false  and c.idempleado=$idempleado and pl.estado IN(3,4) and pl.fechahasta<='".$fecharetiro."' order by pl.id desc limit 3) as t")
                        ->queryScalar();
        
        $estado=Yii::app()->rrhh->createCommand("select public.estado_generar_finiquito($idempleado,'$fecharetiro')  ")
                        ->queryScalar();
        if($estado==true){
            $meses = '<h3>Desea Continuar...?</h3><br><h5>Lista Planillas para el Calculo del Finiquito</h5><ul>' . $meses . '</li></ul>';
       
        }else{
            $meses = '<h3>Desea Continuar...?</h3><br><h5>El Retiro no generara Finiquito...</h5>';
        }
        echo $meses;
        
        
        return;
    }
    /**
     * 
     * @param integer $id, id relaciondado con el aguinaldo de naivdad
     * @return interfaz para la generacion del reporte de aguinalod de navidad
     */
     public function actionPlanillaAguinaldo($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = $this->loadModel(SeguridadModule::dec($id));
        $ltipocontratos = Tipocontrato::model()->findAll();
        if (isset($_POST['Pagobeneficio'])) {

         

            if ($model->save()) {
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }

        $this->renderPartial('planillaaguinaldo', array(
            'model' => $model,
            'listatipocontrato'=>$ltipocontratos 
            ), false, true);
    }
  /**
   * @param integer $_GET['Pagobeneficio']['opciones'], posibles valores 1=Planilla Aguinaldo Impresion o 2= Planilla Aguinaldo Ministerio
   * @param integer $_GET['Pagobeneficio']['id'], id relacionado con el aguinalo de navidad
   * @param integer[] $_GET['tipocontratos'], lista de id de tipos de contratos
   * @return reporte xls con la informacion del aguinaldo  de los empleados 
   */  
        public function actionDescargarExcelPlanilla() {
        $opcion=$_GET['Pagobeneficio']['opciones'];
        $id=$_GET['Pagobeneficio']['id'];
        $tipocontratos= $_GET['tipocontratos'];
        $model = $this->loadModel($id);        
        $tipocontratosseleccionados ='';
           for ($i = 0; $i < count($tipocontratos); $i++) {
                        $tipocontratosseleccionados = $tipocontratosseleccionados . $tipocontratos[$i] . ',';
                    }
                    $tipocontratosseleccionados = substr($tipocontratosseleccionados, 0, -1);
            
            if ($model->idtipopagobeneficio==3){  
                //inicio aguinaldo de navidad
                if($opcion==1){
                    return $this->PlanillaAguinaldoNavidad($id, $tipocontratosseleccionados);

                }else{
                     return $this->PlanillaAguinaldoNavidadMinisterio($id, $tipocontratosseleccionados);
                }
                // fin aguinaldo de navidad
                }
            else{
                //inicio segundo aguinaldo
                 if($opcion==1){
                    return $this->PlanillaSegundoAguinaldo($id, $tipocontratosseleccionados);

                }else{
                     return $this->PlanillaSegundoAguinaldoMinisterio($id, $tipocontratosseleccionados);
                }
                // fin segundo aguinaldo
                
            }
        
    }
    /**
     * 
     * @param integer $id,id relacionado con el segundo aguinaldo 
     * @param integer[] $listacontratos, lista de id de los tipos de contratos 
     * retorna reporte xls con la informacion del segunado aguinaldo de los empleados para impresion
     */
    function PlanillaSegundoAguinaldo($id,$listacontratos) {        
        $fila = 8;
        $model = $this->loadModel($id);
        $porcentaje=$model->diasvacacion;
        $datoEmpresa = Yii::app()->rrhh
                        ->createCommand("select e.razonsocial,e.nit,e.nrempleadormt,nrempleador,pl.nombrer,pl.cir,pl.anio,to_char(now()::date,'dd-mm-YYYY') as hoy from planilla pl inner join general.representante r on r.cirepresentante=pl.cir inner join general.empresa e on e.id=r.idempresa  where pl.id in ( select split_part(listaplanilla,',',1)::int  from general.pagobeneficio where id=" . $id . ")")
                        ->queryAll()[0];
        $datos = Yii::app()->rrhh
                ->createCommand("select * from dame_lista_segundo_aguinaldo(" . $id . ",'$listacontratos')")
                ->queryAll();

        $nombreArchivo = 'Segundo_A_' . $datoEmpresa['anio'];

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->removeSheetByIndex(0);
        $objPHPExcel->createSheet(0);
        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);
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
        $phpColor = array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '#00ccff'
            ),
            'font' => array(
                'bold' => true,)
        );
        $phpFontC = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'font' => array(
                'bold' => true,
            )
        );
        $phpFontP = array(
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
            ),);
           $phpFontPie = array(
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
        $phpFontCuadricula = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
        );
        $phpFontCuadriculan = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'font' => array(
                'bold' => true,
            )
        );
        $activeSheet->getRowDimension('7')->setRowHeight(50);
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);
        $img = realpath(__DIR__ . '/../../../../images'); // Provide path to your logo file

        $imgot = $img . '/logoEmpresa.png';
        $objDrawingt = new PHPExcel_Worksheet_Drawing();
        $objDrawingt->setName('imgNotice');
        $objDrawingt->setDescription('Noticia');
        $objDrawingt->setPath($imgot);
        $objDrawingt->setOffsetX(5);    // setOffsetX works properly
        $objDrawingt->setOffsetY(0);  //setOffsetY has no effect
        $objDrawingt->setCoordinates('N1');
        $objDrawingt->setWidthAndHeight(140, 70);
        $objDrawingt->setResizeProportional(true);
        $objDrawingt->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
        $activeSheet->getColumnDimension('A')->setWidth(5);
        $activeSheet->getColumnDimension('B')->setWidth(12);
        $activeSheet->getColumnDimension('C')->setWidth(40);
        $activeSheet->getColumnDimension('D')->setWidth(11);
        $activeSheet->getColumnDimension('E')->setWidth(11);
        $activeSheet->getColumnDimension('F')->setWidth(5);
        $activeSheet->getColumnDimension('G')->setWidth(30);
        $activeSheet->getColumnDimension('H')->setWidth(10);
        $activeSheet->getColumnDimension('I')->setWidth(10);
        $activeSheet->getColumnDimension('J')->setWidth(10);
        $activeSheet->getColumnDimension('K')->setWidth(10);
        $activeSheet->getColumnDimension('L')->setWidth(10);
        $activeSheet->getColumnDimension('M')->setWidth(10);
        $activeSheet->getColumnDimension('N')->setWidth(10);
        $activeSheet->getColumnDimension('O')->setWidth(10);
        $activeSheet->getColumnDimension('P')->setWidth(10);
        $activeSheet->getColumnDimension('Q')->setWidth(10);
        $activeSheet->getColumnDimension('R')->setWidth(10);
        $activeSheet
                ->getPageMargins()->setTop(0.4);
        $activeSheet
                ->getPageMargins()->setRight(0.2);
        $activeSheet
                ->getPageMargins()->setLeft(0.2);
        $activeSheet
                ->getPageMargins()->setBottom(0.8);

        $activeSheet->mergeCells('A1:E1');
        $activeSheet->mergeCells('A2:E2');
        $activeSheet->mergeCells('D1:Q1');
        $activeSheet->mergeCells('D2:Q2');
        $activeSheet->mergeCells('D3:Q3');
        $activeSheet->mergeCells('D4:Q4');
        $activeSheet->mergeCells('B5:Q5');
        $activeSheet->mergeCells('A4:Q4');
        $activeSheet->mergeCells('A5:Q5');
       
        $activeSheet->getStyle('A1')->getFont()->setBold(true);
        $activeSheet->getStyle("A2")->getFont()->setBold(true);
        $activeSheet->getStyle('B3')->getFont()->setBold(true);
        $activeSheet->getStyle("B4")->getFont()->setBold(true);
        $activeSheet->setCellValue('A1', 'NOMBRE O RAZÓN SOCIAL : '.$datoEmpresa['razonsocial'] );
        $activeSheet->setCellValue('A2', 'Nº EMPLEADOR MINISTERIO DE TRABAJO : '.$datoEmpresa['nrempleadormt']);        
        $activeSheet->setCellValue('A4', 'PLANILLA DE PAGO DE SEGUNDO AGUINALDO ');
        $activeSheet->setCellValue('A5', 'Correspondientes al mes de : Diciembre gestión '.$datoEmpresa['anio']);
        $activeSheet->getStyle("A4")->getFont()->setSize(14);
        $activeSheet->getStyle("A5")->getFont()->setSize(10);
        $activeSheet->getStyle('A4' )->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('A5' )->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $activeSheet->getStyle("A4")->applyFromArray($phpFontP);
        if($porcentaje>0){
             $activeSheet->getStyle("A7:U7")->applyFromArray($phpFontC);
        $activeSheet->getStyle("A7:U7")->getAlignment()->setWrapText(true);
        }else{
        $activeSheet->getStyle("A7:S7")->applyFromArray($phpFontC);
        $activeSheet->getStyle("A7:S7")->getAlignment()->setWrapText(true);}
        $activeSheet->setCellValue('A12', '(En Bolivianos)');
       
        $activeSheet->setCellValue('A7', 'Nº');
        $activeSheet->setCellValue('B7', 'Carnet de Identidad');
        $activeSheet->setCellValue('C7', 'Nombre Completo');      
        $activeSheet->setCellValue('D7', 'Nacionalidad');
        $activeSheet->setCellValue('E7', 'Fecha de Naciemiento');
        $activeSheet->setCellValue('F7', 'Sexo');
        $activeSheet->setCellValue('G7', 'Ocupación que Desempeña');
        $activeSheet->setCellValue('H7', 'Fecha de Ingreso');
        $activeSheet->setCellValue('I7', 'Fecha de Retiro');
        $activeSheet->setCellValue('J7', 'Promedio del haber básico');
        $activeSheet->setCellValue('K7', 'Promedio del bono de antigüedad');
        $activeSheet->setCellValue('L7', 'Promedio del bono de producción');
        $activeSheet->setCellValue('M7', 'Promedio del subsidio de frontera');
        $activeSheet->setCellValue('N7', 'Promedio trabajo extraordinario y nocturno');
        $activeSheet->setCellValue('O7', 'Promedio pago dominical y domingo trabajado');
        $activeSheet->setCellValue('P7', 'Promedio otros bonos');
        $activeSheet->setCellValue('Q7', 'Promedio total ganado');
        $activeSheet->setCellValue('R7', 'Meses trabajados');
        $activeSheet->setCellValue('S7', 'Total ganado después de duodécimas');
      //  $activeSheet->setCellValue('S7', 'FIRMA DEL EMPLEADO');
if ($porcentaje>0){
     $activeSheet->setCellValue('T7', $porcentaje.'%');
        $activeSheet->setCellValue('U7', 'Liquido pagable');
}        
        $cant = count($datos);

        for ($i = 0; $i < $cant; $i++) {
            $activeSheet->getRowDimension($fila)->setRowHeight(22);
            $activeSheet->getStyle("C".$fila)->getAlignment()->setWrapText(true);
            $activeSheet->getStyle("G".$fila)->getAlignment()->setWrapText(true);
            $activeSheet->getStyle("A" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("B" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("C" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("D" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("E" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("F" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("G" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("H" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("I" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("J" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("K" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("L" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("M" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("N" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("O" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("P" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("Q" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("R" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("S" . $fila)->applyFromArray($phpFontCuadricula);
            if($porcentaje>0){
                 $activeSheet->getStyle("T" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("U" . $fila)->applyFromArray($phpFontCuadricula);
           
            }
            
            $activeSheet->setCellValue('A' . $fila, $i + 1);
            $activeSheet->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('I' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('J' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $activeSheet->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('K' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('L' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('M' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('N' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('O' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('P' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('P' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('Q' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('Q' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('R' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('R' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('S' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('S' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('T' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('T' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('U' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('U' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
          
            $activeSheet->setCellValue('B' . $fila, $datos[$i]['ci']);
            $activeSheet->setCellValue('C' . $fila, $datos[$i]['nombrec']);
            $activeSheet->setCellValue('D' . $fila, $datos[$i]['nacionalidad']);
            $activeSheet->setCellValue('E' . $fila, $datos[$i]['fechanac']);
            $activeSheet->setCellValue('F' . $fila, $datos[$i]['sexo']);
            $activeSheet->setCellValue('G' . $fila, $datos[$i]['cargo']);
            $activeSheet->setCellValue('H' . $fila, $datos[$i]['fechaingreso']);
            $activeSheet->setCellValue('I' . $fila, $datos[$i]['fecharetiro']);
            $activeSheet->setCellValue('J' . $fila, $datos[$i]['hbasico']);
            $activeSheet->setCellValue('K' . $fila, $datos[$i]['antiguedad']);
            $activeSheet->setCellValue('L' . $fila, $datos[$i]['bonoproduccion']);
            $activeSheet->setCellValue('M' . $fila, $datos[$i]['frontera']);
            $activeSheet->setCellValue('N' . $fila, $datos[$i]['extra']);
            $activeSheet->setCellValue('O' . $fila, $datos[$i]['dominical']);
            $activeSheet->setCellValue('P' . $fila, $datos[$i]['otrob']);
            $activeSheet->setCellValue('Q' . $fila, $datos[$i]['promedio']);
            $activeSheet->setCellValue('R' . $fila, $datos[$i]['meses']);
            $activeSheet->setCellValue('S' . $fila, $datos[$i]['liquido']);
            if($porcentaje>0){
              $activeSheet->setCellValue('T' . $fila, $datos[$i]['porcentaje']);
              $activeSheet->setCellValue('U' . $fila, $datos[$i]['liquidopagable']);  
            }


            $fila += 1;
        }
         $activeSheet->getStyle("G11:G".$fila)->getAlignment()->setWrapText(true);
        $activeSheet->mergeCells('A' . $fila . ':I' . $fila);
        $activeSheet->setCellValue('A' . $fila, 'TOTALES');
        $activeSheet->getStyle("A" . $fila . ':I' . $fila)->applyFromArray($phpFontCuadriculan);
        $activeSheet->getStyle('A' . $fila )->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('A' . $fila )->getFont()->setBold(true);
        if($porcentaje>0){
        $activeSheet->getStyle("J" . $fila . ':U' . $fila)->applyFromArray($phpFontCuadriculan);
        $activeSheet->getStyle('J' . $fila . ':U' . $fila)->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('J' . $fila . ':U' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('J' . $fila . ':U' . $fila)->getFont()->setBold(true);
        $activeSheet->setCellValue('T' . $fila, '=SUM(T8:T' . ($fila - 1) . ')');
        $activeSheet->setCellValue('U' . $fila, '=SUM(U8:U' . ($fila - 1) . ')');
       
        
        }
        else{
            $activeSheet->getStyle("J" . $fila . ':S' . $fila)->applyFromArray($phpFontCuadriculan);
            $activeSheet->getStyle('J' . $fila . ':S' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('J' . $fila . ':S' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('J' . $fila . ':S' . $fila)->getFont()->setBold(true);
        
        }
        $activeSheet->setCellValue('I' . $fila, '=SUM(I8:I' . ($fila - 1) . ')');
        $activeSheet->setCellValue('J' . $fila, '=SUM(J8:J' . ($fila - 1) . ')');
        $activeSheet->setCellValue('K' . $fila, '=SUM(K8:K' . ($fila - 1) . ')');
        $activeSheet->setCellValue('L' . $fila, '=SUM(L8:L' . ($fila - 1) . ')');
        $activeSheet->setCellValue('M' . $fila, '=SUM(M8:M' . ($fila - 1) . ')');
        $activeSheet->setCellValue('N' . $fila, '=SUM(N8:N' . ($fila - 1) . ')');
        $activeSheet->setCellValue('O' . $fila, '=SUM(O8:O' . ($fila - 1) . ')');
        $activeSheet->setCellValue('P' . $fila, '=SUM(P8:P' . ($fila - 1) . ')');
        $activeSheet->setCellValue('Q' . $fila, '=SUM(Q8:Q' . ($fila - 1) . ')');
        $activeSheet->setCellValue('R' . $fila, '=SUM(R8:R' . ($fila - 1) . ')');
        $activeSheet->setCellValue('S' . $fila, '=SUM(S8:S' . ($fila - 1) . ')');
        
        $fila += 5;
        $activeSheet->mergeCells('C' . $fila . ':E' . $fila);
        $activeSheet->mergeCells('G' . $fila . ':H' . $fila);
        $activeSheet->mergeCells('J' . $fila . ':K' . $fila);
        $activeSheet->getStyle('C' . $fila)->applyFromArray($phpFontPie);
        $activeSheet->getStyle('G' . $fila)->applyFromArray($phpFontPie);
        $activeSheet->getStyle('J' . $fila)->applyFromArray($phpFontPie);
        $activeSheet->getStyle('M' . $fila )->getFont()->setBold(true);
        $activeSheet->setCellValue('C' . $fila, 'NOMBRE DEL EMPLEADOR O REPRESENTANTE LEGAL');
        $activeSheet->setCellValue('G' . $fila, 'Nº DE DOCUMENTO DE IDENTIDAD');
        $activeSheet->setCellValue('J' . $fila, 'FIRMA');
        $activeSheet->setCellValue('M' . $fila, 'FECHA: ');
        $activeSheet->setCellValue('N' . $fila, $datoEmpresa['hoy']);


        $this->descargarExcel($objPHPExcel, $nombreArchivo);
    }
    /**
     * 
     * @param integer $id, id relacionado con el segundo aguinaldo
     * @param integer[] $listacontratos, lista de id de los tipos de contratos de los empleados
     * retorna reporte xls con la informacion del segundo aguinaldo de los empleados para la presentacion al ministerio de trabajo
     */
    function PlanillaSegundoAguinaldoMinisterio($id,$listacontratos) {

       
        $fila = 2;
        $nombre = 'Ejemplo';
        $datoEmpresa = Yii::app()->rrhh
                        ->createCommand("select e.razonsocial,e.nit,e.nrempleadormt,nrempleador,pl.nombrer,pl.cir,pl.anio,to_char(now()::date,'dd-mm-YYYY') as hoy from planilla pl inner join general.representante r on r.cirepresentante=pl.cir inner join general.empresa e on e.id=r.idempresa  where pl.id in ( select split_part(listaplanilla,',',1)::int  from general.pagobeneficio where id=$id  )")
                        ->queryAll()[0];
        $datos = Yii::app()->rrhh
                ->createCommand("select * from dame_lista_segundo_aguinaldo_ministerio( $id,'$listacontratos' )")
                ->queryAll();
       
        $nombreArchivo = 'SAguinaldo_Ministerio' . $datoEmpresa['anio'];
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
        $phpColor = array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '#00ccff'
            ),
            'font' => array(
                'bold' => true,)
        );
        $phpFontC = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'font' => array(
                'bold' => true,
            )
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
        $phpFontCuadricula = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
        );
        $phpFontCuadriculan = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'font' => array(
                'bold' => true,
            )
        );
        $activeSheet->getRowDimension('1')->setRowHeight(40);
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);

        $activeSheet->getColumnDimension('A')->setWidth(5);
        $activeSheet->getColumnDimension('B')->setWidth(25);
        $activeSheet->getColumnDimension('C')->setWidth(25);
        $activeSheet->getColumnDimension('D')->setWidth(25);
        $activeSheet->getColumnDimension('E')->setWidth(25);
        $activeSheet->getColumnDimension('F')->setWidth(25);
        $activeSheet->getColumnDimension('G')->setWidth(25);
        $activeSheet->getColumnDimension('H')->setWidth(25);
        $activeSheet->getColumnDimension('I')->setWidth(25);
        $activeSheet->getColumnDimension('J')->setWidth(5);
        $activeSheet->getColumnDimension('K')->setWidth(25);
        $activeSheet->getColumnDimension('L')->setWidth(25);
        $activeSheet->getColumnDimension('M')->setWidth(25);
        $activeSheet->getColumnDimension('N')->setWidth(25);
        $activeSheet->getColumnDimension('O')->setWidth(25);
        $activeSheet->getColumnDimension('P')->setWidth(25);
        $activeSheet->getColumnDimension('Q')->setWidth(25);
        $activeSheet->getColumnDimension('R')->setWidth(25);
        $activeSheet->getColumnDimension('S')->setWidth(25);
        $activeSheet->getColumnDimension('T')->setWidth(25);
        $activeSheet->getColumnDimension('U')->setWidth(25);
        $activeSheet->getColumnDimension('V')->setWidth(25);
        $activeSheet->getColumnDimension('W')->setWidth(25);
        $activeSheet->getColumnDimension('X')->setWidth(25);
        $activeSheet->getColumnDimension('Y')->setWidth(25);
        $activeSheet->getColumnDimension('Z')->setWidth(25);
        $activeSheet->getColumnDimension('AA')->setWidth(25);
        $activeSheet->getColumnDimension('AB')->setWidth(25);
        $activeSheet->getColumnDimension('AC')->setWidth(25);
        $activeSheet->getColumnDimension('AD')->setWidth(25);
        $activeSheet->getColumnDimension('AE')->setWidth(25);
        $activeSheet->getColumnDimension('AF')->setWidth(25);
        $activeSheet->getColumnDimension('AG')->setWidth(25);
        $activeSheet->getColumnDimension('AH')->setWidth(25);
        $activeSheet->getStyle('A1:AH1')->getFont()->setBold(true);
        $activeSheet->getStyle("A1:AH1")->getAlignment()->setWrapText(true);
        $activeSheet->setCellValue('A1', 'Nº');
        $activeSheet->setCellValue('B1', 'Tipo de documento de identidad');
        $activeSheet->setCellValue('C1', 'Número de documento de identidad');
        $activeSheet->setCellValue('D1', 'Lugar de expedición');
        $activeSheet->setCellValue('E1', 'Fecha de nacimiento');
        $activeSheet->setCellValue('F1', 'Apellido Paterno');
        $activeSheet->setCellValue('G1', 'Apellido Materno');
        $activeSheet->setCellValue('H1', 'Nombres');
        $activeSheet->setCellValue('I1', 'País de nacionalidad');
        $activeSheet->setCellValue('J1', 'Sexo');        
        $activeSheet->setCellValue('K1', 'Jubilado');
        $activeSheet->setCellValue('L1', '¿Aporta a la AFP?');
        $activeSheet->setCellValue('M1', '¿Persona con discapacidad?');
        $activeSheet->setCellValue('N1', 'Tutor de persona con discapacidad');
        $activeSheet->setCellValue('O1', 'Fecha de ingreso');       
        $activeSheet->setCellValue('P1', 'Fecha de retiro');
        $activeSheet->setCellValue('Q1', 'Motivo retiro');
        $activeSheet->setCellValue('R1', 'Caja de salud');
        $activeSheet->setCellValue('S1', 'AFP a la que aporta');        
        $activeSheet->setCellValue('T1', 'NUA/CUA');
        $activeSheet->setCellValue('U1', 'Sucursal o ubicación adicional');
        $activeSheet->setCellValue('V1', 'Clasificación laboral');
        $activeSheet->setCellValue('W1', 'Cargo');
        $activeSheet->setCellValue('X1', 'Modalidad de contrato');
        $activeSheet->setCellValue('Y1', 'Promedio del haber básico');
        $activeSheet->setCellValue('Z1', 'Promedio del bono de antigüedad');
        $activeSheet->setCellValue('AA1', 'Promedio del bono de producción');
        $activeSheet->setCellValue('AB1', 'Promedio del subsidio de frontera');
        $activeSheet->setCellValue('AC1', 'Promedio trabajo extraordinario y nocturno');
        $activeSheet->setCellValue('AD1', 'Promedio pago dominical y domingo trabajado');
        $activeSheet->setCellValue('AE1', 'Promedio otros bonos');
        $activeSheet->setCellValue('AF1', 'Promedio total ganado');
        $activeSheet->setCellValue('AG1', 'Meses trabajados');
        $activeSheet->setCellValue('AH1', 'Total ganado después de duodécimas');
       //cod , empleado ,cargo  ,tg1 ,tg2 ,tg3 ,factor ,dia ,mes ,anio 
        $cant = count($datos);

        for ($i = 0; $i < $cant; $i++) {
            $activeSheet->getStyle("A" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("B" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("C" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("D" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("E" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("F" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("G" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("H" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("I" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("J" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("K" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("L" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("M" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("N" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("O" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("P" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("Q" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("R" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("S" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("T" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("U" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("V" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("W" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("X" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("Y" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("Z" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("AA" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("AB" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("AC" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("AD" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("AE" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("AF" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("AG" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("AH" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->setCellValue('A' . $fila, $i + 1);
            $activeSheet->getStyle('Y' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('Y' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $activeSheet->getStyle('Z' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('Z' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $activeSheet->getStyle('AA' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('AA' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('AB' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('AB' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('AC' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('AC' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('AD' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('AD' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('AE' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('AE' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('AF' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('AF' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('AG' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('AG' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('AH' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('AH' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
          
            $activeSheet->setCellValue('B' . $fila, 'CI');
            $activeSheet->setCellValue('C' . $fila, $datos[$i]['ci']);
            $activeSheet->setCellValue('D' . $fila, $datos[$i]['expedicion']);
            $activeSheet->setCellValue('E' . $fila, $datos[$i]['fechanac']);
            $activeSheet->setCellValue('F' . $fila, $datos[$i]['apellidop']);
            $activeSheet->setCellValue('G' . $fila, $datos[$i]['apellidom']);
            $activeSheet->setCellValue('H' . $fila, $datos[$i]['nombrec']);
            $activeSheet->setCellValue('I' . $fila, $datos[$i]['nacionalidad']);           
            $activeSheet->setCellValue('J' . $fila, $datos[$i]['sexo']);
            $activeSheet->setCellValue('K' . $fila, $datos[$i]['jubilado']);
            $activeSheet->setCellValue('L' . $fila, $datos[$i]['aportaafp']);
            $activeSheet->setCellValue('M' . $fila, $datos[$i]['tienediscapacidad']);
            $activeSheet->setCellValue('N' . $fila, $datos[$i]['tutor']);
            $activeSheet->setCellValue('O' . $fila, $datos[$i]['fechaingreso']);
            $activeSheet->setCellValue('P' . $fila, $datos[$i]['fecharetiro']);
            $activeSheet->setCellValue('Q' . $fila, $datos[$i]['motivo']);
            $activeSheet->setCellValue('R' . $fila, $datos[$i]['caja']);
            $activeSheet->setCellValue('S' . $fila, $datos[$i]['afpaporta']);           
            $activeSheet->setCellValue('T' . $fila, $datos[$i]['nua']);
            $activeSheet->setCellValue('U' . $fila, $datos[$i]['sucursal']);
            $activeSheet->setCellValue('V' . $fila, $datos[$i]['clasificacionlaboral']);
            $activeSheet->setCellValue('W' . $fila, $datos[$i]['cargo']);
            $activeSheet->setCellValue('X' . $fila, $datos[$i]['modalidadcontrato']); 
            $activeSheet->setCellValue('Y' . $fila, $datos[$i]['hbasico']);
            $activeSheet->setCellValue('Z' . $fila, $datos[$i]['antiguedad']);
            $activeSheet->setCellValue('AA' . $fila, $datos[$i]['bonoproduccion']);
            $activeSheet->setCellValue('AB' . $fila, $datos[$i]['frontera']);
            $activeSheet->setCellValue('AC' . $fila, $datos[$i]['extra']);
            $activeSheet->setCellValue('AD' . $fila, $datos[$i]['dominical']);
            $activeSheet->setCellValue('AE' . $fila, $datos[$i]['otrob']);
            $activeSheet->setCellValue('AF' . $fila, $datos[$i]['promedio']);
            $activeSheet->setCellValue('AG' . $fila, $datos[$i]['cantmes']);
            $activeSheet->setCellValue('AH' . $fila, $datos[$i]['totalganadonav']);
            $fila += 1;
        }
        $this->descargarExcel($objPHPExcel, $nombreArchivo);
    }
    /**
     * 
     * @param integer $id, id relaciondado con el aguinaldo de naivdad
     * @return interfaz para la generacion del reporte de aguinalod de navidad
     */
     public function actionPlanillaPrima($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = $this->loadModel(SeguridadModule::dec($id));
        $ltipocontratos = Tipocontrato::model()->findAll();
        if (isset($_POST['Pagobeneficio'])) {

         

            if ($model->save()) {
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }

        $this->renderPartial('planillaprima', array(
            'model' => $model,
            'listatipocontrato'=>$ltipocontratos 
            ), false, true);
    }
    /**
   * @param integer $_GET['Pagobeneficio']['opciones'], posibles valores 1=Planilla con Personal Retirado 2= Planilla con Personal Activo  y 3= todos
   * @param integer $_GET['Pagobeneficio']['id'], id relacionado con la Prima Anual
   * @param integer[] $_GET['tipocontratos'], lista de id de tipos de contratos
   * @return reporte xls con la informacion de la Prima Anual
   */  
        public function actionDescargarExcelPlanillaPrima() {
        $opcion=$_GET['Pagobeneficio']['opciones'];
        $id=$_GET['Pagobeneficio']['id'];
        $tipocontratos= $_GET['tipocontratos'];
        $model = $this->loadModel($id);        
        $tipocontratosseleccionados ='';
           for ($i = 0; $i < count($tipocontratos); $i++) {
                        $tipocontratosseleccionados = $tipocontratosseleccionados . $tipocontratos[$i] . ',';
                    }
                    $tipocontratosseleccionados = substr($tipocontratosseleccionados, 0, -1);
           
        $fila = 6;
        $nombre = 'Ejemplo';
        $porcentaje=Yii::app()->rrhh
                        ->createCommand("select porcentaje*100 from general.primaanual where id=(select infoadicionalformapago::int from general.pagobeneficio where id=" . $model->id . ")")
                        ->queryScalar();
        $datoEmpresa = Yii::app()->rrhh
                        ->createCommand("select e.razonsocial,e.nit,e.nrempleadormt,nrempleador,pl.nombrer,pl.cir,pl.anio,to_char(now()::date,'dd-mm-YYYY') as hoy from planilla pl inner join general.representante r on r.cirepresentante=pl.cir inner join general.empresa e on e.id=r.idempresa  where pl.id in ( select split_part(listaplanilla,',',1)::int  from general.pagobeneficio where id=" . $model->id . ")")
                        ->queryAll()[0];
        $datos = Yii::app()->rrhh
                ->createCommand("select * from dame_lista_prima_anual(" . $id . ",'$tipocontratosseleccionados',$opcion)")
                ->queryAll();

        $nombreArchivo = 'Prima_Anual_' . $datoEmpresa['anio'];

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->removeSheetByIndex(0);
        $objPHPExcel->createSheet(0);
        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
        $activeSheet->setTitle($nombreArchivo);
        $activeSheet->getDefaultColumnDimension()->setWidth(14);
        $htmlHelper = new \PHPExcel_Helper_HTML();
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);

       
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
        $phpColor = array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '#00ccff'
            ),
            'font' => array(
                'bold' => true,)
        );
        $phpFontC = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'font' => array(
                'bold' => true,
            )
        );
        $phpFontC = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'font' => array(
                'bold' => true,
            )
        );
        $phpFontTitulo = array(
            
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
            ),);
        $phpFontCuadricula = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            ),
        );
        $phpFontCuadriculan = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '000000')
                ),
            ),
            'font' => array(
                'bold' => true,
            )
        );
      $activeSheet
                ->getPageMargins()->setTop(0.8);
        $activeSheet
                ->getPageMargins()->setRight(0.2);
        $activeSheet
                ->getPageMargins()->setLeft(0.2);
        $activeSheet
                ->getPageMargins()->setBottom(0.4);
        $objPHPExcel->getDefaultStyle()->applyFromArray($phpFont);
        $activeSheet->mergeCells('A1:M1');
        $activeSheet->mergeCells('A2:M2');
        $activeSheet->mergeCells('A3:M3');
        $activeSheet->mergeCells('A4:M4');
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
        $activeSheet->getRowDimension(5)->setRowHeight(52);
        $activeSheet->getRowDimension(1)->setRowHeight(15);
        $activeSheet->getRowDimension(2)->setRowHeight(15);
        $activeSheet->getRowDimension(3)->setRowHeight(15);
        $activeSheet->getRowDimension(4)->setRowHeight(15);

        $activeSheet->getColumnDimension('A')->setWidth(5);
        $activeSheet->getColumnDimension('B')->setWidth(10);
        $activeSheet->getColumnDimension('C')->setWidth(45);
        $activeSheet->getColumnDimension('D')->setWidth(40);
        $activeSheet->getColumnDimension('E')->setWidth(15);
        $activeSheet->getColumnDimension('F')->setWidth(15);
        $activeSheet->getColumnDimension('G')->setWidth(15);
        $activeSheet->getColumnDimension('H')->setWidth(15);
        $activeSheet->getColumnDimension('I')->setWidth(15);
        $activeSheet->getColumnDimension('J')->setWidth(15);
        $activeSheet->getColumnDimension('K')->setWidth(15);
        $activeSheet->getColumnDimension('L')->setWidth(15);
        $activeSheet->getColumnDimension('M')->setWidth(15);  
        $activeSheet->getColumnDimension('N')->setWidth(15);
        $activeSheet->getColumnDimension('O')->setWidth(15);  

        $activeSheet->getStyle('A1')->getFont()->setBold(true);
        $activeSheet->getStyle("A2")->getFont()->setBold(true);
        $activeSheet->getStyle('A3')->getFont()->setBold(true);
        $activeSheet->getStyle("A4")->getFont()->setBold(true);
        $activeSheet->setCellValue('A1', 'PRIMA ANUAL '. $datoEmpresa['razonsocial']);  
        $activeSheet->setCellValue('A3', 'GESTIÓN'.$datoEmpresa['anio']);
        $activeSheet->getStyle("A1")->getFont()->setSize(16);
        $activeSheet->getStyle("A1:A4")->applyFromArray($phpFontTitulo);
        $activeSheet->getStyle("A5:O5")->applyFromArray($phpFontC);
        $activeSheet->getStyle("A5:O5")->getAlignment()->setWrapText(true);
        $activeSheet->setCellValue('A5', 'Nº');
        $activeSheet->setCellValue('B5', 'C.I.');
        $activeSheet->setCellValue('C5', 'APELLIDOS Y NOMBRES');
        $activeSheet->setCellValue('D5', 'CARGO');
        $activeSheet->setCellValue('E5', 'FECHA DE INGRESO');
        $activeSheet->setCellValue('F5', 'FECHA RETIRO');
        $activeSheet->setCellValue('G5', 'T.G. Mes 1');
        $activeSheet->setCellValue('H5', 'T.G. Mes 2');
        $activeSheet->setCellValue('I5', 'T.G. Mes 3');
        $activeSheet->setCellValue('J5', 'TOTALGANADO PROMEDIO');
        $activeSheet->setCellValue('K5', 'MESES TRABAJO');
        $activeSheet->setCellValue('L5', 'MONTO EN BS.');
        $activeSheet->setCellValue('M5', 'MONTO PRIMA BS. '.$porcentaje.'%');
        $activeSheet->setCellValue('N5', 'RC-IVA.');
        $activeSheet->setCellValue('O5', 'LIQUIDO EN BS.');
        $cant = count($datos);

        for ($i = 0; $i < $cant; $i++) {
            $activeSheet->getStyle("A" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("B" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("C" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("D" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("E" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("F" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("G" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("H" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("I" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("J" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("K" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("L" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("M" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("N" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->getStyle("O" . $fila)->applyFromArray($phpFontCuadricula);
            $activeSheet->setCellValue('A' . $fila, $i + 1);
            $activeSheet->getStyle('G' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('G' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('H' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('H' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('I' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('I' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('J' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('J' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('K' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('K' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('L' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('L' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('M' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('M' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('N' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('N' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $activeSheet->getStyle('O' . $fila)->getNumberFormat()->setFormatCode('0.00');
            $activeSheet->getStyle('O' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            
            $activeSheet->setCellValue('B' . $fila, $datos[$i]['ci']);
            $activeSheet->setCellValue('C' . $fila, $datos[$i]['nombrecompleto']);
            $activeSheet->setCellValue('D' . $fila, $datos[$i]['cargo']);
            $activeSheet->setCellValue('E' . $fila, $datos[$i]['fechaingreso']);
             $activeSheet->setCellValue('F' . $fila, $datos[$i]['fecharetiro']);
            $activeSheet->setCellValue('G' . $fila, $datos[$i]['tg1']);
            $activeSheet->setCellValue('H' . $fila, $datos[$i]['tg2']);
            $activeSheet->setCellValue('I' . $fila, $datos[$i]['tg3']);
            $activeSheet->setCellValue('J' . $fila, $datos[$i]['promedio']);
            $activeSheet->setCellValue('K' . $fila, $datos[$i]['meses']);
            $activeSheet->setCellValue('L' . $fila, $datos[$i]['pagar']);
            $activeSheet->setCellValue('M' . $fila, $datos[$i]['pagarprima']);
            $activeSheet->setCellValue('N' . $fila, $datos[$i]['montorciva']);
            $activeSheet->setCellValue('O' . $fila, ($datos[$i]['pagarprima']-$datos[$i]['montorciva']));


            $fila += 1;
        }
        $activeSheet->mergeCells('A' . $fila . ':F' . $fila);
        $activeSheet->setCellValue('A' . $fila, 'TOTALES');
        $activeSheet->getStyle("A" . $fila . ':O' . $fila)->applyFromArray($phpFontCuadriculan);
        $activeSheet->getStyle('G' . $fila . ':O' . $fila)->getNumberFormat()->setFormatCode('0.00');
        $activeSheet->getStyle('A' . $fila . ':O' . $fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $activeSheet->getStyle('A' . $fila . ':O' . $fila)->getFont()->setBold(true);
        $activeSheet->setCellValue('G' . $fila, '=SUM(G6:G' . ($fila - 1) . ')');
        $activeSheet->setCellValue('H' . $fila, '=SUM(H6:H' . ($fila - 1) . ')');
        $activeSheet->setCellValue('I' . $fila, '=SUM(I6:I' . ($fila - 1) . ')');
        $activeSheet->setCellValue('J' . $fila, '=SUM(J6:J' . ($fila - 1) . ')');
        $activeSheet->setCellValue('K' . $fila, '=SUM(K6:K' . ($fila - 1) . ')');
        $activeSheet->setCellValue('L' . $fila, '=SUM(L6:L' . ($fila - 1) . ')');
        $activeSheet->setCellValue('M' . $fila, '=SUM(M6:M' . ($fila - 1) . ')');
        $activeSheet->setCellValue('N' . $fila, '=SUM(N6:N' . ($fila - 1) . ')');
        $activeSheet->setCellValue('O' . $fila, '=SUM(O6:O' . ($fila - 1) . ')');
        $fila += 5;
        $activeSheet->mergeCells('C' . $fila . ':G' . $fila);
        $activeSheet->mergeCells('J' . $fila . ':L' . $fila);
        $activeSheet->mergeCells('O' . $fila . ':Q' . $fila);
        $activeSheet->mergeCells('T' . $fila . ':U' . $fila);
        $activeSheet->getStyle('C' . $fila)->applyFromArray($phpFontP);
        $activeSheet->getStyle('J' . $fila)->applyFromArray($phpFontP);
        $activeSheet->getStyle('O' . $fila)->applyFromArray($phpFontP);
        $activeSheet->getStyle('S' . $fila)->applyFromArray($phpFontP);
        $activeSheet->setCellValue('C' . $fila, 'NOMBRE DEL EMPLEADOR O REPRESENTANTE LEGAL');
        $activeSheet->setCellValue('J' . $fila, 'Nº DE DOCUMENTO DE IDENTIDAD');
        $activeSheet->setCellValue('O' . $fila, 'FIRMA');
        $activeSheet->setCellValue('S' . $fila, 'FECHA: ');
        $activeSheet->setCellValue('T' . $fila, $datoEmpresa['hoy']);


        $this->descargarExcel($objPHPExcel, $nombreArchivo);
            
        
    }
   

}
