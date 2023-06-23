var admConfiguracionatraso = new Object();
admConfiguracionatraso.__proto__ = SystemSearch;

//declare var
admConfiguracionatraso.nameView = "admConfiguracionatraso";
admConfiguracionatraso.url = "configuracionatraso/admin";
admConfiguracionatraso.idContainer = "";
admConfiguracionatraso.eventRow = "THIS.update();";
admConfiguracionatraso.nextView = "Configuracionatraso";
//functions
admConfiguracionatraso.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admConfiguracionatraso.init()');
    }
}

admConfiguracionatraso.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Configuracionatraso.idKeySend());';
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
