var Empleadodeducciones = new Object();
Empleadodeducciones.__proto__ = SystemWindow;
//variables
Empleadodeducciones.nameView = "Empleadodeducciones";
Empleadodeducciones.url = "empleadodeducciones";

Empleadodeducciones.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Deducciones al Empleado',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Deducciones al Empleado',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Empleadodeducciones',
        WindowWidth: 300,
        WindowHeight: 385,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Empleadodeducciones.beforeCreate = function () {
    //var error = false;//false es no existe error antes de crear formulario
    return this.validarFormulario();
}
Empleadodeducciones.afterCreate = function () {
    Empleadodeducciones.reload();
}

Empleadodeducciones.beforeUpdate = function () {
    //var error = false;//false es no existe error antes de actulizar formulario
    return this.validarFormulario();
}
Empleadodeducciones.afterUpdate = function () {
    Empleadodeducciones.closeWindow();
}
Empleadodeducciones.validarFormulario=function(){
    var error=false;
    var cant=0;
    if ($('#'+Empleadodeducciones.Id('iddeducciones')).val()=='') {
        $('#'+Empleadodeducciones.Id('iddeducciones')).css('background-color','#f68c8c');
         cant+=1;
    }else{
        $('#'+Empleadodeducciones.Id('iddeducciones')).css('background-color','#fff');
        
    }
     if ($('#'+Empleadodeducciones.Id('monto')).val()=='') {
        $('#'+Empleadodeducciones.Id('monto')).css('background-color','#f68c8c');
         cant+=1;
    }else{
        $('#'+Empleadodeducciones.Id('monto')).css('background-color','#fff');
        
    }
     if ($('#'+Empleadodeducciones.Id('fechar')).val()=='') {
        $('#'+Empleadodeducciones.Id('fechar')).css('background-color','#f68c8c');
         cant+=1;
    }else{
        $('#'+Empleadodeducciones.Id('fechar')).css('background-color','#fff');
        
    }
     if ($('#'+Empleadodeducciones.Id('descripcion')).val()=='') {
        $('#'+Empleadodeducciones.Id('descripcion')).css('background-color','#f68c8c');
         cant+=1;
    }else{
        $('#'+Empleadodeducciones.Id('descripcion')).css('background-color','#fff');
        
    }
    if (cant>0) {
        error=true;
    }
    return error;
}
