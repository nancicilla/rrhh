var Persona = new Object();
Persona.__proto__ = SystemWindow;
//variables
Persona.nameView = "Persona";
Persona.url = "persona";
Persona.idm;
Persona.generar='';
Persona.init = function() {
    var THIS = this;

    if (this.action == 'create' || this.action == 'view' || this.action == 'BoletaEmpleado' || this.action == 'Deduccion' || this.action == 'NuevoContrato'|| this.action == 'NuevoHorario' || this.action == 'ReincorporacionEmpleado' || this.action == 'RetiroEmpleado'|| this.action == 'RetiroEmpleadosinfiniquito'  || this.action == 'Permiso' || this.action == 'Bono' || this.action == 'update'||this.action=='EliminarEmpleado') {

        this.buttonChange({ id: 'save', label: 'Guardar', key: 'G' });
       
             if (this.action === 'create'|| this.action == 'update') {
        Persona.gridSearchVars('gridPorcentajespago', +SGridView.getAllData(this.getSGridView('gridPorcentajespago').idempresasubempleadora,'idempresasubempleadora'));
   
        }
        $('#' + this.Id('municipio')).keyup(function(e) {
            var k = (document.all) ? e.keyCode : e.which;
            if (k != 37 && k != 38 && k != 39 && k != 40 && k != 13 && k != 9) {
                Persona.set('idmunicipio', '');
                Persona.ById('municipio').style.background = "";
                Persona.set('idlocalidad', '');
                Persona.ById('localidad').style.background = "";
            }
        });
        $('#' + this.Id('municipio')).blur(function() {
            if (Persona.get('idmunicipio') == '') {
                this.value = '';
                Persona.ById('municipio').style.background = "";
                Persona.ById('localidad').style.background = "";
            }else{
                 Persona.set('idlocalidad', '');
                Persona.ById('localidad').style.background = "";
            }
        });
        
        $('#' + this.Id('nivelsalarial')).keyup(function(e) {
            var k = (document.all) ? e.keyCode : e.which;
            if (k != 37 && k != 38 && k != 39 && k != 40 && k != 13 && k != 9) {
                Persona.set('idnivelsalarial', '');
                Persona.ById('nivelsallarial').style.background = "";
                
            }
        });
      
        
    }

    jQuery('#' + Persona.Id('localidad')).
    autocomplete({ 'source': '/coreT/rrhh/persona/autocompleteLocalidad?idmunicipio=' + $('#' + Persona.Id('idmunicipio')).val() });


};

Persona.options = function() {
        this.setActions('create', {
            WindowTitle: 'Crear Personal',
            initButtons: 'save,cancel',
            layerEndOn: false,
            ableBackWindow: true
        });

        this.setActions('BoletaEmpleado', {

            WindowWidth: 300,
            WindowHeight: 250,
            WindowTitle: 'Boleta Empleado',
            initButtons: 'planillas',
            endButtons: 'planillas',
            layerEndOn: false,
            ableBackWindow: true
        });
        this.setActions('view', {
            WindowTitle: 'Asignación de Uniforme',
            initButtons: 'save,cancel',
            layerEndOn: false,
            ableBackWindow: true
        });
        this.setActions('Permiso', {

            WindowWidth: 400,
            WindowHeight: 550,
            WindowTitle: 'Permisos',
            initButtons: 'save,cancel',
            layerEndOn: false,
            ableBackWindow: true
        });
        this.setActions('update', {
            WindowTitle: 'Modificar Personal',
            initButtons: 'save,cancel',
            layerEndOn: false,
            ableBackWindow: true
        });
        this.setActions('RetiroEmpleado', {
            WindowWidth: 550,
            WindowHeight: 580,
            WindowTitle: 'Registro Finiquito',
            initButtons: 'save,cancel',
            layerEndOn: false,
            ableBackWindow: true
        });
         this.setActions('RetiroEmpleadosinfiniquito', {
            WindowWidth: 250,
            WindowHeight: 280,
            WindowTitle: 'Retiro de Empleado',
            initButtons: 'save,cancel',
            layerEndOn: false,
            ableBackWindow: true
        });

        this.setActions('ReincorporacionEmpleado', {

            WindowWidth: 680,
            WindowHeight: 360,
            WindowTitle: 'Reincorporacion Empleado ',
            initButtons: 'save,cancel',
            layerEndOn: false,
            ableBackWindow: true
        });
        this.setActions('NuevoContrato', {

            WindowWidth: 680,
            WindowHeight: 360,
            WindowTitle: 'Nuevo Contrato',
            initButtons: 'save,cancel',
            layerEndOn: false,
            ableBackWindow: true
        });
        this.setActions('NuevoHorario', {

            WindowWidth: 680,
            WindowHeight: 560,
            WindowTitle: 'Nuevo Horario',
            initButtons: 'save,cancel',
            layerEndOn: false,
            ableBackWindow: true
        });
        this.setActions('Deduccion', {

            WindowWidth: 400,
            WindowHeight: 450,
            WindowTitle: 'Deducion',
            initButtons: 'save,cancel',
            layerEndOn: false,
            ableBackWindow: true
        });
        this.setActions('Bono', {

            WindowWidth: 350,
            WindowHeight: 426,
            WindowTitle: 'Asignación de Bono',
            initButtons: 'save,cancel',
            layerEndOn: false,
            ableBackWindow: true
        });
         this.setActions('EliminarEmpleado', {
            WindowWidth: 380,
            WindowHeight: 200,
            WindowTitle: 'Eliminar Empleado',
            initButtons: 'save,cancel',
            layerEndOn: false,
            ableBackWindow: true
        });
        var options = {
            WindowName: this.nameView,
            WindowTitle: 'Persona',
            WindowWidth: 900,
            WindowHeight: 620,
            WindowInitFunction: '',
            WindowCloseFunction: '',
            WindowMaxFunction: '',
            WindowMinFunction: '',
            WindowOnBackground: true,
            typeLoading: 'on' // on,off,onMain
        };
        return options;
    }
    //
