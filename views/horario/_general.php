
    <div class="row"    <?php echo 'id="'.System::Id('contenedorCabecera').'"';?>>
	<div class="column">
		<?php echo $form->labelEx($model,'fechadesde',array('label'=>'Desde')); ?>
		<?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'model' => $model,
							'attribute' => 'fechadesde',
							'value' => $model->fechadesde,
							'language' => 'es',							
							'options' => array(
								'showAnim' => 'slideDown',
								'showButtonPanel' => true,
								'changeMonth' => true,
								'changeYear' => true,
								'dateFormat' => 'dd-mm-yy',
                                                                'minDate'=>$fechaminima								
					  
							),
							'htmlOptions' => array(
								
                                                                'style' => 'z-index: 20000000 !important;',
                                                                 'onchange'=>'Horario.validarFechahastaEspecial(this.value);'
								
							),
							), true);
		?>
	</div>
    
	<div class="column">
		<?php echo $form->labelEx($model,'fechahasta',array('label'=>'Hasta')); ?>
		<?php 
		echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'fechahasta',
			'value' => $model->fechahasta,
			'language' => 'es',			
			'options' => array(
				'showAnim' => 'slideDown',
				'showButtonPanel' => true,
				'changeMonth' => true,
				'changeYear' => true,
				'dateFormat' => 'dd-mm-yy',
				'minDate'=>$fechaminima
	  
			),
			'htmlOptions' => array(
				
                            'style' => 'z-index: 20000001 !important;',
                            'onchange'=>'Horario.mostrarObservacionHorarioEventual();'
				
			),
			), true);
		?>
	</div>
    
	
    </div>
    <div class="row"  style="width:60%;">
        <?php echo $form->label($model, 'id',array('label'=>'Horario')); ?>

        <?php echo $form->hiddenField($model,'id'); ?>

        <div id="autocomplete">
            <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'horarios',
                'source' => $this->createUrl("horario/BuscarHorario"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {

                                        $('#'+Horario.Id('id') ).val(ui.item.id);
                                        Horario.dameInformacionHorario(ui.item.id);
                                     
                                    }"
                ),
                'htmlOptions' => array(
                    'placeholder'=>'Buscar Horario...',
                    'style' => 'width: 100% !important;text-transform: uppercase;',
                    
                    
                ),
            ));
            ?>
              
        </div>
    </div>
    <div class="row " <?php echo 'id="'.System::Id('conthorario').'"';?>>
    </div>
