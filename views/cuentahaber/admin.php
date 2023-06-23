<?php

/* @var $this CuentahaberController */
/* @var $model Cuentahaber */

echo System::Search(array(
    'title' => 'Administración de Cuenta Sueldo y Salario',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admCuentahaber',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
        
        'name' => 'idcuenta',
        'width' => 30,
        'value'=>'($data->idcuenta==null)?"": str_replace(".","",$data->idcuenta0->numero)." - ". $data->idcuenta0->nombre',

        ),
		array(
		'name' => 'descripcion',
		'width' => 40,
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

