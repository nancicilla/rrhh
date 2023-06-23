var Movimientopersonal = new Object();
Movimientopersonal.__proto__ = SystemWindow;
//variables
Movimientopersonal.nameView = "Movimientopersonal";
Movimientopersonal.url = "movimientopersonal";
Persona.init = function() {
    var THIS = this;

    if (this.action == 'create' || this.action == 'update' ||this.action=='CambiarHorario') {

        this.buttonChange({ id: 'save', label: 'Guardar', key: 'G' });

        
            }
     
       
};
Movimientopersonal.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Movimientopersonal',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Contrato',        
        layerEndOn: false,
        
        ableBackWindow: true
    });
 
      this.setActions('CambiarHorario', {

        WindowWidth: 550,
        WindowHeight: 360,
        WindowTitle: 'Cambiar Horario',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Movimientopersonal',
        WindowWidth: 550,
        WindowHeight: 310,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Movimientopersonal.CambiarHorario = function(options) {
    this.action = 'CambiarHorario';
    this.open(this.getOptions(options));
}
Movimientopersonal.beforeCreate = function () {
    var error = this.validarFormulario();
    return error;
}
Movimientopersonal.afterCreate = function () {
    Movimientopersonal.reload();
}

Movimientopersonal.beforeUpdate = function () {
    var error = this.validarFormulario();//false es no existe error antes de crear formulario   
    return error;
}
Movimientopersonal.afterUpdate = function () {
    Movimientopersonal.closeWindow();
}

Movimientopersonal.beforeCambiarHorario = function () {
    var error =false;//false es no existe error antes de crear formulario   
    if ($('#'+Movimientopersonal.Id('idhorario')).val()=='') {
        $('#'+Movimientopersonal.Id('idhorario')).css('background-color','#f68c8c');
        error=true;
        Movimientopersonal.showMessageError('Revise los datos !! ');
    }else{
        $('#'+Movimientopersonal.Id('idhorario')).css('background-color','#fff');
       
         if ($('#' + Movimientopersonal.Id('contenedorMensaje')).html() != '') {
             Movimientopersonal.showMessageError('El empleado Tiene permiso asignado  !! ');
             Movimientopersonal=true;
        } 
    

    }
    return error;
}
Movimientopersonal.afterCambiarHorario = function () {
    Movimientopersonal.closeWindow();
}
Movimientopersonal.validarFecha =function (fecha) {
    if(!/^\d{1,2}\-\d{1,2}\-\d{4}$/.test(fecha))
        return false;
    return true;
}
Movimientopersonal.validarFormulario=function () {
    var canterror=0;
    var error=false;
    if ($('#'+Movimientopersonal.Id('empleado')).val()=='') {
     $('#'+Movimientopersonal.Id('empleado')).css('background-color','#f68c8c'); 
     canterror+=1;
    }else{
     $('#'+Movimientopersonal.Id('empleado')).css('background-color','#fff'); 
    }
    if ($('#'+Movimientopersonal.Id('idpuestotrabajo')).val()=='') {
        $('#'+Movimientopersonal.Id('idpuestotrabajo')).css('background-color','#f68c8c');
        canterror+=1;
    }else{
        $('#'+Movimientopersonal.Id('idpuestotrabajo')).css('background-color','#fff');

    }
    if ($('#'+Movimientopersonal.Id('idnivelsalarial')).val()=='') {
        $('#'+Movimientopersonal.Id('idnivelsalarial')).css('background-color','#f68c8c');
        canterror+=1;
    }else{
        $('#'+Movimientopersonal.Id('idnivelsalarial')).css('background-color','#fff');

    }
    if ($('#'+Movimientopersonal.Id('tipocontrato')).val()=='') {
        $('#'+Movimientopersonal.Id('tipocontrato')).css('background-color','#f68c8c');
        canterror+=1;
    }else{
        $('#'+Movimientopersonal.Id('tipocontrato')).css('background-color','#fff');

    }
     var fecha=$('#'+Movimientopersonal.Id('fechaini')).val();
 var  estado=!this.validarFecha(fecha);
   if (estado) {
   $('#'+Movimientopersonal.Id('fechaini')).css('background-color','#f68c8c');
   canterror+=1;
   }else{
 $('#'+Movimientopersonal.Id('fechaini')).css('background-color','#fff');
   }

    if ($('#'+Movimientopersonal.Id('turno')).val()=='') {
        $('#'+Movimientopersonal.Id('turno')).css('background-color','#f68c8c');
        canterror+=1;
    }else{
        $('#'+Movimientopersonal.Id('turno')).css('background-color','#fff');

    }

   
    if (canterror>0) {
        Movimientopersonal.showMessageError('Revise los datos!! ');
        error=true;
    }
    return error;
}

Movimientopersonal.dameInfoE=function(ide) {
    var ele=$('#contu>select').attr('id');
    var indice=ele.indexOf("_");
    ele.substring(0, indice);
    $.ajax({
        'type':'post',
        'url':'rrhh/movimientopersonal/dameInfoE',
        'data':{ide:ide,nombre: ele.substring(0, indice)},
        success:function (vec) {
        
        $('#'+Movimientopersonal.Id('unidad')+'>option[value="'+vec.unidad+'"]').attr('selected',true);  
        $('#'+Movimientopersonal.Id('unidad')+'>option[value="'+vec.unidad+'"]').trigger('change');  

        
        $('#'+Movimientopersonal.Id('area')+'>option[value="'+vec.area+'"]').attr('selected',true);  
        $('#'+Movimientopersonal.Id('area')+'>option[value="'+vec.area+'"]').trigger('change');  
        
        $('#'+Movimientopersonal.Id('seccion')+'>option[value="'+vec.seccion+'"]').attr('selected',true);  
        $('#'+Movimientopersonal.Id('seccion')+'>option[value="'+vec.seccion+'"]').trigger('change');  
        
        $('#'+Movimientopersonal.Id('idpuestotrabajo')+'>option[value="'+vec.cargo+'"]').attr('selected',true);
        $('#'+Movimientopersonal.Id('idnivelsalarial')+'>option[value="'+vec.nivel+'"]').attr('selected',true);  
        $('#'+Movimientopersonal.Id('conthorario')).html(vec.horarios);
        $('#contrato').html(vec.contrato);

       },
        error:function () {
            alter('ocurrio un error al optener los datos del empleado...');
        }

    });
}

Movimientopersonal.dameInformacionHorario=function(idhorario){
     $('#'+Movimientopersonal.Id('conthorario')).empty();
       $.ajax({
        'type':'post',
        'url':'rrhh/movimientopersonal/dameHorario',
        'data':{idhorario:idhorario,nombre: Movimientopersonal.groupForm},
        success:function (resp) {
           
         $('#'+Movimientopersonal.Id('conthorario')).html(resp.horarios);
        

       },
        error:function () {
            alter('ocurrio un error al optener los datos del empleado...');
        }

    });
    

}