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
          echo '<strong>Empleado:</strong>'.$model->idempleado0->idpersona0->apellidop." ".$model->idempleado0->idpersona0->apellidom." ".$model->idempleado0->idpersona0->nombre."<br>";
        
    
     ?>

  
    </div>



    <div class="row"  <?php echo 'id="'.System::Id('contenedorVacaciones').'"';?>>


 

</div>



    <?php

    if (boolval( $model->tipo)) {
    ?>
     <div class="row">
    <?php
          echo $form->label($model, 'fechadesde',array('label'=>'Fecha'));
             echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechadesde',
                    'value' => $model->fechadesde,
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy'
                        
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 155px;',
                   
                   'onchange' => 'Trabajosexternos.dameHoras(this.value)'

                    ),
                    ), true);
         
?>    </div>
<h6>Horario</h6>
    <div class="row" >
       
        <div class="row" <?php echo 'id="'.System::Id('contHorario').'"';?>>
        <?php
        echo $horario;
        ?>
            
        </div>
        
    </div>

    <div class="row"  style="display:block;"<?php echo 'id="'.System::Id('conthoras').'"';?>>
   <div class="row" <?php echo 'id="'.System::Id('horastrabajador').'"';?>>
       
    </div>


    <div class="column">
        <?php echo $form->labelEx($model,'horainicio',array('label'=>'Hora (Desde)')); ?>
    <div class="column">
    
        <?php echo $form->labelEx($model,'hi',array('label'=>'HH')); ?>
        <?php 
         $i=$intervalohoras[0]["hi"];
        echo $form->numberField($model,'hi',array('min'=>'0','data-horario'=>$i, 'max'=>'19', 'style'=>'width:35px' ,'onchange'=>'Trabajosexternos.validarHoras()')); ?>
    </div>
    <div class="column">:</div>
    <div class="column">    
        <?php echo $form->labelEx($model,'mi',array('label'=>'MM')); ?>
        <?php
         $i=$intervalohoras[0]["mi"];
         echo $form->numberField($model,'mi',array('min'=>'0','data-horario'=>$i, 'max'=>'59' , 'style'=>'width:35px','onchange'=>'Trabajosexternos.validarHoras()')); ?>
    </div>
    </div>
    

    <div class="column" >
        <?php echo $form->labelEx($model,'horafin',array('label'=>'Hora (Hasta)')); ?>
    <div class="column">
    
        <?php echo $form->labelEx($model,'hs',array('label'=>'HH')); ?>
        <?php
         $s=$intervalohoras[0]["hs"];
         echo $form->numberField($model,'hs',array('min'=>'0','data-horario'=>$s, 'max'=>'22' , 'style'=>'width:35px','onchange'=>'Trabajosexternos.validarHoras()')); ?>
    </div>
    <div class="column">:</div>
    <div class="column">
    
        <?php echo $form->labelEx($model,'ms',array('label'=>'MM')); ?>
        <?php
         $s=$intervalohoras[0]["ms"]; 
        echo $form->numberField($model,'ms',array('min'=>'0','data-horario'=>$s, 'max'=>'59' , 'style'=>'width:35px','onchange'=>'Trabajosexternos.validarHoras()')); ?>
    </div>
    </div>
    </div>
 

    <?php
    
    }else{

?>


<div class="row">
    <div class="column">
    <?php
          echo $form->label($model, 'fechadesde',array('label'=>'Fecha'));
             echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechadesde',
                    'value' => $model->fechadesde,
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
              

                    ),
                    ), true);
         
?>    </div>
   <div class="column"  <?php echo 'id="'.System::Id('ocularfecha').'"';?>>
         <?php
         echo $form->label($model, 'fechahasta');
         echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechahasta',
                    'value' => $model->fechahasta,
                    'language' => 'es',                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'minDate'=>$model->fechadesde             
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 155px;',
                    ),
                    ), true);
          
?>

    </div>
</div>
<h6>Horario</h6>
    <div class="row" >
       
        <div class="row" <?php echo 'id="'.System::Id('contHorario').'"';?>>
            
        </div>
        
    </div>
   


<?php
    }

    ?>


<div class="row">
      <?php echo $form->labelEx($model,'descripcion',array('label'=>'Detalle')); ?>
     
<?php echo $form->textArea($model, 'descripcion', array('maxlength' => 300, 'style'=>'width:95%','style' => 'text-transform: uppercase')); ?>
    
       
    </div>
 
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Trabajosexternos',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
