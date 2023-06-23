<?php
/*
 * HorarioController.php
 *
 * Version 0.$Rev: 286 $
 *
 * Creacion: 21/02/2020
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
class HorarioController extends Controller
{
	 /*
     * IMPORTANTE!!!
     * Los métodos filters(),_publicActionsList() y accessRules() deben copiarse
     * tal cual en todos los controladores del proyecto
     */
    
    /* 
     * se debe usar este método filters en todos los controladores para permitir
     * filtrar si el  tiene acceso a las acciones y controlador o no, 
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
        
        $model=new Horario;
        $model->idhorario=0;
        $listahorario=array();
        $listaempleados=array();
        $fechaminima= Yii::app()->rrhh
                    ->createCommand("select to_char((select dame_fechaminimacorte()),'dd-mm-YYYY')")
                    ->queryScalar();  

        if(isset($_POST['Horario'])){

            $cant=Yii::app()->rrhh->createCommand("select count(*) as cant from general.horario where nombre=' ".$model->nombre."' ")->queryScalar();
                $model->attributes=$_POST['Horario'];
                
                if ($cant==0){

                    if($model->save()){     
                    Cuerpohorario::model()->registrarListaHorario($model->id,$_POST['gridHorasTrabajo']); 
                   echo System::dataReturn('Creación exitosa!', array('id' => SeguridadModule::enc($model->id)));
                        return;
                    } else {
                    echo System::hasErrors('Revise los datos! ', $model);
                return;
                }}else{
                    echo System::hasErrors('El Nombre del Horario ya Existe! ', $model->nombre); 
                }
        }

        $this->renderPartial('create',array(
            'model'=>$model,
            'listahorario'=>$listahorario,
            'listaempleados'=>$listaempleados,
            'fechaminima'=>$fechaminima
        ), false, true);
    }
    /**
     * 
     * @return interfaz para el registro de horario eventual 
     */
    public  function actionHorarioespecial(){
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        $model=new Horario;     
        $listahorario=Yii::app()->rrhh->createCommand("select id,nombre from general.horario where estado=true  order by nombre asc ")->queryAll();
        $listasecciones= Yii::app()->rrhh->createCommand("select s.id,s.nombre,a.nombre as nombrearea from general.seccion s
 inner join general.area a on a.id=s.idarea 
 where s.eliminado=false and s.id in (
 select distinct pt.idseccion from 

general.historialestadoempleado hee inner join contrato c on c.idhistorialestadoempleado=hee.id inner join historialcontrato hc on hc.idcontrato=c.id inner join general.puestotrabajo pt 
on pt.id=hc.idpuestotrabajo
 
 inner join 
general.seguimientoempleado se on se.idempleado =hee.idempleado inner join 
ftbl_usuario_web_cruge_user cu on cu.iduser=se.idcrugeuser where  se.eliminado=false and cu.username='".Yii::app()->user->getName()."'
  and hee.activo=1 and hc.id =(select hc1.id from historialcontrato hc1 inner join contrato c1 on c1.id=hc1.idcontrato where c1.idhistorialestadoempleado=hee.id  order by hc1.id desc limit 1 ) and hee.id in 
(select (select max(id) from general.historialestadoempleado where eliminado=false and idempleado =e.id)
 from general.empleado e where  e.eliminado=false)) order by s.nombre asc ")->queryAll();
        
        $fechaminima= Yii::app()->rrhh
                    ->createCommand("select to_char((select dame_fechaminimacorte()),'dd-mm-YYYY')")
                    ->queryScalar();  
        if (isset( $_POST['Horario'])) {
                $cant=count($listasecciones);
                $letras=$model->dameColumna('A', $cant);
                for ($i=0;$i<$cant;$i++){    
                    Horario::model()->registrarHorarioEmpleado($_POST['Horario']['id'],$_POST['grilla'.$letras[$i]],$_POST['Horario']['fechadesde'],$_POST['Horario']['fechahasta']);
                           
                }
                    
            echo System::dataReturn('exitosa!', array('id' => SeguridadModule::enc($model->id)));
                      return;

        }
       $this->renderPartial('horarioespecial',array(
           'model'=>$model,
            'listahorario'=>$listahorario,
           'listasecciones'=>$listasecciones,
           'fechaminima'=>$fechaminima
        ), false, true);
    }
    /**
     * 
     * @param interger $id, id del horario
     * @return interfaz para la asignacion de empleados al horario
     */ 
    public function actionAsignarempleado($id)
    {
        Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
        
        $model=$this->loadModel(SeguridadModule::dec($id));
        $model->scenario='update';
        $listaempleados=Horario::model()->listaEmpleadoQuitar($model->id);
        $fecha= Yii::app()->rrhh->createCommand("select to_char(fechahasta+1,'dd-mm-YYYY') from planilla where eliminado=false order by id desc limit 1  ")
            ->queryScalar();
         

        if(isset($_POST['gridEmpleados']))
        {          
            if(true){
               
                Horario::model()->guardarlistaQuitarEmpleados($_POST['gridEmpleados'],$model->id);
                
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } else {
                echo System::hasErrors('Revise los datos! ', $model);
                return;
            }
        }

        $this->renderPartial('asignarempleado',array(
            'model'=>$model,
            'listaempleados'=>$listaempleados,
            'fecha'=>$fecha
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
         $model->scenario='update';
         $idhorario=$model->id;
         $model->idhorario=$model->id;
         $hm=Horario::model()->DameHoraMinutoHorario($model->id);
         $model->horas=$hm[0]['hora'];
         $model->minutos=$hm[0]['minuto'];
         $listahorario=$model->dameHorarios();
         $listaempleados= Yii::app()->rrhh->createCommand("select distinct e.id from general.empleado e inner join movimientopersonal mp on mp.idempleado=e.id  inner join general.seguimientoempleado se on se.idempleado=e.id inner join ftbl_usuario_web_cruge_user cu on cu.iduser=se.idcrugeuser  where se.eliminado=false and cu.username='".Yii::app()->user->getName()."'  and  mp.idhorario=$idhorario and  e.eliminado=false and mp.eliminado=false and e.id in(( select idempleado from general.historialestadoempleado where eliminado=false and activo=1 and id in(   select ( select max(id) from general.historialestadoempleado where eliminado=false and idempleado =e.id) from general.empleado e where eliminado=false ) )) ")
            ->queryAll();
         $fecha= Yii::app()->rrhh
          ->createCommand("select  to_char(((select fechahasta+1 from planilla where eliminado=false order by id desc limit 1)),'dd-mm-YYYY') ")  ->queryScalar();
      
         $ventana='_horarioupdate';
  
        if(isset($_POST['Horario']))
        {    
            
            if(count($listaempleados)>0){
             $idhorariopadre=$model->id;
             $model=new Horario;            
             $model->id=null;
             $model->idhorariopadre=$idhorario;
            }else{
              Yii::app()->rrhh->createCommand("update general.cuerpohorario set eliminado=true where idhorario= ".$model->id)
            ->execute();
            } 
            
                $model->attributes=$_POST['Horario'];
                $model->save();
                Cuerpohorario::model()->registrarListaHorario($model->id,$_POST['gridHorasTrabajo']); 
               if(count($listaempleados)>0){
                Horario::model()->guardarlistaEmpleados($idhorariopadre, $model->id,$_POST['Horario']['fechainicio']);
                                
                echo System::dataReturn('', array('id' => SeguridadModule::enc($model->id)));
                return;
            } 
        }

        $this->renderPartial('update',array(
            'model'=>$model,
            'fecha'=>$fecha,
              'listahorario'=>$listahorario,
              'listaempleados'=>$listaempleados,
            'ventana'=>$ventana
        ), false, true);
    }
    /**
     *@param string $_POST['dia'],parte del nombre del dia ejemplo, Lunes, Martes, etc.
     * retorna un listado de nombre de dias 
     */
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
                ),
        ));
    }
    /**
     * @param string $_POST['nombrecompleto'] ,nombbre completo o parte del nombre completo
     * retorna la lista de empleados que contegan en su nombre completo $_POST['nombrecompleto']
     */
     public function actionBuscarEmpleado()
    {
        
        $datos = Persona::model()->filtraPersona($_POST['nombrecompleto']);
        if(count($datos->getData()) == 0)
            $datos = array(
                0 => array('nombre' => $_POST['nombrecompleto'], 'id' => '0')
            );
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $datos,
            'columns' => array(
                array('name' => 'nombrecompleto', 'header' => 'Empleado', 'value' => '$data->nombrecompleto'),
                array('name' => 'id', 'typeCol' => 'hidden', 'value' => '$data->empleados[0]->id'),
            ),
        ));
    }
  /**
     *@param string $_POST['diad'],parte del nombre del dia ejemplo, Lunes, Martes, etc.
     * retorna un listado de nombre de dias 
     */
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
             //   array('name' => 'idtipobancoHidden', 'typeCol' => 'hidden', 'value' => '-1'),
            ),
        ));
    }
    /**
     * @param string $_POST['rangohora'], hora o parte de la hora 
     * retorna listado de intervalos de horas que contengan a  $_POST['rangohora']
     */
     public function actionBuscarHora()
    {
        
        $datos = Rangohora::model()->filtraHora($_POST['rangohora']);
        if(count($datos->getData()) == 0)
            $datos = array(
                0 => array('nombre' => $_POST['rangohora'], 'id' => '0')
            );
        
        echo SGridView::widget('TGridViewList', array(
            'dataProvider' => $datos,
            'columns' => array(
                array('name' => 'rangohora', 'header' => 'Horas', 'value' => '$data->horai'),
                array('name' => 'idrangohora', 'typeCol' => 'hidden', 'value' => '$data->id'),
             //   array('name' => 'idtipobancoHidden', 'typeCol' => 'hidden', 'value' => '-1'),
            ),
        ));
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

        $model=new Horario('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize', Yii::app()->params['defaultPageSize']);
        }           

        if(isset($_GET['Horario'])){
                $model->attributes=$_GET['Horario'];
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
    * @param string $_GET['term'], nombre o parte del nombre del horario
    * retorna un listado de horarios que contenga a $_GET['term']
    */
    public function actionBuscarHorario()
    {
            $request = trim($_GET['term']);
           
            $requestMayuscula = strtoupper($request);
            if ($request != '') {
                $model = Horario::model()->findAll(array("condition" => "  t. nombre like '%$requestMayuscula%' "));
                $data = array();
                foreach ($model as $get) {
                    $data[] = array(
                        'value' =>  $get->nombre,
                        'id' => $get->id,
                    );
                }
                $this->layout = 'empty';
                echo CJSON::encode($data);
            }
        
    }
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Horario the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Horario::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        /**
         * 
         * @param integer $id, ide del horario
         * @return un formulario con la informacion del horario
         */
        public function actionInformacionhorario($id)
        {
             Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);

             $model=$this->loadModel(SeguridadModule::dec($id));
             $model->scenario='update';
             $model->idhorario=$model->id;
             $hm=Horario::model()->DameHoraMinutoHorario($model->id);
             $model->horas=$hm[0]['hora'];
             $model->minutos=$hm[0]['minuto'];
             $listahorario=$model->dameHorarios();

            if(isset($_POST['Horario']))
            {
               return;
            }

            $this->renderPartial('informacionhorario',array(
                'model'=>$model,
                  'listahorario'=>$listahorario,
            ), false, true);



        }
	/**
	 * Performs the AJAX validation.
	 * @param Horario $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='horario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        /**
         * @param integer $_POST['idempleado'], el id del empleado
         * @param integer $_POST['fecha'], fecha a la que se quiere Analizar
         * @return retorna un string informado si el empleado tiene un horario de inicio en esa fecha
         */
        public function actionHorarioenfecha() {
            $idempleado=$_POST['idempleado'];
            $fecha=$_POST['fecha'];
            $resp= Yii::app()->rrhh
                    ->createCommand("select case when (select count(*) from movimientopersonal where eliminado=false and idempleado=$idempleado and fechaini='$fecha')=0 then''else 'tiene' end")
                    ->queryScalar();  
            echo $resp;
            return ;
            
        }
        /**
         * @param integer $_POST['idempleado'], id del empleado
         * @param date $_POST['fecha'],fecha en la que se quiere hacer un cambio de horario
         * @return string que notifica si en esa fecha el empleado tiene un horario asignado
         */
        function actionObservacionHorario() {
            $idempleado=$_POST['idempleado'];
            $fecha=$_POST['fecha'];
            $resp= Yii::app()->rrhh
                    ->createCommand("select * from  dame_observacion_horario('$fecha',$idempleado ) ")
                    ->queryScalar();  
             if(strlen($resp)>0){
               echo $resp.'<div class="row"><strong>PASOS:</strong><ol><li>Elimine todos los permisos del listado anterior</li><li>Asigne el nuevo horario</li><li>Reasigne los permisos anteriormente eliminados</li></ol></div>';
             }else{
               echo'';
             }
            return ;
            
        }
        /**
         * @param integer[] $_POST['grilla'], id  de los empleados
         * @param date $_POST['fecha'], fecha a la que se quiere analizar
         * @return string , con la informacion de las empleados que tienen algun tipo de permiso asignado  
         */
        function actionObservacionHorarioEmpleados() {
            $empleados=$_POST['grilla'];
            $fecha=$_POST['fecha'];
            $cadena='';
            for($i=0;$i<count($empleados);$i++){
              if($empleados[$i]['id']!=''){
                    $resp= Yii::app()->rrhh
                    ->createCommand("select * from  dame_observacion_horario('$fecha',".$empleados[$i]['id']." ) ")
                    ->queryScalar();    
                    if($resp!=''){
                        $cadena.='<div class="row"><h5>'.$empleados[$i]['nombrecompleto'].'</h5>'.$resp.'</div>';
                    }
              }
             
             }
             if($cadena!=''){
                 $cadena.='<div class="row"><strong>PASOS:</strong><ol><li>Elimine todos los permisos del listado anterior</li><li>Asigne el nuevo horario</li><li>Reasigne los permisos anteriormente eliminados</li></ol></div>';
          
             }
            echo $cadena;
            return ;
            
        }
       /**
         * @param integer[] $_POST['grilla'], id  de los empleados
         * @param date $_POST['fechadesde], fecha desde, a la que se quiere analizar
         * @param date $_POST['fechahasta], fecha hasta, a la que se quiere analizar
         * @return string , con la informacion de los empleados que tienen algun tipo de permiso asignado  
         */
        function actionObservacionHorarioEntreFechas() {
            $empleados=$_POST['grilla'];
            $fechadesde=$_POST['fechadesde'];
            $fechahasta=$_POST['fechahasta'];
            $cadena='';
            for($i=0;$i<count($empleados);$i++){
              if($empleados[$i]['id']!=''){
                    $resp= Yii::app()->rrhh
                    ->createCommand("select * from  dame_observacion_horario_entrefechas('$fechadesde','$fechahasta',".$empleados[$i]['id']." ) ")
                    ->queryScalar();    
                    if($resp!=''){
                        $cadena.='<div class="row"><h5>'.$empleados[$i]['nombrecompleto'].'</h5>'.$resp.'</div>';
                    }
              }
             
             }
             if($cadena!=''){
                 $cadena.='<div class="row"><strong>PASOS:</strong><ol><li>Elimine todos los permisos del listado anterior</li><li>Asigne el nuevo horario</li><li>Reasigne los permisos anteriormente eliminados</li></ol></div>';
          
             }
            echo $cadena;
            return ;
            
        }
        /**
         * @param integer $_POST['id'], id del horario
         * @param date  $_POST['fecha'], fecha a la que se quiere analizar
         * @return string ,con la informacion de los empleados que tuviensen algun permiso asignado
         */
         function actionObservacionUpdateHorario() {
            $idhorario=$_POST['id'];
            $fecha=$_POST['fecha'];
            $cadena= Yii::app()->rrhh
                    ->createCommand("select dame_observacion_updatehorario('$fecha', $idhorario) ")
                    ->queryScalar(); 
             if($cadena!=''){
                 $cadena.='<div class="row"><strong>PASOS:</strong><ol><li>Elimine todos los permisos del listado anterior</li><li>Asigne el nuevo horario</li><li>Reasigne los permisos anteriormente eliminados</li></ol></div>';
          
             }
            echo $cadena;
            return ;
            
        }
}
