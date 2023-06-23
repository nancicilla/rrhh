var Historialbancohoras = new Object();
Historialbancohoras.__proto__ = SystemWindow;
//variables
Historialbancohoras.nameView = "Historialbancohoras";
Historialbancohoras.url = "historialbancohoras";
Historialbancohoras.init = function () {
  var THIS=this;
 if (this.action == 'create'||this.action == 'saldohistorialbancohoras'||  this.action == 'update'||this.action=='registrogrupal') {
  
 this.buttonChange({id: 'save', label: 'Guardar', key: 'G'});  

  
}}
Historialbancohoras.options = function () {
    this.setActions('create', {
        WindowTitle: 'Registro Permiso(Hora en Contra)',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Compensacion ',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('saldohistorialbancohoras', {        
      WindowTitle: 'Saldo Historial Banco Horas',
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
  this.setActions('registrogrupal', {        
      WindowTitle: 'Registro Grupal Banco Horas',
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
 
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Historialbancohoras',
        WindowWidth: 400,
        WindowHeight: 550,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}
Historialbancohoras.saldohistorialbancohoras = function () {
  this.action = 'saldohistorialbancohoras';
  this.open(this.getOptions());
}
Historialbancohoras.registrogrupal = function () {
  this.action = 'registrogrupal';
  this.open(this.getOptions());
}
Historialbancohoras.beforeCreate = function () {
    var error = this.validarFormulario();//false es no existe error antes de crear formulario
    return error;
}
Historialbancohoras.afterCreate = function () {
    Historialbancohoras.printBancohora(); 
    Historialbancohoras.reload();
}

Historialbancohoras.beforeUpdate = function () {
    var error = this.validarFormularioUpdate();//false es no existe error antes de actulizar formulario
   
    return error;
}
Historialbancohoras.afterUpdate = function () {
    Historialbancohoras.closeWindow();
}
Historialbancohoras.beforeRegistrogrupal = function () {
    var error = this.validarFormularioRegistrGrupal();//false es no existe error antes de actulizar formulario
   
    return error;
}
Historialbancohoras.afterRegistrogrupal = function () {
    Historialbancohoras.closeWindow();
}
Historialbancohoras.beforeSaldohistorialbancohoras=function () {
      var error=false;
      var cant=0;
    if ($('#'+Historialbancohoras.Id('fechadesde')).val()==''){
         $('#'+Historialbancohoras.Id('fechadesde')).css('background-color','#f68c8c');
      cant=1;
        
    }else{
     $('#'+Historialbancohoras.Id('fechadesde')).css('background-color','#ffffff');    
    }
    if ($('#'+Historialbancohoras.Id('descripcion')).val()==''){
         $('#'+Historialbancohoras.Id('descripcion')).css('background-color','#f68c8c');
      cant=1;
        
    }else{
     $('#'+Historialbancohoras.Id('descripcion')).css('background-color','#ffffff');    
    }
    if (cant>0){
        error=true;
        
        Historialbancohoras.showMessageError('Revise los datos !! ');
    }
  return error;
}
Historialbancohoras.afterSaldohistorialbancohoras=function () {
  Historialbancohoras.closeWindow();
  
}


Historialbancohoras.dameInformacionEmpleado=function (idempleado) {

   
     $.ajax({
        'type':'post',
        'url':'rrhh/historialbancohoras/dameInformacionEmpleado',
        'data':{ide:idempleado,nombre:Historialbancohoras.groupForm},
        success:function (resp) {
            //{"canthoras":0,"respuesta":"","observacion":"","fechaminima":"2020-09-01"}
            var vec=jQuery.parseJSON(resp);
          console.log(resp);
            var canthoras=vec.canthoras +' '+ vec.respuesta;
            var hv=vec.observacion;
            $('#' + Historialbancohoras.Id("fechadesde")).datepicker("option", "minDate", vec.fechaminima);
          

            $('#'+Historialbancohoras.Id('conthoras')).html(canthoras);
              
            
            if (hv.length!=0 ) {
              
                if (dv!=0) {
                $('#'+Historialbancohoras.Id('contenedorMensaje')).html(hv);
                }else{
                   $('#'+Historialbancohoras.Id('contenedorMensaje')).html('<div class="row" ><p class="alert alert-info">El empleado no cuenta con Horas a Favor... </p></div>');
                }
                 $('#'+Historialbancohoras.Id('contenedorMensaje')).show();
                  $('#'+Historialbancohoras.Id('contenedorHistorialbancohoras')).hide();
         
            }else{
              
            
              $('#' + Historialbancohoras.Id("fechadesde")).attr('value','');
              $('#' + Historialbancohoras.Id("fechahasta")).attr('value','');
              $('#'+ Historialbancohoras.Id('contHorario')).empty();      
               
         
              $('#'+Historialbancohoras.Id('contenedorHistorialbancohoras')).show();
                $('#'+Historialbancohoras.Id('contenedorMensaje')).hide();                 
            }
           
            

       },
        error:function () {
            alert('ocurrio un error al optener los datos del empleado...');
        }

    });
   
    
}
Historialbancohoras.dameFechaMax=function(fechadesde){
   
 var res = fechadesde.split("-");
var f=res[2]+'-'+res[1]+'-'+res[0];
f=new Date(f);
f.setDate(f.getDate() + 1);
var idempleado=$('#'+Historialbancohoras.Id('idempleado')).val();
var id=$('#'+Historialbancohoras.Id('id')).val();

    $('#' + Historialbancohoras.Id("fechahasta")).datepicker("option", "minDate", fechadesde);
      
     
if ($('#'+Historialbancohoras.Id('tipo')).prop('checked')) {
$.ajax({
    type:'post',
    url:'rrhh/historialbancohoras/MostrarhorarioFecha',
    data:{ 
    idempleado:idempleado,
    fecha:fechadesde
    },
    success:function (resp) {
         var vec=jQuery.parseJSON(resp);            
        $('#'+Historialbancohoras.Id('contHorario')).html(vec.horario);
        $('#'+Historialbancohoras.Id('hi')).attr('data-horario',vec.hi);
        $('#'+Historialbancohoras.Id('mi')).attr('data-horario',vec.mi);
        $('#'+Historialbancohoras.Id('hs')).attr('data-horario',vec.hs);
        $('#'+Historialbancohoras.Id('ms')).attr('data-horario',vec.ms);
         fechaa= new Date( vec.fechalimite);  
       //  $('#' + Historialbancohoras.Id("fechahasta")).datepicker("option", "maxDate", fechaa);
   

            },
    error:function (er) {
        
        console.log(er);
    }
  });

      }else{
        
   $.ajax({      
        'type':'post',
        'url':'rrhh/historialbancohoras/dameFechaMax',
        'data':{fecha:fechadesde,ide:idempleado,id:id},
        success:function (resp) {
            var vec=jQuery.parseJSON(resp);
            console.log(vec);
            console.log(fechadesde);
            var horas=vec.horas;
            fechaa= new Date( vec.fechalimite); 
           
            $('#'+Historialbancohoras.Id('contHorasPorTomar')).html(0);
           
           // $('#' + Historialbancohoras.Id("fechahasta")).datepicker("option", "maxDate", fechaa);
           
           
       },
        error:function (er) {
            alert('ocurrio un error '+er);
        }

    });
      }

    
      
 
      

}


Historialbancohoras.Mostrar=function (elemento) {
  $('#'+Historialbancohoras.Id('contHorasPorTomar')).html('0');
  var opcion ;
    if ($('#'+Historialbancohoras.Id('tipo')).prop('checked')) {
        $('#'+Historialbancohoras.Id('ocularfecha')).hide();
        $('label[for="'+Historialbancohoras.groupForm+'_fechadesde"]').html('Fecha');
        $('#'+Historialbancohoras.Id('contenedorhoras')).show(); 
       opcion=0;
        

    }
    else{
        opcion=1;
               
              $('#'+Historialbancohoras.Id('ocularfecha')).show();
              
        $('label[for="'+Historialbancohoras.groupForm+'_fechadesde"]').html('Desde');
      $('#'+Historialbancohoras.Id('contenedorhoras')).hide();
   

    }
    $.ajax({      
        'type':'post',
        'url':'rrhh/historialbancohoras/dameFechaminima',
        'data':{ide:$('#'+Historialbancohoras.Id('idempleado')).val(),opcion:opcion},
        success:function (resp) {
           
           $('#' + Historialbancohoras.Id("fechadesde")).datepicker("option", "minDate", resp);
            $('#' + Historialbancohoras.Id("fechahasta")).datepicker("option", "minDate", resp);
           
           
       },
        error:function (er) {
            alert('ocurrio un error '+er);
        }

    });
$('#'+Historialbancohoras.Id('contHorario')).html('');
    

     
}


Historialbancohoras.validarHoras=function(){

    var canterror=0;
    var hi=$('#'+Historialbancohoras.Id('hi')).val();
    var mi=$('#'+Historialbancohoras.Id('mi')).val();
    var hs=$('#'+Historialbancohoras.Id('hs')).val();
    var ms=$('#'+Historialbancohoras.Id('ms')).val();
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
     var horaip=$('#'+Historialbancohoras.Id('hi')).attr('data-horario')+':'+$('#'+Historialbancohoras.Id('mi')).attr('data-horario');
     var horasp=$('#'+Historialbancohoras.Id('hs')).attr('data-horario')+':'+$('#'+Historialbancohoras.Id('ms')).attr('data-horario');
     var horas=hs+':'+ms;
      if (horai>=horaip  && horai<horasp) {
        $('#'+Historialbancohoras.Id('hi')).css('background-color','#fff');
        $('#'+Historialbancohoras.Id('mi')).css('background-color','#fff');
           
      }else{
       
        $('#'+Historialbancohoras.Id('hi')).css('background-color','#f68c8c');
        $('#'+Historialbancohoras.Id('mi')).css('background-color','#f68c8c');
        canterror+=1;
      }
      if (horas>horai  && horas<=horasp) {
        $('#'+Historialbancohoras.Id('hs')).css('background-color','#fff');
        $('#'+Historialbancohoras.Id('ms')).css('background-color','#fff');
              
      }else{
        $('#'+Historialbancohoras.Id('hs')).css('background-color','#f68c8c');
        $('#'+Historialbancohoras.Id('ms')).css('background-color','#f68c8c');
        canterror+=1;
      }
    
    return canterror;
    
    }


    Historialbancohoras.MostrarHoras=function(){
        this.validarHoras();
          var fecha =$('#'+Historialbancohoras.Id('fechadesde')).val();
          if (fecha!=='') {
         var idempleado=$('#'+Historialbancohoras.Id('idempleado')).val();
         var hi =$('#'+Historialbancohoras.Id('hi')).val();
         var hs =$('#'+Historialbancohoras.Id('hs')).val();
         var mi=$('#'+Historialbancohoras.Id('mi')).val();
         var ms =$('#'+Historialbancohoras.Id('ms')).val();
           $.ajax({
            
              'type':'post',
              'url':'rrhh/historialbancohoras/dameHorasPorTomar',
              'data':{ fechadesde:$('#'+Historialbancohoras.Id('fechadesde')).val(), hi:hi,hs:hs,mi:mi,ms:ms,idempleado:idempleado},
              success:function (resp) {  
                      
                  $('#'+Historialbancohoras.Id('contHorasPorTomar')).html(resp);
                
      
      
             },
              error:function () {
                  alert('ocurrio un error ');
              }
      
          });
      
      
      
      }
      
      }
       Historialbancohoras.validarFormulario=function(){
      var canterror=0;
      var error=false;
        if ($('#'+Historialbancohoras.Id('fechasolicitud')).val()==''){
        $('#'+Historialbancohoras.Id('fechasolicitud')).css('background-color','#f68c8c');
        canterror+=1;
      }else{
        $('#'+Historialbancohoras.Id('fechasolicitud')).css('background-color','#ffffff');
      }
      if ($('#'+Historialbancohoras.Id('fechadesde')).val()==''){
        $('#'+Historialbancohoras.Id('fechadesde')).css('background-color','#f68c8c');
        canterror+=1;
      }else{
        $('#'+Historialbancohoras.Id('fechadesde')).css('background-color','#ffffff');
      }
      if ($('#'+Historialbancohoras.Id('tipo')).prop('checked')) {
      canterror+=this.validarHoras();
     
      }
      else{
        if ($('#'+Historialbancohoras.Id('fechahasta')).val()==''){
          $('#'+Historialbancohoras.Id('fechahasta')).css('background-color','#f68c8c');
          canterror+=1;
        }else{
          $('#'+Historialbancohoras.Id('fechahasta')).css('background-color','#ffffff');
        }
      }    
      if(canterror>0){
        error=true;
        Historialbancohoras.showMessageError('Revise los datos !! ');
      }
      else if(parseFloat( $('#'+Historialbancohoras.Id('contHorasPorTomar')).html())<=0){
            $('#'+Historialbancohoras.Id('hi')).css('background-color','#f68c8c');
            $('#'+Historialbancohoras.Id('mi')).css('background-color','#f68c8c');
            $('#'+Historialbancohoras.Id('hs')).css('background-color','#f68c8c');
            $('#'+Historialbancohoras.Id('ms')).css('background-color','#f68c8c');
            Historialbancohoras.showMessageError('El intervalo de Horas Seleccionadas No son validas... '); 
    error=true;
 }
      return error;
      }
      Historialbancohoras.validarFormularioUpdate=function(){
      var canterror=0;
      var error=false;
       if ($('#'+Historialbancohoras.Id('fechasolicitud')).val()==''){
        $('#'+Historialbancohoras.Id('fechasolicitud')).css('background-color','#f68c8c');
        canterror+=1;
      }else{
        $('#'+Historialbancohoras.Id('fechasolicitud')).css('background-color','#ffffff');
      }
     if ($('#'+Historialbancohoras.Id('fechadesde')).val()==''){
        $('#'+Historialbancohoras.Id('fechadesde')).css('background-color','#f68c8c');
        canterror+=1;
      }else{
        $('#'+Historialbancohoras.Id('fechadesde')).css('background-color','#ffffff');
      }
      
      if ($('#'+Historialbancohoras.Id('tipo')).val()=='1') {
        canterror+=this.validarHoras();
            
      }
      else{
        if ($('#'+Historialbancohoras.Id('fechahasta')).val()==''){
          $('#'+Historialbancohoras.Id('fechahasta')).css('background-color','#f68c8c');
          canterror+=1;
        }else{
          $('#'+Historialbancohoras.Id('fechahasta')).css('background-color','#ffffff');
        }
      } 
      
      if(canterror>0){
        error=true;
        Historialbancohoras.showMessageError('Revise los datos !! ');
      }
      return error;
      }
      
      
      
      Historialbancohoras.damecantHorasPorTomar=function(){
        var desde=$('#'+Historialbancohoras.Id('fechadesde')).val();
       
        var hasta =$('#'+Historialbancohoras.Id('fechahasta')).val();
  
        var idempleado=$('#'+Historialbancohoras.Id('idempleado')).val();
          $.ajax({           
             'type':'post',
             'url':'rrhh/historialbancohoras/dameHorasPorTomarFechas',
             'data':{ fechadesde:desde,fechahasta:hasta,idempleado:idempleado},
             success:function (resp) {  
               //  contHorasPorTomar   
                              
                 $('#'+Historialbancohoras.Id('contHorasPorTomar')).html(resp);    
     
            },
             error:function () {
                 alert('ocurrio un error ');
             }
     
         });

      }
      Historialbancohoras.printBancohora=function(){
           var url = this.url+'/imprimirBanchohoraAlCrear';
            this.openUrl(url);
      }
Historialbancohoras.mostrarOpcionregistrogrupal=function(){
    dias=$('#'+Historialbancohoras.Id('dias')).val();
    tipo=$('#'+Historialbancohoras.Id('tipo')).val();
    ndias=parseFloat( $('#'+Historialbancohoras.Id('dias')).val());
    if($('#'+Historialbancohoras.Id('fechadesde')).val()!=''&& tipo!=''&& ndias>0 &&  dias!=''&& $('#'+Historialbancohoras.Id('jornada')).val()!='') {
       console.log("--->"+$('#'+Historialbancohoras.Id('fechadesde')).val()+'<----'); 
       console.log("--->"+$('#'+Historialbancohoras.Id('tipo')).val()+'<----'); 
       console.log("--->"+$('#'+Historialbancohoras.Id('jornada')).val()+'<----'); 
       console.log("--->"+$('#'+Historialbancohoras.Id('dias')).val()+'<----'); 
            $('#'+Historialbancohoras.Id('mensaje')).html('');
                $.ajax({
               'type':'post',
               'url':'rrhh/historialbancohoras/listaempleadosregistrogrupal',
               'data':{fecha:$('#'+Historialbancohoras.Id('fechadesde')).val(),tipo:tipo, dias:ndias,jornada:$('#'+Historialbancohoras.Id('jornada')).val(),nombre: Historialbancohoras.groupForm},
               success:function (resp) {          
                $('#'+Historialbancohoras.Id('contempleados')).html(resp);       

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
     $('#'+Historialbancohoras.Id('tipo>option:first')).prop('selected','selected');

    $('#'+Historialbancohoras.Id('mensaje')).html('<div class="alert alert-info"><p>Previamente se debe seleccionar Fecha , Cantidad de dias y la Jornada  </p></div>');

}
}
Historialbancohoras.ResaltarObservados=function(){
   
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
     $('#'+Historialbancohoras.Id('mensaje')).html('<div class="alter alert-info">El personal resaltodo ,tiene permiso asignado en el rango de hora-dia ... </div>');
 }else{
     $('#'+Historialbancohoras.Id('mensaje')).html('');

 }
}

Historialbancohoras.validarFormularioRegistrGrupal=function(){
    var error=false;
    var cant=0;
    var grilla=this.getSGridView('gridEmpleados'); 
    if ($('#'+Historialbancohoras.Id('fechadesde')).val()=='') {
       error=true;
       $('#'+Historialbancohoras.Id('fechadesde')).css('background-color','#f68c8c');             
     } 
    else{
      $('#'+Historialbancohoras.Id('fechadesde')).css('background-color','#fff');
    }
   
    if (parseFloat( $('#'+Historialbancohoras.Id('dias')).val())<=0) {
       error=true;
       $('#'+Historialbancohoras.Id('dias')).css('background-color','#f68c8c');             
     } 
    else{
      $('#'+Historialbancohoras.Id('dias')).css('background-color','#fff');
    }
    if ($('#'+Historialbancohoras.Id('tipo')).val()=='') {
       error=true;
       $('#'+Historialbancohoras.Id('tipo')).css('background-color','#f68c8c');             
     } 
    else{
      $('#'+Historialbancohoras.Id('tipo')).css('background-color','#fff');
    }
    if ($('#'+Historialbancohoras.Id('jornada')).val()=='') {
       error=true;
       $('#'+Historialbancohoras.Id('jornada')).css('background-color','#f68c8c');             
     } 
    else{
      $('#'+Historialbancohoras.Id('jornada')).css('background-color','#fff');
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
        Historialbancohoras.showMessageError('Revise sus datos!'); 
        error=true;
   }
   return error;
}   