var Horariolactancia = new Object();
Horariolactancia.__proto__ = SystemWindow;
//variables
Horariolactancia.nameView = "Horariolactancia";
Horariolactancia.url = "horariolactancia";
Horariolactancia.init = function () {
     var THIS=this;
if (this.action == 'create'|| this.action === 'update'||this.action==='Horarioespecial'||this.action === 'HorarioLactancia') {
   
    this.buttonChange({id: 'save', label: 'Guardar', key: 'G'});
           
       
     
}}

Horariolactancia.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Horariolactancia',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Horario Lactancia',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('HorarioLactancia', {        
        WindowTitle: 'Horario Lactancia',
        initButtons: 'cerrar',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('Horarioespecial', {          
       WindowWidth: 800,
        WindowHeight: 555,   
        WindowTitle: 'Horario Eventual Lactancia',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Horariolactancia',
        WindowWidth: 650,
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

Horariolactancia.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Horariolactancia.afterCreate = function () {
    Horariolactancia.reload();
}

Horariolactancia.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Horariolactancia.afterUpdate = function () {
    Horariolactancia.closeWindow();
}
Horariolactancia.beforeHorarioLactancia = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Horariolactancia.afterHorarioLactancia= function () {
    Horariolactancia.closeWindow();
}
Horariolactancia.HorarioLactancia = function (options) {
    this.action = 'HorarioLactancia';
    this.open(this.getOptions(options));

};
Horariolactancia.Horarioespecial = function (options) {
    this.action = 'Horarioespecial';
    this.open(this.getOptions(options));

};
Horariolactancia.beforeHorarioespecial = function () {
    var error=this.ValidarHorarioEspecial();   
   return error;
}
Horariolactancia.afterHorarioespecial = function () {
   Horariolactancia.closeWindow();
}

Horariolactancia.ValidarHorarioEspecial=function(){
    
    var error=false;
    var cant=0;
    var cantempleados=0;
    if ($('#'+Horariolactancia.Id('fechadesde')).val()=='') {
             $('#'+Horariolactancia.Id('fechadesde')).css('background-color','#f68c8c');

          ++cant;
        }else{
            $('#'+Horariolactancia.Id('fechadesde')).css('background-color','#fff');
        }
        if ($('#'+Horariolactancia.Id('fechahasta')).val()=='') {
             $('#'+Horariolactancia.Id('fechahasta')).css('background-color','#f68c8c');

          ++cant;
        }else{
            $('#'+Horariolactancia.Id('fechahasta')).css('background-color','#fff');
        }
        
        
            
            grid=this.getSGridView("gridEmpleados");
            for(var f = 1; f <= grid.rows; f++)
                {
                     if( grid.row(f).get('seleccionar')==true){

                      cantempleados=1;
                      break;
                      
                       }
            }
            
        if (cant>0) {
            error=true;
             Horariolacatancia.showMessageError('Revise los datos !!'); 
        }else if(cantempleados==0){
             error=true;
             Horariolactancia.showMessageError('Debe Selleccionar al menos una Empleada !!');   
        }else{
             if ($('#' + Horariolactancia.Id('contenedorMensaje')).html().length>0) {
             Horariolactanacia.showMessageError('El empleado Tiene permiso asignado  !! ');
             error=true;
        } 
            
        }
    return error;
}

Horariolactancia.Actualizarcheckboxgeneral=function(){
     var grid=this.getSGridView('gridEmpleados'); 
     
     cantelementos=grid.rows;
     canttikeados=0;
     cantnotikeados=0;
     elemento=$('#cbxgrilla1');     
        for(var f = 1; f <=cantelementos; f++)
        {            
               if( grid.row(f).get('seleccionar')==true)
               ++canttikeados;
               
            
        }
        if(cantelementos==canttikeados)
            elemento.prop('checked',true);
        else
            elemento.prop('checked',false);
    Horariolactancia.mostrarObservacionHorarioEventual();
}

Horariolactancia.mostrarObservacionHorarioEventual=function(){
    var grid;
    var vector=[];
    var fechadesde=$('#'+Horariolactancia.Id('fechadesde')).val();
    var fechahasta=$('#'+Horariolactancia.Id('fechahasta')).val();
   
    if(fechadesde!=''&& fechahasta!=''){      
        
      
            grid=this.getSGridView("gridEmpleados");
            for(var f = 1; f <= grid.rows; f++)
                {
                     if( grid.row(f).get('seleccionar')==true){

                        nombre=grid.row(f).get('nombrecompleto');
                        idempleado= grid.row(f).get('id');
                        vector.push({'id':idempleado,'nombrecompleto':nombre});
                       }
            }
    
    if(vector.length>0) {   
     $.ajax({     
        'type':'post',
        'url':'rrhh/horario/observacionHorarioEntreFechas',
        'data':{  grilla:vector,fechadesde:fechadesde,fechahasta:fechahasta},
        success:function (resp) {               
                 $('#' + Horariolactancia.Id("contenedorMensaje")).html(resp);          

       },
        error:function () {
            alert('ocurrio un error ');
        }

    });  }
    }
}
Horariolactancia.seleccionar=function(elemento){
   elemento=$(elemento);
  
   var grid=this.getSGridView('gridEmpleados'); 
   estado=elemento.prop('checked');
        for(var f = 1; f <= grid.rows; f++)
        {            
               grid.row(f).set('seleccionar',estado);  
            
        }
}
Horariolactancia.validarFechahastaEspecial=function(fechadesde){
     $('#' + Horariolactancia.Id("fechahasta")).datepicker("option", "minDate", fechadesde);
     Horariolactancia.mostrarObservacionHorarioEventual();            
}