<?php

/* @var $this FeriadoController */
/* @var $model Feriado */

echo System::Search(array(
    'title' => 'Administración de Feriados',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admFeriado',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'nombre',
		'width' => 30,
		),
		array(
		'name' => 'fechafestividad',
		'width' => 10,
                'value'=>'date ("d-m-Y",strtotime( $data->fechafestividad))'
		),
		array(
		'name' => 'descripcion',
		'width' => 40,
		),
		array(
		'name' => 'usuario',
		'width' => 10,
		),
		
                array('typeCol' => 'buttons',
                    'width' => 5,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                    'update' => array('label' => 'Modificar',
                                                     'visible' => 'Feriado::model()->MostrarElemento(SeguridadModule::enc($data->getPrimaryKey()))',
                       ),
                                    'delete' => array('label' => 'Eliminar',
                                                 'visible' => 'Feriado::model()->MostrarElemento(SeguridadModule::enc($data->getPrimaryKey()))',
                                        ),
                                    ),
		),
	),
    ))
));