Persona.Permiso = function(options) {
    this.action = 'Permiso';
    this.open(this.getOptions(options));
}
Persona.RetiroEmpleado = function(options) {
    this.action = 'RetiroEmpleado';
    this.open(this.getOptions(options));
}
Persona.RetiroEmpleadosinfiniquito = function(options) {
    this.action = 'RetiroEmpleadosinfiniquito';
    this.open(this.getOptions(options));
}
Persona.ReincorporacionEmpleado = function(options) {
    this.action = 'ReincorporacionEmpleado';
    this.open(this.getOptions(options));
}
Persona.Deduccion = function(options) {
    this.action = 'Deduccion';
    this.open(this.getOptions(options));
}
Persona.NuevoContrato = function(options) {
    this.action = 'NuevoContrato';
    this.open(this.getOptions(options));
}
Persona.NuevoHorario = function(options) {
    this.action = 'NuevoHorario';
    this.open(this.getOptions(options));
}
Persona.afterDeduccion = function(options) {
    Persona.closeWindow();
}
Persona.Bono = function(options) {
    this.action = 'Bono';
    this.open(this.getOptions(options));
}
Persona.BoletaEmpleado = function(options) {

    this.action = 'BoletaEmpleado';
    this.open(this.getOptions(options));
}
Persona.EliminarEmpleado = function(options) {
    this.action = 'EliminarEmpleado';
    this.open(this.getOptions(options));
}
Persona.beforeCreate = function() {
    var error = false; // this.validarGrilla();//false es no existe error antes de crear formulario
    //var grilla=this.validarGrillaHT();  
    var depe = this.validarGrillaDependiente();
    var porcentaje=this.sumarPorcentaje();
    var contrato = this.validarContrato();
    if ((depe) || contrato||porcentaje) {
        if(porcentaje)
            Persona.showMessageError('La suma de los porcentajes debe ser igual 100 !! ');
            else
        Persona.showMessageError('Revise los datos !! ');
        error = true;
    }
    return error;
}
Persona.afterCreate = function() {
    Persona.reload();
}

