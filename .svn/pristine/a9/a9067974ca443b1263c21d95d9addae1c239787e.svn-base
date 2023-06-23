<?php

/* @var $this PuestotrabajoController */
/* @var $model Puestotrabajo */
 
echo System::Search(array(
    'title' => 'Administración de Puesto de Trabajos',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admPuestotrabajo',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'nombre',
		'width' => 20,
		),
		
		array(
		
		'name' => 'idseccion',
		'width' => 30,
		'value'=>'$data->idseccion0->nombre." (".$data->idseccion0->idarea0->idunidad0->nombre." - ".$data->idseccion0->idarea0->nombre.")"',
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

