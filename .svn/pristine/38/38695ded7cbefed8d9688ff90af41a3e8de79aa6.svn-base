var Pagobeneficio = new Object();
Pagobeneficio.__proto__ = SystemWindow;
//variables
Pagobeneficio.nameView = "Pagobeneficio";
Pagobeneficio.url = "pagobeneficio";
Pagobeneficio.fecha='';
Pagobeneficio.init = function() {
    var THIS = this;
    if (this.action == 'create' || this.action == 'Consolidarprimaanual' || this.action == 'update' || this.action == 'prima' || this.action == 'ConsolidarQuinquenio' || this.action == 'aguinaldonavidad' || this.action == 'segundoaguinaldo' || this.action == 'listaempleadoprimaanual' || this.action == 'ModificarParametrosFiniquito' || this.action == 'ConsolidarFiniquito'|| this.action == 'DescargarBajaCNS'||this.action=='PlanillaAguinaldo'||this.action=='ConsolidarAguinaldo'||this.action=='ActualizarAguinaldonavidad'||this.action=='ActualizarSegundoAguinaldo'||this.action=='PlanillaPrima') {
        this.buttonChange({ id: 'save', label: 'Guardar', key: 'G' });
    }
};

Pagobeneficio.options = function() {
    this.setActions('create', {
        WindowTitle: 'Registrar Pago Quinquenio',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {
        WindowTitle: 'Modificar Pago Quinquenio',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('ConsolidarQuinquenio', {
        WindowWidth: 300,
        WindowHeight: 250,
        WindowTitle: 'Consolidar Quinqunio',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('ConsolidarAguinaldo', {
        WindowWidth: 300,
        WindowHeight: 250,
        WindowTitle: 'Consolidar Aguinaldo',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('ActualizarAguinaldonavidad', {
        WindowWidth: 300,
        WindowHeight: 250,
        WindowTitle: 'Actualizar Fecha Pago Aguinaldo',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('ActualizarSegundoAguinaldo', {
        WindowWidth: 300,
        WindowHeight: 250,
        WindowTitle: 'Actualizar Aguinaldo',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('ConsolidarFiniquito', {
        WindowWidth: 300,
        WindowHeight: 250,
        WindowTitle: 'Consolidar Finiquito',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
 this.setActions('ModificarParametrosFiniquito', {
        WindowWidth: 550,
        WindowHeight: 550,
        WindowTitle: 'Modificar Parametros Finiquito',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('DescargarBajaCNS', {

        WindowWidth: 250,
        WindowHeight: 250,
        WindowTitle: 'Baja CNS',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('prima', {
        WindowWidth: 400,
        WindowHeight: 250,
        WindowTitle: 'Prima Anual',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('Consolidarprimaanual', {
        WindowWidth: 250,
        WindowHeight: 250,
        WindowTitle: 'Consolidar Prima Anual',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('listaempleadoprimaanual', {
        WindowWidth: 500,
        WindowHeight: 650,
        WindowTitle: 'Lista Empleados Prima Anual',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('aguinaldonavidad', {
        WindowWidth: 300,
        WindowHeight: 250,
        WindowTitle: 'Registrar Aguinaldo de Navidad',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('segundoaguinaldo', {
        WindowWidth: 300,
        WindowHeight: 250,
        WindowTitle: 'Registrar Segundo Aguinaldo ',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
  
     this.setActions('PlanillaAguinaldo', {
        WindowWidth: 500,
        WindowHeight: 350,
        WindowTitle: 'Planilla Aguinaldo',
        initButtons: 'planillas',
        endButtons: 'planillas',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('PlanillaPrima', {
        WindowWidth: 500,
        WindowHeight: 400,
        WindowTitle: 'Planilla Prima',
        initButtons: 'planillas',
        endButtons: 'planillas',
        layerEndOn: false,
        ableBackWindow: true
    });
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Pagobeneficio',
        WindowWidth: 300,
        WindowHeight: 350,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on' // on,off,onMain
    };
    return options;
}
Pagobeneficio.ConsolidarQuinquenio = function(options) {

    this.action = 'ConsolidarQuinquenio';
    this.open(this.getOptions(options));
}
Pagobeneficio.ConsolidarAguinaldo= function(options) {

    this.action = 'ConsolidarAguinaldo';
    this.open(this.getOptions(options));
}
Pagobeneficio.ActualizarAguinaldonavidad= function(options) {

    this.action = 'ActualizarAguinaldonavidad';
    this.open(this.getOptions(options));
}
Pagobeneficio.ActualizarSegundoAguinaldo= function(options) {

    this.action = 'ActualizarSegundoAguinaldo';
    this.open(this.getOptions(options));
}
Pagobeneficio.ConsolidarFiniquito = function(options) {
    this.action = 'ConsolidarFiniquito';
    this.open(this.getOptions(options));
}
Pagobeneficio.ModificarParametrosFiniquito = function(options) {
    this.action = 'ModificarParametrosFiniquito';
    this.open(this.getOptions(options));
}
Pagobeneficio.DescargarBajaCNS = function(options) {
    this.action = 'DescargarBajaCNS';
    this.open(this.getOptions(options));
}
Pagobeneficio.Consolidarprimaanual = function(options) {
    this.action = 'Consolidarprimaanual';
    this.open(this.getOptions(options));
}
Pagobeneficio.prima = function(options) {
    this.action = 'prima';
    this.open(this.getOptions(options));
}
Pagobeneficio.listaempleadoprimaanual = function(options) {
    this.action = 'listaempleadoprimaanual';
    this.open(this.getOptions(options));
}
Pagobeneficio.aguinaldonavidad = function(options) {

    this.action = 'aguinaldonavidad';
    this.open(this.getOptions(options));
}
Pagobeneficio.PlanillaPrima = function(options) {
    this.action = 'PlanillaPrima';
    this.open(this.getOptions(options));
}
Pagobeneficio.PlanillaAguinaldo = function(options) {

    this.action = 'PlanillaAguinaldo';
    this.open(this.getOptions(options));
}
Pagobeneficio.segundoaguinaldo = function(options) {

    this.action = 'segundoaguinaldo';
    this.open(this.getOptions(options));
}
Pagobeneficio.beforeCreate = function() {
    var error = false; //false es no existe error antes de actulizar formulario
    var valor = parseInt($('#Pagobeneficio_numpago').val());
    var cante = 0;
    var max = parseInt($('#Pagobeneficio_numpago[max]').attr('max'));
    var numq = parseInt($('#Pagobeneficio_numeroquinquenios').val());
    if (max > 0) {

        if ($('#' + Pagobeneficio.Id('fechasolicitud')).val() == '') {
            $('#' + Pagobeneficio.Id('fechasolicitud')).css('background-color', '#f68c8c');
            cante = cante + 1;
        } else {
            $('#' + Pagobeneficio.Id('fechasolicitud')).css('background-color', '#ffffff');
        }

        if (valor <= 0 || max < valor || $('#Pagobeneficio_numpago[max]').val() == '') {
            cante = cante + 1;

            $('#Pagobeneficio_numpago[max]').css('background-color', '#f68c8c');

        } else {
            $('#Pagobeneficio_numpago[max]').css('background-color', '#ffffff');

        }
        if (cante > 0) {
            error = true;
            Pagobeneficio.showMessageError('Revise los datos !! ');
        } else {



            $('#' + Pagobeneficio.Id('numpago')).val($('#Pagobeneficio_numpago[max]').val());


        }
    } else {
        error = true;
        Pagobeneficio.showMessageError('Debe tener al menos un Quinquenio Habilitado... !! ');
    }

    return error;
}
Pagobeneficio.afterCreate = function() {
    Pagobeneficio.reload();
}

Pagobeneficio.beforeUpdate = function() {
    var error = false; //false es no existe error antes de actulizar formulario
    var cante = 0;
    if ($('#' + Pagobeneficio.Id('fechasolicitud')).val() == '') {
        $('#' + Pagobeneficio.Id('fechasolicitud')).css('background-color', '#f68c8c');
        cante = cante + 1;
    } else {
        $('#' + Pagobeneficio.Id('fechasolicitud')).css('background-color', '#ffffff');
    }

    if (cante > 0) {
        error = true;
        Pagobeneficio.showMessageError('Revise los datos !! ');
    }


    return error;
}
Pagobeneficio.afterUpdate = function() {
    Pagobeneficio.closeWindow();
}
Pagobeneficio.beforeConsolidarAguinaldo= function() {
    var error = false; //false es no existe error antes de actulizar formulario
    var cante = 0;
    if ($('#' + Pagobeneficio.Id('fechasolicitud')).val() == '') {
        $('#' + Pagobeneficio.Id('fechasolicitud')).css('background-color', '#f68c8c');
        cante = cante + 1;
    } else {
        $('#' + Pagobeneficio.Id('fechasolicitud')).css('background-color', '#ffffff');
    }

    if (cante > 0) {
        error = true;
        Pagobeneficio.showMessageError('Revise los datos !! ');
    }


    return error;
}
Pagobeneficio.afterConsolidarAguinaldo = function() {
    Pagobeneficio.closeWindow();
}
Pagobeneficio.beforeActualizarAguinaldonavidad= function() {
    var error = false; //false es no existe error antes de actulizar formulario
    var cante = 0;
    if ($('#' + Pagobeneficio.Id('fechapago')).val() == '') {
        $('#' + Pagobeneficio.Id('fechapago')).css('background-color', '#f68c8c');
        cante = cante + 1;
    } else {
        $('#' + Pagobeneficio.Id('fechapago')).css('background-color', '#ffffff');
    }

    if (cante > 0) {
        error = true;
        Pagobeneficio.showMessageError('Revise los datos !! ');
    }


    return error;
}
Pagobeneficio.afterActualizarAguinaldonavidad = function() {
    Pagobeneficio.closeWindow();
}
Pagobeneficio.beforeActualizarSegundoAguinaldo= function() {
    var error = false; //false es no existe error antes de actulizar formulario
    var cante = 0;
    if ($('#' + Pagobeneficio.Id('fechapago')).val() == '') {
        $('#' + Pagobeneficio.Id('fechapago')).css('background-color', '#f68c8c');
        cante = cante + 1;
    } else {
        $('#' + Pagobeneficio.Id('fechapago')).css('background-color', '#ffffff');
    }
    if ($('#' + Pagobeneficio.Id('porcentaje')).val() == ''|| parseFloat($('#' + Pagobeneficio.Id('porcentaje')).val())<0) {
        $('#' + Pagobeneficio.Id('porcentaje')).css('background-color', '#f68c8c');
        cante = cante + 1;
    } else {
        $('#' + Pagobeneficio.Id('porcentaje')).css('background-color', '#ffffff');
    }

    if (cante > 0) {
        error = true;
        Pagobeneficio.showMessageError('Revise los datos !! ');
    }


    return error;
}
Pagobeneficio.afterActualizarSegundoAguinaldo = function() {
    Pagobeneficio.closeWindow();
}
Pagobeneficio.beforeConsolidarQuinquenio = function() {
    var error = false; //false es no existe error antes de crear formulario
    var cante = 0;
    console.log($('#' + Pagobeneficio.Id('fechapago')).val());
    if ($('#' + Pagobeneficio.Id('fechapago')).val() == '') {
        $('#' + Pagobeneficio.Id('fechapago')).css('background-color', '#f68c8c');
        cante = cante + 1;
    } else {
        $('#' + Pagobeneficio.Id('fechapago')).css('background-color', '#ffffff');
    }

    if (cante > 0) {
        error = true;
        Pagobeneficio.showMessageError('Revise los datos !! ');
    }
    return error;
}
Pagobeneficio.afterConsolidarFiniquito = function() {
    Pagobeneficio.closeWindow();
}
Pagobeneficio.beforeConsolidarFiniquito = function() {
    var error = false; //false es no existe error antes de crear formulario
    var cante = 0;
    console.log($('#' + Pagobeneficio.Id('fechapago')).val());
    if ($('#' + Pagobeneficio.Id('fechapago')).val() == '') {
        $('#' + Pagobeneficio.Id('fechapago')).css('background-color', '#f68c8c');
        cante = cante + 1;
    } else {
        $('#' + Pagobeneficio.Id('fechapago')).css('background-color', '#ffffff');
    }

    if (cante > 0) {
        error = true;
        Pagobeneficio.showMessageError('Revise los datos !! ');
    }
    return error;
}
Pagobeneficio.afterConsolidarQuinquenio = function() {
    Pagobeneficio.closeWindow();
}
Pagobeneficio.beforeModificarParametrosFiniquito = function() {
    var error = false;
    return error;
}
Pagobeneficio.afterModificarParametrosFiniquito = function() {
    Pagobeneficio.closeWindow();
}
Pagobeneficio.beforeDescargarBajaCNS= function() {
    var error = false;
    if($('#'+Pagobeneficio.Id('fechapago')).val()==''){
        $('#' + Pagobeneficio.Id('fechapago')).css('background-color', '#f68c8c');
         error = true;
          Pagobeneficio.showMessageError('Revise los datos !! ');
    }
    else
    {
        $('#' + Pagobeneficio.Id('fechapago')).css('background-color', '#ffffff');
        Pagobeneficio.fecha=$('#'+Pagobeneficio.Id('fechapago')).val();
    }
    return error;
}
Pagobeneficio.afterDescargarBajaCNS= function() {
    this.printBajaCNS();
    
    Pagobeneficio.closeWindow();
}
Pagobeneficio.printBajaCNS = function () {
    var url = 'pagobeneficio/imprimirBajaCNS?info=' + this.idKey()+' '+Pagobeneficio.fecha;
    this.openUrl(url);
};
Pagobeneficio.beforePrima = function() {
    var error;
    if (parseInt($('#' + Pagobeneficio.Id('estado')).val()) == 1) {

        error = false;
    } else {
        error = this.ValidarFormPrima(); //false es no existe error antes de crear formulario

    }
    return error;

}
Pagobeneficio.afterPrima = function() {
    Pagobeneficio.closeWindow();
}
Pagobeneficio.beforeConsolidarprimaanual = function() {
    var error = false; //false es no existe error antes de crear formulario
    $('#' + Pagobeneficio.Id('contenedorMensaje')).html('Sea Paciente la consolidacion puede demorar...');

    return error;
}
Pagobeneficio.afterConsolidarprimaanual = function() {
    Pagobeneficio.closeWindow();
}
Pagobeneficio.beforeListaempleadoprimaanual = function() {
    var error = false; //false es no existe error antes de crear formulario
    return error;
}
Pagobeneficio.afterListaempleadoprimaanual = function() {
    Pagobeneficio.closeWindow();
}
Pagobeneficio.beforeAguinaldonavidad = function() {
    var error = false; //false es no existe error antes de crear formulario
    if ($('#' + Pagobeneficio.Id('fechapago')).val() != '') {
        $('#' + Pagobeneficio.Id('fechapago')).css('background-color', '#ffffff');
    } else {
        $('#' + Pagobeneficio.Id('fechapago')).css('background-color', '#f68c8c');
        Pagobeneficio.showMessageError('Revise los datos !! ');
        error = true;

    }
    return error;
}
Pagobeneficio.afterAguinaldonavidad = function() {
    Pagobeneficio.closeWindow();
}
Pagobeneficio.beforeSegundoaguinaldo = function() {
    var error = false; //false es no existe error antes de crear formulario
    
    if ($('#' + Pagobeneficio.Id('fechapago')).val() != '') {
        $('#' + Pagobeneficio.Id('fechapago')).css('background-color', '#ffffff');
    } else {
        $('#' + Pagobeneficio.Id('fechapago')).css('background-color', '#f68c8c');
        error = true;
    }
    if ($('#' + Pagobeneficio.Id('porcentaje')).val() != '' && (parseFloat($('#' + Pagobeneficio.Id('porcentaje')).val())>=0 &&parseFloat($('#' + Pagobeneficio.Id('porcentaje')).val())<=100)) 
    
    {
        $('#' + Pagobeneficio.Id('porcentaje')).css('background-color', '#ffffff');
    } else {
        $('#' + Pagobeneficio.Id('porcentaje')).css('background-color', '#f68c8c');
        error = true;
    }
    if (error==true)
     Pagobeneficio.showMessageError('Revise los datos !! ');
    

    return error;
}
Pagobeneficio.afterSegundoaguinaldo = function() {
    Pagobeneficio.closeWindow();
}
Pagobeneficio.validarNumeroQuinquenio = function(pelemento) {
    var elemento = $(pelemento);

    if (parseInt(elemento.attr('max')) >= parseInt(elemento.val()) || parseInt(elemento.val()) > 0) {
        elemento.css('background-color', '#ffffff');
    } else {
        elemento.css('background-color', '#f68c8c');

    }
}
Pagobeneficio.beforePlanillaAguinaldo = function() {
    var error = false; //false es no existe error antes de crear formulario
    return error;
}
Pagobeneficio.afterPlanillaAguinaldo = function() {
    Pagobeneficio.closeWindow();
}

Pagobeneficio.descargarBoletaQuinquenio = function() {
    if ($('#' + Pagobeneficio.Id('numeroquinquenios')).val() != '') {
        $('#' + Pagobeneficio.Id('numeroquinquenios')).css('background-color', '#ffffff');
        var datos = this.prepareSend($('#' + this.groupForm).serialize()) + this.gestionSchemaMain();
        this.downloadFile(this.urlIni + this.url + '/DescargarExcelBoletaQuinquenio?' + datos);


    } else {
        $('#' + Pagobeneficio.Id('numeroquinquenios')).css('background-color', '#f68c8c');
        Pagobeneficio.showMessageError('Revise los datos !! ');

    }
}

Pagobeneficio.MostrarGestion = function() {
    var fechad = $('#' + Pagobeneficio.Id('fechadesde')).val();
    var fechah = $('#' + Pagobeneficio.Id('fechahasta')).val();
    if (fechad != '' && fechah != '') {
        fechad = fechad.split('-');
        fechah = fechah.split('-');
        var aniod = fechad[2];
        var anioh = fechah[2];
        if (aniod == anioh) {
            $('#' + Pagobeneficio.Id('gestion')).val(anioh)
        } else {
            $('#' + Pagobeneficio.Id('gestion')).val(aniod + '/' + anioh);
        }

    }
}
Pagobeneficio.Decimales = function(valor) {

    $('#' + Pagobeneficio.Id('monto')).val(parseFloat(valor).toFixed(4));

}
Pagobeneficio.ValidarFormPrima = function() {
    var error = false;
    var cant = 0;
    if ($('#' + Pagobeneficio.Id('fechadesde')).val() == '') {
        $('#' + Pagobeneficio.Id('fechadesde')).css('background-color', '#f68c8c');
        ++cant;
    } else {
        $('#' + Pagobeneficio.Id('fechadesde')).css('background-color', '#ffffff');
    }
    if ($('#' + Pagobeneficio.Id('fechahasta')).val() == '') {
        $('#' + Pagobeneficio.Id('fechahasta')).css('background-color', '#f68c8c');
        ++cant;
    } else {
        $('#' + Pagobeneficio.Id('fechahasta')).css('background-color', '#ffffff');
    }
    if ($('#' + Pagobeneficio.Id('monto')).val() != '') {
        if (parseFloat($('#' + Pagobeneficio.Id('monto')).val()) > 0) {
            $('#' + Pagobeneficio.Id('monto')).css('background-color', '#ffffff');
        } else {
            $('#' + Pagobeneficio.Id('monto')).css('background-color', '#f68c8c');
            ++cant;

        }

    } else {
        $('#' + Pagobeneficio.Id('monto')).css('background-color', '#f68c8c');
        ++cant;
    }
    if (cant > 0) {
        Pagobeneficio.showMessageError("Revise los datos !!");
        error = true;
    } else {
        $('#' + Pagobeneficio.Id('gestion')).attr('disabled', false);
    }
    return error;
}
Pagobeneficio.CargarOpcion = function(opcion) {
        if (opcion == '1') {
            $('#' + Pagobeneficio.Id('infoadicionalformapago')).hide();

        } else {
            $('#' + Pagobeneficio.Id('infoadicionalformapago')).show();

        }

    }
    Pagobeneficio.descargarExcelPlanilla = function() {
    var cant=0;
        if ($('#s2id_' + Pagobeneficio.groupForm + '_tipocontratos>ul>li[class="select2-search-choice"]').length > 0  && $('#' + Pagobeneficio.Id('opciones')).val()>0) {
      
     
        var datos = this.prepareSend($('#' + this.groupForm).serialize()) + this.gestionSchemaMain();
        this.downloadFile(this.urlIni + this.url + '/DescargarExcelPlanilla?' + datos);
    
    } else {
         if ($('#' + Pagobeneficio.Id('opciones')).val()==0) {
        $('#' + Pagobeneficio.Id('opciones')).css('background-color', '#f68c8c');
        ++cant;
    } else {
        $('#' + Pagobeneficio.Id('opciones')).css('background-color', '#ffffff');
    }
   if ($('#s2id_' + Pagobeneficio.groupForm + '_tipocontratos>ul>li[class="select2-search-choice"]').length ==0)   {
    ++cant;
            }
         if (cant==1){ 
                Pagobeneficio.showMessageError('Revise los datos !! ');
            }else{
        $('#' + Pagobeneficio.Id('contenedorMensaje')).html('<div class="alert alert-info">Debe seleccionar un TipoContrato y una Opcion de Reporte </div>');

    }
    }
}
Pagobeneficio.beforePlanillaPrima = function() {
    var error=false;
    
    return error;

}
Pagobeneficio.afterPlanillaPrima = function() {
    Pagobeneficio.closeWindow();
}
Pagobeneficio.descargarExcelPlanillaPrima = function() {
    var cant=0;
        if ($('#s2id_' + Pagobeneficio.groupForm + '_tipocontratos>ul>li[class="select2-search-choice"]').length > 0 && $('#' + Pagobeneficio.Id('opciones')).val()>0) {
      
     
        var datos = this.prepareSend($('#' + this.groupForm).serialize()) + this.gestionSchemaMain();
        this.downloadFile(this.urlIni + this.url + '/DescargarExcelPlanillaPrima?' + datos);
    
    } else {
         if ($('#' + Pagobeneficio.Id('opciones')).val()==0) {
        $('#' + Pagobeneficio.Id('opciones')).css('background-color', '#f68c8c');
        ++cant;
    } else {
        $('#' + Pagobeneficio.Id('opciones')).css('background-color', '#ffffff');
    }
   if ($('#s2id_' + Pagobeneficio.groupForm + '_tipocontratos>ul>li[class="select2-search-choice"]').length ==0)   {
    ++cant;
            }
         if (cant==1){ 
                Pagobeneficio.showMessageError('Revise los datos !! ');
            }else{
        $('#' + Pagobeneficio.Id('contenedorMensaje')).html('<div class="alert alert-info">Debe seleccionar un TipoContrato y una Opcion de Reporte </div>');

    }
    }
}