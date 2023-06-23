<?php
/* @var $this PersonaController */
/* @var $model Persona */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
    ));
    ?>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <div class="formWindow">
        <div class="row">
              <?php echo $form->hiddenField($model,'id'); ?>
            <?php echo $form->label($model, 'nombre'); ?>
            <?php
            echo $form->textArea($model, 'nombre', array('maxlength' => 300, 'cols' => 4));
            ?>
        </div>
        
   


        <div class="row">

         <div  <?php echo 'id="'.System::Id('contenedorListaDeducciones').'"';?>>
  <?php echo $this->renderPartial('listaempleado', array('lista' => $modeleb), true); ?>
    </div>
               <h5 style="position: absolute; left: 12px; top: 450px;">Total
    <span class="badge" <?php echo 'id="'.System::Id('spanTotalBono').'"';?>  style="font-size: 18px; font-weight: bold;  color: black;"> <?php echo $total;?> Bs.</span> 
</h5>
        </div>
        

   <div style=" position: absolute; left: 30px; top: 420px !important;" ><span><img src="protected/modules/rrhh/images/excel1.png"   width="32" height="32"> </span></div>
                      
<div class="row" style="position: absolute; left: 60px; top: 420px;">

<div  <?php echo 'id="'.System::Id('fileExcel').'"';?>>

</div>
     
    </div>   
            <?php
            echo System::Buttons(array(
                'nameView' => 'Persona',
                'buttons' => array()
            ));
            ?> 
            <?php $this->endWidget(); ?>



</div><!-- form -->
