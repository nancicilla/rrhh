<?php
/* @var $this BonoController */
/* @var $model Bono */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
   
)); ?>
    <div class="formWindow">
    
	<?php echo $mensaje;?>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Bono',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
