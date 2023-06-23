var Deducciones = new Object();
Deducciones.__proto__ = SystemWindow;
//variables
Deducciones.nameView = "Deducciones";
Deducciones.url = "deducciones";
Deducciones.init = function () {
     var THIS=this;
    if (this.action == 'create'|| this.action == 'update'||this.action == 'pulperia') {
   
    this.buttonChange({id: 'save', label: 'Guardar', key: 'G'});
           
       if(this.action=='pulperia'){
            Deducciones.subirArchivoExcel();
       }
     
}}
Deducciones.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Deducciones',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Deducciones',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
 this.setActions('pulperia', {        
        WindowTitle: 'Pulperia',
        initButtons: 'save,cancel',
         WindowWidth: 500,
        WindowHeight:500,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        layerEndOn: false,
        ableBackWindow: true
    });
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Deducciones',
        WindowWidth: 500,
        WindowHeight: 500,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}


Deducciones.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Deducciones.afterCreate = function () {
    Deducciones.reload();
}

Deducciones.Pulperia = function () {
    this.action = 'pulperia';
    this.open(this.getOptions());
}
Deducciones.beforePulperia=function () {
    return false;
}
Deducciones.afterPulperia = function () {
    //Deducciones.reload();
    Deducciones.closeWindow();
}
Deducciones.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Deducciones.afterUpdate = function () {
   

    Deducciones.closeWindow();
}

Deducciones.mostrar=function(){
    
    if ($('#'+Deducciones.Id('esagrupador')).prop('checked')==false) {
     $('#'+Deducciones.Id('contenedorAgrupador')).show();
     
     
    }else{
 $('#'+Deducciones.Id('contenedorAgrupador')).hide();

 
    }
}