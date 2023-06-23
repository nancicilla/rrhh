<?php

/* @var $this EmpleadoController */
/* @var $model Empleado */
//var_dump($model->search());
//var_dump($model);
echo System::Search(array(
    'title' => 'Administración Asistencia',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admEmpleado',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(

	array(

		'name' => 'id',
			'typeCol' => 'hidden',
		'value'=>'SeguridadModule::enc($data->id)',	
		
		),
	array(

		'name' => 'empleado',
		'width' => 25,
		'value'=>'$data->estadoempleado',
	'split' => false,
		
		),
		array(

		'name' => 'observacion',
		'header'=>'Observación',
		'width' => 20,
		'value'=>'$data->observacion',
	'split' => false,
		
		),
		array(

		'name' => 'significadocolor',
		'header'=>'Significado Color',
		'width' => 20,
		'value'=>'$data->significadocolor',
	'split' => false,
		
		),
		
                array('typeCol' => 'buttons',
                    'width' => 10,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                    'update' => array('label' => 'Modificar'),
                                    ),
		),
	),
    ))
));

