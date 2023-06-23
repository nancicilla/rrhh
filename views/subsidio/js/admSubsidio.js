var admSubsidio = new Object();
admSubsidio.__proto__ = SystemSearch;

//declare var
admSubsidio.nameView = "admSubsidio";
admSubsidio.url = "subsidio/admin";
admSubsidio.idContainer = "";
admSubsidio.eventRow = "";
admSubsidio.nextView = "Subsidio";
//functions
admSubsidio.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admSubsidio.init()');
    }
}

admSubsidio.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Subsidio.idKeySend());';
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

admSubsidio.RegistroNacidoVivo=function (argument) {
    var id = SGridView.getSelected('id');    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admSubsidio.search();';
    options.idKey = id;
    Subsidio.RegistroNacidoVivo(options);
}
 admSubsidio.NuevoHorarioLactancia=function(){
    var id = SGridView.getSelected('id');    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admSubsidio.search();';
    options.idKey = id;
    Subsidio.NuevoHorarioLactancia(options);  
 }
