<?php
/* @var $this EmpleadodeduccionesController */
/* @var $model Empleadodeducciones */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'monto')
)); ?>
    <div class="formWindow">
    
	
    
	<div class="row">
		<?php echo $form->labelEx($model,'iddeducciones'); ?>
		<?php echo $form->dropDownList($model,'iddeducciones',CHtml::listData(Deducciones::model()->findAll('t.esagrupador=false and t.porfucion=false '),'id','nombre'),array('empty'=>'')); ?>
	</div>
   
    
	<div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto'); ?>
	</div>
    	<div class="row">
		<?php echo $form->labelEx($model,'fechar');

echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechar',                    
                    'language' => 'es',                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'minDate'=>$model->fecha
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                    ),
                    ), true);

		 ?>
	
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textArea($model,'descripcion',array('rows'=>3,'cols'=>3)); ?>
	</div>
    

     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Empleadodeducciones',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
