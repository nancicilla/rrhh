<?php
/* @var $this BonosController */
/* @var $model Bonos */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    
)); ?>
    <div class="formWindow" id="pl">
    <div class="row">
        <div class="column">
            <?php echo $form->hiddenField($model,'id'); ?>
            <?php echo $form->labelEx($model,'opciones'); ?>
            <?php echo $form->dropDownList($model,'opciones',CHtml::listData(array(array('id'=>0,'nombre'=>''),array('id'=>1,'nombre'=>'Planilla Aguinaldo Impresion'),array('id'=>2,'nombre'=>'Planilla Aguinaldo Ministerio'), ),'id','nombre')); ?> 

        </div>
       
    </div>


</div>

    <div class="row"   <?php echo 'id="'.System::Id('contenedorTipocContrato').'"';?>>
            <?php echo $form->labelEx($model,'tipocontrato'); ?>
            <?php
              $this->widget('ext.select2.ESelect2', array(
                'id' => 'tipocontratos',
                'name' => 'tipocontratos',
                'value' => $listatipocontrato,
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
  
<div class="row" <?php echo 'id="'.System::Id('contenedorMensaje').'"';?>>
        
    </div>
    <?php
   echo System::Buttons(array(
        'nameView' => 'Pagobeneficio',
        'buttons' => array(

                        'planillas' => array(
                            'label' => 'Descargar Excel',
                            'click' => 'Pagobeneficio.descargarExcelPlanilla()',
                            'icon' => 'download-alt',
                            'width' => 130,)
            )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
