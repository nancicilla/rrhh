var Seccion = new Object();
Seccion.__proto__ = SystemWindow;
//variables
Seccion.nameView = "Seccion";
Seccion.url = "seccion";
Seccion.init = function () {
     var THIS=this;
    if (this.action == 'create' || this.action == 'update') {
        $('#' + this.Id('cuenta')).keyup(function (e) {
            var k = (document.all) ? e.keyCode : e.which;
            if (k != 37 && k != 38 && k != 39 && k != 40 && k != 13 && k != 9) {
                Seccion.set('idcuenta', '');
                Seccion.ById('cuenta').style.background = "";
            }
        });
        $('#' + this.Id('cuenta')).blur(function () {
            if (Seccion.get('idcuenta') == '') {
                this.value = '';
                Seccion.ById('cuenta').style.background = "";
            }
        });
    }
};
Seccion.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Seccion',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Seccion',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Seccion',
        WindowWidth: 250,
        WindowHeight: 350,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Seccion.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Seccion.afterCreate = function () {
    Seccion.reload();
}

Seccion.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Seccion.afterUpdate = function () {
    Seccion.closeWindow();
}
Seccion.listaArea = function (idunidad,idarea) {
    //console.log(idcu);
   $.ajax({
    type:'post',
    url:'rrhh/seccion/listaArea',
    data:{idu:idunidad},
    success:function (elementos) {
    $('#'+idarea).empty();
     $('#'+idarea).html(elementos);

    },error:function (er) {
        alert('error');
    }
   });
}