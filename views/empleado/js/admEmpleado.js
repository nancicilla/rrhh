var admEmpleado = new Object();
admEmpleado.__proto__ = SystemSearch;

//declare var
admEmpleado.nameView = "admEmpleado";
admEmpleado.url = "empleado/admin";
admEmpleado.idContainer = "";
admEmpleado.eventRow = "THIS.update();";
admEmpleado.nextView = "Empleado";
//functions
admEmpleado.init = function () {
    try {
        
           $('#' + this.Id('pempleado')).keyup(function (e) {
            var k = (document.all) ? e.keyCode : e.which;
            if (k != 37 && k != 38 && k != 39 && k != 40 && k != 13 && k != 9) {
                admEmpleado.set('id', '');
                admEmpleado.ById('pempleado').style.background = "";
               
            }
        });  
           $('#' + this.Id('pempleado')).blur(function () {
            if (admEmpleado.get('pempleado') == '') {
               admEmpleado.set('id', '');
                admEmpleado.ById('pempleado').style.background = "";
              admEmpleado.search();
            
                
            }
        });
    } catch (err) {
        alert('Error al cargar admEmpleado.init()');
    }
}

admEmpleado.options = function () {
     fecha= $('#'+admEmpleado.Id('fecha')).val();
    var afterFunction = '';
    //THIS.search(Empleado.idKeySend());
    var updateFunction = '';
    //para actualizar la lista si actualiza/borrar/crea un formulario
    
     var idKey = SGridView.getSelected('id')+'  '+fecha;
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
