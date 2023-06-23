var admPermiso = new Object();
admPermiso.__proto__ = SystemSearch;

//declare var
admPermiso.nameView = "admPermiso";
admPermiso.url = "permiso/admin";
admPermiso.idContainer = "";
admPermiso.eventRow = "THIS.update();";
admPermiso.nextView = "Permiso";
//functions
admPermiso.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admPermiso.init()');
    }
}

admPermiso.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Permiso.idKeySend());';
    //para actualizar la lista si actualiza/borrar/crea un formulario
    var idKey = SGridView.getSelected('id');
    var varsSend = "";
    var url = "";
    var nameContainer = "";

    var options = {
        idKey: idKey,
        afterFunction: afterFunction,
        updateFunction: updateFunction,
        varsSend: varsSend
    };

    return options;

}   
admPermiso.Constancia= function () {
    var id = SGridView.getSelected('id'); 
    Permiso.Constancia(id);
}