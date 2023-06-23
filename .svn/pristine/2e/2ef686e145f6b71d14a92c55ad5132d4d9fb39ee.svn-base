<?php
/*
 * HistorialestadoempleadoController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 04/05/2020
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
class HistorialestadoempleadoController extends Controller
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
        
        $model=new Historialestadoempleado;

        if(isset($_POST['Historialestadoempleado'])){
                $model->attributes=$_POST['Historialestadoempleado'];
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
        
        $model=$this->loadModel(SeguridadModule::dec($id));
        $model->fechavacacion= date ("d-m-Y",strtotime( $model->fechavacacion));

        if(isset($_POST['Historialestadoempleado']))
        {
            $model->attributes=$_POST['Historialestadoempleado'];
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
     * 
     * @return interfaz para la seleccion de fechas para el reporte de personal ingresado y retira
     */
    public function actionIngresoRetiroEmpleado()
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=new Historialestadoempleado;
        $listameses=Yii::app()->rrhh
        ->createCommand(" select *  from  dame_meses_ingreso_retiro_personal() order by id desc ")
        ->queryAll();
        $fecha=Yii::app()->rrhh
        ->createCommand(" select to_char((valor::date+1),'dd-mm-YYYY') as fecha  from general.configuracion where id=26 ")
        ->queryScalar();
        if(isset($_POST['Historialestadoempleado'])){
                $model->attributes=$_POST['Historialestadoempleado'];
                if($model->save()){                       
                    echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {
                    echo System::hasErrors('Revise los datos! ', $model);
                return;
                }
        }

        $this->renderPartial('ingresoretiropersonal',array(
            'model'=>$model,
            'listameses'=>$listameses,
            'fecha'=>$fecha
        ), false, true);
    }
    /**
     * 
     * @param date $fechadesde, fecha desde
     * @param date $fechahasta, fecha hasta
     * retorna reporte de personla ingresado/retirado entre las fechas selleccionadas
     */
     public function actionReporteIngresoRetiroEmpleado($fechadesde,$fechahasta) {
     

        if ($fechadesde === ''||!isset($fechadesde)) {
                     $criteria = new CDbCriteria();
                     $criteria->order = 't.id ASC';
                     $criteria->limit=1;
                     $ordenModel = Gestion::model()->find($criteria);
                     $fechadesde = date ("d-m-Y",strtotime( $ordenModel->inicio));
                 }
                 if ($fechahasta === ''||!isset($fechahasta)) {
                     $fechahasta = date('d-m-Y');
                 } 
                 $re = new JasperReport('/reports/RRHH/ReporteIngresoRetiroEmpleado', JasperReport::FORMAT_PDF, array(
                 'p_fechadesde' => date ("d-m-Y",strtotime( $fechadesde)), 
                 'p_fechahasta' => date ("d-m-Y",strtotime( $fechahasta)), 
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
            $this->loadModel(SeguridadModule::dec($id))->safeDelete();
            self::actionAdmin();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model=new Historialestadoempleado('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Historialestadoempleado'])){
                $model->attributes=$_GET['Historialestadoempleado'];
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
	 * @return Historialestadoempleado the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Historialestadoempleado::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Historialestadoempleado $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='historialestadoempleado-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
        }
         /**
          * 
          * @param integer $id, id que se relaciona con el ingreso del empleado
          * interfaz para la generacion del reporte de afiliacion 
          */
         public function actionDescargarAfiliacionCNS($id) {
            Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
            $model=$this->loadModel(SeguridadModule::dec($id));
            $model->fecha='';      
            $this->renderPartial('afiliacionCNS',array(
                'model'=>$model

            ), false, true);

        
        }
        /**
         * 
         * @param date $fecha,fecha de afiliacion del empleado
         * @param integer $id, id vinculado con el ingreso del empleado
         * @param float $sueldo, haber basico manual
         * retorna reporte de afiliacion
         */
        public function actionImprimirAfiliacion($fecha,$id,$sueldo) {
       
            $re = new JasperReport('/reports/RRHH/AfiliacionCNS', JasperReport::FORMAT_PDF, array(
                'p_idhistorialestadoempleado' => $id,
                'p_fechapresentacion'=>$fecha,
                'p_sueldo'=>$sueldo
            ));
            $re->exec();
            if ($re->getPages() > 0) {
                echo $re->toPDF();
            } else {
                throw new CrugeException('El reporte no tiene páginas.', 483);
            }

        
    }
    /**
     * Retorna interfaz para el llenado manual de informacion referente a la Baja Caja, del personal que no tiene finiquito
     */
     public function actionReportebajacaja() {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);
            $model= new Historialestadoempleado;
            $model->fecha='';   
            $listaempleado=Yii::app()->rrhh
            ->createCommand("select id,nombrecompleto from(select hee.id,p.nombrecompleto,(select c.idhistorialestadoempleado from contrato c inner join historialcontrato hc on hc.idcontrato=c.id 
 where hc.eliminado=false and c.eliminado=false and (c.idhistorialestadoempleado=(
  select he.id from general.historialestadoempleado he where he.eliminado=false and he.idempleado=hee.idempleado and he.id<hee.id order by he.id desc limit 1))

and c.idtipocontrato in(select id from general.tipocontrato where eliminado=false and generarcc=true) 
and hc.fecharegistro<=hee.fecharetiro order by hc.fecharegistro desc limit 1) from general.historialestadoempleado hee inner join 
general.empleado e on e.id=hee.idempleado inner join general.persona p on p.id=e.idpersona
 where hee.eliminado=false and  hee.activo=0 and hee.id 
not in (select idhistorialestadoempleado from general.pagobeneficio where eliminado=false and idtipopagobeneficio=2) order by p.nombrecompleto asc) as t where t.idhistorialestadoempleado is not null")
            ->queryAll();
            $this->renderPartial('bajaCaja',array(
                'model'=>$model,
                'listaempleado'=>$listaempleado

            ), false, true); 
    }
    /**
     * 
     * @param date $fecha, fecha de presentacion de la baja
     * @param integer $id, id relacionado con la baja del empleado
     * @param float $sueldo, sueldo del empleado
     * @param integer $tiporetiro, tipo de contrato 
     * @throws CrugeException
     */
    public function actionImprimirBajaManual($fecha,$id,$sueldo,$tiporetiro) {
      
        $re = new JasperReport('/reports/RRHH/ReporteManualBajaCaja', JasperReport::FORMAT_PDF, array(
                'p_idhistorialestadoempleado' => $id,
                'p_fechapresentacion'=>$fecha,
                'p_sueldo'=>$sueldo,
                'p_idtiporetiro'=>$tiporetiro
            ));
            $re->exec();
            if ($re->getPages() > 0) {
                echo $re->toPDF();
            } else {
                throw new CrugeException('El reporte no tiene páginas.', 483);
            }

        
    }
    
}
