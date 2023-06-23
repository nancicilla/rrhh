<?php
/* @var $this RangohoraController */
/* @var $model Rangohora */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'turno')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'turno'); ?>
		<?php echo  $form->textField($model,'turno',array('style' => 'text-transform: uppercase'));
		//$form->textField($model,'turno',array('maxlength'=>6,'style' => 'text-transform: uppercase')); 
         //$form->dropDownList($model,'turno',CHtml::listData(array(array('id'=>'MAÑANA','nombre'=>'MAÑANA'),array('id'=>'TARDE','nombre'=>'TARDE'),array('id'=>'NOCHE','nombre'=>'NOCHE')),'id','nombre'),array('empty'=>'') );
		
		?>
	</div>
    

	<div class="row">
		<?php echo $form->labelEx($model,'horai',array('label'=>'Hora de Entrada')); ?>
		
	<div class="column">
	
		<?php echo $form->labelEx($model,'hi',array('label'=>'HH')); ?>
		<?php echo $form->numberField($model,'hi',array('min'=>'0', 'max'=>'20', 'style'=>'width:35px' )); ?>
	</div>
	<div class="column">:</div>
	<div class="column">
	
		<?php echo $form->labelEx($model,'mi',array('label'=>'MM')); ?>
		<?php echo $form->numberField($model,'mi',array('min'=>'0', 'max'=>'59' , 'style'=>'width:35px')); ?>
	</div>
	<div class="column">
	
		<?php echo $form->labelEx($model,'controlarentrada'); ?>
		<?php echo $form->checkBox($model,'controlarentrada'); ?>
	</div>
    </div>
	

	<div class="row">
		<?php echo $form->labelEx($model,'horas',array('label'=>'Hora de Salida')); ?>
	<div class="column">
	
		<?php echo $form->labelEx($model,'hs',array('label'=>'HH')); ?>
		<?php echo $form->numberField($model,'hs',array('min'=>'1', 'max'=>'24' , 'style'=>'width:35px')); ?>
	</div>
	<div class="column">:</div>
	<div class="column">
	
		<?php echo $form->labelEx($model,'ms',array('label'=>'MM')); ?>
		<?php echo $form->numberField($model,'ms',array('min'=>'0', 'max'=>'59' , 'style'=>'width:35px')); ?>
	</div>
	<div class="column">
	
		<?php echo $form->labelEx($model,'controlarsalida'); ?>
		<?php echo $form->checkBox($model,'controlarsalida'); ?>
	</div>
    </div>

     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Rangohora',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
