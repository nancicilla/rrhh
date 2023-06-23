var Configuracionatraso = new Object();
Configuracionatraso.__proto__ = SystemWindow;
//variables
Configuracionatraso.nameView = "Configuracionatraso";
Configuracionatraso.url = "configuracionatraso";

Configuracionatraso.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Configuracionatraso',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Configuracionatraso',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Configuracionatraso',
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

Configuracionatraso.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Configuracionatraso.afterCreate = function () {
    Configuracionatraso.reload();
}

Configuracionatraso.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Configuracionatraso.afterUpdate = function () {
    Configuracionatraso.closeWindow();
}

Configuracionatraso.validarFormulario=function(){
    var error=false ;
    
}