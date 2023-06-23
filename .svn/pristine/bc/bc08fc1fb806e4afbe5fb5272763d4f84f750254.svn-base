<?php
echo SGridView::widget('TGridView', array(
    'id' => 'gridLista',
    'dataProvider' => $lista,
    'buttonAdd' => true,
    'buttonText' => '+',
    'height' => 300,
    'eventAfterEdition' => 'Otrosgastos.sumarTotalDeduccion();',
        'eventAfterEditionAutomatic' => true,
    'columns' => array(
        array(
            'name' => 'id',
            'typeCol' => 'hidden'
        ),
           array(
                'header' => 'Empleado',
                'name' => 'nombrecompleto',
                'searchUrl' => 'otrosgastos/BuscarEmpleado',
                'searchCopyCol' => 'ci',
                'searchHeight' => 100,
                'searchWidth' => 220,
                'value' => '$data->nombrecompleto == null? "" : $data->nombrecompleto',
                'width' => 40,
               
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
                
            ),
        array(
            'header' => 'C.I.',
            'name' => 'ci',            
            'key' => true,
            'width' => 10,
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
            'width' => 10,
            'buttons' => array('delete')
        )
    )
));
?>
