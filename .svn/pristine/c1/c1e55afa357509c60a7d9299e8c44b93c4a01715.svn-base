var admTipopermiso = new Object();
admTipopermiso.__proto__ = SystemSearch;

//declare var
admTipopermiso.nameView = "admTipopermiso";
admTipopermiso.url = "tipopermiso/admin";
admTipopermiso.idContainer = "";
admTipopermiso.eventRow = "THIS.update();";
admTipopermiso.nextView = "Tipopermiso";
//functions
admTipopermiso.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admTipopermiso.init()');
    }
}

admTipopermiso.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Tipopermiso.idKeySend());';
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
