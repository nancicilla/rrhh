 <div class="row">
    
    		<div class="column">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>100,'style' => 'text-transform: uppercase')); ?>
	</div>
        <div class="column">
            <?php

                        
                echo $form->label($model, 'fechainicio', array('label' => 'Fecha Inicio' ));
                echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechainicio',
                    'value' => $model->fechainicio,
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'minDate' => $fechaminima,                       
              
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                        ,'data-v'=>'',
                        'onchange'=>'Horario.Actualizarinfocambiofecha()'
                    ),
                    ), true);
            ?>
        </div>
	
    </div>

	
    <div class="row">
    	
    
    
	<div class="column">
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->checkBox($model,'estado'); ?>
	</div>
    </div>
	
    
<div class="row" <?php echo 'id="'.System::Id('chd').'"';?>>
 
 </div>

	  <div class="row">
            <?php echo $form->labelEx($model, 'horastrabajo',array('label'=>'Horas de Trabajo')); ?>
    
            <?php

echo SGridView::widget('TGridView', array(
        'id' => 'gridHorasTrabajo',
        'dataProvider' => $listahorario,       
         'buttonAdd' => true,
        'buttonText' => '+',        
        'height' => 180,
        'eventAfterEdition' => 'Horario.cantidadHora();',
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
                'header'=>'Horas',
                'name' => 'rangohora',
                'searchUrl' => 'horario/BuscarHora',
                'searchCopyCol' => 'idrangohora',
                'searchHeight' => 100,
                'searchWidth' => 220,
                'value' => '$data->idrangohora == null? "" :Horario::model()->ArmarNombreIntervalo($data->idrangohora0->horai,$data->idrangohora0->horas,$data->idrangohora0->controlarentrada,$data->idrangohora0->controlarsalida)',
                'width' => 15,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',

                

                
            ),
            array( 
                'name' => 'idrangohora',
                'typeCol' => 'hidden',
                   
                
            ),  array(
                'header'=>'Minutos de descanso',
                'name'=>'mindescanso',
                'type' => 'number(2)',
                'width' => 15,

                ),
            array(
                'header'=>'Horario Intercalado Semanalmente??',
                'name' => 'estado',
                'width' => 20,
                'typeCol' => 'checkbox',
                /*'click' => 'function(){
                            SGridView.selectRow(this);
                            Persona.cantidadHora();}'*/
            ),
            array(
                'header'=>'Fecha Inicial Intercalacion',
                'name'=>'fechaiseq',
                'value'=>'$data->fechaiseq == null?"":  date("d-m-Y", strtotime($data->fechaiseq))',
                'typeCol' => 'uneditable',
                 'typeCol' => 'editable(estado==1 )',
                 'width' => 15,

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
        <script type="text/javascript">
            Horario.cantidadHora();
        </script>