<?php
/* @var $this TrabajosexternosController */
/* @var $model Trabajosexternos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admTrabajosexternos',
)); ?>
	<div class="row">
		<?php echo $form->label($model,'empleado'); ?>

		<?php echo $form->textField($model,'empleado',array('placeholder'=>'Buscar Empleado...')); ?>

	</div>

	<div class="row">
		<?php echo $form->label($model,'fechadesde'); ?>
		    <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechadesde',
                'name' => 'trabajosexternos[fechadesde]',
                'value' => $model->fechadesde,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate) {admTrabajosexternos.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Trabajosexternos_fechadesde',
                ),
                    ), true)  
                    ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fechahasta'); ?>
		    <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechahasta',
                'name' => 'trabajosexternos[fechahasta]',
                'value' => $model->fechahasta,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate) {admTrabajosexternos.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Trabajosexternos_fechahasta',
                ),
                    ), true)  
                    ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion'); ?>
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
                'name' => 'trabajosexternos[fecha]',
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
                    'onClose' => 'js:function(selectedDate) {admTrabajosexternos.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Trabajosexternos_fecha',
                ),
                    ), true)  
                    ?>

                    </div>
   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
