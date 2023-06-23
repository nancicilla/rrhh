var admBonos = new Object();
admBonos.__proto__ = SystemSearch;

//declare var
admBonos.nameView = "admBonos";
admBonos.url = "bonos/admin";
admBonos.idContainer = "";
admBonos.eventRow = "THIS.update();";
admBonos.nextView = "Bonos";
//functions
admBonos.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admBonos.init()');
    }
}

admBonos.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Bonos.idKeySend());';
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
