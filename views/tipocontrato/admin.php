<?php

/* @var $this TipocontratoController */
/* @var $model Tipocontrato */

echo System::Search(array(
    'title' => 'Administración de Tipos de Contratos',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admTipocontrato',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'nombre',
		'width' => 50,
		),        array(
        'name' => 'generarcc',
        'value'=>'($data->generarcc==true)?"Genera C.C.":"No Genera C.C."',
        'width' => 25,
        ),
		array(
		'name' => 'usuario',
		'width' => 15,
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

