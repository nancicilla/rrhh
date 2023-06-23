<?php
/* @var $this ConfiguracionatrasoController */
/* @var $model Configuracionatraso */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'intervaloinicial')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'intervaloinicial'); ?>
		<?php echo $form->textField($model,'intervaloinicial'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'intervalofinal'); ?>
		<?php echo $form->textField($model,'intervalofinal'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'porcentaje'); ?>
		<?php echo $form->textField($model,'porcentaje'); ?>
	</div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Configuracionatraso',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
