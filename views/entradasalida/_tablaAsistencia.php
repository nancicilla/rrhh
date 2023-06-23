<?php
/* @var $this EntradasalidaController */
/* @var $model Entradasalida */
/* @var $form CActiveForm */
?>
<?php

echo SGridView::widget('TGridView', array(
    'id' => 'gridListaImportacion',
    'dataProvider' => $lista,
    'buttonAdd' => true,
    'buttonText' => '+',
    'height' => 300,
    'columns' => array(
        array(
            'name' => 'id',
            'typeCol' => 'hidden'
        ),
             
        array(
            'name' => 'ci',
            
            'width' => 10,
         
            'typeCol' => 'editable',
             ),
          array(
            'name' => 'nombre',
            
            'key' => true,
            'width' => 15,
            'typeCol' => 'editable',
             'style' => array('text-transform' => 'uppercase'),
              ),
          array(
            'name' => 'sellada',
            
            'key' => true,
            'width' => 15,
            'typeCol' => 'editable',
             'style' => array('text-transform' => 'uppercase'),
              ),
        array(
            'typeCol' => 'buttons',
            'width' => 3,
            'buttons' => array('delete')
        )
    )
));
?>


?>