var Vacaciones = new Object();
Vacaciones.__proto__ = SystemWindow;
//variables
Vacaciones.nameView = "Vacaciones";
Vacaciones.url = "vacaciones";
Deducciones.init = function () {
     var THIS=this;
    if (this.action == 'create'||this.action == 'saldovacacion'||this.action=='adicionarvacacion'||this.action=='quitarvacacion'||  this.action == 'update'||this.action=='reportegeneralvacaciones'||this.action=='actualizarabono'|| this.action=='ReporteVacaciones') {
      // alert(this.action);
    this.buttonChange({id: 'save', label: 'Guardar', key: 'G'});
      

     
}}
Vacaciones.options = function () {
    this.setActions('create', {
        WindowTitle: 'Registrar Vacaciones',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Vacaciones',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
 this.setActions('saldovacacion', {        
        WindowTitle: 'Saldo Vacacion',
        initButtons: 'save,cancel',
         WindowWidth: 500,
        WindowHeight:500,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('adicionarvacacion', {        
        WindowTitle: 'Adicionar Vacacion(grupo)',
        initButtons: 'save,cancel',
         WindowWidth: 500,
        WindowHeight:500,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('quitarvacacion', {        
        WindowTitle: 'Registrar Vacacion(grupo)',
        initButtons: 'save,cancel',
         WindowWidth: 500,
        WindowHeight:500,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('reportegeneralvacaciones', {        
        WindowTitle: 'Reporte General Vacacion',
        initButtons: 'reportePDF,reporteXLS',
         WindowWidth: 350,
        WindowHeight:350,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('actualizarabono', {        
        WindowTitle: 'Actualizar Abono',
        initButtons: 'save,cancel',
        WindowWidth: 300,
        WindowHeight: 250, 
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('ReporteVacaciones', {        
        WindowTitle: 'Reporte Vacaciones',
        initButtons: 'reporte',
         WindowWidth: 400,
        WindowHeight:250,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        layerEndOn: false,
        ableBackWindow: true
    });
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Vacaciones',
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
Vacaciones.actualizarabono=function (option) {
    this.action = 'actualizarabono'; 
    
    this.open(this.getOptions(option));
}
Vacaciones.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    if ($('#'+Vacaciones.Id('contenedorVacaciones')).attr('style')=='') {
 /// hay posibilidad de horas vacacion

 error=this.validadFormulario();
 if (error) {
    Vacaciones.showMessageError('Revise los datos!! ');
 }else if(parseFloat( $('#'+Vacaciones.Id('conttDiasVacacion')).html())<=0){
    $('#'+Vacaciones.Id('hi')).css('background-color','#f68c8c');
    $('#'+Vacaciones.Id('mi')).css('background-color','#f68c8c');
    $('#'+Vacaciones.Id('hs')).css('background-color','#f68c8c');
    $('#'+Vacaciones.Id('ms')).css('background-color','#f68c8c');
    Vacaciones.showMessageError('El intervalo de Horas Seleccionadas No son validas... '); 
    error=true;
 }


    }else{
        
        Vacaciones.closeWindow(); 
       
    }
 return error;
    
}
Vacaciones.Reportegeneralvacaciones=function(){
    this.action = 'reportegeneralvacaciones';
    this.open(this.getOptions());   
   
}
Vacaciones.saldovacacion = function () {
    this.action = 'saldovacacion';
    this.open(this.getOptions());
}

Vacaciones.adicionarvacacion = function () {
    this.action = 'adicionarvacacion';
    this.open(this.getOptions());
}
Vacaciones.quitarvacacion = function () {
    this.action = 'quitarvacacion';
    this.open(this.getOptions());
}
Vacaciones.ReporteVacaciones=function(){
    this.action = 'ReporteVacaciones';
    this.open(this.getOptions());   
   
}
Vacaciones.beforeSaldovacacion=function () {
  return false;
}
Vacaciones.afterSaldovacacion=function () {
  Vacaciones.closeWindow();
}
Vacaciones.beforeAdicionarvacacion=function () {
  return this.validarFormularioAdicionarvacacion();
}
Vacaciones.afterAdicionarvacacion=function () {
  Vacaciones.closeWindow();
}
Vacaciones.beforeQuitarvacacion=function () {
  return this.validarFormularioQuitarvacacion();
}
Vacaciones.afterQuitarvacacion=function () {
  Vacaciones.closeWindow();
}
Vacaciones.beforeReportegeneralvacaciones=function () {
  return false;
}
Vacaciones.afterReportegeneralvacaciones=function () {
  Vacaciones.closeWindow();
}
Vacaciones.beforeReporteVacaciones=function () {
  return false;
}
Vacaciones.afterReporteVacaciones=function () {
  Vacaciones.closeWindow();
}
Vacaciones.afterCreate = function () {
  Vacaciones.printVacacion();  
    Vacaciones.reload();
}

Vacaciones.beforeUpdate = function () {
   var r= this.validadFormulario2();
if (r==false) {
//Vacaciones.closeWindow();
}else{
    r=true;
  Vacaciones.showMessageError('Revise los datos !! ');  
}
return r;
}
Vacaciones.afterUpdate = function () {

Vacaciones.closeWindow();
    
}
Vacaciones.beforeActualizarabono= function () {
     var valor=$('#'+Vacaciones.Id('diasabono')).val();
    var error=isNaN(valor);
     if (error ||parseFloat(valor)<=0 ){
         error=true;
         $('#'+Vacaciones.Id('diasabono')).css('background-color', '#f68c8c');
         Vacaciones.showMessageError('Revise sus datos ');
     }else{
         $('#'+Vacaciones.Id('diasabono')).css('background-color', '#ffffff');
     }
    return error;
}
Vacaciones.afterActualizarabono = function () {
  Vacaciones.closeWindow();
  Vacaciones.reload();
   
   
}
Vacaciones.dameInformacionEmpleado=function (idempleado) {

        $.ajax({
        'type':'post',
        'url':'rrhh/vacaciones/dameInformacionEmpleado',
        'data':{ide:idempleado,nombre:Vacaciones.groupForm},
        success:function (resp) {
            var vec=jQuery.parseJSON(resp);
            var dv=vec.diasva;
            var hv=vec.observacion;
            
            if (hv.length!=0 ) {
              
                if (dv!=0) {
                $('#'+Vacaciones.Id('contenedorMensaje')).html(hv);
                }else{
                   $('#'+Vacaciones.Id('contenedorMensaje')).html('<div class="row" ><p class="alert alert-info">El empleado no cuenta con dias de vacación... </p></div>');
                }
                 $('#'+Vacaciones.Id('contenedorMensaje')).show();
                  $('#'+Vacaciones.Id('contenedorVacaciones')).hide();
         
            }else{
              
              $('#'+Vacaciones.Id('conttDiasVacacion')).html('0');
              $('#'+Vacaciones.Id('contDiasVacaciont')).html('0');
              $('#'+Vacaciones.Id('contDiasVacacionH')).html(hv);
              $('#'+Vacaciones.Id('contDiasVacacion')).html(dv);
              $('#'+Vacaciones.Id('contFechaContratacion')).html(vec.fechacontratacion);
              $('#' + Vacaciones.Id("fechadesde")).attr('value','');
              $('#' + Vacaciones.Id("fechahasta")).attr('value','');
              $('#'+Vacaciones.Id('contHorario')).empty();
           
            $('#' + Vacaciones.Id("fechadesde")).datepicker("option", "minDate", vec.fechaminima);
            $('#' + Vacaciones.Id("fechahasta")).datepicker("option", "minDate", vec.fechaminima);

              $('#'+Vacaciones.Id('contenedorVacaciones')).show();
                $('#'+Vacaciones.Id('contenedorMensaje')).hide();                 
            }
           
   

       },
        error:function () {
            alert('ocurrio un error al optener los datos del empleado...');
        }

    });
   
    
}
Vacaciones.dameFechaMax=function(fechadesde){
   
 var res = fechadesde.split("-");
var f=res[2]+'-'+res[1]+'-'+res[0];
f=new Date(f);
f.setDate(f.getDate() + 1);
var idempleado=$('#'+Vacaciones.Id('idempleado')).val();
console.log("damefechamaxima fechadesde= "+fechadesde);
console.log("damefechamaxima idempleado = "+idempleado);
console.log("damefechamaxima f = "+f);


    $('#' + Vacaciones.Id("fechahasta")).datepicker("option", "minDate", fechadesde);
    $('#' + Vacaciones.Id("fechahasta")).val('');
    var fechaa='';
   
     
      if ($('#'+Vacaciones.Id('tipo')).prop('checked')) {
          console.log("deberia mostrar horario.......");
$.ajax({
    type:'post',
    url:'rrhh/vacaciones/MostrarhorarioFecha',
    data:{ 
    idempleado:idempleado,
    fecha:fechadesde
    },
    success:function (resp) {
         var vec=jQuery.parseJSON(resp);
            
        $('#'+Vacaciones.Id('contHorario')).html(vec.horario);
        $('#'+Vacaciones.Id('hi')).attr('data-horario',vec.hi);
        $('#'+Vacaciones.Id('mi')).attr('data-horario',vec.mi);
        $('#'+Vacaciones.Id('hs')).attr('data-horario',vec.hs);
        $('#'+Vacaciones.Id('ms')).attr('data-horario',vec.ms);
        console.log("antes de convertir "+vec.fechalimite)
         fechaa= new Date( vec.fechalimite);  
         console.log("despues de convertir "+fechaa);
         $('#' + Vacaciones.Id("fechahasta")).datepicker("option", "maxDate", fechaa);
         

            },
    error:function (er) {
        
        console.log(er);
    }
  });

      }else{
        console.log('ssss--->'+fechadesde+'....'+idempleado);
   $.ajax({
      
        'type':'post',
        'url':'rrhh/vacaciones/dameFechaMax',
        'data':{fecha:fechadesde,ide:idempleado},
        success:function (resp) {

            var vec=jQuery.parseJSON(resp);
            console.log(vec);
            var dias=vec.dias;
            fechaa= new Date( vec.fechalimite);    
            
            $('#'+Vacaciones.Id('contDiasVacaciont')).html(dias);
            $('#'+Vacaciones.Id('conttDiasVacacion')).html('0');
            $('#' + Vacaciones.Id("fechahasta")).datepicker("option", "maxDate", fechaa);
           // $('#'+Vacaciones.Id('fechahasta')).val();
           
       },
        error:function () {
            alert('ocurrio un error ');
        }

    });
      }

      
      

}
Vacaciones.dameFechaMax1=function(fechadesde){
   
 var res = fechadesde.split("-");
var f=res[2]+'-'+res[1]+'-'+res[0];
f=new Date(f);
f.setDate(f.getDate() + 1);

    $('#' + Vacaciones.Id("fechahasta")).datepicker("option", "minDate", f);
    $('#' + Vacaciones.Id("fechahasta")).val('');
    var fechaa;
      $.ajax({
        async: false,
        'type':'post',
        'url':'rrhh/vacaciones/dameFechaMax1',
        'data':{fecha:fechadesde,id:$('#'+Vacaciones.Id('id')).val(),ide:$('#'+Vacaciones.Id('idempleado')).val()},
        success:function (resp) {
          
            var vec=jQuery.parseJSON(resp);
            console.log(vec);
            var dias=vec.dias;
            fechaa= new Date( vec.fechalimite);  
            console.log(" La fecha maxima es "+fechaa);
            if (vec.fechaminima!=='') {
            $('#' + Vacaciones.Id("fechadesde")).datepicker("option", "minDate", new Date(vec.fechaminima));
            }
            $('#'+Vacaciones.Id('contDiasVacaciont')).html(dias);
            $('#'+Vacaciones.Id('conttDiasVacacion')).html('0');
            $('#' + Vacaciones.Id("fechahasta")).datepicker("option", "maxDate", fechaa);
           
           
       },
        error:function () {
            alert('ocurrio un error ');
        }

    });
     


}
Vacaciones.dameFechaMax2=function(fechadesde){
   
 

  var idempleado=$('#'+Vacaciones.Id('idempleado')).val();
     $.ajax({
    type:'post',
    url:'rrhh/vacaciones/MostrarhorarioFecha',
    data:{ 
    idempleado:idempleado,
    fecha:fechadesde
    },
    success:function (resp) {
         var vec=jQuery.parseJSON(resp);
            
        $('#'+Vacaciones.Id('contHorario')).html(vec.horario);
        $('#'+Vacaciones.Id('hi')).attr('data-horario',vec.hi);
        $('#'+Vacaciones.Id('mi')).attr('data-horario',vec.mi);
        $('#'+Vacaciones.Id('hs')).attr('data-horario',vec.hs);
        $('#'+Vacaciones.Id('ms')).attr('data-horario',vec.ms);
   

            },
    error:function (er) {
        
        console.log(er);
    }
  });
     

}
//actionDameDiasPorTomar
Vacaciones.dameDiasPorTomar=function(fechahasta){
    if (fechahasta!='') {
 $.ajax({
      
        'type':'post',
        'url':'rrhh/vacaciones/dameDiasPorTomar',
        'data':{ fechadesde:$('#'+Vacaciones.Id('fechadesde')).val(), fechahasta:fechahasta,ide:$('#'+Vacaciones.Id('idempleado')).val()},
        success:function (resp) {
            console.log(resp);
          var vec=jQuery.parseJSON(resp);
            $('#'+Vacaciones.Id('contHorario')).html(vec.horario);
            $('#'+Vacaciones.Id('conttDiasVacacion')).html(vec.dias);
       },
        error:function () {
            alert('ocurrio un error  ');
        }

    });}
      
}
Vacaciones.validadFormulario=function () {
    var error=false;
    var canterror=0;
    if ($('#'+Vacaciones.Id('empleado')).val()=='') {
        $('#'+Vacaciones.Id('empleado')).css('background-color','#f68c8c');
        canterror+=1;

    }else{
        $('#'+Vacaciones.Id('empleado')).css('background-color','#fff');

    }
     if ($('#'+Vacaciones.Id('fechasolicitud')).val()=='') {
        $('#'+Vacaciones.Id('fechasolicitud')).css('background-color','#f68c8c');
        canterror+=1;

    }else{
        $('#'+Vacaciones.Id('fechasolicitud')).css('background-color','#fff');

    }
    if ($('#'+Vacaciones.Id('fechadesde')).val()=='') {
        $('#'+Vacaciones.Id('fechadesde')).css('background-color','#f68c8c');
        canterror+=1;

    }else{
        $('#'+Vacaciones.Id('fechadesde')).css('background-color','#fff');

    }
if ($('#'+Vacaciones.Id('tipo')).prop('checked')) {
   
     ///////////// por hora
    
    canterror+=this.validarHoras();

    /////////////fin por hora/////
}
    else{
        /////por dia
 if ($('#'+Vacaciones.Id('fechahasta')).val()=='') {
        $('#'+Vacaciones.Id('fechahasta')).css('background-color','#f68c8c');
        canterror+=1;

    }else{
        $('#'+Vacaciones.Id('fechahasta')).css('background-color','#fff');

    }
     /////fin por dia
    }
    if (canterror>0) {
          // 
        error=true;
    }

     return error;

    
}

Vacaciones.validadFormulario2=function () {
    var error=false;
    var canterror=0;
     if ($('#'+Vacaciones.Id('empleado')).val()=='') {
        $('#'+Vacaciones.Id('empleado')).css('background-color','#f68c8c');
        canterror+=1;

    }else{
        $('#'+Vacaciones.Id('empleado')).css('background-color','#fff');

    }
    if ($('#'+Vacaciones.Id('fechadesde')).val()=='') {
        $('#'+Vacaciones.Id('fechadesde')).css('background-color','#f68c8c');
        canterror+=1;

    }else{
        $('#'+Vacaciones.Id('fechadesde')).css('background-color','#fff');

    }
if ($('#'+Vacaciones.Id('tipo')).val()=='1') {
   
     ///////////// por hora
    
    canterror+=this.validarHoras();

    /////////////fin por hora/////
}
    else{
        /////por dia
 if ($('#'+Vacaciones.Id('fechahasta')).val()=='') {
        $('#'+Vacaciones.Id('fechahasta')).css('background-color','#f68c8c');
        canterror+=1;

    }else{
        $('#'+Vacaciones.Id('fechahasta')).css('background-color','#fff');

    }
     /////fin por dia
    }
    if (canterror>0) {
          // 
        error=true;
    }

     return error;

    
}
Vacaciones.Mostrar=function (elemento) {
    if ($('#'+Vacaciones.Id('tipo')).prop('checked')) {
        
        $('#'+Vacaciones.Id('conthoras')).show();
        $('#'+Vacaciones.Id('ocularfecha')).hide();
        $('label[for="'+Vacaciones.groupForm+'_fechadesde"]').html('Fecha');
        $('#'+Vacaciones.Id('etiquetahd')).html('Horas por Tomar:');
        $('#'+Vacaciones.Id('conttDiasVacacion')).html('');
         
   Vacaciones.Fechasminimas(1);
   Vacaciones.dameFechaMax($('#'+Vacaciones.Id('fechadesde')).val())
    }
    else{
               
        $('#'+Vacaciones.Id('conthoras')).hide();
        $('#'+Vacaciones.Id('ocularfecha')).show();
        $('#'+Vacaciones.Id('etiquetahd')).html('Dias por Tomar:');
        $('#'+Vacaciones.Id('conttDiasVacacion')).html('');
        $('label[for="'+Vacaciones.groupForm+'_fechadesde"]').html('Desde');
         Vacaciones.Fechasminimas(2);
      
    }
  
    

     
}
Vacaciones.validarHoras=function(){
var error=false;
var canterror=0;
var hi=$('#'+Vacaciones.Id('hi')).val();
var mi=$('#'+Vacaciones.Id('mi')).val()
var hs=$('#'+Vacaciones.Id('hs')).val();
var ms=$('#'+Vacaciones.Id('ms')).val();
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
 var horaip=$('#'+Vacaciones.Id('hi')).attr('data-horario')+':'+$('#'+Vacaciones.Id('mi')).attr('data-horario');
 var horasp=$('#'+Vacaciones.Id('hs')).attr('data-horario')+':'+$('#'+Vacaciones.Id('ms')).attr('data-horario');
 var horas=hs+':'+ms;
  if (horai>=horaip  && horai<horasp) {
    $('#'+Vacaciones.Id('hi')).css('background-color','#fff');
     $('#'+Vacaciones.Id('mi')).css('background-color','#fff');
    
    
  }else{
    console.log(horai+'....'+horaip+'....'+horasp);
    $('#'+Vacaciones.Id('hi')).css('background-color','#f68c8c');
     $('#'+Vacaciones.Id('mi')).css('background-color','#f68c8c');
   canterror+=1;
  }
  if (horas>horai  && horas<=horasp) {
    $('#'+Vacaciones.Id('hs')).css('background-color','#fff');
     $('#'+Vacaciones.Id('ms')).css('background-color','#fff');
    
    
  }else{
    $('#'+Vacaciones.Id('hs')).css('background-color','#f68c8c');
     $('#'+Vacaciones.Id('ms')).css('background-color','#f68c8c');
   canterror+=1;
  }
 
return canterror;

}

Vacaciones.MostrarHoras=function(){
   this.validarHoras();
   var fecha =$('#'+Vacaciones.Id('fechadesde')).val();
   if (fecha!=='') {
   var idempleado=$('#'+Vacaciones.Id('idempleado')).val();
   var hi =$('#'+Vacaciones.Id('hi')).val();
   var hs =$('#'+Vacaciones.Id('hs')).val();
   var mi=$('#'+Vacaciones.Id('mi')).val();
   var ms =$('#'+Vacaciones.Id('ms')).val();
     $.ajax({
      
        'type':'post',
        'url':'rrhh/vacaciones/dameHorasPorTomar',
        'data':{ fechadesde:$('#'+Vacaciones.Id('fechadesde')).val(), hi:hi,hs:hs,mi:mi,ms:ms,idempleado:idempleado},
        success:function (resp) {  
                $('#'+Vacaciones.Id('conttDiasVacacion')).html(resp);
            },
        error:function () {
            alert('ocurrio un error ');
        }

    });



}

}
Vacaciones.descargarReporteVacacionPDF=function(){
  if($('#'+Vacaciones.Id('fechadesde')).val()=='')
  {     $('#'+Vacaciones.Id('fechadesde')).css('background-color','#f68c8c');
        Vacaciones.showMessageError('Revise los datos !! '); 
        
  }
  else{     
      var datos = this.prepareSend($('#' + this.groupForm).serialize())
      var urlCompleta = 'ImprimirReportegeneralvacaciones?' + datos ;
      this.openUrl(urlCompleta); 
        $('#'+Vacaciones.Id('fechadesde')).css('background-color','#ffffff');
    
  }
      
}
Vacaciones.Fechasminimas=function(tipo){
  $.ajax({
      
        'type':'post',
        'url':'rrhh/vacaciones/damefechasminimas',
        'data':{ ide:$('#'+Vacaciones.Id('idempleado')).val(), tipo:tipo},
        success:function (resp) {  
                var vec=jQuery.parseJSON(resp);           
                 $('#' + Vacaciones.Id("fechadesde")).datepicker("option", "minDate", vec.fechaminima);
                 $('#' + Vacaciones.Id("fechahasta")).datepicker("option", "minDate", vec.fechaminima);   
     

       },
        error:function () {
            alert('ocurrio un error ');
        }

    });   
}
Vacaciones.mostrarOpcion=function(tipo){
    $.ajax({
       'type':'post',
       'url':'rrhh/vacaciones/listaempleadostipo',
       'data':{tipo:tipo,nombre: Vacaciones.groupForm},
       success:function (resp) {          
        $('#'+Vacaciones.Id('contempleados')).html(resp);       

      },
       error:function () {
           alter('ocurrio un error al optener listado empleados...');
       }
   }); 
}
Vacaciones.mostrarOpcionquitar=function(){
    dias=$('#'+Vacaciones.Id('dias')).val();
    tipo=$('#'+Vacaciones.Id('tipo')).val();
    ndias=parseFloat( $('#'+Vacaciones.Id('dias')).val());
    if($('#'+Vacaciones.Id('fechadesde')).val()!=''&& tipo!=''&& ndias>0 &&  dias!=''&& $('#'+Vacaciones.Id('jornada')).val()!='') {
       
            $('#'+Vacaciones.Id('mensaje')).html('');
                $.ajax({
               'type':'post',
               'url':'rrhh/vacaciones/listaempleadosquitar',
               'data':{fecha:$('#'+Vacaciones.Id('fechadesde')).val(),tipo:tipo, dias:ndias,jornada:$('#'+Vacaciones.Id('jornada')).val(),nombre: Vacaciones.groupForm},
               success:function (resp) {          
                $('#'+Vacaciones.Id('contempleados')).html(resp);       

              },
               error:function () {
                   alert('ocurrio un error al optener listado empleados...');
               }
           }); 
   
  
}else{
        var grilla=this.getSGridView('gridEmpleados');    
    console.log(grilla);
     for (var f = 1; f <= grilla.rows; f++) {  
     
         grilla.delRow(1);
      
 }
     $('#'+Vacaciones.Id('tipo>option:first')).prop('selected','selected');

    $('#'+Vacaciones.Id('mensaje')).html('<div class="alert alert-info"><p>Previamente se debe seleccionar Fecha , Cantidad de dias y la Jornada  </p></div>');

}
}
Vacaciones.validarFormularioAdicionarvacacion=function(){
    var error=false;
    var grilla=this.getSGridView('gridEmpleados');    
    var cantidad=0;
     for (var f = 1; f <= grilla.rows; f++) {  
      if ( grilla.row(f).get('nombrecompleto')!='' ){
          cantidad=1;
          break
      }
 }
   
    console.log("la cantidad ="+cantidad);
    if ($('#'+Vacaciones.Id('fechadesde')).val()=='') {
       error=true;
       $('#'+Vacaciones.Id('fechadesde')).css('background-color','#f68c8c');             
     } 
    else{
      $('#'+Vacaciones.Id('fechadesde')).css('background-color','#fff');
   }
    if ($('#'+Vacaciones.Id('dias')).val()=='0'|| parseInt($('#'+Vacaciones.Id('dias')).val())<0) {
       error=true;
       $('#'+Vacaciones.Id('dias')).css('background-color','#f68c8c');             
     } 
    else{
      $('#'+Vacaciones.Id('dias')).css('background-color','#fff');
   }
   if ($('#'+Vacaciones.Id('observacion')).val()=='0') {
       error=true;
       $('#'+Vacaciones.Id('observacion')).css('background-color','#f68c8c');             
     } 
    else{
      $('#'+Vacaciones.Id('observacion')).css('background-color','#fff');
   }
   if(error==true){
        Vacaciones.showMessageError('Revise sus datos!'); 
   }else if(cantidad==0){
       error=true;
        Vacaciones.showMessageError('Lista de empleados no puede estar vacia!!'); 
   }
   return error;
}

Vacaciones.validarFormularioQuitarvacacion=function(){
    var error=false;
    var cant=0;
    var grilla=this.getSGridView('gridEmpleados'); 
    if ($('#'+Vacaciones.Id('fechadesde')).val()=='') {
       error=true;
       $('#'+Vacaciones.Id('fechadesde')).css('background-color','#f68c8c');             
     } 
    else{
      $('#'+Vacaciones.Id('fechadesde')).css('background-color','#fff');
    }
   
    if (parseFloat( $('#'+Vacaciones.Id('dias')).val())<=0) {
       error=true;
       $('#'+Vacaciones.Id('dias')).css('background-color','#f68c8c');             
     } 
    else{
      $('#'+Vacaciones.Id('dias')).css('background-color','#fff');
    }
    if ($('#'+Vacaciones.Id('tipo')).val()=='') {
       error=true;
       $('#'+Vacaciones.Id('tipo')).css('background-color','#f68c8c');             
     } 
    else{
      $('#'+Vacaciones.Id('tipo')).css('background-color','#fff');
    }
    if ($('#'+Vacaciones.Id('jornada')).val()=='') {
       error=true;
       $('#'+Vacaciones.Id('jornada')).css('background-color','#f68c8c');             
     } 
    else{
      $('#'+Vacaciones.Id('jornada')).css('background-color','#fff');
    }
       
     for (var f = 1; f <= grilla.rows; f++) {  
      if ( grilla.row(f).get('nombrecompleto')!='' ){
          if (grilla.row(f).get('tipo')=='3') {
            ++cant;
           
            grilla.row(f).attributes('nombrecompleto', {tooltip: '', validate: false});

            }else{
             grilla.row(f).attributes('nombrecompleto', {tooltip: '', validate: true});

            }
      }
 }
   if(error==true || cant>0){
        Vacaciones.showMessageError('Revise sus datos!'); 
        error=true;
   }
   return error;
}
Vacaciones.printVacacion = function () {
    var url = this.url+'/imprimirVacacionAlCrear';
    this.openUrl(url);
};
Vacaciones.ResaltarObservados=function(){
   
   var grilla=this.getSGridView('gridEmpleados'); 
   
    var cant=0;
     for (var f = 1; f <= grilla.rows; f++) {  
      if ( grilla.row(f).get('nombrecompleto')!='' ){
          if (grilla.row(f).get('tipo')=='3') {
            ++cant;           
            grilla.row(f).attributes('nombrecompleto', {tooltip: '', validate: false});

            }else{
             grilla.row(f).attributes('nombrecompleto', {tooltip: '', validate: true});

            }
      }
 } 
 if (cant>0){
     $('#'+Vacaciones.Id('mensaje')).html('<div class="alter alert-info">El personal resaltodo ,tiene permiso asignado en el rango de hora-dia o cuenta con Saldo Insuficiente... </div>');
 }else{
     $('#'+Vacaciones.Id('mensaje')).html('');

 }
}
Vacaciones.descargarReporteVacaciones=function(){
  var cantidad=0;
  if($('#'+Vacaciones.Id('fechadesde')).val()=='')
  {     $('#'+Vacaciones.Id('fechadesde')).css('background-color','#f68c8c');
        cantidad+=1;        
  }
  else{     
        $('#'+Vacaciones.Id('fechadesde')).css('background-color','#ffffff');    
  }
  if($('#'+Vacaciones.Id('fechahasta')).val()=='')
  {     $('#'+Vacaciones.Id('fechahasta')).css('background-color','#f68c8c');
        cantidad+=1;        
  }
  else{     
        $('#'+Vacaciones.Id('fechahasta')).css('background-color','#ffffff');    
  }
 
  if (cantidad==0){
      var datos = this.prepareSend($('#' + this.groupForm).serialize()) + this.gestionSchemaMain();
      this.downloadFile(this.urlIni + this.url + '/DescargarReporteVacaciones?' + datos );
    
  }else{
      Vacaciones.showMessageError('Revise los datos !! '); 
  }
  
  
      
}

Vacaciones.descargarReporteVacacionXLS = function() {
    if ($('#s2id_' + Vacaciones.groupForm + '_area>ul>li[class="select2-search-choice"]').length > 0 && $('#'+Vacaciones.Id('fechadesde')).val()!='') {
        if( $("#" + Vacaciones.Id('fechadesde')).val()==''){
             $('#' + Vacaciones.Id('fechadesde')).css('background-color', '#ffffff');
        }
        
        var datos = this.prepareSend($('#' + this.groupForm).serialize()) + this.gestionSchemaMain();
        this.downloadFile(this.urlIni + this.url + '/DescargarReporteGeneralVacacionXLS?' + datos );
    
    } else {
        if( $("#" + Vacaciones.Id('fechadesde')).val()==''){
             $('#' + Vacaciones.Id('fechadesde')).css('background-color', '#f68c8c');
        }
       
         Vacaciones.showMessageError('Debe seleccionar Area - fecha  !! ');
        }
}