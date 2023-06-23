var admPlanillaretroactivo = new Object();
admPlanillaretroactivo.__proto__ = SystemSearch;

//declare var
admPlanillaretroactivo.nameView = "admPlanillaretroactivo";
admPlanillaretroactivo.url = "planillaretroactivo/admin";
admPlanillaretroactivo.idContainer = "";
admPlanillaretroactivo.eventRow = "THIS.update();";
admPlanillaretroactivo.nextView = "Planillaretroactivo";
//functions
admPlanillaretroactivo.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admPlanillaretroactivo.init()');
    }
}

admPlanillaretroactivo.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Planillaretroactivo.idKeySend());';
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
admPlanillaretroactivo.GenerarPlanilla= function () {
    this.set_url();
    var THIS = this; 
    Planillaretroactivo.GenerarPlanilla(THIS.getOptions());
}
admPlanillaretroactivo.Darbajaplanilla= function () {
    this.set_url();
    var THIS = this; 
    Planillaretroactivo.Darbajaplanilla(THIS.getOptions());
}
admPlanillaretroactivo.DescargarPlanilla= function () {
    this.set_url();
    var THIS = this; 
    Planillaretroactivo.DescargarPlanilla(THIS.getOptions());
}
admPlanillaretroactivo.ConsolidarPlanilla= function () {
    this.set_url();
    var THIS = this; 
    Planillaretroactivo.ConsolidarPlanilla(THIS.getOptions());
}

admPlanillaretroactivo.DescargarPlanillaprefactura= function () {
    this.set_url();
    var THIS = this; 
    Planillaretroactivo.DescargarPlanillaprefactura(THIS.getOptions());
}
admPlanillaretroactivo.ConsolidarPrefacturaretroactivo=function(){
    this.set_url();
    var THIS = this; 
    Planillaretroactivo.ConsolidarPrefacturaretroactivo(THIS.getOptions());
}

admPlanillaretroactivo.ConsolidarIncrementoIndemnizacion=function(){
    this.set_url();
    var THIS = this;
    Planillaretroactivo.ConsolidarIncrementoIndemnizacion(THIS.getOptions());
    
}