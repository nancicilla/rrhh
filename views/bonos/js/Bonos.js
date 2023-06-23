var Bonos = new Object();
Bonos.__proto__ = SystemWindow;
//variables
Bonos.nameView = "Bonos";
Bonos.url = "bonos";

Bonos.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Bonos',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Bonos',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Bonos',
        WindowWidth: 550,
        WindowHeight: 630,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Bonos.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return this.validarFormulario();
}
Bonos.afterCreate = function () {
    Bonos.reload();
}

Bonos.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Bonos.afterUpdate = function () {
    Bonos.closeWindow();
}
Bonos.validarFormulario=function() {
    //////////////////////////////////////////
    var grilla=this.getSGridView('gridPuestoTrabajo'); 
     var cante=0;
     var  estado=$('#'+Bonos.Id('estado')).prop('checked');
     var error=false;
     console.log(estado);

 var cant=0;
if (grilla.rows==1) {
 if (grilla.row(1).get('idpuestotrabajo')=='' ) {
     error=true;
            grilla.row(1).attributes('puesto', {tooltip: '', validate: false});
            Bonos.showMessageError('Revise sus datos...!! '); 
 }
}else{
  
 for (var f = 1; f <= grilla.rows; f++) {
   if (estado) {
    console.log("antes de la validacion de la grilla");
     if (grilla.row(f).get('valor')=='') {
        grilla.row(f).attributes('valor', {tooltip: '', validate: true}); 
     }else{
               ++cante;
        grilla.row(f).attributes('valor', {tooltip: '', validate: false}); 
     }
   }
    if (grilla.row(f).get('idpuestotrabajo')=='' ) {
        ++cante;
            grilla.row(1).attributes('puesto', {tooltip: '', validate: false});
 }else{
    grilla.row(1).attributes('puesto', {tooltip: '', validate: true});
 }
  
     }
}

if (cante>0) {
    error=true;
     Bonos.showMessageError('Revise sus datos...!! '); 
}


     return error;
    //////////////////////////////////////////////
}