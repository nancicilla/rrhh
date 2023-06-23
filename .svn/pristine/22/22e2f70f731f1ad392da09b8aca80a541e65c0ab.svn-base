
var admRegistroasistencia = new Object();
admRegistroasistencia.__proto__ = SystemSearch;

//declare var
admRegistroasistencia.nameView = "admRegistroasistencia";
admRegistroasistencia.url = "empleado/adminregistroasistencia";
admRegistroasistencia.idContainer = "";

admRegistroasistencia.nextView = "Empleado";
//functions
admRegistroasistencia.init = function () {
    try {
        
           $('#' + this.Id('pempleado')).keyup(function (e) {
            var k = (document.all) ? e.keyCode : e.which;
            if (k != 37 && k != 38 && k != 39 && k != 40 && k != 13 && k != 9) {
                admRegistroasistencia.set('id', '');
                admRegistroasistencia.ById('pempleado').style.background = "";
                console.log("se ejecutoooooooo1");
              //admEmpleado.search();
            }
        });  
           $('#' + this.Id('pempleado')).blur(function () {
            if (admRegistroasistencia.get('pempleado') == '') {
               admRegistroasistencia.set('id', '');
                admRegistroasistencia.ById('pempleado').style.background = "";
              admRegistroasistencia.search();
              console.log("se ejecutoooooooo2");
                
            }
        });
    } catch (err) {
        alert('Error al cargar admRegistroasistencia.init()');
    }
}

admRegistroasistencia.options = function () {
     fecha= $('#'+admRegistroasistencia.Id('fecha')).val();
    // console.log('--->'+fecha+'<<<<');
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
