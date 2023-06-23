<?php

/* @var $this PlanillaretroactivoController */
/* @var $model Planillaretroactivo */

echo System::Search(array(
    'title' => 'Administración de Planilla Retroactivos',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admPlanillaretroactivo',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
		array(
		'name' => 'mesinicio',
                'value'=>'Planillaretroactivo::model()->dameNombreMes($data->mesinicio) ." ".$data->anio',
		'width' => 25,
		),
		array(
		'name' => 'mesfin',
                'value'=>'Planillaretroactivo::model()->dameNombreMes($data->mesfin) ." ".$data->anio',
		
		'width' =>25,
		),
		array(
		'name' => 'monto',
		'width' => 15,
		),
		array(
		'name' => 'porcentaje',
		'width' => 15,
		),
		
                array('typeCol' => 'buttons',
                    'width' => 20,
                    'deleteConfirmation'=>'¿Seguro que desea eliminar este elemento?',
                    'buttons' => 	array(
                                    'update' => array('label' => 'Modificar', 'visible' => '$data->estado==0?true:false',
                                       ),
                                    'generarplanilla' => array(
                                        'label' => 'Generar Planilla Retroactiva',
                                        'icon' => 'ok',
                                        'visible' => '$data->estado==0 ?true:false',
                                        'click' =>'                                                        
                                        function(){
                                            SGridView.selectRow(this);
                                            admPlanillaretroactivo.GenerarPlanilla();
                                            return false;
                                        }',
                                    ),
                         'descargarplanilla' => array(
                             'url' => 'array("descargarPlanilla","id"=>SeguridadModule::enc($data->getPrimaryKey()))'
                            ,'label'=>'Descargar Planilla',
                             'visible' => '$data->estado>=1 && $data->porsistema==true', 'icon' => 'download-alt',
                             'click' =>'                                                        
                                        function(){
                                            SGridView.selectRow(this);
                                            admPlanillaretroactivo.DescargarPlanilla();
                                            return false;
                                        }'
                                    ),
                         'descargarplanillafiniquito' => array(
                              'url' => 'array("descargarPlanillafiniquito","id"=>SeguridadModule::enc($data->getPrimaryKey()))',
                              'options' => array('target' => '_blank'),
                            'label'=>'Descargar Planilla Finiquito',
                             'visible' => '$data->estado>=1 && $data->porsistema==true',
                             'icon' => 'print',
                               ) ,
                         'descargarplanillaafp' => array(
                              'url' => 'array("descargarPlanillaafp","id"=>SeguridadModule::enc($data->getPrimaryKey()))',
                              'options' => array('target' => '_blank'),
                            'label'=>'Descargar Planilla AFP',
                             'visible' => '$data->estado>=1 && $data->porsistema==true',
                             'icon' => 'print',
                               ),
                        'descargarplanillaafpministerio' => array(
                              'url' => 'array("descargarPlanillaafpministerio","id"=>SeguridadModule::enc($data->getPrimaryKey()))',
                              'options' => array('target' => '_blank'),
                            'label'=>'Descargar Planilla AFP Ministerio',
                             'visible' => '$data->estado>=1 && $data->porsistema==true',
                             'icon' => 'print',
                               ),
                        'descargarplanillaprefactura' => array(
                             'url' => 'array("descargarPlanillaprefactura","id"=>SeguridadModule::enc($data->getPrimaryKey()))'
                            ,'label'=>'Descargar Planilla Prefactura',
                             'visible' => '$data->estado>=2   && $data->porsistema==true', 'icon' => 'download-alt',
                             'click' =>'                                                        
                                        function(){
                                            SGridView.selectRow(this);
                                            admPlanillaretroactivo.DescargarPlanillaprefactura();
                                            return false;
                                        }'
                                    ) ,'consolidarplanilla' => array(
                                        'label' => 'Consolidar Planilla',
                                        'icon' => 'ok',
                                        'visible' => '$data->estado==1 ? true:false',
                                        'click' =>'                                                        
                                        function(){
                                            SGridView.selectRow(this);
                                            admPlanillaretroactivo.ConsolidarPlanilla();
                                            return false;
                                        }',
                                    )
                                     ,'darbajaplanilla' => array(
                                        'label' => 'Dar Baja Planilla',
                                        'icon' => 'trash',
                                        'visible' => '$data->estado==1 ? true:false',
                                        'click' =>'                                                        
                                        function(){
                                            SGridView.selectRow(this);
                                            admPlanillaretroactivo.Darbajaplanilla();
                                            return false;
                                        }',
                                    ),
                        'consolidarplanillaprefactura' => array(
                                        'label' => 'Consolidar Planilla Prefactura',
                                        'icon' => 'ok',
                                        'visible' => '$data->estado>1 && $data->conprefactura==false  && $data->porsistema==true && '.Yii::app()->user->checkAccess('action_rrhh_planilla_consolidarPrefacturaretroactivo').'==1',
                                        'click' =>'                                                        
                                        function(){
                                            SGridView.selectRow(this);
                                            admPlanillaretroactivo.ConsolidarPrefacturaretroactivo();
                                            return false;
                                        }',
                                    )
                        ,
                          'generarAjusteIncremento' => array(
                        'label' => 'Consolidar Asiento de Incremento Indemnizacion',
                        'icon' => 'ok-sign',
                       'visible' => 'Planillaretroactivo::model()->MotrarGenerarAsientoAjusteIncremento(SeguridadModule::enc($data->getPrimaryKey())) &&'.Yii::app()->user->checkAccess('action_rrhh_planilla_consolidarPrefacturaSueldos').'==1',
                      
                        'click' =>'                                                        
                        function(){
                            SGridView.selectRow(this);
                            admPlanillaretroactivo.ConsolidarIncrementoIndemnizacion();
                            return false;
                        }',
                        
                    ),
                                    'delete' => array('label' => 'Eliminar Corte Retroactivo', 'visible' => '$data->estado==0?true:false',
                                       ),
                                    ),
		),
	),
    ))
));

