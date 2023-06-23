var admEntradasalida = new Object();
admEntradasalida.__proto__ = SystemSearch;

//declare var
admEntradasalida.nameView = "admEntradasalida";
admEntradasalida.url = "entradasalida/admin";
admEntradasalida.idContainer = "";
//admEntradasalida.eventRow = "THIS.update();";
admEntradasalida.nextView = "Entradasalida";
//functions
admEntradasalida.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admEntradasalida.init()');
    }
}

admEntradasalida.options = function () {
  fecha= $('#'+admEntradasalida.Id('fecha')).val();
    var afterFunction = '';
    var updateFunction = 'THIS.search(Entradasalida.idKeySend());';
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
admEntradasalida.seguimiento=function(){

    Entradasalida.seguimiento();
}
admEntradasalida.cambiarevento=function(){
    Entradasalida.cambiarevento();   
}
admEntradasalida.bajasellada=function(){
     var id = SGridView.getSelected('id');    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admEntradasalida.search();';
    options.idKey = id;
    Entradasalida.bajasellada(options);
}
admEntradasalida.bajaselladasinsalida=function(){
     var id = SGridView.getSelected('id');    
   
    Entradasalida.bajaselladasinsalida(id );
}
