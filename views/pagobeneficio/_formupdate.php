<?php
/* @var $this PagobeneficioController */
/* @var $model Pagobeneficio*/
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'id')
)); ?>
    <div class="formWindow">
   
	<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'id')
)); ?>
 

<div class="row">
		<?php echo $form->labelEx($model,'fechasolicitud'); ?>
		<?php   echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechasolicitud',
                    'value' => $model->fechasolicitud,
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
                    ), true);?>
	</div>
    <div class="row">
	
   </div>

    <div class="row alter alert-info">
  
    
    </div>
  
<?php $this->endWidget(); ?>
    

              
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Pagobeneficio',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
