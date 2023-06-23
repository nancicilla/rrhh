var Lactancia = new Object();
Lactancia.__proto__ = SystemWindow;
//variables
Lactancia.nameView = "Lactancia";
Lactancia.url = "lactancia";

Lactancia.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Lactancia',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Lactancia',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Lactancia',
        WindowWidth: 280,
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

Lactancia.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Lactancia.afterCreate = function () {
    Lactancia.reload();
}

Lactancia.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Lactancia.afterUpdate = function () {
    Lactancia.closeWindow();
}
