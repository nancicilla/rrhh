var Entradasalida = new Object();
Entradasalida.__proto__ = SystemWindow;
//variables
Entradasalida.nameView = "Entradasalida";
Entradasalida.url = "entradasalida";
Entradasalida.pfecha='';
Entradasalida.pidempleado='';
Entradasalida.pnombreempleado='';
Entradasalida.ordenarnombre='asc';
Entradasalida.ordenarentrada='desc';
Entradasalida.ordenarsalida='desc';
Entradasalida.ordenarfecha='desc';
Entradasalida.ordenardifentrada='desc';
Entradasalida.ordenardifsalida='desc';
Entradasalida.fechadesde='';
Entradasalida.fechahasta='';
Entradasalida.area='';
Entradasalida.seccion='';
Entradasalida.evento='';
Entradasalida.tipoevento='';
Entradasalida.orden='';

Entradasalida.init = function () {
     var THIS=this;
    if (this.action == 'create'|| this.action == 'Importarasistencia'|| this.action == 'AtrasosEmpleado'|| this.action == 'AsistenciaEmpleado'||this.action == 'update'||this.action=='ReporteHorasAsistidas'||this.action=='seguimiento'||this.action=='cambiarevento'||this.action=='bajasellada'||this.action=='RegistrarTeletrabajo') {
       if (this.action=='create' && Entradasalida.pfecha!=''){
        $('#'+Entradasalida.Id('fechaparametro')).val(Entradasalida.pfecha);
        $('#'+Entradasalida.Id('empleado')).val(Entradasalida.pnombreempleado);
        $('#'+Entradasalida.Id('idempleado')).val(  Entradasalida.pidempleado);
        Entradasalida.dameHorarioEmpleadoF(Entradasalida.pfecha);

       }
    this.buttonChange({id: 'save', label: 'Guardar', key: 'G'});
    if(this.action=='cambiarevento'){
    
        $('#' + this.Id('empleado')).blur(function() {
            if ($('#' + Entradasalida.Id('empleado')).val() == '') {
                this.value = '';
                Entradasalida.ById('empleado').style.background = "";
                Entradasalida.set('idempleado', '');
                Entradasalida.cargartabla();
                Entradasalida.asignareventoscabeceraevento();
            }
        });

    jQuery('#' + Entradasalida.Id('seccion')).autocomplete({ 'source': '/coreT/rrhh/seccion/autocompleteSeccion?area=' + $('#' + Entradasalida.Id('area')).val() });
    if(Entradasalida.fechadesde!=''){
    
    $('#'+Entradasalida.Id('fechadesde')).val(Entradasalida.fechadesde);
    $('#'+Entradasalida.Id('fechahasta')).val(Entradasalida.fechahasta);
     $('#' + Entradasalida.Id('fechahasta')).datepicker("option", "minDate", Entradasalida.fechadesde);
    $('#'+Entradasalida.Id('area>option[value="'+Entradasalida.area+'"]')).prop('selected','selected');    
    $('#'+Entradasalida.Id('seccion')).val(Entradasalida.seccion);
    $('#'+Entradasalida.Id('evento[value="'+Entradasalida.evento+'"]')).trigger( "click" );
    $('#'+Entradasalida.Id('tipoevento>option[value="'+Entradasalida.tipoevento+'"]')).prop('selected','selected');  
    $('#'+Entradasalida.Id('tipoevento')).trigger( "change" );
    
    }
 jQuery('#' + Entradasalida.Id('empleado')).
    autocomplete({ 'source': '/coreT/rrhh/entradasalida/autocompletePersona?area=' + $('#' +  Entradasalida.Id('area')).val() });

    }
           

       
    
  
    $('#' + this.Id('btnBuscarAsistencia')).on('click',function () {
       
       var opcionmostrar=false;
    if($('#'+Entradasalida.Id('mostrartodo')).prop('checked'))
    {
        opcionmostrar=true;
    }
    //console.log($('#s2id_' + Entradasalida.groupForm + '_tipocontrato').children());
    var listacontrato=$('#'+Entradasalida.groupForm +'_tipocontrato')[0]['selectedOptions']
     var lista='';
        for(i=0;i<listacontrato.length;i++){
         lista+=$('#'+Entradasalida.groupForm +'_tipocontrato')[0]['selectedOptions'][i].value+',';
       
     }
   
   
       
        $.ajax({
           'type':'post',
           'url':'rrhh/entradasalida/damelistaasistenciatipo',
           'data':{desde:$('#'+Entradasalida.Id('fechadesde')).val(),hasta:$('#'+Entradasalida.Id('fechahasta')).val(),
           area:$('#'+Entradasalida.Id('area')).val(),
           cargo:$('#'+Entradasalida.Id('cargo')).val(),
           empleado:$('#'+Entradasalida.Id('empleado')).val(),
           tipoobservacion:$('#'+Entradasalida.Id('tipoobservacion')).val(),
           tipocontrato:lista,
           nombre:Entradasalida.groupForm,
            opcion:'fecha::date',  
            mostrartodo:opcionmostrar,
           orden:'desc ,entrada desc,salida desc ,nombrecompleto desc'
                 
        },
    
           success:function (resp) {
           
             $('#'+Entradasalida.Id('contenedorCuerpo')).html(resp);
             Entradasalida.colorear();
             Entradasalida.asignareventoscabecera();
        
    
          },
           error:function () {
               alert('ocurrio un error al obtener los datos del empleado...');
           }
    
       });
    
        
    });
  if(this.action == 'Importarasistencia' )
        {
            Entradasalida.subirArchivoExcel();        
            
        }
        if(this.action == 'seguimiento' )
        {
          Entradasalida.asignareventoscabecera();
            
            
        }

     
};

}

