var admFiniquito = new Object();
admFiniquito.__proto__ = SystemSearch;

//declare var
admFiniquito.nameView = "admFiniquito";
admFiniquito.url = "pagobeneficio/adminfiniquito";
admFiniquito.idContainer = "";

admFiniquito.nextView = "Pagobeneficio";
//functions
admFiniquito.init = function () {
    try {
          $('#'+this.Id('pempleado') ).keyup(function (e) {
            var k = (document.all) ? e.keyCode : e.which;
            if (k != 37 && k != 38 && k != 39 && k != 40 && k != 13 && k != 9) {
                AdmFiniquito.set('id', '');
                AdmFiniquito.ById('gestion').style.background = "";
                
                AdmFiniquito.search();
                console.log("entrooooo1");
            }
        });  
           $('#'+this.Id('pemeplado') ).blur(function () {
            if (AdmFiniquito.get('pempleado') == '') {
                AdmFiniquito.set('id', '');
                AdmFiniquito.ById('pempleado').style.background = "";
                
                
            }
        });
    } catch (err) {
        alert('Error al cargar admPagobeneficio.init()');
    }
}

admFiniquito.options = function () {
   var afterFunction = '';
    var updateFunction = '';
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

admFiniquito.ModificarParametrosFiniquito = function() {
    var id = SGridView.getSelected('id');

    this.set_url();
    var THIS = this;
    var options = THIS.getOptions();
    options.updateFunction = 'admFiniquito.search();';
    options.idKey = id;

    Pagobeneficio.ModificarParametrosFiniquito(options);
}
admFiniquito.ConsolidarFiniquito=function(){
     var id = SGridView.getSelected('id');

    this.set_url();
    var THIS = this;
    var options = THIS.getOptions();
    options.updateFunction = 'admFiniquito.search();';
    options.idKey = id;

    Pagobeneficio.ConsolidarFiniquito(options);
}
  admFiniquito.DescargarBajaCNS=function(){
      var id = SGridView.getSelected('id');

    this.set_url();
    var THIS = this;
    var options = THIS.getOptions();
    options.updateFunction = 'admFiniquito.search();';
    options.idKey = id;

    Pagobeneficio.DescargarBajaCNS(options); 
  }