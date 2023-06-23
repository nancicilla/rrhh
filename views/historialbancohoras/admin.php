<?php

/* @var $this HistorialbancohorasController */
/* @var $model Historialbancohoras */

echo System::Search(array(
    'title' => 'Administración de Historial Banco Horas',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admHistorialbancohoras',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
			array(
				'name' => 'idempleado',
				'width' => 23,
				'value'=>'$data->idempleado0==null?"":$data->idempleado0->idpersona0->apellidop." ".$data->idempleado0->idpersona0->apellidom." ".$data->idempleado0->idpersona0->nombre',
				),
			
		array(
					'name'=>'fechadesde',
					'type' => 'date', 
					'value'=>'  date ("d-m-Y",strtotime( $data->fechadesde))',
					'width'=> 8,
					),
		array(
						'name'=>'fechahasta',
						'type' => 'date', 
						'value'=>'  date ("d-m-Y",strtotime( $data->fechahasta))',
						'width'=> 8,
						),
            array(
		'name' => 'horainicio',
		'width' => 5,
		'header'=>'Hora Inicial',
		'value'=>'$data->tipo?$data->horainicio :""',
		),
		array(
		'name' => 'horafin',
                'header'=>'Hora Final',
		'width' => 5,

		'value'=>'$data->tipo?$data->horafin :""',
		),
		array(
			'name' => 'cantminfavor',
			'width' => 5,
		),array(
			'name' => 'cantmincontra',
			'width' => 5,
		),
            array(
			'name' => 'descripcion',
			'width' => 15,
		),

		array(
				'name' => 'usuario',
				'width' => 8,
		),
		array(
			'name'=>'fecha',
			'type' => 'datetime', 
			'value'=>'  date ("d-m-Y H:i:s",strtotime( $data->fecha))',
			'width'=> 12,
			), 
		
                array('typeCol' => 'buttons',
                    'width' => 6,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                   
                                    'delete' => array('label' => 'Eliminar'),
                        'update' => array('label' => 'Modificar'),
                        'Imprimir' => array('url' => 'array("imprimirBanchohora","id"=>SeguridadModule::enc($data->getPrimaryKey()))','label'=>'Imprimir Permiso', 'icon' => 'print', 'options' => array('target' => '_blank')),
                   
                                    ),
		),
	),
    ))
));

