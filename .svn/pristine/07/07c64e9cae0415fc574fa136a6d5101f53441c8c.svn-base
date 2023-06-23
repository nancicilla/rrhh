var admHistorialbancohoras = new Object();
admHistorialbancohoras.__proto__ = SystemSearch;

//declare var
admHistorialbancohoras.nameView = "admHistorialbancohoras";
admHistorialbancohoras.url = "historialbancohoras/admin";
admHistorialbancohoras.idContainer = "";
admHistorialbancohoras.eventRow = "THIS.update();";
admHistorialbancohoras.nextView = "Historialbancohoras";
//functions
admHistorialbancohoras.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admHistorialbancohoras.init()');
    }
}

admHistorialbancohoras.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Historialbancohoras.idKeySend());';
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
