var Representante = new Object();
Representante.__proto__ = SystemWindow;
//variables
Representante.nameView = "Representante";
Representante.url = "representante";

Representante.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Representante',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Representante',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Representante',
        WindowWidth: 255,
        WindowHeight: 275,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Representante.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Representante.afterCreate = function () {
    Representante.reload();
}

Representante.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Representante.afterUpdate = function () {
    Representante.closeWindow();
}
