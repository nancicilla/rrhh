var admFeriado = new Object();
admFeriado.__proto__ = SystemSearch;

//declare var
admFeriado.nameView = "admFeriado";
admFeriado.url = "feriado/admin";
admFeriado.idContainer = "";
admFeriado.eventRow = "THIS.update();";
admFeriado.nextView = "Feriado";
//functions
admFeriado.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admFeriado.init()');
    }
}

admFeriado.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Feriado.idKeySend());';
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
