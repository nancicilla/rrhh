var Tipobeneficio = new Object();
Tipobeneficio.__proto__ = SystemWindow;
//variables
Tipobeneficio.nameView = "Tipobeneficio";
Tipobeneficio.url = "tipobeneficio";

Tipobeneficio.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Tipo Beneficio',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Tipo Beneficio',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Tipo Beneficio',
        WindowWidth: 400,
        WindowHeight: 430,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Tipobeneficio.beforeCreate = function () {
    //console.log('antes de mostar debemos validar');
    //grilla=$('#'+Tipobeneficio.Id('gridBeneficio'));
   
   var   error = this.validarGrilla();//false es no existe error antes de crear formulario
   //console.log(this.action);
     
   
   
    return error;
}

Tipobeneficio.validarGrilla=function() {
    var grilla=this.getSGridView('gridBeneficio');
 
     var totale=0;
     var error=false;
     //console.log('n Numbermero--->'+grilla.rows);

 for (var f = 1; f <= grilla.rows; f++) {
   
    if ( grilla.row(f).get('rangof')!='' && parseInt(grilla.row(f).get('rangof'))>=parseInt(grilla.row(f).get('rangoi'))){
            grilla.row(f).attributes('rangof', {tooltip: '', validate: true});
        
            grilla.row(f).attributes('rangoi', {tooltip: '', validate: true});

    }
    else{
         if (parseInt(grilla.row(f).get('rangoi'))>-1) {
                error=true;
                grilla.row(f).attributes('rangoi', {tooltip: 'Cantidad No váĺida! ', validate: false});
                ++totale;
         }
         else
         {
            
                grilla.row(f).attributes('rangoi', {tooltip: '', validate: true});
         }
     if (grilla.row(f).get('rangof')=='') {
         error=true;
      grilla.row(f).attributes('rangof', {tooltip: 'Cantidad No váĺida! ', validate: false});
    ++totale;
     }else{
         grilla.row(f).attributes('rangof', {tooltip: '', validate: true});
        // console.log('rangof----es un Number--->'+grilla.row(f).get('rangof'));
     }
         
     }
    if (grilla.row(f).get('porcentaje')=='') {
            error=true;
            grilla.row(f).attributes('porcentaje', {tooltip: 'Cantidad No váĺida! ', validate: false});
            ++totale;
     }else{
         grilla.row(f).attributes('porcentaje', {tooltip: '', validate: true});
        
     }
 }
    if(totale > 0)
    {
        Tipobeneficio.showMessageError('Por favor verifique sus datos ! ');
   
    }

        
     
 

 return error;
}

Tipobeneficio.afterCreate = function () {
    Tipobeneficio.reload();
}

Tipobeneficio.beforeUpdate = function () {
   var error = this.validarGrilla();
    return error;
}
Tipobeneficio.afterUpdate = function () {
    Tipobeneficio.closeWindow();
}
