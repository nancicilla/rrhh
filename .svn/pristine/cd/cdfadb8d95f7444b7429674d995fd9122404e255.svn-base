var Horario = new Object();
Horario.__proto__ = SystemWindow;
//variables
Horario.nameView = "Horario";
Horario.url = "horario";

Horario.listagrilla=[];
Horario.init = function () {
     var THIS=this;
if (this.action == 'create'|| this.action === 'update'||this.action==='Horarioespecial'||this.action=='Asignarempleado'||this.action === 'Informacionhorario') {
   
    this.buttonChange({id: 'save', label: 'Guardar', key: 'G'});
           
       
     
}}
Horario.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Horario',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Horario',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    
    this.setActions('Asignarempleado', {          
       WindowWidth: 800,
        WindowHeight: 475,   
        WindowTitle: 'Asignar  Empleados a Horario',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('Horarioespecial', {          
       WindowWidth: 800,
        WindowHeight: 555,   
        WindowTitle: 'Horario Eventual',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('Informacionhorario', {   
       
        WindowWidth: 800,
         WindowHeight: 455,   
         WindowTitle: ' Informacion Horario',
         initButtons: 'save,cancel',
         layerEndOn: false,
         ableBackWindow: true
     });
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Horario',
        WindowWidth: 800,
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

Horario.Horarioespecial = function() {
     Horario.listagrilla=[];
    this.action = 'Horarioespecial';
    this.open(this.getOptions());
}

Horario.Asignarempleado= function(options) {
    this.action = 'Asignarempleado';
    this.open(this.getOptions(options));
}
Horario.Informacionhorario = function(options) {
    this.action = 'Informacionhorario';
    this.open(this.getOptions(options));
}

Horario.beforeHorarioespecial = function () {
    var error=this.ValidarHorarioEspecial();   
   return error;
}

Horario.beforeAsignarempleado = function () {
    var error=this.validarFormularioAsignacionHorario();  
   return error;
}
Horario.afterHorarioespecial = function () {
   Horario.closeWindow();
}
Horario.afterInformacionhorario = function () {
    Horario.closeWindow();
}
Horario.beforeInformacionhorario = function () {
    var error=false;   
   return error;
}
Horario.afterAsignarempleado= function () {
    Horario.closeWindow();
}
Horario.beforeCreate = function () {
    var error = this.validarGrillaHT();//false es no existe error antes de crear formulario
    var grilla=this.getSGridView('gridEmpleados');
    var err=false;
     if ($('#'+Horario.Id('nombre')).val()=='') {
       err=true;
       $('#'+Horario.Id('nombre')).css('background-color','#f68c8c');             
     } 
    else{
      $('#'+Horario.Id('nombre')).css('background-color','#fff');
    }
  
    if (error||err) {
        error=true;
          Horario.showMessageError('Revise los datos !! '); 
         
    }
   
   return error;
}
Horario.afterCreate = function () {
  
    Horario.reload();
}

Horario.beforeUpdate = function () {
    var error = this.validarGrillaHT();//false es no existe error antes de crear formulario
    var error1=this.validarFormulario();
    var err=false;
    var cad='Revise los datos !! ';
    switch (error1){
        case 0:{break;}
        case 1:{
            err=true;
            break;
        }
        default:
        {
         err=true;
         cad='El horario no debe tener empleados para dar de baja ...';
         break;
        }
    }
    if (error||err) {
          Horario.showMessageError(cad); 
    }
    if (err==false){
       
         if ($('#' + Horario.Id('contenedorMensaje')).html() != '') {
             Horario.showMessageError('Hay empleado(s) con permiso(s) asignado(s)  !! ');
             error=true;
        } 
    }
    return error||err;
}
Horario.afterUpdate = function () {
    Horario.closeWindow();
}

Horario.cantidadHora = function () {
    var grilla = Horario.getSGridView('gridHorasTrabajo');
   th=0;
   tm=0;
 for (var f = 1; f <= grilla.rows; f++) {
      if (grilla.row(f).get('rangohora')!=''  ){
     
        if ( grilla.row(f).get('iddia')!='' && grilla.row(f).get('iddiad')!='') {
        aux=parseInt(grilla.row(f).get('iddiad'))-parseInt(grilla.row(f).get('iddia'))+1;
         cadena=grilla.row(f).get('rangohora');
        vech=cadena.split('-');
        vech[1]=vech[1].substring(0, 5);
        vhi=  vech[0].split(':');
        vhf=vech[1].split(':');
        hi=parseInt(vhi[0]);
        mi=parseInt(vhi[1]);
        hf=parseInt(vhf[0]);
        mf=parseInt(vhf[1]);
        console.log('hi='+hi+':'+mi+'  hf='+hf+':'+mf);
        if (mf<mi){
            hf-=1;
            mf+=60;
        }
        th+=(hf-hi)*aux;//Math.abs(-7.25)
        tm+=(mf-mi)*aux;
        grilla.row(f).attributes('diad', {tooltip: '', validate: true});
        grilla.row(f).attributes('dia', {tooltip: '', validate: true});
    }
    else{
        grilla.row(f).attributes('diad', {tooltip: '', validate: false});
        grilla.row(f).attributes('dia', {tooltip: '', validate: false});
        }
    }    
      if (tm>=60) {
        th+=parseInt( tm/60);
        tm=tm%60;
        }else{
            

        }
        $('#'+Horario.Id('chd') ).html('<strong>'+th+'</strong> horas con <strong>'+tm+' </strong>minutos por semana');
            
 }

}

Horario.validarFormulario=function(){

canterror=0;
error=false;
 
 if ($('#'+Horario.Id('nombre')).val()=='') {
    canterror=1;
     $('#'+Horario.Id('nombre')).css('background-color','#f68c8c');
             
 } 
 else{
 $('#'+Horario.Id('nombre')).css('background-color','#fff');
 }
  if ($('#'+Horario.Id('fechainicio')).val()=='') {
    canterror=1;
     $('#'+Horario.Id('fechainicio')).css('background-color','#f68c8c');
             
 } 
 else{
 $('#'+Horario.Id('fechainicio')).css('background-color','#fff');
 }

 if ( $('#'+Horario.Id('estado')).prop('checked')==false) {
    if (this.validarGrillaEmpleado()>0) {
      canterror+=2;  
      
    }

 }
   
 
 return canterror;
}
Horario.validarGrillaHT=function() {
    var grilla=this.getSGridView('gridHorasTrabajo');
    var error=false;
    var cant=0;
 for (var f = 1; f <= grilla.rows; f++) {   
        try{
            if (grilla.row(f).get('dia')=='') {
            ++cant;
            grilla.row(f).attributes('dia', {tooltip: '', validate: false});

            }else{
             grilla.row(f).attributes('dia', {tooltip: '', validate: true});

            }
            if (grilla.row(f).get('diad')=='') {
            ++cant;
            grilla.row(f).attributes('diad', {tooltip: '', validate: false});

            }else{
             grilla.row(f).attributes('diad', {tooltip: '', validate: true});

            }
            if (grilla.row(f).get('rangohora')=='') {
            ++cant;
            grilla.row(f).attributes('rangohora', {tooltip: '', validate: false});

            }else{
             grilla.row(f).attributes('rangohora', {tooltip: '', validate: true});

            }
            
            if (this.validarFecha(grilla.row(f).get('fechaiseq')) && grilla.row(f).get('estado')==1) {
           
            grilla.row(f).attributes('fechaiseq', {tooltip: '', validate: true});

            }else if(!this.validarFecha(grilla.row(f).get('fechaiseq')) && grilla.row(f).get('estado')==1){
             
    ++cant;
            grilla.row(f).attributes('fechaiseq', {tooltip: '', validate: false});
            }

            
           //console.log('--->'++'<-------------');

            }catch(ex){


        }    
     }
     if (cant>0) {
      
        error=true;
     }
 return error;
}
Horario.validarFecha=function(fecha) {
   
var fecha = fecha.split('-');
 var anio = fecha[2];
 var mes = fecha[1];
 var dia = fecha[0];
 
 var fechaaux = new Date(anio, mes - 1, dia);//mes empieza de cero Enero = 0

 if(!fechaaux || fechaaux.getFullYear() == anio && fechaaux.getMonth() == mes -1 && fechaaux.getDate() == dia){
   
 return true;
 }else{
   
 return false;
 }
}
Horario.validarGrillaEmpleado=function() {
    var grilla=this.getSGridView('gridEmpleados');
   
    var cant=0;
 for (var f = 1; f <= grilla.rows; f++) {   
        try{
            if (grilla.row(f).get('id')!='') {
            ++cant;
            grilla.row(f).attributes('', {tooltip: '', validate: false});

            }else{
                 grilla.row(f).attributes('', {tooltip: '', validate: true});

            }
            

            }catch(ex){


        }    
     }
   
 return cant;
}
Horario.verificarEmpleado=function(){
     var grilla=this.getSGridView('gridEmpleados');
   var fecha= $('#'+Horario.Id('fechainicio')).val();
    var cant=0;
    var respuesta;
    if (fecha!='') {
 for (var f = 1; f <= grilla.rows; f++) {   
        
            if (grilla.row(f).get('id')!='') {
                console.log('.......>'+grilla.row(f).get('id')+'<......');
         
 $.ajax({
    type:'post',
   
    url:'rrhh/horario/verificarEmpleado',
    data:{idempleado:grilla.row(f).get('id'),fecha:fecha},
    success:function (resp) {
        respuesta=resp;

       

    }
   });  

  if (respuesta!=0) {
          grilla.row(f).attributes('nombrecompleto', {tooltip: '', validate: false});

      
     }else{
          grilla.row(f).attributes('nombrecompleto', {tooltip: '', validate: true});

     }
            }
            

           
     }}else{
        alert('Debe seleccionar la fecha de Inicio ');
     }
   
 return cant;
}
Horario.Limpiar=function(){
     var grilla=this.getSGridView('gridEmpleados');   
     grilla.resetRows();    
    SGridView.inClick=true;
    SGridView.addRow(Horario.groupForm+'gridEmpleados');
    $('#'+Horario.Id('limpiar')).prop('checked',false);
  
}
Horario.colorear=function(){
      var grid=this.getSGridView('gridEmpleados');  
      console.log(Horario.groupForm);
    var color = '#d8e4bc';
        for(var f = 1; f <= grid.rows; f++)
        {
             if(grid.row(f).get('colorear') == 1 )
            {
                
                grid.row(f).attributes('nombrecompleto', {'style': {'background': color}});
                grid.row(f).attributes('fechainicio', {'style': {'background': color}});
            }
                      
            
        }
}
Horario.Quitarboton=function(){
    var grid=this.getSGridView('gridEmpleados'); 
    var estado=grid.rowSelected().get('estado');
    var editar=grid.rowSelected().get('editar');
    var fechainicio=grid.rowSelected().get('fechainicio');
    if(estado==0 && editar!=-1){
        grid.rowSelected().set('limpiar',false); 
    }
    if($('#'+Horario.Id('fechainicio')).val()!='' && editar==-1  && fechainicio==''){
        grid.rowSelected().set('fechainicio',$('#'+Horario.Id('fechainicio')).val());
        
    }
    this.colorear();
                           
                          
}

Horario.dameInformacionHorario=function(idhorario){
    $('#'+Horario.Id('conthorario')).empty();
      $.ajax({
       'type':'post',
       'url':'rrhh/movimientopersonal/dameHorario',
       'data':{idhorario:idhorario,nombre: Horario.groupForm},
       success:function (resp) {
          
        $('#'+Horario.Id('conthorario')).html(resp.horarios);
       

      },
       error:function () {
           alter('ocurrio un error al optener informacion de horario...');
       }
   }); 

}
Horario.seleccionar=function(elemento){
   elemento=$(elemento);
    
   var nombregrilla=elemento.attr('id');
   nombregrilla=nombregrilla.substring(3,nombregrilla.length);
   var grid=this.getSGridView(nombregrilla); 
   estado=elemento.prop('checked');
        for(var f = 1; f <= grid.rows; f++)
        {            
               grid.row(f).set('seleccionar',estado);  
            
        }
        Horario.mostrarObservacionHorarioEventual();
}
Horario.Actualizarcheckboxgeneral=function(nombre){
     var grid=this.getSGridView(nombre); 
     console.log("nombre del check --->"+nombre);
     console.log(Horario.listagrilla);
     cantelementos=grid.rows;
     canttikeados=0;
     cantnotikeados=0;
     elemento=$('#cbx'+nombre);     
        for(var f = 1; f <=cantelementos; f++)
        {            
               if( grid.row(f).get('seleccionar')==true)
               ++canttikeados;
               
            
        }
        if(cantelementos==canttikeados)
            elemento.prop('checked',true);
        else
            elemento.prop('checked',false);
    Horario.mostrarObservacionHorarioEventual();
}
Horario.ValidarHorarioEspecial=function(){
    
    var error=false;
    var cant=0;
    var cantempleados=0;
    if ($('#'+Horario.Id('fechadesde')).val()=='') {
             $('#'+Horario.Id('fechadesde')).css('background-color','#f68c8c');

          ++cant;
        }else{
            $('#'+Horario.Id('fechadesde')).css('background-color','#fff');
        }
        if ($('#'+Horario.Id('fechahasta')).val()=='') {
             $('#'+Horario.Id('fechahasta')).css('background-color','#f68c8c');

          ++cant;
        }else{
            $('#'+Horario.Id('fechahasta')).css('background-color','#fff');
        }
        if ($('#'+Horario.Id('horarios')).val()=='') {
             $('#'+Horario.Id('horarios')).css('background-color','#f68c8c');

          ++cant;
        }else{
            $('#'+Horario.Id('horarios')).css('background-color','#fff');
        }
        for(var i=0;i<Horario.listagrilla.length;i++){
            
            grid=this.getSGridView(""+Horario.listagrilla[i]);
            for(var f = 1; f <= grid.rows; f++)
                {
                     if( grid.row(f).get('seleccionar')==true){

                      cantempleados=1;
                      break;
                      
                       }
            }
    }
        
        if (cant>0) {
            error=true;
             Horario.showMessageError('Revise los datos !!'); 
        }else if(cantempleados==0){
             error=true;
             Horario.showMessageError('Debe Selleccionar al menos un Empleado !!');   
        }else{
             if ($('#' + Horario.Id('contenedorMensaje')).html().length>0) {
             Horario.showMessageError('El empleado Tiene permiso asignado  !! ');
             error=true;
        } 
            
        }
    return error;
}
Horario.validarFechahastaEspecial=function(fechadesde){
     $('#' + Horario.Id("fechahasta")).datepicker("option", "minDate", fechadesde);
     Horario.mostrarObservacionHorarioEventual();            
}
Horario.validarFormularioAsignacionHorario=function(){
    var error=false;
     var grid=this.getSGridView('gridEmpleadoasignar');
     var cant=0;
      
        for(var f = 1; f <= grid.rows; f++)
        {
             if(grid.row(f).get('nombrecompleto') !='' )
            {
                
               ++cant;
            }       
           
            
        }
        if($('#'+Horario.Id('fechainicio')).val()=='' && cant>0 ){
            error=true;
             $('#'+Horario.Id('fechainicio')).css('background-color','#f68c8c');

            Horario.showMessageError("Revise sus datos!!");
            
        }else
        {
             $('#'+Horario.Id('fechainicio')).css('background-color','#ffffff');

        }
 return error;   
}
Horario.Observacionempleado=function(){
    var grid = this.getSGridView('gridEmpleados'); 
    var fecha=$('#'+Horario.Id('fechainicio')).val();
      Horario.colorcelda='#ffffff';
    if(fecha!='' &&  grid.rowSelected().get('id')!='' && grid.rowSelected().get('estado')=='-1' ){
        
         $.ajax({
            'type':'post',
            'url':'rrhh/horario/horarioenfecha',
            'data':{ fecha:fecha,
                idempleado:grid.rowSelected().get('id'),
                
         },
         async:false,
            success:function (resp) {
                if(resp!=''){
                   grid.rowSelected().set('estado','2');
                }
                
           },
            error:function () {
                alert('ocurrio un error al  obtener informacion del empleado...');
            }
     
        }); 
        
          
    
    }
    Horario.Actualizarinfo();
}
Horario.Actualizarinfo=function(){
    //esta es la que estoy ejecutando ahorita
    var fecha=$('#'+Horario.Id('fechainicio')).val();
   $('#'+Horario.Id('contenedorFecha')).html(fecha);
    
   var grid = this.getSGridView('gridEmpleados'); 
    
   for(var f = 1; f <= grid.rows; f++)
        {
         nombre=grid.row(f).get('nombrecompleto');
         idempleado= grid.row(f).get('id');
        if(fecha!='' && grid.row(f).get('estado')=='2'  ){         
            grid.row(f).attributes('nombrecompleto', {'style': {'color': 'red', 'font-weight': 'bold'}});
        }
   
}
Horario.mostrarObservacion();
}

Horario.Actualizarinfocambiofecha=function(){
    var fecha=$('#'+Horario.Id('fechainicio')).val();
   $('#'+Horario.Id('contenedorFecha')).html(fecha);
   var grid = this.getSGridView('gridEmpleados'); 
    for(var f = 1; f <= grid.rows; f++)
        {
         nombre=grid.row(f).get('nombrecompleto');
         idempleado= grid.row(f).get('id');
        if(fecha!='' && grid.row(f).get('id')!=''  ){         
           
            $.ajax({
            'type':'post',
            'url':'rrhh/horario/horarioenfecha',
            'data':{ fecha:fecha,
                idempleado:grid.row(f).get('id'),
                
         },
         async:false,
            success:function (resp) {
                if(resp!=''){
                   grid.row(f).set('estado','2');
                    grid.row(f).attributes('nombrecompleto', {'style': {'color': 'red', 'font-weight': 'bold'}});
                }else{
                     grid.row(f).set('estado','-1');
                      grid.row(f).attributes('nombrecompleto', {'style': {'color': 'black', 'font-weight': ''}});
              
                }
                
           },
            error:function () {
                alert('ocurrio un error al  obtener informacion del empleado...');
            }
     
        }); 
           
        }
   
}
Horario.mostrarObservacion();
}

Horario.mostrarObservacion=function(){
    var grid=this.getSGridView('gridEmpleados');
    var vector=[];
    var fecha=$('#'+Horario.Id('fechainicio')).val();
    if(fecha!=''){
    for(var f = 1; f <= grid.rows; f++)
        {
         nombre=grid.row(f).get('nombrecompleto');
         idempleado= grid.row(f).get('id');
       vector.push({'id':idempleado,'nombrecompleto':nombre});
        }
     $.ajax({     
        'type':'post',
        'url':'rrhh/horario/observacionHorarioEmpleados',
        'data':{  grilla:vector,fecha:fecha},
        success:function (resp) {               
                 $('#' + Horario.Id("contenedorMensaje")).html(resp);          

       },
        error:function () {
            alert('ocurrio un error ');
        }

    });  
}}

Horario.mostrarObservacionHorarioEventual=function(){
    var grid;
    var vector=[];
    var fechadesde=$('#'+Horario.Id('fechadesde')).val();
    var fechahasta=$('#'+Horario.Id('fechahasta')).val();
    $('#' + Horario.Id("contenedorMensaje")).html(''); 
    if(fechadesde!=''&& fechahasta!=''){
        console.log("cantgrilla="+Horario.listagrilla.length);
        for(var i=0;i<Horario.listagrilla.length;i++){
            console.log(Horario.listagrilla[i]);
            grid=this.getSGridView(""+Horario.listagrilla[i]);
            for(var f = 1; f <= grid.rows; f++)
                {
                     if( grid.row(f).get('seleccionar')==true){

                        nombre=grid.row(f).get('nombrecompleto');
                        idempleado= grid.row(f).get('id');
                        vector.push({'id':idempleado,'nombrecompleto':nombre});
                       }
            }
    }
    if(vector.length>0) {   
     $.ajax({     
        'type':'post',
        'url':'rrhh/horario/observacionHorarioEntreFechas',
        'data':{  grilla:vector,fechadesde:fechadesde,fechahasta:fechahasta},
        success:function (resp) {               
                 $('#' + Horario.Id("contenedorMensaje")).html(resp);          

       },
        error:function () {
            alert('ocurrio un error ');
        }

    });  }
    }
}

Horario.mostrarObservacionHorario=function(){
   
    var fecha=$('#'+Horario.Id('fechainicio')).val();
    if(fecha!=''){
   
     $.ajax({     
        'type':'post',
        'url':'rrhh/horario/observacionUpdateHorario',
        'data':{  id:$('#'+Horario.Id('id')).val(),fecha:fecha},
        success:function (resp) {               
                 $('#' + Horario.Id("contenedorMensaje")).html(resp);          

       },
        error:function () {
            alert('ocurrio un error ');
        }

    });  
}}