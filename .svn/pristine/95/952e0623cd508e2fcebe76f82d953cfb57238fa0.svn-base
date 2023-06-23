<?php

/* @var $this PagobeneficioController */
/* @var $model Pagobeneficio */

echo System::Search(array(
    'title' => 'Administración de Aguinaldos de Navidad',
    'formSearch' => $this->renderPartial('_searchaguinaldonavidad', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admAguinaldonavidad',
        'dataProvider' => $model->searchaguinaldonavidad(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		
		array(
		'name' => 'fechapago',
		'width' => 30,
		'type' => 'date',
        'value'=>'  date ("d-m-Y",strtotime( $data->fechapago))',
		),
		
		array(
			'name' => 'usuario',
			'width' => 10,
			),
		array(
                'name'=>'fecha',
                'type' => 'datetime', 
				'width'=> 10,
				'value'=>'  date ("d-m-Y",strtotime( $data->fecha))',
            ),  
			
                array('typeCol' => 'buttons',
                    'width' => 10,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                    'editar'=> array(    
                        'click' => 'function () {                        
                        SGridView.selectRow(this); 
                        admAguinaldonavidad.ActualizarAguinaldonavidad(); return false;}', 
                        'visible' => 'Pagobeneficio::model()->EstadoAguinaldo(SeguridadModule::enc($data->getPrimaryKey()))',
                        'label' => 'Editar Fecha Pago', 'icon' => 'pencil'
                        ),
                       'ReporteMinisterio' => array(    
                        'click' => 'function () {                        
                        SGridView.selectRow(this); 
                        admAguinaldonavidad.PlanillaAguinaldo(); return false;}', 
                        'label' => 'Planilla', 'icon' => 'download-alt'),
                       'Imprimirboleta' => array('url' => 'array("imprimirBoletaAguinaldoNavidad","id"=>SeguridadModule::enc($data->getPrimaryKey()))','label'=>'Imprimir Boletas Aguinaldo Navidad','visible' => '!Pagobeneficio::model()->EstadoAguinaldo(SeguridadModule::enc($data->getPrimaryKey()))',
                         'icon' => 'print', 'options' => array('target' => '_blank')),
             
                      'consolidar' => array(
                        'label' => 'Consolidar Aguinaldo ',
                        'icon' => 'ok',
                        'visible' => 'Pagobeneficio::model()->EstadoAguinaldo(SeguridadModule::enc($data->getPrimaryKey()))',
                        
                        'click' =>'                                                        
                        function(){
                            SGridView.selectRow(this);
                            admAguinaldonavidad.Consolidar();
                            return false;
                        }',
                        
                    ),
                    
                        
								
                                    ),
		),
	),
    ))
));

