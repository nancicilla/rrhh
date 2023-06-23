<?php
/* @var $this PersonaController */
/* @var $model Persona */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admPersona',
)); ?>
	<div class="row">
		<?php echo $form->label($model,'ci'); ?>
		<?php echo $form->textField($model,'ci',array('maxlength'=>15)); ?>
	</div>


	<div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'apellidop'); ?>
		<?php echo $form->textField($model,'apellidop',array('maxlength'=>40)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'apellidom'); ?>
		<?php echo $form->textField($model,'apellidom',array('maxlength'=>40)); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'area'); ?>
		<?php echo $form->textField($model,'area',array('maxlength'=>60)); ?>
	</div>
        <div class="row">
		<?php echo $form->label($model,'activo',array('label'=>'Estado')); ?>
		<?php echo $form->dropDownList($model,'activo',CHtml::listData(array(array('id'=>1,'nombre'=>'Activo'),array('id'=>0,'nombre'=>'Inactivo')),'id','nombre'),array('empty'=>''));?>

	</div>
	

	<div class="row">
		<?php echo $form->label($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('maxlength'=>30)); ?>
	</div>

	

        <div class="row">
		<?php echo $form->label($model, 'fecha'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fecha',
                'name' => 'persona[fecha]',
                'value' => $model->fecha,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate) {admPersona.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Persona_fecha',
                ),
                    ), true)  
                    ?>

                    </div>
   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
