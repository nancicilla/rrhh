var Planillaretroactivo = new Object();
Planillaretroactivo.__proto__ = SystemWindow;
//variables
Planillaretroactivo.nameView = "Planillaretroactivo";
Planillaretroactivo.url = "planillaretroactivo";
Planillaretroactivo.init = function() {
    var THIS = this;
    if (this.action == 'create' || this.action == 'update' || this.action=='GenerarPlanilla'||this.action=='Darbajaplanilla'||this.action=='DescargarPlanilla'|| this.action=='DescargarPlanillaprefactura' ||this.action=='ConsolidarPlanilla'||this.action=='ConsolidarPrefacturaretroactivo'||this.action=='ConsolidarIncrementoIndemnizacion') {
        this.buttonChange({ id: 'save', label: 'Guardar', key: 'G' });
        
    }
};


Planillaretroactivo.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Planilla Retroactivo',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Planilla Retroactivo',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
this.setActions('GenerarPlanilla', {

        WindowWidth: 350,
        WindowHeight: 250,
        WindowTitle: 'Generar Planilla Retroactivo',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
this.setActions('DescargarPlanilla', {

        WindowWidth: 300,
        WindowHeight: 350,
        WindowTitle: 'Descargar Planilla Retroactivo',
        initButtons: 'descargar',
        endButtons: 'descargar',        
        layerEndOn: false,
        ableBackWindow: true
    });
this.setActions('DescargarPlanillaprefactura', {

        WindowWidth: 300,
        WindowHeight: 350,
        WindowTitle: 'Descargar Planilla Prefactura',
        initButtons: 'descargar',
        endButtons: 'descargar',        
        layerEndOn: false,
        ableBackWindow: true
    });
this.setActions('Darbajaplanilla', {

        WindowWidth: 350,
        WindowHeight: 250,
        WindowTitle: 'Dar Baja Planilla Retroactivo',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
this.setActions('ConsolidarPlanilla', {

        WindowWidth: 355,
        WindowHeight: 250,
        WindowTitle: 'Consolidar Planilla',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
this.setActions('ConsolidarPrefacturaretroactivo', {

        WindowWidth: 355,
        WindowHeight: 250,
        WindowTitle: 'Consolidar Planilla Prefactura',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
this.setActions('ConsolidarIncrementoIndemnizacion', {

        WindowWidth: 350,
        WindowHeight: 250,
        WindowTitle: 'Consolidar Ajuste Incremento Indemnizacion',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Planillaretroactivo',
        WindowWidth: 250,
        WindowHeight: 355,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Planillaretroactivo.beforeCreate = function () {
    var error = this.validarFormulario();//false es no existe error antes de crear formulario
    return error;
}
Planillaretroactivo.afterCreate = function () {
    Planillaretroactivo.reload();
}

Planillaretroactivo.beforeUpdate = function () {
    var error = this.validarFormulario()    ;//false es no existe error antes de actulizar formulario
    
    return error;
}
Planillaretroactivo.afterUpdate = function () {
    Planillaretroactivo.closeWindow();
}
Planillaretroactivo.GenerarPlanilla = function(options) {
    this.action = 'GenerarPlanilla';
    this.open(this.getOptions(options));
}
Planillaretroactivo.beforeGenerarPlanilla = function () {
    var error = false ;//false es no existe error antes de actulizar formulario
    return error;
}
Planillaretroactivo.afterGenerarPlanilla = function () {
    Planillaretroactivo.closeWindow();
}
Planillaretroactivo.DescargarPlanilla = function(options) {
    this.action = 'DescargarPlanilla';
    this.open(this.getOptions(options));
}
Planillaretroactivo.beforeDescargarPlanilla = function () {
    var error = false ;//false es no existe error antes de actulizar formulario
    return error;
}
Planillaretroactivo.afterDescargarPlanilla = function () {
    Planillaretroactivo.closeWindow();
}
Planillaretroactivo.DescargarPlanillaprefactura = function(options) {
    this.action = 'DescargarPlanillaprefactura';
    this.open(this.getOptions(options));
}
Planillaretroactivo.beforeDescargarPlanillaprefactura = function () {
    var error = false ;//false es no existe error antes de actulizar formulario
    return error;
}
Planillaretroactivo.afterDescargarPlanilla = function () {
    Planillaretroactivo.closeWindow();
}
Planillaretroactivo.ConsolidarPrefacturaretroactivo = function(options) {
    this.action = 'ConsolidarPrefacturaretroactivo';
    this.open(this.getOptions(options));
}
Planillaretroactivo.beforeConsolidarPrefacturaretroactivo= function () {
    var error = false ;//false es no existe error antes de actulizar formulario
    return error;
}
Planillaretroactivo.afterConsolidarPrefacturaretroactivo = function () {
    Planillaretroactivo.closeWindow();
}
Planillaretroactivo.Darbajaplanilla= function(options) {
    this.action = 'Darbajaplanilla';
    this.open(this.getOptions(options));
}
Planillaretroactivo.beforeDarbajaplanilla = function () {
    var error = false ;//false es no existe error antes de actulizar formulario
    return error;
}
Planillaretroactivo.afterDarbajaplanilla = function () {
    Planillaretroactivo.closeWindow();
}
Planillaretroactivo.ConsolidarPlanilla= function(options) {
    this.action = 'ConsolidarPlanilla';
    this.open(this.getOptions(options));
}
Planillaretroactivo.beforeConsolidarPlanilla = function () {
    var error = false ;//false es no existe error antes de actulizar formulario
    if ( $('#'+Planillaretroactivo.Id('fechapago')).val()==''){
        error=true;
        $('#' + Planilla.Id('fechapago')).css('background-color', '#f68c8c');
        Planillaretroactivo.showMessageError('Revise los datos !! ');
    }else{
        $('#' + Planilla.Id('fechapago')).css('background-color', '#ffffff');
        
    }
    
    return error;
}
Planillaretroactivo.afterConsolidarPlanilla = function () {
    Planillaretroactivo.closeWindow();
}
Planillaretroactivo.ConsolidarIncrementoIndemnizacion=function(options){
    this.action = 'ConsolidarIncrementoIndemnizacion';
    this.open(this.getOptions(options)); 
 }
Planillaretroactivo.beforeConsolidarIncrementoIndemnizacion = function() {
   // var error = this.validarFormulario(); //false es no existe error antes de crear formulario
   var error=false;
    return error;
}
Planillaretroactivo.afterConsolidarIncrementoIndemnizacion= function() {
    Planillaretroactivo.closeWindow();
}
Planillaretroactivo.validarFormulario=function (){
    var error=false;
    if (parseFloat( $('#'+Planillaretroactivo.Id('monto')).val())<=0) {
       error=true;
       $('#'+Planillaretroactivo.Id('monto')).css('background-color','#f68c8c');             
     } 
    else{
       $('#'+Planillaretroactivo.Id('monto')).css('background-color','#fff');
    }
    if (parseFloat( $('#'+Planillaretroactivo.Id('porcentaje')).val())<=0) {
       error=true;
       $('#'+Planillaretroactivo.Id('porcentaje')).css('background-color','#f68c8c');             
     } 
    else{
       $('#'+Planillaretroactivo.Id('porcentaje')).css('background-color','#fff');
    }
     if(error==true ){
        Planillaretroactivo.showMessageError('Revise sus datos!'); 

   }
   return error;
}
Planillaretroactivo.descargarExcelPlanilla=function(){
     var datos = this.prepareSend($('#' + this.groupForm).serialize()) + this.gestionSchemaMain();
        this.downloadFile(this.urlIni + this.url + '/DescargarExcelPlanilla?' + datos );
    
}
Planillaretroactivo.descargarExcelPlanillaprefactura=function(){
     var datos = this.prepareSend($('#' + this.groupForm).serialize()) + this.gestionSchemaMain();
        this.downloadFile(this.urlIni + this.url + '/DescargarExcelPlanillaprefactura?' + datos );
    
}

