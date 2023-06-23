var admMovimientopersonal = new Object();
admMovimientopersonal.__proto__ = SystemSearch;
//declare var
admMovimientopersonal.nameView = "admMovimientopersonal";
admMovimientopersonal.url = "movimientopersonal/admin";
admMovimientopersonal.idContainer = "";
admMovimientopersonal.eventRow = "THIS.update();";
admMovimientopersonal.nextView = "Movimientopersonal";
//functions
admMovimientopersonal.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admMovimientopersonal.init()');
    }
}

admMovimientopersonal.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Movimientopersonal.idKeySend());';
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
  
  admMovimientopersonal.CambiarHorario=function (argument) {
    var id = SGridView.getSelected('id');    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admMovimientopersonal.search();';
    options.idKey = id;
    Movimientopersonal.CambiarHorario(options);
}