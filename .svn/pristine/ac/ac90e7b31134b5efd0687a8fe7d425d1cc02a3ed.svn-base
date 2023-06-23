<?php
/* @var $this BonosController */
/* @var $model Bonos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admBonos',
)); ?>
	<div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>30)); ?>
	</div>

	
	<div class="row">
		<?php echo $form->label($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('maxlength'=>30)); ?>
	</div>
    <div class="row">
        <?php echo $form->labelEx($model,'enplanilla',array('label'=>'Mostrar en Planilla General?')); ?>
         <?php  echo $form->checkBox($model,'enplanilla'); ?>  
     
    </div>

	<div class="row">
		<?php echo $form->label($model,'vigente'); 
       

        ?>
		<?php echo $form->checkBox($model,'vigente'); ?>
	</div>
     <div class="row">
        <?php
         echo $form->labelEx($model, 'idcuenta', array('label' => 'Cuenta'));
         echo $form->textField($model, 'cuenta');
      ?>
    </div>

        <div class="row">
		<?php echo $form->label($model, 'fecha'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fecha',
                'name' => 'bonos[fecha]',
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
                    'onClose' => 'js:function(selectedDate) {admBonos.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Bonos_fecha',
                ),
                    ), true)  
                    ?>

                    </div>
   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
