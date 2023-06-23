<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    
)); ?>
    <div class="formWindow">
<div class="row">
      <?php echo $form->labelEx($model,'conconstancia',array('label'=>'Tiene Constancia ?')); ?>
     <?php echo $form->checkBox($model,'conconstancia'); ?> 
       
    </div>       
  
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Permiso',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->

