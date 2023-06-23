var admPagobeneficio = new Object();
admPagobeneficio.__proto__ = SystemSearch;

//declare var
admPagobeneficio.nameView = "admPagobeneficio";
admPagobeneficio.url = "pagobeneficio/admin";
admPagobeneficio.idContainer = "";

admPagobeneficio.nextView = "Pagobeneficio";
//functions
admPagobeneficio.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admPagobeneficio.init()');
    }
}

admPagobeneficio.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Pagobeneficio.idKeySend());';
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
admPagobeneficio.ConsolidarQuinquenio=function () {
  
    var id = SGridView.getSelected('id');
        
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admPagobeneficio.search();';
    options.idKey = id;
       
    Pagobeneficio.ConsolidarQuinquenio(options);
  }
    