Persona.beforeUpdate = function() {
    Persona.dameAutocomplete();
    var error = false; // this.validarGrilla();//false es no existe error antes de crear formulario
    var porcentaje=this.sumarPorcentaje();  
    var depe = this.validarGrillaDependiente();
    var contrato=this.validarContratou();   
    if (depe||porcentaje||contrato) {
        if(porcentaje)
            Persona.showMessageError('La suma de los porcentajes debe ser igual 100 !! ');
            else
             Persona.showMessageError('Revise los datos !! ');
            error = true;
    }
    return error;
}
Persona.afterUpdate = function() {
    Persona.closeWindow();
}
Persona.beforeView = function() {
    // var error=this.validarGrilla();
    var entrega = this.validarGrillaE();
    var devolucion = this.validarGrillaD();
    var canterror=0;
    var mensaje='';

    var error = false;
    if ( $('#'+ Persona.Id('fechaentrega')).val()!=='' && $('#'+ Persona.Id('descripcion_entrega')).val()=='') {
        mensaje='Esta intentando guardar datos vacios en Entrega !! ';
        ++canterror;
    } 
     
    if  ( $('#'+ Persona.Id('fechadevolucion')).val()!=='' && $('#'+ Persona.Id('descripcion_devolucion')).val()=='') {
             ++canterror;
           mensaje='Revise los datos en Devolución de Uniforme!! ';
       
    } 
        
   if (canterror>0) {
          Persona.showMessageError(mensaje);
            error = true;

            
        } 


    
    return error;
}
Persona.afterView = function() {
    Persona.closeWindow();
}
Persona.beforePermiso = function() {
    var error = this.validarPermiso();


    return error;
}
Persona.beforeRetiroEmpleado = function() {
    var error = this.validarEstadoEmpleado();
    console.log("--->"+$('#' + Persona.Id('idempleado')).val()+"<---");
    if (error == false && $('#' + Persona.Id('activo')).val() == '1') {
        if ($('#' + Persona.Id('estadocivil')).val() != 'V') {
            error = true;

            $.ajax({
                'type': 'post',
                'url': 'rrhh/pagobeneficio/dameListaPlanillaFiniquito',
                'data': { fecharetiro: $('#' + Persona.Id('fecharetiro')).val(),idempleado:$('#' + Persona.Id('idempleado')).val() },
                success: function(resp) {

                    $('#' + Persona.Id('contenedorMensaje')).html(resp);
                    $('#' + Persona.Id('estadocivil')).val('V');
                    $('#' + Persona.Id('contenedorMensaje')).show();
                    $('#' + Persona.Id('contenedorAguinaldo')).show();
                    $('#' + Persona.Id('contenedorRetiro')).hide();
                    Persona.generar=resp;

                },
                error: function(er) {
                    alter('ocurrio un error al optener los datos del empleado...');
                }

            });

        }
    }
    return error;


}
Persona.beforeRetiroEmpleadosinfiniquito = function() {
    var error = false;
    if ($('#'+Persona.Id('fecharetiro')).val()==''){
        $('#' + Persona.Id('fecharetiro')).css('background-color', '#f68c8c');

            error = true;
   Persona.showMessageError('Revise los datos !! ');
           
    }else{
       $('#' + Persona.Id('fecharetiro')).css('background-color', '#ffffff');
  
    }
   
    return error;


}
Persona.beforeReincorporacionEmpleado = function() {
    var error = this.validarEstadoEmpleado();
    return error;
}
Persona.afterRetiroEmpleado = function() {
    this.printFiniquito();
    Persona.closeWindow();
}
Persona.afterRetiroEmpleadosinfiniquito = function() {
    Persona.closeWindow();
}
Persona.afterReincorporacionEmpleado = function() {
     Persona.closeWindow();
}
Persona.beforeNuevoContrato = function() {
    var error = this.validarFormularioM();
    return error;
}
Persona.afterNuevoContrato = function() {
    Persona.closeWindow();
}
Persona.beforeNuevoHorario = function() {

    var error = false;
    var cant = 0;
   
    if ($('#' + Persona.Id('fechaini')).val() == '') {
        ++cant;
        $('#' + Persona.Id('fechaini')).css('background-color', '#f68c8c');
    } else {
        $('#' + Persona.Id('fechaini')).css('background-color', '#fff');
    }
    if ($('#' + Persona.Id('idhorario')).val() == '') {
        ++cant;
        $('#' + Persona.Id('idhorario')).css('background-color', '#f68c8c');
    } else {
        $('#' + Persona.Id('idhorario')).css('background-color', '#fff');
    }
    
    if(cant>0){
        Persona.showMessageError('Revise los datos !! ');
        error=true;
    }else{
         if ($('#' + Persona.Id('contenedorMensaje')).html() != '') {
             Persona.showMessageError('El empleado Tiene permiso asignado  !! ');
             error=true;
        } 
    }
    
    return error;
}
Persona.afterEliminarEmpleado= function() {
    Persona.closeWindow();
}
Persona.beforeEliminarEmpleado = function() {
    var error = false;
    return error;
}
Persona.afterNuevoHorario = function() {
    Persona.closeWindow();
}
Persona.beforeDeduccion = function() {
    var error = this.validarDeduccion();


    return error;
}
Persona.afterPermiso = function() {
    Persona.closeWindow();
    

    // Persona.reload();
}
Persona.listaPuestotrabajo = function(idseccion, idelemento) {
    $.ajax({
        type: 'post',
        async: false,
        cache: false,
        url: 'rrhh/puestotrabajo/listaPuestotrabajo',
        data: { ids: idseccion },
        success: function(elementos) {

            $('#' + idelemento).empty();
            $('#' + idelemento).html(elementos);

        },
        error: function(er) {
            alert('error');
        }
    });
}
Persona.dameIdMunicipio = function() {

    return $('#' + this.Id('idmunicipio')).val();
}
Persona.dameAutocomplete = function() {

    jQuery('#' + Persona.Id('localidad')).
    autocomplete({ 'source': '/coreT/rrhh/persona/autocompleteLocalidad?idmunicipio=' + $('#' + this.Id('idmunicipio')).val() });
}
Persona.validarGrillaE = function() {
    var grilla = this.getSGridView('gridEntregau');
    var totale = 0;
    var error = false;
    var cant = 0;
    for (var f = 1; f <= grilla.rows; f++) {

        if (grilla.row(f).get('uniforme') != '' || grilla.row(f).get('talla') != '' || grilla.row(f).get('unidad') != '' || grilla.row(f).get('cantidad') != '') {
            grilla.row(f).attributes('uniforme', { tooltip: '', validate: true });
            ++cant;
            if (grilla.row(f).get('uniforme') != '') {
                grilla.row(f).attributes('uniforme', { tooltip: '', validate: true });
            } else {

                grilla.row(f).attributes('uniforme', { tooltip: 'Ingrese el nombre del Uniforme!!', validate: false });
                ++totale;
            }
            if (grilla.row(f).get('talla') != '') {
                grilla.row(f).attributes('talla', { tooltip: '', validate: true });

            } else {

                grilla.row(f).attributes('talla', { tooltip: 'Ingrese el nombre del Uniforme!!', validate: false });
                ++totale;
            }
            if (grilla.row(f).get('unidad') != '') {
                grilla.row(f).attributes('unidad', { tooltip: '', validate: true });

            } else {

                grilla.row(f).attributes('unidad', { tooltip: 'Ingrese el nombre del Uniforme!!', validate: false });
                ++totale;
            }
            if (grilla.row(f).get('cantidad') != '') {
                grilla.row(f).attributes('cantidad', { tooltip: '', validate: true });

            } else {

                grilla.row(f).attributes('cantidad', { tooltip: 'Ingrese el nombre del Uniforme!!', validate: false });
                ++totale;
            }




        }



    }
    if (cant > 0) {
        if ($('#' + Persona.Id('fechae')).val() == '') {
            $('#' + Persona.Id('fechae')).css('background-color', '#f68c8c');

            error = true;
        }
    }
    if (totale > 0) {
        error = true;
    }


    return ['' + cant, '' + error];
}

