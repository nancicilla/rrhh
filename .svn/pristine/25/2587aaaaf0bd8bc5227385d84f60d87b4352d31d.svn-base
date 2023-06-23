
var admPrimaanual = new Object();
admPrimaanual.__proto__ = SystemSearch;

//declare var
admPrimaanual.nameView = "admPrimaanual";
admPrimaanual.url = "pagobeneficio/adminprimaanual";
admPrimaanual.idContainer = "";

admPrimaanual.nextView = "Pagobeneficio";
//functions
admPrimaanual.init = function () {
    try {
       
           $('#'+this.Id('gestion') ).keyup(function (e) {
            var k = (document.all) ? e.keyCode : e.which;
            if (k != 37 && k != 38 && k != 39 && k != 40 && k != 13 && k != 9) {
                admPrimaanual.set('id', '');
                admPrimaanual.ById('gestion').style.background = "";
                
                admPrimaanual.search();
                
            }
        });  
           $('#'+this.Id('gestion') ).blur(function () {
            if (admPrimaanual.get('gestion') == '') {
                admPrimaanual.set('id', '');
                admPrimaanual.ById('gestion').style.background = "";
                //admPrimaanual.search();
              
             
                
            }
        });
    } catch (err) {
        alert('Error al cargar admRegistroasistencia.init()');
    }
}

admPrimaanual.options = function () {
  
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
admPrimaanual.prima=function () {
  
    var id = SGridView.getSelected('id');
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admPrimaanual.search();';
    options.idKey = id;
    Pagobeneficio.prima(options);
  }
  admPrimaanual.Listaprimaanual=function () {
  
    var id = SGridView.getSelected('id');
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admPrimaanual.search();';
    options.idKey = id;
    Pagobeneficio.listaempleadoprimaanual(options);
  }
    
    
admPrimaanual.Consolidarprimaanual=function () {
  
    var id = SGridView.getSelected('id');
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admPrimaanual.search();';
    options.idKey = id;
    
    Pagobeneficio.Consolidarprimaanual(options);
  }
  admPrimaanual.PlanillaPrima=function(){
    var id = SGridView.getSelected('id');
    this.set_url();
    var THIS = this;
    var options=THIS.getOptions();
    options.updateFunction = 'admPrimaanual.search();';
    options.idKey = id;
    Pagobeneficio.PlanillaPrima(options);  
  }