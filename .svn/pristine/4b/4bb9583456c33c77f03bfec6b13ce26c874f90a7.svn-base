var Seguimientoempleado = new Object();
Seguimientoempleado.__proto__ = SystemWindow;
//variables
Seguimientoempleado.nameView = "Seguimientoempleado";
Seguimientoempleado.url = "seguimientoempleado";

Seguimientoempleado.options = function () {
    this.setActions('create', {
        WindowTitle: 'Registrar Autorización Seguimiento Asistencia',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Autorización Seguimiento Asistencia',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Seguimientoempleado',
        WindowWidth: 500,
        WindowHeight: 505,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Seguimientoempleado.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Seguimientoempleado.afterCreate = function () {
    Seguimientoempleado.reload();
}

Seguimientoempleado.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Seguimientoempleado.afterUpdate = function () {
    Seguimientoempleado.closeWindow();
}
