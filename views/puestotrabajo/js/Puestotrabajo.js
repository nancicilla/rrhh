var Puestotrabajo = new Object();
Puestotrabajo.__proto__ = SystemWindow;
//variables
Puestotrabajo.nameView = "Puestotrabajo";
Puestotrabajo.url = "puestotrabajo";

Puestotrabajo.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Puestotrabajo',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Puestotrabajo',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Puestotrabajo',
        WindowWidth: 500,
        WindowHeight: 300,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Puestotrabajo.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Puestotrabajo.afterCreate = function () {
    Puestotrabajo.reload();
}

Puestotrabajo.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Puestotrabajo.afterUpdate = function () {
    Puestotrabajo.closeWindow();
}
Puestotrabajo.listaSeccion = function (idunidad,idarea,idseccion) {
    //console.log(idcu); falt
   $.ajax({
    type:'post',
    async: false,
     cache:false,
    url:'rrhh/puestotrabajo/listaSeccion',
    data:{ida:idarea},
    success:function (elementos) {
       
    $('#'+idseccion).empty();
     $('#'+idseccion).html(elementos);
    

    },error:function (er) {
        alert('error');
    }
   });
}
Puestotrabajo.listaArea = function (idunidad, idarea,idseccion,idpuestotrabajo) {
    //console.log(idcu);
   $.ajax({
    type:'post',
    async: false,
     cache:false,
    url:'rrhh/puestotrabajo/listaArea',
    data:{idu:idunidad},
    success:function (elementos) {

       
    $('#'+idarea).empty();
    $('#'+idseccion).empty();
    $('#'+idpuestotrabajo).empty();
    $('#'+idarea).html(elementos);

    },error:function (er) {
        alert('error');
    }
   });
}