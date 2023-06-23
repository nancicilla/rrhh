var admSeguimientoempleado = new Object();
admSeguimientoempleado.__proto__ = SystemSearch;

//declare var
admSeguimientoempleado.nameView = "admSeguimientoempleado";
admSeguimientoempleado.url = "seguimientoempleado/admin";
admSeguimientoempleado.idContainer = "";
admSeguimientoempleado.eventRow = "THIS.update();";
admSeguimientoempleado.nextView = "Seguimientoempleado";
//functions
admSeguimientoempleado.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admSeguimientoempleado.init()');
    }
}

admSeguimientoempleado.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Seguimientoempleado.idKeySend());';
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
