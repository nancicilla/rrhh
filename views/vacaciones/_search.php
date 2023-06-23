<?php
/* @var $this VacacionesController */
/* @var $model Vacaciones */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admVacaciones',
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
                'name' => 'vacaciones[fechadesde]',
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
                    'onClose' => 'js:function(selectedDate) { admVacaciones.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Vacaciones_fecha',
                ),
                    ), true)  
                    ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fechahasta'); ?>
		<?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechahasta',
                'name' => 'vacaciones[fechahasta]',
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
                    'onClose' => 'js:function(selectedDate) { admVacaciones.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Vacaciones_fechahasta',
                ),
                    ), true)  
                    ?>
	</div>
<div class="row">
        <?php echo $form->label($model,'diastomados'); ?>
        <?php echo $form->textField($model,'diastomados',array('maxlength'=>30)); ?>
    </div>
	
    <div class="row">
        <?php echo $form->label($model,'fechaav'); ?>
        <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechaav',
                'name' => 'vacaciones[fechaav]',
                'value' => $model->fechaav,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate) { admVacaciones.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Vacaciones_fechaav',
                ),
                    ), true)  
                    ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'dias',array('label'=>'Saldo Vacacion')); ?>
        <?php echo $form->textField($model,'dias',array('maxlength'=>30)); ?>
    </div>

	
<div class="row">
        <?php echo $form->label($model,'usuario'); ?>
        <?php echo $form->textField($model,'usuario',array('maxlength'=>30)); ?>
    </div>

    

            
    <div class="row">
        <?php echo $form->label($model,'fecha'); ?>
        <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fecha',
                'name' => 'vacaciones[fecha]',
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
                    'onClose' => 'js:function(selectedDate) { admVacaciones.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Vacaciones_fecha',
                ),
                    ), true)  
                    ?>
    </div>


	

 
   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
