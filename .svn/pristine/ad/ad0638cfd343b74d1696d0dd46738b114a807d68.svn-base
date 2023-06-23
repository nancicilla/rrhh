<?php

/* @var $this SeguimientoempleadoController */
/* @var $model Seguimientoempleado */

echo System::Search(array(
    'title' => 'Administración de Seguimiento Empleado',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admSeguimientoempleado',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(           
		
		array(                   
		'name' => 'idcrugeuser',
                'value'=>'Seguimientoempleado::dameNombreUsuario($data->idcrugeuser)',
		'width' => 30,
		),
		array(
		'name' => 'usuario',
		'width' => 30,
		),
		   
                array(
                'name'=>'fecha',
                'type' => 'datetime', 
                'width'=> 30,
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

