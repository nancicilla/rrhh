<?php
/* @var $this AreaController */
/* @var $model Area */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">   
	 <div class="row">
             <?php echo $form->hiddenField($model,'id'); ?>
             <?php echo $form->labelEx($model,'pempleado',array('label'=>'Empleado')); ?>
                                  <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'pempleado',
                'source' => $this->createUrl("entradasalida/autocompleteEmpleado"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {    
                          $('#' + Empleado.Id('id')).val(ui.item.id);
                                      
                                    }"
                ),
                'htmlOptions' => array(
                	'placeholder'=>'Empleado',
                    'style' => 'text-transform: uppercase;width:90%',
                    
                ),
                ));         

            ?>

        </div>
        <div class="row">
            
            <div class="column">
               <?php  echo $form->label($model, 'fechadesde',array('label'=>'Desde'));
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
                        'style' => 'width: 150px;'
                    ),
                    ), true);
            ?>
            </div>
            <div class="column">
               <?php  echo $form->label($model, 'fechahasta',array('label'=>'Hasta'));
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
                        'style' => 'width: 150px;'
                    ),
                    ), true);
            ?>
            </div>
        </div>
        
        
   
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Empleado',
        'buttons' => array( 'asistencia' => array(
                'label' => 'Imprimir',
                'click' => 'Empleado.descargaReporteasistenciaempleado()',
                'icon' => 'print',
                'width' => 130,))
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
