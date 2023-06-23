var Dependiente = new Object();
Dependiente.__proto__ = SystemWindow;
//variables
Dependiente.nameView = "Dependiente";
Dependiente.url = "dependiente";
Dependiente.init = function () {
     var THIS=this;
    if (this.action == 'create' || this.action == 'update') {
      // alert(this.action);
    this.buttonChange({id: 'save', label: 'Guardar', key: 'G'});
           
  
   
        if(this.action == 'create' )
        {
            Dependiente.subirArchivoExcel();
            
           
        }

     
}}

Dependiente.options = function () {
    this.setActions('create', {
        WindowTitle: 'Importar/Registrar Deduccion Empleado(Lote)',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });
    this.setActions('update', {        
        WindowTitle: 'Modificar Dependiente',
        initButtons: 'save,cancel',
        layerEndOn: false,
        ableBackWindow: true
    });

    var options = {
        WindowName: this.nameView,
        WindowTitle: 'Dependiente',
                WindowWidth: 550,
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

Dependiente.beforeCreate = function () {
    var error = this.validarFormulario();//false es no existe error antes de crear formulario
    if (error==true) {
        Dependiente.showMessageError('Revise los datos !! ');
    }
    return error;
}
Dependiente.afterCreate = function () {
     Dependiente.closeWindow();
}

Dependiente.beforeUpdate = function () {
    var error = false;//false es no existe error antes de actulizar formulario
    return error;
}
Dependiente.afterUpdate = function () {
    Dependiente.closeWindow();
}
Dependiente.subirArchivoExcel = function() {
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
                THIS.ById('contenedorListaDeducciones').innerHTML=xhr.responseText;
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
Dependiente.sumarTotalDeduccion=function () {
    //gridListaPulperia #9dcad6;
    var grilla = this.getSGridView('gridListaDeduccion');
    var total=0;  
    for (var i =  1; i <=grilla.rows; i++) {
         if ((grilla.row(i).get('ci')+'').length>=6 && (grilla.row(i).get('ci')+'').length<=10) {
           total+=parseFloat(grilla.row(i).get('monto'));
           
            if (grilla.row(i).get('estado')=='-1') {
                       
            grilla.row(i).attributes('nombrecompleto', {tooltip: '', validate: true});
            grilla.row(i).attributes('ci', {tooltip: '', validate: true});
            grilla.row(i).attributes('monto', {tooltip: '', validate: true});

            }else{
             grilla.row(i).attributes('nombrecompleto', {tooltip: '', validate: false});
            grilla.row(i).attributes('ci', {tooltip: '', validate:false});
            grilla.row(i).attributes('monto', {tooltip: '', validate: false});

            }
            //grilla.row(f).attributes('nombrecompleto', {tooltip: '', validate: false});
          
            
         }
         
        
    }
    $('#' + this.Id('spanTotalSubClientes')).text(  parseFloat( total).toFixed( 2 )+' Bs.');
}
Dependiente.HabilitarEliminar=function(){
   
     var grilla=this.getSGridView('gridListaDeduccion');  
     SGridView.inClick=true;
     SGridView.addRow(Dependiente.groupForm+'gridListaDeduccion');
     SGridView.selectRow(grilla.row(grilla.rows));
   
     SGridView.delRow();
}
Dependiente.validarFormulario=function() {
    var grilla=this.getSGridView('gridListaDeduccion');
    var error=false;
    var cant=0;
    var fi=$('#'+Dependiente.Id('fecha')).val().split("-");
    var ff=$('#'+Dependiente.Id('fechafin')).val().split("-");

 fi=fi[2]+'-'+fi[1]+'-'+fi[0];
  ff=ff[2]+'-'+ff[1]+'-'+ff[0];
if ($('#'+Dependiente.Id('deduccion')).val()=='') {
    cant+=1;
    $('#'+Dependiente.Id('deduccion')).css('background-color','#f68c8c');
}else{
    $('#'+Dependiente.Id('deduccion')).css('background-color','#fff');

}

if (fi!='' && ff!='') {
 fi=new Date(fi);
 ff=new Date(ff);
 
 console.log(fi.getTime()-ff.getTime());
 console.log(ff.getTime()-fi.getTime());
  if (fi<=ff) {
     $('#'+Dependiente.Id('fecha')).css('background-color','#fff');
      $('#'+Dependiente.Id('fechafin')).css('background-color','#fff');

  }else{
     $('#'+Dependiente.Id('fecha')).css('background-color','#f68c8c');
      $('#'+Dependiente.Id('fechafin')).css('background-color','#f68c8c');
       cant+=1;

  }
}else{
    if ($('#'+Dependiente.Id('fecha')).val()=='') {
    cant+=1;
    $('#'+Dependiente.Id('fecha')).css('background-color','#f68c8c');
}else{
    $('#'+Dependiente.Id('fecha')).css('background-color','#fff');

}
if ($('#'+Dependiente.Id('fechafin')).val()=='') {
    cant+=1;
    $('#'+Dependiente.Id('fechafin')).css('background-color','#f68c8c');
}else{
    $('#'+Dependiente.Id('fechafin')).css('background-color','#fff');

}
}
if ($('#'+Dependiente.Id('descripcion')).val()=='') {
    cant+=1;
    $('#'+Dependiente.Id('descripcion')).css('background-color','#f68c8c');
}else{
    $('#'+Dependiente.Id('descripcion')).css('background-color','#fff');

}


 for (var i = 1; i <= grilla.rows; i++) {   
        try{
            if ((grilla.row(i).get('ci')+'').length<6 || (grilla.row(i).get('ci')+'').length>10) {
            ++cant;
            console.log((grilla.row(i).get('ci')+'').length+'......'+grilla.row(i).get('ci')); 
             grilla.row(i).attributes('ci', {tooltip: 'C.I. Incorrecta!!', validate: false});
            }else{
             grilla.row(i).attributes('ci', {tooltip: 'C.I. Incorrecta!!', validate: true});
            }

             if (grilla.row(i).get('monto')<=0||grilla.row(i).get('monto')=='') {
            
             grilla.row(i).set('monto',0);
            }
            if(grilla.row(i).get('estado')=='2'){
                ++cant;
            }
            }
            catch(ex){

        } 
        console.log((grilla.row(i).get('ci')+'').length);   
     }
     if (cant>0) {
       
        error=true;
      }
      return error;
 
}