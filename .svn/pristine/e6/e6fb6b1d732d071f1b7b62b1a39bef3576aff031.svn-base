<?php

            echo SGridView::widget('TGridView', array(
                'id' => 'gridEmpleado',
                'dataProvider' => $lista,
                'buttonAdd' => true,
                'buttonText' => '+',
                'eventAfterEdition' => 'Bono.sumarTotalBono();',
                'height' => 300,
                'columns' => array(
                    array(
                        'name' => 'id',
                        'typeCol' => 'hidden'
                    ),
                    array(
                        'header' => 'Empleado',
                        'name' => 'empleado',
                        'searchUrl' => 'bono/BuscarEmpleado',
                       
                        'searchCopyCol' => 'ci',
                        'searchHeight' => 100,
                        'searchWidth' => 220,
                        'value' => '$data->idempleado == null? "" : $data->idempleado0->idpersona0->nombrecompleto',
                        'width' => 50,
                        'style' => array('text-transform' => 'uppercase'),
                        'typeCol' => 'editable',
                    ),   array(
            'header' => 'C.I.',
            'name' => 'ci',
            
            'key' => true,
            'width' => 20,
            'typeCol' => 'uneditable',
            'value'=>'$data->ci',
           
            'style' => array('text-transform' => 'uppercase'),
        ),
                    array(
                        'name' => 'idempleado',
                        'typeCol' => 'hidden'
                    ),
                    array(
                        'header' => 'Monto(Bs.)',
                        'name' => 'monto',
                        'typeCol' => 'editable',
                        'type' => 'number(12,2)',
                        'width' => 15,
                    ),
                    array(
                        'name' => 'idbono',
                        'typeCol' => 'hidden'
                    ),
                     array(
                        'name' => 'estado',
                        'value' => '$data->estado',
                        'valueDefault' => '-1',
                        'typeCol' => 'hidden'

                    ),
                    array(
                        'width' => 5,
                        'typeCol' => 'buttons',
                        'buttons' => array('delete'),
                    ),
                ),
            ));
            ?>