<?php

/* @var $form CActiveForm */
?>
<div class="container">
	<div class="offset-12">
		<div id="content">
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'')
)); ?>
    <div class="formWindow">
    <?php echo $form->hiddenField($model,'id'); ?>
    	<div class="row alert alert-info">
            <h6>Desea Consolidar Prima Anual?</h6>
              <h6 <?php echo 'id="'.System::Id('contenedorMensaje').'"';?>></h6>
         
             <div class="row">
		<?php echo $form->labelEx($model,'fechapago'); ?>
		<?php   echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechapago',
                    'value' => $model->fechapago,
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                       
              
                    ),
                    'htmlOptions' => array(
                       
                    ),
                    ), true);?>
	</div>
		
	</div>
       
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Pagobeneficio',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
                </div>
        </div>
</div>