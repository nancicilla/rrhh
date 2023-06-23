var Bonoespecial = new Object();
Bonoespecial.__proto__ = SystemWindow;
//variables
Bonoespecial.nameView = "Bonoespecial";
Bonoespecial.url = "bonoespecial";
Bonoespecial.init = function() {
    var THIS = this;
    if (this.action == 'create' || this.action == 'Consolidar' || this.action == 'update'  ||this.action== 'Listaempleado' ||this.action=='Planilla') {
        this.buttonChange({ id: 'save', label: 'Guardar', key: 'G' });
    }
};

Bonoespecial.options = function () {
    this.setActions('create', {
        WindowTitle: 'Registrar Bono Especial',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Bono Especial',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
     this.setActions('listaempleado', {
        WindowWidth: 500,
        WindowHeight: 650,
        WindowTitle: 'Lista de Empleados ',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('Planilla', {
        WindowWidth: 350,
        WindowHeight: 350,
        WindowTitle: 'Descargar Planilla ',
        initButtons: 'planillas',
        endButtons: 'planillas',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('Consolidar', {
        WindowWidth: 350,
        WindowHeight: 250,
        WindowTitle: 'Consolidar Bono ',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Bonoespecial',
        WindowWidth: 750,
        WindowHeight: 600,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}
Bonoespecial.listaempleado = function(options) {
    this.action = 'listaempleado';
    this.open(this.getOptions(options));
}
Bonoespecial.Planilla = function(options) {
    this.action = 'Planilla';
    this.open(this.getOptions(options));
}
Bonoespecial.Consolidar = function(options) {
    this.action = 'Consolidar';
    this.open(this.getOptions(options));
}
Bonoespecial.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Bonoespecial.afterCreate = function () {
    Bonoespecial.reload();
}

Bonoespecial.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Bonoespecial.afterUpdate = function () {
    Bonoespecial.closeWindow();
}
Bonoespecial.beforeListaempleado = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Bonoespecial.afterListaempleado = function () {
    Bonoespecial.closeWindow();
}
Bonoespecial.beforePlanilla = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Bonoespecial.afterPlanilla = function () {
    Bonoespecial.closeWindow();
}
Bonoespecial.beforeConsolidar = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Bonoespecial.afterConsolidar = function () {
    Bonoespecial.closeWindow();
}
Bonoespecial.descargarExcelPrefactura = function() {
    if ($('#s2id_' + Bonoespecial.groupForm + '_empresasubempleadora>ul>li[class="select2-search-choice"]').length > 0 ) {
        
        var datos = this.prepareSend($('#' + this.groupForm).serialize()) + this.gestionSchemaMain();
        this.downloadFile(this.urlIni + this.url + '/DescargarPrefactura?' + datos );
    
    } else {
       
         Bonoespecial.showMessageError('Debe seleccionar   por lo menos una Empresa !! ');
        }
}
Bonoespecial.MostrarOpcion=function(opcion){
    $('#' + Bonoespecial.Id('contenedorMontoDistribuir')).hide();
       $('#' + Bonoespecial.Id('contenedorMonto')).hide();
       $('#' + Bonoespecial.Id('contenedorMontoDistribuir2')).hide();
    $('#' + Bonoespecial.Id('contenedorBA')).hide();
    console.log(opcion+2);
    switch (opcion) {
  case '1':
  {
       $('#' + Bonoespecial.Id('contenedorMontoDistribuir')).show();
       $('#' + Bonoespecial.Id('contenedorMonto')).show();
       $('#' + Bonoespecial.Id('contenedorMontoDistribuir2')).show();
        $('label[for="'+Bonoespecial.groupForm+'_monto"]').html('Monto a Distribuir(Bs.)');
  }
    break;
  case '2':{
    $('#' + Bonoespecial.Id('contenedorMonto')).show();
    $('label[for="'+Bonoespecial.groupForm+'_monto"]').html('Monto');
   }
    break;
  case '3':{
   $('#' + Bonoespecial.Id('contenedorBA')).show();
   $('#' + Bonoespecial.Id('contenedorMonto')).show();
   $('label[for="'+Bonoespecial.groupForm+'_monto"]').html('Porcentaje(%)');
   }
    break;
  default:
    //este código se ejecutará si ninguno de los casos coincide con la expresión
    break;
}
}