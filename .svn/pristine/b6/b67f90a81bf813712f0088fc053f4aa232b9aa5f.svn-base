<div class="row">
    <?php
         
          echo $form->labelEx($modeleud,'fechadevolucion',array('label'=>'Fecha de Devolucion'));
                    echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $modeleud,
                    'attribute' => 'fechadevolucion',
                    'value' => $modeleud->fechadevolucion,
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'onSelect'=>'js:function(){$(this).css("background-color","#fff");}'
                  
                  
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                    ),
                    ), true);

            ?>
	</div>
 <div class="row">
		<?php echo $form->labelEx($modeleud,'descripcion_devolucion'); ?>
		<?php echo $form->textArea($modeleud,'descripcion_devolucion',array('rows'=>3, 'cols'=>15,'style' => 'text-transform: uppercase;width:95%'));?>
	</div>
  <div class="row">
            
            <?php
             
echo SGridView::widget('TGridView', array(
        'id' => 'gridDevolucion',
        'dataProvider' => $listauniformes,       
         'buttonAdd' => false,
        'buttonText' => '+',        
        'height' => 200,
        'eventAfterEditionAutomatic' => true,
       
        'columns' => array(           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
                
            ),
            
              
              array(
                'header' => 'Devolver',
                'name' => 'descripcion_entrega',
                'value' => '$data->descripcion_entrega',
                'width' => 95,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'uneditable',
               
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