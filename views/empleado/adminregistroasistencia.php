<?php

/* @var $this EmpleadoController */
/* @var $model Empleado */
//var_dump($model->search());
//var_dump($model);
echo System::Search(array(
    'title' => 'Administración Registro de asistencia',
    'formSearch' => $this->renderPartial('_searchregistroasistencia', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admRegistroasistencia',
        'dataProvider' => $model->searchregistroasistencia(),
		'height' => Yii::app()->params['defaultAdminHeight'],
		
        'columns' => array(

	array(

		'name' => 'id',
			'typeCol' => 'hidden',
		'value'=>'SeguridadModule::enc($data->idr)',	
		
		),
	array(

		'name' => 'empleado',
		'width' => 25,
		'value'=>'$data->nombrecompleto',
	'split' => false,
		
		),
		array(

		'name' => 'fecha',
		'header'=>'Fecha',
		'width' => 20,
		'value'=>'$data->fecha',
	'split' => false,
		
		),
		array('typeCol' => 'buttons',
		'width' => 10,
		'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
		'buttons' => 	array(
					
						'delete' => array('label' => 'Eliminar','visible'=>'$data->manual'),
						),
),
		
               
	),
    ))
));

