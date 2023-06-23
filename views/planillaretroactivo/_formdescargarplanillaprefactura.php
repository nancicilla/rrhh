<?php
/* @var $this PlanillaretroactivoController */
/* @var $model Planillaretroactivo */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'mesinicio')
)); ?>
    <div class="formWindow">
       <?php echo $form->hiddenField($model,'id'); ?>
	   <div class="row"   <?php echo 'id="'.System::Id('contenedorTipocContrato').'"';?>>
            <?php echo $form->labelEx($model,'tipocontrato',array('label'=>'Tipo Contrato')); ?>
            <?php
              $this->widget('ext.select2.ESelect2', array(
                'id' => 'tipocontratos',
                'name' => 'tipocontratos',
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
    <div class="row"   <?php echo 'id="'.System::Id('contenedorEmpresas').'"';?>>
            <?php echo $form->labelEx($model,'empresa',array('label'=>'Empresas ')); ?>
            <?php
              $this->widget('ext.select2.ESelect2', array(
                'id' => 'empresas',
                'name' => 'empresas',
                'value' => $listaempresas,
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
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Planillaretroactivo',
        'buttons' => array( 'descargar' => array(
                            'label' => 'Descargar Excel',
                            'click' => 'Planillaretroactivo.descargarExcelPlanillaprefactura()',
                            'icon' => 'download-alt',
                            'width' => 130,))
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
