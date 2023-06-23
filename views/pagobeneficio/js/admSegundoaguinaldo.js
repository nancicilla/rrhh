
var admSegundoaguinaldo = new Object();
admSegundoaguinaldo.__proto__ = SystemSearch;

//declare var
admSegundoaguinaldo.nameView = "admSegundoaguinaldo";
admSegundoaguinaldo.url = "pagobeneficio/adminsegundoaguinaldo";
admSegundoaguinaldo.idContainer = "";

admSegundoaguinaldo.nextView = "Pagobeneficio";
//functions
admSegundoaguinaldo.init = function () {
    try {
        
          
    } catch (err) {
        alert('Error al cargar admRegistroasistencia.init()');
    }
}

admSegundoaguinaldo.options = function () {
     fecha= $('#'+admSegundoaguinaldo.Id('fecha')).val();
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
admSegundoaguinaldo.segundoaguinaldo=function () {
  
    var id = SGridView.getSelected('id');
        
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admSegundoaguinaldo.search();';
    options.idKey = id;
       
    Pagobeneficio.segundoaguinaldo(options);
  }
admSegundoaguinaldo.PlanillaSegundoAguinaldo=function () {
  
    var id = SGridView.getSelected('id');        
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admSegundoaguinaldo.search();';
    options.idKey = id;
       
    Pagobeneficio.PlanillaAguinaldo(options);
  }
   admSegundoaguinaldo.Consolidar=function () {
  
    var id = SGridView.getSelected('id');
        
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admSegundoaguinaldo.search();';
    options.idKey = id;
       
    Pagobeneficio.ConsolidarAguinaldo(options);
  }
   admSegundoaguinaldo.ActualizarSegundoAguinaldo=function () {
  
    var id = SGridView.getSelected('id');
        
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admSegundoaguinaldo.search();';
    options.idKey = id;
       
    Pagobeneficio.ActualizarSegundoAguinaldo(options);
  }
    