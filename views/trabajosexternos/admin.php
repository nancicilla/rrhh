<?php

/* @var $this TrabajosexternosController */
/* @var $model Trabajosexternos */

echo System::Search(array(
    'title' => 'Administración de Trabajos Externos',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admTrabajosexternos',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		  array(
		'name' => 'idempleado',
		'width' => 30,
		'value'=>'$data->idempleado0->idpersona0->apellidop." ".$data->idempleado0->idpersona0->apellidom." ". $data->idempleado0->idpersona0->nombre'
		),
		array(
		'name' => 'fechadesde',
		'width' => 10,
		'value'=>'date ("d-m-Y",strtotime( $data->fechadesde))'
		),
		array(
		'name' => 'fechahasta',
		'width' => 10,
		'value'=>'date ("d-m-Y",strtotime( $data->fechahasta))'
		),
            array(
		'name' => 'horainicio',
		'width' =>10,
		
		'value'=>'$data->tipo?$data->horainicio :""',
		),
		array(
		'name' => 'horafin',
		'width' => 10,

		'value'=>'$data->tipo?$data->horafin :""',
		),
		
		
		array(
		'name' => 'usuario',
		'width' => 8,
		),
		  array(
                'name'=>'fecha',
                'type' => 'datetime', 
                'value'=>'date ("d-m-Y H:i:s",strtotime( $data->fecha))',
                'width'=> 12,
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

