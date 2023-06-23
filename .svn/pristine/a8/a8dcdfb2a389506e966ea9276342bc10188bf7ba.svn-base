<?php
/* @var $this HistorialestadoempleadoController */
/* @var $model Historialestadoempleado */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admHistorialestadoempleado',
)); ?>
<div class="row">
		<?php echo $form->label($model,'empleado'); ?>

		<?php echo $form->textField($model,'empleado',array('placeholder'=>'Buscar Empleado...')); ?>

    	
	</div>
	<div class="row">
		<?php echo $form->label($model,'fechaantiguedad'); ?>
		<?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechaantiguedad',
                'name' => 'historialestadoempleado[fechaantiguedad]',
                'value' => $model->fechaantiguedad,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate) {admHistorialestadoempleado.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Historialestadoempleado_fechaantiguedad',
                ),
                    ), true)  
                    ?>

	</div>

	<div class="row">
		<?php echo $form->label($model,'fechaplanilla'); ?>
			<?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechaplanilla',
                'name' => 'historialestadoempleado[fechaplanilla]',
                'value' => $model->fechaplanilla,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate) {admHistorialestadoempleado.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Historialestadoempleado_fechaplanilla',
                ),
                    ), true)  
                    ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fechaultidemnizacion'); ?>
		<?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechaultidemnizacion',
                'name' => 'historialestadoempleado[fechaultidemnizacion]',
                'value' => $model->fechaultidemnizacion,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate) {admHistorialestadoempleado.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Historialestadoempleado_fechaultidemnizacion',
                ),
                    ), true)  
                    ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecharetiro'); ?>	<?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fecharetiro',
                'name' => 'historialestadoempleado[fecharetiro]',
                'value' => $model->fecharetiro,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate) {admHistorialestadoempleado.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Historialestadoempleado_fecharetiro',
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
                'name' => 'historialestadoempleado[fecha]',
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
                    'onClose' => 'js:function(selectedDate) {admHistorialestadoempleado.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Historialestadoempleado_fecha',
                ),
                    ), true)  
                    ?>

                    </div>
   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
