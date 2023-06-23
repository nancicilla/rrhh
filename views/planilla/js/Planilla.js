var Planilla = new Object();
Planilla.__proto__ = SystemWindow;
//variables
Planilla.nameView = "Planilla";
Planilla.url = "planilla";
Planilla.init = function() {
    var THIS = this;
    if (this.action == 'create' || this.action == 'update' || this.action == 'Actualizar' || this.action == 'Planilla' || this.action == 'Consolidar' || this.action == 'Gplanilla' || this.action == 'GenerarPlanilla'||this.action=='ConsolidarIndemnizacion'||this.action=='ConsolidarPrefacturaSueldos'||this.action=='ConsolidarPrefacturaBonos'|| this.action == 'ConsolidarPrefacturaLactacia'|| this.action=='Reportedominicalperdido'||this.action=='Reportedistribuciondominical') {
        this.buttonChange({ id: 'save', label: 'Guardar', key: 'G' });
    }
};

Planilla.options = function() {
    this.setActions('create', {
        WindowTitle: 'Crear Corte Planilla',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {
        WindowTitle: 'Modificar Corte Planilla',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('Planilla', {

        WindowWidth: 300,
        WindowHeight: 350,
        WindowTitle: 'Dar de Baja Planilla',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    //Generarplanilla
    this.setActions('Gplanilla', {

        WindowWidth: 300,
        WindowHeight: 250,
        WindowTitle: 'Generar Planilla',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    this.setActions('Consolidar', {

        WindowWidth: 300,
        WindowHeight: 350,
        WindowTitle: 'Consolidar Planilla',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('ConsolidarIndemnizacion', {

        WindowWidth: 450,
        WindowHeight: 550,
        WindowTitle: 'Consolidar Planilla Indemnizacion',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
     this.setActions('ConsolidarPrefacturaSueldos', {

        WindowWidth: 350,
        WindowHeight: 250,
        WindowTitle: 'Consolidar Prefactura Sueldos',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
     this.setActions('ConsolidarPrefacturaBonos', {

        WindowWidth: 350,
        WindowHeight: 250,
        WindowTitle: 'Consolidar Prefactura Otros Bonos',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('ConsolidarPrefacturaLactancia', {

        WindowWidth: 350,
        WindowHeight: 250,
        WindowTitle: 'Consolidar Prefactura Lactancia',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('Actualizar', {

        WindowWidth: 400,
        WindowHeight: 450,
        WindowTitle: 'Actualizar',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('GenerarPlanilla', {

        WindowWidth: 750,
        WindowHeight: 570,
        WindowTitle: 'Generar Planilla ',
        initButtons: 'planillas',
        endButtons: 'planillas',
        layerEndOn: false,
        ableBackWindow: true

    });
    this.setActions('Prefactura', {

        WindowWidth: 500,
        WindowHeight: 320,
        WindowTitle: 'Descargar Prefactura ',
        initButtons: 'planillas',
        endButtons: 'planillas',
        layerEndOn: false,
        ableBackWindow: true

    });
     this.setActions('Reportedominicalperdido', {

        WindowWidth: 400,
        WindowHeight: 300,
        WindowTitle: 'Reporte Dominical Perdido',
        initButtons: 'Imprimir',
        endButtons: 'Imprimir',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('Reportedistribuciondominical', {

        WindowWidth: 300,
        WindowHeight: 270,
        WindowTitle: 'Reporte Distribucion Dominical ',
        initButtons: 'Imprimir',
        endButtons: 'Imprimir',
        layerEndOn: false,
        ableBackWindow: true
    });
     
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Planilla',
        WindowWidth: 300,
        WindowHeight: 535,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on' // on,off,onMain
    };
    return options;
}

Planilla.beforeCreate = function() {
    var error = this.validarFormulario(); //false es no existe error antes de crear formulario
    return error;
}
Planilla.afterCreate = function() {
    Planilla.closeWindow();
}
Planilla.beforePlanilla = function() {
    var error = false; //false es no existe error antes de crear formulario
    return error;
}
Planilla.afterPlanilla = function() {
    Planilla.closeWindow();
}
Planilla.beforeConsolidarPrefacturaSueldos = function() {
    var error = false; //false es no existe error antes de crear formulario
    return error;
}
Planilla.afterConsolidarPrefacturaSueldos = function() {
    Planilla.closeWindow();
}
Planilla.beforeConsolidarPrefacturaLactancia = function() {
    var error = false; //false es no existe error antes de crear formulario
    return error;
}
Planilla.afterConsolidarPrefacturaLactancia = function() {
    Planilla.closeWindow();
}
Planilla.beforeConsolidarPrefacturaBonos = function() {
    var error = false; //false es no existe error antes de crear formulario
    return error;
}
Planilla.afterConsolidarPrefacturaBonos = function() {
    Planilla.closeWindow();
}
Planilla.beforeConsolidar = function() {
    var error = false; //false es no existe error antes de crear formulario
    return error;
}
Planilla.afterConsolidar = function() {
    Planilla.closeWindow();
}
Planilla.beforeConsolidarIndemnizacion = function() {
    var error = false; //false es no existe error antes de crear formulario
    return error;
}
Planilla.afterConsolidarIndemnizacion = function() {
    Planilla.closeWindow();
}
Planilla.beforeGenerarPrefactura = function() {
    var error = false; //false es no existe error antes de crear formulario
    return error;
}
Planilla.afterGenerarPrefactura = function() {
    Planilla.closeWindow();
}
Planilla.beforeGplanilla = function() {
    var error = false; //false es no existe error antes de crear formulario
    $('#' + Planilla.Id('contmensaje')).html('<div class=" alert alert-info"> <h6>Sea Paciente la Generacion de la Planilla durara un par de minutos...<h6></div>');
    return error;
}
Planilla.afterGplanilla = function() {
    Planilla.closeWindow();
}
Planilla.beforeGenerarPlanilla = function() {
    var error = false; //false es no existe error antes de crear formulario
     return error;
}

Planilla.beforeUpdate = function() {
    var error = this.validarFormulario(); //false es no existe error antes de actulizar formulario
    return error;
}

Planilla.afterUpdate = function() {
    Planilla.closeWindow();
}

Planilla.Actualizar = function() {
    this.action = 'Actualizar';
    this.open(this.getOptions());
}
Planilla.Planilla = function(options) {
    this.action = 'Planilla';
    this.open(this.getOptions(options));
}
Planilla.Prefactura= function() {
    this.action = 'Prefactura';
    this.open(this.getOptions());
}
Planilla.Consolidar = function(options) {
    this.action = 'Consolidar';
    this.open(this.getOptions(options));
}
 Planilla.ConsolidarIndemnizacion=function(options){
    this.action = 'ConsolidarIndemnizacion';
    this.open(this.getOptions(options)); 
 }
 Planilla.ConsolidarPrefacturaSueldos=function(options){
    this.action = 'ConsolidarPrefacturaSueldos';
    this.open(this.getOptions(options)); 
 }
  Planilla.ConsolidarPrefacturaLactancia=function(options){
    this.action = 'ConsolidarPrefacturaLactancia';
    this.open(this.getOptions(options)); 
 }
 Planilla.ConsolidarPrefacturaBonos =function(options){
    this.action = 'ConsolidarPrefacturaBonos';
    this.open(this.getOptions(options)); 
 }
 Planilla.Reportedominicalperdido=function(){
    this.action = 'Reportedominicalperdido';
    this.open(this.getOptions()); 
 }
 Planilla.Reportedistribuciondominical=function(){
    this.action = 'Reportedistribuciondominical';
    this.open(this.getOptions()); 
 }
Planilla.Gplanilla = function(options) {
    this.action = 'Gplanilla';
    this.open(this.getOptions(options));
}
Planilla.GenerarPlanilla = function(options) {

    this.action = 'GenerarPlanilla';
    this.open(this.getOptions(options));
}

Planilla.beforeReportedominicalperdido = function() {
    var error = false; //false es no existe error antes de crear formulario
    return error;
}
Planilla.afterReportedistribuciondominical = function() {
    Planilla.closeWindow();
}
Planilla.beforeReportedominicalperdido = function() {
    var error = false; //false es no existe error antes de crear formulario
    return error;
}
Planilla.afterReportedistribuciondominical = function() {
    Planilla.closeWindow();
}
Planilla.validarFormulario = function() {
    var error = false;
    var cant = 0;
    if ($('#' + Planilla.Id('fechahasta')).val() == '') {
        $('#' + Planilla.Id('fechahasta')).css('background-color', '#f68c8c');

        ++cant;
    } else {
        $('#' + Planilla.Id('fechahasta')).css('background-color', '#fff');
    }
    if ($('#' + Planilla.Id('fechadesde')).val() == '') {
        $('#' + Planilla.Id('fechadesde')).css('background-color', '#f68c8c');
        ++cant;
    } else {
        $('#' + Planilla.Id('fechadesde')).css('background-color', '#fff');
    }
    if ($('#' + Planilla.Id('fechaic')).val() == '') {
        $('#' + Planilla.Id('fechaic')).css('background-color', '#f68c8c');

        ++cant;
    } else {
        $('#' + Planilla.Id('fechaic')).css('background-color', '#fff');
    }
    if ($('#' + Planilla.Id('fechafc')).val() == '') {
        $('#' + Planilla.Id('fechafc')).css('background-color', '#f68c8c');
        ++cant;

    } else {
        $('#' + Planilla.Id('fechafc')).css('background-color', '#fff');
    }

    if ($('#' + Planilla.Id('fechaic')).val() > $('#' + Planilla.Id('fechafc')).val()) {
        ++cant;

        $('#' + Planilla.Id('fechafc')).css('background-color', '#f68c8c');
    } else {
        $('#' + Planilla.Id('fechafc')).css('background-color', '#fff');
    }
    if ($('#' + Planilla.Id('fechadesde')).val() > $('#' + Planilla.Id('fechahasta')).val()) {
        ++cant;
        $('#' + Planilla.Id('fechahasta')).css('background-color', '#f68c8c');
    } else {

        $('#' + Planilla.Id('fechahasta')).css('background-color', '#fff');
    }
    if ($('#' + Planilla.Id('encargadoplanilla')).val()=='' ) {
        ++cant;

        $('#' + Planilla.Id('encargadoplanilla')).css('background-color', '#f68c8c');
    } else {
        $('#' + Planilla.Id('encargadoplanilla')).css('background-color', '#fff');
    }
    if ($('#' + Planilla.Id('nombre')).val()=='' ) {
        ++cant;

        $('#' + Planilla.Id('nombre')).css('background-color', '#f68c8c');
    } else {
        $('#' + Planilla.Id('nombre')).css('background-color', '#fff');
    }
    if ($('#' + Planilla.Id('cargoencargado')).val() =='') {
        ++cant;
        $('#' + Planilla.Id('cargoencargado')).css('background-color', '#f68c8c');
    } else {

        $('#' + Planilla.Id('cargoencargado')).css('background-color', '#fff');
    }
    if (cant > 0) {
        Planilla.showMessageError('Revise los datos !! ');
        error = true;
    }

    return error;
}

Planilla.descargarExcelPlanilla = function() {
    if ($('#s2id_' + Planilla.groupForm + '_area>ul>li[class="select2-search-choice"]').length > 0) {
           var grillab = Planilla.getSGridView('gridBeneficios');
        var grillaa = Planilla.getSGridView('gridAportaciones');
        var vecb = [];
        var veca = [];
        var vec = [];
        var estado = 0;

        for (var i = 1; i <= grillab.rows; i++) {
            vecb.push({ 'nombre': grillab.row(i).get('nombre'), 'estado': grillab.row(i).get('estado') });
        }
        for (var i = 1; i <= grillaa.rows; i++) {
            veca.push({ 'nombre': grillaa.row(i).get('nombre'), 'estado': grillaa.row(i).get('estado') });
        }

        var datos = this.prepareSend($('#' + this.groupForm).serialize()) + this.gestionSchemaMain();
        this.downloadFile(this.urlIni + this.url + '/DescargarExcelPlanilla?' + datos + '&gridBeneficios=' + JSON.stringify(vecb) + '&gridAportaciones=' + JSON.stringify(veca));
    
    } else {
        $('#' + Planilla.Id('contenedorMensaje')).html('<div class="alert alert-info">Debe seleccionar un  Area</div>');
    }
}

Planilla.CargarOpcion = function(opcion) {
    var cad = $('#' + Planilla.Id('opciones') + '>option[value=' + opcion + ']').html();
        $('#' + Planilla.Id('descripcion')).val(cad);
        $('#' + Planilla.Id('contenedorOpciones0')).hide();
        $('#' + Planilla.Id('contenedorOpciones1')).hide();
        $('#' + Planilla.Id('contenedorOpciones')).hide();
        $('#' + Planilla.Id('contenedorOpcionAFP')).hide();
        $('#' + Planilla.Id('contenedorOpcionCNS')).hide();
        $('#' + Planilla.Id('contenedorOpcionDescuento')).hide();
        $('#' + Planilla.Id('contenedorTipocContrato')).hide();
        $('#'+ Planilla.Id('contenedorOpcioneso')).hide();
        $('#'+Planilla.Id('contenedorBA')).hide();
        $('#'+Planilla.Id('contenedorTipoIndemnizacion')).hide();

    if (opcion == '1') {      
        $('#' + Planilla.Id('contenedorOpciones0')).show();
        $('#' + Planilla.Id('contenedorOpciones1')).show();
        $('#' + Planilla.Id('contenedorOpciones')).show();
        $('#'+ Planilla.Id('contenedorOpcioneso')).show();
        $('#'+ Planilla.Id('contenedorBA')).show();
        
    } else if (opcion == '3' ) {
         $('#' + Planilla.Id('contenedorOpcionCNS')).show();
         $('#' + Planilla.Id('contenedorTipocContrato')).show();
        
    }
    else if(opcion == '4'){
          $('#' + Planilla.Id('contenedorOpcionAFP')).show();
    }
    else if(opcion == '5'){
        $('#' + Planilla.Id('contenedorOpcionDescuento')).show();
        $('#' + Planilla.Id('contenedorTipocContrato')).show();
    }
    else if(opcion=='2'){
       
       $('#' + Planilla.Id('contenedorOpciones0')).show(); 
       $('#' + Planilla.Id('contenedorOpciones1')).show();
       $('#'+Planilla.Id('contenedorTipocContrato')).show();

    }
    else if(opcion=='6'){
       
        $('#'+Planilla.Id('contenedorTipoIndemnizacion')).show();
 
     }

}
Planilla.mostrarListaBeneficio = function() {
    var estado = $("#" + Planilla.Id('mostrarBeneficioDesglosada')).prop("checked");
    $.ajax({
        'type': 'post',
        'url': 'rrhh/planilla/dameListaBeneficios',
        'data': { estado: estado, nombre: Planilla.groupForm ,id:$("#" + Planilla.Id('id')).val()},
        success: function(resp) {

            $('#' + Planilla.Id('contenedorBeneficio')).html(resp);

        },
        error: function() {
            alert('ocurrio un error al optener la lista de beneficios...');
        }

    });
}

Planilla.mostrarListaAportaciones = function() {
    var estado = $("#" + Planilla.Id('mostrarAportacionDesglosada')).prop("checked");

    $.ajax({
        'type': 'post',
        'url': 'rrhh/planilla/dameListaAportaciones',
        'data': { estado: estado, nombre: Planilla.groupForm ,id:$("#" + Planilla.Id('id')).val()},
        success: function(resp) {

            $('#' + Planilla.Id('contenedorAportacion')).html(resp);

        },
        error: function() {
            alert('ocurrio un error al optener la lista de aportaciones...');
        }

    });
}

Planilla.descargarExcelPrefactura = function() {
    if ($('#s2id_' + Planilla.groupForm + '_empresasubempleadora>ul>li[class="select2-search-choice"]').length > 0 && $("#" + Planilla.Id('id')).val()!='' &&   $("#" + Planilla.Id('opciones')).val()!='0') {
        if( $("#" + Planilla.Id('id')).val()==''){
             $('#' + Planilla.Id('id')).css('background-color', '#ffffff');
        }
        if( $("#" + Planilla.Id('opciones')).val()==''){
             $('#' + Planilla.Id('opciones')).css('background-color', '#ffffff');
        }
        var datos = this.prepareSend($('#' + this.groupForm).serialize()) + this.gestionSchemaMain();
        this.downloadFile(this.urlIni + this.url + '/DescargarPrefactura?' + datos );
    
    } else {
        if( $("#" + Planilla.Id('id')).val()==''){
             $('#' + Planilla.Id('id')).css('background-color', '#f68c8c');
        }
        if( $("#" + Planilla.Id('opciones')).val()=='0'){
             $('#' + Planilla.Id('opciones')).css('background-color', '#f68c8c');
        }
         Planilla.showMessageError('Debe seleccionar  Planilla - Mes - Empresa(s) !! ');
        }
}
Planilla.descargaReportedominicalperdido=function(){
     if ($('#'+Planilla.Id('empleado')).val()=='')
    {
        $('#'+Planilla.Id('idempleado')).val('');
    }
   if ($('#'+Planilla.Id('id')).val()=='')
    {
        $('#'+Planilla.Id('id')).css('background-color','#f68c8c');
        Planilla.showMessageError('Revise sus datos...!! ');
    
    }else{
        $('#'+Planilla.Id('id')).css('background-color','#ffffff');
        var datos = this.prepareSend($('#' + this.groupForm).serialize());
        var url = 'ImprimirReporteDominicalperdido?' + datos;
        this.openUrl(url);
    }
   
}
Planilla.descargaReportedistribuciondominical=function(){
     
   if ($('#'+Planilla.Id('id')).val()=='')
    {
        $('#'+Planilla.Id('id')).css('background-color','#f68c8c');
        Planilla.showMessageError('Revise sus datos...!! ');
    
    }else{
        $('#'+Planilla.Id('id')).css('background-color','#ffffff');
        var datos = this.prepareSend($('#' + this.groupForm).serialize());
        var url = 'ImprimirReporteDistribuciondominical?' + datos;
        this.openUrl(url);
    }
   
}