Persona.validarGrillaD = function() {
    var grilla = this.getSGridView('gridEntregaud');
    var error = false;
    var cant = 0;
    for (var f = 1; f <= grilla.rows; f++) {
        try {
            if (grilla.row(f).get('devuelto') == '1') {
                ++cant;
            }

        } catch (ex) {

        }
    }
    if (cant > 0) {
        if ($('#' + Persona.Id('fechad')).val() == '') {
            $('#' + Persona.Id('fechad')).css('background-color', '#f68c8c');

            error = true;
        }
    }
    return ['' + cant, '' + error];
}
Persona.validarContrato = function() {

    var error = false;
    var cante = 0;

    var elementos = $('select[data-v]');


    $.each(elementos, function(ind, ele) {
        if ($(ele).val() == '') {
            $(ele).css('background-color', '#f68c8c');

            ++cante;
        } else {
            $(ele).css('background-color', '#fff');
        }
    });

    if ($('#' + Persona.Id('fechaplanilla')).val() == '') {
        $('#' + Persona.Id('fechaplanilla')).css('background-color', '#f68c8c');

        ++cante;
    } else {
        $('#' + Persona.Id('fechaplanilla')).css('background-color', '#fff');
    }

    if ($('#' + Persona.Id('fechaantiguedad')).val() == '') {
        $('#' + Persona.Id('fechaantiguedad')).css('background-color', '#f68c8c');

        ++cante;
    } else {
        $('#' + Persona.Id('fechaantiguedad')).css('background-color', '#fff');
    }

    if ($('#' + Persona.Id('fechaultidemnizacion')).val() == '') {
        $('#' + Persona.Id('fechaultidemnizacion')).css('background-color', '#f68c8c');

        ++cante;
    } else {
        $('#' + Persona.Id('fechaultidemnizacion')).css('background-color', '#fff');
    }
    if ( $('#' + Persona.Id('montocategoria')).val()=='' ) {
        $('#' + Persona.Id('montocategoria')).css('background-color', '#f68c8c');

        ++cante;
    } else {
        $('#' + Persona.Id('montocategoria')).css('background-color', '#fff');
    }
    if ( $('#' + Persona.Id('montotransporte')).val()=='' ) {
        $('#' + Persona.Id('montotransporte')).css('background-color', '#f68c8c');

        ++cante;
    } else {
        $('#' + Persona.Id('montotransporte')).css('background-color', '#fff');
    }
    if ( $('#' + Persona.Id('idnivelsalarial')).val()=='' ) {
        $('#' + Persona.Id('nivelsalarial')).css('background-color', '#f68c8c');

        ++cante;
    } else {
        $('#' + Persona.Id('nivelsalarial')).css('background-color', '#fff');
    }
    if ( $('#' + Persona.Id('idhorario')).val()=='' ) {
        $('#' + Persona.Id('idhorario')).css('background-color', '#f68c8c');
        ++cante;
    } else {
        $('#' + Persona.Id('idhorario')).css('background-color', '#fff');
    }
    if (cante > 0) {
        error = true;
    }

    return error;

}
Persona.validarGrillaHT = function() {
    var grilla = this.getSGridView('gridHorasTrabajo');
    var error = false;
    var cant = 0;
    for (var f = 1; f <= grilla.rows; f++) {
        try {
            if (grilla.row(f).get('dia') == '') {
                ++cant;
                grilla.row(f).attributes('dia', { tooltip: '', validate: false });

            } else {
                grilla.row(f).attributes('dia', { tooltip: '', validate: true });

            }
            if (grilla.row(f).get('diad') == '') {
                ++cant;
                grilla.row(f).attributes('diad', { tooltip: '', validate: false });

            } else {
                grilla.row(f).attributes('diad', { tooltip: '', validate: true });

            }
            if (grilla.row(f).get('rangohora') == '') {
                ++cant;
                grilla.row(f).attributes('rangohora', { tooltip: '', validate: false });

            } else {
                grilla.row(f).attributes('rangohora', { tooltip: '', validate: true });

            }

            if (this.validarFecha(grilla.row(f).get('fechaiseq')) && grilla.row(f).get('estado') == 0) {

                grilla.row(f).attributes('fechaiseq', { tooltip: '', validate: true });

            } else if (!this.validarFecha(grilla.row(f).get('fechaiseq')) && grilla.row(f).get('estado') == 0) {

                ++cant;
                grilla.row(f).attributes('fechaiseq', { tooltip: '', validate: false });
            }

 

        } catch (ex) {


        }
    }
    if (cant > 0) {
        Persona.showMessageError('Revise los datos !! ');
        error = true;
    }
    return error;
}
Persona.validarFecha = function(fecha) {

    var fecha = fecha.split('-');
    var anio = fecha[2];
    var mes = fecha[1];
    var dia = fecha[0];

    var fechaaux = new Date(anio, mes - 1, dia); //mes empieza de cero Enero = 0

    if (!fechaaux || fechaaux.getFullYear() == anio && fechaaux.getMonth() == mes - 1 && fechaaux.getDate() == dia) {

        return true;
    } else {

        return false;
    }
}

