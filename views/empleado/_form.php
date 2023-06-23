<?php
/* @var $this EmpleadoController */
/* @var $model Empleado */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'huella1')
)); ?>
    <div class="formWindow">
    <div class="row">
    <div class="">
        <?php
      
         $empleado=Empleado::model()->find('t.id='.$model->idempleado);
         echo $empleado->idpersona0->apellidop.' '.$empleado->idpersona0->apellidom.' '.$empleado->idpersona0->nombre;

        ?>
    </div> 
</div>
	<div class="row">
     <div class="column">
         <?php
         echo $form->hiddenField($model,'idempleado'); 
         $fecha=  Date('d-m-Y', strtotime('-1 day'));
      

    
           echo $form->labelEx($model,'fechadesde'); 
     echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
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
                         'minDate'=>$model->fechamin,
                        'maxDate'=>$fecha,
              
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;',
                        'onchange'=>'Empleado.mostrar_asistencia_fechas()'
                       
                    ),
                    ), true);

         ?>
     </div>
     <div class="column">
         <?php

            echo $form->labelEx($model,'fechahasta'); 
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
                         'minDate'=>$model->fechamin,
                        'maxDate'=>$fecha,
              
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;',
                         'onchange'=>'Empleado.mostrar_asistencia_fechas()'
                       
                    ),
                    ), true);
         ?>
     </div>

    </div>
<div class="row" <?php echo 'id="'.System::Id('contenedorAsistencia').'"';?>>
        
   

<div class="row">
    <div class="alert alert-info">
        <?php 
// var_dump($horarios);
      echo $horarios[0]['horario'];

    
        ?>
    </div> 
    
</div>
<?php
if ($horarios[0]['permiso']!='') {
    ?>
<div class='row'>
 <div class="alert alert-warning">
        <?php 

      echo $horarios[0]['permiso'];

    
        ?>
    </div> 
</div>
    <?php
}

?>
<div class="row">
    <?php ?>
        <?php  ?>

    <?php

      if ($tienelactancia!='No tiene Horario Lactancia') {
      echo $tienelactancia;
          
            
   
      }
    ?>
</div>
<div class="row">
    <?php
     //echo ;
    // echo "---*****->".$listaentradasalida->itemCount()."<<<<<<";
    //$alto=count($listaentradasalida->getData())*55;
    $alto=200;
    $altoe=count($listaentradasalidaespecial->getData())*60;
    $nombref='Empleado.Calcular(\'A\');';
