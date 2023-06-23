var Empresasubempleadora = new Object();
Empresasubempleadora.__proto__ = SystemWindow;
//variables
Empresasubempleadora.nameView = "Empresasubempleadora";
Empresasubempleadora.url = "empresasubempleadora";

Empresasubempleadora.options = function () {
    this.setActions('create', {
        WindowTitle: 'Registrar Empresa',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Empresa',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Empresasubempleadora',
        WindowWidth: 350,
        WindowHeight:550,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Empresasubempleadora.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Empresasubempleadora.afterCreate = function () {
    Empresasubempleadora.reload();
}

Empresasubempleadora.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Empresasubempleadora.afterUpdate = function () {
    Empresasubempleadora.closeWindow();
}
