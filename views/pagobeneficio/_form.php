<?php
/* @var $this PagobeneficioController */
/* @var $model Pagobeneficio*/
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'id')
)); ?>
    <div class="formWindow">
   
	<div class="row" >
        <?php echo $form->label($model, 'idhistorialestadoempleado',array('label'=>'Empleado')); ?>

        <?php echo $form->hiddenField($model,'idhistorialestadoempleado'); ?>
		<?php echo $form->hiddenField($model,'numpago'); ?>
		

        <div id="autocomplete">
            <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'empleado',
                'source' => $this->createUrl("pagobeneficio/autocompletePersona"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {

                                        $('#'+Pagobeneficio.Id('idhistorialestadoempleado') ).val(ui.item.id);
										$.ajax({
											type:'post',
											async: false,
											cache:false,
											url:'rrhh/pagobeneficio/solicitudquinquenio',
											data:{ids:ui.item.id},
											success:function (elementos) {
													  
											$('#'+Pagobeneficio.Id('contquinquenio')).empty();
											 $('#'+Pagobeneficio.Id('contquinquenio')).html(elementos);
											
											

										
											},error:function (er) {
												alert('error al obtner el formulario de solicitud quinquen');
											}
										   });    
                                     
                                    }"
                ),
                'htmlOptions' => array(
                    'placeholder'=>'Buscar Empleado...',
                    'style' => 'width: 100% !important;text-transform: uppercase;',
                    
                ),
            ));
            ?>
              
            </div>
            <div class="row">
		<?php echo $form->labelEx($model,'fechasolicitud'); ?>
		<?php   echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechasolicitud',
                    'value' => $model->fechasolicitud,
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                       
              
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                        ,'data-v'=>''
                        
                    ),
                    ), true);?>
	</div>
             <div class="row">
                <div class="column">
                    <?php echo $form->labelEx($model, 'idformapago', array('label' => 'Forma de Pago')); ?>
                    <?php echo $form->dropDownList($model, 'idformapago', CHtml::listData(Formapago::model()->findAll(array('order'=>"nombre asc")), 'id', 'nombre'), array('onchange' => 'Persona.CargarOpcion(this.value)')); ?>
                </div>
                <div class="column">
                    <?php echo $form->labelEx($model, 'descripcionformapago', array('label' => 'Detalle forma de pago')); ?>
                    <?php echo $form->textField($model, 'descripcionformapago', array('style' => 'text-transform: uppercase')); ?>
                </div>
            </div>

    <div class="row alert alert-info" <?php echo 'id="'.System::Id('contquinquenio').'"';?>>
   
    </div>

    
	
    
    

              
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Pagobeneficio',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
