var Trabajosexternos = new Object();
Trabajosexternos.__proto__ = SystemWindow;
//variables
Trabajosexternos.nameView = "Trabajosexternos";
Trabajosexternos.url = "trabajosexternos";

Trabajosexternos.options = function () {
    this.setActions('create', {
        WindowTitle: 'Registrar Trabajo Externo',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Trabajo Externo',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Trabajosexternos',
        WindowWidth: 500,
        WindowHeight: 515,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Trabajosexternos.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    if ($('#'+Trabajosexternos.Id('contenedorTrabajosexternos')).attr('style')=='') { 
        error=this.validadFormulario();
        if (error) {
           Trabajosexternos.showMessageError('Revise los datos!! ');
        }
    }else{
        
        Trabajosexternos.closeWindow(); 
       
    }
 return error;
}
Trabajosexternos.afterCreate = function () {
    Trabajosexternos.reload();
}

Trabajosexternos.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Trabajosexternos.afterUpdate = function () {
    Trabajosexternos.closeWindow();
}


Trabajosexternos.dameInformacionEmpleado=function (idempleado) {            
            $('#' +Trabajosexternos.Id("fechadesde")).attr('value','');
            $('#' + Trabajosexternos.Id("fechahasta")).attr('value','');
            $('#'+Trabajosexternos.Id('contHorario')).empty();
            $('#'+Trabajosexternos.Id('contenedorTrabajosexternos')).show();
            $('#'+Trabajosexternos.Id('contenedorMensaje')).hide();  
    
}
Trabajosexternos.Mostrar=function (elemento) {
    if ($('#'+Trabajosexternos.Id('tipo')).prop('checked')) {
        console.log("tikeado");
        $('#'+Trabajosexternos.Id('ocularfecha')).hide();
        $('label[for="'+Trabajosexternos.groupForm+'_fechadesde"]').html('Fecha');
        $('#'+Trabajosexternos.Id('etiquetahd')).html('Horas por Tomar:');
        $('#'+Trabajosexternos.Id('conttDiasVacacion')).html('');
        $('#'+Trabajosexternos.Id('conthoras')).show();
    } else{
           console.log("notikeado");     
        $('#'+Trabajosexternos.Id('ocularfecha')).show();
        $('label[for="'+Trabajosexternos.groupForm+'_fechadesde"]').html('Desde');
        $('#'+Trabajosexternos.Id('conthoras')).hide();
        
        
      
    }
    $('#'+Trabajosexternos.Id('contHorario')).html('');
}
Trabajosexternos.validadFormulario=function () {
    var error=false;
    var canterror=0;
    if ($('#'+Trabajosexternos.Id('empleado')).val()=='') {
        $('#'+Trabajosexternos.Id('empleado')).css('background-color','#f68c8c');
        canterror+=1;

    }else{
        $('#'+Trabajosexternos.Id('empleado')).css('background-color','#fff');

    }
    
    if ($('#'+Trabajosexternos.Id('fechadesde')).val()=='') {
        $('#'+Trabajosexternos.Id('fechadesde')).css('background-color','#f68c8c');
        canterror+=1;

    }else{
        $('#'+Trabajosexternos.Id('fechadesde')).css('background-color','#fff');

    }
if ($('#'+Trabajosexternos.Id('tipo')).prop('checked')) {  
 canterror+=this.validarHoras();
}else{    /////por dia
 if ($('#'+Trabajosexternos.Id('fechahasta')).val()=='') {
        $('#'+Trabajosexternos.Id('fechahasta')).css('background-color','#f68c8c');
        canterror+=1;

    }else{
        $('#'+Trabajosexternos.Id('fechahasta')).css('background-color','#fff');

    }
     /////fin por dia
    }
    if (canterror>0) {
          // 
        error=true;
    }

     return error;

    
}
Trabajosexternos.dameHoras=function(fechadesde){
    var res = fechadesde.split("-");
var f=res[2]+'-'+res[1]+'-'+res[0];
f=new Date(f);
f.setDate(f.getDate() + 1);
var idempleado=$('#'+Trabajosexternos.Id('idempleado')).val();
    $('#' + Trabajosexternos.Id("fechahasta")).datepicker("option", "minDate", fechadesde);
    $('#' + Trabajosexternos.Id("fechahasta")).val('');
  
   
     
      if ($('#'+Trabajosexternos.Id('tipo')).prop('checked')) {
$.ajax({
    type:'post',
    url:'rrhh/trabajosexternos/MostrarhorarioFecha',
    data:{ 
    idempleado:idempleado,
    fecha:fechadesde
    },
    success:function (resp) {
         var vec=jQuery.parseJSON(resp);
            
        $('#'+Trabajosexternos.Id('contHorario')).html(vec.horario);
        $('#'+Trabajosexternos.Id('hi')).attr('data-horario',vec.hi);
        $('#'+Trabajosexternos.Id('mi')).attr('data-horario',vec.mi);
        $('#'+Trabajosexternos.Id('hs')).attr('data-horario',vec.hs);
        $('#'+Trabajosexternos.Id('ms')).attr('data-horario',vec.ms);
        

            },
    error:function (er) {
        
        console.log(er);
    }
  });

      }
}
Trabajosexternos.validarHoras=function(){
var error=false;
var canterror=0;
var hi=$('#'+Trabajosexternos.Id('hi')).val();
var mi=$('#'+Trabajosexternos.Id('mi')).val()
var hs=$('#'+Trabajosexternos.Id('hs')).val();
var ms=$('#'+Trabajosexternos.Id('ms')).val();
if (parseInt(hi)<10) {
  hi='0'+hi;

}
if (parseInt(mi)<10) {
  mi='0'+mi;

}
if (parseInt(hs)<10) {
  hs='0'+hs;

}
if (parseInt(ms)<10) {
  ms='0'+ms;

}
var horai=hi+':'+mi;
 var horaip=$('#'+Trabajosexternos.Id('hi')).attr('data-horario')+':'+$('#'+Trabajosexternos.Id('mi')).attr('data-horario');
 var horasp=$('#'+Trabajosexternos.Id('hs')).attr('data-horario')+':'+$('#'+Trabajosexternos.Id('ms')).attr('data-horario');
 var horas=hs+':'+ms;
  if (horai>=horaip  && horai<horasp) {
    $('#'+Trabajosexternos.Id('hi')).css('background-color','#fff');
     $('#'+Trabajosexternos.Id('mi')).css('background-color','#fff');
    
    
  }else{
    $('#'+Trabajosexternos.Id('hi')).css('background-color','#f68c8c');
     $('#'+Trabajosexternos.Id('mi')).css('background-color','#f68c8c');
   canterror+=1;
  }
  if (horas>horai  && horas<=horasp) {
    $('#'+Trabajosexternos.Id('hs')).css('background-color','#fff');
     $('#'+Trabajosexternos.Id('ms')).css('background-color','#fff');
    
    
  }else{
    $('#'+Trabajosexternos.Id('hs')).css('background-color','#f68c8c');
     $('#'+Trabajosexternos.Id('ms')).css('background-color','#f68c8c');
   canterror+=1;
  }
 
return canterror;

}