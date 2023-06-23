<?php

/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'')
)); ?>
    <div class="formWindow">
        
    <?php echo $form->hiddenField($model,'id'); ?>
    	<div class=" alert alert-info">
        <?php    echo $model->nombre; ?>
              <div class="row " <?php echo 'id="'.System::Id('contmensaje').'"';?>> </div>
		
	</div>
      
       
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Planilla',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
