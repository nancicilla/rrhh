var admNivelsalarial = new Object();
admNivelsalarial.__proto__ = SystemSearch;

//declare var
admNivelsalarial.nameView = "admNivelsalarial";
admNivelsalarial.url = "nivelsalarial/admin";
admNivelsalarial.idContainer = "";
admNivelsalarial.eventRow = "THIS.update();";
admNivelsalarial.nextView = "Nivelsalarial";
//functions
admNivelsalarial.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admNivelsalarial.init()');
    }
}

admNivelsalarial.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Nivelsalarial.idKeySend());';
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
