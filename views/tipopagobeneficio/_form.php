<?php
/* @var $this TipopagobeneficioController */
/* @var $model Tipopagobeneficio */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>100,'style' => 'text-transform: uppercase')); ?>
	</div>
    <div class="row">
    <?php
      
          echo $form->labelEx($model, 'asolicitudempleado');
          echo $form->checkBox($model,'asolicitudempleado');
      
     ?>
    </div>
    <div class="row">
     <?php
      if ($model->scenario=='update') {
          echo $form->labelEx($model, 'vigente');
          echo $form->checkBox($model,'vigente');
      }
     ?>
 </div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Tipopagobeneficio',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
