<?php
/* @var $this CuentahaberController */
/* @var $model Cuentahaber */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'idcuenta')
)); ?>
    <div class="formWindow">
    
	 <div class="row">
      <?php echo $form->hiddenField($model, 'idcuenta'); ?>

        <?php echo $form->labelEx($model,'cuenta',array('label'=>'Cuenta Planilla')); 

          
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
                                        $('#' + Cuentahaber.Id('idcuenta')).val(ui.item.id);
                                      
                                    }"
                ),
                'htmlOptions' => array(
                    'style' => 'width: 85%;text-transform: uppercase;'
                ),
            ));
                ?>

    </div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textArea($model, 'descripcion', array('maxlength' => 300)); ?>
	</div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Cuentahaber',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
