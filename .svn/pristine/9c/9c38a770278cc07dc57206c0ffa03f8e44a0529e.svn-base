<?php
/* @var $this NivelsalarialController */
/* @var $model Nivelsalarial */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>30,'style' => 'text-transform: uppercase')); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'sueldo'); ?>
		<?php
        $valor=Configuracion::model()->find('t.id=2')->valor; 
         if ( $model->scenario=='create') {
            echo $form->numberField($model,'sueldo',array('min'=> $valor,'value'=> $valor));
         }else{

            echo $form->numberField($model,'sueldo',array('min'=> $valor));
         }
        


         ?>
	</div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Nivelsalarial',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
