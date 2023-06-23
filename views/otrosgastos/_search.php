<?php
/* @var $this OtrosgastosController */
/* @var $model Otrosgastos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admOtrosgastos',
)); ?>
    <div class="row">
		<?php echo $form->label($model,'empleado'); ?>
		<?php echo $form->textField($model,'empleado',array('placeholder'=>'Buscar Empleado...')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre'); ?>
	</div>



	
	<div class="row">
		<?php echo $form->label($model,'monto'); ?>
		<?php echo $form->textField($model,'monto',array('maxlength'=>12)); ?>
	</div>

	

        <div class="row">
		<?php echo $form->label($model, 'fechadesde'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechadesde',
                'name' => 'otrosgastos[fechadesde]',
                'value' => $model->fecha,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'onClose' => 'js:function(selectedDate) {admOtrosgastos.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Otrosgastos_fechadesde',
                ),
                    ), true)  
                    ?>

                    </div>

   
 <div class="row">
		<?php echo $form->label($model, 'fechahasta'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechahasta',
                'name' => 'otrosgastos[fechahasta]',
                'value' => $model->fecha,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                   
                    'onClose' => 'js:function(selectedDate) {admOtrosgastos.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Otrosgastos_fechahasta',
                ),
                    ), true)  
                    ?>

                    </div>
    <div class="row">
		<?php echo $form->label($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('maxlength'=>30)); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- search-form -->
