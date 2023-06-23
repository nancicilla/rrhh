<?php
/* @var $this HistorialestadoempleadoController */
/* @var $model Historialestadoempleado */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'id')
)); ?>
    <div class="formWindow">
    	<div class="row">
		<?php echo $form->labelEx($model,'Desde'); ?>
		<?php echo  $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fecha',
                    'value' => $model->fecha,
                    'language' => 'es',                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                         'maxDate'=>'today',
                        'minDate'=>$fecha
              
                    ),
                    'htmlOptions' => array(
                       'data-v'=>''
                    ),
                    ), true); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'fechavacacion',array('label'=>'Hasta')); ?>
		<?php  echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechavacacion',
                    'value' => $model->fechavacacion,
                    'language' => 'es',                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                         'maxDate'=>'today',
                        'minDate'=>$fecha
              
                    ),
                    'htmlOptions' => array(
                       'data-v'=>''
                    ),
                    ), true); ?>
	</div>
   
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Historialestadoempleado',
        'buttons' => array(
               'planilla' => array(
                'label' => 'Descargar Reporte',
                'click' => 'Historialestadoempleado.ReporteIngresoRetiroEmpleado()',
                'icon' => 'download-alt',
                'width' => 130,)
        )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
