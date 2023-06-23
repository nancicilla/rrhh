var admDependiente = new Object();
admDependiente.__proto__ = SystemSearch;

//declare var
admDependiente.nameView = "admDependiente";
admDependiente.url = "dependiente/admin";
admDependiente.idContainer = "";
admDependiente.eventRow = "THIS.update();";
admDependiente.nextView = "Dependiente";
//functions
admDependiente.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admDependiente.init()');
    }
}

admDependiente.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Dependiente.idKeySend());';
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
