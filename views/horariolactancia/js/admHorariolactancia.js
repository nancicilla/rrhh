var admHorariolactancia = new Object();
admHorariolactancia.__proto__ = SystemSearch;

//declare var
admHorariolactancia.nameView = "admHorariolactancia";
admHorariolactancia.url = "horariolactancia/admin";
admHorariolactancia.idContainer = "";
admHorariolactancia.eventRow = "THIS.update();";
admHorariolactancia.nextView = "Horariolactancia";
//functions
admHorariolactancia.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admHorariolactancia.init()');
    }
}

admHorariolactancia.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Horariolactancia.idKeySend());';
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

 admHorariolactancia.HorarioLactancia=function(){
    var id = SGridView.getSelected('id');    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admHorariolactancia.search();';
    options.idKey = id;
    Horariolactancia.HorarioLactancia(options);  
 }