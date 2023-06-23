<?php

/* @var $this LactanciaController */
/* @var $model Lactancia */

echo System::Search(array(
    'title' => 'Administración de Lactancias',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admLactancia',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'idempleado',
		'value'=>'$data->idempleado0 == null?"":$data->idempleado0->idpersona0->apellidop." ".$data->idempleado0->idpersona0->apellidom." ".$data->idempleado0->idpersona0->nombre',
		'width' => 30,
		),
		array(
		'name' => 'fechadesde',
		'value'=>'date("d-m-Y",strtotime($data->fechadesde))',
		'width' => 20,
		),
		array(
		'name' => 'fechahasta',
		'value'=>'date("d-m-Y",strtotime($data->fechahasta))',
		'width' => 20,
		),
		array(
		'name' => 'rangohora',
		'width' => 20,
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

