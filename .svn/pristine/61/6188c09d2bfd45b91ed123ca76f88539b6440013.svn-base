var Otrosgastos = new Object();
Otrosgastos.__proto__ = SystemWindow;
//variables
Otrosgastos.nameView = "Otrosgastos";
Otrosgastos.url = "otrosgastos";
Otrosgastos.init = function () {
     var THIS=this;
    if (this.action == 'create' || this.action == 'update') {
      // alert(this.action);
    this.buttonChange({id: 'save', label: 'Guardar', key: 'G'});
           
  
   
        if(this.action == 'create' )
        {
            Otrosgastos.subirArchivoExcel();
            
          
        }

     
}}

Otrosgastos.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Otros Gastos',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Otros Gastos',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true,
         WindowWidth: 250,
        WindowHeight: 365
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Otrosgastos',
        WindowWidth: 650,
        WindowHeight: 565,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Otrosgastos.beforeCreate = function () {
    var error = this.validarFormulario();//false es no existe error antes de crear formulario
    return error;
}
Otrosgastos.afterCreate = function () {
    Otrosgastos.reload();
}

Otrosgastos.beforeUpdate = function () {
    var error = this.validarFormularioUpdate()  ;//false es no existe error antes de actulizar formulario
    return error;
}
Otrosgastos.afterUpdate = function () {
    Otrosgastos.closeWindow();
}
Otrosgastos.subirArchivoExcel = function() {
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
                THIS.ById('contenedorLista').innerHTML=xhr.responseText;
                THIS.sumarTotalDeduccion();
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
Otrosgastos.sumarTotalDeduccion=function () {
    //gridListaPulperia #9dcad6;
    var grilla = this.getSGridView('gridLista');
    var total=0;
    var cantidad=grilla.rows;
    if (cantidad==1){
        if(grilla.row(1).get('ci')==''){
            cantidad=0;
        }
    }
  
    
    for (var i =  1; i <=grilla.rows; i++) {
         if ((grilla.row(i).get('ci')+'').length>=6 && (grilla.row(i).get('ci')+'').length<=10) {
           total+=parseFloat(grilla.row(i).get('monto'));
         }
         if (grilla.row(i).get('estado')=='-1') {
                       
            grilla.row(i).attributes('nombrecompleto', {tooltip: '', validate: true});
            grilla.row(i).attributes('ci', {tooltip: '', validate: true});
            grilla.row(i).attributes('monto', {tooltip: '', validate: true});

            }else{
             grilla.row(i).attributes('nombrecompleto', {tooltip: '', validate: false});
            grilla.row(i).attributes('ci', {tooltip: '', validate:false});
            grilla.row(i).attributes('monto', {tooltip: '', validate: false});

            }
        
    }
    $('#' + this.Id('spanTotalSubClientes')).text( parseFloat( total).toFixed( 2 )+' Bs.');
}
Otrosgastos.HabilitarEliminar=function(){
   
    var grilla=this.getSGridView('gridLista');  
      SGridView.inClick=true;
     SGridView.addRow(Otrosgastos.groupForm+'gridLista');
     SGridView.selectRow(grilla.row(grilla.rows));
   
     SGridView.delRow();
}
Otrosgastos.validarFormulario=function() {
    var grilla=this.getSGridView('gridLista');
    var error=false;
    var cant=0;

    if ($('#'+Otrosgastos.Id('fecharegistro')).val()=='') {
    cant+=1;
    $('#'+Otrosgastos.Id('fecharegistro')).css('background-color','#f68c8c');
    }else{
    $('#'+Otrosgastos.Id('fecharegistro')).css('background-color','#fff');

    }
    if ($('#'+Otrosgastos.Id('nombre')).val()=='') {
    cant+=1;
    $('#'+Otrosgastos.Id('nombre')).css('background-color','#f68c8c');
    }else{
    $('#'+Otrosgastos.Id('nombre')).css('background-color','#fff');
    }




 for (var i = 1; i <= grilla.rows; i++) {   
        try{
            if ((grilla.row(i).get('ci')+'').length<6 || (grilla.row(i).get('ci')+'').length>10) {
            ++cant;
               grilla.row(i).attributes('ci', {tooltip: 'C.I. Incorrecta!!', validate: false});
            }else{
             grilla.row(i).attributes('ci', {tooltip: 'C.I. Incorrecta!!', validate: true});
            }
          
             if (grilla.row(i).get('monto')<=0||grilla.row(i).get('monto')=='') {
            
             grilla.row(i).set('monto',0);
            }
            if (grilla.row(i).get('estado')=='2') {
            
             ++cant;
            }
            }
            catch(ex){

        } 
        
     }
     if (cant>0) {
       
        error=true;
        Otrosgastos.showMessageError('Verifique sus datos!! '); 
      }
      return error;
 
}
Otrosgastos.validarFormularioUpdate=function (){
  var info=$('#'+Otrosgastos.Id('monto')).val();
  info=info.replace(",",".");
  var error=false;
  var  cant=1;
   if(!isNaN(info))
   {
     $('#'+Otrosgastos.Id('monto')).val(info);
      if (parseFloat(info)>0) {
        cant=0;
        $('#'+Otrosgastos.Id('monto')).css('background-color','#f68c8c');
      }

  }
   if ($('#'+Otrosgastos.Id('fecharegistro')).val()=='') {
    cant+=1;
    $('#'+Otrosgastos.Id('fecharegistro')).css('background-color','#f68c8c');
    }else{
    $('#'+Otrosgastos.Id('fecharegistro')).css('background-color','#fff');

    }
      if ($('#'+Otrosgastos.Id('nombre')).val()=='') {
    cant+=1;
    $('#'+Otrosgastos.Id('nombre')).css('background-color','#f68c8c');
    }else{
    $('#'+Otrosgastos.Id('nombre')).css('background-color','#fff');
    }
    if (cant>0){
        error=true;
        Otrosgastos.showMessageError('Verifique sus datos!! '); 
    }
     return error;
}


