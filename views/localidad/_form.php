<?php
/* @var $this LocalidadController */
/* @var $model Localidad */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>70,'style' => 'text-transform: uppercase')); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'idmunicipio'); ?>
		<?php echo $form->textField($model,'idmunicipio'); ?>
	</div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Localidad',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
