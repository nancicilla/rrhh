<?php
/* @var $this Formulario110Controller */
/* @var $model Formulario110 */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admFormulario110',
)); ?>
	<div class="row">
		<?php echo $form->label($model,'empleado'); ?>
		<?php echo $form->textField($model,'empleado'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fechapresentacion'); ?>
		<?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechapresentacion',
                'name' => 'formulario110[fechapresentacion]',
                'value' => $model->fechapresentacion,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'onClose' => 'js:function(selectedDate) {admFormulario110.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Formulario110_fechapresentacion',
                ),
                    ), true)  
                    ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'montopresentado'); ?>
		<?php echo $form->textField($model,'montopresentado',array('maxlength'=>12)); ?>
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
                'name' => 'formulario110[fecha]',
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
                    'onClose' => 'js:function(selectedDate) {admFormulario110.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Formulario110_fecha',
                ),
                    ), true)  
                    ?>

                    </div>
   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
