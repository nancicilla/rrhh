var Asistencia = new Object();
Asistencia.__proto__ = SystemWindow;
//variables
Asistencia.nameView = "Asistencia";
Asistencia.url = "asistencia";
Asistencia.init = function () {
     var THIS=this;
    if (this.action == 'create'||   this.action == 'update'|| this.action == 'Actualizar') {
     
    this.buttonChange({id: 'save', label: 'Guardar', key: 'G'});    
       
    }


     
};

Asistencia.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Asistencia-Corte',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Asistencia',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
     this.setActions('Seguimiento', {   
       
         WindowWidth: 800,
        WindowHeight: 500,    
        WindowTitle: 'Asistenciaee',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
     this.setActions('Actualizar', {   
       
         WindowWidth: 250,
        WindowHeight: 350, 
        WindowTitle: 'Actualizar Fechas',
          initButtons: 'back,save',
             endButtons: 'back',
             layerEndOn: false,
             ableBackWindow: true
    });
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Asistencia',
        WindowWidth: 250,
        WindowHeight: 350,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}
/*
       $('#'+this.Id('proveedor')).blur(function(){
            if(Orden.get('idproveedor') == ''){
                this.value = '';
                Orden.ById('proveedor').style.background="";
                Orden.buscarBanco('');
            }
        });
*/
Asistencia.Seguimiento = function(options) {
    this.action = 'Seguimiento';
    this.open(this.getOptions(options));
}
Asistencia.afterSeguimiento = function () {
//

Asistencia.closeWindow();

}
Asistencia.update=function () {
  this.action = 'update';
    this.open(this.getOptions());
}
Asistencia.Actualizar = function() {
    this.action = 'Actualizar';
    this.open(this.getOptions());
}
Asistencia.afterActualizar = function () {
   Asistencia.closeWindow();
 }
Asistencia.cerrarVentana = function () {
   Asistencia.closeWindow();

}
Asistencia.beforeSeguimiento = function () {
    var error = this.validarFormularioSeguimiento();//false es no existe error antes de crear formulario
    return error;
}
Asistencia.beforeCreate = function () {
    var error = this.validarFormulario();//false es no existe error antes de crear formulario
    return error;
}
Asistencia.afterCreate = function () {
    Asistencia.closeWindow();
}

Asistencia.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Asistencia.afterUpdate = function () {
    Asistencia.closeWindow();
}
Asistencia.validarFormulario=function () {
    var error=false;
    var cant=0;
    if ($('#'+Asistencia.Id('fechahasta')).val()=='') {
         $('#'+Asistencia.Id('fechahasta')).css('background-color','#f68c8c');
        
      ++cant;
    }else{
        $('#'+Asistencia.Id('fechahasta')).css('background-color','#fff');
    }
     if ($('#'+Asistencia.Id('fechadesde')).val()=='') {
         $('#'+Asistencia.Id('fechadesde')).css('background-color','#f68c8c');
           ++cant;
    }else{
        $('#'+Asistencia.Id('fechadesde')).css('background-color','#fff');
    }
    if ($('#'+Asistencia.Id('fechaic')).val()=='') {
         $('#'+Asistencia.Id('fechaic')).css('background-color','#f68c8c');
        
      ++cant;
    }else{
        $('#'+Asistencia.Id('fechaic')).css('background-color','#fff');
    }
     if ($('#'+Asistencia.Id('fechafc')).val()=='') {
         $('#'+Asistencia.Id('fechafc')).css('background-color','#f68c8c');
           ++cant;

    }else{
        $('#'+Asistencia.Id('fechafc')).css('background-color','#fff');
    }

    if ($('#'+Asistencia.Id('fechaic')).val()> $('#'+Asistencia.Id('fechafc')).val()) {
     ++cant;
     
      $('#'+Asistencia.Id('fechafc')).css('background-color','#f68c8c');
    }else{
        $('#'+Asistencia.Id('fechafc')).css('background-color','#fff');
    }
    if ($('#'+Asistencia.Id('fechadesde')).val()> $('#'+Asistencia.Id('fechahasta')).val()) {
     ++cant;
      $('#'+Asistencia.Id('fechahasta')).css('background-color','#f68c8c');
    }else{
       
       $('#'+Asistencia.Id('fechahasta')).css('background-color','#fff');
    }
    if (cant>0) {
         Asistencia.showMessageError('Revise los datos !! ');
         error=true;
    }
   
    return error;
}

Asistencia.mostrar=function (par1,par2) {
    var k = (document.all) ? event.keyCode : event.which;
    var THIS = this;   
    if(k == 13)
    {
    var valora= SGridView.getSelected('dias');
    var ida=SGridView.getSelected('id');
    $.ajax({
        url:'rrhh/asistencia/actualizardia',
        type:'post',
        data:{id:ida,valor:valora},
        success:function (resp) {
            
        },
        error:function (error) {
            console.log('OCURRIO UN ERROR EN EL MOMENTO DE LA ACTUALIZACION');
        }
        });

    
        
    }
  }
  Asistencia.actualizarFactorDescuentoFalta=function (par1,par2) {
    var k = (document.all) ? event.keyCode : event.which;
    var THIS = this;   
    if(k == 13)
    {
    var valora= SGridView.getSelected('factordescuentofalta');
    var ida=SGridView.getSelected('id');
    $.ajax({
        url:'rrhh/asistencia/actualizarFactorDescuentoFalta',
        type:'post',
        data:{id:ida,valor:valora},
        success:function (resp) {
            
        },
        error:function (error) {
            console.log('OCURRIO UN ERROR EN EL MOMENTO DE LA ACTUALIZACION');
        }
        });

    
        
    }
  }
  Asistencia.mostrarasistencia=function (elemento) {
    var fecha=$(elemento).val();
    cadena=$(elemento).attr('id').split("_", 2);    
    var ida= $('#'+cadena[0]+'_id').val();

       $.ajax({
        url:'rrhh/asistencia/dameasistenciadia',
        type:'post',
        data:{id:ida,fecha:fecha,nombre:cadena[0]},
        success:function (resp) {
          console.log(cadena[0]);
            $( '#'+Asistencia.Id('contenedorAsistencia')).html(resp);
           
        },
        error:function (error) {
            console.log('OCURRIO UN ERROR AL CARGAR ');
        }
        });
          
  }
  
  Asistencia.ejemplo = function() {
    var grid = this.getSGridView('gridEntradasalida');
    this.gridSearchVars('gridEntradasalida', '&idcategoriatipo=' + grid.rowSelected().get('idcategoriatipo') + '&bbb=222'); 
    
}
Asistencia.probando=function () {
    var grid = this.getSGridView('gridEntradasalida');
  
    if ( grid.rowSelected().get('idcategoriatipo')=='4') {
      console.log("entrando para modificar");
      grid.rowSelected().set('autorizado',1);
    }
}

Asistencia.actualizarhoraextra=function () {
    var k = (document.all) ? event.keyCode : event.which;
    var THIS = this;   
    if(k == 13)
    {
    var valora= SGridView.getSelected('horasextras');
    var ida=SGridView.getSelected('id');
    $.ajax({
        url:'rrhh/asistencia/actualizarhoraextra',
        type:'post',
        data:{id:ida,valor:valora},
        success:function (resp) {
            
        },
        error:function (error) {
            console.log('OCURRIO UN ERROR EN EL MOMENTO DE LA ACTUALIZACION');
        }
        });

    
        
    }}
Asistencia.actualizarvalor=function (primer,seg) {
    var k = (document.all) ? event.keyCode : event.which;
    var THIS = this;  
   
    if(k == 13)
    {  
    var valora= SGridView.getSelected(primer);
    var ida=SGridView.getSelected('id');
    $.ajax({
        url:'rrhh/asistencia/actualizarvalor',
        type:'post',
        data:{id:ida,columna:primer,valor:valora},
        success:function (resp) {
            
        },
        error:function (error) {
            console.log('OCURRIO UN ERROR EN EL MOMENTO DE LA ACTUALIZACION');
        }
        });

    
        
    }}

  


