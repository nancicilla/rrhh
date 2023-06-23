<?php
/* @var $this PersonaController */
/* @var $model Persona */
/* @var $form CActiveForm */
?>



    <div class="formWindow">
    <div class="row">
	<div class="column">
		<?php echo $form->labelEx($model,'ci'); ?>
		<?php echo $form->textField($model,'ci',array('minlength'=>8,'maxlength'=>9,'style' => 'text-transform: uppercase')); ?>
	</div><div class="column">
		<?php echo $form->labelEx($model,'complementoci'); ?>
		<?php echo $form->textField($model,'complementoci',array('maxlength'=>3,'style' => 'text-transform: uppercase')); ?>
	</div>
	<div class="column">
		<?php echo $form->labelEx($model,'expedicion'); ?>
		<?php echo $form->dropDownList($model,'expedicion',CHtml::listData(
			array(array('id'=>'BN','nombre'=>'BENI'),array('id'=>'CH','nombre'=>'CHUQUISACA'),array('id'=>'CB','nombre'=>'COCHABAMBA'),array('id'=>'LP','nombre'=>'LA PAZ'),array('id'=>'OR','nombre'=>'ORURO'),array('id'=>'PA','nombre'=>'PANDO'),array('id'=>'PT','nombre'=>'POTOSI'),array('id'=>'SC','nombre'=>'SANTA CRUZ'),array('id'=>'TJ','nombre'=>'TARIJA')),'id','nombre'),array('empty'=>'')); ?>
	</div>
    </div>
 	
    
	<div class="row">
	<div class="column">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('minlength'=>3, 'maxlength'=>50,'style' => 'text-transform: uppercase')); ?>
	</div>
	<div class="column">
		<?php echo $form->labelEx($model,'apellidop'); ?>
		<?php echo $form->textField($model,'apellidop',array('maxlength'=>40,'style' => 'text-transform: uppercase')); ?>
	</div>
	<div class="column">
		<?php echo $form->labelEx($model,'apellidom'); ?>
		<?php echo $form->textField($model,'apellidom',array('maxlength'=>40,'style' => 'text-transform: uppercase')); ?>
	</div>
    </div>
	
    
	
    <div class="row">
	<div class="column">
		<?php echo $form->labelEx($model,'estadocivil'); ?>
		<?php echo $form->dropDownList($model,'estadocivil',CHtml::listData(
			array(array('id'=>'S','nombre'=>'SOLTERO(A)'),array('id'=>'C','nombre'=>'CASADO(A)'),array('id'=>'V','nombre'=>'VIUDO(A)'),array('id'=>'D','nombre'=>'DIVORCIADO(A)'),array('id'=>'O','nombre'=>'OTRO')),'id','nombre'),array('empty'=>'')); ?>
	</div>
	<div class="column">
		<?php echo $form->labelEx($model,'apellidocasada'); ?>
		<?php echo $form->textField($model,'apellidocasada',array('maxlength'=>40,'style' => 'text-transform: uppercase')); ?>
	</div>
        <div class="column">
		<?php echo $form->labelEx($model,'sexo'); ?>
		<?php echo $form->dropDownList($model,'sexo',CHtml::listData(
		array(array('id'=>'F','nombre'=>'FEMENINO'),array('id'=>'M','nombre'=>'MASCULINO')),'id','nombre'),array('empty'=>'')); ?>
	</div>
    </div>

    <div class="row">
	
	 <div class="column">
            <?php
			$edadmax='';
            $edadmin='';
            $conf=Configuracion::model()->find(" eliminado=false and  para like '%EDAD%'");
            if (isset($conf)) {
                $edadmin='-'.$conf->valor.'Y';
            		
            	}	
            
        
        
                echo $form->label($model, 'fechanac');
                echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechanac',
                    'value' => $model->fechanac,
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                      
                        'minDate'=>$edadmax,
              
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                    ),
                    ), true);
//            echo '==>> '.$model->scenario;
            ?>
        </div>

        <div class="column">
		<?php echo $form->labelEx($model,'profesion'); ?>
		<?php echo $form->textField($model,'profesion',array('maxlength'=>40,'style' => 'text-transform: uppercase')); ?>
        </div>
    
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'discapacidad'); ?>
        <?php echo $form->checkBox($model,'discapacidad'); ?>
    </div>
    <div class="row">
    <div class="">

		<?php
		
		 echo $form->labelEx($model,'idmunicipio'); ?>
		<?php echo $form->hiddenField($model,'idmunicipio'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'municipio',
                'source' => $this->createUrl("persona/autocompleteMunicipio"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {
                                        $('#' + Persona.Id('idmunicipio')).val(ui.item.id);
                                      
                                      Persona.dameAutocomplete();
                                    }"
                ),
                'htmlOptions' => array(
                	'placeholder'=>'Nombre del municipio',
                    'style' => 'width: 100%;text-transform: uppercase;',
                    
                ),
            ));
		
          

                 ?>
              
          	</div>
    	<div class="">
    	<?php
  

		 echo $form->labelEx($model,'idlocalidad'); ?>
		<?php echo $form->hiddenField($model,'idlocalidad'); ?>

    	<div id="autocomplete">

			<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'localidad',

                'source' => $this->createUrl("persona/autocompleteLocalidad"),

                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {
                                        $('#' + Persona.Id('idlocalidad')).val(ui.item.id);
                                    //  console.log(Persona.Id('idlocalidad'));
                                      
                                    }"
                ),
                'htmlOptions' => array(
                	'placeholder'=>'Nueva localidad  EJ. nombre municipio -nombre nueva localidad',
                    'style' => 'width: 100%;text-transform: uppercase;',
                    
                ),
            ));
		
          

                 ?>
              
          	</div>
          	</div>
	

    </div>
	
	<div class="row">
	<div class="column">
		<?php echo $form->labelEx($model,'telefono'); ?>
		<?php echo $form->textField($model,'telefono',array('minlength'=>7,'maxlength'=>8,'style' => 'text-transform: uppercase')); ?>
	</div>
	<div class="column">
		<?php echo $form->labelEx($model,'ncelular'); ?>
		<?php echo $form->textField($model,'ncelular',array('minlength'=>8,'maxlength'=>8,'style' => 'text-transform: uppercase')); ?>
	</div>
	<div class="column">
		<?php echo $form->labelEx($model,'correoe'); ?>
		<?php echo $form->textField($model,'correoe',array('minlength'=>14,'maxlength'=>60,'type'=>'email')); ?>
	</div>
    </div>   
	
    
	<div class="row">
		<div class="column">
			<?php echo $form->labelEx($direccion,'calle'); ?>
		<?php echo $form->textField($direccion,'calle',array('style' => 'text-transform: uppercase'));  ?>
		</div>
		<div class="column">
			<?php echo $form->labelEx($direccion,'numero',array('label'=>'Número(Casa)')); ?>
		<?php echo $form->textField($direccion,'numero',array('minlength'=>1,'maxlength'=>5,'style' => 'text-transform: uppercase')); ?>
		</div>
		<div class="column">
			<?php echo $form->labelEx($direccion,'zona'); ?>
		<?php echo $form->textField($direccion,'zona',array('minlength'=>5,'maxlength'=>50,'style' => 'text-transform: uppercase')); ?>
		</div>
		
	</div>
  
    
	
    </div>
   