Persona.cantidadHora = function() {
    var grilla = Persona.getSGridView('gridHorasTrabajo');
    //var confirmado = grid.rowSelected().get('rangohora');
    // console.log(confirmado);
    th = 0;
    tm = 0;
    for (var f = 1; f <= grilla.rows; f++) {

        if (grilla.row(f).get('rangohora') != '') {

            if (grilla.row(f).get('iddia') != '' && grilla.row(f).get('iddiad') != '') {
                aux = parseInt(grilla.row(f).get('iddiad')) - parseInt(grilla.row(f).get('iddia')) + 1;
                cadena = grilla.row(f).get('rangohora');
                vech = cadena.split('-');
                vech[1] = vech[1].substring(0, 5);
                vhi = vech[0].split(':');
                vhf = vech[1].split(':');
                hi = parseInt(vhi[0]);
                mi = parseInt(vhi[1]);
                hf = parseInt(vhf[0]);
                mf = parseInt(vhf[1]);
                th += Math.abs(hf - hi) * aux; //Math.abs(-7.25)
                tm += mf - mi;
                grilla.row(f).attributes('diad', { tooltip: '', validate: true });
                grilla.row(f).attributes('dia', { tooltip: '', validate: true });
            } else {
                grilla.row(f).attributes('diad', { tooltip: '', validate: false });
                grilla.row(f).attributes('dia', { tooltip: '', validate: false });
            }


        }

        if (tm >= 60) {
            ++th;
            tm = 0;
        } else {
            if (tm < 0) {
                --th;
                tm = Math.abs(tm);
            }

        }
        $('#chd').html('<strong>' + th + '</strong> horas con <strong>' + tm + ' </strong>minutos por semana');

    }


    /* if (confirmado==1){
          grid.rowSelected().set('conforme', 1);
     }else{
         grid.rowSelected().ById('cantidadrecibida').click();
     }*/
}
Persona.validarGrillaDependiente = function() {
    var grilla = Persona.getSGridView('gridDependientes');
    var cante = 0;
    var error = false;
    for (var f = 1; f <= grilla.rows; f++) {
        if ( /*grilla.row(f).get('ci')!=''||*/ grilla.row(f).get('nombrec') != '' || grilla.row(f).get('fechanacr') != '' || grilla.row(f).get('parentesco') != '') {
            /*
                 if (grilla.row(f).get('ci')=='')
                 {
                    ++cante;
                    grilla.row(f).attributes('ci', {tooltip: '', validate: false}); 
                 }else{
                     grilla.row(f).attributes('ci', {tooltip: '', validate: true}); 
                 }*/
            if (grilla.row(f).get('nombrec') == '') {
                ++cante;
                grilla.row(f).attributes('nombrec', { tooltip: '', validate: false });
            } else {
                grilla.row(f).attributes('nombrec', { tooltip: '', validate: true });
            }
            if (!this.validarFecha(grilla.row(f).get('fechanacr'))) {
                ++cante;
                grilla.row(f).attributes('fechanacr', { tooltip: '', validate: false });
            } else {
                grilla.row(f).attributes('fechanacr', { tooltip: '', validate: true });
            }
            if (grilla.row(f).get('parentesco') == '') {
                ++cante;
                grilla.row(f).attributes('parentesco', { tooltip: '', validate: false });
            } else {
                grilla.row(f).attributes('parentesco', { tooltip: '', validate: true });
            }

        } else {
            grilla.row(f).attributes('parentesco', { tooltip: '', validate: true });
            grilla.row(f).attributes('fechanacr', { tooltip: '', validate: true });
            grilla.row(f).attributes('nombrec', { tooltip: '', validate: true });
            grilla.row(f).attributes('ci', { tooltip: '', validate: true });
        }
    }
    if (cante > 0) {
        error = true;
        Persona.showMessageError('Debe llenar los dependientes !! ');
    }
    return error;
}
Persona.validarPermiso = function() {
    if ($('#' + Persona.Id('tipo')).prop('checked')) {
        return this.Validacion2();
    } else {
        return this.Validacion1();
    }

}
Persona.validarEstadoEmpleado = function() {
    var error = false;
    var cant = 0;
   
        if ($('#' + Persona.Id('fecha')).val() == '') {
            ++cant;
            $('#' + Persona.Id('fecha')).css('background-color', '#f68c8c');
        } else {
            $('#' + Persona.Id('fecha')).css('background-color', '#fff');
        }
        if ($('#' + Persona.Id('fechaini')).val() == '') {
            ++cant;
            $('#' + Persona.Id('fechaini')).css('background-color', '#f68c8c');
        } else {
            $('#' + Persona.Id('fechaini')).css('background-color', '#fff');
        }
        if ($('#' + Persona.Id('idpuestotrabajo')).val() == '') {
            ++cant;
            $('#' + Persona.Id('idpuestotrabajo')).css('background-color', '#f68c8c');
        } else {
            $('#' + Persona.Id('idpuestotrabajo')).css('background-color', '#fff');
        }
        if ($('#' + Persona.Id('nivelsalarial')).val() == '') {
            ++cant;
            $('#' + Persona.Id('nivelsalarial')).css('background-color', '#f68c8c');
        } else {
            $('#' + Persona.Id('nivelsalarial')).css('background-color', '#fff');
        }
        if ($('#' + Persona.Id('tipocontrato')).val() == '') {
            ++cant;
            $('#' + Persona.Id('tipocontrato')).css('background-color', '#f68c8c');
        } else {
            $('#' + Persona.Id('tipocontrato')).css('background-color', '#fff');
        }
        if ($('#' + Persona.Id('idhorario')).val() == '') {
            ++cant;
            $('#' + Persona.Id('idhorario')).css('background-color', '#f68c8c');
        } else {
            $('#' + Persona.Id('idhorario')).css('background-color', '#fff');
        }
    

    if (cant > 0) {
        error = true;
        Persona.showMessageError('Revise los datos !! ');
    }
    return error;
}
Persona.Validacion1 = function() {

    var error = false;
    var cant = 0;
    if ($('#' + Persona.Id('fechai')).val() == '') {
        ++cant;
        $('#' + Persona.Id('fechai')).css('background-color', '#f68c8c');
    } else {
        $('#' + Persona.Id('fechai')).css('background-color', '#fff');
    }
    if ($('#' + Persona.Id('fechaf')).val() == '') {
        ++cant;
        $('#' + Persona.Id('fechaf')).css('background-color', '#f68c8c');
    } else {
        $('#' + Persona.Id('fechaf')).css('background-color', '#fff');
    }
    if ($('#' + Persona.Id('idtipopermiso')).val() == '') {
        ++cant;
        $('#' + Persona.Id('idtipopermiso')).css('background-color', '#f68c8c');
    } else {

        $('#' + Persona.Id('idtipopermiso')).css('background-color', '#fff');
    }

    if (cant > 0) {
        Persona.showMessageError('Revise los datos!! ');
        error = true;
    }
    return error;
}
Persona.validarDeduccion = function() {

    var error = false;
    var cant = 0;
    if ($('#' + Persona.Id('fechar')).val() == '') {
        ++cant;
        $('#' + Persona.Id('fechar')).css('background-color', '#f68c8c');
    } else {
        $('#' + Persona.Id('fechar')).css('background-color', '#fff');
    }
    if ($('#' + Persona.Id('iddeducciones')).val() == '') {
        ++cant;
        $('#' + Persona.Id('iddeducciones')).css('background-color', '#f68c8c');
    } else {
        $('#' + Persona.Id('iddeducciones')).css('background-color', '#fff');
    }
    if ($('#' + Persona.Id('descripcion')).val() == '') {
        ++cant;
        $('#' + Persona.Id('descripcion')).css('background-color', '#f68c8c');
    } else {
        $('#' + Persona.Id('descripcion')).css('background-color', '#fff');
    }
    if (parseFloat($('#' + Persona.Id('monto')).val()) <= 1) {
        ++cant;
        $('#' + Persona.Id('monto')).css('background-color', '#f68c8c');
    } else {
        $('#' + Persona.Id('monto')).css('background-color', '#fff');
    }

    if (cant > 0) {
        Persona.showMessageError('Revise los datos!! ');
        error = true;
    }
    return error;
}
Persona.Validacion2 = function() {

    var error = false;
    var cant = 0;
    if ($('#' + Persona.Id('idtipopermiso')).val() == '') {
        ++cant;
        $('#' + Persona.Id('idtipopermiso')).css('background-color', '#f68c8c');
    } else {

        $('#' + Persona.Id('idtipopermiso')).css('background-color', '#fff');
    }
    if ($('#' + Persona.Id('fechai')).val() == '') {
        ++cant;
        $('#' + Persona.Id('fechai')).css('background-color', '#f68c8c');
    } else {
        $('#' + Persona.Id('fechai')).css('background-color', '#fff');
    }

    cant += this.validarHoras();

    if (cant > 0) {
        Persona.showMessageError('Revise los datos!! ');
        error = true;
    }
    return error;
}
Persona.validarfechaf = function(valor) {
    var valor = valor.split("-");
    var f = new Date(valor[2] + '-' + valor[1] + '-' + valor[0]);
    if (fi != '') {
        var fi = $('#' + Persona.Id('fechai')).val().split('-');
        fi = new Date(fi[2] + '-' + fi[1] + '-' + fi[0]);

        if (fi > f) {

            $('#' + Persona.Id('fechaf')).val($('#' + Persona.Id('fechai')).val());
        }
    }

}
Persona.validarfechai = function(valor) {
    var fi = valor.split('-');
    fi = new Date(fi[2] + '-' + fi[1] + '-' + fi[0]); 
    fimin= fi ;
  fimin.setDate(fimin.getDate() + 1);
     $('#' + Persona.Id("fechaf")).datepicker("option", "minDate", fimin);
  console.log("valor "+valor);
  console.log("fi "+fi);
  console.log("fimin "+fimin);
    var ff = $('#' + Persona.Id('fechaf')).val();
    if (ff != '') {

        var f = new Date(ff[2] + '-' + ff[1] + '-' + ff[0]);
        ff = new Date(f);
        if (ff < fi) {

            $('#' + Persona.Id('fechai')).val($('#' + Persona.Id('fechaf')).val());

        }


    }
    $.ajax({
        type: 'post',
        url: 'rrhh/persona/Mostrarhorario',
        data: {
            idp: $('#' + Persona.Id('id')).val(),
            fecha: $('#' + Persona.Id('fechai')).val()
        },
        success: function(resp) {
            var vec = jQuery.parseJSON(resp);

            $('#' + Persona.Id('horastrabajador')).html(vec.horario);
            $('#' + Persona.Id('hi')).attr('data-horario', vec.hi);
            $('#' + Persona.Id('mi')).attr('data-horario', vec.mi);
            $('#' + Persona.Id('hs')).attr('data-horario', vec.hs);
            $('#' + Persona.Id('ms')).attr('data-horario', vec.ms);

            console.log(resp);
        },
        error: function(er) {
            $('#' + Persona.Id('horastrabajador')).html('');
            console.log(er);
        }
    });
}
Persona.Mostrar = function(elemento) {
    if ($('#' + Persona.Id('tipo')).prop('checked')) {
        $('#' + Persona.Id('conthoras')).show();
        $('#' + Persona.Id('ocularfecha')).hide();

        $('label[for="' + Persona.groupForm + '_fechai"]').html('Fecha');
        
        Persona.Fechasminimas(1);

    } else {
        
        $('#' + Persona.Id('conthoras')).hide();
        $('#' + Persona.Id('ocularfecha')).show();


        $('label[for="' + Persona.groupForm + '_fechai"]').html('Desde');
         Persona.Fechasminimas(2);
    }

 


}
Persona.listaHorario = function(idturno) {
    $('#' + Persona.Id('idhorario')).empty();
    $('#' + Persona.Id('contenedorHorario')).empty();

    $.ajax({
        'type': 'post',
        'url': 'rrhh/movimientopersonal/dameListaHorario',
        'data': { idturno: idturno, nombre: Persona.groupForm },
        success: function(resp) {
            console.log(resp);
            $('#' + Persona.Id('idhorario')).html(resp);

        },
        error: function() {
            alter('ocurrio un error al optener los datos del empleado...');
        }

    });

}
Persona.dameInformacionHorario = function(idhorario) {

    $('#' + Persona.Id('contenedorHorario')).empty();

    $.ajax({
        'type': 'post',
        'url': 'rrhh/movimientopersonal/dameHorario',
        'data': { idhorario: idhorario, nombre: Persona.groupForm },
        success: function(resp) {           
            $('#' + Persona.Id('contenedorHorario')).html(resp.horarios);

        },
        error: function(er) {
            alter('ocurrio un error al optener los datos del empleado...');
        }

    });
 
}

