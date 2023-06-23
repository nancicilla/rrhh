<?php

/* @var $this PersonaController */
/* @var $model Persona */

echo System::Search(array(
    'title' => 'Administración de Personal',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admPersona',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'ci',
                'width' => 8,
            ),
            array(
                'name' => 'apellidop',
                'width' => 10,
            ),
            array(
                'name' => 'apellidom',
                'width' => 10,
            ),
            array(
                'name' => 'nombre',
                'width' => 15,
            ),
            array(
                'name' => 'area',
                'width' => 12,
                'value' => 'Persona::model()->dameNombreArea(SeguridadModule::enc($data->getPrimaryKey()))'
            ),
            array(
                'name' => 'activo',
                'width' => 10,
                'split' => false,
                'value' => '$data->activo== 1?"<span style=\'color: white;\' class=\'label label-success\'> ACTIVO</span>" :"<span style=\'color: white\' class=\'label label-info\'>INACTIVO</span>" ',
            ),
            array(
                'name' => 'usuario',
                'width' => 10,
            ),
            array(
                'name' => 'fecha',
                'type' => 'datetime',
                'value' => 'date ("d-m-Y",strtotime( $data->fecha))',
                'width' => 10,
            ),
            //bitcoin
            array('typeCol' => 'buttons',
                'width' => 15,
                'deleteConfirmation' => '¿Seguro que desea Acivar/Inactivar Empleado ?',
                'buttons' => array(
                    'Ver' => array('click' => 'function () {SGridView.selectRow(this); admPersona.view(); return false;}','visible' => Yii::app()->user->checkAccess('action_rrhh_persona_view').'==1  '
                    ,'icon' => 'shopping-cart', 'label' => 'Asignar Uniforme'),
                    'Permiso' => array('click' => 'function () {SGridView.selectRow(this); admPersona.Permiso(); return false;}',
                        'visible' => Yii::app()->user->checkAccess('action_rrhh_persona_Permiso').'==1  '
                    , 'icon' => 'tags'),

                    'Deducciones' => array('click' => 'function () {SGridView.selectRow(this); admPersona.Deduccion(); return false;}',
                      'visible' => Yii::app()->user->checkAccess('action_rrhh_persona_Deduccion').'==1',   'icon' => 'plus'),
                    'delete' => array('label' => 'Retiro Empleado',
                    'visible' => 'Persona::model()->MostrarRetiro(SeguridadModule::enc($data->getPrimaryKey())) &&'.Yii::app()->user->checkAccess('action_rrhh_persona_RetiroEmpleado').'==1',
                    'click' => 'function () {SGridView.selectRow(this); admPersona.RetiroEmpleado(); return false;}'),
                    'retirosinfiniquito' => array('label' => 'Retiro Empleado',
                        'visible' => 'Persona::model()->MostrarRetirosinfiniquito(SeguridadModule::enc($data->getPrimaryKey())) &&'.Yii::app()->user->checkAccess('action_rrhh_persona_RetiroEmpleadosinfiniquito').'==1 ', 'icon' => 'trash',
                    'click' => 'function () {SGridView.selectRow(this); admPersona.RetiroEmpleadosinfiniquito(); return false;}'),
                    
                    'reincorporacion' => array('label' => 'Reincorporacion Empleado','icon'=>'repeat',
                    'visible' => 'Persona::model()->MostrarReincorporacion(SeguridadModule::enc($data->getPrimaryKey()))  &&'.Yii::app()->user->checkAccess('action_rrhh_persona_ReincorporacionEmpleado').'==1',
                    
                        'click' => 'function () {SGridView.selectRow(this); admPersona.ReincorporacionEmpleado(); return false;}'),
               
                    'NuevoContrato' => array('visible' => '! Persona::model()->MostrarReincorporacion(SeguridadModule::enc($data->getPrimaryKey())) &&'.Yii::app()->user->checkAccess('action_rrhh_persona_NuevoContrato').'==1',
                    'click' => 'function () {SGridView.selectRow(this); admPersona.NuevoContrato(); return false;}', 'icon' => 'refresh', 'label' => 'Nuevo Contrato'),
                    'NuevoHorario' => array(
                        'visible' => '! Persona::model()->MostrarReincorporacion(SeguridadModule::enc($data->getPrimaryKey()))  &&'.Yii::app()->user->checkAccess('action_rrhh_persona_NuevoHorario').'==1 && Persona::model()->AsignarNuevoHorario(SeguridadModule::enc($data->getPrimaryKey())) ',
    
                        'click' => 'function () {                        
                        SGridView.selectRow(this); admPersona.NuevoHorario(); return false;}', 'label' => 'Nuevo Horario', 'icon' => 'calendar'),
                    
                    'Imprimir' => array('url' => 'array("imprimirVacacionesEmpleado","id"=>SeguridadModule::enc($data->getPrimaryKey()))', 'label' => 'Imprimir Vacacion Empleado',
                        'visible' => Yii::app()->user->checkAccess('action_rrhh_persona_imprimirVacacionesEmpleado').'==1 '
,
                     'icon' => 'print', 'options' => array('target' => '_blank')),
                    'BoletaEmpleado' => array('click' => 'function () {
                            SGridView.selectRow(this); admPersona.BoletaEmpleado(); return false;}', 'label' => 'Boleta Empleado', 
                    'visible' => Yii::app()->user->checkAccess('action_rrhh_persona_boletaEmpleado').'==1 ',
                    'icon' => 'file'),
                    'BancoHora' => array('url' => 'array("ReporteBancoHoraHistorial","id"=>SeguridadModule::enc($data->getPrimaryKey()))',
                      'visible' => Yii::app()->user->checkAccess('action_rrhh_persona_ReporteBancoHoraHistorial').'==1 '
                      ,
                    'icon' => 'download','label'=>'Reporte Banco Horas', 'options' => array('target' => '_blank')),
                    'ImprimirKardex' => array('url' => 'array("imprimirKardexEmpleado","id"=>SeguridadModule::enc($data->getPrimaryKey()))', 'label' => 'Imprimir Kardex Empleado',
                        'visible' => Yii::app()->user->checkAccess('action_rrhh_persona_imprimirKardexEmpleado').'==1 '
,
                     'icon' => 'print', 'options' => array('target' => '_blank')),
                    'eliminar' => array('label' => 'Eliminar Empleado','icon'=>'remove',
                        'visible' => 'Persona::model()->MostrarEliminarPersona(SeguridadModule::enc($data->getPrimaryKey()))  &&'.Yii::app()->user->checkAccess('action_rrhh_persona_EliminarEmpleado').'==1 ',
                    'click' => 'function () {SGridView.selectRow(this); admPersona.EliminarEmpleado(); return false;}'),
                  
                               
                    ),
            ),
        ),
    ))
));

