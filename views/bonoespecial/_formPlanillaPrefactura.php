<?php
/* @var $this BonosController */
/* @var $model Bonos */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    
)); ?>
       <?php echo $form->hiddenField($model,'id'); ?>
     <div class="row"  <?php echo 'id="'.System::Id('contenedorEmpresasubempleadora').'"';?>>
            <?php echo $form->labelEx($model,'empresasubempleadora',array('label'=>'Empresas Sub Empleadoras')); ?>
            <?php
              $this->widget('ext.select2.ESelect2', array(
                'id' => 'empresasubempleadora',
                    'name' => 'empresasubempleadora',
                'value' => $lempresasubempleadora,
                'data' => CHtml::listData(Empresasubempleadora::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'),
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
   
    <div class="row"  <?php echo 'id="'.System::Id('contenedorMensaje').'"';?>></div>
   
  
 
    <?php
   echo System::Buttons(array(
        'nameView' => 'Bonoespecial',
        'buttons' => array(

                        'planillas' => array(
                            'label' => 'Descargar Excel',
                            'click' => 'Bonoespecial.descargarExcelPrefactura()',
                            'icon' => 'download-alt',
                            'width' => 130,)
            )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
