var admRepresentante = new Object();
admRepresentante.__proto__ = SystemSearch;

//declare var
admRepresentante.nameView = "admRepresentante";
admRepresentante.url = "representante/admin";
admRepresentante.idContainer = "";
admRepresentante.eventRow = "THIS.update();";
admRepresentante.nextView = "Representante";
//functions
admRepresentante.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admRepresentante.init()');
    }
}

admRepresentante.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Representante.idKeySend());';
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
