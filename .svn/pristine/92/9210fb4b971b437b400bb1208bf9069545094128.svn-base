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
      <?php
   echo $form->labelEx($model,'fechaparametro', array('label' => 'Fecha' )); 
     echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechaparametro',
                    'value' => $model->fechaparametro,
                    'language' => 'es',                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'maxDate'=>date('d-m-Y'),
                        'minDate'=>$fechaminima
              
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;',
                        'onchange'=>'Entradasalida.dameHorarioEmpleadoF(this.value)',
                       
                    ),
                    ), true);

      ?>
        <div class="">       
        <?php echo $form->hiddenField($model,'idempleado'); ?>
    <?php
    if ($model->scenario!='update') {
     echo $form->labelEx($model,'idempleado',array('label'=>'Empleado')); 
     $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'empleado',
                'source' => $this->createUrl("movimientopersonal/autocompletePersona"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {
                        var fecha=$('#'+Entradasalida.Id('fechaparametro')).val();
                                        $('#' + Entradasalida.Id('idempleado')).val(ui.item.id);
                                    //  Movimientopersonal.dameInfoE(ui.item.id);
                                      if(fecha.length>0){
                                        Entradasalida.dameHorarioEmpleado(ui.item.id,fecha);
                                        }else{
                                             $('#'+Entradasalida.Id('contenedorHorario')).html('DEBE SELECCIONAR UNA FECHA...');

                                        }
                                    }"
                ),
                'htmlOptions' => array(
                    'placeholder'=>'Buscar Empleado...',
                    'style' => 'width: 100%;text-transform: uppercase;',
                    
                ),
            ));
     ?>

    <?php
        }
    ?>
    </div>
    <div class="row">
        <div class="column">
            <div class="row">
                   <div class="column">
        <?php echo $form->labelEx($model,'hi',array('label'=>'Hora ')); ?>
    <div class="column">
    
        <?php echo $form->labelEx($model,'hi',array('label'=>'HH')); ?>
        <?php echo $form->numberField($model,'hi',array('min'=>'0','max'=>'23', 'style'=>'width:35px' )); ?>
    </div>
    <div class="column">:</div>
    <div class="column">    
        <?php echo $form->labelEx($model,'mi',array('label'=>'MM')); ?>
        <?php echo $form->numberField($model,'mi',array('min'=>'0', 'max'=>'59' , 'style'=>'width:35px')); ?>
    </div>
    </div>

            </div>
        </div> 
        <div class="column">
             <div class="row alert alert-info" <?php echo 'id="'.System::Id('contenedorHorario').'"';?>>
        
    </div>

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
