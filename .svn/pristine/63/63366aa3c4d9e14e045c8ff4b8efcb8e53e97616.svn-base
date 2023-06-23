var Unidad = new Object();
Unidad.__proto__ = SystemWindow;
//variables
Unidad.nameView = "Unidad";
Unidad.url = "unidad";
Unidad.vec=[];
Unidad.suma=0;
Unidad.sumac=0;
Unidad.init = function () {
     var THIS=this;
    if (this.action == 'create' || this.action == 'update') {
        $('#' + this.Id('cuenta')).keyup(function (e) {
            var k = (document.all) ? e.keyCode : e.which;
            if (k != 37 && k != 38 && k != 39 && k != 40 && k != 13 && k != 9) {
                Unidad.set('idcuenta', '');
                Unidad.ById('cuenta').style.background = "";
            }
        });
        $('#' + this.Id('cuenta')).blur(function () {
            if (Unidad.get('idcuenta') == '') {
                this.value = '';
                Unidad.ById('cuenta').style.background = "";
            }
        });
    }
};
Unidad.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Unidad',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Unidad',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Unidad',
        WindowWidth: 250,
        WindowHeight: 405,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Unidad.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Unidad.afterCreate = function () {
    Unidad.reload();
}

Unidad.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Unidad.afterUpdate = function () {
    Unidad.closeWindow();
}
Unidad.setInformacionCuenta = function (idcuenta, nombreCuenta) {
    console.log(idcuenta+nombreCuenta);
    /*$('#' + this.Id("idcuenta")).val(idcuenta);
    $('#' + this.Id("cuenta")).val(nombreCuenta);*/
};
/*
no haya ninguna proomocion
haya una promo
haya mas de una promo

*/
Unidad.calcular = function (mm) {
  var grilla = Unidad.getSGridView('gridCarrito');
  var s=0;  
 //console.log(mm);

 for (var f = 1; f <= grilla.rows; f++) {
  if (grilla.row(f).get('monto')!='')
   {
    ver=true;
    this.vec.forEach(function (el) {
       if (el==grilla.row(f).get('monto')) {
        ver=false;
       }
    })
    if(ver){
    this.vec.push(grilla.row(f).get('monto'));
   }
}
else{
   if ( grilla.row(f).get('pu')!='' && grilla.row(f).get('cant')!='' ) {
    s+=parseInt(grilla.row(f).get('pu'))*parseInt(grilla.row(f).get('cant'));
   } 

}

    
            
 }
 console.log(this.vec);
 console.log('numele'+this.vec.length);
}