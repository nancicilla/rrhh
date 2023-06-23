var Cuentahaber = new Object();
Cuentahaber.__proto__ = SystemWindow;
//variables
Cuentahaber.nameView = "Cuentahaber";
Cuentahaber.url = "cuentahaber";

Cuentahaber.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Cuenta Sueldo y Salario',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Cuenta Sueldo y Salario',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Cuenta Sueldo y Salario',
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

Cuentahaber.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Cuentahaber.afterCreate = function () {
    Cuentahaber.reload();
}

Cuentahaber.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Cuentahaber.afterUpdate = function () {
    Cuentahaber.closeWindow();
}
