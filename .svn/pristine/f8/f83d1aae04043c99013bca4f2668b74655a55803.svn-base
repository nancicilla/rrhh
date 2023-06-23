<?php

/* @var $this MovimientopersonalController */
/* @var $model Movimientopersonal */

echo System::Search(array(
    'title' => 'Administración Modificar Contrato/Horario',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admMovimientopersonal',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
         array(
         'header'=>'Empleado',
		'name' => 'idempleado',
		'value'=>'$data->idempleado0==null?"":$data->idempleado0->idpersona0->apellidop." ".$data->idempleado0->idpersona0->apellidom." ".$data->idempleado0->idpersona0->nombre',
		'width' => 60,
		),
		array(
		'name' => 'fechaini',
			//'value'=>' date_format( $data->fechaini,"d-m-Y")',
		'value'=>' date ("d-m-Y",strtotime( $data->fechaini))',
		'width' => 10,
		),
		
		array(
		'name' => 'usuario',
		'width' => 10,
		),
		 array(
		 	'header'=>'Fecha',
                'name'=>'fecha',
                'type' => 'date', 
                'width'=> 10,
                'value'=>'date("d-m-Y",strtotime($data->fecha))',
                ),
		
                array('typeCol' => 'buttons',
                    'width' => 10,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                   
					'delete' => array('label' => 'Eliminar', 'visible' => 'Movimientopersonal::model()->mostrarBorrar(SeguridadModule::enc($data->getPrimaryKey()))',),
                         'CambiarHorario' => array(                       
                        'click' => 'function () {   SGridView.selectRow(this); admMovimientopersonal.CambiarHorario(); return false;}', 'visible' => 'Movimientopersonal::model()->mostrarBorrar(SeguridadModule::enc($data->getPrimaryKey()))', 'label' => 'Cambiar Horario', 'icon' => 'calendar'),
									),
		),
	),
    ))
));

