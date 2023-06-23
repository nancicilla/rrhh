var Area = new Object();
Area.__proto__ = SystemWindow;
//variables
Area.nameView = "Area";
Area.url = "area";
Area.init = function () {
     var THIS=this;
    if (this.action == 'create' || this.action == 'update') {
        $('#' + this.Id('cuenta')).keyup(function (e) {
            var k = (document.all) ? e.keyCode : e.which;
            if (k != 37 && k != 38 && k != 39 && k != 40 && k != 13 && k != 9) {
                Area.set('idcuenta', '');
                Area.ById('cuenta').style.background = "";
            }
        });
        $('#' + this.Id('cuenta')).blur(function () {
            if (Area.get('idcuenta') == '') {
                this.value = '';
                Area.ById('cuenta').style.background = "";
            }
        });
         
    }
};
Area.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Area',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Area',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Area',
        WindowWidth: 250,
        WindowHeight: 400,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Area.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Area.afterCreate = function () {
    Area.reload();
}

Area.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Area.afterUpdate = function () {
    Area.closeWindow();
}
Area.sugerirSigla= function (valor) { 
   $('form > div:nth-child(1) > div:nth-child(2)>input').val(valor.substring(0, 2));
}