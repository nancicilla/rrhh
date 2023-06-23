<?php
/* @var $this PlanillaretroactivoController */
/* @var $model Planillaretroactivo */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'mesinicio')
)); ?>
    <div class="formWindow">
     <?php echo $form->hiddenField($model,'id'); ?>
    	<div class=" alert alert-info">
        <?php
         echo $model->scenario;
        ?>
              <div class="row " <?php echo 'id="'.System::Id('contmensaje').'"';?>>
        </div>
		
	</div>
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Planillaretroactivo',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
