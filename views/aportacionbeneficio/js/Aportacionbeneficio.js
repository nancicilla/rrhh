var Aportacionbeneficio = new Object();
Aportacionbeneficio.__proto__ = SystemWindow;
//variables
Aportacionbeneficio.nameView = "Aportacionbeneficio";
Aportacionbeneficio.url = "aportacionbeneficio";

Aportacionbeneficio.init = function() {
    if(this.action == 'update'||this.action=='Bonoantiguedadmensual')
    { this.buttonChange({id: 'save', label: 'Guardar', key: 'G'});
           
      

    }
}
Aportacionbeneficio.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Aportacionbeneficio',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Aportacion-Beneficio',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
 this.setActions('Bonoantiguedadmensual', {        
        WindowTitle: 'Reporte Bono Antiguedad Mensual',
        initButtons: 'save,cancel',
        initButtons: 'bonomensual',
        endButtons: 'bonomensual',
         WindowWidth: 300,
        WindowHeight: 200, 
        layerEndOn: false,
        ableBackWindow: true
    });
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Aportacionbeneficio',
        WindowWidth: 550,
        WindowHeight: 530,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}
Aportacionbeneficio.Bonoantiguedadmensual=function(){
    this.action = 'Bonoantiguedadmensual';   
    this.open(this.getOptions()); 
}
Aportacionbeneficio.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Aportacionbeneficio.afterCreate = function () {
    Aportacionbeneficio.reload();
}

Aportacionbeneficio.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Aportacionbeneficio.afterUpdate = function () {
    Aportacionbeneficio.closeWindow();
}
Aportacionbeneficio.beforeBonoantiguedadmensual= function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Aportacionbeneficio.afterBonoantiguedadmensual = function () {
    Aportacionbeneficio.closeWindow();
}

Aportacionbeneficio.validarPorcentajeIntervalo=function () {
    var info=$('#'+Aportacionbeneficio.Id('porcentaje')).val();
    var error=false;
    var cant=0;
     if(this.numerico()){
        switch ($('#'+Aportacionbeneficio.Id('tipo')).val()){
         case '1':{
                    if (this.literalv()) {
                        error=true;
                          $('#'+Aportacionbeneficio.Id('porcentaje')).css('background-color','#f68c8c');
                       Aportacionbeneficio.showMessageError('Revise los datos !! '); 
                    }else{
                         $('#'+Aportacionbeneficio.Id('porcentaje')).css('background-color','#fff');
                    }
            break;}
         case '2':{
                    if (this.literalb()) {
                        error=true;
                          $('#'+Aportacionbeneficio.Id('porcentaje')).css('background-color','#f68c8c');
                       Aportacionbeneficio.showMessageError('Revise los datos !! '); 
                    }else{
                         $('#'+Aportacionbeneficio.Id('porcentaje')).css('background-color','#fff');
                    }
            break;}
        
         default:{
                    if (this.literala()) {
                        error=true;
                          $('#'+Aportacionbeneficio.Id('porcentaje')).css('background-color','#f68c8c');
                       Aportacionbeneficio.showMessageError('Revise los datos !! '); 
                    }else{
                         $('#'+Aportacionbeneficio.Id('porcentaje')).css('background-color','#fff');
                    }
         }   
        }
     }else{
         $('#'+Aportacionbeneficio.Id('porcentaje')).css('background-color','#fff');
     }
    return error;
}
Aportacionbeneficio.literala=function() { 
  var info=$('#'+Aportacionbeneficio.Id('porcentaje')).val();// para configuraciones tipo aportación
  var expreg = /^([1-9][0-9][0-9][0-9][0-9][-][2-9][0-9][0-9][0-9][0-9][,][1-9][0-9]*[.]*[1-9]*[;])*$/;
  if(expreg.test(info))
   return false;
  else 
    return true; 
} 
Aportacionbeneficio.literalb=function() { 
  var info=$('#'+Aportacionbeneficio.Id('porcentaje')).val();
  var expreg = /^([1-9][0-9][-][2-9][0-9][,][1-9][0-9]*[.]*[1-9]*[;])*$/;// para los bonos
  if(expreg.test(info))
   return false;
  else 
    return true; 
}

Aportacionbeneficio.literalv=function() { 
  var info=$('#'+Aportacionbeneficio.Id('porcentaje')).val();
  var expreg = /^([0-9][0-9][-][2-9][0-9][,][1-9][0-9]*[.]*[1-9]*[;])*$/;  // para las vacaciones
  if(expreg.test(info))
   return false;
  else 
    return true; 
} 
Aportacionbeneficio.numerico=function (){
  var info=$('#'+Aportacionbeneficio.Id('porcentaje')).val();
  info=info.replace(",",".");
   var error=true;
   if(!isNaN(info))
   {
     $('#'+Aportacionbeneficio.Id('porcentaje')).val(info);
      if (parseFloat(info)<30) {
        error=false;
      }

  }
     return error;
}
// 
Aportacionbeneficio.bloquear=function(){
    if ($('#'+Aportacionbeneficio.Id('esagrupador')).prop('checked')==true) {
     $('#'+Aportacionbeneficio.Id('contenedorAgrupador')).hide();
      $('#'+Aportacionbeneficio.Id('contenedorAgrupador1')).hide();
      $('#'+Aportacionbeneficio.Id('contenedorAgrupador2')).hide();
     
     
    }else{
     $('#'+Aportacionbeneficio.Id('contenedorAgrupador')).show();
     $('#'+Aportacionbeneficio.Id('contenedorAgrupador1')).show();
     $('#'+Aportacionbeneficio.Id('contenedorAgrupador2')).show();
 
    }
  }
Aportacionbeneficio.Reportebonoantiguedadanual=function(){
     var url = 'coreT/rrhh/aportacionbeneficio/Reportebonoantiguedadanual' ;    
    this.openUrl(url);
}
Aportacionbeneficio.Reportebonoantiguedadmensual=function(){
     var url = 'coreT/rrhh/aportacionbeneficio/Reportebonoantiguedadmensual?mes='+$('#'+Aportacionbeneficio.Id('mes')).val() ;    
    
    this.openUrl(url);
}