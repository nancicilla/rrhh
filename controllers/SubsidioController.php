<?php

/*
 * SubsidioController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 09/12/2019
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

class SubsidioController extends Controller {
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

        $model = new Subsidio;
        $model->scenario = 'crear';
        if (isset($_POST['Subsidio'])) {
            $model->attributes = $_POST['Subsidio'];
            if ($_POST['Subsidio']['fechanacbebe'] == '') {
                $model->fechanacbebe = null;
            }
            if ($model->save()) {
                echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
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
        $model->fechar = date("d-m-Y", strtotime($model->fechar));
        $model->fechaiqmes= date("d-m-Y", strtotime($model->fechaiqmes));
        if($model->fechanacbebe!=null){
             
        $model->fechanacbebe =date("d-m-Y", strtotime($model->fechanacbebe));
        }$horariolactancias = $model->horariolactancias;
        if (count($horariolactancias) == 0) {
            $modelhorariolactancia = new Horariolactancia;
            $horariolactancias = array();
        } else {
            $modelhorariolactancia = $horariolactancias[0];
            $model->fechadesde = date("d-m-Y", strtotime($model->fechadesde));
            $model->fechahasta = date("d-m-Y", strtotime($model->fechahasta));
            $horariolactancias = Horariolactancia::model()->listaHorarios($model->id);
        }


        if (isset($_POST['Subsidio'])) {
            $model->attributes = $_POST['Subsidio'];
            if ($_POST['Subsidio']['fechanacbebe'] == '') {
                $model->fechanacbebe = null;
            }
            if ($_POST['Subsidio']['fechadesde'] == '') {
                $model->fechadesde= null;
                $model->fechahasta= null;
            }
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
            'modelhorariolactancia' => $modelhorariolactancia,
            'horariolactancias' => $horariolactancias,
                ), false, true);
    }

    /**
     * Deletes safely a particular model.
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

        $model = new Subsidio('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }

        if (isset($_GET['Subsidio'])) {
            $model->attributes = $_GET['Subsidio'];
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
     * @param string $_POST['nombrecompleto'], nombre completo o parte del nombre completo del empleado
     * retorna lista de empleado que contengan en su nombre comple a $_POST['nombrecompleto']
     */
    public function actionAutocompletePersona() {
        $request = trim($_GET['term']);
        $requestMayuscula = strtoupper($request);
        if ($request != '') {
            $model = Persona::model()->findAll(array("condition" => " ( t.nombre like '%$requestMayuscula%' or t.apellidop like '%$requestMayuscula%'  or t.apellidom like '%$requestMayuscula%') and t.id in (select idpersona from general.empleado) "));
            $data = array();
            foreach ($model as $get) {
                $data[] = array(
                    'value' => $get->apellidop . ' ' . $get->apellidom . ' ' . $get->nombre,
                    'id' => $get->empleados[0]->id,
                );
            }
            $this->layout = 'empty';
            echo CJSON::encode($data);
        }
    }
    /**
     *@param integer $_POST['ide'], id del empleado
     * retorna la beneficiciaria
     */
    public function actionMostrarbenficiaria() {
        $ide = $_POST['ide'];
        $lista = Yii::app()->rrhh->createCommand("select d.id,d.nombrec from general.empleado e inner join general.persona p on p.id=e.idpersona inner join general.dependiente d on d.idpersona=p.id inner join general.parentesco pa on pa.id=d.idparentesco where e.id=" . $ide . " and d.eliminado=false and pa.parentescod='ESPOSA' and p.sexo='V'")->queryAll();
        $this->renderPartial('_beneficiaria', array(
            'lista' => $lista,
                ), false, true);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Subsidio the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Subsidio::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Subsidio $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'subsidio-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Actualiza la informaciòn de nacido vivo y registra el asiento de natalidad
     * @param integer $id the ID of the model to be updated
     */
    public function actionRegistroNacidoVivo($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = $this->loadModel(SeguridadModule::dec($id));
        $model->scenario = 'registroNacidoVivo';
        if (isset($_POST['Subsidio'])) {
            $model->attributes = $_POST['Subsidio'];
            if ($_POST['Subsidio']['fechanacbebe'] == '') {
                $model->fechanacbebe = null;
            }
            if ($model->save()) {          
            
                $aux = Yii::app()->contabilidad
                        ->createCommand('select "' . getGestionSchema() . '".registrar_asiento_nacido_vivo(' . $model->idempleado . ',\'' . Yii::app()->user->getName() . '\');')
                        ->queryScalar();
                                  
                if ($aux !== 'exito') {
                    echo System::hasErrors($aux, $model);
                } else {
                    echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                }
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }
        $this->renderPartial('registroNacidoVivo', array(
            'model' => $model,
                ), false, true);
    }
    
    /**
     * Da de baja un subsidio
     * @param integer $id el id del modelo a ser dado de baja
     */
    public function actionDarbaja($id) {
        $model = $this->loadModel(SeguridadModule::dec($id));
        $model->activo = 0;
        $model->save();
    }
    /**
     * 
     * @param integer $id, del subsiio a dar de alta
     */
     public function actionDaralta($id) {
        $model = $this->loadModel(SeguridadModule::dec($id));
        $model->activo = 1;
        $model->save();
    }
    /**
     * 
     * @param integer $id, id del subsidio de la beneficiaria del horario de lactancia
     * @return formulario para el registro del nuevo horario de lactancia
     */
    public function actionNuevoHorarioLactancia($id) {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model = $this->loadModel(SeguridadModule::dec($id));
        if($model->fechadesde!=null){
            $model->scenario='none';
        }
        $fechaminima= Yii::app()->rrhh
                    ->createCommand("select to_char((select dame_fechaminimacorte()),'dd-mm-YYYY')")
                    ->queryScalar(); 
        if (isset($_POST['Subsidio'])) {    
                
                if($model->scenario!='none'){
                $model->fechadesde= $_POST['Subsidio']['fechadesde'];
                $model->fechahasta= $_POST['Subsidio']['fechahasta'];
                $model->fechainicio=$model->fechadesde;
                $model->save();
                }else{
                    $model->fechadesde= $_POST['Subsidio']['fechainicio'];
                }
                if(true){
 
                
                    $cadena=Horariolactancia::model()->registrarDatosHorarioLactancia($model->id,$model->idempleado, $model->fechadesde, $_POST['gridHorasTrabajo']);
                    if ($cadena!=''){
                      echo System::hasErrors($cadena, $model);
                    
                    }
                }else{
                    echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                }
             return;
                                  
             
               
        }
        $this->renderPartial('horariolactancia', array(
            'model' => $model,
            'fechaminima'=>$fechaminima
                ), false, true);
    }
}
