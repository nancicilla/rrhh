var admPersona = new Object();
admPersona.__proto__ = SystemSearch;

//declare var
admPersona.nameView = "admPersona";
admPersona.url = "persona/admin";
admPersona.idContainer = "";
admPersona.eventRow = "THIS.update();";
admPersona.nextView = "Persona";
//functions
admPersona.init = function () {
    try {
         
    } catch (err) {
        alert('Error al cargar admPersona.init()');
    }
}

admPersona.options = function () {
    var afterFunction = '';
    var updateFunction = 'THIS.search(Persona.idKeySend());';
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

admPersona.Permiso=function (argument) {
     var id = SGridView.getSelected('id');
    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admPersona.search();';
    options.idKey = id;
    Persona.Permiso(options);
}
admPersona.NuevoContrato=function (argument) {
     var id = SGridView.getSelected('id');
    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admPersona.search();';
    options.idKey = id;
    Persona.NuevoContrato(options);
}
admPersona.Deduccion=function (argument) {
     var id = SGridView.getSelected('id');
    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admPersona.search();';
    options.idKey = id;
    Persona.Deduccion(options);
}
admPersona.Bono=function () {
     var id = SGridView.getSelected('id');
    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admPersona.search();';
    options.idKey = id;
    Persona.Bono(options);
}

admPersona.RetiroEmpleado=function (argument) {
     var id = SGridView.getSelected('id');    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admPersona.search();';
    options.idKey = id;
    Persona.RetiroEmpleado(options);
}

admPersona.RetiroEmpleadosinfiniquito=function (argument) {
     var id = SGridView.getSelected('id');    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admPersona.search();';
    options.idKey = id;
    Persona.RetiroEmpleadosinfiniquito(options);
}
admPersona.ReincorporacionEmpleado=function (argument) {
     var id = SGridView.getSelected('id');
    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admPersona.search();';
    options.idKey = id;
    Persona.ReincorporacionEmpleado(options);
}

admPersona.BoletaEmpleado=function (argument) {
   var id = SGridView.getSelected('id');   
   this.set_url();
   var THIS = this;
   var options=THIS.getOptions();
   options.updateFunction = 'admPersona.search();';
   options.idKey = id;
   Persona.BoletaEmpleado(options);
}
admPersona.NuevoHorario=function(){
    var id = SGridView.getSelected('id');   
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admPersona.search();';
    options.idKey = id;
    Persona.NuevoHorario(options);

};
admPersona.EliminarEmpleado=function (argument) {
     var id = SGridView.getSelected('id');    
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admPersona.search();';
    options.idKey = id;
    Persona.EliminarEmpleado(options);
}