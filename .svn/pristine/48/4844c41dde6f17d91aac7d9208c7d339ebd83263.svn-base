var Feriado = new Object();
Feriado.__proto__ = SystemWindow;
//variables
Feriado.nameView = "Feriado";
Feriado.url = "feriado";

Feriado.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Feriado',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Feriado',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Feriado',
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

Feriado.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Feriado.afterCreate = function () {
    Feriado.reload();
}

Feriado.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Feriado.afterUpdate = function () {
    Feriado.closeWindow();
}
