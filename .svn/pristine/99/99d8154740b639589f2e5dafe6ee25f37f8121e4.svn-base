<?php

/* @var $this TipopermisoController */
/* @var $model Tipopermiso */

echo System::Search(array(
    'title' => 'Administración de Tipo Permisos con Goce de Haber',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admTipopermiso',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'nombre',
		'width' => 30,
		),
		array(
		'name' => 'descripcion',
		'width' => 40,
		),
		array(
		'name' => 'efecto',
		'width' => 10,
		'value'=>'($data->efecto==true)?"Con Efecto en Planilla":"Sin Efecto en Planilla"'
		),
		array(
		'name' => 'valore',
		'width' => 10,
		'value'=>'($data->efecto==true)?"Descuento ".$data->valore." vez(ces) el periodo de ausencia":"N/A"'
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

