var admTurno = new Object();
admTurno.__proto__ = SystemSearch;

//declare var
admTurno.nameView = "admTurno";
admTurno.url = "turno/admin";
admTurno.idContainer = "";
admTurno.eventRow = "THIS.update();";
admTurno.nextView = "Turno";
//functions
admTurno.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admTurno.init()');
    }
}

admTurno.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Turno.idKeySend());';
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
