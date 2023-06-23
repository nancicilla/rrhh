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
        <?php echo $form->labelEx($modelp,'idtipopermiso'); ?>
        <?php echo $form->dropDownList($modelp,'idtipopermiso',CHtml::listData(Tipopermiso::model()->findAll(array('order'=>'nombre')),'id','nombre'),array('empty'=>'','style'=>'Width:90%')); ?>
    </div>
       <div class="row">
        <?php echo $form->labelEx($modelp,'tipo',array('label'=>'Sacar permiso por hora?')); ?>
        <?php echo $form->checkBox($modelp,'tipo',array('onclick'=>'Persona.Mostrar(this)')); ?>
        <?php echo $form->hiddenField($model,'id'); ?>
    </div>  
    <div class="row">

    <div class="column">
        <?php
       
                echo $form->label($modelp, 'fechai', array('label' => 'Fecha' ));
                echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $modelp,
                    'attribute' => 'fechai',
                    'value' => $modelp->fechai,
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'minDate'=>$fechaminima
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 155px;',
                        'onchange'=>'Persona.validarfechai(this.value)'
                    ),
                    ), true);
        ?>
    </div>
    <div class="column" style="display:none;" <?php echo 'id="'.System::Id('ocularfecha').'"';?>>
        <?php

 echo $form->label($modelp, 'fechaf');
                echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $modelp,
                    'attribute' => 'fechaf',
                    'value' => $modelp->fechaf,
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
                        'onchange'=>'Persona.validarfechaf(this.value)'
                    ),
                    ), true);
        ?>
    </div>
    </div>

    <div class="row"  style="display:block;"<?php echo 'id="'.System::Id('conthoras').'"';?>>
   <div class="row" <?php echo 'id="'.System::Id('horastrabajador').'"';?>>
       
    </div>


    <div class="column">
        <?php echo $form->labelEx($modelp,'horai',array('label'=>'Hora (Desde)')); ?>
    <div class="column">
    
        <?php echo $form->labelEx($modelp,'hi',array('label'=>'HH')); ?>
        <?php echo $form->numberField($modelp,'hi',array('min'=>'0','value'=>'7', 'max'=>'19', 'style'=>'width:35px','data-horario'=>'' ,'onchange'=>'Persona.validarHoras()')); ?>
    </div>
    <div class="column">:</div>
    <div class="column">    
        <?php echo $form->labelEx($modelp,'mi',array('label'=>'MM')); ?>
        <?php echo $form->numberField($modelp,'mi',array('min'=>'0','value'=>'0', 'max'=>'59' , 'style'=>'width:35px','data-horario'=>'','onchange'=>'Persona.validarHoras()')); ?>
    </div>
    </div>
    

    <div class="column" >
        <?php echo $form->labelEx($modelp,'horaf',array('label'=>'Hora (Hasta)')); ?>
    <div class="column">
    
        <?php echo $form->labelEx($modelp,'hs',array('label'=>'HH')); ?>
        <?php echo $form->numberField($modelp,'hs',array('min'=>'0','value'=>'7', 'max'=>'22' , 'style'=>'width:35px','data-horario'=>'','onchange'=>'Persona.validarHoras()')); ?>
    </div>
    <div class="column">:</div>
    <div class="column">
    
        <?php echo $form->labelEx($modelp,'ms',array('label'=>'MM')); ?>
        <?php echo $form->numberField($modelp,'ms',array('min'=>'0','value'=>'0', 'max'=>'59' , 'style'=>'width:35px','data-horario'=>'','onchange'=>'Persona.validarHoras()')); ?>
    </div>
    </div>
    </div>




    <div class="row">
        <?php echo $form->labelEx($modelp,'descripcion'); ?>
        <?php echo $form->textArea($modelp,'descripcion',array('col'=>3,'rows' => 3,'style'=>'Width:90%','style' => 'text-transform: uppercase')); ?>
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
