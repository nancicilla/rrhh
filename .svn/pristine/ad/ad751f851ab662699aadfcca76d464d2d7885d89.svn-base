<?php
/* @var $this RepresentanteController */
/* @var $model Representante */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'cirepresentante')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'cirepresentante'); ?>
		<?php echo $form->textField($model,'cirepresentante',array('maxlength'=>20,'style' => 'text-transform: uppercase')); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'nrepresentante'); ?>
		<?php echo $form->textField($model,'nrepresentante',array('maxlength'=>60,'style' => 'text-transform: uppercase')); ?>
	</div>
    
	
    
	<div class="row">
		<?php echo $form->labelEx($model,'activo'); ?>
		<?php echo $form->checkBox($model,'activo'); ?>
	</div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Representante',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
