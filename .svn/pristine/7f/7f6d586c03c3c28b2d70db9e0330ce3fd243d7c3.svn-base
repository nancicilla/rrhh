<?php
/* @var $this EntradasalidaController */
/* @var $model Entradasalida */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'idempleado')
)); ?>
    <div class="formWindow">      
     
        <div class="row">
            <?php echo $form->labelEx($model,'ci'); ?>
           <?php echo $form->numberField($model,'ci',array('maxlength'=>12,'min'=>'1','onblur'=>'Entradasalida.validarNumeroCi(this.value)')); ?>
               

</div>
        <div class="row">
            <h3 style="text-align: center" <?php echo 'id="'.System::Id('Hora').'"';?>>    
            

</div>
     
    <?php
    echo System::Buttons(array(
        'nameView' => 'Entradasalida',
        'buttons' => array(

            )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
</div>