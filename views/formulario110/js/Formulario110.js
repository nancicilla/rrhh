var Formulario110 = new Object();
Formulario110.__proto__ = SystemWindow;
//variables
Formulario110.nameView = "Formulario110";
Formulario110.url = "formulario110";
Formulario110.init = function () {
     var THIS=this;
    if (this.action == 'create'||  this.action == 'update') {
      this.buttonChange({id: 'save', label: 'Guardar', key: 'G'});
           
       if(this.action == 'create' )
        {
            Formulario110.subirArchivoExcel();
           
        }
    }
   

     
};

Formulario110.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Formulario110',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Formulario110',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true,
        WindowWidth: 350,
        WindowHeight: 250,
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Formulario110',
        WindowWidth: 450,
        WindowHeight: 555,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Formulario110.beforeCreate = function () {
    var error = this.validar();//false es no existe error antes de crear formulario
    return error;
}
Formulario110.afterCreate = function () {
    Formulario110.reload();
}

Formulario110.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    var cant=0;

    if ($('#'+Formulario110.Id('fechapresentacion')).val()=='')
    {
         $('#'+Formulario110.Id('fechapresentacion')).css('background-color','#f68c8c');
        cant=1;
    }else{
        $('#'+Formulario110.Id('fechapresentacion')).css('background-color','#ffffff');
    }
   
    if ( parseFloat( $('#'+Formulario110.Id('montopresentado')).val())<=0 || $('#'+Formulario110.Id('montopresentado')).val()=='')
    {
         $('#'+Formulario110.Id('montopresentado')).css('background-color','#f68c8c');
        cant=1;
    }else{
        $('#'+Formulario110.Id('montopresentado')).css('background-color','#ffffff');
    }
    if (cant>0){
        Formulario110.showMessageError("Revise sus datos !!");
        error=true;
    }
    return error;
}
Formulario110.afterUpdate = function () {
    Formulario110.closeWindow();
}
Formulario110.validar=function () {
    var error=false;
    var cant=0;

   var grilla=this.getSGridView('gridEmpleado'); 
    if ($('#'+Formulario110.Id('fechapresentacion')).val()=='')
    {
         $('#'+Formulario110.Id('fechapresentacion')).css('background-color','#f68c8c');
        cant=1;
    }else{
        $('#'+Formulario110.Id('fechapresentacion')).css('background-color','#ffffff');
    }

   for (var i = 1; i<=grilla.rows ; i++) {
  
      if (grilla.row(i).get('empleado')=='') {
      ++cant;
      grilla.row(i).attributes('empleado', { validate: false});
      }else{
          grilla.row(i).attributes('empleado', { validate: true});
      }
     
       if (grilla.row(i).get('estado')=='2') {
            ++cant;
       }
   
   
      if (grilla.row(i).get('monto')<=0) {
        ++cant;
       grilla.row(i).attributes('monto', { validate: false});


      }else{
        grilla.row(i).attributes('monto',{validate:true});
      }

 
    }
   if (cant>0) {
    error=true;
     Formulario110.showMessageError('Verifique sus datos!! '); 
   }

    
   return error;
}

Formulario110.sumarTotal=function(){
   
    var grilla=this.getSGridView('gridEmpleado');  
    this.gridSearchVars('gridEmpleado', '&idbono=' + $('#'+Bono.Id('id')).val()); 
   
    var total=0;
   for (var i = 1; i<=grilla.rows ; i++) {
    
   
      if (grilla.row(i).get('monto')>0) {
       total+=grilla.row(i).get('monto');
       grilla.row(i).attributes('monto', { validate: true});

      }else{
        grilla.row(i).attributes('monto',{validate:false});
      }
        if (grilla.row(i).get('estado')=='-1') {
                       
            grilla.row(i).attributes('empleado', {tooltip: '', validate: true});
            grilla.row(i).attributes('ci', {tooltip: '', validate: true});
            grilla.row(i).attributes('monto', {tooltip: '', validate: true});

            }else{
             grilla.row(i).attributes('empleado', {tooltip: '', validate: false});
            grilla.row(i).attributes('ci', {tooltip: '', validate:false});
            grilla.row(i).attributes('monto', {tooltip: '', validate: false});

            }
   
    }
    $('#'+Formulario110.Id('spanTotalBono')).html( parseFloat( total).toFixed( 2 )+' Bs.');
}
Formulario110.subirArchivoExcel = function() {
    var element=this.ById('fileExcel');
    element.parentElement.style.padding=null;
    var archivosExcel=element.innerHTML;
    
    element.innerHTML='<div class="pedidoArchivosExcel" ></div>'+
                      '<div class="">'+archivosExcel+'</div>';
    
    
    element.style.width="200px";
    element.style.height="20px";
    element.style.top="416px";
    
    $('#'+element.id).on('mousemove', function() {
        $(this).css('height', '46px');
    });
    
    $('#'+element.id).on('mouseout', function() {
        $(this).css('height', '20px');
    });
    
    var url=this.urlIni+this.url+'/subirArchivoExcel?groupForm='+this.groupForm;
    
    var THIS=this;
    var options = {iframe: {url: url}};
    // Attach FileDrop to an area ('zone' is an ID but you can also give a DOM node):
    var zone = new FileDrop(element.id, options);
    
    // Do something when a user chooses or drops a file:
    zone.event('send', function (files) {
        // Depending on browser support files (FileList) might contain multiple items.
        files.each(function (file) {
          // React on successful AJAX upload:
            file.event('done', function (xhr) {
                var errorFormato=$('<div>'+xhr.responseText+'</div>').find("div.errorFormato")[0];
                
                THIS.set('archivoexcel',this.name); 
                $('#'+THIS.Id('fileExcel')).find('.pedidoArchivosExcel')[0].innerHTML=this.name;
                THIS.ById('contenedorListaempleados').innerHTML=xhr.responseText;
               THIS.sumarTotal();
               THIS.HabilitarEliminar();
                if(errorFormato.innerHTML!=''){
                    var message='<div style="background:#1d6fb8;color:#ffffff; margin-top:10px;" >REVISAR FORMATO DE EXCEL</div><br>'+errorFormato.innerHTML;
                    bootbox.alert(message);
                }
            });
            
            file.sendTo(url);

        });
    });
    
    zone.event('iframeDone', function (xhr) {
      alert('Done uploading via <iframe>, response:\n\n' + xhr.responseText);
    });

}

Formulario110.HabilitarEliminar=function(){
    var grilla=this.getSGridView('gridEmpleado');  
     SGridView.inClick=true;
     SGridView.addRow(Formulario110.groupForm+'gridEmpleado');
     SGridView.selectRow(grilla.row(grilla.rows));
     SGridView.delRow();
}