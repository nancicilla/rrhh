<?php

/* @var $this HorariolactanciaController */
/* @var $model Horariolactancia */

echo System::Search(array(
    'title' => 'Administración de Horario Lactancia',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admHorariolactancia',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'header'=>'Empleado',
		'name' => 'empleado',
		'width' => 35,
               'value'=>'$data->idsubsidio0==null?"":$data->idsubsidio0->idempleado0->idpersona0->apellidop." ".$data->idsubsidio0->idempleado0->idpersona0->apellidom." ".$data->idsubsidio0->idempleado0->idpersona0->nombre',
		
		),
		array(
		'name' => 'fechadesde',
		'width' => 30,
                'value'=>' date ("d-m-Y",strtotime( $data->fechadesde))',
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
                    'width' => 15,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                        'horario' => array(
                                        'label' => ' Horario de Lactancia',
                                        'icon' => 'calendar',
                                        'click' =>'                                                        
                                        function(){
                                            SGridView.selectRow(this);
                                            admHorariolactancia.HorarioLactancia();
                                            return false;
                                        }',
                                       ),
                                    'update' => array('label' => 'Modificar','visible' => 'Horariolactancia::model()->mostrarBorrar(SeguridadModule::enc($data->getPrimaryKey()))'),
                                    'delete' => array('label' => 'Eliminar','visible' => 'Horariolactancia::model()->mostrarBorrar(SeguridadModule::enc($data->getPrimaryKey()))'),
                                    ),
		),
	),
    ))
));

