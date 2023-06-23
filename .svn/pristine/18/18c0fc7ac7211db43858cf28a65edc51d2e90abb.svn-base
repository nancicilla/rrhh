<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('style' => 'text-transform: uppercase')); ?>
	</div>
     <div class="row">
        <?php echo $form->labelEx($model,'esagrupador'); ?>
         <?php echo $form->checkBox($model,'esagrupador',array('onchange'=>'Deducciones.mostrar()')); ?>  
     
    </div>
    <div style="display:<?php  if ($model->esagrupador==false){echo'display-block';}else{echo'none;';}?>" <?php echo 'id="'.System::Id('contenedorAgrupador').'"';?>>
     <div class="row">
        <?php echo $form->labelEx($model,'mostrardetallado',array('label'=>'Mostrar Detallado')); ?>
         <?php  echo $form->checkBox($model,'mostrardetallado'); ?>  
     
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
                                        $('#' + Deducciones.Id('idcuenta')).val(ui.item.id);
                                      
                                    }"
                ),
                'htmlOptions' => array(
                    'style' => 'width: 85%;text-transform: uppercase;'
                ),
            ));
                ?>

    </div>
     <div class="row">
        <?php echo $form->labelEx($model,'porfucion',array('label'=>'Calculo por Funcion?')); ?>
         <?php echo $form->checkBox($model,'porfucion'); ?>  
     
    </div>
    
   
    

        <?php echo $form->labelEx($model,'iddeduccionpadre',array('label'=>'Agrupar en...')); ?>
        <?php echo $form->dropDownList($model,'iddeduccionpadre',CHtml::listData(Deducciones::model()->findAll('t.esagrupador=true'),'id','nombre'),array('empty'=>'')); ?>
    </div>
      
    <div class="row">
        <?php
        if ($model->scenario=='update') {
            echo $form->labelEx($model,'estado',array('label'=>'Vigente?')); 
        echo $form->checkBox($model,'estado');
        }
           ?>  
     
    </div>