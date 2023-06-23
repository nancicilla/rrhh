var admVacaciones = new Object();
admVacaciones.__proto__ = SystemSearch;

//declare var
admVacaciones.nameView = "admVacaciones";
admVacaciones.url = "vacaciones/admin";
admVacaciones.idContainer = "";
admVacaciones.nextView = "Vacaciones";
admVacaciones.eventRow = "THIS.update();";
//functions
admVacaciones.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admVacaciones.init()');
    }
}

admVacaciones.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Vacaciones.idKeySend());';
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
admVacaciones.actualizarabono=function(){
    var id = SGridView.getSelected('id'); 
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admVacaciones.search();';
    options.idKey = id;
    Vacaciones.actualizarabono(options);
}