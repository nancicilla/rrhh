<?php
/* @var $this EmpleadoController */
/* @var $model Empleado */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admEmpleado',
)); ?>
	
    <div class="row">
        <?php echo $form->label($model,'pempleado',array('label'=>'Empleado')); ?>

        <?php echo $form->textField($model,'pempleado',array('placeholder'=>'Buscar Empleado...')); ?>

        
    </div>
        <div class="row">
		<?php 
       
    

        echo $form->label($model, 'fecha'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fecha',
                'name' => 'empleado[fecha]',
                'value' => $model->fecha,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'minDate'=>$model->fechaminima,
                    'maxDate' => date('d-m-Y', strtotime('-1 day')),
                    'onClose' => 'js:function(selectedDate) {admEmpleado.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Empleado_fecha',
                ),
                    ), true)  
                    ?>

                    </div>
   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
