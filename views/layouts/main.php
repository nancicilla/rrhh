<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <?php
    Yii::app()->bootstrap->register();
    System::init(array('module' => 'rrhh',
        'list' => array(
            array('view' => 'unidad', 'js' => 'Unidad'),
            array('view' => 'unidad', 'js' => 'admUnidad'),
            array('view' => 'area', 'js' => 'Area'),
            array('view' => 'area', 'js' => 'admArea'),
            array('view' => 'seccion', 'js' => 'Seccion'),
            array('view' => 'seccion', 'js' => 'admSeccion'),
            array('view' => 'puestotrabajo', 'js' => 'Puestotrabajo'),
            array('view' => 'puestotrabajo', 'js' => 'admPuestotrabajo'),
            array('view' => 'persona', 'js' => 'Persona'),
            array('view' => 'persona', 'js' => 'admPersona'),
            array('view' => 'tipocontrato', 'js' => 'Tipocontrato'),
            array('view' => 'tipocontrato', 'js' => 'admTipocontrato'),
            array('view' => 'rangohora', 'js' => 'Rangohora'),
            array('view' => 'rangohora', 'js' => 'admRangohora'),
            array('view' => 'configuracion', 'js' => 'Configuracion'),
            array('view' => 'configuracion', 'js' => 'admConfiguracion'),            
            array('view' => 'tipopermiso', 'js' => 'Tipopermiso'),
            array('view' => 'tipopermiso', 'js' => 'admTipopermiso'),
            array('view' => 'lactancia', 'js' => 'Lactancia'),
            array('view' => 'lactancia', 'js' => 'admLactancia'),
            array('view' => 'bono', 'js' => 'Bono'),
            array('view' => 'bono', 'js' => 'admBono'),
            array('view' => 'bono', 'js' => 'admBonoPlanillaTributaria'),
            array('view' => 'bonos', 'js' => 'Bonos'),
            array('view' => 'bonos', 'js' => 'admBonos'),
            array('view' => 'nivelsalarial', 'js' => 'Nivelsalarial'),
            array('view' => 'nivelsalarial', 'js' => 'admNivelsalarial'),
            array('view' => 'representante', 'js' => 'Representante'),
            array('view' => 'representante', 'js' => 'admRepresentante'),
            array('view' => 'representante', 'js' => 'Representante'),
            array('view' => 'representante', 'js' => 'admRepresentante'),
            array('view' => 'movimientopersonal', 'js' => 'Movimientopersonal'),
            array('view' => 'movimientopersonal', 'js' => 'admMovimientopersonal'),
            array('view' => 'aportacionbeneficio', 'js' => 'Aportacionbeneficio'),
            array('view' => 'aportacionbeneficio', 'js' => 'admAportacionbeneficio'),
            array('view' => 'asistencia', 'js' => 'Asistencia'),
            array('view' => 'asistencia', 'js' => 'admAsistencia'),
            array('view' => 'entradasalida', 'js' => 'Entradasalida'),
            array('view' => 'entradasalida', 'js' => 'admEntradasalida'),
            array('view' => 'empleado', 'js' => 'Empleado'),
            array('view' => 'empleado', 'js' => 'admEmpleado'),
            array('view' => 'empleado', 'js' => 'admRegistroasistencia'),
            array('view' => 'permiso', 'js' => 'Permiso'),
            array('view' => 'permiso', 'js' => 'admPermiso'),
            array('view' => 'empleadodeducciones', 'js' => 'Empleadodeducciones'),
            array('view' => 'empleadodeducciones', 'js' => 'admEmpleadodeducciones'),
            array('view' => 'deducciones', 'js' => 'Deducciones'),
            array('view' => 'deducciones', 'js' => 'admDeducciones'),
            array('view' => 'configuracionatraso', 'js' => 'Configuracionatraso'),
            array('view' => 'configuracionatraso', 'js' => 'admConfiguracionatraso'),
            array('view' => 'subsidio', 'js' => 'Subsidio'),
            array('view' => 'subsidio', 'js' => 'admSubsidio'),
            array('view' => 'tmpentradasalida', 'js' => 'Tmpentradasalida'),
            array('view' => 'tmpentradasalida', 'js' => 'admTmpentradasalida'),
            array('view' => 'vacaciones', 'js' => 'Vacaciones'),
            array('view' => 'vacaciones', 'js' => 'admVacaciones'),
            array('view' => 'turno', 'js' => 'Turno'),
            array('view' => 'turno', 'js' => 'admTurno'),
            array('view' => 'horario', 'js' => 'Horario'),
            array('view' => 'horario', 'js' => 'admHorario'),
            array('view' => 'planilla', 'js' => 'Planilla'),
            array('view' => 'planilla', 'js' => 'admPlanilla'),
            array('view' => 'dependiente', 'js' => 'Dependiente'),
            array('view' => 'dependiente', 'js' => 'admDependiente'),
            array('view' => 'historialestadoempleado', 'js' => 'Historialestadoempleado'),
            array('view' => 'historialestadoempleado', 'js' => 'admHistorialestadoempleado'),
            array('view' => 'tipopagobeneficio', 'js' => 'Tipopagobeneficio'),
            array('view' => 'tipopagobeneficio', 'js' => 'admTipopagobeneficio'),
            array('view' => 'pagobeneficio', 'js' => 'Pagobeneficio'),
            array('view' => 'pagobeneficio', 'js' => 'admPagobeneficio'),
            array('view' => 'pagobeneficio', 'js' => 'admAguinaldonavidad'),
            array('view' => 'pagobeneficio', 'js' => 'adminPrimaanual'),
            array('view' => 'pagobeneficio', 'js' => 'adminFiniquito'),
            array('view' => 'pagobeneficio', 'js' => 'admSegundoaguinaldo'),
            array('view' => 'historialbancohoras', 'js' => 'Historialbancohoras'),
            array('view' => 'historialbancohoras', 'js' => 'admHistorialbancohoras'),
            array('view' => 'seguimientoempleado', 'js' => 'Seguimientoempleado'),
            array('view' => 'seguimientoempleado', 'js' => 'admSeguimientoempleado'),
            array('view' => 'trabajosexternos', 'js' => 'Trabajosexternos'),
            array('view' => 'trabajosexternos', 'js' => 'admTrabajosexternos'),
            array('view' => 'empresasubempleadora', 'js' => 'Empresasubempleadora'),
            array('view' => 'empresasubempleadora', 'js' => 'admEmpresasubempleadora'),
            array('view' => 'horariolactancia', 'js' => 'Horariolactancia'),
            array('view' => 'horariolactancia', 'js' => 'admHorariolactancia'),
            array('view' => 'planillaretroactivo', 'js' => 'Planillaretroactivo'),
            array('view' => 'planillaretroactivo', 'js' => 'admPlanillaretroactivo'),
            array('view' => 'otrosgastos', 'js' => 'Otrosgastos'),
            array('view' => 'otrosgastos', 'js' => 'admOtrosgastos'),
            array('view' => 'feriado', 'js' => 'admFeriado'),
            array('view' => 'feriado', 'js' => 'Feriado'),
            array('view' => 'bonoespecial', 'js' => 'admBonoespecial'),
            array('view' => 'bonoespecial', 'js' => 'Bonoespecial'),
            array('view' => 'formulario110', 'js' => 'admFormulario110'),
            array('view' => 'formulario110', 'js' => 'Formulario110'),
            
        )
    ));
    ?> 
    <body>
        <script type="text/javascript">
            var windowMessageDelay = <?= Yii::app()->params['windowMessageDelay']; ?>;
        </script>
        <?php
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/protected/components/js/sw.js');
        if (Yii::app()->user->isGuest != 1) {
            require_once(Yii::app()->basePath . '/components/main.php');
            ?> 
            <div id="page">
                <div style=" height: 20px; padding: 5px;  background: #171717">
                    <?php
                    $this->widget('bootstrap.widgets.TbNavbar', array(
                        'brandLabel' => '',
                        'brandUrl' => Yii::app()->createUrl("rrhh"),
                        'color' => TbHtml::NAVBAR_COLOR_INVERSE,
                        'display' => null, // default is static to top
                        'items' => array(
                            array(
                                'class' => 'bootstrap.widgets.TbNav',
                                'items' => array(
                                    array('label' => 'E. Organizacional',
                                        'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                            array('label' => 'Unidad'),
                                            array('label' => 'Crear',
                                                'url' => 'javascript:admUnidad.create()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_unidad_create')),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admUnidad.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_unidad_admin')),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Area'),
                                            array('label' => 'Crear',
                                                'url' => 'javascript:admArea.create()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_area_create')),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admArea.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_area_admin')),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Seccion'),
                                            array('label' => 'Crear',
                                                'url' => 'javascript:admSeccion.create()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_seccion_create')),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admSeccion.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_seccion_admin')),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Puesto de Trabajo'),
                                            array('label' => 'Crear',
                                                'url' => 'javascript:admPuestotrabajo.create()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_puestotrabajo_create')),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admPuestotrabajo.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_puestotrabajo_admin')),
                                        )),
                                    array('label' => 'Personal',
                                        'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                            array('label' => 'Personal'),
                                            array('label' => 'Registrar',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_persona_create'),
                                                'url' => 'javascript:admPersona.create()'),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admPersona.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_persona_admin')),
                                            array('label' => 'Administrar  Historial Estado Empleado',
                                                'url' => 'javascript:admHistorialestadoempleado.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_historialestadoempleado_admin')),
                                            array('label' => 'Administrar Modificar Contrato/Horario',
                                                'url' => 'javascript:admMovimientopersonal.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_movimientopersonal_admin')),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Deducciones'),
                                            array('label' => 'Importar/Registrar Deduccion Empleado(Lote)',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_deducciones_create'),
                                                'url' => 'javascript:admDependiente.create()'),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admEmpleadodeducciones.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_empleadodeducciones_admin')),
                                             TbHtml::menuDivider(),
                                            array('label' => 'Otros Gastos'),
                                            array('label' => 'Importar/Registrar Otros Gastos Empleado(Lote)',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_otrosgrastos_create'),
                                                'url' => 'javascript:admOtrosgastos.create()'),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admOtrosgastos.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_otrosgastos_admin')),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Bonos (en Planilla)'),
                                            array('label' => 'Registrar',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_bono_create'),
                                                'url' => 'javascript:admBono.create()'),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admBono.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_bono_admin')),
                                            
                                            /*array('label' => 'Administrar',
                                                'url' => 'javascript:admSegundoaguinaldo.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_pagobeneficio_segundoaguinaldo')),
                                        */
                                            array('label' => 'Administrar Bono Planilla Tributaria',
                                                'url' => 'javascript:admBonoPlanillaTributaria.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_bonoplanillatributaria_admin')),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Bonos Especiales'),
                                            array('label' => 'Registrar',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_bonoespecial_create'),
                                                'url' => 'javascript:admBonoespecial.create()'),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admBonoespecial.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_bonoespecial_admin')),
                                              TbHtml::menuDivider(),  
                                            array('label' => 'Formulario 110'),
                                            array('label' => 'Registrar',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_formulario110_create'),
                                                'url' => 'javascript:admFormulario110.create()'),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admFormulario110.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_formulario110_admin')),
                                            
                                            
                                        )),
                                    array('label' => 'Permisos y Vacaciones',
                                        'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                            array('label' => 'Banco de Horas'),
                                            array('label' => 'Saldo inic. Horas a Favor',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_historialbancohoras_saldohistorialbancohoras'),
                                                'url' => 'javascript:Historialbancohoras.saldohistorialbancohoras()'),
                                            array('label' => 'Registrar Permiso(Hora en contra) ',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_historialbancohoras_create'),
                                                'url' => 'javascript:admHistorialbancohoras.create()'),
                                            array('label' => 'Registro grupal',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_historialbancohoras_registrogrupal'),
                                                'url' => 'javascript:Historialbancohoras.registrogrupal()'),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admHistorialbancohoras.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_historialbancohoras_admin')),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Permisos c/Goce Haber'),
                                            array('label' => 'Registrar',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_permiso_create'),
                                                'url' => 'javascript:admPermiso.create()'),
                                            array('label' => 'Registro grupal',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_permiso_registrogrupal'),
                                                'url' => 'javascript:Permiso.registrogrupal()'),
                                            array('label' => 'Administrar ',
                                                'url' => 'javascript:admPermiso.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_permiso_admin')),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Vacaciones'),
                                            array('label' => 'Registrar Saldo inic. Vacacion',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_vacaciones_saldovacacion'),
                                                'url' => 'javascript:Vacaciones.saldovacacion()'),
                                            array('label' => 'Registro individual',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_vacaciones_create'),
                                                'url' => 'javascript:admVacaciones.create()'),
                                            array('label' => 'Registro grupal',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_vacaciones_quitarvacacion'),
                                                'url' => 'javascript:Vacaciones.quitarvacacion()'),
                                            array('label' => 'Adicionar días a Vacacion',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_vacaciones_adicionarvacacion'),
                                                'url' => 'javascript:Vacaciones.adicionarvacacion()'),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admVacaciones.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_vacaciones_admin')),
                                       TbHtml::menuDivider(),
                                            array('label' => 'Trabajo Externo'),
                                            array('label' => 'Registrar',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_trabajosexternos_create'),
                                                'url' => 'javascript:admTrabajosexternos.create()'),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admTrabajosexternos.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_trabajosexternos_admin')),
                                      
                                            )),  
                                    array('label' => 'Control Asistencia',
                                        'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                            array('label' => 'Listado', 'visible' => Yii::app()->user->checkAccess('action_rrhh_entradasalida_admin'),
                                                'url' => 'javascript:admEntradasalida.actionAdmin()'
                                            ),
                                            array('label' => 'Seguimiento', 'visible' => Yii::app()->user->checkAccess('action_rrhh_entradasalida_cambiarevento'),
                                                'url' => 'javascript:admEntradasalida.cambiarevento()'
                                            ),
                                            array('label' => 'Seguimiento Avanzado ', 'visible' => Yii::app()->user->checkAccess('action_rrhh_entradasalida_seguimiento'),
                                                'url' => 'javascript:admEntradasalida.seguimiento()'
                                            ),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Registrar Asistencia(Manual)', 'visible' => Yii::app()->user->checkAccess('action_rrhh_entradasalida_create'),
                                                'url' => 'javascript:admEntradasalida.create()'
                                            ),
                                             array('label' => 'Registrar Asistencia(Teletrabajo)', 'visible' => Yii::app()->user->checkAccess('action_rrhh_entradasalida_registrarTeletrabajo'),
                                                'url' => 'javascript:Entradasalida.RegistrarTeletrabajo()'
                                            ),
                                            array('label' => 'Importar Asistencia', 'visible' => Yii::app()->user->checkAccess('action_rrhh_entradasalida_create'),
                                                'url' => 'javascript:admTmpentradasalida.create()'
                                            ),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Establecer Horario Eventual', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_horario'),
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_horario_especial'),
                                                'url' => 'javascript:Horario.Horarioespecial()'
                                            ),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Reporte de Horas Asistidas',
                                                'url' => 'javascript:Entradasalida.ReporteHorasAsistidas()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_entradasalida_reportehorasasistidas')),
                                        ),
                                    ),
                                    array('label' => 'Planillas',
                                        'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                            array('label' => 'Crear',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_planilla_create'),
                                                'url' => 'javascript:admPlanilla.create()'),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admPlanilla.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_planilla_admin')),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Administrar Asistencia',
                                                'url' => 'javascript:admAsistencia.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_asistencia_admin')),
                                            TbHtml::menuDivider(),
                                              array('label' => 'Prefactura',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_planilla_prefactura'),
                                                'url' => 'javascript:Planilla.Prefactura()'
                                            ),
                                             TbHtml::menuDivider(),
                                            array('label' => 'Planilla de Retroactivo'),
                                            array('label' => 'Crear',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_planillaretroactivo_create'),
                                                'url' => 'javascript:admPlanillaretroactivo.create()'),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admPlanillaretroactivo.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_planillaretroactivo_admin')),
                                         
                                            )),
                                    array('label' => 'Beneficios Sociales',
                                        'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                            array('label' => 'Quinquenios'),
                                            array('label' => 'Registrar',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_pagobeneficio_create'),
                                                'url' => 'javascript:admPagobeneficio.create()'),
                                            array('label' => 'Administrar ',
                                                'url' => 'javascript:admPagobeneficio.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_pagobeneficio_admin')),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Finiquitos'),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admFiniquito.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_pagobeneficio_adminfiniquito')),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Aguinaldo de Navidad'),
                                            array('label' => 'Registrar',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_pagobeneficio_aguinaldonavidad'),
                                                'url' => 'javascript:admAguinaldonavidad.aguinaldodenavidad()'),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admAguinaldonavidad.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_pagobeneficio_adminaguinaldonavidad')),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Segundo Aguinaldo '),
                                            array('label' => 'Registrar',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_pagobeneficio_segundoaguinaldo'),
                                                'url' => 'javascript:admSegundoaguinaldo.segundoaguinaldo()'),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admSegundoaguinaldo.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_pagobeneficio_segundoaguinaldo')),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Prima Anual'),
                                            array('label' => 'Registrar',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_pagobeneficio_primaanual'),
                                                'url' => 'javascript:admPrimaanual.prima()'),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admPrimaanual.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_pagobeneficio_adminprimaanual')),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Lactancias'),
                                            array('label' => 'Registrar',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_subsidio_create'),
                                                'url' => 'javascript:admSubsidio.create()'),
                                            array('label' => 'Administrar',
                                                'url' => 'javascript:admSubsidio.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_subsidio_admin')),
                                            array('label' => 'Establecer Horario Eventual', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_horariolactancia'),
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_horariolactancia_especial'),
                                                'url' => 'javascript:Horariolactancia.Horarioespecial()'
                                            ),
                                            array('label' => 'Administrar Horario de Lactancia',
                                                'url' => 'javascript:admHorariolactancia.actionAdmin()',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_horariolactancia_admin')),
                                     
                                        )),
                                    array('label' => 'Reportes',
                                        'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                            array('label' => 'Ingreso/Retiro',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_historialestadoempleado_reporte'),
                                                'url' => 'javascript:Historialestadoempleado.IngresoRetiroEmpleado()'),
                                            array('label' => 'Vacaciones  a Fecha',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_vacaciones_reporteageneralvacaciones'),
                                                'url' => 'javascript:Vacaciones.Reportegeneralvacaciones()'),
                                            array('label' => 'Cumpleañeros del mes',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_empleado_reportecumpleanerodelmes'),
                                                'url' => 'javascript:Empleado.Reportecumpleanerodelmes()'),
                                            array('label' => 'Lista de Empleados',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_empleado_reportelistaempleados'),
                                                'url' => 'javascript:Empleado.Reportelistaempleados()'
                                            ),
                                            array('label' => 'Datos Empleados',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_empleado_reportedatosempleados'),
                                                'url' => 'javascript:Empleado.Reportedatosempleados()'
                                            ),
                                            array('label' => 'Reporte de Familiares y Edades',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_empleado_familiaresedades'),
                                                'url' => 'javascript:Empleado.Familiaresedades()'
                                            ),
                                             array('label' => 'Permiso C/Goce Sin Constancia',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_permiso_reportepermisosinconstancia'),
                                                'url' => 'javascript:Permiso.Reportepermisosinconstancia()'
                                            ),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Kardex Empleado',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_empleado_kardexempleado'),
                                                'url' => 'javascript:Empleado.Kardexempleado()'
                                            ),
                                            array('label' => 'Horario Empleado',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_empleado_hoorarioempleado'),
                                                'url' => 'javascript:Empleado.Horarioempleado()'
                                            ),
                                            array('label' => 'Detalle Asistencia Empleado',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_empleado_asistenciaempleado'),
                                                'url' => 'javascript:Empleado.Asistenciaempleado()'
                                            ),
                                            TbHtml::menuDivider(),
                                            array('label' => 'Bono Antiguedad Anual',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_aportacionbeneficio_reportebonoantiguadadanual'),
                                                'url' => 'javascript:Aportacionbeneficio.Reportebonoantiguedadanual()'
                                            ),
                                            array('label' => 'Bono Antiguedad Mes',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_aportacionbeneficio_reportebonoantiguadadmensual'),
                                                'url' => 'javascript:Aportacionbeneficio.Bonoantiguedadmensual()'
                                            ),
                                            TbHtml::menuDivider(),
                                            
                                            array('label' => 'Dominical Perdido',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_planilla_reportedominicalperdido'),
                                                'url' => 'javascript:Planilla.Reportedominicalperdido()'
                                            ),
                                             array('label' => 'Lista Distribucion Dominical',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_planilla_reportedistribuciondominical'),
                                                'url' => 'javascript:Planilla.Reportedistribuciondominical()'
                                            ),
                                            TbHtml::menuDivider(),
                                            
                                            array('label' => 'Baja Manual',
                                                'visible' => Yii::app()->user->checkAccess('action_rrhh_historialestadoempleado'),
                                                'url' => 'javascript:Historialestadoempleado.Reportebajacaja()'
                                            ),
                                            array('label' => 'Otros Reportes', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_historialestadoempleado'),
                                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                                    array('label' => 'Promedio Personal',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_historialestadoempleado'),
                                                        'url' => 'javascript:Empleado.ReportePromedioPersonal()'),
                                                    array('label' => 'Edad Antiguedad Personal',
                                                        'url' => 'javascript:Empleado.ReporteAntiguedadPersonal()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_historialestadoempleado')),
                                                    array('label' => 'Horas Efectivas',
                                                        'url' => 'javascript:Empleado.ReporteHorasefectivas()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_historialestadoempleado')),
                                                    array('label' => 'Reporte Vacaciones',
                                                        'url' => 'javascript:Vacaciones.ReporteVacaciones()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_historialestadoempleado')),
                                                    array('label' => 'Índice de Deserción',
                                                        'url' => 'javascript:Empleado.IndiceDesersion()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_historialestadoempleado')),
                                                    array('label' => 'Reporte Para Contratos',
                                                        'url' => 'javascript:Empleado.ReporteParaContrato()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_historialestadoempleado')),
                                                )),
                                        )),
                                    array('label' => 'P. Laborales',
                                        'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                            array('label' => 'Tipo Contrato', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_tipocontrato'),
                                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                                    array('label' => 'Crear',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_tipocontrato_create'),
                                                        'url' => 'javascript:admTipocontrato.create()'),
                                                    array('label' => 'Administrar',
                                                        'url' => 'javascript:admTipocontrato.actionAdmin()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_tipocontrato_admin')),
                                                )),
                                            array('label' => 'Aportes y Beneficios Sociales', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_aportacionbenefico'),
                                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                                    array('label' => 'Administrar',
                                                        'url' => 'javascript:admAportacionbeneficio.actionAdmin()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_aportacionbeneficio_admin')),
                                                )),
                                            array('label' => 'Tipo Deducciones', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_deducciones'),
                                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                                    array('label' => 'Crear',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_deducciones_create'),
                                                        'url' => 'javascript:admDeducciones.create()'),
                                                    array('label' => 'Administrar',
                                                        'url' => 'javascript:admDeducciones.actionAdmin()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_deducciones_admin')),
                                                )),
                                            array('label' => 'Bonos Puesto Trabajo', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_bonos'),
                                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                                    array('label' => 'Crear',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_bonos_create'),
                                                        'url' => 'javascript:admBonos.create()'),
                                                    array('label' => 'Administrar',
                                                        'url' => 'javascript:admBonos.actionAdmin()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_bonos_admin')),
                                                )),
                                            array('label' => 'Tipo Pago Beneficio', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_bonos'),
                                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                                    array('label' => 'Crear',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_tipopagobeneficio_create'),
                                                        'url' => 'javascript:admTipopagobeneficio.create()'),
                                                    array('label' => 'Administrar',
                                                        'url' => 'javascript:admTipopagobeneficio.actionAdmin()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_tipopagobeneficio_admin')),
                                                )),
                                            array('label' => 'Horarios', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_horario'),
                                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                                    array('label' => 'Crear',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_horario_create'),
                                                        'url' => 'javascript:admHorario.create()'),
                                                    array('label' => 'Administrar',
                                                        'url' => 'javascript:admHorario.actionAdmin()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_horario_admin')),
                                                )),
                                            array('label' => 'Intervalos de Hora', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_rangohora'),
                                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                                    array('label' => 'Crear',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_rangohora_create'),
                                                        'url' => 'javascript:admRangohora.create()'),
                                                    array('label' => 'Administrar',
                                                        'url' => 'javascript:admRangohora.actionAdmin()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_rangohora_admin')),
                                                )),
                                            
                                            array('label' => 'Nivel Salarial', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_nivelsalarial'),
                                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                                    array('label' => 'Crear',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_nivelsalarial_create'),
                                                        'url' => 'javascript:admNivelsalarial.create()'),
                                                    array('label' => 'Administrar',
                                                        'url' => 'javascript:admNivelsalarial.actionAdmin()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_nivelsalarial_admin')),
                                                )),
                                        )),
                                    array('label' => 'Configuraciones',
                                        'class' => 'nav navbar-nav navbar-right', 'icon' => 'wrench white', 'items' => array(
                                            array('label' => 'Configuración', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_configuracion'),
                                                'class' => 'nav navbar-nav navbar-right', 'items' => array(array('label' => 'Crear',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_configuracion_create'),
                                                        'url' => 'javascript:admConfiguracion.create()'),
                                                    array('label' => 'Administrar',
                                                        'url' => 'javascript:admConfiguracion.actionAdmin()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_configuracion_admin')),
                                                )
                                            ),
                                            array('label' => 'Permisos y Bajas Medicas', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_tipopermiso'),
                                                'class' => 'nav navbar-nav navbar-right', 'items' => array(array('label' => 'Crear',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_tipopermiso_create'),
                                                        'url' => 'javascript:admTipopermiso.create()'),
                                                    array('label' => 'Administrar',
                                                        'url' => 'javascript:admTipopermiso.actionAdmin()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_tipopermiso_admin'))
                                                ,
                                                )
                                            ),
                                            array('label' => 'Empresa Subempleadora', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_empresasubempleadora'),
                                                'class' => 'nav navbar-nav navbar-right', 'items' => array(array('label' => 'Crear',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_empresasubempleadora_create'),
                                                        'url' => 'javascript:admEmpresasubempleadora.create()'),
                                                    array('label' => 'Administrar',
                                                        'url' => 'javascript:admEmpresasubempleadora.actionAdmin()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_empresasubempleadora_admin')),)
                                            ),
                                            array('label' => 'Representante Legal', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_representante'),
                                                'class' => 'nav navbar-nav navbar-right', 'items' => array(array('label' => 'Crear',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_representante_create'),
                                                        'url' => 'javascript:admRepresentante.create()'),
                                                    array('label' => 'Administrar',
                                                        'url' => 'javascript:admRepresentante.actionAdmin()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_representante_admin')),)
                                            ),
                                            array('label' => 'Cuenta Sueldos y Salario', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_configuracion'),
                                                'class' => 'nav navbar-nav navbar-right', 'items' => array(array('label' => 'Contra Cuenta ',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_configuracion_contracuenta'),
                                                        'url' => 'javascript:Configuracion.Contracuenta()')
                                                ,)
                                            ),
                                            array('label' => 'Configuracion Atrasos', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_configuracionatraso'),
                                                'class' => 'nav navbar-nav navbar-right', 'items' => array(array('label' => 'Crear',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_configuracionatraso_create'),
                                                        'url' => 'javascript:admConfiguracionatraso.create()'),
                                                    array('label' => 'Administrar',
                                                        'url' => 'javascript:admConfiguracionatraso.actionAdmin()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_configuracionatraso_admin')),)
                                            ),
                                            array('label' => 'Festividades', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_feriado'),
                                                'class' => 'nav navbar-nav navbar-right', 'items' => array(array('label' => 'Crear ', 'visible' => Yii::app()->user->checkAccess('action_rrhh_feriado_create'),
                                                        'url' => 'javascript:admFeriado.create()'),
                                                    array('label' => 'Administrar ', 'url' => 'javascript:admFeriado.actionAdmin()',
                                                        'visible' => Yii::app()->user->checkAccess('action_rrhh_feriado_admin')
                                                    ,)),
                                            ),
                                            
                                            array('label' => 'Aut. Seguimiento', 'visible' => Yii::app()->user->checkAccess('controller_rrhh_seguimientoempleado'),
                                                'class' => 'nav navbar-nav navbar-right', 'items' => array(
                                                     array('label' => 'Registrar ', 'visible' => Yii::app()->user->checkAccess('action_rrhh_seguimientoempleado_create'),
                                                'url' => 'javascript:admSeguimientoempleado.create()'
                                            ),
                                             array('label' => 'Administrar', 'visible' => Yii::app()->user->checkAccess('action_rrhh_seguimientoempleado_admin'),
                                                'url' => 'javascript:admSeguimientoempleado.actionAdmin()'
                                            ),),
                                            ),
                                              
                                           
                                            
                                        )),
                                ),
                            ),
                        ),
                    ));
                    ?>

                    <div id="mainmenu">
                    </div><!-- mainmenu -->
                    <?php if (isset($this->breadcrumbs)): ?>
                        <?php
                        $this->widget('zii.widgets.CBreadcrumbs', array(
                            'links' => $this->breadcrumbs,
                        ));
                        ?><!-- breadcrumbs -->
                    <?php endif ?>
                    <?php $this->widget('Flashes'); ?>
                    <div id="mainContainer" style="padding-top:3px; height: 500px">                  
                        <?php echo $content; ?>
                    </div>
                    <div class="clear"></div>
                </div><!-- style -->              
            </div><!-- page -->
            <?php
        }else {
            echo $content;
            if (Yii::app()->getController()->action->id == 'login') {
                ?>
                <body
                    <div id='custom-background-login'></div>
                </body>        
                <?php
            }
        }
        ?>
        <?php echo gestionSchema::navegacion(); ?> 
    </body>
</html>
