var admCuentahaber = new Object();
admCuentahaber.__proto__ = SystemSearch;

//declare var
admCuentahaber.nameView = "admCuentahaber";
admCuentahaber.url = "cuentahaber/admin";
admCuentahaber.idContainer = "";
admCuentahaber.eventRow = "THIS.update();";
admCuentahaber.nextView = "Cuentahaber";
//functions
admCuentahaber.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admCuentahaber.init()');
    }
}

admCuentahaber.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Cuentahaber.idKeySend());';
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
