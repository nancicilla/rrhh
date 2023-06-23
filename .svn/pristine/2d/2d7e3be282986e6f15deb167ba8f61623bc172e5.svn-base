var Tipopagobeneficio = new Object();
Tipopagobeneficio.__proto__ = SystemWindow;
//variables
Tipopagobeneficio.nameView = "Tipopagobeneficio";
Tipopagobeneficio.url = "tipopagobeneficio";

Tipopagobeneficio.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Tipopagobeneficio',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Tipopagobeneficio',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Tipopagobeneficio',
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

Tipopagobeneficio.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Tipopagobeneficio.afterCreate = function () {
    Tipopagobeneficio.reload();
}

Tipopagobeneficio.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Tipopagobeneficio.afterUpdate = function () {
    Tipopagobeneficio.closeWindow();
}
