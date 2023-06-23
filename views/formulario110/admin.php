<?php

/* @var $this Formulario110Controller */
/* @var $model Formulario110 */

echo System::Search(array(
    'title' => 'Administración de Formulario 110',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admFormulario110',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'idempleado',
                'value'=>'$data->idempleado0->idpersona0->apellidop." ".$data->idempleado0->idpersona0->apellidom." ".$data->idempleado0->idpersona0->nombre',
		
		'width' => 26,
		),
		array(
		'name' => 'fechapresentacion',
		'width' => 8,
                 'value'=>'  date ("d-m-Y",strtotime( $data->fechapresentacion))',
		),
		array(
		'name' => 'montopresentado',
		'width' => 8,
		),
                array(
		'name' => 'montodescontado',
		'width' => 8,
		),
                array(
		'name' => 'saldo',
		'width' => 10,
		),
		array(
		'name' => 'porcentaje',
		'width' => 5,
		),
		array(
                'name' => 'usuario',
                'width' =>10,
                ),
                array(
                    'name' => 'fecha',
                    'type' => 'datetime',
                    'width' => 15,
                    'value' => 'date ("d-m-Y H:i:s",strtotime( $data->fecha))',
                ),
		
                array('typeCol' => 'buttons',
                    'width' => 10,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                    'update' => array('label' => 'Modificar','visible' => 'Formulario110::model()->MostrarBoton(SeguridadModule::enc($data->getPrimaryKey()))'),
                                    'delete' => array('label' => 'Eliminar', 'visible' => 'Formulario110::model()->MostrarBoton(SeguridadModule::enc($data->getPrimaryKey()))',)
                    
                                    ),
		),
	),
    ))
));

