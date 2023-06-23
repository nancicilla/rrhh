<?php

/* @var $this OtrosgastosController */
/* @var $model Otrosgastos */

echo System::Search(array(
    'title' => 'Administración de Otros Gastos',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admOtrosgastos',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
		'name' => 'idempleado',
                'value'=>'$data->idempleado==""?"":$data->idempleado0->idpersona0->nombrecompleto',
		'width' => 25,
		),
		array(
		'name' => 'nombre',
		'width' => 25,
		),
		array(
		'name' => 'fecharegistro',
                'type' => 'date',
                'value' => 'date ("d-m-Y",strtotime( $data->fecharegistro))',
		'width' => 10,
		),
		array(
		'name' => 'monto',
		'width' => 10,
		),
		array(
                'name' => 'usuario',
                'width' => 10,
                ),
                array(
                    'name' => 'fecha',
                    'type' => 'date',
                    'value' => 'date ("d-m-Y",strtotime( $data->fecha))',
                    'width' => 10,
                ),
                array('typeCol' => 'buttons',
                    'width' => 10,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                    'update' => array('label' => 'Modificar','visible' => 'Otrosgastos::model()->MostrarElemento(SeguridadModule::enc($data->getPrimaryKey()))',
                       ),
                                    'delete' => array('label' => 'Eliminar','visible' => 'Otrosgastos::model()->MostrarElemento(SeguridadModule::enc($data->getPrimaryKey()))',
                       ),
                                    ),
		),
	),
    ))
));

