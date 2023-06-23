<?php
echo SGridView::widget('TGridView', array(
    'id' => 'gridListaDeduccion',
    'dataProvider' => $listadeducciones,
    'buttonAdd' => true,
    'buttonText' => '+',
    'height' => 300,
    'eventAfterEdition' => 'Dependiente.sumarTotalDeduccion();',
        'eventAfterEditionAutomatic' => true,
    'columns' => array(
        array(
            'name' => 'id',
            'typeCol' => 'hidden'
        ),
           array(
                'header' => 'Empleado',
                'name' => 'nombrecompleto',
                'searchUrl' => 'dependiente/BuscarEmpleado',
                'searchCopyCol' => 'ci',
                'searchHeight' => 100,
                'searchWidth' => 220,
                'value' => '$data->nombrecompleto == null? "" : $data->nombrecompleto',
                'width' => 10,
               
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
                
            ),
        array(
            'header' => 'C.I.',
            'name' => 'ci',
            
            'key' => true,
            'width' => 7,
            'typeCol' => 'uneditable',
           
            'style' => array('text-transform' => 'uppercase'),
        ),
     

       
        array(
            'name' => 'monto',
            'value' => '$data->total>0?$data->total:0',
            'width' => 10,
            'type' => 'number(10,2)',
            'typeCol' => 'editable',
          
        ),
        array(
            'name' => 'estado',
            'value' => '$data->estado',
            'valueDefault' => '-1',
           'typeCol' => 'hidden'
          
        ),
        array(
            'typeCol' => 'buttons',
            'width' => 3,
            'buttons' => array('delete')
        )
    )
));
?>
