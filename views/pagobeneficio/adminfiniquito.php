<?php

/* @var $this PagobeneficioController */
/* @var $model Pagobeneficio */

echo System::Search(array(
    'title' => 'Administración de Finiquitos',
    'formSearch' => $this->renderPartial('_searchfiniquito', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admFiniquito',
        'dataProvider' => $model->searchfiniquito(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'idhistorialestadoempleado',
                'width' => 33,
                'value' => '$data->idhistorialestadoempleado0->idempleado0->idpersona0->apellidop." ".$data->idhistorialestadoempleado0->idempleado0->idpersona0->apellidom." ".$data->idhistorialestadoempleado0->idempleado0->idpersona0->nombre'
            ),
            array(
                'name' => 'fechadesde',
                'width' => 10,
                'type' => 'date',
                'value' => '$data->fechadesde',
            ),
            array(
                'name' => 'fechahasta',
                'width' => 10,
                'type' => 'date',
                'value' => '$data->fechahasta',
            ),
            array(
                'name' => 'estado',
                'width' => 10,
                'value' => ' $data->estado==1?"Finiquito Generado":"Finiquito Consolidado"',
            ),
            array(
                'name' => 'fechapago',
                'width' => 10,
                 'value'=>'  date ("d-m-Y",strtotime( $data->fechapago))',
            ),
            array(
                'name' => 'monto',
                'width' => 10,
                'align' => 'right', 
            ),
            array(
                'name' => 'usuario',
                'width' => 10,
            ),
            array('typeCol' => 'buttons',
                'width' => 7,
                'deleteConfirmation' => '¿Seguro que desea eliminar este elemento?',
                'buttons' => array(
                    'update' => array('label' => 'Modificar Abonos,Deducciones,RC-IVA', 'visible' => 'Pagobeneficio::model()->MotrarElemento(SeguridadModule::enc($data->getPrimaryKey()))',
                        'click' => '                                                        
										function(){
											SGridView.selectRow(this);
											admFiniquito.ModificarParametrosFiniquito();
											return false;
										}',
                    ),
                    'Imprimir' => array('url' => 'array("descargarFiniquito","id"=>SeguridadModule::enc($data->getPrimaryKey()))', 'label' => 'Descargar Finiquito', 'icon' => 'download-alt', 'options' => array('target' => '_blank')),
                    'consolidarfiniquito' => array(
                        'label' => 'Consolidar Finiquito',
                        'icon' => 'ok',
                        'visible' => 'Pagobeneficio::model()->MotrarElemento(SeguridadModule::enc($data->getPrimaryKey()))',
                        'click' => '                                                        
										function(){
											SGridView.selectRow(this);
											admFiniquito.ConsolidarFiniquito();
											return false;
										}',
                    ),
                    'Imprimircns' => array( 
                        'label' => 'Descargar Baja CNS', 
                        'icon' => 'print',
               'visible' => '!( Pagobeneficio::model()->MotrarElemento(SeguridadModule::enc($data->getPrimaryKey())))',
                    
               'click' =>'                                                        
                        function(){
                            SGridView.selectRow(this);
                            admFiniquito.DescargarBajaCNS();
                            return false;
                        }',
                       'options' => array('target' => '_blank')),
                 
                    'delete' => array('label' => 'Eliminar', 'visible' => 'Pagobeneficio::model()->MotrarElemento(SeguridadModule::enc($data->getPrimaryKey()))',
                    ),
                ),
            ),
        ),
    ))
));

