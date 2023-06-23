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
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>60,'style' => 'text-transform: uppercase','onkeyup'=>' Area.Ofuscar(this)','placeholder'=>'Nombre Area...')); ?>
	</div>
     
	<div class="row">
		<?php echo $form->labelEx($model,'sigla'); ?>
		<?php echo $form->textField($model,'sigla',array('maxlength'=>3,'style' => 'text-transform: uppercase')); ?>
	</div>
    
		<div class="row">
		<?php echo $form->labelEx($model,'idunidad'); ?>
		<?php echo $form->dropDownList($model,'idunidad',CHtml::listData(Unidad::model()->findAll(),'id','nombre'),array('empty'=>'')); ?>
	</div>
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
                                        $('#' + Area.Id('idcuenta')).val(ui.item.id);
                                      
                                    }"
                ),
                'htmlOptions' => array(
                    'style' => 'width: 85%;text-transform: uppercase;'
                ),
            ));
                ?>

	</div>
    <div class="row">
        <?php echo $form->labelEx($model,'toleranciaenhorario'); ?>
         <?php  echo $form->checkBox($model,'toleranciaenhorario'); ?>  
     
    </div>
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Area',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
