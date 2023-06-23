<?php
/*
 * MovimientopersonalController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 14/05/2019
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
class MovimientopersonalController extends Controller
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
        
        $model=new Movimientopersonal;
        $areas=array();
        $secciones=array();
        $sueldos=  Yii::app()->rrhh
            ->createCommand("select id, nombre||'('||sueldo||' Bs.)' as sueldo from general.nivelsalarial where eliminado =false")
            ->query();

        if(isset($_POST['Movimientopersonal'])){
            $existe=Movimientopersonal::model()->find("t.idempleado=".$_POST['Movimientopersonal']['idempleado']." and  t.fechaini='".$_POST['Movimientopersonal']['fechaini']."'");
            if (count($existe)==0) {
                $model->attributes=$_POST['Movimientopersonal'];
                $model->idcontrato=Movimientopersonal::model()->dameIdContrato($_POST['Movimientopersonal']['idempleado']);
                Movimientopersonal::model()->bajaMovimiento($_POST['Movimientopersonal']['idempleado']);     

                if($model->save()){ 
             //   Horario::model()->registrarHT( $_POST['gridHorasTrabajo'],$model->id);                    
                    echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                    return;
                } else {
                    echo System::hasErrors('Revise los datos! ', $model);
                return;
                }}else{
                     echo System::hasErrors('Ya existe un movimiento en esta fecha! ', $model->fechaini);
                }
        }

        $this->renderPartial('create',array(
            'model'=>$model,
            'areas'=>$areas,
            'secciones'=>$secciones,
            'sueldos'=>$sueldos,
            'puestotrabajos'=>array(),
            //'listaHorarios'=>$listaHorarios,

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
        $fechaini=$model->fechaini;
      
        $informacion=Yii::app()->rrhh
            ->createCommand("select c.idtipocontrato,hc.* from general.historialestadoempleado hee inner join 
contrato c on c.idhistorialestadoempleado=hee.id  inner join  historialcontrato hc 
on hc.idcontrato=c.id

 where hee.eliminado=false  and c.eliminado=false and hc.eliminado=false and  hee.activo=1 and hee.idempleado=".$model->idempleado."  and hc.fecharegistro<='".$model->fechaini."' order by hc.fecharegistro desc limit 1 ")
            ->queryAll();        
        $model->tipocontrato=$informacion[0]['idtipocontrato'];
        $esrrhh=Yii::app()->rrhh
            ->createCommand("select usuariorrhh from  general.seguimientoempleado se inner join ftbl_usuario_web_cruge_user cu on cu.iduser=se.idcrugeuser where se.eliminado=false and cu.username='".Yii::app()->user->getName()."' order by se.id desc limit 1  ")
            ->queryScalar();
        $model->scenario='update';
        $date = date_create($model->fechaini);
        $model->fechaini= date_format($date, 'd-m-Y');
        $ns= Nivelsalarial::model()->find('t.id='.$informacion[0]['idnivelsalarial']);
        $modelpuestotrabajo= Puestotrabajo::model()->find('t.id='.$informacion[0]['idpuestotrabajo']);
        $model->nivelsalarial=$ns->sueldo.' Bs.('.$ns->nombre.')';
        $modelcontrato= Contrato::model()->find('t.id='.$informacion[0]['idcontrato']);
        $areas=Area::model()->findAll('t.idunidad='.$modelpuestotrabajo->idseccion0->idarea0->idunidad);
        $secciones=Seccion::model()->findAll('t.idarea='.$modelpuestotrabajo->idseccion0->idarea0->id);
         if($modelcontrato->idtipocontrato0!==null){
            $contrato=$modelcontrato->idtipocontrato0->nombre;
         }
         else
         {
            $contrato=0;
         }
         $horarios=Horario::model()->listaHorarios($model->idhorario);    
        $puestotrabajos=$modelpuestotrabajo->id;
        $model->unidad=$modelpuestotrabajo->idseccion0->idarea0->idunidad0->id;
        $model->area=$modelpuestotrabajo->idseccion0->idarea0->id;
        $model->seccion=$modelpuestotrabajo->idseccion0->id;  
        $sueldos=  Yii::app()->rrhh
            ->createCommand("select id, nombre||'('||sueldo||' Bs.)' as sueldo from general.nivelsalarial where eliminado =false")
            ->query();      
        if($esrrhh==true){
            $ventana='update';
        }else{
            $ventana='horario';
        }

        if(isset($_POST['Movimientopersonal']))
        {
            
            $tipocontrato=$_POST['Movimientopersonal']['tipocontrato'];
            if($tipocontrato!=''){
                        
                $modelcontrato->idtipocontrato=$_POST['Movimientopersonal']['tipocontrato'];
                $modelcontrato->save();
            }
            $model->attributes=$_POST['Movimientopersonal'];
            if($model->estado==true){
                $model->fechaini=$fechaini;
            }

            if($model->save()){
                   
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }

        $this->renderPartial($ventana,array(
            'model'=>$model,            
            'areas'=>$areas,
            'secciones'=>$secciones,
            'puestotrabajos'=>$puestotrabajos,
            'sueldos'=>$sueldos,
            'contrato'=>$contrato,
            'horarios'=>$horarios
             
        ), false, true);
    }

    /**
     * Deletes safely a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
            $usuario=Yii::app()->user->getName(); 
             Yii::app()->rrhh
            ->createCommand("select quitar_empleado_horario_movimento(".SeguridadModule::dec($id).",'$usuario') ")
            ->execute();
            self::actionAdmin();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        Yii::app()->getClientScript()->scriptMap = array('jquery.js' => false, 'jquery.ui.js' => false, 'jquery-ui.min.js' => false);

        $model=new Movimientopersonal('search');
       // $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Movimientopersonal'])){
                $model->attributes=$_GET['Movimientopersonal'];
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
	 * @return Movimientopersonal the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Movimientopersonal::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Movimientopersonal $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='movimientopersonal-form')
		{
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
               $model=   Yii::app()->rrhh
            ->createCommand("select e.id ,  p.apellidop||' '||p.apellidom||' '||p.nombre as nombrecompleto from general.persona p inner join general.empleado e on e.idpersona=p.id right outer join general.seguimientoempleado se on se.idempleado=e.id  right outer JOIN ftbl_usuario_web_cruge_user cu  on cu.iduser=se.idcrugeuser where se.eliminado=false and  cu.username='".Yii::app()->user->getName()."' and p.nombrecompleto like '%$requestMayuscula%' and e.id in (  (select e.id from general.historialestadoempleado hee inner join  general.empleado e on e.id=hee.idempleado   where hee.eliminado=false  and hee.activo=1 and hee.id in (select  (select max(id) from general.historialestadoempleado where eliminado=false and idempleado=e.id) as idhistorial from general.empleado e where   e.eliminado=false)) 
            )   ")
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
     * @param string $_GET['term'], sueldo o parte del sueldo
     * retorna un listado de sueldo que contenga  a $_GET['term']
     */
    public function actionAutocompleteNivelsalarial()
    {
       $request = trim($_GET['term']);
        if ($request != '') {
            $model = Nivelsalarial::model()->findAll(array("condition" => "  t.sueldo::text like '$request%' "));
            $data = array();
            foreach ($model as $get) {
                $data[] = array(
                    'value' => $get->sueldo.' Bs.('.$get->nombre.')',
                    'id' => $get->id,
                );
            }
            $this->layout = 'empty';
            echo CJSON::encode($data);
        }
    }
    /**
     * @param integer $_POST['ide'], id del empleado
     * @param string $_POST['nombre'], nombre del formulario que hace el llamado a esta funcion
     * @return   elelemetos de un formulario referentes al horari del empleado
     */
    public function actionDameInfoE()
    {
        $ide=$_POST['ide'];
        $nombre=$_POST['nombre'];
        $model = Movimientopersonal::model()->find(array("condition" => " t.idempleado=$ide and eliminado=false "));
         $nivel=$model->idnivelsalarial;
         $cargo=$model->idpuestotrabajo;
         $seccion=$cargo=$model->idpuestotrabajo0->idseccion;      
         $area=$model->idpuestotrabajo0->idseccion0->idarea;
         $unidad=$model->idpuestotrabajo0->idseccion0->idarea0->idunidad;
         $contrato=$model->idcontrato0->idtipocontrato0->nombre;
         $horarios=Horario::model()->listaHorarios($model->id);
         $hh= $this->renderPartial('_horario',array(
            'horarios'=>$horarios,
            'nombre'=>  $nombre,
        ),  true);
         header('Content-type: application/json'); 
         echo CJSON::encode(array('cargo'=>$cargo,'seccion'=>$seccion,'area'=>$area,'unidad'=>$unidad,'nivel'=>$nivel,'horarios'=>$hh,'contrato'=>$contrato));
      return;

    }
    /**
     * @param integer $_POST['idhorario'], id del horario
     * @param string $_POST['nombre'], nombre del formulario que hace el llamado a esta funcion
     * @return elementos de formulario con la informacion del horario
     */
    public function actionDameHorario()
    {
        $idhorario=$_POST['idhorario'];
        $nombre=$_POST['nombre'];
        $horarios=Horario::model()->listaHorarios($idhorario);      
        $hh= $this->renderPartial('_horario',array(
            'horarios'=>$horarios,
            'nombre'=>  $nombre,
           
        ),  true);
        header('Content-type: application/json'); 
         echo CJSON::encode(array('horarios'=>$hh));

      return;
    }
    /**
     * 
     * @param integer $id, id del movimiento de personal 
     * @return un formulario para el cambio de horario
     */
    public function actionCambiarHorario($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $model=$this->loadModel(SeguridadModule::dec($id));
        $horarios=Horario::model()->listaHorarios($model->idhorario);   
        $cadena='';
        $resp= Yii::app()->rrhh
                    ->createCommand("select * from  dame_observacion_horario('".$model->fechaini."',".$model->idempleado." ) ")
                    ->queryScalar();    
                    if($resp!=''){
                        $cadena='<div class="row">'.$resp.'</div><div class="row"><strong>PASOS:</strong><ol><li>Elimine todos los permisos del listado anterior</li><li>Asigne el nuevo horario</li><li>Reasigne los permisos anteriormente eliminados</li></ol></div>';
          
                    }
        if(isset($_POST['Movimientopersonal']))
        {
            
            $model->attributes=$_POST['Movimientopersonal'];
            

            if(true){
             $usuario=Yii::app()->user->getName();
            Yii::app()->rrhh
            ->createCommand("select actualizar_horario_empleado(".$model->idempleado.", ".$model->idhorario.",'".$model->fechaini."','$usuario') ")
            ->execute();   
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }

        $this->renderPartial('cambiarhorario',array(
            'model'=>$model,          
             'horarios'=>$horarios,
            'mensaje'=>$cadena
        ), false, true);
    }
}