Persona.validarHoras = function() {
    var error = false;
    var canterror = 0;
    var hi = $('#' + Persona.Id('hi')).val();
    var mi = $('#' + Persona.Id('mi')).val()
    var hs = $('#' + Persona.Id('hs')).val();
    var ms = $('#' + Persona.Id('ms')).val();
    if (parseInt(hi) < 10) {
        hi = '0' + hi;

    }
    if (parseInt(mi) < 10) {
        mi = '0' + mi;

    }
    if (parseInt(hs) < 10) {
        hs = '0' + hs;

    }
    if (parseInt(ms) < 10) {
        ms = '0' + ms;

    }
    var horai = hi + ':' + mi;
    var horaip = $('#' + Persona.Id('hi')).attr('data-horario') + ':' + $('#' + Persona.Id('mi')).attr('data-horario');
    var horasp = $('#' + Persona.Id('hs')).attr('data-horario') + ':' + $('#' + Persona.Id('ms')).attr('data-horario');
    var horas = hs + ':' + ms;
    if (horai >= horaip && horai < horasp) {
        $('#' + Persona.Id('hi')).css('background-color', '#fff');
        $('#' + Persona.Id('mi')).css('background-color', '#fff');


    } else {
        console.log(horai + '....' + horaip + '....' + horasp);
        $('#' + Persona.Id('hi')).css('background-color', '#f68c8c');
        $('#' + Persona.Id('mi')).css('background-color', '#f68c8c');
        canterror += 1;
    }
    if (horas > horai && horas <= horasp) {
        $('#' + Persona.Id('hs')).css('background-color', '#fff');
        $('#' + Persona.Id('ms')).css('background-color', '#fff');


    } else {
        $('#' + Persona.Id('hs')).css('background-color', '#f68c8c');
        $('#' + Persona.Id('ms')).css('background-color', '#f68c8c');
        canterror += 1;
    }

    return canterror;

}
Persona.validarContratou = function() {

    var error = false;
    var cante = 0;
 
    console.log("montocategoria="+$('#' + Persona.Id('montocategoria')).val());
    if ( $('#' + Persona.Id('montocategoria')).val()=='' ) {
        $('#' + Persona.Id('montocategoria')).css('background-color', '#f68c8c');

        ++cante;
    } else {
        $('#' + Persona.Id('montocategoria')).css('background-color', '#fff');
    }
    if ( $('#' + Persona.Id('montotransporte')).val()=='' ) {
        $('#' + Persona.Id('montotransporte')).css('background-color', '#f68c8c');

        ++cante;
    } else {
        $('#' + Persona.Id('montotransporte')).css('background-color', '#fff');
    }

    if (cante > 0) {
        error = true;
    }

    return error;

}

