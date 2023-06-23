<?php

/* @var $this EntradasalidaController */
/* @var $model Entradasalida */
 
//            echo '==>> '.$model->scenario;
      // var_dump($model->search());
echo System::Search(array(
    'title' => 'Administración de Control Sellada',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
     
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admEntradasalida',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
        array(

		'name' => 'id',
		'typeCol' => 'hidden',

		'value'=>'SeguridadModule::enc($data->id)'
		),
		
        array(
        'name' => 'idempleado',
        'width' => 40,
        //'value'=>'Entradasalida::damemensaje($data->idempleado,$data->fecha) ',
        'value'=>'$data->idempleado0->idpersona0->apellidop." ".$data->idempleado0->idpersona0->apellidom." ".$data->idempleado0->idpersona0->nombre ',
        ),
        array(
        'name'=>'fecha',
        'width' => 10,
       'value'=>'  date ("d-m-Y",strtotime( $data->fecha))',
       
        ),
        array(
        'name'=>'entrada',
        'width' => 15,
        'value'=>'$data->entrada',
       
        ),  
         array(
        'name'=>'salida',
        'width' => 15,
         'value'=>'$data->salida',
        //'value'=>'Entradasalida::damemensaje($data->idempleado,$data->fecha) ',
      
        ),
		
		
		
                array('typeCol' => 'buttons',
                    'width' => 20,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                'delete' => array('label' => 'Eliminar Sellada',
                                      'visible' => 'Entradasalida::model()->MostrarBajasellada(SeguridadModule::enc($data->getPrimaryKey()))',
              
                                    'click' => 'function () {SGridView.selectRow(this); admEntradasalida.bajasellada(); return false;}'),
                                'deletesinsalida' => array('label' => 'Eliminar Sellada', 'icon' => 'trash',
                                      'visible' => '!Entradasalida::model()->MostrarBajasellada(SeguridadModule::enc($data->getPrimaryKey()))',
              
                                    'click' => 'function () {SGridView.selectRow(this); admEntradasalida.bajaselladasinsalida();return false;}'),
                                       
                        ),
		),
	),
    ))
));

