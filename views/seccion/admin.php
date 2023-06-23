<?php

/* @var $this SeccionController */
/* @var $model Seccion */

echo System::Search(array(
    'title' => 'Administración de Seccion',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admSeccion',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'sigla',
		'width' => 10,
		),
		array(
		'name' => 'nombre',
		'width' => 20,
		),
		array(
		'name' => 'idarea',
		'width' => 20,
		'value'=>'$data->idarea0->nombre." (".$data->idarea0->idunidad0->nombre.")"',
		),
		array(
		'name' => 'idcuenta',

		'width' => 20,
		'value'=>'($data->idcuenta==null)?"": str_replace(".","",$data->idcuenta0->numero)." - ". $data->idcuenta0->nombre',

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
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                    'update' => array('label' => 'Modificar'),
                                     'delete' => array('label' => 'Eliminar'),
                                   
                                    ),
		),
	),
    ))
));

