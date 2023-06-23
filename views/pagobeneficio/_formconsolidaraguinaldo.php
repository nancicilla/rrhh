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
<?php echo $form->hiddenField($model,'id'); ?>
<div class="row alter alert-info">
    <strong class="text-info">Desea Consolidar el Aguinaldo ?</strong>
	</div>
  

    
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
