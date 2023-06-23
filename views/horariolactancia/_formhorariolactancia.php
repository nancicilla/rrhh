<?php
/* @var $this HorariolactanciaController */
/* @var $model Horariolactancia */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'fechadesde')
)); ?>
    <div class="formWindow">
    
	<?php
        echo "<h6>Horario</h6>";

echo SGridView::widget('TGridView', array(
        'id' => 'gridHorasTrabajo',
        'dataProvider' =>$cuerpohorario,       
         'buttonAdd' => false,
        'buttonText' => '+',        
        'height' => 200,
        'eventAfterEdition' => 'Horario.cantidadHora();',
        'eventAfterEditionAutomatic' => false,
        'columns' => array(           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
                
            ),
             array(
                'header' => 'Dia (desde)',
                'name' => 'dia',
               
                'value' => '$data->iddia == null? "" : $data->iddia0->nombre',
                'width' => 10,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'uneditable',
                
            ),
              array( 
                'name' => 'iddia',
                'typeCol' => 'hidden'
                
            ),
                         array(
                'header' => 'Dia (hasta)',
                'name' => 'diad',                
                'value' => '$data->iddiad == null? "" : $data->iddiad0->nombre',
                'width' => 10,
               'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'uneditable',
            
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
                'typeCol' => 'uneditable',

                

                
            ),
                array(
                'header'=>'Hora(Hasta)',
                'name' => 'horas',               
                'width' => 10,
                'style' => array('text-transform' => 'uppercase','placeholder'=>'Ej. 08:00-09:00'),
                'typeCol' => 'uneditable',            

                
            ),
         
           
             

           
        ),
    ));
?>
	</div>
    

    
	
   
   


	
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Horariolactancia',
        'buttons' => array(

                        'cerrarr' => array(
                            'label' => 'Cerrar',
                            'click' => 'Horariolactancia.cerrarHorarioLactancia',
                           
                            'width' => 130,)
            )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
