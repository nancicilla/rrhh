<?php

/* @var $this PagobeneficioController */
/* @var $model Pagobeneficio */

echo System::Search(array(
    'title' => 'Administración Quinquenios',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admPagobeneficio',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
				'name' => 'idhistorialestadoempleado',
				'width' => 30,
				'value'=>'$data->idhistorialestadoempleado0->idempleado0->idpersona0->apellidop." ".$data->idhistorialestadoempleado0->idempleado0->idpersona0->apellidom." ".$data->idhistorialestadoempleado0->idempleado0->idpersona0->nombre'
				),
		array(
		'name' => 'numpago',
		'width' => 10,
		),
		array(
		'name' => 'fechasolicitud',
		'width' => 10,
		'type' => 'date',
        'value'=>' $data->fechasolicitud == null?"": date ("d-m-Y",strtotime( $data->fechasolicitud))',
		),
		array(
		'name' => 'fechadesde',
		'width' => 10,
		'type' => 'date',
        'value'=>'  date ("d-m-Y",strtotime( $data->fechadesde))',
		),
         
		array(
		'name' => 'fechahasta',
		'width' => 10,
		'type' => 'date',
        'value'=>'  date ("d-m-Y",strtotime( $data->fechahasta))',
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
                                    'update' => array('label' => 'Modificar','visible' => 'Pagobeneficio::model()->MotrarElemento(SeguridadModule::enc($data->getPrimaryKey()))',
								),
									
		   'Imprimir' => array('url' => 'array("descargarBoletaQuinquenio","id"=>SeguridadModule::enc($data->getPrimaryKey()))', 'label' => 'Descargar Boleta Beneficio', 'icon' => 'download', 'options' => array('target' => '_blank')),
		     'reporteQuinquenio' => array('url' => 'array("descargarReporteQuinquenio","id"=>SeguridadModule::enc($data->getPrimaryKey()))', 'label' => 'Descargar Reporte Quinquenio',
										
									 'icon' => 'download-alt', 'options' => array('target' => '_blank')),
		  
                        'consolidarquinquenio' => array(
										'label' => 'Consolidar Quinquenio',
										'icon' => 'ok',
										'visible' => 'Pagobeneficio::model()->MotrarElemento(SeguridadModule::enc($data->getPrimaryKey()))',
										'click' =>'                                                        
										function(){
											SGridView.selectRow(this);
											admPagobeneficio.ConsolidarQuinquenio();
											return false;
										}',
										
									),
									'delete' => array('label' => 'Eliminar','visible' => 'Pagobeneficio::model()->MotrarElemento(SeguridadModule::enc($data->getPrimaryKey()))',
								),
                                    ),
		),
	),
    ))
));

