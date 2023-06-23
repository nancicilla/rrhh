var Subsidio = new Object();
Subsidio.__proto__ = SystemWindow;
//variables
Subsidio.nameView = "Subsidio";
Subsidio.url = "subsidio";

Subsidio.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Subsidio',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {
        WindowTitle: 'Modificar Subsidio',
        initButtons: 'save,cancel',
        WindowWidth: 650,
        WindowHeight: 500,
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('RegistroNacidoVivo', {
        WindowWidth: 280,
        WindowHeight: 350,
        WindowTitle: 'Registro Nacido Vivo',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('NuevoHorarioLactancia', {
        WindowWidth: 650,
        WindowHeight: 500,
        WindowTitle: 'Nuevo Horario Lactancia',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Subsidio',
        WindowWidth: 350,
        WindowHeight: 500,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Subsidio.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    error = this.validarFormularioCreate();
    if (error) {
        Subsidio.showMessageError('Revise los datos !! ');
    }
    return error;
}
Subsidio.afterCreate = function () {
    Subsidio.reload();
}

Subsidio.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    error = this.validarFormularioUpdate();
    if (error) {
        Subsidio.showMessageError('Revise los datos !! ');
    }
    return error;
}
Subsidio.afterUpdate = function () {
    Subsidio.closeWindow();
}
Subsidio.dameBeneficiaria = function (idempleado) {
    //console.log(Subsidio);
    //cadena=$('#'+Subsidio.Id('fechar')).attr('id').split("_", 2); 
    $.ajax({
        type: 'post',
        url: 'rrhh/subsidio/Mostrarbenficiaria',
        data: {
            ide: idempleado,
            nombre: Subsidio.groupForm
        },
        success: function (resp) {
            var contenedor = $('#' + Subsidio.Id('contenedorBeneficiaria'));

            contenedor.show();
            $('#' + Subsidio.Id('iddependiente')).empty();
            $('#' + Subsidio.Id('iddependiente')).html(resp);

        },
        error: function (er) {
            $('#horastrabajador').html(er);
            console.log(er);
        }
    });

}

Subsidio.validarFormularioCreate = function () {
    var cantError = 0;
    var error = false;
    if ($('#' + Subsidio.Id('fechar')).val() == '') {
        $('#' + Subsidio.Id('fechar')).css('background-color', '#f68c8c');

        cantError += 1;
    }
    if ($('#' + Subsidio.Id('fechaiqmes')).val() == '') {
        $('#' + Subsidio.Id('fechaiqmes')).css('background-color', '#f68c8c');

        cantError += 1;
    }

    if (parseInt($('#' + Subsidio.Id('numbebe')).val()) < 1)
    {
        $('#' + Subsidio.Id('numbebe')).css('background-color', '#f68c8c');

        cantError += 1;
    }
    if (cantError > 0) {

        error = true;
    }
    return error;
}

Subsidio.dameInformacionHorario = function (idhorario) {
    $('#' + Subsidio.Id('contenedorHorario')).empty();
    $.ajax({
        'type': 'post',
        'url': 'rrhh/movimientopersonal/dameHorario',
        'data': {idhorario: idhorario, nombre: Subsidio.groupForm},
        success: function (resp) {

            $('#' + Subsidio.Id('contenedorHorario')).html(resp.horarios);
        },
        error: function () {
            alter('ocurrio un error al optener los datos del empleado...');
        }
    });
}

Subsidio.validarFormularioUpdate = function () {
    var cantError = 0;
    var error = false;
    if ($('#' + Subsidio.Id('fechar')).val() == '') {
        $('#' + Subsidio.Id('fechar')).css('background-color', '#f68c8c');
        cantError += 1;
    } else {
        $('#' + Subsidio.Id('fechar')).css('background-color', '#fff');
    }
    if ($('#' + Subsidio.Id('fechaiqmes')).val() == '') {
        $('#' + Subsidio.Id('fechaiqmes')).css('background-color', '#f68c8c');
        cantError += 1;
    } else {
        $('#' + Subsidio.Id('fechaiqmes')).css('background-color', '#fff');
    }
    if (parseInt($('#' + Subsidio.Id('numbebe')).val()) < 1)
    {
        $('#' + Subsidio.Id('numbebe')).css('background-color', '#f68c8c');
        cantError += 1;
    } else {
        $('#' + Subsidio.Id('numbebe')).css('background-color', '#fff');
    }
    if ($('#' + Subsidio.Id('fechadesde')).val() != '' || $('#' + Subsidio.Id('fechahasta')).val() != '') {
        if ($('#' + Subsidio.Id('fechadesde')).val() == '') {
            $('#' + Subsidio.Id('fechadesde')).css('background-color', '#f68c8c');
            cantError += 1;
        } else {
            $('#' + Subsidio.Id('fechadesde')).css('background-color', '#fff');
        }
        if ($('#' + Subsidio.Id('fechahasta')).val() == '') {
            $('#' + Subsidio.Id('fechahasta')).css('background-color', '#f68c8c');
            cantError += 1;
        } else {
            $('#' + Subsidio.Id('fechahasta')).css('background-color', '#fff');
        }
        var grilla = Subsidio.getSGridView('gridHorasTrabajo');
        for (var f = 1; f <= grilla.rows; f++) {
            if (grilla.row(f).get('dia') != '' || grilla.row(f).get('diad') != '') {
                if (grilla.row(f).get('dia') == '')
                {
                    ++cantError;
                    grilla.row(f).attributes('dia', {tooltip: '', validate: false});
                } else {
                    grilla.row(f).attributes('dia', {tooltip: '', validate: true});
                }
                if (grilla.row(f).get('diad') == '')
                {
                    ++cantError;
                    grilla.row(f).attributes('diad', {tooltip: '', validate: false});
                } else {
                    grilla.row(f).attributes('diad', {tooltip: '', validate: true});
                }
                if (this.validarHora(grilla.row(f).get('horai')) || grilla.row(f).get('horai') == '')
                {
                    ++cantError;
                    grilla.row(f).attributes('horai', {tooltip: '', validate: false});
                } else {
                    grilla.row(f).attributes('horai', {tooltip: '', validate: true});
                }
                if (this.validarHora(grilla.row(f).get('horas')) || grilla.row(f).get('horas') == '')
                {
                    ++cantError;
                    grilla.row(f).attributes('horas', {tooltip: '', validate: false});
                } else {
                    grilla.row(f).attributes('horas', {tooltip: '', validate: true});
                }
            }
        }
    }
    if (cantError > 0) {
        error = true;
    }
    return error;
}

Subsidio.validarHora = function (hora) {
    var expreg = /^([0-2][0-9][:][0-5][0-9])*$/;  // para las vacaciones
    if (expreg.test(hora))
        return false;
    else
        return true;
};
Subsidio.beforeRegistroNacidoVivo = function () {
    var error = false;
    return 'Éste es un proceso irreversible y generará un asiento contable, desea continuar?';
    return error;
}

Subsidio.RegistroNacidoVivo = function (options) {
    this.action = 'RegistroNacidoVivo';
    this.open(this.getOptions(options));

};

Subsidio.afterRegistroNacidoVivo = function () {
    Subsidio.closeWindow();
};
Subsidio.beforeNuevoHorarioLactancia = function () {
    var error = false;
      return error;
}

Subsidio.NuevoHorarioLactancia = function (options) {
    this.action = 'NuevoHorarioLactancia';
    this.open(this.getOptions(options));

};

Subsidio.afterNuevoHorarioLactancia = function () {
    Subsidio.closeWindow();
};
