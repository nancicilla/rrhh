<?php
/* @var $this PuestotrabajoController */
/* @var $model Puestotrabajo */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
    <div class="row">
	<div class="column">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>60,'style' => 'text-transform: uppercase')); ?>
	</div>
    
	
	</div>
	<div class="row">
		<?php
   if ($model->scenario=='update') {
        echo $form->hiddenField($model, 'idcuenta'); 

    if ($model->idcuenta0!==null) {
              $model->cuenta=str_replace('.','',$model->idcuenta0->numero).' - '. $model->idcuenta0->nombre;
            }
   	}
   	$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'cuenta',
                'source' => $this->createUrl("unidad/autocompleteCuenta"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {
                                        $('#' + Puestotrabajo.Id('idcuenta')).val(ui.item.id);
                                      
                                    }"
                ),
                'htmlOptions' => array(
                    'style' => 'width: 85%;text-transform: uppercase;',
                    'placeholder'=>'Cuenta...'
                ),
            ));
  

		?>
	</div>
	<div class="row">
	  <div class="column">
	<?php echo $form->labelEx($model,'idunidad',array('label'=>'Unidad')); ?>
	<div  id="contu">
		
		<?php echo $form->dropDownList($model,'idunidad',CHtml::listData(Unidad::model()->findAll(),'id','nombre'),array('empty'=>'','onchange'=>'Puestotrabajo.listaArea(this.value,Puestotrabajo.Id("area"),Puestotrabajo.Id("idseccion"),1)'));?>
	</div>
    </div>
    <div class="column">
	<?php echo $form->labelEx($model,'area',array('label'=>'Area')); ?>
	<div  id="conta">
		
		<?php echo $form->dropDownList($model,'area',CHtml::listData(Area::model()->findAll(),'id','nombre'),array('empty'=>'','onchange'=>'Puestotrabajo.listaSeccion(Puestotrabajo.Id("unidad"),this.value,Puestotrabajo.Id("idseccion"))'));?>
	</div>
    </div>
    </div>
    <div class="row">
	<div class="column">
		<?php echo $form->labelEx($model,'idseccion'); ?>
		<?php echo $form->dropDownList($model,'idseccion',CHtml::listData($secciones,'id','nombre'),array('empty'=>'')); ?>
	</div>
        <div class="column">
		<?php echo $form->labelEx($model,'clasificacionlaboral'); ?>
		<?php      

            echo $form->numberField($model,'clasificacionlaboral',array('step'=> '1',"min"=>"1",'placeholder'=>'Clasificacion Laboral Ministerio'));
        ?>
	</div>
	 
	</div>
	<div class="row">

		
	</div>

    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Puestotrabajo',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
