<?php

/* @var $this RepresentanteController */
/* @var $model Representante */

echo System::Search(array(
    'title' => 'Administración de Representantes',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admRepresentante',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'header'=>'C.I.',
		'name' => 'cirepresentante',
		'width' => 30,
		),
		array(
		'header'=>'Nombre Completo',
		'name' => 'nrepresentante',
		'width' => 60,
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

