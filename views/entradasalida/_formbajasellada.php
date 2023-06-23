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
            <?php echo $form->radioButton($model,'evento',array('value'=>'E','uncheckValue'=>null)) . 'Entrada'; ?>

            <?php echo $form->radioButton($model,'evento',array('value'=>'S','uncheckValue'=>null)) . 'Salida'; ?>

                
               

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