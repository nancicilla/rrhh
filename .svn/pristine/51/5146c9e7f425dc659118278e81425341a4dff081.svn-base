<?php

/* @var $this PagobeneficioController */
/* @var $model Pagobeneficio */

echo System::Search(array(
    'title' => 'Administración de Segundo Aguinaldos',
    'formSearch' => $this->renderPartial('_searchsegundoaguinaldo', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admSegundoaguinaldo',
        'dataProvider' => $model->searchsegundoaguinaldo(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		
		array(
		'name' => 'fechapago',
		'width' => 50,
		'type' => 'date',
                'value'=>'  date ("d-m-Y",strtotime( $data->fechapago))',
		),
            array(
		'name' => 'porcentaje',
		'width' => 20,
                'value'=>'$data->diasvacacion',
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
                        admSegundoaguinaldo.ActualizarSegundoAguinaldo();
                        return false;}', 
                        'visible' => 'Pagobeneficio::model()->EstadoAguinaldo(SeguridadModule::enc($data->getPrimaryKey()))',
                        'label' => 'Editar Fecha Pago', 'icon' => 'pencil'
                        ),
                       'Reporte' => array(    
                        'click' => 'function () {                        
                        SGridView.selectRow(this); 
                        admSegundoaguinaldo.PlanillaSegundoAguinaldo(); return false;}', 
                        'label' => 'Planilla', 'icon' => 'download-alt'),
                         'Imprimirboleta' => array('url' => 'array("ImprimirBoletaSegundoAguinaldo","id"=>SeguridadModule::enc($data->getPrimaryKey()))','label'=>'Imprimir Boletas Segundo Aguinaldo','visible' => '!Pagobeneficio::model()->EstadoAguinaldo(SeguridadModule::enc($data->getPrimaryKey()))',
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

