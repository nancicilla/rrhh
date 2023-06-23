var Tipocontrato = new Object();
Tipocontrato.__proto__ = SystemWindow;
//variables
Tipocontrato.nameView = "Tipocontrato";
Tipocontrato.url = "tipocontrato";

Tipocontrato.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Tipocontrato',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Tipocontrato',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Tipocontrato',
        WindowWidth: 400,
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

Tipocontrato.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Tipocontrato.afterCreate = function () {
    Tipocontrato.reload();
}

Tipocontrato.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Tipocontrato.afterUpdate = function () {
    Tipocontrato.closeWindow();
}
