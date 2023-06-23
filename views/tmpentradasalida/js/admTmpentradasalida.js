var admTmpentradasalida = new Object();
admTmpentradasalida.__proto__ = SystemSearch;

//declare var
admTmpentradasalida.nameView = "admTmpentradasalida";
admTmpentradasalida.url = "tmpentradasalida/admin";
admTmpentradasalida.idContainer = "";
admTmpentradasalida.eventRow = "THIS.update();";
admTmpentradasalida.nextView = "Tmpentradasalida";
//functions
admTmpentradasalida.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admTmpentradasalida.init()');
    }
}

admTmpentradasalida.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Tmpentradasalida.idKeySend());';
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
