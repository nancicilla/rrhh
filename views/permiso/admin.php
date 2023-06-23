<?php

/* @var $this PermisoController */
/* @var $model Permiso */

echo System::Search(array(
    'title' => 'Administración de Permisos',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admPermiso',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'idempleado',
		'width' => 23,
		'value'=>'$data->idempleado0->idpersona0->apellidop." ".$data->idempleado0->idpersona0->apellidom." ".$data->idempleado0->idpersona0->nombre'
		),
		array(
		'name' => 'idtipopermiso',
		'width' => 15,
		'value'=>'$data->idtipopermiso0->nombre'
		),
		array(
		'name' => 'tipo',
		'width' => 5,
		'value'=>'$data->tipo?"Hora":"Día"',
		),
		array(
		'name' => 'horai',
		'width' => 11,
                'header'=>'Horas',
		
		'value'=>'$data->tipo?$data->horai." - ".$data->horaf :""',
		),
		
		array(
		'name' => 'fechai',
		'width' => 10,
		'value'=>' date ("d-m-Y",strtotime( $data->fechai))',
		),
		array(
		'name' => 'fechaf',
		'width' => 10,
		'value'=>' $data->tipo?"": date ("d-m-Y",strtotime( $data->fechaf))',
		),
                array(
		'name' => 'conconstancia',
		'width' => 6,
                'split' => false,
		'value' => '$data->conconstancia == true?"<span style=\'color: white;\' class=\'label label-success\'>Si</span>" :"<span style=\'color: white\' class=\'label label-info\'>No</span>" ',
       
                    ),
		array(
		'name' => 'usuario',
		'width' => 4,
		),
        array(
                'name'=>'fecha',
                'type' => 'date', 
                'value'=>'date ("d-m-Y",strtotime( $data->fecha))',
                'width'=> 10,
                ),    
		
                array('typeCol' => 'buttons',
                    'width' => 6,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' =>array(
                                   
                        'delete' => array('label' => 'Eliminar'),
                        'update' => array('label' => 'Modificar')
                         ,'conconstancia' => array(
                                        'label' => 'Constancia',
                             'visible' => Yii::app()->user->checkAccess('action_rrhh_permiso_constancia').'==1',
                      
                                        'icon' => 'ok',
                                        'click' =>'                                                        
                                        function(){
                                            SGridView.selectRow(this);
                                            admPermiso.Constancia();
                                            return false;
                                        }',
                                    ),
                        'Imprimir' => array('url' => 'array("imprimirPermiso","id"=>SeguridadModule::enc($data->getPrimaryKey()))','label'=>'Imprimir Permiso', 'icon' => 'print', 'options' => array('target' => '_blank')),
                         
                                    ),
		),
	),
    ))
));

