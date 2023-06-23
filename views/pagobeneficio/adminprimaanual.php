<?php

/* @var $this PagobeneficioController */
/* @var $model Pagobeneficio */

echo System::Search(array(
    'title' => 'Administración de Prima Anual',
    'formSearch' => $this->renderPartial('_searchprimaanual', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admPrimaanual',
        'dataProvider' => $model->searchprimaanual(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		
		array(
		'name' => 'gestion',
		'width' => 30,
		'value'=>'$data->gestion'
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
			/*
		array(
		'name' => 'fechapago',
		'width' => 30,
		),
		array(
		'name' => 'idtipopagobeneficio',
		'width' => 30,
		),
		array(
		'name' => 'idhistorialestadoempleado',
		'width' => 30,
		),
		array(
		'name' => 'monto',
		'width' => 30,
		),
		array(
		'name' => 'listaplanilla',
		'width' => 30,
		),
		array(
		'name' => 'usuario',
		'width' => 30,
		),
		*/
		/*   
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
		    'Listado' => array('click' => 'function () {SGridView.selectRow(this); admPrimaanual.Listaprimaanual(); return false;}',
                                                    'icon' => 'list', 'label' => 'Lista de Empleados',
                         'visible' => 'Pagobeneficio::model()->MotrarOpcionPrimaAnual(SeguridadModule::enc($data->getPrimaryKey()))',
                     
                        
                        ),
                      'Planilla' => array(     'icon' => 'download-alt', 'label' => 'Planilla',
                          'visible'=>true,
                          'click' => 'function () {SGridView.selectRow(this); admPrimaanual.PlanillaPrima(); return false;}',
                      
                         
                     
                        
                        ),
                           
                    'consolidar' => array(
                        'label' => 'Consolidar Prima Anual',
                        'icon' => 'ok',
                        'visible' => 'Pagobeneficio::model()->MotrarOpcionPrimaAnual(SeguridadModule::enc($data->getPrimaryKey()))',
                        'click' =>'                                                        
                            function(){
                            SGridView.selectRow(this);
                            console.log("asntes");
                            admPrimaanual.Consolidarprimaanual();
                            console.log("despues");
                            return false;
                            }',),
                                        
                             'Imprimirboleta' => array('url' => 'array("imprimirBoletaPrimaAnual","id"=>SeguridadModule::enc($data->getPrimaryKey()))','label'=>'Imprimir Boletas Prima Anual', 'icon' => 'print', 'options' => array('target' => '_blank')),
              
			'delete' => array('label' => 'Eliminar','visible' => 'Pagobeneficio::model()->MotrarOpcionPrimaAnual(SeguridadModule::enc($data->getPrimaryKey()))',
                       ),
								
                                    ),
		),
	),
    ))
));

