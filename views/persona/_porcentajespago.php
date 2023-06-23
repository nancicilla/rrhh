 

            <?php echo $form->labelEx($model, 'porcentajepago',array('label'=>'PORCENTAJES DE PAGO POR EMPRESA')); ?>
           
           <?php


            echo SGridView::widget('TGridView', array(
                'id' => 'gridPorcentajespago',
                'dataProvider' => $lista,
                'buttonAdd' => true,
                'buttonText' => '+',
                'eventAfterEdition' => 'Persona.sumarPorcentaje();',
                'height' => 300,
                'columns' => array(
                    array(
                        'name' => 'id',
                        'typeCol' => 'hidden'
                    ),
                    array(
                        'header' => 'Empresa',
                        'name' => 'empresasubempleadora',
                        'searchUrl' => 'persona/BuscarEmpresasubempleadora',
                        'searchCopyCol' => 'idempresasubempleadora',
                        'searchHeight' => 100,
                        'searchWidth' => 220,
                        'value' => '$data->idempresasubempleadora == null? "" : $data->idempresasubempleadora0->nombre',
                        'width' => 50,
                        'style' => array('text-transform' => 'uppercase'),
                        'typeCol' => 'editable',
                    ),  
                    array(
                        'name' => 'idempresasubempleadora',
                        'typeCol' => 'hidden'
                    ),
                   
                    array(
                        'header' => 'Porcentaje(%)',
                        'name' => 'porcentaje',
                        'typeCol' => 'editable',
                        'type' => 'number(3,4)',
                        'width' => 15,
                    ),
                   
                    array(
                        'width' => 5,
                        'typeCol' => 'buttons',
                        'buttons' => array('delete'),
                    ),
                ),
            ));
            ?>
<div class="row">
    <h5 style="position: absolute; left: 25px; top: 450px;"> Porcentaje 
       <span class="badge" <?php echo 'id="'.System::Id('spanTotalPorcentaje').'"';?>  style="font-size: 18px; font-weight: bold;  color: black;"> <?php echo $total;?> 0%</span> 
    </h5>
</div>