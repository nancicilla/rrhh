var admBono = new Object();
admBono.__proto__ = SystemSearch;

//declare var
admBono.nameView = "admBono";
admBono.url = "bono/admin";
admBono.idContainer = "";
admBono.eventRow = "THIS.update();";
admBono.nextView = "Bono";
//functions
admBono.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admBono.init()');
    }
}

admBono.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Bono.idKeySend());';
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
admBono.Asignarbono=function () {
    var id = SGridView.getSelected('id');
    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admBono.search();';
    options.idKey = id;
    Bono.Asignarbono(options);
}
