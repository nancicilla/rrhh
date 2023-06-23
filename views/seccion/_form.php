<?php
/* @var $this SeccionController */
/* @var $model Seccion */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
    <div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>40,'style' => 'text-transform: uppercase','onkeyup'=>'Area.sugerirSigla(this.value)')); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'sigla'); ?>
		<?php echo $form->textField($model,'sigla',array('maxlength'=>4,'style' => 'text-transform: uppercase')); ?>
	</div>
    
	
   	<div class="row">
		<?php echo $form->labelEx($model,'unidad'); ?>
		<?php echo $form->dropDownList($model,'unidad',CHtml::listData(Unidad::model()->findAll(),'id','nombre'),array('empty'=>'','onchange'=>'Seccion.listaArea(this.value,Seccion.Id("idarea"))')); ?>
	</div>
    	<div class="row">
	<?php echo $form->labelEx($model,'idarea'); ?>
	<div  id="conta">
		
		<?php echo $form->dropDownList($model,'idarea',CHtml::listData(Area::model()->findAll(),'id','nombre'),array('empty'=>''))?>
	</div>
    </div>
	  <div class="row">
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
                                        $('#' + Seccion.Id('idcuenta')).val(ui.item.id);
                                      
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
        'nameView' => 'Seccion',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
