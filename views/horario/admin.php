<?php

/* @var $this HorarioController */
/* @var $model Horario */

echo System::Search(array(
    'title' => 'Administración de Horarios',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admHorario',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'nombre',
		'width' => 45,
		),
		
		
		array(
		'name' => 'estado',
		'width' => 20,
		'value'=>'$data->estado==1?"VIGENTE":"NO VIGENTE"',
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
                    'width' => 15,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                        'eliminarempleado' => array('click' => 'function () {SGridView.selectRow(this); admHorario.asignarempleado(); return false;}', 'icon' => 'list','label'=>'Asignar Empleado a Horario'),
                                              
                        'update' => array('label' => 'Modificar Horario' ),
                        
                        'delete' => array('label' => 'Eliminar'),
                                    ),
		),
	),
    ))
));

