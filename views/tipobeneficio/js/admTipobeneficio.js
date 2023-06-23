var admTipobeneficio = new Object();
admTipobeneficio.__proto__ = SystemSearch;

//declare var
admTipobeneficio.nameView = "admTipobeneficio";
admTipobeneficio.url = "tipobeneficio/admin";
admTipobeneficio.idContainer = "";
admTipobeneficio.eventRow = "THIS.update();";
admTipobeneficio.nextView = "Tipobeneficio";
//functions
admTipobeneficio.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admTipobeneficio.init()');
    }
}

admTipobeneficio.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Tipobeneficio.idKeySend());';
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
