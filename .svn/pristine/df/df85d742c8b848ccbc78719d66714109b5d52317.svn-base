var admEmpresasubempleadora = new Object();
admEmpresasubempleadora.__proto__ = SystemSearch;

//declare var
admEmpresasubempleadora.nameView = "admEmpresasubempleadora";
admEmpresasubempleadora.url = "empresasubempleadora/admin";
admEmpresasubempleadora.idContainer = "";
admEmpresasubempleadora.eventRow = "THIS.update();";
admEmpresasubempleadora.nextView = "Empresasubempleadora";
//functions
admEmpresasubempleadora.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admEmpresasubempleadora.init()');
    }
}

admEmpresasubempleadora.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Empresasubempleadora.idKeySend());';
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
