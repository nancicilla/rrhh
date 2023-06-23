var admTrabajosexternos = new Object();
admTrabajosexternos.__proto__ = SystemSearch;

//declare var
admTrabajosexternos.nameView = "admTrabajosexternos";
admTrabajosexternos.url = "trabajosexternos/admin";
admTrabajosexternos.idContainer = "";
admTrabajosexternos.eventRow = "THIS.update();";
admTrabajosexternos.nextView = "Trabajosexternos";
//functions
admTrabajosexternos.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admTrabajosexternos.init()');
    }
}

admTrabajosexternos.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Trabajosexternos.idKeySend());';
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
