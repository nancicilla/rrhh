<?php

/* @var $this BonoliberalidadController */
/* @var $model Bonoliberalidad */

echo System::Search(array(
    'title' => 'Administración de Bonos Especiales',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admBonoespecial',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'nombre',
		'width' => 20,
		),
		array(
		'name' => 'fechadesde',
		'width' => 10,
		'value'=>' date ("d-m-Y",strtotime( $data->fechadesde))',
		),
		array(
		'name' => 'fechahasta',
		'width' => 10,
		'value'=>' date ("d-m-Y",strtotime( $data->fechahasta))',
		),
                array(
		'name' => 'monto',
		'width' => 10,
		),
		
                array(
		'name' => 'fecha',
		'width' => 10,
		'value'=>' date ("d-m-Y",strtotime( $data->fecha))',
		),		
                array('typeCol' => 'buttons',
                    'width' => 10,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' =>array(
                            'Listado' => array('click' => 'function () {SGridView.selectRow(this); admBonoespecial.Listaempleado(); return false;}',
                                               'icon' => 'list', 'label' => 'Lista de Empleados',
                                               'visible' => 'Bonoespecial::model()->MotrarOpcion(SeguridadModule::enc($data->getPrimaryKey()))', ),
                           'Planilla' => array('icon' => 'download-alt', 'label' => 'Planilla',
                                               'visible'=>true,
                                               'click' => 'function () {SGridView.selectRow(this); admBonoespecial.Planilla(); return false;}', 
                        ),
                           
                    'consolidar' => array(
                        'label' => 'Consolidar Bono',
                        'icon' => 'ok',
                        'visible' => 'Bonoespecial::model()->MotrarOpcion(SeguridadModule::enc($data->getPrimaryKey()))',
                        'click' =>'                                                        
                            function(){
                            SGridView.selectRow(this);                            
                            admBonoespecial.Consolidar();
                            return false;
                            }',),                                     
                           
			'delete' => array('label' => 'Eliminar','visible' => 'Bonoespecial::model()->MotrarOpcion(SeguridadModule::enc($data->getPrimaryKey()))',
                       ),
                                    ),
		),
	),
    ))
));

