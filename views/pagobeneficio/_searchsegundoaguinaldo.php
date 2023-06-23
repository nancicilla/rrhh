<?php
/* @var $this PagobeneficioController */
/* @var $model Pagobeneficio */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admSegundoaguinaldo',
)); ?>

	

	<div class="row">
		<?php echo $form->label($model,'fechapago'); ?>
		
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechapago',
                'name' => 'pagobeneficio[fechapago]',
                'value'=>$model->fechapago,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                  
                    'onClose' => 'js:function(selectedDate) {admSegundoaguinaldo.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Pagobeneficio_fechasolicitud',
                ),
                    ), true)  
                    ?>
	</div>



	

	
	<div class="row">
		<?php echo $form->label($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('maxlength'=>40)); ?>
	</div>

        <div class="row">
		<?php echo $form->label($model, 'fecha'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fecha',
                'name' => 'pagobeneficio[fecha]',
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
                    'onClose' => 'js:function(selectedDate) {admSegundoaguinaldo.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Pagobeneficio_fecha',
                ),
                    ), true)  
                    ?>

                    </div>
   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
