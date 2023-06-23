<?php
   
    
echo SGridView::widget('TGridView', array(
      'id' => $nombre.'gridLista',
    'dataProvider' =>$selladas,
    'buttonAdd' => false,
    'specialCellEditionMode' => false,   
    'eventAfterEditionAutomatic' => true,
    'eventAfterEdition' =>'Entradasalida.validarHoraMinuto();',   
    'buttonText' => '+',
    'height' => 300,
    'columns' => array(
       array(
            'name' => 'identradasalida',
            'typeCol' => 'hidden'
        ),
       
       array(
            'name' => 'idcategoriatipo',
             'typeCol' => 'hidden'
        ),   
        
        
        array(
            'name' => 'nombrecompleto',
           
            'header'=>'Nombre Completo',
            'width' => 24,
         
            'typeCol' => 'uneditable'
            
        ),
          array(
            'name' => 'fecha',
            
            'width' => 7,
            'typeCol' => 'uneditable'
            
        ),
          array(
            'header'=>'Sellada',
            'name' => 'entrada',
            'width' => 7,
            'typeCol' => 'uneditable'
            
        ),
        array(
            'header'=>'Hora',
            'name' => 'difhentrada',
            'width' => 7,
            'type' => 'number(0)',
            'typeCol' => 'editable(idcategoriatipo==1 || idcategoriatipo==5 )',
          
        ),
        array(
            'header'=>'Min',
            'name' => 'difmentrada',
            'width' => 7,
            'type' => 'number(0)',
            'typeCol' => 'editable(idcategoriatipo==1 || idcategoriatipo==5 )',
          
        ),
        array(
            
            'name' => 'difentradaoriginal',
                'typeCol' => 'hidden',
          
        ),
        array('name'=>'otrotipocolumna',
            'typeCol' => 'hidden',
            ),
        array(
            'header' => 'Tipo',
            'name' => 'tipoentrada',
            'width' =>18,
            'style' => array('text-transform' => 'uppercase'),
            'typeCol' => 'uneditable',
               ),
        array(
            'header' => 'Observacion',
            'name' => 'observacionentrada',
            'width' =>18,
            'style' => array('text-transform' => 'uppercase'),
            'typeCol' => 'editable',             
               ),
        array( 
            'name' => 'idtipoentrada',
            'typeCol' => 'hidden',
        ),
         array(
                'width' => 4,
                'typeCol' => 'buttons',
                'buttons'=>array('delete'),
                
            ),
       
       
    )
));
