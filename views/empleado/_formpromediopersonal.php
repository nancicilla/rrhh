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
                        'maxDate'=>$fechamaxima      
                    
              
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
                        'maxDate'=>$fechamaxima
              
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                    ),
                    ), true);
            ?>
            </div>
        </div>
        
         <div class="row" >
            <?php echo $form->labelEx($model,'tipocontrato',array('label'=>'Tipo Contrato')); ?>
            <?php
              $this->widget('ext.select2.ESelect2', array(
                'id' => 'tipocontrato',
                'name' => 'tipocontrato',
                'value' => $ltipocontratos,
                'data' => CHtml::listData(Tipocontrato::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'),
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
        'nameView' => 'Empleado',
        'buttons' => array( 'reporte' => array(
                'label' => 'Descargar Reporte',
                'click' => 'Empleado.descargaReportePromedioPersonal()',
                'icon' => 'print',
                'width' => 130,))
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
