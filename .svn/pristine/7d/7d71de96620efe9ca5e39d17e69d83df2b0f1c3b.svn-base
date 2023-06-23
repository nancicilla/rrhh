var admBonoPlanillaTributaria = new Object();
admBonoPlanillaTributaria.__proto__ = SystemSearch;

//declare var
admBonoPlanillaTributaria.nameView = "admBonoPlanillaTributaria";
admBonoPlanillaTributaria.url = "bono/adminBonoPlanillaTributaria";
admBonoPlanillaTributaria.idContainer = "";
admBonoPlanillaTributaria.eventRow = "THIS.update();";
admBonoPlanillaTributaria.nextView = "Bono";
//functions
admBonoPlanillaTributaria.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admBono.init()');
    }
}
admBonoPlanillaTributaria.options = function () {
   var afterFunction = '';
    var updateFunction = 'admBonoPlanillaTributaria.search();';
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

admBonoPlanillaTributaria.Asignarbono=function () {
    var id = SGridView.getSelected('id');    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admBonoPlanillaTributaria.search();';
    options.idKey = id;
    Bono.Asignarbono(options);
}
