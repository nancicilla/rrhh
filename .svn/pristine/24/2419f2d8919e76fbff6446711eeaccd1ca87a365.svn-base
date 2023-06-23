<?php
echo SGridView::widget('TGridView', array(
    'id' => 'gridListaDeducciones',
    'dataProvider' =>$listadeducciones,
    'buttonAdd' => true,
    'buttonText' => '+',
    'height' => 300,
    'eventAfterEdition' => 'Deducciones.sumarTotalDeducciones();',
    'columns' => array(
        array(
            'name' => 'id',
            'typeCol' => 'hidden'
        ),
        array(
            'name' => 'ci',
            
            'key' => true,
            'width' => 7,
            'typeCol' => 'editable',
            'style' => array('text-transform' => 'uppercase'),
        ),
       
        array(
            'name' => 'total',
            'value' => '$data->total>0?$data->total:0',
            'width' => 10,
            'type' => 'number(10,2)',
            'typeCol' => 'editable',
        ),
        array(
            'typeCol' => 'buttons',
            'width' => 3,
            'buttons' => array('delete')
        )
    )
));
?>


