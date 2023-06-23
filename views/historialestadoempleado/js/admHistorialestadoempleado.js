var admHistorialestadoempleado = new Object();
admHistorialestadoempleado.__proto__ = SystemSearch;

//declare var
admHistorialestadoempleado.nameView = "admHistorialestadoempleado";
admHistorialestadoempleado.url = "historialestadoempleado/admin";
admHistorialestadoempleado.idContainer = "";
admHistorialestadoempleado.eventRow = "THIS.update();";
admHistorialestadoempleado.nextView = "Historialestadoempleado";
//functions
admHistorialestadoempleado.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admHistorialestadoempleado.init()');
    }
}

admHistorialestadoempleado.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Historialestadoempleado.idKeySend());';
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
admHistorialestadoempleado.PagoQuinquenio=function () {
    var id = SGridView.getSelected('id');
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admHistorialestadoempleado.search();';
    options.idKey = id;       
    Historialestadoempleado.PagoQuinquenio(options);
    }
admHistorialestadoempleado.ListaQuinquenio=function () {
        var id = SGridView.getSelected('id');
        this.set_url();
        var THIS = this;
        var options=THIS.getOptions();
        options.updateFunction = 'admHistorialestadoempleado.search();';
        options.idKey = id;       
        Historialestadoempleado.ListaQuinquenio(options);
        }
    
admHistorialestadoempleado.DescargarAfiliacionCNS=function(){
    var id = SGridView.getSelected('id');
    this.set_url();
    var THIS = this;
    var options = THIS.getOptions();
    options.idKey = id;
  Historialestadoempleado.DescargarAfiliacionCNS(options); 
  }