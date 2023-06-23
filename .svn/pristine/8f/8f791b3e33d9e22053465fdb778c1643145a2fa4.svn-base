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
    <div class="row" >
        <?php                 
                echo $form->label($model, 'fecharegistro');
                echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fecharegistro',
                    
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'minDate'=>$fecha
                        
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                    ),
                    ), true);

            ?>
  
     
    
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'monto'); ?>
        <?php echo $form->numberField($model,'monto',array('step'=>'0.01')); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'nombre'); ?>
        <?php echo $form->textArea($model,'nombre',array('rows'=>2, 'cols'=>15,'style'=>'Width:90%')); ?>
    </div>
       
    

              
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Otroscostos',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
