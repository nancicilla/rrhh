<?php
/* @var $this MovimientopersonalController */
/* @var $model Movimientopersonal */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admMovimientopersonal',
)); ?>
	<div class="row">
		<?php echo $form->label($model,'empleado'); ?>

		<?php echo $form->textField($model,'empleado',array('placeholder'=>'Buscar Empleado...')); ?>

    	
	</div>
	<div class="row">
		<?php echo $form->label($model,'fechaini'); ?>
		 <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechaini',
                'name' => 'movimientopersonal[fechaini]',
                'value' => $model->fechaini,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                   
                    'onClose' => 'js:function(selectedDate) {admMovimientopersonal.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Movimientopersonal_fechaini',
                ),
                    ), true)  
                    ?>
	</div>



	

	<div class="row">
		<?php echo $form->label($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('maxlength'=>30)); ?>
	</div>






        <div class="row">
		<?php echo $form->label($model, 'fecha',array('label'=>'Fecha')); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fecha',
                'name' => 'movimientopersonal[fecha]',
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
                    'onClose' => 'js:function(selectedDate) {admMovimientopersonal.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Movimientopersonal_fecha',
                ),
                    ), true)  
                    ?>

                    </div>
   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
