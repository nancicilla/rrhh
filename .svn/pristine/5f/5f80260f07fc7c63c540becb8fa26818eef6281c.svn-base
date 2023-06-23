var admArea = new Object();
admArea.__proto__ = SystemSearch;

//declare var
admArea.nameView = "admArea";
admArea.url = "area/admin";
admArea.idContainer = "";
admArea.eventRow = "THIS.update();";
admArea.nextView = "Area";
//functions
admArea.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admArea.init()');
    }
}

admArea.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Area.idKeySend());';
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
