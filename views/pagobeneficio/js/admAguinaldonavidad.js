
var admAguinaldonavidad = new Object();
admAguinaldonavidad.__proto__ = SystemSearch;

//declare var
admAguinaldonavidad.nameView = "admAguinaldonavidad";
admAguinaldonavidad.url = "pagobeneficio/adminaguinaldonavidad";
admAguinaldonavidad.idContainer = "";

admAguinaldonavidad.nextView = "Pagobeneficio";
//functions
admAguinaldonavidad.init = function () {
    try {
        
          
    } catch (err) {
        alert('Error al cargar admRegistroasistencia.init()');
    }
}

admAguinaldonavidad.options = function () {
     fecha= $('#'+admAguinaldonavidad.Id('fecha')).val();
    // console.log('--->'+fecha+'<<<<');
    var afterFunction = '';
    //THIS.search(Empleado.idKeySend());
    var updateFunction = '';
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
admAguinaldonavidad.aguinaldodenavidad=function () {
  
    var id = SGridView.getSelected('id');
        
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admAguinaldonavidad.search();';
    options.idKey = id;
       
    Pagobeneficio.aguinaldonavidad(options);
  }
  admAguinaldonavidad.PlanillaAguinaldo=function () {
  
    var id = SGridView.getSelected('id');
        
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admAguinaldonavidad.search();';
    options.idKey = id;
       
    Pagobeneficio.PlanillaAguinaldo(options);
  }
   admAguinaldonavidad.Consolidar=function () {
  
    var id = SGridView.getSelected('id');
        
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admAguinaldonavidad.search();';
    options.idKey = id;
       
    Pagobeneficio.ConsolidarAguinaldo(options);
  }
   admAguinaldonavidad.ActualizarAguinaldonavidad=function () {
  
    var id = SGridView.getSelected('id');
        
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admAguinaldonavidad.search();';
    options.idKey = id;
       
    Pagobeneficio.ActualizarAguinaldonavidad(options);
  }