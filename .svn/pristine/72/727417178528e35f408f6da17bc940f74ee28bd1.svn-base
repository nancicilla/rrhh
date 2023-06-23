var admRangohora = new Object();
admRangohora.__proto__ = SystemSearch;

//declare var
admRangohora.nameView = "admRangohora";
admRangohora.url = "rangohora/admin";
admRangohora.idContainer = "";
admRangohora.eventRow = "THIS.update();";
admRangohora.nextView = "Rangohora";
//functions
admRangohora.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admRangohora.init()');
    }
}

admRangohora.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Rangohora.idKeySend());';
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
