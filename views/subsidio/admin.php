<?php

/* @var $this SubsidioController */
/* @var $model Subsidio */

echo System::Search(array(
    'title' => 'Administración de Subsidios',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admSubsidio',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'idempleado',
                'width' => 18,
                'value' => '$data->idempleado0->idpersona0->apellidop." ".$data->idempleado0->idpersona0->apellidom." ".$data->idempleado0->idpersona0->nombre'
            ),
             array(
                'name' => 'area',
                'width' => 10,
                'value' => 'Persona::model()->dameNombreArea(SeguridadModule::enc($data->idempleado0->idpersona0->id))',
            ),
            array(
                'name' => 'activo',
                'width' => 5,
                'value' => '$data->activo==0? "Inactivo":"Activo"',
            ),
            array(
                'name' => 'fechar',
                'width' =>9,
                'value' => '$data->fechar',
                'type' => 'date'
            ),
            array(
                'name' => 'fechaiqmes',
                'width' => 9,
                'value' => '$data->fechaiqmes',
                'type' => 'date'
            ),
            array(
                'name' => 'fechanacbebe',
                'width' => 9,
                'type' => 'date'
            ),
            array(
                'name' => 'fechaafiliacion',
                'width' => 9,
                'type' => 'date'
            ),
             array(
                'name' => 'fechainiciolactancia',
                'width' => 9,
                'type' => 'date'
            ),
            array(
                'name' => 'numbebe',
                'width' => 4,
            ),
            array(
                'name' => 'usuario',
                'width' => 5,
            ),
            array(
                'name' => 'fecha',
                'type' => 'datetime',
                'width' => 8,
                'value' => '$data->fecha',
                'type' => 'date'
            ),
            array('typeCol' => 'buttons',
                'width' => 5,
                'deleteConfirmation' => '¿Seguro que desea eliminar este elemento?',
                'buttons' => array(
                    'update' => array('label' => 'Modificar', 'visible' => '($data->activo==true)'),  
                      'horario' => array(
                        'label' => 'Nuevo Horario de Lactancia',
                        'icon' => 'calendar',
                        'visible' => 'Subsidio::model()->MotrarHorarioLactancia(SeguridadModule::enc($data->getPrimaryKey()))',
                        'click' =>'                                                        
                        function(){
                            SGridView.selectRow(this);
                            admSubsidio.NuevoHorarioLactancia();
                            return false;
                        }',
                       ),
                    'darbaja' => array(
                        'label' => 'Dar de Baja Subsidio',
                        'icon' => 'remove',
                        'visible' => '($data->activo==1)',
                        'url' => 'array("darbaja","id"=>SeguridadModule::enc($data->getPrimaryKey()))',
                        'click' => 'function(){
                            SGridView.selectRow(this); 
                            var href = $(this).attr("href");
                            bootbox.confirm("¿Está seguro que desea dar de baja el subsidio?",
                                function(confirmed){
                                    if (confirmed){
                                        $.ajax({
                                            type: "post",
                                            url: href,         
                                            success: function(data) {
                                                if ($.trim(data)){
                                                    bootbox.alert(data);
                                                }
                                                admSubsidio.search();
                                            }
                                        });
                                    }
                                }
                            ); 
                        return false;}',
                    ),
                   
                    'RegistroNacidoVivo' => array(
                        'visible' => '($data->fechanacbebe=="" && $data->activo==true)',
                        'click' => 'function () {
                            SGridView.selectRow(this); admSubsidio.RegistroNacidoVivo(); 
                            return false;}', 'label' => 'Registro Nac. Vivo', 'icon' => 'file'),
                          'daralta' => array(
                        'label' => 'Alta Baja Subsidio',
                        'icon' => 'ok',
                        'visible' => '($data->activo==0)',
                        'url' => 'array("daralta","id"=>SeguridadModule::enc($data->getPrimaryKey()))',
                        'click' => 'function(){
                            SGridView.selectRow(this); 
                            var href = $(this).attr("href");
                            bootbox.confirm("¿Está seguro que desea dar Alta baja el subsidio?",
                                function(confirmed){
                                    if (confirmed){
                                        $.ajax({
                                            type: "post",
                                            url: href,         
                                            success: function(data) {
                                                if ($.trim(data)){
                                                    bootbox.alert(data);
                                                }
                                                admSubsidio.search();
                                            }
                                        });
                                    }
                                }
                            ); 
                        return false;}',
                    ),
                    'delete' => array('label' => 'Eliminar'),
                ),
            ),
        ),
    ))
));

