var admTipopagobeneficio = new Object();
admTipopagobeneficio.__proto__ = SystemSearch;

//declare var
admTipopagobeneficio.nameView = "admTipopagobeneficio";
admTipopagobeneficio.url = "tipopagobeneficio/admin";
admTipopagobeneficio.idContainer = "";
admTipopagobeneficio.eventRow = "THIS.update();";
admTipopagobeneficio.nextView = "Tipopagobeneficio";
//functions
admTipopagobeneficio.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admTipopagobeneficio.init()');
    }
}

admTipopagobeneficio.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Tipopagobeneficio.idKeySend());';
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
