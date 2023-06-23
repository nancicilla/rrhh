<?php

/* @var $this HistorialestadoempleadoController */
/* @var $model Historialestadoempleado */

echo System::Search(array(
    'title' => 'Administración de Historial Estado Empleado',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admHistorialestadoempleado',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
        	array(
		'name' => 'idempleado',
		'width' => 22,
		'value'=>'$data->idempleado0==null?"":$data->idempleado0->idpersona0->apellidop." ".$data->idempleado0->idpersona0->apellidom." ".$data->idempleado0->idpersona0->nombre',
		),
		array(
		'name' => 'fechaantiguedad',
		 'value'=>'date ("d-m-Y",strtotime( $data->fechaantiguedad))',
                'width'=> 9,
		),
		array(
		'name' => 'fechaplanilla',
		 'value'=>'date ("d-m-Y",strtotime( $data->fechaplanilla))',
                'width'=> 9,
		),
		array(
		'name' => 'fechaultidemnizacion',
		 'value'=>'date ("d-m-Y",strtotime( $data->fechaultidemnizacion))',
                'width'=> 9,
		),
            	array(
		'name' => 'fechavacacion',
		 'value'=>'date ("d-m-Y",strtotime( $data->fechavacacion))',
                'width'=> 9,
		),
		array(
		'name' => 'fecharetiro',
		'value'=>' $data->fecharetiro==null?"": date ("d-m-Y",strtotime( $data->fecharetiro))',
                'width'=> 9,
		),
                array(
                   'header'=>'Estado',
		'name' => 'activo',
		'value'=>' $data->activo==1?"Activo": "No Activo"',
                'width'=> 9,
		),
		array(
		'name' => 'usuario',
		'width' => 9,
		),
		array(
                'name'=>'fecha',
                'type' => 'datetime', 
                'value'=>'date ("d-m-Y",strtotime( $data->fecha))',
                'width'=> 10,
                ),
                array('typeCol' => 'buttons',
                    'width' => 5,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                        'update' => array('label' => 'Modificar Fecha Vacacion','visible' => 'Historialestadoempleado::model()->MostrarEdicion(SeguridadModule::enc($data->getPrimaryKey()))',),
                         'afiliciacionCNS' => array('label' => 'Afiliciacion Caja de Salud','icon'=>'download-alt',
                         'visible' => 'Historialestadoempleado::model()->MostrarAfiliacion(SeguridadModule::enc($data->getPrimaryKey()))',
                       'click' =>' function(){
											SGridView.selectRow(this);
											admHistorialestadoempleado.DescargarAfiliacionCNS();
											return false;
										}',                         
                             
                             ),
               
                            				
								
                                    ),
		),
	),
    ))
));

