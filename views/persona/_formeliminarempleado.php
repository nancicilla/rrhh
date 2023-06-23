<?php
/* @var $this PersonaController */
/* @var $model Persona */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
  
)); ?>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
     <div class="formWindow">
        <div class="row alert alert-info">   
    
       <?php echo $form->hiddenField($model,'id'); ?>
            <h5>
                Desea Eliminar a "<?php echo $model->nombrecompleto;?>"
            </h5>
        
    </div>
  
    </div>   
    <?php
    echo System::Buttons(array(
        'nameView' => 'Persona',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget();  ?>



</div><!-- form -->
