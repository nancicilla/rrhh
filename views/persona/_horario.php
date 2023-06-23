<div class="row">
           <?php echo $form->labelEx($model, 'rangohora',array('label'=>'Horas de Trabajo')); ?>
    </div>
	      <div class="row " <?php echo 'id="'.System::Id('contenedorHorario').'"';?>>
         
     <?php echo $form->hiddenField($modelmp, 'idhorario'); ?>
     <div class="row">
         <?php
         if (isset($modelmp->idhorario)) {
            echo "<h6>".Horario::model()->findAll('t.id='.$modelmp->idhorario)[0]['nombre']."</h6>";   
         }
             
         ?>
     </div>
            <?php
           
echo SGridView::widget('TGridView', array(
        'id' => 'gridHorasTrabajo',
        'dataProvider' => $listahorario,      
        'buttonAdd' => false,
        'buttonText' => '+',        
        'height' => 150,
        'eventAfterEdition' => 'Persona.cantidadHora();',
        'columns' => array(           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
                
            ),
             array(
                'header' => 'Dia (desde)',
                'name' => 'dia',               
                'value' => '$data->iddia == null? "" : $data->iddia0->nombre',
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'uneditable',
                 'width' => 10,
                
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
                'header'=>'Horas',
                'name' => 'rangohora',
                'value' => '$data->idrangohora == null? "" :Horario::model()->ArmarNombreIntervalo($data->idrangohora0->horai,$data->idrangohora0->horas,$data->idrangohora0->controlarentrada,$data->idrangohora0->controlarsalida)',
                'width' => 15,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'uneditable',

                

                
            ),
            array( 
                'name' => 'idrangohora',
                'typeCol' => 'hidden',
                   
                
            ),
            array(
                'header'=>'Horario Intercalado Semanalmente?',
                'name' => 'estado',
                'width' => 20,
                'value'=>'$data->estado==1?"SI":"NO"',
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'uneditable',
                             
            ),
            array(
                'header'=>'Fecha Inicial Intercalacion',
                'name'=>'fechaiseq',
                'value'=>'$data->fechaiseq == null?"":  date("d-m-Y", strtotime($data->fechaiseq))',
                'typeCol' => 'uneditable',
                 'width' => 15,

                ),
               array(
                'header'=>'Minutos de descanso',
                'name'=>'mindescanso',
                'type' => 'number(2)',
                'width' => 15,
                 'typeCol' => 'uneditable',

                ),
              

           
        ),
    ));
?>
        </div>
