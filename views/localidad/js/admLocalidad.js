var admLocalidad = new Object();
admLocalidad.__proto__ = SystemSearch;

//declare var
admLocalidad.nameView = "admLocalidad";
admLocalidad.url = "localidad/admin";
admLocalidad.idContainer = "";
admLocalidad.eventRow = "THIS.update();";
admLocalidad.nextView = "Localidad";
//functions
admLocalidad.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admLocalidad.init()');
    }
}

admLocalidad.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Localidad.idKeySend());';
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
