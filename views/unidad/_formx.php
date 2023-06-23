<?php
/* @var $this UnidadController */
/* @var $model Unidad */
/* @var $form CActiveForm 
style='color: #3a87ad;'
*/
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
   
    <div class="row" >
        <h1>Pagar</h1>
        <p class="row" id="tt"></p>   

    </div>
    <div class="row">
        
            <?php
/*

nombre
cantidad 
pu 
pud
total
montom
*/
echo SGridView::widget('TGridView', array(
        'id' => 'gridCarrito',
        'dataProvider' =>array(),       
         'buttonAdd' => true,
        'buttonText' => '+',        
        'height' => 180,
        'eventAfterEdition' => 'Unidad.calcular();',
        'columns' => array(           

             array(
                'header' => 'Item',
                'name' => 'item',
                'width' => 10,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
                
            ),

             array(
                'header' => 'Cantidad',
                'name' => 'cant',
                'width' => 10,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
                
            ),
              array( 
                'header'=>'P.U.',
                'name' => 'pu',
                'typeCol' => 'editable',
                'width' => 10,
                
            ),
            array(
                'header' => 'P.U.D.',
                'name' => 'pud',
               
                'width' => 10,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
            
            ),
              array( 
                'header'=>'TOTAL',
                'name' => 'total',
                'typeCol' => 'editable',
                'width' => 10,
                
            ),
            array( 
                'header'=>'Monto Minimo',
                'name' => 'monto',
                'typeCol' => 'editable',
                   'width' => 10,
                
            ),
      
                array(
                'width' => 4,
                'typeCol' => 'buttons',
                'buttons'=>array('delete'),
                
            ),

           
        ),
    ));
?>
    </div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Unidad',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
