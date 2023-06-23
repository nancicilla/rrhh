var Rangohora = new Object();
Rangohora.__proto__ = SystemWindow;
//variables
Rangohora.nameView = "Rangohora";
Rangohora.url = "rangohora";

Rangohora.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Rangohora',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Rangohora',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Rangohora',
        WindowWidth: 350,
        WindowHeight: 255,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Rangohora.beforeCreate = function () {


error=this.validarFormulario();

    return error;
}
Rangohora.afterCreate = function () {
    Rangohora.reload();
}

Rangohora.beforeUpdate = function () {
    var error = this.validarFormulario();
    return error;
}
Rangohora.afterUpdate = function () {
    Rangohora.closeWindow();
}
Rangohora.validarFormulario=function(){
var hi = parseInt( $('#'+Rangohora.Id('hi')).val());
var hs=parseInt($('#'+Rangohora.Id('hs')).val());
var mi = parseInt( $('#'+Rangohora.Id('mi')).val());
var ms=parseInt($('#'+Rangohora.Id('ms')).val());
var validare=$('#'+Rangohora.Id('controlarentrada')).prop('checked');
var validars=$('#'+Rangohora.Id('controlarsalida')).prop('checked');

if (hs>=hi &&hs>=0 &&hs<=24 &&hi>=0 &&((validars||validare)==true) && (mi<60 && mi>-1)&&(ms<60 && ms>-1)) {
return false;
}else{

 if(hs<hi || hs>25 ||hi>23|| hi<0){
     $('#'+Rangohora.Id('hs')).css('background','#f58686');
     $('#'+Rangohora.Id('hi')).css('background','#f58686');

 }else{
     $('#'+Rangohora.Id('hs')).css('background','#ffffff');
     $('#'+Rangohora.Id('hi')).css('background','#ffffff');

 }
  if(mi>60 || mi<0){
     $('#'+Rangohora.Id('mi')).css('background','#f58686');
    

 }else{
     $('#'+Rangohora.Id('mi')).css('background','#ffffff');
    

 }
  if(ms>60 || ms<0){
     $('#'+Rangohora.Id('ms')).css('background','#f58686');
    

 }else{
     $('#'+Rangohora.Id('ms')).css('background','#ffffff');
    

 }
  if ((validare|| validars)==false) {
  Rangohora.showMessageError('Revise sus datos,solo una de las horas puede estar destikeada');
  }else{
   Rangohora.showMessageError('Revise sus datos');
  }

    return true;
}

}
