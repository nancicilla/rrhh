<?php

/* @var $this NivelsalarialController */
/* @var $model Nivelsalarial */

echo System::Search(array(
    'title' => 'Administración de Niveles Salariales',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admNivelsalarial',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'nombre',
		'width' => 50,
		),
		array(
		'name' => 'sueldo',
		'width' => 20,
		),
		array(
		'name' => 'usuario',
		'width' => 10,
		),
         array(
                'name'=>'fecha',
                'type' => 'date', 
                'width'=> 10,
                'value'=>'date("d-m-Y",strtotime($data->fecha))',
                ), 
		
                array('typeCol' => 'buttons',
                    'width' => 10,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                    'update' => array('label' => 'Modificar'),
                                    'delete' => array('label' => 'Eliminar'),
                                    ),
		),
	),
    ))
));

