var admHorario = new Object();
admHorario.__proto__ = SystemSearch;

//declare var
admHorario.nameView = "admHorario";
admHorario.url = "horario/admin";
admHorario.idContainer = "";
//admHorario.eventRow = "THIS.update();";
admHorario.nextView = "Horario";
//functions
admHorario.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admHorario.init()');
    }
}

admHorario.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Horario.idKeySend());';
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
admHorario.cambiarhorarioempleados=function (argument) {
     var id = SGridView.getSelected('id');    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admHorario.search();';
    options.idKey = id;
    Horario.Cambiarhorarioempleados(options);
}
admHorario.Informacionhorario=function (argument) {
    var id = SGridView.getSelected('id');    
   this.set_url();
   var THIS = this;
   var options=THIS.getOptions();
   options.updateFunction = 'admHorario.search();';
   options.idKey = id;
   Horario.Informacionhorario(options);
}
 

admHorario.asignarempleado=function(){
    var id = SGridView.getSelected('id');    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admHorario.search();';
    options.idKey = id;
    Horario.Asignarempleado(options);
}