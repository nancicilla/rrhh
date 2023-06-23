var Historialestadoempleado = new Object();
Historialestadoempleado.__proto__ = SystemWindow;
//variables
Historialestadoempleado.nameView = "Historialestadoempleado";
Historialestadoempleado.url = "historialestadoempleado";

Historialestadoempleado.init = function () {
    var THIS=this;
   if (this.action == 'create'||  this.action == 'update'|| this.action=='PagoQuinquenio'|| this.action=='ListaQuinquenio'||this.action=='IngresoRetiroEmpleado'||this.action=='DescargarAfiliacionCNS'||this.action=='Reportebajacaja') {
       this.buttonChange({id: 'save', label: 'Guardar', key: 'G'});
          
     
      
   }


    
};

Historialestadoempleado.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Historialestadoempleado',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar H. Estado Empleado',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
     this.setActions('IngresoRetiroEmpleado', {        
        WindowTitle: 'Reporte Ingreso Retiro Empleado',
        initButtons: 'planilla',
        endButtons: 'planilla',
        layerEndOn: false,
        WindowWidth: 250,
        WindowHeight: 300,
        layerEndOn: false,
        ableBackWindow: true
    });
     this.setActions('DescargarAfiliacionCNS', {        
        WindowTitle: 'Descargar Afiliacion CNS',
        initButtons: 'afiliacion',
        endButtons: 'afiliacion',
        layerEndOn: false,
        WindowWidth: 250,
        WindowHeight: 300,
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('PagoQuinquenio', {        
        WindowTitle: 'Pago Quinquenio',
        initButtons: 'save,cancel',
        WindowWidth: 300,
        WindowHeight: 250,  
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('ListaQuinquenio', {        
        WindowTitle: 'Pago Quinquenio',
        initButtons: 'save,cancel',
        WindowWidth: 300,
        WindowHeight: 150, 
        initButtons: 'planilla',
        endButtons: 'planilla', 
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('Reportebajacaja', {        
        WindowTitle: 'Reporte Manual Baja Caja',
        initButtons: 'baja',
        endButtons: 'baja',
        layerEndOn: false,
        WindowWidth: 250,
        WindowHeight: 300,
        layerEndOn: false,
        ableBackWindow: true
    });
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Historialestadoempleado',
        WindowWidth: 250,
        WindowHeight: 255,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}
Historialestadoempleado.IngresoRetiroEmpleado = function() {
   
    this.action = 'IngresoRetiroEmpleado';
    this.open(this.getOptions());
}
Historialestadoempleado.DescargarAfiliacionCNS=function(options){
   this.action = 'DescargarAfiliacionCNS';
    this.open(this.getOptions(options));   
}
Historialestadoempleado.PagoQuinquenio=function(options){
    this.action = 'PagoQuinquenio';
    this.open(this.getOptions(options));
}
Historialestadoempleado.ListaQuinquenio=function(options){
    this.action = 'ListaQuinquenio';
    this.open(this.getOptions(options));
}
Historialestadoempleado.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Historialestadoempleado.afterCreate = function () {
    Historialestadoempleado.reload();
}
Historialestadoempleado.beforeIngresoRetiroEmpleado= function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Historialestadoempleado.afterIngresoRetiroEmpleado= function () {
    Historialestadoempleado.reload();
}
Historialestadoempleado.beforeDescargarAfiliacionCNS= function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Historialestadoempleado.Reportebajacaja= function() {

    this.action = 'Reportebajacaja';
    this.open(this.getOptions());
}
Historialestadoempleado.beforeReportebajacaja = function() {
    Historialestadoempleado.reload();
}
Historialestadoempleado.afterReportebajacaja = function() {
    Historialestadoempleado.reload();
}
Historialestadoempleado.afterDescargarAfiliacionCNS= function () {
    Historialestadoempleado.reload();
}
Historialestadoempleado.ReporteAfiliciacionCNS=function(){
    console.log(isNaN($('#'+Historialestadoempleado.Id('sueldo')).val()));
    if ($('#'+Historialestadoempleado.Id('fecha')).val()==''){
          $('#'+Historialestadoempleado.Id('fecha')).css('background-color','#f68c8c');
           Historialestadoempleado.showMessageError('Revise los datos !! '); 
    }
    else if (( $('#'+Historialestadoempleado.Id('id')).val())==''){
          $('#'+Historialestadoempleado.Id('id')).css('background-color','#f68c8c');
           Historialestadoempleado.showMessageError('Revise los datos !! '); 
    }
    else if ( isNaN($('#'+Historialestadoempleado.Id('sueldo')).val())==true||$('#'+Historialestadoempleado.Id('sueldo')).val()==''){
          $('#'+Historialestadoempleado.Id('sueldo')).css('background-color','#f68c8c');
           Historialestadoempleado.showMessageError('Revise los datos !! '); 
       }
    else{
        $('#'+Historialestadoempleado.Id('sueldo')).css('background-color','#ffffff');
         $('#'+Historialestadoempleado.Id('fecha')).css('background-color','#ffffff');
      var url = 'historialestadoempleado/imprimirAfiliacion?fecha='+$('#'+Historialestadoempleado.Id('fecha')).val()+'& id='+$('#'+Historialestadoempleado.Id('id')).val()+'& sueldo='+$('#'+Historialestadoempleado.Id('sueldo')).val();
    this.openUrl(url);
    }
}
Historialestadoempleado.ReporteIngresoRetiroEmpleado=function(){
    //alert (serialize({"id":"1","fecha":"25-09-2020"}));
    var datos = this.prepareSend($('#' + this.groupForm).serialize());
    
      var url = 'historialestadoempleado/reporteIngresoRetiroEmpleado?fechadesde='+$('#'+Historialestadoempleado.Id('fecha')).val()+'& fechahasta='+$('#'+Historialestadoempleado.Id('fechavacacion')).val();
    this.openUrl(url);
}
Historialestadoempleado.beforePagoQuinquenio = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    var valor= parseInt( $('#'+Historialestadoempleado.Id('numpago')).val());
    var cante=0;
    
    var max=parseInt($('#'+Historialestadoempleado.Id('numpago')).attr('max'));
  


    if(max>0){
        if($('#'+Historialestadoempleado.Id('fechasolicitud')).val()==''){
            $('#'+Historialestadoempleado.Id('numpago')).css('background-color','#f68c8c');
            cante=cante+1;
        }else{
            $('#'+Historialestadoempleado.Id('numpago')).css('background-color','#ffffff');
        }

    if( valor<=0|| max<valor|| $('#'+Historialestadoempleado.Id('numpago')).val()==''){
   cante=cante+1;
   
     $('#'+Historialestadoempleado.Id('numpago')).css('background-color','#f68c8c');
    
    }else{
        $('#'+Historialestadoempleado.Id('numpago')).css('background-color','#ffffff');
        
    }
    if(cante>0){
     error=true;
        Historialestadoempleado.showMessageError('Revise los datos !! '); 
    }
}
    else{
        Historialestadoempleado.closeWindow();   
    }
    return error;
}
Historialestadoempleado.afterPagoQuinquenio = function () {
    Historialestadoempleado.closeWindow();
}
Historialestadoempleado.beforeListaQuinquenio = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Historialestadoempleado.afterListaQuinquenio = function () {
    Historialestadoempleado.closeWindow();
}
Historialestadoempleado.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Historialestadoempleado.afterUpdate = function () {
    Historialestadoempleado.closeWindow();
}
Historialestadoempleado.validarNumeroQuinquenio=function(pelemento){
    var elemento=$(pelemento);
    
    if(parseInt( elemento.attr('max'))>=parseInt( elemento.val())){
        elemento.css('background-color','#ffffff');
    }else{
        elemento.css('background-color','#f68c8c');
             
    }
}
Historialestadoempleado.descargarBoletaQuinquenio=function(){
    if($('#'+Historialestadoempleado.Id('numeroquinquenios')).val()!=''){
        $('#'+Historialestadoempleado.Id('numeroquinquenios')).css('background-color','#ffffff');
        var datos = this.prepareSend($('#' + this.groupForm).serialize()) + this.gestionSchemaMain();
        this.downloadFile(this.urlIni+this.url+'/DescargarExcelBoletaQuinquenio?' + datos);
      
      
    }else{
        $('#'+Historialestadoempleado.Id('numeroquinquenios')).css('background-color','#f68c8c');
        Historialestadoempleado.showMessageError('Revise los datos !! ');
        
    }
   }
Historialestadoempleado.ReporteBajaCaja=function(){
    console.log(isNaN($('#'+Historialestadoempleado.Id('sueldo')).val()));
    if ($('#'+Historialestadoempleado.Id('fecha')).val()==''){
          $('#'+Historialestadoempleado.Id('fecha')).css('background-color','#f68c8c');
           Historialestadoempleado.showMessageError('Revise los datos !! '); 
    }else if ( isNaN($('#'+Historialestadoempleado.Id('sueldo')).val())==true||$('#'+Historialestadoempleado.Id('sueldo')).val()==''){
          $('#'+Historialestadoempleado.Id('sueldo')).css('background-color','#f68c8c');
           Historialestadoempleado.showMessageError('Revise los datos !! '); 
    }else{
        $('#'+Historialestadoempleado.Id('sueldo')).css('background-color','#ffffff');
         $('#'+Historialestadoempleado.Id('fecha')).css('background-color','#ffffff');
      var url = 'historialestadoempleado/imprimirBajaManual?fecha='+$('#'+Historialestadoempleado.Id('fecha')).val()+'& id='+$('#'+Historialestadoempleado.Id('id')).val()+'& sueldo='+$('#'+Historialestadoempleado.Id('sueldo')).val()+'& tiporetiro='+$('#'+Historialestadoempleado.Id('idtiporetiro')).val();
    this.openUrl(url);
    }
}
