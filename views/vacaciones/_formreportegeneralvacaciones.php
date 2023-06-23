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
                        'dateFormat' => 'dd-mm-yy',
                        
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 155px;',
                   

                    ),
                    ), true);
         
?>    </div>
       <div class="row" >
            <?php echo $form->labelEx($model,'area',array('label'=>'Areas')); ?>
            <?php
              $this->widget('ext.select2.ESelect2', array(
                'id' => 'area',
                'name' => 'area',
                'value' => $listaareas,
                'data' => CHtml::listData(Area::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'),
                'htmlOptions' => array(
                    'multiple' => 'multiple',
                    'style' => 'width:100%;'
                ),
                'options' => array(
                    'placeholder' => 'Seleccione...',
                    'allowClear' => true,
                ),
            ));
            ?>
   
    </div>

     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Vacaciones',
        'buttons' => array(
             'reportePDF' => array(
                            'label' => 'ImprimirPDF',
                            'click' => 'Vacaciones.descargarReporteVacacionPDF()',
                            'icon' => 'print',
                            'width' => 130,),
             'reporteXLS' => array(
                            'label' => 'ImprimirXLS',
                            'click' => 'Vacaciones.descargarReporteVacacionXLS()',
                            'icon' => 'print',
                            'width' => 130,)
        )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
