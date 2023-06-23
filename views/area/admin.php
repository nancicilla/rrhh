<?php

/* @var $this AreaController */
/* @var $model Area */

echo System::Search(array(
    'title' => 'Administración de Areas',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admArea',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'sigla',
		'width' => 5,
		),
		array(
		'name' => 'nombre',
		'width' => 30,
		),
		array(
		'name' => 'idunidad',
		'width' => 15,
		'value'=>'$data->idunidad0->nombre',
		),
	array(
		'header'=>'Cuenta',
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

