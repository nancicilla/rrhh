var admEmpleadodeducciones = new Object();
admEmpleadodeducciones.__proto__ = SystemSearch;

//declare var
admEmpleadodeducciones.nameView = "admEmpleadodeducciones";
admEmpleadodeducciones.url = "empleadodeducciones/admin";
admEmpleadodeducciones.idContainer = "";
//admEmpleadodeducciones.eventRow = "THIS.update();";
admEmpleadodeducciones.nextView = "Empleadodeducciones";
//functions
admEmpleadodeducciones.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admEmpleadodeducciones.init()');
    }
}

admEmpleadodeducciones.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Empleadodeducciones.idKeySend());';
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
