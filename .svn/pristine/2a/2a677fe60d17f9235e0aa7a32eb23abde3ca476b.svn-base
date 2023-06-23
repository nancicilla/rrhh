<?php
/* @var $this BonosController */
/* @var $model Bonos */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    
)); ?>
       <?php echo $form->hiddenField($model,'id'); ?>
   
   
    <div class="row alert alert-info"  <?php echo 'id="'.System::Id('contenedorMensaje').'"';?>>
       Desea Consolidar el Bono?
       <div class="row">
		<?php echo $form->labelEx($model,'fechapago'); ?>
		<?php   echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechapago',
                    'value' => $model->fechapago,
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                       
              
                    ),
                    'htmlOptions' => array(
                       
                    ),
                    ), true);?>
	</div>
    </div>
   
  
 
    <?php
   echo System::Buttons(array(
        'nameView' => 'Bonoespecial',
        'buttons' => array(

                      
            )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