Entradasalida.options = function () {
    this.setActions('create', {
        WindowTitle: 'Registrar Asistencia',
        initButtons: 'save,cancel',
        WindowWidth: 350,
        WindowHeight: 400,
        layerEndOn: false,
        ableBackWindow: true
    });
     this.setActions('ReporteHorasAsistidas', {        
        WindowTitle: 'Reporte de Horas Asistidas',
        initButtons: 'planilla',
        endButtons: 'planilla',
         WindowWidth: 350,
        WindowHeight: 350, 
        layerEndOn: false,
        ableBackWindow: true
    });
     this.setActions('bajasellada', {        
        WindowTitle: 'Eliminar sellada',
        initButtons: 'save,cancel',
         WindowWidth: 300,
        WindowHeight: 200, 
        layerEndOn: false,
        ableBackWindow: true
    });
     this.setActions('RegistrarTeletrabajo', {        
        WindowTitle: 'Registrar Sellada',
        initButtons: 'save,cancel',
         WindowWidth: 300,
        WindowHeight: 200, 
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Entradasalida',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
   this.setActions('Importarasistencia', {        
        WindowTitle: 'Importar Asistencia',
        initButtons: 'save,cancel',
         WindowWidth: 400,
        WindowHeight: 450, 
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('seguimiento', {        
        WindowTitle: 'Seguimiento Avanzado de Asistencia ',
        initButtons: 'reporte,reporteempleado',         
         WindowWidth: 1260,
        WindowHeight: 610, 
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('cambiarevento', {        
        WindowTitle: 'Seguimiento de Asistencia',
        initButtons: 'save,cancel',         
         WindowWidth: 950,
        WindowHeight: 600, 
        layerEndOn: false,
        ableBackWindow: true
    });
      this.setActions('AtrasosEmpleado', {        
        WindowTitle: 'Atrasos Empleado',
        initButtons: 'save,cancel',
         WindowWidth: 400,
        WindowHeight: 300, 
        layerEndOn: false,
        ableBackWindow: true
    });
    
    
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Entradasalida',
        WindowWidth: 700,
        WindowHeight: 400,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}
Entradasalida.ReporteHorasAsistidas=function () {
    this.action = 'ReporteHorasAsistidas';   
    this.open(this.getOptions());
}
Entradasalida.importarasistencia=function () {
    this.action = 'Importarasistencia';   
    this.open(this.getOptions());
}
Entradasalida.seguimiento=function () {
    this.action = 'seguimiento';   
    this.open(this.getOptions());
}
Entradasalida.bajasellada=function (option) {
    this.action = 'bajasellada';   
    this.open(this.getOptions(option));
}
Entradasalida.RegistrarTeletrabajo=function () {
    this.action = 'RegistrarTeletrabajo';   
    this.open(this.getOptions());
}
Entradasalida.cambiarevento=function () {
    this.action = 'cambiarevento';   
    this.open(this.getOptions());
}

Entradasalida.AtrasosEmpleado=function () {
    this.action = 'AtrasosEmpleado';   
    this.open(this.getOptions());
}

Entradasalida.beforeCreate = function () {
     var error = this.validarFormulario();
     return error;
}
Entradasalida.afterCreate = function () {
  Entradasalida.reload();
   
   
}
Entradasalida.beforeBajasellada= function () {
     var tipo=$('#'+Entradasalida.Id('evento')+':checked').val();
    var error;
     if (tipo!== undefined ){
         error=false;
     }else{
         error=true;
          Entradasalida.showMessageError('Debe seleccionar una opcion !! ');
     }
    return error;
}
Entradasalida.afterBajasellada = function () {
  Entradasalida.closeWindow();
  Entradasalida.reload();
   
   
}
Entradasalida.beforeRegistrarTeletrabajo= function () {
    
     if ($('#'+Entradasalida.Id('ci')).val()!=''){
         $('#'+Entradasalida.Id('ci')).css('background-color', '#ffffff');
         error=false;
     }else{
         error=true;
         $('#'+Entradasalida.Id('ci')).css('background-color', '#f68c8c');
          Entradasalida.showMessageError('Revise su Dato !! ');
     }
    return error;
}
Entradasalida.afterRegistrarTeletrabajo = function () { 

   
   
}
Entradasalida.beforeReporteHorasAsistidas = function () {
    var error = this.validarFormularioHorasAsistidas();//false es no existe error antes de crear formulario
  
    return false;
}
Entradasalida.afterReporteHorasAsistidas = function () {
    Entradasalida.closeWindow();
}
Entradasalida.beforeCambiarevento = function () {
    var canterror=0 ;
    var valor;
     if($('#'+Entradasalida.Id('cambiara')).val()==''){
            $('#' + Entradasalida.Id('cambiara')).css('background-color', '#f68c8c');
            canterror++;
            
            
         
     }else{
         $('#' + Entradasalida.Id('cambiara')).css('background-color', '#ffffff');
            
     }
     valor=$('#'+Entradasalida.Id('intervaloini')).val();
     if((!isNaN(valor))||(valor=='')){
    
        $('#'+Entradasalida.Id('intervaloini')).css('background-color', '#ffffff');
           
        
    
    } else {
      canterror++;
      $('#'+Entradasalida.Id('intervaloini')).css('background-color', '#f68c8c');
        
    }
     valor=$('#'+Entradasalida.Id('intervalofin')).val();
   
     if((!isNaN(valor))||valor==''){
    
        $('#'+Entradasalida.Id('intervalofin')).css('background-color', '#ffffff');
          
        
    
    } else {
      canterror++;
      $('#'+Entradasalida.Id('intervalorfin')).css('background-color', '#f68c8c');
        
    }
    if(canterror>0){
    Entradasalida.showMessageError('Revise los datos  !! ');return true;}else{
    Entradasalida.fechadesde=$('#'+Entradasalida.Id('fechadesde')).val();
    Entradasalida.fechahasta=$('#'+Entradasalida.Id('fechahasta')).val();
    Entradasalida.area=$('#'+Entradasalida.Id('area')).val();
    Entradasalida.seccion=$('#'+Entradasalida.Id('seccion')).val();    
    Entradasalida.evento=$('#'+Entradasalida.Id('evento')+':checked').val();
    Entradasalida.tipoevento=$('#'+Entradasalida.Id('tipoevento')).val();
  
     return false;
    }
     
    
}
Entradasalida.afterCambiarevento = function () {
    Entradasalida.reload();
    
    
}
Entradasalida.beforeImportarasistencia = function () {
  
    return false;
}
Entradasalida.afterImportarasistencia = function () {
    Entradasalida.reload();
}
Entradasalida.valirarFormularioReporte=function(){
    var error=false;
   var cant=0;
    if  ($('#'+Entradasalida.Id('empleado')).val()==''){
         $('#'+Entradasalida.Id('hi')).css('background-color','#f68c8c');
            cant+=1;
    }
    else{
        $('#'+Entradasalida.Id('empleado')).css('background-color','#ffffff');
             
    }
     if  ($('#'+Entradasalida.Id('fechadesde')).val()==''){
         $('#'+Entradasalida.Id('fechadesde')).css('background-color','#f68c8c');
            cant+=1;
    }
    else{
        $('#'+Entradasalida.Id('fechadesde')).css('background-color','#ffffff');
             
    }
     if  ($('#'+Entradasalida.Id('fechahasta')).val()==''){
         $('#'+Entradasalida.Id('fechahasta')).css('background-color','#f68c8c');
            cant+=1;
    }
    else{
        $('#'+Entradasalida.Id('fechahasta')).css('background-color','#ffffff');
             
    }
    if (cant>0){
        error=true;
        Entradasalida.showMessageError('Revise sus datos...!! ');
    }
    return error;
}

Entradasalida.reporte=function(opcion){
     var url = 'entradasalida/'+opcion+'?idempleado=' +$('#'+Entradasalida.Id('idempleado')).val()+'&desde='+$('#'+Entradasalida.Id('fechadesde')).val()+'&hasta='+$('#'+Entradasalida.Id('fechahasta')).val();
    this.openUrl(url);
}






Entradasalida.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Entradasalida.afterUpdate = function () {
 Entradasalida.closeWindow();
}

Entradasalida.validarFormulario=function () {
  var  error= false;
    var fecha=$('#'+Entradasalida.Id('fechaparametro')).val();
    var hi= parseInt($('#'+Entradasalida.Id('hi')).val());
    var mi=parseInt($('#'+Entradasalida.Id('mi')).val());
      if (hi>=0 && hi<=23 ) {
        $('#'+Entradasalida.Id('hi')).css('background-color','#fff');
            
        }else{
            
            $('#'+Entradasalida.Id('hi')).css('background-color','#f68c8c');
             
            error=true;
        }
         if (mi>=0 && mi<60 ) {
        $('#'+Entradasalida.Id('mi')).css('background-color','#fff');
            
        }else{
            
            $('#'+Entradasalida.Id('mi')).css('background-color','#f68c8c');
             
            error=true;
        }
     if (fecha.length>0 ) {
        $('#'+Entradasalida.Id('fechaparametro')).css('background-color','#fff');
            
        }else{
            
            $('#'+Entradasalida.Id('fechaparametro')).css('background-color','#f68c8c');
             
            error=true;
        }
        if ($('#'+Entradasalida.Id('idempleado')).val().length==0) {
            
            $('#'+Entradasalida.Id('empleado')).css('background-color','#f68c8c');
            error=true;
        }else{
            $('#'+Entradasalida.Id('empleado')).css('background-color','#fff');
        }
        if (error){
             Entradasalida.showMessageError('Revise sus datos...!! ');
        }
        else{
            Entradasalida.pfecha=$('#'+Entradasalida.Id('fechaparametro')).val();
            Entradasalida.pnombreempleado=$('#'+Entradasalida.Id('empleado')).val();
            Entradasalida.pidempleado= $('#'+Entradasalida.Id('idempleado')).val();
        }
        return error;
}



  Entradasalida.colorear=function () {
    
    var grid = this.getSGridView('gridLista');
    var color = '#d8e4bc';
    t1=new Date();
    t2=new Date();
    sumahora=0;
    sumaminuto=0;
    sumaextra=0;
    sumaatraso=0;
    sumasalida=0;
    horas=0;
    for(var f = 1; f <= grid.rows; f++) {
        if(grid.row(f).get('salida')!='' &&grid.row(f).get('entrada')!=''){
             if (((grid.row(f).get('entrada')<grid.row(f).get('horarelacionadaentrada'))  &&(grid.row(f).get('salida')<grid.row(f).get('horarelacionadaentrada')))||((grid.row(f).get('entrada')>grid.row(f).get('horarelacionadasalida'))&&(grid.row(f).get('salida')>grid.row(f).get('horarelacionadasalida')))){}else{
             if (grid.row(f).get('entrada')<grid.row(f).get('horarelacionadaentrada')){
                hi=grid.row(f).get('horarelacionadaentrada').split(':');
             }else{
                 hi=grid.row(f).get('entrada').split(':');
                 
             }
             
             if (grid.row(f).get('salida')>grid.row(f).get('horarelacionadasalida')){
                hf=grid.row(f).get('horarelacionadasalida').split(':');
             }else{
                 hf=grid.row(f).get('salida').split(':');
                 
             }
                    
           
           /*
            *  
            sumahora+=horas;
            sumaminuto+=t1.getMinutes();
           
            */
            
            t1.setHours(hi[0], hi[1]);
            t2.setHours(hf[0], hf[1]);     
            
            t1.setHours(t2.getHours() - t1.getHours(), t2.getMinutes() - t1.getMinutes());
             horas=t1.getHours();
       
        
            sumahora+=horas;
            sumaminuto+=t1.getMinutes();
             horas+=t1.getMinutes()/60;
            grid.row(f).set('horastrabajadas',horas);
        }
        
        


        }
        if(grid.row(f).get('idtipoentrada') == 8){
             
            sumaextra+=grid.row(f).get('difentrada');
        }
        if(grid.row(f).get('idtiposalida') == 8){
             
            sumaextra+=grid.row(f).get('difsalida');
        }
       
        if(grid.row(f).get('idtiposalida') == 4){
             
            sumaminuto+=grid.row(f).get('difsalida');
        }
        if(grid.row(f).get('idtipoentrada') == 3){
             
            sumaatraso+=grid.row(f).get('difentrada');
        }
        if(grid.row(f).get('idtiposalida') == 5){
             
            sumasalida+=grid.row(f).get('difsalida');
        }
        
        if(grid.row(f).get('idtipocategoriaentrada') == 1|| (grid.row(f).get('idtipocategoriaentrada') == 5  ))
        {     
            grid.row(f).attributes('difentrada', {'style': {'background': color}});
            
            grid.row(f).attributes('tipoentrada', {'style': {'background': color}});
          
        }
        if(grid.row(f).get('idtipocategoriasalida') == 1|| (grid.row(f).get('idtipocategoriasalida') == 5  ))
        { 
            
            grid.row(f).attributes('difsalida', {'style': {'background': color}});
            grid.row(f).attributes('tiposalida', {'style': {'background': color}});
            
            
        }
        if(grid.row(f).get('entradamanual') == 1)
        {     
            grid.row(f).attributes('difentrada', {'style': {'background': color}});
            
            grid.row(f).attributes('tipoentrada', {'style': {'background': color}});
            grid.row(f).attributes('entrada', {'style': {'background': color}});
          
        }
        if(grid.row(f).get('salidamanual') == 1)
        { 
            
            grid.row(f).attributes('difsalida', {'style': {'background': color}});
            grid.row(f).attributes('tiposalida', {'style': {'background': color}});
            grid.row(f).attributes('salida', {'style': {'background': color}});
            
            
        }
    }
  
  sumahora+= (sumaminuto/60);
  $('#'+Entradasalida.Id('horaasistida')).val(sumahora.toFixed(2));

  $('#'+Entradasalida.Id('minatraso')).val(sumaatraso);
  $('#'+Entradasalida.Id('horaextra')).val((sumaextra/60).toFixed(4));
  $('#'+Entradasalida.Id('minsalida')).val((sumasalida));

}
Entradasalida.edicionhora=function( ){
     var expreg = /^([0-2][0-9][:][0-5][0-9][:][0-5][0-9])*$/;  
    var grid = this.getSGridView('gridLista');
    var k = (document.all) ? event.keyCode : event.which;
    var identradasalida=grid.rowSelected().get('identradasalida');
    var entrada='E';
    var  hora;
    var grid = this.getSGridView('gridLista');
   if(grid.rowSelected().isFocus('entrada')){
     hora=grid.rowSelected().get('entrada');
   }else if(grid.rowSelected().isFocus('salida')){
    entrada='S';
    hora=grid.rowSelected().get('salida');
   }
   
   if(k == 13)
   {
       if(expreg.test(hora+''))
       {   
           
        $.ajax({
            'type':'post',
            'url':'rrhh/entradasalida/actualizarhorasellada',
            'data':{ identradasalida:identradasalida,
                hora:hora,
                entrada:entrada
         },
     
            success:function () {
                Entradasalida.colorear();
           },
            error:function () {
                alert('ocurrio un error al actulaizar...');
            }
     
        });    
       }
       
   }
}
Entradasalida.edicionminutos=function( ){
    var grid = this.getSGridView('gridLista');
    var k = (document.all) ? event.keyCode : event.which;
    var identradasalida=grid.rowSelected().get('identradasalida');
    var entrada='E';
    var  min;
    var grid = this.getSGridView('gridLista');
   if(grid.rowSelected().isFocus('difentrada')){
     min=grid.rowSelected().get('difentrada');
   }else if(grid.rowSelected().isFocus('difsalida')){
    entrada='S';
    min=grid.rowSelected().get('difsalida');
   }
   
   if(k == 13)
   {
       if($.isNumeric(min) == true)
       {   
        $.ajax({
            'type':'post',
            'url':'rrhh/entradasalida/actualizarminutossellada',
            'data':{ identradasalida:identradasalida,
                min:min,
                entrada:entrada
         },
     
            success:function () {
               Entradasalida.colorear(); 
           },
            error:function () {
                alert('ocurrio un error al actulaizar...');
            }
     
        });    
       }
       
   }
}

Entradasalida.Cargarvariables=function(){
    var grid = this.getSGridView('gridLista');   
    this.gridSearchVars('gridLista', '&idtipocategoriaentrada=' + grid.rowSelected().get('idtipocategoriaentrada')+'&idtipocategoriasalida=' + grid.rowSelected().get('idtipocategoriasalida') ); 
        $.ajax({
            'type':'post',
            'url':'rrhh/entradasalida/actualizartiposellada',
            'data':{ identradasalida:grid.rowSelected().get('identradasalida'),
                tiposalida:grid.rowSelected().get('idtiposalida'),
                tipoentrada: grid.rowSelected().get('idtipoentrada'),
                horaentrada: grid.rowSelected().get('entrada'),
                horasalida:grid.rowSelected().get('salida'),
         },
            success:function () {
                Entradasalida.colorear(); 
           },
            error:function () {
                alert('ocurrio un error al actulaizar...');
            }
     
        });  
        
        
     
}
Entradasalida.descargarAsistencia= function() {    
    var datos = this.prepareSend($('#' + this.groupForm).serialize());
    var url = 'Reporteasistencia?' + datos;
    
    this.openUrl(url);
}


Entradasalida.asignareventoscabecera=function(){
   
 $('#'+this.groupForm+"gridListaTitlenombrecompleto").on('click',function(){
               Entradasalida.Ordenarasistencia('nombrecompleto');
           });
 $('#'+this.groupForm+"gridListaTitledifentrada").on('click',function(){
               Entradasalida.Ordenarasistencia('difentrada');
           });
     $('#'+this.groupForm+"gridListaTitledifsalida").on('click',function(){
               Entradasalida.Ordenarasistencia('difsalida');
           });
    $('#'+this.groupForm+"gridListaTitleentrada").on('click',function(){
               Entradasalida.Ordenarasistencia('entrada');
           });
           $('#'+this.groupForm+"gridListaTitlesalida").on('click',function(){
               Entradasalida.Ordenarasistencia('salida');
           });
            $('#'+this.groupForm+"gridListaTitlefecha").on('click',function(){
               Entradasalida.Ordenarasistencia('fecha');
           });
           
}
Entradasalida.asignareventoscabeceraevento=function(){
   
 $('#'+this.groupForm+"gridListaTitlenombrecompleto").on('click',function(){
               Entradasalida.Ordenarasistenciaevento('nombrecompleto');
           });

    $('#'+this.groupForm+"gridListaTitleentrada").on('click',function(){
               Entradasalida.Ordenarasistenciaevento('entrada');
           });
         
            $('#'+this.groupForm+"gridListaTitlefecha").on('click',function(){
               Entradasalida.Ordenarasistenciaevento('fecha');
           });
           
}
Entradasalida.Ordenarasistencia=function(opcion){
   
    var orden='';
    var todos=false;
    if($('#'+Entradasalida.Id('mostrartodo')).prop('checked'))
    {
        todos=true;
    }
   switch(opcion){
       case 'nombrecompleto':{
                    if (Entradasalida.ordenarnombre=='asc'){         
                        Entradasalida.ordenarnombre='desc';
                        orden=Entradasalida.ordenarnombre+ ' desc,fecha::date '+Entradasalida.ordenarfecha+',entrada '+Entradasalida.ordenarentrada+' , difentrada '+Entradasalida.ordenardifentrada+', salida '+Entradasalida.ordenarsalida+', difsalida '+Entradasalida.ordenardifsalida;
                    }else{       
                        Entradasalida.ordenarnombre='asc';
                         
                    }
                     orden=Entradasalida.ordenarnombre+ ',fecha::date '+Entradasalida.ordenarfecha+',entrada '+Entradasalida.ordenarentrada+' , difentrada '+Entradasalida.ordenardifentrada+', salida '+Entradasalida.ordenarsalida+', difsalida '+Entradasalida.ordenardifsalida;
                 
                    break;
                }
                case 'entrada':{
                    if (Entradasalida.ordenarentrada=='asc'){         
                        Entradasalida.ordenarentrada='desc';
                    }else{       
                        Entradasalida.ordenarentrada='asc';
                        
                    }
                    orden=Entradasalida.ordenarentrada+ ',fecha::date '+Entradasalida.ordenarfecha+' , difentrada '+Entradasalida.ordenardifentrada+', salida '+Entradasalida.ordenarsalida+', difsalida '+Entradasalida.ordenardifsalida+',nombrecompleto '+Entradasalida.ordenarnombre;
                 
                    break;
                        
                }
                case 'salida':{
                        if (Entradasalida.ordenarsalida=='asc'){         
                        Entradasalida.ordenarsalida='desc';
                    }else{       
                        Entradasalida.ordenarsalida='asc';
                    }
                    orden=Entradasalida.ordenarsalida+ ' ,fecha::date '+Entradasalida.ordenarfecha+' , difsalida '+Entradasalida.ordenardifsalida+', entrada '+Entradasalida.ordenarentrada+', difentrada '+Entradasalida.ordenardifentrada+',nombrecompleto '+Entradasalida.ordenarnombre;
                 
                    break;
                        
                }
                case 'difentrada':{
                        if (Entradasalida.ordenardifentrada=='asc'){         
                        Entradasalida.ordenardifentrada='desc';
                    }else{       
                        Entradasalida.ordenardifentrada='asc';
                    }
                    orden=Entradasalida.ordenardifentrada+ ',fecha::date '+Entradasalida.ordenarfecha+' , entrada '+Entradasalida.ordenarentrada+', salida '+Entradasalida.ordenarsalida+', difsalida '+Entradasalida.ordenardifsalida+',nombrecompleto '+Entradasalida.ordenarnombre;
                 
                    break;
                    
                        
                }
                 case 'difsalida':{
                        if (Entradasalida.ordenardifsalida=='asc'){         
                        Entradasalida.ordenardifsalida='desc';
                    }else{       
                        Entradasalida.ordenardifsalida='asc';
                    }
                    orden=Entradasalida.ordenardifsalida+ ',fecha::date '+Entradasalida.ordenarfecha+' , salida '+Entradasalida.ordenarsalida+', entrada '+Entradasalida.ordenarentrada+', difentrada '+Entradasalida.ordenardifentrada+',nombrecompleto '+Entradasalida.ordenarnombre;
                 
                    break;
                        
                }
                default:{
                         opcion='fecha::date ';
                         if (Entradasalida.ordenarfecha=='asc'){         
                        Entradasalida.ordenarfecha='desc';
                         
                    }else{       
                        Entradasalida.ordenarfecha='asc';
                       
                    }
                   orden=Entradasalida.ordenarfecha+ ',entrada '+Entradasalida.ordenarentrada+' , difentrada '+Entradasalida.ordenardifentrada+', salida '+Entradasalida.ordenarsalida+', difsalida '+Entradasalida.ordenardifsalida+',nombrecompleto '+Entradasalida.ordenarnombre;
                 
                    break;
                        
                }
   } 
   
    var opcionmostrar=false;
    if($('#'+Entradasalida.Id('mostrartodo')).prop('checked'))
    {
        opcionmostrar=true;
    }
    $('#'+Entradasalida.groupForm +'_tipocontrato').bind("click", function(){
	console.log("se asigno el evento click");
});
     var listacontrato=$('#'+Entradasalida.groupForm +'_tipocontrato')[0]['selectedOptions']
     var lista='';
        for(i=0;i<listacontrato.length;i++){
         lista+=$('#'+Entradasalida.groupForm +'_tipocontrato')[0]['selectedOptions'][i].value+',';
     }
        $.ajax({
           'type':'post',
           'url':'rrhh/entradasalida/damelistaasistenciatipo',
           'data':{desde:$('#'+Entradasalida.Id('fechadesde')).val(),hasta:$('#'+Entradasalida.Id('fechahasta')).val(),
           area:$('#'+Entradasalida.Id('area')).val(),
           cargo:$('#'+Entradasalida.Id('cargo')).val(),
           empleado:$('#'+Entradasalida.Id('empleado')).val(),
           tipocontrato:lista,
           tipoobservacion:$('#'+Entradasalida.Id('tipoobservacion')).val(),
           mostrartodos:todos,
           nombre:Entradasalida.groupForm,
           opcion:opcion,
           orden:orden,
           mostrartodo:opcionmostrar
           
        },    
           success:function (resp) {           
             $('#'+Entradasalida.Id('contenedorCuerpo')).html(resp);
             Entradasalida.colorear();
             Entradasalida.asignareventoscabecera();  
        
    
          },
           error:function () {
               alert('ocurrio un error al obtener los datos del empleado...');
           }
    
       });
    
}
Entradasalida.Ordenarasistenciaevento=function(opcion){
   
    var orden='';
   switch(opcion){
       case 'nombrecompleto':{
                    if (Entradasalida.ordenarnombre=='asc'){         
                        Entradasalida.ordenarnombre='desc';
                       // orden=Entradasalida.ordenarnombre+ ' desc,es.fecha::date '+Entradasalida.ordenarfecha+',entrada '+Entradasalida.ordenarentrada;
                    }else{       
                        Entradasalida.ordenarnombre='asc';
                         
                    }
                     Entradasalida.orden='p.nombrecompleto '+ Entradasalida.ordenarnombre+ ',es.fecha::date '+Entradasalida.ordenarfecha+',entrada '+Entradasalida.ordenarentrada;
                 
                    break;
                }
                case 'entrada':{
                    if (Entradasalida.ordenarentrada=='asc'){         
                        Entradasalida.ordenarentrada='desc';
                    }else{       
                        Entradasalida.ordenarentrada='asc';
                        
                    }
                    Entradasalida.orden='es.entrada '+ Entradasalida.ordenarentrada+ ',es.fecha::date '+Entradasalida.ordenarfecha+',nombrecompleto '+Entradasalida.ordenarnombre;
                 
                    break;
                        
                }
                           
                default:{
                         opcion='fecha::date ';
                         if (Entradasalida.ordenarfecha=='asc'){         
                        Entradasalida.ordenarfecha='desc';
                         
                    }else{       
                        Entradasalida.ordenarfecha='asc';
                       
                    }
                   Entradasalida.orden='es.fecha '+ Entradasalida.ordenarfecha+ ',entrada '+Entradasalida.ordenarentrada+',nombrecompleto '+Entradasalida.ordenarnombre;
                 
                    break;
                        
                }
   } 
        Entradasalida.cargartabla();
    
}

  Entradasalida.descargarExcelReporteHorasAsistidas=function(){
    if ($('#'+Entradasalida.Id('fechadesde')).val()!='' && $('#'+Entradasalida.Id('fechahasta')).val()!=''){
        $('#'+Entradasalida.Id('fechadesde')).css('background-color','#fff');
        $('#'+Entradasalida.Id('fechahasta')).css('background-color','#fff');
        var datos = this.prepareSend($('#' + this.groupForm).serialize()) + this.gestionSchemaMain();
      
      this.downloadFile(this.urlIni+this.url+'/DescargarExcelReporteHorasAsistidas?' + datos);
      

      }else{
        $('#'+Entradasalida.Id('fechadesde')).css('background-color','#f68c8c');
        $('#'+Entradasalida.Id('fechahasta')).css('background-color','#f68c8c');
        Entradasalida.showMessageError('Revise sus datos...!! ');
       
       
      }
  }
  Entradasalida.cagarlistado=function(tipo){
       $.ajax({
           'type':'post',
           'url':'rrhh/entradasalida/damelistatipo',
           'data':{tipo:tipo     
           
        },  async:false,   
           success:function (resp) {  
            $('#'+Entradasalida.Id('cambiara')).empty();
            $('#'+Entradasalida.Id('tipoevento')).html(resp);
            Entradasalida.limpiargrilla();
            Entradasalida.cargartabla();
    
          },
           error:function () {
               alert('ocurrio un error al obtener los datos del tipo sellada...');
           }
    
       });
  }
  Entradasalida.cagarcambiara=function(evento){
      var tipo=$('#'+Entradasalida.Id('evento')+':checked').val();
       $.ajax({
           'type':'post',
           'url':'rrhh/entradasalida/damelistacambiara',
           'data':{evento:evento,tipo:tipo
       
           
        }, 
        async:false,  
           success:function (resp) {           
           
           $('#'+Entradasalida.Id('cambiara')).html(resp);
           Entradasalida.limpiargrilla();
           Entradasalida.cargartabla();

    
          },
           error:function () {
               alert('ocurrio un error al obtener los datos del tipo sellada...');
           }
    
  });
  }
  Entradasalida.cargartabla=function(){
     var tipo=$('#'+Entradasalida.Id('evento')+':checked').val();
     var evento=$('#'+Entradasalida.Id('tipoevento')).val();
     
     if (tipo!== undefined && evento!=''){
    
        $.ajax({
           'type':'post',
           'url':'rrhh/entradasalida/dametabla',
           'data':{evento:evento,tipo:tipo,desde:$('#'+Entradasalida.Id('fechadesde')).val(),hasta:$('#'+Entradasalida.Id('fechahasta')).val(),
               area:$('#'+Entradasalida.Id('area')).val(),
               empleado:$('#'+Entradasalida.Id('idempleado')).val(),
               intervaloini:$('#'+Entradasalida.Id('intervaloini')).val(),
               intervalofin:$('#'+Entradasalida.Id('intervalofin')).val(),
               nombre:Entradasalida.groupForm,   
               orden:Entradasalida.orden
           
        },    
           success:function (resp) {           
           
        
        $('#'+Entradasalida.Id('contenedorCuerpo')).empty();
        $('#'+Entradasalida.Id('contenedorCuerpo')).html(resp);
        Entradasalida.asignareventoscabeceraevento();
        
          },
           error:function () {
               alert('ocurrio un error al obtener los datos del tipo sellada...');
           }
    
  });}
  }
  Entradasalida.Fechaminima=function(valor)
  {
    $('#' + Entradasalida.Id('fechahasta')).datepicker("option", "minDate", valor);
    Entradasalida.cargartabla();       
      
  }
  Entradasalida.limpiargrilla=function()
  {
    var grid = Entradasalida.getSGridView('gridLista');
  
    grid.resetRows(); 
   
  
  }

Entradasalida.dameAutocomplete = function() {
    jQuery('#' + Entradasalida.Id('seccion')).
    autocomplete({ 'source': '/coreT/rrhh/seccion/autocompleteSeccion?area=' + $('#' + this.Id('area')).val() });
}
Entradasalida.bajaselladasinsalida=function(id){
 $.ajax({
           'type':'post',
           'url':'rrhh/entradasalida/bajaselladasinsalida',
           'data':{id:id   
           
        },    
           success:function () { 
          
           } ,        
         
           error:function () {
               alert('ocurrio un error al dar de baja sellada...');
           }
    
  }); 
   admEntradasalida.search();
}
Entradasalida.validarValorini=function () {
   
    var valor=$('#'+Entradasalida.Id('intervaloini')).val();
    
if(( !isNaN(valor))||valor==''){
    
      $('#'+Entradasalida.Id('intervaloini')).css('background-color', '#ffffff');
         Entradasalida.cargartabla();
        
    
    } else {
           
       $('#'+Entradasalida.Id('intervaloini')).css('background-color', '#f68c8c');
        Entradasalida.showMessageError('Debe ser un numero !! ');
    }


}
Entradasalida.validarValorfin=function () {
   
    var valor=$('#'+Entradasalida.Id('intervalofin')).val();
   
if((!isNaN(valor))||valor==''){
    
        $('#'+Entradasalida.Id('intervalofin')).css('background-color', '#ffffff');
         
        Entradasalida.cargartabla();
    
    } else {
       
       $('#'+Entradasalida.Id('intervalofin')).css('background-color', '#f68c8c');
        Entradasalida.showMessageError('Debe ser un numero !! ');
    }


}
Entradasalida.edicionobservacion=function( ){
    
    var grid = this.getSGridView('gridLista');
    var k = (document.all) ? event.keyCode : event.which;
    var identradasalida=grid.rowSelected().get('identradasalida');
    var entrada='E';
    var  observacion;
    var grid = this.getSGridView('gridLista');
   if(grid.rowSelected().isFocus('observacionentrada')){
     observacion=grid.rowSelected().get('observacionentrada');
   }else if(grid.rowSelected().isFocus('observacionsalida')){
    entrada='S';
   observacion=grid.rowSelected().get('observacionsalida');
    
   }
   
   if(k == 13)
   {
       console.log(grid);
      console.log("observacion  ....."+observacion);
           
        $.ajax({
            'type':'post',
            'url':'rrhh/entradasalida/actualizarobservacion',
            'data':{ identradasalida:identradasalida,
                observacion:observacion,
                entrada:entrada
         },
     
            success:function () {
                Entradasalida.colorear();
           },
            error:function () {
                alert('ocurrio un error al actulaizar...');
            }
     
        });    
      
       
   }
}
Entradasalida.cargarTexto=function(){
    var texto=$('#'+Entradasalida.Id('observacionentrada')).val();
     var grid = this.getSGridView('gridLista');
     for(var i=1;i<=grid.rows;i++){
           if( grid.row(i).get('observacionentrada')==''  ){         
            grid.row(i).set('observacionentrada',texto);
        }
         
     }
    
    
}

Entradasalida.cargarfiltroarea=function(){
    jQuery('#' + Entradasalida.Id('seccion')).autocomplete({ 'source': '/coreT/rrhh/seccion/autocompleteSeccion?area=' + $('#' + Entradasalida.Id('area')).val() });
   this.cargartabla(); 
    jQuery('#' + Entradasalida.Id('empleado')).
    autocomplete({ 'source': '/coreT/rrhh/entradasalida/autocompletePersona?area=' + $('#' +  Entradasalida.Id('area')).val() });

}
Entradasalida.cambiarHora=function(){
  var valor= $('#'+Entradasalida.Id('horainfo')).val();
     var grid = this.getSGridView('gridLista');
     if((!isNaN(valor))&& valor!=''){
         valor=parseInt(valor);
         if(valor<0){
             valor=0;
         }
         if(valor>8){
             valor=8;
         }
         $('#'+Entradasalida.Id('horainfo')).val(valor);
     for(var i=1;i<=grid.rows;i++){
                   
            grid.row(i).set('difhentrada',valor);
        
         
     } } 
}
Entradasalida.cambiarMinuto=function(){
  var valor=$('#'+Entradasalida.Id('minutoinfo')).val();
     var grid = this.getSGridView('gridLista');
        if((!isNaN(valor))&& valor!=''){
         valor=parseInt(valor);
         if(valor<0){
             valor=0;
         }
         if(valor>59){
             valor=59;
         }
         $('#'+Entradasalida.Id('minutoinfo')).val(valor);
     for(var i=1;i<=grid.rows;i++){
                   
            grid.row(i).set('difmentrada',valor);
        
         
     } } 
}
Entradasalida.validarHoraMinuto=function()
{   
    var grid = this.getSGridView('gridLista');
    var k = (document.all) ? event.keyCode : event.which;  
   if(k == 13)
   {
      if(grid.rowSelected().isFocus('difhentrada')){
       hora=parseInt(grid.rowSelected().get('difhentrada'));
       if(hora>8){
           hora=8;
       }
       if(hora<0){
           hora=0;
       }
       grid.rowSelected().set('difhentrada',hora);
        }else if(grid.rowSelected().isFocus('difmentrada')){
        min=parseInt(grid.rowSelected().get('difmentrada'));
       if(min>59){
           min=59;
       }
       if(min<0){
           min=0;
       }
       grid.rowSelected().set('difmentrada',min);
        }
       
   }
}

Entradasalida.validarNumeroCi=function(valor)
{
     if((!isNaN(valor)) && Number.isInteger( parseInt(valor))){    
        $('#'+Entradasalida.Id('ci')).css('background-color', '#ffffff');       
    
    } else {     
      $('#'+Entradasalida.Id('ci')).css('background-color', '#f68c8c');
      Entradasalida.showMessageError('Revise su Dato !! ');
        
    }
}
Entradasalida.dameHora=function(){
         $.ajax({
            'type':'post',
            'url':'rrhh/entradasalida/horaServidor',
            
     
            success:function (hora) {
                $('#'+Entradasalida.Id('Hora')).html(hora);
           },
            error:function () {
                
            }
     
        });    
        
       
}
Entradasalida.CargarListaEmpleados=function(){
    console.log("entrando a la funcion CargarListaEmpleados");
    var opcion=0;
    var desde=$('#'+Entradasalida.Id('fechadesde')).val();
    var hasta=$('#'+Entradasalida.Id('fechahasta')).val();
    var empleado=$('#'+Entradasalida.Id('empleado')).val();
     var listacontrato=$('#'+Entradasalida.groupForm +'_tipocontrato')[0]['selectedOptions']
     var lista='';
        for(i=0;i<listacontrato.length;i++){
         lista+=$('#'+Entradasalida.groupForm +'_tipocontrato')[0]['selectedOptions'][i].value+',';
     }
    if($('#'+Entradasalida.Id('mostrartodo')).prop('checked'))
    {
        opcion=1;
    }
    $.ajax({
            'type':'post',
            'url':'rrhh/entradasalida/dameListaOpcionSeguimiento',
            data:{opcion:opcion,desde:desde,hasta:hasta,tipocontrato:lista},
            
     
            success:function (respuesta) {
                $('#'+Entradasalida.Id('empleado')).html(respuesta);
                $('#'+Entradasalida.Id('empleado')+'>option[value="'+empleado+'"]').prop("selected", true);
    
                },
            error:function () {
                alert("Ocurrio un error al momento de Obtener el listado...");
            }
     
        }); 
}
Entradasalida.dameHorarioEmpleadoF=function (fecha) {
    var idempleado=$('#'+Entradasalida.Id('idempleado')).val();
     if (idempleado.length>0 ) {
    this.dameHorarioEmpleado(idempleado,fecha);
 }
}
Entradasalida.dameHorarioEmpleado=function (idempleado,fecha) {
     $.ajax({
        'type':'post',
        'url':'rrhh/entradasalida/dameHorarioEmpleado',
        'data':{ide:idempleado,fecha:fecha},
        success:function (resp) {
        
     $('#'+Entradasalida.Id('contenedorHorario')).html(resp);

       },
        error:function () {
            alert('ocurrio un error al obtener los datos del empleado...');
        }

    });
}
