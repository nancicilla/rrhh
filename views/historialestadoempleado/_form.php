<?php
/* @var $this HistorialestadoempleadoController */
/* @var $model Historialestadoempleado */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'id')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'fechavacacion',array('label'=>'Fecha Vacacion')); ?>
		<?php  echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechavacacion',
                    'value' => $model->fechavacacion,
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
                        ,'data-v'=>''
                    ),
                    ), true); ?>
	</div>
   
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Historialestadoempleado',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
