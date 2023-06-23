<?php
/* @var $this BonosController */
/* @var $model Bonos */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    
)); ?>
    <div class="formWindow" id="pl">
   
    <?php echo $form->hiddenField($model,'ci'); ?>
    <div class="row">
		<?php echo $form->labelEx($model,'idplanilla'); ?>
		<?php echo $form->dropDownList($model,'idplanilla',CHtml::listData($planillas,'id','gestion'),array('empty'=>'')); ?>
	</div>
   

    </div>
    <?php
   echo System::Buttons(array(
        'nameView' => 'Persona',
        'buttons' => array(

                        'planillas' => array(
                            'label' => 'Imprimir Boleta',
                            'click' => 'Persona.descargarBoletaEmpleado()',
                            'icon' => 'print',
                            'width' => 130,)
            )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
