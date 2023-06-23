<?php
/* @var $this TipopermisoController */
/* @var $model Tipopermiso */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>60,'style' => 'text-transform: uppercase')); ?>
	</div>
    

	<div class="row">
		<?php 

		echo $form->labelEx($model,'efecto'); ?>
		<?php echo $form->dropDownList($model,'efecto',CHtml::listData(array(array('id'=>true,'valor'=>'Con efecto en planilla'),array('id'=>false,'valor'=>'Sin efecto en planilla')),'id','valor'),array('empty'=>'','onchange'=>'Tipopermiso.mostrar(this.value)')); ?>
	</div>


    
	<div class="row" id="mostrar" style="<?php echo $model->scenario;?>">
		<?php echo $form->labelEx($model,'valore'); ?>
		<?php echo $form->numberField($model,'valore',array('min'=>'0' )); ?>
	</div>
		<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textArea($model,'descripcion',array('col'=>'3','row'=>3)); ?>
	</div>
    
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Tipopermiso',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
