<?php

/* @var $this BonosController */
/* @var $model Bonos */

echo System::Search(array(
    'title' => 'Administración de Bonos Puesto Trabajo',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admBonos',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'nombre',
		'width' => 30,
		),
array(

        'name' => 'enplanilla',
        'width' => 10,
        'value'=>'$data->enplanilla==true?"Planilla General":"Planilla Individual"'
        ),

		array(

        'name' => 'estado',
        'width' => 10,
        'value'=>'$data->vigente==true?"VIGENTE":" NO VIGENTE"'
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
        'value'=>'date ("d-m-Y",strtotime( $data->fecha))',
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

