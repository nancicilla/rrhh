<?php

/* @var $this TmpentradasalidaController */
/* @var $model Tmpentradasalida */

echo System::Search(array(
    'title' => 'Administración de Tmpentradasalidas',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admTmpentradasalida',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'ci',
		'width' => 30,
		),
		array(
		'name' => 'usuario',
		'width' => 30,
		),
		/*
		*/
		/*   
                array(
                'name'=>'sellada',
                'type' => 'datetime', 
                'width'=> 30,
                ),    
   
                array(
                'name'=>'fecha',
                'type' => 'datetime', 
                'width'=> 30,
                ),    
		*/
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

