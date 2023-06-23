var Tipopermiso = new Object();
Tipopermiso.__proto__ = SystemWindow;
//variables
Tipopermiso.nameView = "Tipopermiso";
Tipopermiso.url = "tipopermiso";

Tipopermiso.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Permiso y Baja Medica',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Permiso y Baja Medica',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Permiso y Baja Medica',
        WindowWidth: 250,
        WindowHeight: 305,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Tipopermiso.beforeCreate = function () {
    var error = this.validar();
    return error;
}
Tipopermiso.afterCreate = function () {
    Tipopermiso.reload();
}

Tipopermiso.beforeUpdate = function () {
    var error =this.validar();//false es no existe error antes de actulizar formulario
    return error;
}
Tipopermiso.afterUpdate = function () {
    Tipopermiso.closeWindow();
}
Tipopermiso.mostrar=function (valor) {

    if (valor==1) {
        $('#mostrar').css('display','block');
    }else{
       
        $('#mostrar').css('display','none');
    }
}
Tipopermiso.validar=function () {
    var error=false;

    if ($('#'+Tipopermiso.Id("efecto")).val()=="1" &&parseInt($('#'+Tipopermiso.Id("valore")).val())<1) {
        $('#'+Tipopermiso.Id("valore")).css('background-color','#f68c8c');
        error=true;     
        
    }else{
      
        $('#'+Tipopermiso.Id("valore")).css('background-color','#fff');
    }
    if ($('#'+Tipopermiso.Id("nombre")).val()=="") {
           $('#'+Tipopermiso.Id("nombre")).css('background-color','#f68c8c');
        error=true;
        
    }
     if ($('#'+Tipopermiso.Id("efecto")).val()=="") {
           $('#'+Tipopermiso.Id("efecto")).css('background-color','#f68c8c');
        error=true;
    }
    if (error) {
        Tipopermiso.showMessageError('Revise sus datos !! ');
    }

    return error;
}