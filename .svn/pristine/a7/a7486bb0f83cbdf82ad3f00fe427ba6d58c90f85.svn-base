var Tmpentradasalida = new Object();
Tmpentradasalida.__proto__ = SystemWindow;
//variables
Tmpentradasalida.nameView = "Tmpentradasalida";
Tmpentradasalida.url = "tmpentradasalida";
Tmpentradasalida.init = function () {
     var THIS=this;
    if (this.action == 'create' || this.action == 'update') {
      // alert(this.action);
    this.buttonChange({id: 'save', label: 'Guardar', key: 'G'});
           
  
   
        if(this.action == 'create' )
        {
            Tmpentradasalida.subirArchivoExcel();
            
            /*if(this.action == 'update') {
                var grid = this.getSGridView('gridSubCliente');
                $('#' + this.Id('spanTotalSubClientes')).text(grid.rows);
            }*/
        }

     
}}
Tmpentradasalida.options = function () {
    this.setActions('create', {
        WindowTitle: 'Crear Tmpentradasalida',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Tmpentradasalida',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Tmpentradasalida',
        WindowWidth: 400,
        WindowHeight: 505,
        WindowInitFunction: '',
        WindowCloseFunction: '',
        WindowMaxFunction: '',
        WindowMinFunction: '',
        WindowOnBackground: true,
        typeLoading: 'on'// on,off,onMain
    };
    return options;
}

Tmpentradasalida.beforeCreate = function () {
    var error = false;//false es no existe error antes de crear formulario
    return error;
}
Tmpentradasalida.afterCreate = function () {
    Tmpentradasalida.closeWindow();
}

Tmpentradasalida.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Tmpentradasalida.afterUpdate = function () {
    Tmpentradasalida.closeWindow();
}

Tmpentradasalida.subirArchivoExcel = function() {
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
                THIS.ById('contenedorListaImportacion').innerHTML=xhr.responseText;
              
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