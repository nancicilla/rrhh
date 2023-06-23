var admTipocontrato = new Object();
admTipocontrato.__proto__ = SystemSearch;

//declare var
admTipocontrato.nameView = "admTipocontrato";
admTipocontrato.url = "tipocontrato/admin";
admTipocontrato.idContainer = "";
admTipocontrato.eventRow = "THIS.update();";
admTipocontrato.nextView = "Tipocontrato";
//functions
admTipocontrato.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admTipocontrato.init()');
    }
}

admTipocontrato.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Tipocontrato.idKeySend());';
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
