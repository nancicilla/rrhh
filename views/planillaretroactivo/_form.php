<?php
/* @var $this PlanillaretroactivoController */
/* @var $model Planillaretroactivo */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'mesinicio')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'mesinicio'); ?>
                <?php echo $form->dropDownList($model,'mesinicio',CHtml::listData($lista,'id','nombre'),array('empty'=>'')); ?>

	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'mesfin'); ?>
		<?php echo $form->dropDownList($model,'mesfin',CHtml::listData($lista,'id','nombre'),array('empty'=>'')); ?>

	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->numberField($model,'monto',array('min'=>'0','step'=> '0.01'  )); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'porcentaje'); ?>
		<?php echo $form->numberField($model,'porcentaje',array('min'=>'0','step'=> '0.01'  )); ?>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Planillaretroactivo',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
