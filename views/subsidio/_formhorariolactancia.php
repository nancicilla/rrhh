

  
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'focus' => array($model, 'idempleado')
    ));
    ?>
    <div class="formWindow">
       
	<div class="row" style="display:<?php echo$model->scenario; ?>;">
            <div    class="row alter alert-info">
                <h5>Establesca por primera vez, las fechas en la que el empleado tendra horario de lactancia...</h5>
            </div>
		<?php 
               
                echo $form->labelEx($model,'fechadesde'); 
		echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechadesde',                    
                    'language' => 'es',                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'minDate'=>$fechaminima,
                        
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                    ),
                    ), true);
		?>
	</div>
    
	<div class="row"style="display:<?php echo$model->scenario; ?>;">
		<?php echo $form->labelEx($model,'fechahasta'); ?>
		<?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechahasta',
                    
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'minDate'=>$fechaminima,
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                    ),
                    ), true); ?>
	</div>    <div class="row" style="display:<?php echo ($model->scenario=='none')?"":"none"; ?>;">
        <?php
        echo $form->labelEx($model, 'fechainicio',array('label'=>'Fecha Inicio'));
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
                'minDate'=>$fechaminima,
            ),
            'htmlOptions' => array(
                'style' => 'width: 150px;'
                , 'data-v' => ''
            ),
                ), true);
        ?>

    </div>
<div class="row alter alert-info"> <strong>Formato Hora : Ej. 08:00</strong></div>
	<div class="row">
		<?php
        echo "<h6>Horario Lactancia</h6>";

echo SGridView::widget('TGridView', array(
        'id' => 'gridHorasTrabajo',
        'dataProvider' =>array(),       
         'buttonAdd' => true,
        'buttonText' => '+',        
        'height' => 200,
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
    

    
	
    <?php
    echo System::Buttons(array(
        'nameView' => 'Subsidio',
        'buttons' => array()
    ));
    ?> 
    <?php $this->endWidget(); ?>

</div><!-- form -->

   

