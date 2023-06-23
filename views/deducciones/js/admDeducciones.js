var admDeducciones = new Object();
admDeducciones.__proto__ = SystemSearch;

//declare var
admDeducciones.nameView = "admDeducciones";
admDeducciones.url = "deducciones/admin";
admDeducciones.idContainer = "";
admDeducciones.eventRow = "THIS.update();";
admDeducciones.nextView = "Deducciones";
//functions
admDeducciones.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admDeducciones.init()');
    }
}

admDeducciones.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Deducciones.idKeySend());';
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
