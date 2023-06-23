<?php

/* @var $this VacacionesController */
/* @var $model Vacaciones */

echo System::Search(array(
    'title' => 'Administración de Vacaciones',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admVacaciones',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
        array(
		'name' => 'idempleado',
		'width' => 20,
		'value'=>'$data->idempleado0->idpersona0->apellidop." ".$data->idempleado0->idpersona0->apellidom." ". $data->idempleado0->idpersona0->nombre'
		),
		array(
		'name' => 'fechadesde',
		'width' => 10,
		'value'=>'date ("d-m-Y",strtotime( $data->fechadesde))'
		),
		array(
		'name' => 'fechahasta',
		'width' => 10,
		'value'=>'date ("d-m-Y",strtotime( $data->fechahasta))'
		),
            array(
		'name' => 'horai',
		'width' => 5,
		
		'value'=>'$data->tipo?$data->horai :""',
		),
		array(
		'name' => 'horaf',
		'width' => 5,

		'value'=>'$data->tipo?$data->horaf :""',
		),
		array(
		'name' => 'diastomados',
		'width' =>9,
		'value'=>'$data->diastomados',
		),
		array(
		'name' => 'fechaav',
		'width' => 9,
		'value'=>'date ("d-m-Y",strtotime( $data->fechaav))'
		),
		array(
		'name' => 'dias',
		'width' =>9,
		'value'=>'$data->dias',
		),
		array(
		'name' => 'usuario',
		'width' => 9,
		),
		  array(
                'name'=>'fecha',
                'type' => 'datetime', 
                'value'=>'date ("d-m-Y",strtotime( $data->fecha))',
                'width'=> 9,
                ), 
		
                array('typeCol' => 'buttons',
                    'width' => 5,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                   'update' => array('label' => 'Modificar',   'visible' => '$data->diasabono==0'),
                        'actualizarabono' => array('label' => 'Modificar', 'icon' => 'pencil',
                                      'visible' => '$data->diasabono>0',
                                    'click' => 'function () {SGridView.selectRow(this); admVacaciones.actualizarabono();return false;}'),            
                        'delete' => array('label' => 'Eliminar'),
                         'Imprimir' => array('url' => 'array("imprimirVacacion","id"=>SeguridadModule::enc($data->getPrimaryKey()))','label'=>'Imprimir Vacacion', 'visible' => '$data->diasabono==0', 'icon' => 'print', 'options' => array('target' => '_blank')),
                   
                                    ),
		),
	),
    ))
));