switch ($caso[0]['caso']) {
   
	case 1:
		echo SGridView::widget('TGridView', array(
        'id' => 'gridEntradasalidaA',
        'dataProvider' => $listaentradasalida,
       	'ableAddRow' => false,
        'specialCellEditionMode' => false,
        'eventAfterEdition' => $nombref,
        'eventAfterEditionAutomatic' => true,
        'height' => $alto,
        'columns' => array(
           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
                
            ),
          
            array(
                'header' => 'Fecha',
                'name' => 'fecha',
              	
                'width' => 10,
                'style' => array('text-transform' => 'uppercase'),
               
                 'typeCol' => 'uneditable',
                
            ),
            array(
                'header' => 'E/S',
                'name' => 'es',
                'width' => 10,
               // 'visible'=>'$data->idtipo0->idcategoriatipo==1',
                'style' => array('text-transform' => 'uppercase'),
               'typeCol' => 'uneditable',
                
            ),
             array(
                'header' => 'Total Horas',
                'name' => 'horainfo',
                'width' => 10,
                //'type' => 'number(0)',
                'value'=>'$data->horainfo',
                
                // 'typeCol' => 'editable',
                //'onKeyUp' => 'Empleado.AceptarCambios(this,event);show(k);',

                 'typeCol' => 'editable(idcategoriatipo==1 || idcategoriatipo==5 )',
                  ),
              array(
                'header' => 'Total Minutos',
                'name' => 'minutoinfo',
                'width' => 10,
                'type' => 'number(0)',
                'value'=>'$data->minutoinfo',
               
                // 'typeCol' => 'editable',
                //'onKeyUp' => 'Empleado.AceptarCambios(this,event);show(k);',

               'typeCol' => 'editable(idcategoriatipo==1 || idcategoriatipo==5 )',
                     ),
            array(
                'header' => 'Minutos',
                'name' => 'hmin',
                'width' => 10,
                'type' => 'number(0)',
                'typeCol' => 'uneditable',
                 
                
                
            ),
             array(
                'header' => 'Minutos',
                'name' => 'hminaux',    
                'value'=>'$data->hmin',           
                'typeCol' => 'hidden',
            ),
              array(
                
                'name' => 'hminreal',    
                'value'=>'$data->hminreal',           
                'typeCol' => 'hidden',
            ),
              array(
                'header' => 'Autorizado',
                'name' => 'autorizado',
                'typeCol' => 'checkbox',
                 
                'width' => 10,
            ),
           
            array(
                'header' => 'Tipo',
                'name' => 'tipo',
                'searchUrl' => 'asistencia/BuscarTipo',
                'searchCopyCol' => 'idtipo',
                'searchHeight' => 100,
                'searchWidth' => 220,
                'value' => '$data->idtipo== null? "" : $data->idtipo0->nombre',
                'width' => 20,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
            ),
              array( 
                'name' => 'idtipo',
                'typeCol' => 'hidden',
            ),
                 array( 
                'name' => 'idcategoriatipo',
                'value' => '$data->idtipo0->idcategoriatipo',
                'typeCol' => 'hidden',
            ), 

               

           
        ),
    ));
      if (count($listaentradasalidaespecial->getData())>0) {
        echo "<br>";
        $event='Empleado.AceptarCambiosEspecial(this,\'A\');';
            echo SGridView::widget('TGridView', array(
        'id' => 'gridEntradasalidaEspecialA',
        'dataProvider' => $listaentradasalidaespecial,
        'ableAddRow' => false,
        'specialCellEditionMode' => false,
       
        'height' => $altoe,
        'columns' => array(
           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
                
            ),
          
            array(
                
                'name' => 'intervalo',
                
                'width' => 10,
                'style' => array('text-transform' => 'uppercase'),
                 'typeCol' => 'uneditable',
                 'value'=>'$data->intervalo'
                
            ),
            array(
                'header' => 'Total Horas',
                'name' => 'horainfo',
                'width' => 10,
                'type' => 'number(0)',
                'value'=>'$data->horainfo',
                
                // 'typeCol' => 'editable',
                //'onKeyUp' => 'Empleado.AceptarCambios(this,event);show(k);',

                'typeCol' => 'editable',
                'onKeyUp' =>$event ,
                   ),
              array(
                'header' => 'Total Minutos',
                'name' => 'minutoinfo',
                'width' => 10,
                'type' => 'number(0)',
                'value'=>'$data->minutoinfo',
               'onKeyUp' => $event,
                // 'typeCol' => 'editable',
                //'onKeyUp' => 'Empleado.AceptarCambios(this,event);show(k);',

                'typeCol' => 'editable',
                  ),
            array(
                'header' => 'Minutos',
                'name' => 'minutos',
                'width' => 10,
                //'type' => 'number(0)',
                // 'typeCol' => 'editable',
                
                'value'=>'$data->minutos',
                'typeCol' => 'uneditable',
                    ),
            
              array(
                'header' => 'Autorizado',
                'name' => 'autorizado',
                'typeCol' => 'checkbox',
                'width' => 10,
            ),
           
            array(
                'header' => 'Tipo',
                'name' => 'tipo',
                'searchUrl' => 'asistencia/BuscarTipo1',
                'searchCopyCol' => 'idtipo',
                'searchHeight' => 100,
                'searchWidth' => 220,
                'value' => '$data->idtipo== null? "" : $data->idtipo0->nombre',
                'width' => 20,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
                ),
              array( 
                'name' => 'idtipo',
                'typeCol' => 'hidden',
            ),
                 array( 
                'name' => 'idcategoriatipo',
                'value' => '$data->idtipo0->idcategoriatipo',
                'typeCol' => 'hidden',
            ), 

               

           
        ),
    ));
      }

	
		# code...
		break;
	case 2:
		echo '<div class=" alert alert-warning">Falta: El Empleado <strong>NO</strong> Cuenta con Permiso para este dia...</div>';
	
	break;
    case 4:
        echo '<div class=" alert alert-success">Permiso: El Empleado  Cuenta con Permiso para este dia...</div>';
    
    break;
     case 5:
        echo '<div class=" alert alert-success">Feriado: Dia configurado como Feriado...</div>';
    
    break;
     case 6:
        echo '<div class=" alert alert-success">Vacación: El Empleado  Cuenta con Vacación para este dia...</div>';
    
    break;
    case 7:
     $event='Empleado.AceptarCambiosEspecial(this,\'A\');';
       
            echo SGridView::widget('TGridView', array(
        'id' => 'gridEntradasalidaEspecialA',
        'dataProvider' => $listaentradasalidaespecial,
        'ableAddRow' => false,
        'specialCellEditionMode' => false,
       
        'height' => $altoe,
        'columns' => array(
           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
                
            ),
          
            array(
                
                'name' => 'intervalo',
                
                'width' => 10,
                'style' => array('text-transform' => 'uppercase'),
                 'typeCol' => 'uneditable',
                 'value'=>'$data->intervalo'
                
            ),
            array(
                'header' => 'Total Horas',
                'name' => 'horainfo',
                'width' => 10,
                'type' => 'number(0)',
                'value'=>'$data->horainfo',
                
                // 'typeCol' => 'editable',
                'onKeyUp' => $event,

                'typeCol' => 'editable',
                   ),
              array(
                'header' => 'Total Minutos',
                'name' => 'minutoinfo',
                'width' => 10,
                'type' => 'number(0)',
                'value'=>'$data->minutoinfo',
               
                // 'typeCol' => 'editable',
                'onKeyUp' => $event,

                'typeCol' => 'editable',
                    ),
            array(
                'header' => 'Minutos',
                'name' => 'minutos',
                'width' => 10,
                //'type' => 'number(0)',
                // 'typeCol' => 'editable',
                //'onKeyUp' => 'Empleado.AceptarCambios(this,event);show(k);',
                'value'=>'$data->minutos',
                'typeCol' => 'uneditable',
                   ),
            
              array(
                'header' => 'Autorizado',
                'name' => 'autorizado',
                'typeCol' => 'checkbox',
                'width' => 10,
            ),
           
            array(
                'header' => 'Tipo',
                'name' => 'tipo',
                'searchUrl' => 'asistencia/BuscarTipo1',
                'searchCopyCol' => 'idtipo',
                'searchHeight' => 100,
                'searchWidth' => 220,
                'value' => '$data->idtipo== null? "" : $data->idtipo0->nombre',
                'width' => 20,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
                   ),
              array( 
                'name' => 'idtipo',
                'typeCol' => 'hidden',
            ),
                 array( 
                'name' => 'idcategoriatipo',
                'value' => '$data->idtipo0->idcategoriatipo',
                'typeCol' => 'hidden',
            ), 

               

           
        ),
    ));


     break;
   case 8:
        echo '<div class=" alert alert-success">Banco Horas: El Empleado  Cuenta con Permiso para este dia...</div>';
    
    break;
 case ($caso[0]['caso']>=12 || $caso[0]['caso']<=16):{
         switch($caso[0]['caso']){
            case 12:
                echo '<div class=" alert alert-success">Permiso: El Empleado  Cuenta con Permiso para este dia...</div>';
            break;
            case 13:
                echo '<div class=" alert alert-success">Feriado: Dia configurado como Feriado...</div>';
            break;
            case 14:
                echo '<div class=" alert alert-success">Vacación: El Empleado  Cuenta con Permiso para este dia...</div>';
            break;
            case 16:
                echo '<div class=" alert alert-success">Banco Hora: El Empleado  Cuenta con Permiso para este dia...</div>';
            break;
         }
      
        echo SGridView::widget('TGridView', array(
            'id' => 'gridEntradasalidaA',
            'dataProvider' => $listaentradasalida,
               'ableAddRow' => false,
            'specialCellEditionMode' => false,
            'eventAfterEdition' => $nombref,
            'eventAfterEditionAutomatic' => true,
            'height' => $alto,
            'columns' => array(
               
                array( 
                    'name' => 'id',
                    'typeCol' => 'hidden'
                    
                ),
              
                array(
                    'header' => 'Fecha',
                    'name' => 'fecha',
                      
                    'width' => 10,
                    'style' => array('text-transform' => 'uppercase'),
                   
                     'typeCol' => 'uneditable',
                    
                ),
                array(
                    'header' => 'E/S',
                    'name' => 'es',
                    'width' => 10,
                   // 'visible'=>'$data->idtipo0->idcategoriatipo==1',
                    'style' => array('text-transform' => 'uppercase'),
                   'typeCol' => 'uneditable',
                    
                ),
                 array(
                    'header' => 'Total Horas',
                    'name' => 'horainfo',
                    'width' => 10,
                    //'type' => 'number(0)',
                    'value'=>'$data->horainfo',
                    
                    // 'typeCol' => 'editable',
                    //'onKeyUp' => 'Empleado.AceptarCambios(this,event);show(k);',
    
                     'typeCol' => 'editable(idcategoriatipo==1 || idcategoriatipo==5 )',
                        ),
                  array(
                    'header' => 'Total Minutos',
                    'name' => 'minutoinfo',
                    'width' => 10,
                    'type' => 'number(0)',
                    'value'=>'$data->minutoinfo',
                   
                    // 'typeCol' => 'editable',
                    //'onKeyUp' => 'Empleado.AceptarCambios(this,event);show(k);',
    
                   'typeCol' => 'editable(idcategoriatipo==1 || idcategoriatipo==5 )',
                       ),
                array(
                    'header' => 'Minutos',
                    'name' => 'hmin',
                    'width' => 10,
                    'type' => 'number(0)',
                    'typeCol' => 'uneditable',
                     
                    
                    
                ),
                 array(
                    'header' => 'Minutos',
                    'name' => 'hminaux',    
                    'value'=>'$data->hmin',           
                    'typeCol' => 'hidden',
                ),
                  array(
                    
                    'name' => 'hminreal',    
                    'value'=>'$data->hminreal',           
                    'typeCol' => 'hidden',
                ),
                  array(
                    'header' => 'Autorizado',
                    'name' => 'autorizado',
                    'typeCol' => 'checkbox',
                     
                    'width' => 10,
                ),
               
                array(
                    'header' => 'Tipo',
                    'name' => 'tipo',
                    'searchUrl' => 'asistencia/BuscarTipo',
                    'searchCopyCol' => 'idtipo',
                    'searchHeight' => 100,
                    'searchWidth' => 220,
                    'value' => '$data->idtipo== null? "" : $data->idtipo0->nombre',
                    'width' => 20,
                    'style' => array('text-transform' => 'uppercase'),
                    'typeCol' => 'editable',
                ),
                  array( 
                    'name' => 'idtipo',
                    'typeCol' => 'hidden',
                ),
                     array( 
                    'name' => 'idcategoriatipo',
                    'value' => '$data->idtipo0->idcategoriatipo',
                    'typeCol' => 'hidden',
                ), 
    
                   
    
               
            ),
        ));
        

  } break;
	
}

?>
 </div>
    
	
    
	
    
	 </div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Empleado',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    Empleado.colorear('A');
    
</script>