var admAsistencia = new Object();
admAsistencia.__proto__ = SystemSearch;

//declare var
admAsistencia.nameView = "admAsistencia";
admAsistencia.url = "asistencia/admin";
admAsistencia.idContainer = "";
//admAsistencia.eventRow = "THIS.update();";
admAsistencia.nextView = "Asistencia";
//functions
admAsistencia.init = function () {
    try {
        
    } catch (err) {
        alert('Error al cargar admAsistencia.init()');
    }
}

admAsistencia.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Asistencia.idKeySend());';
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
