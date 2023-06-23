var admAportacionbeneficio = new Object();
admAportacionbeneficio.__proto__ = SystemSearch;

//declare var
admAportacionbeneficio.nameView = "admAportacionbeneficio";
admAportacionbeneficio.url = "aportacionbeneficio/admin";
admAportacionbeneficio.idContainer = "";
admAportacionbeneficio.eventRow = "THIS.update();";
admAportacionbeneficio.nextView = "Aportacionbeneficio";
//functions
admAportacionbeneficio.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admAportacionbeneficio.init()');
    }
}

admAportacionbeneficio.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Aportacionbeneficio.idKeySend());';
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
