<?php
/* @var $this LactanciaController */
/* @var $model Lactancia */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admLactancia',
)); ?>
<div class="row">
		<?php echo $form->label($model,'idempleado'); ?>

		<?php echo $form->hiddenField($model,'idempleado'); ?>

    	<div id="autocomplete">
			<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'empleado',
                'source' => $this->createUrl("movimientopersonal/autocompletePersona"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {
                                        $('#Lactancia_idempleado' ).val(ui.item.id);
                                admLactancia.search();
                                     
                                    }"
                ),
                'htmlOptions' => array(
                	'placeholder'=>'Buscar Empleado...',
                    'style' => 'width: 100%;text-transform: uppercase;',
                    
                ),
            ));
            ?>
              
          	</div>
	</div>
	<div class="row">
		<?php echo $form->label($model,'fechadesde'); ?>
		<?php echo $form->textField($model,'fechadesde'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fechahasta'); ?>
		<?php echo $form->textField($model,'fechahasta'); ?>
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
                'name' => 'lactancia[fecha]',
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
                    'onClose' => 'js:function(selectedDate) {admLactancia.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Lactancia_fecha',
                ),
                    ), true)  
                    ?>

                    </div>
   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
