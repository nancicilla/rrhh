<?php
/* @var $this UnidadController */
/* @var $model Unidad */
/* @var $form CActiveForm 
style='color: #3a87ad;'
*/
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
   
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>60,'style' => 'text-transform: uppercase','placeholder'=>'nombre de la Unidad...')); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'lciudad'); ?>
		<?php echo $form->textField($model,'lciudad',array('maxlength'=>30,'style' => 'text-transform: uppercase')); ?>
	</div>
       
	  <?php echo $form->hiddenField($model, 'idcuenta'); ?>

		<?php echo $form->labelEx($model,'cuenta'); 

		if ($model->scenario=='update') {
			if ($model->idcuenta0!==null) {
               $model->cuenta=str_replace('.','',$model->idcuenta0->numero).' - '. $model->idcuenta0->nombre;
     
            }
            
		}
              


		?>            
<?php
$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'cuenta',
                'source' => $this->createUrl("unidad/autocompleteCuenta"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {
                                        $('#' + Unidad.Id('idcuenta')).val(ui.item.id);
                                      console.log('----->'+Unidad.Id('idcuenta'));
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
        'nameView' => 'Unidad',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
