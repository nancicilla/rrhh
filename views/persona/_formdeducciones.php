<?php
/* @var $this PersonaController */
/* @var $model Persona */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
   
    'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
     <div class="formWindow">
       
        <div class="row">
        <?php echo $form->labelEx($modeld,'iddeducciones', array('label' => 'Deducción' )); ?>
        <?php echo $form->dropDownList($modeld,'iddeducciones',CHtml::listData(Deducciones::model()->findAll('t.porfucion=false and esagrupador=false'),'id','nombre'),array('empty'=>'','style'=>'Width:90%')); ?>
    </div>
      
     
    <div class="row">

    <div class="column">
        <?php
       
                echo $form->label($modeld, 'fechar', array('label' => 'Fecha' ));
                echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $modeld,
                    'attribute' => 'fechar',
                    
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 155px;',
                        
                    ),
                    ), true);
        ?>
    </div>
 
    </div>

     <div class="row">    
        <?php echo $form->labelEx($modeld,'monto',array('label'=>'Monto')); ?>
        <?php echo $form->numberField($modeld,'monto',array('min'=>'10','value'=>'10' )); ?>
    </div>
    

    




    <div class="row">
        <?php echo $form->labelEx($modeld,'descripcion'); ?>
        <?php echo $form->textArea($modeld,'descripcion',array('col'=>3,'rows' => 3,'style'=>'Width:90%')); ?>
    </div>
      
    <?php
    echo System::Buttons(array(
        'nameView' => 'Persona',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget();  ?>



</div><!-- form -->
