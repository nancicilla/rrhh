var Nivelsalarial = new Object();
Nivelsalarial.__proto__ = SystemWindow;
//variables
Nivelsalarial.nameView = "Nivelsalarial";
Nivelsalarial.url = "nivelsalarial";

Nivelsalarial.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Nivelsalarial',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Nivelsalarial',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Nivelsalarial',
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

Nivelsalarial.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Nivelsalarial.afterCreate = function () {
    Nivelsalarial.reload();
}

Nivelsalarial.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Nivelsalarial.afterUpdate = function () {
    Nivelsalarial.closeWindow();
}
