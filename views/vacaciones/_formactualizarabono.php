<?php
/* @var $this VacacionesController */
/* @var $model Vacaciones */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    
)); ?>
    <div class="formWindow">
        
       <div class="row">       
        <?php 
          echo $form->hiddenField($model,'idempleado'); 
          echo $form->hiddenField($model,'id'); 
          echo $form->hiddenField($model,'tipo'); 
         
    
     ?>

  
    </div>
 
<div class="row">
		<?php echo $form->labelEx($model,'diasabono',array('label'=>'Dias')); ?>
		<?php      

            echo $form->numberField($model,'diasabono',array('step'=> '0.001',"min"=>"0.100",  'style' => 'width: 55px;'));
        ?>
	</div>


    <div class="row">
        <?php echo $form->labelEx($model,'observacion',array('label'=>'Detalle')); ?>
     
        <?php echo $form->textArea($model, 'observacion', array('maxlength' => 300, 'style'=>'width:95%','style' => 'text-transform: uppercase')); ?>
    
       
    </div>
 
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Vacaciones',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
