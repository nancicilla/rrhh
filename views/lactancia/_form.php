<?php
/* @var $this LactanciaController */
/* @var $model Lactancia */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'empleado')
)); ?>
    <div class="formWindow">
     	<div class="row">    	
        <?php echo $form->hiddenField($model,'idempleado'); ?>
    <?php
    if ($model->scenario!='update') {
     echo $form->labelEx($model,'idempleado',array('label'=>'Empleado')); 
     $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'empleado',
                'source' => $this->createUrl("lactancia/autocompletePersona"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {
                                        $('#' + Lactancia.Id('idempleado')).val(ui.item.id);
                                      
                                    }"
                ),
                'htmlOptions' => array(
                    'placeholder'=>'Buscar Empleado...',
                    'style' => 'width: 100%;text-transform: uppercase;',
                    
                ),
            ));
     ?>

    <?php
        }
    ?>
   	</div>
   		<div class="row">
		<?php echo $form->labelEx($model,'configuracion',array('label'=>'Seleccione...')); ?>
		<?php echo $form->dropDownList($model,'configuracion',CHtml::listData(Configuracion::model()->findAll("t.para='LACTANCIA'"),'id','nombre'),array('empty'=>''));?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'fechadesde'); 
		echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechadesde',
                    
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                    ),
                    ), true);
		?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'fechahasta'); ?>
		<?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechahasta',
                    
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                    ),
                    ), true); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'rangohora'); ?>
		<?php echo $form->textField($model,'rangohora',array('maxlength'=>12,'style' => 'text-transform: uppercase','placeholder'=>'Ej: 8:00-9:00')); ?>
	</div>
    <div class="row">
    	
    </div>

    
	
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Lactancia',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