Persona.validarFechaM = function(fecha) {
    if (!/^\d{1,2}\-\d{1,2}\-\d{4}$/.test(fecha))
        return false;
    return true;
}
Persona.validarFormularioM = function() {
        var canterror = 0;
        var error = false;

        if ($('#' + Persona.Id('idpuestotrabajo')).val() == '') {
            $('#' + Persona.Id('idpuestotrabajo')).css('background-color', '#f68c8c');
            canterror += 1;
        } else {
            $('#' + Persona.Id('idpuestotrabajo')).css('background-color', '#fff');

        }
        if ($('#' + Persona.Id('nivelsalarial')).val() == '') {
            $('#' + Persona.Id('nivelsalarial')).css('background-color', '#f68c8c');
            canterror += 1;
        } else {
            $('#' + Persona.Id('idnivelsalarial')).css('background-color', '#fff');

        }
        var fecha = $('#' + Persona.Id('fechaini')).val();
        var estado = !this.validarFechaM(fecha);
        if ($('#' + Persona.Id('fechaini')).val() == '') {
            $('#' + Persona.Id('fechaini')).css('background-color', '#f68c8c');
            canterror += 1;
        } else {
            $('#' + Persona.Id('fechaini')).css('background-color', '#fff');
        }



        if ($('#' + Persona.Id('idhorario')).val() == '') {
            $('#' + Persona.Id('idhorario')).css('background-color', '#f68c8c');
            canterror += 1;
        } else {
            $('#' + Persona.Id('idhorario')).css('background-color', '#fff');

        }
        if (canterror > 0) {
            Persona.showMessageError('Revise los datos!! ');
            error = true;
        }
        return error;
    }
    Persona.listaHorario = function(idturno) {
    $('#' + Movimientopersonal.Id('idhorario')).empty();
    $('#' + Movimientopersonal.Id('conthorario')).empty();

    $.ajax({
        'type': 'post',
        'url': 'rrhh/movimientopersonal/dameListaHorario',
        'data': { idturno: idturno, nombre: Persona.groupForm },
        success: function(resp) {

            $('#' + Persona.Id('idhorario')).html(resp);

        },
        error: function() {
            alter('ocurrio un error al optener los datos del empleado...');
        }

    });

}
Persona.descargarBoletaEmpleado = function() {
    if ($('#' + Persona.Id('idplanilla')).val() != '') {
        $('#' + Persona.Id('idplanilla')).css('background-color', '#ffffff');
        ///

        var urlCompleta = 'ImprimirBoletaEmpleado?ci=' + $('#' + Persona.Id('ci')).val() + '&idplanilla=' + $('#' + Persona.Id('idplanilla')).val();
        this.openUrl(urlCompleta);
        ///

    } else {
        $('#' + Persona.Id('idplanilla')).css('background-color', '#f68c8c');
        Persona.showMessageError('Revise los datos !! ');

    }
}
 Persona.CargarOpcion = function(opcion) {
        if (opcion == '1') {
            $('#' + Persona.Id('descripcionformapago')).hide();

        } else {
            $('#' + Persona.Id('descripcionformapago')).show();
        }
    }
    
