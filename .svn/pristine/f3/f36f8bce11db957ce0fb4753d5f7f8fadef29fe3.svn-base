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
                echo $form->labelEx($model,'idempleado',array('label'=>'Empleado')); 
                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'empleado',
                'source' => $this->createUrl("movimientopersonal/autocompletePersona"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {                                        
                                       $('#'+Entradasalida.Id('idempleado')).val(ui.item.id);
                                       
                                        
                                    }"
                ),
                'htmlOptions' => array(
                    'placeholder'=>'Buscar Empleado...',
                    'style' => 'width: 100%;text-transform: uppercase;',
                    
                ),
              ));       
    
            ?>

    </div>
    <div class="row">
        <div class="column">
            <?php
                echo $form->label($model, 'fechadesde',array('label'=>'Desde'));
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
                   

                    ),
                    ), true);
         
            ?> 
        </div>
   <div >
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
                        'maxDate' => 'today',
                    
                 
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 155px;'
                    ),
                    ), true);
          
?>

    </div>
</div>     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Entradasalida',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
