var Localidad = new Object();
Localidad.__proto__ = SystemWindow;
//variables
Localidad.nameView = "Localidad";
Localidad.url = "localidad";

Localidad.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Localidad',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Localidad',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Localidad',
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

Localidad.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Localidad.afterCreate = function () {
    Localidad.reload();
}

Localidad.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Localidad.afterUpdate = function () {
    Localidad.closeWindow();
}
