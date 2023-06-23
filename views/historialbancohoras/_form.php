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

       

 
     echo $form->labelEx($model,'idempleado',array('label'=>'Empleado')); 
     $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'empleado',
                'source' => $this->createUrl("movimientopersonal/autocompletePersona"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {
                      
                                     
                                       $('#'+Historialbancohoras.Id('idempleado')).val(ui.item.id);
                                        Historialbancohoras.dameInformacionEmpleado(ui.item.id);
                                        
                                    }"
                ),
                'htmlOptions' => array(
                    'placeholder'=>'Buscar Empleado...',
                    'style' => 'width: 100%;text-transform: uppercase;',
                    
                ),
            ));

        
    
     ?>

  
    </div>



    <div class="row" style="display:none ;" <?php echo 'id="'.System::Id('contenedorHistorialbancohoras').'"';?>>
         <div class="row">
    <?php
          echo $form->label($model, 'fechasolicitud');
             echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechasolicitud',
                    'value' => $model->fechasolicitud,
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
         
?>    </div>

    <div class="row">
    <p>Horas en Banco: <span><strong  <?php echo 'id="'.System::Id('conthoras').'"';?>> </strong></span>  </p>

   
   
</div>
<div class="row">
        <?php echo $form->labelEx($model,'tipo',array('label'=>'Sacar Compensacion por hora?')); ?>
        <?php echo $form->checkBox($model,'tipo',array('onclick'=>'Historialbancohoras.Mostrar(this)')); ?>
   
    </div>
 

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
                        
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 155px;',
                   
                    'onchange' => 'Historialbancohoras.dameFechaMax(this.value)'

                    ),
                    ), true);
         
?>    </div>
   <div class="column" style="display:none;" <?php echo 'id="'.System::Id('ocularfecha').'"';?>>
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
                       
                    
                 
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 155px;',
                        'onchange'=>'Historialbancohoras.damecantHorasPorTomar(this.value)'
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
<div class="row"  style="display:block;"<?php echo 'id="'.System::Id('contenedorhoras').'"';?>>
   <div class="row" <?php echo 'id="'.System::Id('horastrabajador').'"';?>>
       
    </div>
    <div class="column">
        <?php echo $form->labelEx($model,'horainicio',array('label'=>'Hora (Desde)')); ?>
         <div class="column">
    
            <?php echo $form->labelEx($model,'hi',array('label'=>'HH')); ?>
            <?php echo $form->numberField($model,'hi',array('min'=>'0','value'=>'7','data-horario'=>'', 'max'=>'19', 'style'=>'width:35px' ,'onchange'=>'Historialbancohoras.validarHoras()')); ?>
         </div>
        <div class="column">:</div>
            <div class="column">    
              <?php echo $form->labelEx($model,'mi',array('label'=>'MM')); ?>
                <?php echo $form->numberField($model,'mi',array('min'=>'0','value'=>'0','data-horario'=>'', 'max'=>'59' , 'style'=>'width:35px','onchange'=>'Historialbancohoras.validarHoras()')); ?>
            </div>
    </div>
    

    <div class="column" >
            <?php echo $form->labelEx($model,'horafin',array('label'=>'Hora (Hasta)')); ?>
            <div class="column">
                <?php echo $form->labelEx($model,'hs',array('label'=>'HH')); ?>
                <?php echo $form->numberField($model,'hs',array('min'=>'0','value'=>'7','data-horario'=>'', 'max'=>'22' , 'style'=>'width:35px','onchange'=>'Historialbancohoras.MostrarHoras()')); ?>
            </div>
        <div class="column">:</div>
        <div class="column">
           <?php echo $form->labelEx($model,'ms',array('label'=>'MM')); ?>
           <?php echo $form->numberField($model,'ms',array('min'=>'0','value'=>'0','data-horario'=>'', 'max'=>'59' , 'style'=>'width:35px','onchange'=>'Historialbancohoras.MostrarHoras()')); ?>
        </div>
    </div>
</div>
  <div class="row">
    <p><span > Horas por Tomar:</span> <span ><strong <?php echo 'id="'.System::Id('contHorasPorTomar').'"';?>> </strong></span> </p>
</div>




<div class="row">
      <?php echo $form->labelEx($model,'descripcion',array('label'=>'Detalle')); ?>
     
<?php echo $form->textArea($model, 'descripcion', array('maxlength' => 300, 'style'=>'width:95%','style' => 'text-transform: uppercase')); ?>
    
       
    </div>

        
    </div>


 
 <div class="row" style="display:none;" <?php echo 'id="'.System::Id('contenedorMensaje').'"';?>>
    
       
    </div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Historialbancohoras',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
