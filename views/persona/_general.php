
<div class="row" >
  <div class="column">
    <?php echo $form->labelEx($model,'unidad',array('label'=>'Unidad')); ?>
    <div  id="contu">
        
        <?php echo $form->dropDownList($model,'unidad',CHtml::listData(Unidad::model()->findAll(),'id','nombre'),array('empty'=>'','onchange'=>'Puestotrabajo.listaArea(this.value,Persona.Id("area"),Persona.Id("seccion"),Persona.Id("idpuestotrabajo"))'));?>
    </div>
    </div>
 <div class="column">
	<?php echo $form->labelEx($model,'area'); ?>
	<div  id="conta">
		
		<?php echo $form->dropDownList($model,'area',CHtml::listData($areas,'id','nombre'),array('empty'=>'','onchange'=>'Puestotrabajo.listaSeccion(Persona.Id("unidad"),this.value,Persona.Id("seccion"))'));?>
	</div>
    </div>
    <div class="column">
		<?php echo $form->labelEx($model,'seccion',array('label'=>'Sección')); ?>
		<?php 

        echo $form->dropDownList($model,'seccion',CHtml::listData($secciones,'id','nombre'),array('empty'=>'','onchange'=>'Persona.listaPuestotrabajo(this.value,Persona.Id("idpuestotrabajo"))')); ?>
	</div>
        <div class="column">
    <?php echo $form->labelEx($model,'idpuestotrabajo',array('label'=>'Nuevo Puesto de Trabajo')); ?>
    <div  id="conta">
        
        <?php echo $form->dropDownList($model,'puestoactual',CHtml::listData($puestotrabajos,'id','nombre'),array('empty'=>''));?>
    </div>
    </div>
    </div>
    <div class="row">
	     <div class="column">
        <?php echo $form->labelEx($model,'tipocontrato',array('label'=>'Contrato')); 
        
        echo $form->dropDownList($model,'tipocontrato',CHtml::listData(Tipocontrato::model()->findAll(),'id','nombre'),array('empty'=>'')); 
        ?>
      
    </div> 
	



	 <div class="column" style="width: 50%;">
        <?php echo $form->label($model, 'nivelsalarialid',array('label'=>'Nivel Salarial')); ?>

        <?php echo $form->hiddenField($model,'nivelsalarialid'); ?>
        <?php
        if($model->scenario=='update'){
            echo "".$model->nivelsalarial;
        }else{
            
        
        
        
        ?>

        <div id="autocomplete">
            <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'nivelsalarial',
                'source' => $this->createUrl("historialcontrato/autocompleteNivelsalarial"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {

                                        $('#'+Persona.Id('nivelsalarialid') ).val(ui.item.id);
                                
                                     
                                    }"
                ),
                'htmlOptions' => array(
                    'placeholder'=>'Seleccione Sueldo...',
                    'style' => 'width: 100% !important;text-transform: uppercase;',
                    
                ),
            ));
            ?>
              
            </div>
<?php

        }?>
    </div>
  

		<div class="column">
		<?php echo $form->labelEx($model,'fechaini',array('label'=>'Fecha Reincorporacion')); ?>
		<?php  
         
         $manana= mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));   
         $manana= date('d-m-Y',$manana);
         
         echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechaini',
                    'value' => $model->fechaini,
                    'language' => 'es',                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'minDate' =>$fecha,
                                        ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;',
                        
                    ),
                    ), true);
	 ?>
	</div>  
	<div class="column">
		<?php echo $form->labelEx($model,'fecha',array('label'=>'Fecha Antiguedad')); ?>
		<?php  
         
        
         
         echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fecha',
                    'value' => $model->fecha,
                    'language' => 'es',                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'minDate' =>$fecha,
                                        ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;',
                        
                    ),
                    ), true);
	 ?>
	</div>  
      <div class="column">
		<?php echo $form->labelEx($model,'fechafincontrato',array('label'=>'Fecha Fin Contrato')); ?>
		<?php  
         
        
         
         echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechafincontrato',
                    'value' => $model->fechafincontrato,
                    'language' => 'es',                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'minDate' =>$fecha,
                                        ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;',
                        
                    ),
                    ), true);
	 ?>
	</div>  
		</div>

  