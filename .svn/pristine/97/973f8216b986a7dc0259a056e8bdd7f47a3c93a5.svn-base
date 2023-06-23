<?php
/* @var $this ConfiguracionController */
/* @var $model Configuracion */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>60,'style' => 'text-transform: uppercase;width: 90%;')); ?>
	</div>
    <div class="row">
        <?php echo $form->labelEx($model,'sigla'); ?>
        <?php echo $form->textField($model,'sigla',array('maxlength'=>10,'style' => 'text-transform: uppercase;width: 90%;')); ?>
    </div>
     <div class="row">
        <?php echo $form->labelEx($model,'valor'); ?>
        <?php echo $form->textField($model,'valor',array('maxlength'=>22,'style' => 'text-transform: uppercase;width: 90%;')); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'para'); ?>
        <?php echo $form->dropDownList($model,'para',CHtml::listData(
            array(array( 'id'=>'BENEFICIO','nombre'=>'BENEFICIO'),array('id'=>'APORTE','nombre'=>'APORTE'),array('id'=>'EDAD','nombre'=>'EDAD DE CONTRATACIÓN'),array('id'=>'LACTANCIA','nombre'=>'LACTANCIA'),array('id'=>'PARAMETRO','nombre'=>'PARAMETRO'),array('id'=>'OTRO','nombre'=>'OTRO')),'id','nombre'),array('empty'=>'','style' => 'width: 90%;')); ?>
    </div>
    
	<div class="">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textArea($model,'descripcion',array('col'=>20,'rows'=>4,'style' => 'width: 90%;')); ?>
	</div>
     
    </div>
 
    <?php
    echo System::Buttons(array(
        'nameView' => 'Configuracion',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
