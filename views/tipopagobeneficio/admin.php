<?php

/* @var $this TipopagobeneficioController */
/* @var $model Tipopagobeneficio */

echo System::Search(array(
    'title' => 'Administración de Tipo Pago Beneficios',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admTipopagobeneficio',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'nombre',
		'width' => 50,
        ),
        array(
            'name' => 'vigente',
            'width' => 20,
            'value'=>'$data->vigente==true?"Vigente":"No Vigente"'
            ),
		array(
		'name' => 'usuario',
		'width' => 10,
		),
		  
                array(
                'name'=>'fecha',
                'type' => 'datetime', 
                'width'=> 10,
                'value'=>' date ("d-m-Y",strtotime( $data->fecha))',
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

