<?php

/* @var $this TipobeneficioController */
/* @var $model Tipobeneficio */

echo System::Search(array(
    'title' => 'Administración de Tipos de Beneficios',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admTipobeneficio',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'nombre',
		'width' => 40,
		),
		array(
		'name' => 'tipo',
		'value'=>'($data->tipo=="V")?"VACACIÓN":"BONO"',
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
                                    'delete' => array('label' => 'Eliminar'),
                                    ),
		),
	),
    ))
));

