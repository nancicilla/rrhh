var admOtrosgastos = new Object();
admOtrosgastos.__proto__ = SystemSearch;

//declare var
admOtrosgastos.nameView = "admOtrosgastos";
admOtrosgastos.url = "otrosgastos/admin";
admOtrosgastos.idContainer = "";
admOtrosgastos.eventRow = "THIS.update();";
admOtrosgastos.nextView = "Otrosgastos";
//functions
admOtrosgastos.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admOtrosgastos.init()');
    }
}

admOtrosgastos.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Otrosgastos.idKeySend());';
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
