<?php

/* @var $this EmpresasubempleadoraController */
/* @var $model Empresasubempleadora */

echo System::Search(array(
    'title' => 'Administración de Empresas Subempleadoras',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admEmpresasubempleadora',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'nombre',
		'width' => 20,
		),
               array(
		'name' => 'fee',
		'width' => 10,
		),
            array(
		'name' => 'impuesto',
		'width' => 10,
		),
                array(
		'header'=>'Cuenta Cliente',
		'name' => 'cuentacliente',

		'width' => 20,		
		'value'=>'($data->cuentacliente==null)?"": str_replace(".","",$data->cuentacliente0->numero)." - ". $data->cuentacliente0->nombre'
			),
            array(
		'header'=>'Cuenta Venta',
		'name' => 'cuentaventa',

		'width' => 20,		
		'value'=>'($data->cuentaventa==null)?"": str_replace(".","",$data->cuentaventa0->numero)." - ". $data->cuentaventa0->nombre'
			),
		array(
		'name' => 'usuario',
		'width' => 10,
		),
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
                                    'update' => array('label' => 'Modificar'),
                                    'delete' => array('label' => 'Eliminar'),
                                    ),
		),
	),
    ))
));