Persona.printFiniquito = function () {
    if (Persona.generar!='<h3>Desea Continuar...?</h3><br><h5>El Retiro no generara Finiquito...</h5>')
    {
        var url = 'pagobeneficio/imprimirFiniquitoAlCrear?idempleado=' + this.idKey();
        this.openUrl(url);
    }
};


Persona.Fechasminimas=function(tipo){
  $.ajax({     
        'type':'post',
        'url':'rrhh/'+this.url+'/damefechasminimas',
        'data':{ ide:$('#'+Persona.Id('id')).val(), tipo:tipo},
        success:function (resp) {  
             var vec=jQuery.parseJSON(resp);
             fechaa= new Date( vec.fechaminima);  
                 $('#' + Persona.Id("fechai")).datepicker("option", "minDate", vec.fechaminima);
                  $('#' + Persona.Id("fechaf")).datepicker("option", "minDate",vec.fechaminima);     
               

       },
        error:function () {
            alert('ocurrio un error ');
        }

    });   
}
Persona.mostrarObservacion=function(){
     $.ajax({     
        'type':'post',
        'url':'rrhh/horario/observacionHorario',
        'data':{ idempleado:$('#'+Persona.Id('idempleado')).val(), fecha:$('#'+Persona.Id('fechaini')).val()},
        success:function (resp) {               
                 $('#' + Persona.Id("contenedorMensaje")).html(resp);          

       },
        error:function () {
            alert('ocurrio un error ');
        }

    });  
}
Persona.sumarPorcentaje=function(){
   
    var grilla=this.getSGridView('gridPorcentajespago');  
    var error=false;
    var total=0;
    Persona.gridSearchVars('gridPorcentajespago', SGridView.getAllData(this.getSGridView('gridPorcentajespago').idempresasubempleadora,'idempresasubempleadora'));
   
   for (var i = 1; i<=grilla.rows ; i++) {
    
   
      if (grilla.row(i).get('porcentaje')>0) {
       total+=grilla.row(i).get('porcentaje');
       grilla.row(i).attributes('porcentaje', { validate: true});
      }else{
        grilla.row(i).attributes('porcentaje',{validate:false});
      }

   
    }
    $('#'+Persona.Id('spanTotalPorcentaje')).html(total+' %.');
    if(total!=100 ){
        error=true;
        Persona.showMessageError('La suma de los porcentajes debe ser igual 100 !! ');
    }
    return error;
}
Persona.AnalizarselladaPermisos=function(){
    var idempleado=$('#'+Persona.Id('id')).val();
    if (idempleado!== undefined){
    if (!$('#' + Persona.Id('analizarsellada')).prop('checked')) {
          $.ajax({     
        'type':'post',
        'url':'rrhh/persona/analizarselladaPermiso',
        'data':{ idempleado:idempleado},
        success:function (resp) {  
           
                  if(resp!=''){
                  $('#' + Persona.Id('analizarsellada')).prop('checked',true);
                               
                  }
                   $('#' + Persona.Id("contenedorMensajeAnalizar")).html(resp);
                  

       },
        error:function () {
            alert('ocurrio un error ');
        }

    }); 
      }
  }
      
}
