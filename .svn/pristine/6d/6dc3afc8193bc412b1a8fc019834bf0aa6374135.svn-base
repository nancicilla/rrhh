<?php
/* @var $this EmpresasubempleadoraController */
/* @var $model Empresasubempleadora */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>100,'style' => 'text-transform: uppercase')); ?>
	</div>
         <div class="row">
		<?php echo $form->labelEx($model,'fee'); ?>
		<?php echo$form->numberField($model,'fee',array('min'=>'0', 'max'=>'50', 'style'=>'width:100px' )); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'impuesto'); ?>
		<?php echo$form->numberField($model,'impuesto',array('min'=>'0', 'max'=>'50', 'style'=>'width:100px' )); ?>
	</div>
        <div class="row">
            <?php echo $form->labelEx($model,'prefacturaindemnizacion'); ?>
            <?php echo $form->checkBox($model,'prefacturaindemnizacion'); ?>

        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'prefacturaprimeraguinaldo'); ?>
            <?php echo $form->checkBox($model,'prefacturaprimeraguinaldo'); ?>

        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'prefacturasegundoaguinaldo'); ?>
            <?php echo $form->checkBox($model,'prefacturasegundoaguinaldo'); ?>

        </div>
        <div class="row">
              <?php echo $form->hiddenField($model, 'cuentacliente'); ?>

		<?php echo $form->labelEx($model,'cliente',array('label'=>'Cuenta Cliente Servicio')); 

		if ($model->scenario=='update') {
			if ($model->cuentacliente0!==null) {
               $model->cliente=str_replace('.','',$model->cuentacliente0->numero).' - '. $model->cuentacliente0->nombre;
     
            }
            
		}
              


		?>   
            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'cliente',
                'source' => $this->createUrl("unidad/autocompleteCuenta"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {
                                        $('#' + Empresasubempleadora.Id('cuentacliente')).val(ui.item.id);
                                      
                                    }"
                ),
                'htmlOptions' => array(
                    'style' => 'width: 85%;text-transform: uppercase;'
                ),
            ));


                ?>
        </div>
        <div class="row">
              <?php echo $form->hiddenField($model, 'cuentaventa'); ?>

		<?php echo $form->labelEx($model,'venta',array('label'=>'Cuenta Venta de Servicio')); 

		if ($model->scenario=='update') {
			if ($model->cuentacliente0!==null) {
               $model->venta=str_replace('.','',$model->cuentaventa0->numero).' - '. $model->cuentaventa0->nombre;
     
            }
            
		}
              


		?>   
            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'venta',
                'source' => $this->createUrl("unidad/autocompleteCuenta"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {
                                        $('#' + Empresasubempleadora.Id('cuentaventa')).val(ui.item.id);
                                      
                                    }"
                ),
                'htmlOptions' => array(
                    'style' => 'width: 85%;text-transform: uppercase;'
                ),
            ));


                ?>
        </div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Empresasubempleadora',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
