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
         
?>    </div>
  
 <div class="column">
    <?php
          echo $form->label($model, 'fechahasta',array('label'=>'Hasta'));
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
                   

                    ),
                    ), true);
         
?>    </div>
   
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Vacaciones',
        'buttons' => array(
             'reporte' => array(
                            'label' => 'Imprimir',
                            'click' => 'Vacaciones.descargarReporteVacaciones()',
                            'icon' => 'print',
                            'width' => 130,)
        )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
