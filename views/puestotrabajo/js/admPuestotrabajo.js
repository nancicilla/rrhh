var admPuestotrabajo = new Object();
admPuestotrabajo.__proto__ = SystemSearch;

//declare var
admPuestotrabajo.nameView = "admPuestotrabajo";
admPuestotrabajo.url = "puestotrabajo/admin";
admPuestotrabajo.idContainer = "";
admPuestotrabajo.eventRow = "THIS.update();";
admPuestotrabajo.nextView = "Puestotrabajo";
//functions
admPuestotrabajo.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admPuestotrabajo.init()');
    }
}

admPuestotrabajo.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Puestotrabajo.idKeySend());';
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
