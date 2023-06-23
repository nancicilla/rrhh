<?php

/* @var $this UnidadController */
/* @var $model Unidad */

echo System::Search(array(
    'title' => 'Administración de Unidades',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admUnidad',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'nombre',
		'width' => 25,
		),
		array(
		'name' => 'lciudad',
		'width' => 20,
		),
		array(
			'header'=>'Cuenta',
		'name' => 'idcuenta',

		'width' => 25,		
		'value'=>'($data->idcuenta==null)?"": str_replace(".","",$data->idcuenta0->numero)." - ". $data->idcuenta0->nombre'
			),
		array(
		'name' => 'usuario',
		'width' => 10,
		),
		array(
        'name'=>'fecha',
        'type' => 'datetime',
        'value'=>'  date ("d-m-Y",strtotime( $data->fecha))',
        'width'=> 10,
        ),   
                array('typeCol' => 'buttons',
                    'width' => 10,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elementok?',
                    'buttons' => 	array(
                                    'update' => array('label' => 'Modificar'),

                                     'delete' => array('url' => 'array("delete","id" => SeguridadModule::enc($data->getPrimaryKey()))', 'label' => 'Eliminar'),

                                  
                                    ),
		),
	),
    ))
));

