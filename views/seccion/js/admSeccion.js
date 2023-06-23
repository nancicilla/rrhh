var admSeccion = new Object();
admSeccion.__proto__ = SystemSearch;

//declare var
admSeccion.nameView = "admSeccion";
admSeccion.url = "seccion/admin";
admSeccion.idContainer = "";
admSeccion.eventRow = "THIS.update();";
admSeccion.nextView = "Seccion";
//functions
admSeccion.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admSeccion.init()');
    }
}

admSeccion.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Seccion.idKeySend());';
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
