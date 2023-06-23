var Turno = new Object();
Turno.__proto__ = SystemWindow;
//variables
Turno.nameView = "Turno";
Turno.url = "turno";

Turno.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Turno',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Turno',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Turno',
        WindowWidth: 250,
        WindowHeight: 155,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Turno.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Turno.afterCreate = function () {
    Turno.reload();
}

Turno.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Turno.afterUpdate = function () {
    Turno.closeWindow();
}
