 <?php

echo SGridView::widget('TGridView', array(
        'id' => $nombre.'gridEmpleados',
        'dataProvider' => $listaempleados,       
         'buttonAdd' => $estado,
        'buttonText' => '+',        
        'height' => 260,
        'eventAfterEdition' => "Historialbancohoras.ResaltarObservados();",
        'eventAfterEditionAutomatic' => true,
        'specialCellEditionMode' => false,
        'columns' => array(           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
            ),
             array(
                'header' => 'Nombre Completo',
                'name' => 'nombrecompleto',
                'searchUrl' => 'horario/BuscarEmpleado',
                'searchCopyCol' => 'id',
                'searchHeight' => 100,
                'searchWidth' => 220,
                'value' => '$data->nombrecompleto == null? "" : $data->nombrecompleto',
                'width' => 10,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'uneditable',
                
            ),
            array(
               
                'name' => 'tipo',
                'value' => '$data->tipo',
                 'typeCol' => 'hidden'
                
            ),
             
             
                array(
                'width' => 4,
                'typeCol' => 'buttons',
                'buttons'=>array('delete'),
                
            ),

           
        ),
    ));

?>

<script>
Historialbancohoras.ResaltarObservados();
</script>