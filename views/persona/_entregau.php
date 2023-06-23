<div class="row">
	
            <?php
         
           
          echo $form->labelEx($modeleu,'fechaentrega',array('label'=>'Fecha de Entrega'));
                    echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $modeleu,
                    'attribute' => 'fechaentrega',
                    'value' => $modeleu->fechaentrega,
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
		<?php echo $form->labelEx($modeleu,'descripcion_entrega'); ?>
		<?php echo $form->textArea($modeleu,'descripcion_entrega',array('rows'=>3, 'cols'=>15,'style' => 'text-transform: uppercase;width:95%'));?>
	</div>
   