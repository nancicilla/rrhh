<?php
 $evento='Entradasalida.edicionminutos();';
 $eventohora='Entradasalida.edicionhora();';
 $eventoobservacion='Entradasalida.edicionobservacion();';
 $nombref='Entradasalida.Cargarvariables();';        
echo SGridView::widget('TGridView', array(
    'id' => $nombre.'gridLista',
    'dataProvider' => $lista,
    'buttonAdd' => false,
    'specialCellEditionMode' => false,
    'eventAfterEdition' => $nombref,
    'eventAfterEditionAutomatic' => true,
    'buttonText' => '+',
    'height' => 400,
    'columns' => array(
        array(
            'name' => 'identradasalida',
            'typeCol' => 'hidden'
        ),
        array(
            'name' => 'idtipocategoriaentrada',
            'typeCol' => 'hidden'
        ),
        array(
            'name' => 'idtipocategoriasalida',
            'typeCol' => 'hidden'
        ),
        array(
            'name' => 'entradamanual',
            'typeCol' => 'hidden'
        ),
        array(
            'name' => 'salidamanual',
            'typeCol' => 'hidden'
        ), 
            array(
            'name' => 'horarelacionadaentrada',
            'typeCol' => 'hidden'
        ),  
         array(
            'name' => 'horarelacionadasalida',
            'typeCol' => 'hidden'
        ),  
        array(
            'name' => 'nombrecompleto',
           'header'=>'Nombre Completo',            
            'width' => 22,         
            'typeCol' => 'uneditable'
            
        ),
          array(
            'name' => 'fecha',
            
            'width' => 6,
            'typeCol' => 'uneditable'
            
        ),
          array(
            'name' => 'entrada',
            'width' => 6,
            'typeCol' => 'editable(entradamanual==1)',
              'onKeyUp' => $eventohora,
            
        ),
        array(
            'header'=>'Min',
            'name' => 'difentrada',
            'width' => 4,
            'type' => 'number(0)',
            'typeCol' => 'editable(idtipocategoriaentrada==1 || idtipocategoriaentrada==5 )',
            'onKeyUp' => $evento,
              
            
        ),
        array(
            'header' => 'Tipo',
            'name' => 'tipoentrada',
            'searchUrl' => 'asistencia/BuscarTipoentrada',
            'searchCopyCol' => 'idtipoentrada',
            'searchHeight' => 100,
            'searchWidth' => 220,
           'change' => 'function(){
               alert("ooooo");
            SGridView.selectRow(this);
            Entradasalida.cambiotipo();}',
            'width' => 14,
            'style' => array('text-transform' => 'uppercase'),
            'typeCol' => 'editable',
           
                 ),
           array(           
            'name' => 'horarelacionadaespecialentrada',
            'typeCol' => 'hidden',
               ),
          array(
            'header' => 'Observacion',
            'name' => 'observacionentrada',
            'width' => 9,
            'style' => array('text-transform' => 'uppercase'),           
            'typeCol' => 'editable',
            'onKeyUp' => $eventoobservacion,
               ),
        array( 
            'name' => 'idtipoentrada',
            'typeCol' => 'hidden',
        ),
        array(
            'name' => 'salida',
            'width' => 6,
            'typeCol' => 'editable(salidamanual==1)',
            'onKeyUp' => $eventohora,
            
        ),
        array(
            'header'=>'Min',
            'name' => 'difsalida',
            'width' => 4,
            'type' => 'number(0)',
            'typeCol' => 'editable(idtipocategoriasalida==1 || idtipocategoriasalida==5 )',
            'onKeyUp' => $evento,
        ),
        array(
            'header' => 'Tipo',
            'name' => 'tiposalida',
            'searchUrl' => 'asistencia/BuscarTiposalida',
            'searchCopyCol' => 'idtiposalida',
            'searchHeight' => 100,
            'searchWidth' => 220,
            'width' => 14,
            'style' => array('text-transform' => 'uppercase'),
            'typeCol' => 'editable',
            'select' => 'function(){
               
                SGridView.selectRow(this);
                Entradasalida.cambiotipo();}',
                  ),
            array(           
            'name' => 'horarelacionadaespecialsalida',
            'typeCol' => 'hidden',
               ),
          array(
            'header' => 'Observacion',
            'name' => 'observacionsalida',
            'width' => 9,
            'style' => array('text-transform' => 'uppercase'),
            'typeCol' => 'editable',
             'onKeyUp' => $eventoobservacion
               ),
          array(
             'header' => 'Horas Efectivas',
            'name' => 'horastrabajadas',
            'width' => 6,
            'type' => 'number(3,2)',
            
        ),
        array( 
            'name' => 'idtiposalida',
            'type' => 'number(0)',
            'typeCol' => 'hidden'
            
        ),
    )
));
?>
