<?php
/* @var $this DependienteController */
/* @var $model Dependiente */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admDependiente',
)); ?>
	<div class="row">
		<?php echo $form->label($model,'ci'); ?>
		<?php echo $form->textField($model,'ci',array('maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombrec'); ?>
		<?php echo $form->textField($model,'nombrec',array('maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fechanac'); ?>
		<?php echo $form->textField($model,'fechanac'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'parentesco'); ?>
		<?php echo $form->textField($model,'parentesco',array('maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'discapacidad'); ?>
		<?php echo $form->checkBox($model,'discapacidad'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idpersona'); ?>
		<?php echo $form->textField($model,'idpersona'); ?>
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
                'name' => 'dependiente[fecha]',
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
                    'onClose' => 'js:function(selectedDate) {admDependiente.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Dependiente_fecha',
                ),
                    ), true)  
                    ?>

                    </div>
   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
