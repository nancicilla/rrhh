 <div class="row" style="display:<?php  if ($model->esagrupador==false){echo'display-block';}else{echo'none;';}?>" <?php echo 'id="'.System::Id('contenedorAgrupador2').'"';?>>

    <?php
    echo SGridView::widget('TGridView', array(
        'id' => 'gridAreas',
        'dataProvider' => $listaareas,
        'buttonAdd' => true,
        'buttonText' => '+',
        'height' => 250,
        'eventAfterEditionAutomatic' => true,
        'columns' => array(
            array(
                'name' => 'id',
                'typeCol' => 'hidden'
            ),
            array(
                'header' => 'Area',
                'name' => 'area',
                'searchUrl' => 'area/BuscarArea',
                'searchCopyCol' => 'idarea',
                'searchHeight' => 100,
                'searchWidth' => 220,
                'value' => '$data->idarea == null? "" : $data->idarea0->nombre',
                'width' => 48,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
            ),
            array(
                'name' => 'idarea',
                'typeCol' => 'hidden'
            ),
            array(
                'header' => 'Cuenta',
                'name' => 'cuenta',
                'searchUrl' => 'area/BuscarCuenta',
                'searchCopyCol' => 'idcuenta',
                'searchHeight' => 100,
                'searchWidth' => 520,
                'value' => '$data->idcuenta == null? "" : str_replace(".","",$data->idcuenta0->numero)." - ". $data->idcuenta0->nombre',
                'width' => 48,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
            ),
            array(
                'name' => 'idcuenta',
                'typeCol' => 'hidden'
            ),
            array(
                'width' => 4,
                'typeCol' => 'buttons',
                'buttons' => array('delete'),
            ),
        ),
    ));
    ?>
</div>