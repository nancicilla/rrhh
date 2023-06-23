<div class="row">    	
        <?php echo $form->hiddenField($model,'idempleado'); ?>
  

   
   	</div>
       


<div class="row" >
  <div class="column">
    <?php echo $form->labelEx($model,'unidad',array('label'=>'Unidad')); ?>
    <div  id="contu">
        
        <?php echo $form->dropDownList($model,'unidad',CHtml::listData(Unidad::model()->findAll(),'id','nombre'),array('empty'=>'','readonly'=>true,'onchange'=>'Puestotrabajo.listaArea(this.value,Movimientopersonal.Id("area"),Movimientopersonal.Id("seccion"),Movimientopersonal.Id("idpuestotrabajo"))'));?>
    </div>
    </div>
 <div class="column">
	<?php echo $form->labelEx($model,'area'); ?>
	<div  id="conta">
		
		<?php echo $form->dropDownList($model,'area',CHtml::listData($areas,'id','nombre'),array('empty'=>'','readonly'=>true,'onchange'=>'Puestotrabajo.listaSeccion(Movimientopersonal.Id("unidad"),this.value,Movimientopersonal.Id("seccion"))'));?>
	</div>
    </div>
    <div class="column">
		<?php echo $form->labelEx($model,'seccion',array('label'=>'Sección')); ?>
		<?php 

        echo $form->dropDownList($model,'seccion',CHtml::listData($secciones,'id','nombre'),array('empty'=>'','readonly'=>true,'onchange'=>'Persona.listaPuestotrabajo(this.value,Movimientopersonal.Id("idpuestotrabajo"))')); ?>
	</div>
        <div class="column">
    <?php echo $form->labelEx($model,'idpuestotrabajo',array('label'=>'Nuevo Puesto de Trabajo')); ?>
    <div  id="conta">
        
        <?php echo $form->dropDownList($model,'idpuestotrabajo',CHtml::listData($puestotrabajos,'id','nombre'),array('empty'=>'','readonly'=>true));?>
    </div>
    </div>
    </div>
          <div class="row">
        <?php echo $form->labelEx($model,'tipocontrato',array('label'=>'Contrato')); 
        
        echo $form->dropDownList($model,'tipocontrato',CHtml::listData(Tipocontrato::model()->findAll(),'id','nombre'),array('empty'=>'','readonly'=>true)); 
        ?>
      
    </div> 
	    <div class="row">



	 <div class="column" style="width: 50%;">
        <?php echo $form->label($model, 'idnivelsalarial',array('label'=>'Nivel Salarial')); ?>

        <?php echo $form->hiddenField($model,'idnivelsalarial'); ?>
        <?php
        if($model->scenario=='update'){
        
            
        
        
        
        ?>

        <div id="autocomplete">
            <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'nivelsalarial',
                'source' => $this->createUrl("movimientopersonal/autocompleteNivelsalarial"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {

                                        $('#'+Movimientopersonal.Id('idnivelsalarial') ).val(ui.item.id);
                                
                                     
                                    }"
                ),
                'htmlOptions' => array(
                    'placeholder'=>'Seleccione Sueldo...',
                    'style' => 'width: 100% !important;text-transform: uppercase;',
                    'readonly'=>true
                ),
            ));
            ?>
              
            </div>
<?php

        }?>
    </div>
  

		<div class="column">
		<?php echo $form->labelEx($model,'fechaini'); ?>
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
                        'minDate' =>$manana,
                                        ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;','readonly'=>true,
                        
                    ),
                    ), true);
	 ?>
	</div>  

      
		</div>

      
