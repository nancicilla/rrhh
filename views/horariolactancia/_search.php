<?php
/* @var $this HorariolactanciaController */
/* @var $model Horariolactancia */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admHorariolactancia',
)); ?>
	

	<div class="row">
		<?php echo $form->label($model,'empleado'); ?>
		<?php echo $form->textField($model,'empleado',array('placelholder'=>'Buscar empleado...')); ?>
	</div>
        <div class="row">
		<?php echo $form->label($model,'fechadesde'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechadesde',
                'name' => 'horariolactancia[fechadesde]',
                'value' => $model->fechadesde,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    
                    'onClose' => 'js:function(selectedDate) {admHorariolactancia.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Horariolactancia_fechadesde',
                ),
                    ), true)  
                    ?>
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
                'name' => 'horariolactancia[fecha]',
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
                    'onClose' => 'js:function(selectedDate) {admHorariolactancia.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Horariolactancia_fecha',
                ),
                    ), true)  
                    ?>

                    </div>
   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
