var Configuracion = new Object();
Configuracion.__proto__ = SystemWindow;
//variables
Configuracion.nameView = "Configuracion";
Configuracion.url = "configuracion";
Configuracion.init = function () {
     var THIS=this;
      
    if (this.action == 'create'|| this.action == 'Contracuenta'|| this.action == 'update') {
      
    this.buttonChange({id: 'save', label: 'Guardar', key: 'G'});
           
      
       
}

     
};
Configuracion.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Configuración',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Configuración',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
      this.setActions('Contracuenta', {        
        WindowTitle: 'Modificar Contra Cuenta',
        initButtons: 'save,cancel',
        layerEndOn: false,
            WindowWidth: 250,
        WindowHeight: 250,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Configuración',
        WindowWidth: 300,
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

Configuracion.beforeCreate = function () {
    var error = this.validarValor();//false es no existe error antes de crear formulario
    return error;
}
Configuracion.afterCreate = function () {
    Configuracion.reload();
}

Configuracion.beforeUpdate = function () {
    var error = this.validarValor();//false es no existe error antes de crear formulario
    console.log(error);
    return error;
}
Configuracion.afterUpdate = function () {
    Configuracion.closeWindow();
}
Configuracion.beforeContracuenta = function () {
    var error = this.validarFormularioCuenta();//false es no existe error antes de crear formulario
     if (error) {
        Configuracion.showMessageError('Revise los datos !! ');
     }
    return error;
}
Configuracion.afterContracuenta = function () {
    Configuracion.closeWindow();}


Configuracion.Contracuenta = function() {
    console.log("entra a contracuenta...");
    this.action = 'Contracuenta';
    this.open(this.getOptions());
}


Configuracion.validarValor=function () {
    var expreg = /^([0-7][-][0-7][,][0-9][0-9]*[.]*[0-9]*[;])*$/;  
    var info=$('#'+Configuracion.Id('valor')).val();
    
    if(expreg.test(info)){
       $('#'+Configuracion.Id('valor')).css('background-color','#fff');
         return false;
     }
    else{ 
      info=info.replace(",",".");
    if(isNaN(info))
    {   //Verificar si es una fecha

       info=$('#'+Configuracion.Id('valor')).val();
       vec=info.split('-');
       fecha=new Date(vec[2]+'-'+vec[1]+'-'+vec[0]);
       if (fecha.getDate()) {
         $('#'+Configuracion.Id('valor')).css('background-color','#fff');
         return false;
       }else{
         $('#'+Configuracion.Id('valor')).css('background-color','#f68c8c');
         return true;
        
       } 

    
   
    }
    else{
        $('#'+Configuracion.Id('valor')).css('background-color','#fff');
        $('#'+Configuracion.Id('valor')).val(info);
        return false;
    }
        
    }
   


}
Configuracion.validarFormularioCuenta=function () {
    var cantError=0;
    var error=false;
    if ($('#'+Configuracion.Id('cuenta')).val()=='') {
        $('#'+Configuracion.Id('cuenta')).css('background-color','#f68c8c');
             
            ++ cantError; 
    }else{
            $('#'+Configuracion.Id('cuenta')).css('background-color','#fff');
         }
         if (cantError>0) {
         error=true;
         }
         return error;
}




