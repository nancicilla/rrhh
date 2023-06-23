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
               <?php  echo $form->label($model, 'fechadesde',array('label'=>'Fecha'));
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
           
        </div>
        <div class="row" >
            <?php echo $form->labelEx($model,'area',array('label'=>'Area')); ?>
            <?php
              $this->widget('ext.select2.ESelect2', array(
                'id' => 'area',
                'name' => 'area',
                'value' => $lareas,
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
         <div class="row" >
            <?php echo $form->labelEx($model,'tipocontrato',array('label'=>'Contratos')); ?>
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
                'click' => 'Empleado.descargaReporteAntiguedadPersonal()',
                'icon' => 'print',
                'width' => 130,))
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
