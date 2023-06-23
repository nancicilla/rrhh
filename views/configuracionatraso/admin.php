<?php

/* @var $this ConfiguracionatrasoController */
/* @var $model Configuracionatraso */

echo System::Search(array(
    'title' => 'Administración de Configuracionatrasos',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admConfiguracionatraso',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'intervaloinicial',
		'width' => 25,
		),
		array(
		'name' => 'intervalofinal',
		'width' => 25,
		),
		array(
		'name' => 'porcentaje',
		'width' => 20,
		),
		array(
		'name' => 'usuario',
		'width' => 10,
		),
                array(
                'name'=>'fecha',
                'type' => 'datetime', 
                'width'=> 10,
                )
		,
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

