   
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>100,'style' => 'text-transform: uppercase;width:85%;')); ?>
	</div>
	<div class="row">
	<div class="column">
		<?php echo $form->labelEx($model,'esagrupador'); ?>
		<?php  echo $form->checkBox($model,'esagrupador',  array('onchange' =>'Aportacionbeneficio.bloquear()'  )); ?>  
	</div>
	<div class="column" style="display:<?php  if ($model->esagrupador==false){echo'display-block';}else{echo'none;';}?>" <?php echo 'id="'.System::Id('contenedorAgrupador').'"';?>>

		<?php echo $form->labelEx($model,'idaportacionbeneficiopadre'); ?>
		<?php echo $form->dropDownList($model,'idaportacionbeneficiopadre',CHtml::listData(Aportacionbeneficio::model()->findAll('t.esagrupador=true'),'id','nombre'),array('empty'=>'')); ?>
	</div>
	 </div>
		 <div class="row" style="display:<?php  if ($model->esagrupador==false){echo'display-block';}else{echo'none;';}?>" <?php echo 'id="'.System::Id('contenedorAgrupador1').'"';?>>


	
	
	<div class="row">
	  <?php echo $form->hiddenField($model, 'idcuenta'); ?>

		<?php echo $form->labelEx($model,'cuenta'); 

		if ($model->scenario=='update') {
			if ($model->idcuenta0!==null) {
              $model->cuenta=str_replace('.','',$model->idcuenta0->numero).' - '.$model->idcuenta0->nombre;
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
                                        $('#' + Aportacionbeneficio.Id('idcuenta')).val(ui.item.id);
                                      
                                    }"
                ),
                'htmlOptions' => array(
                    'style' => 'width: 85%;text-transform: uppercase;'
                ),
            ));
                ?>

	</div>
	
	
        <div class="row">
	<div class="column">
		<?php echo $form->labelEx($model,'porcentaje',array('label'=>'Porcentaje <br> Intervalos(<small>rango_inicial</small>-<small>rango_final</small>,<small>valor_porcentaje</small>;) '));  ?>
		<?php echo $form->textField($model,'porcentaje',array('maxlength'=>100,'style' => 'text-transform: uppercase;width:95%;height:auto;','placeholder'=>'Ej. Intervalos:13000-25000,1;')); ?>
	</div>
	<div class="column">
	
		<?php
		echo "<br>"; 
		echo $form->labelEx($model,'orden',array('label'=>'Orden')); ?>
		<?php echo $form->numberField($model,'orden',array('min'=>'1',  'style'=>'width:95%' )); ?>
	</div>
 
    <div >
		<?php
		echo $form->hiddenField($model,'tipo');
		 /*echo $form->dropDownList($model,'tipo',Chtml::listData(array(array('id'=>1,'nombre'=>'VACACIÓN'),array('id'=>2,'nombre'=>'BONO'),array('id'=>3,'nombre'=>'APORTE IMPOSITIVO'),array('id'=>4,'nombre'=>'APORTE CONSENSUADO')),'id','nombre'),array('style' => 'text-transform: uppercase;width:85%;')); */?>
	</div>
	</div>
	<div class="row">
	<div class="column">
		<?php  echo $form->labelEx($model,'enplanilla',array('label'=>'Se muestra en  planilla de Sueldos y Salarios?')); ?>
		<?php echo $form->checkBox($model,'enplanilla'); ?>
	</div>
    <div class="column">
		<?php echo $form->labelEx($model,'estado',array('label'=>'Habilitado?')); ?>
		<?php echo $form->checkBox($model,'estado'); ?>
	</div>
	
</div>
	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textArea($model,'descripcion',array('rows'=>3, 'cols'=>15,'style' => 'text-transform: uppercase;width:95%'));?>
	</div>
    </div>
	
    