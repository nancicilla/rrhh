
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
                                                                 'onchange'=>'Horariolactancia.validarFechahastaEspecial(this.value);'
								
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
                            'onchange'=>'Horariolactancia.mostrarObservacionHorarioEventual();'
				
			),
			), true);
		?>
	</div>
    
	
    </div>
   <div class="row alter alert-info"> <strong>Formato Hora : Ej. 08:00</strong></div>
    <div class="row " <?php echo 'id="'.System::Id('conthorario').'"';?>>
        	<?php
        echo "<h6>Horario Lactancia</h6>";
        
echo SGridView::widget('TGridView', array(
        'id' => 'gridHorasTrabajo',
        'dataProvider' => array(),       
         'buttonAdd' => true,
        'buttonText' => '+',        
        'height' => 200,

        'eventAfterEditionAutomatic' => true,
        'columns' => array(           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
                
            ),
             array(
                'header' => 'Dia (desde)',
                'name' => 'dia',
                'searchUrl' => 'horario/BuscarDia',
                'searchCopyCol' => 'iddia',
                'searchHeight' => 100,
                'searchWidth' => 220,
                'value' => '$data->iddia == null? "" : $data->iddia0->nombre',
                'width' => 10,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
                
            ),
              array( 
                'name' => 'iddia',
                'typeCol' => 'hidden'
                
            ),
                         array(
                'header' => 'Dia (hasta)',
                'name' => 'diad',
                'searchUrl' => 'horario/BuscarDiad',
                'searchCopyCol' => 'iddiad',
                'searchHeight' => 100,
                'searchWidth' => 220,
                'value' => '$data->iddiad == null? "" : $data->iddiad0->nombre',
                'width' => 10,
               'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
            
            ),
              array( 
                'name' => 'iddiad',
                'typeCol' => 'hidden'
                
            ),
               array(
                'header'=>'Hora(Desde)',
                'name' => 'horai',
               
                'width' => 10,
                'style' => array('text-transform' => 'uppercase','placeholder'=>'Ej. 08:00-09:00'),
                'typeCol' => 'editable',

                

                
            ),
                array(
                'header'=>'Hora(Hasta)',
                'name' => 'horas',               
                'width' => 10,
                'style' => array('text-transform' => 'uppercase','placeholder'=>'Ej. 08:00-09:00'),
                'typeCol' => 'editable',            

                
            ),
         
           
             
                array(
                'width' => 4,
                'typeCol' => 'buttons',
                'buttons'=>array('delete'),
                
            ),

           
        ),
    ));
?>
    </div>
