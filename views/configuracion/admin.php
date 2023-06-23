<?php

/* @var $this ConfiguracionController */
/* @var $model Configuracion */

echo System::Search(array(
    'title' => 'Administración de Configuraciones',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admConfiguracion',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'nombre',
		'width' => 30,
		),
        array(
        'name' => 'sigla',
        'width' => 10,
        ),
        array(
        'header'=>'Aplicable a ',
        'name' => 'para',
        'width' => 10,
        ),
		array(
		'name' => 'descripcion',
		'width' => 30,
		),
		array(
		'name' => 'usuario',
		'width' => 10,
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

