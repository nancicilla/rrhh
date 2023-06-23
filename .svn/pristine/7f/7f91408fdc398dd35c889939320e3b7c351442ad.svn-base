var admConfiguracion = new Object();
admConfiguracion.__proto__ = SystemSearch;

//declare var
admConfiguracion.nameView = "admConfiguracion";
admConfiguracion.url = "configuracion/admin";
admConfiguracion.idContainer = "";
admConfiguracion.eventRow = "THIS.update();";
admConfiguracion.nextView = "Configuracion";
//functions
admConfiguracion.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admConfiguracion.init()');
    }
}

admConfiguracion.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Configuracion.idKeySend());';
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
