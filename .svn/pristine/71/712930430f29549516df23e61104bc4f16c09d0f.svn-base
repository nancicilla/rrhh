var admLactancia = new Object();
admLactancia.__proto__ = SystemSearch;

//declare var
admLactancia.nameView = "admLactancia";
admLactancia.url = "lactancia/admin";
admLactancia.idContainer = "";
admLactancia.eventRow = "THIS.update();";
admLactancia.nextView = "Lactancia";
//functions
admLactancia.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admLactancia.init()');
    }
}

admLactancia.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Lactancia.idKeySend());';
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
