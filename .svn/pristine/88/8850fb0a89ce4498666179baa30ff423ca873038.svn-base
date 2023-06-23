


<?php


           $date1 = new DateTime($desde);
$date2 = new DateTime($hasta);
$cant = $date1->diff($date2)->days;
 $letras=$this->dameColumna('A',$cant);
for ($i=0; $i <=$cant ; $i++) { 

$nuevafecha = strtotime ( '+'.$i.' day' , strtotime ( $desde ) ) ;
$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
//----inicio ciclo
 $tienelactancia=Yii::app()->rrhh
            ->createCommand(" select tiene_lactancia(".$idempleado.", '".$nuevafecha."') as res")
            ->queryAll()[0]['res'];
       ////// fin hora lactancia////////
         $caso=Yii::app()->rrhh
            ->createCommand(" select dame_caso(".$idempleado.",'".$nuevafecha."') as caso")
            ->queryAll();
        $horarios= Yii::app()->rrhh
            ->createCommand(" select * from dame_horario_permiso_empleado1(".$idempleado.",'".$nuevafecha."') as horario")
            ->queryAll();
         $listaentradasalida=Entradasalida::model( )->listaEntradaSalida($nuevafecha,$idempleado);
          if ($caso[0]['caso']==1||($caso[0]['caso']>=12 && $caso[0]['caso']<=16)) {
              $listaentradasalidaespecial=Entradasalida::model()->listaEntradaSalidaFueraHorarioTurno($nuevafecha,$idempleado);

          }else{
         $listaentradasalidaespecial=Entradasalida::model()->listaEntradaSalidaFueraHorarioDia($nuevafecha,$idempleado);}

?>


<div class="row">
<div class="row">
    <hr  style=" border-top: 3px solid #f1f1f1 ;">
</div>
<div class="row">
    <div class="alert alert-info">
        <?php echo $horarios[0]['horario'];?>
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
    <?php
      if ($tienelactancia!='No tiene Horario Lactancia') {
          
           echo $tienelactancia;
   
      }
    ?>
</div>
<div class="row">
    <?php
   
    $alto=200;
    $altoe=count($listaentradasalidaespecial->getData())*60;
    //echo '-------->'.$caso[0]['caso'];
 $nombref='Empleado.Calcular(\''.$letras[$i].'\');';
switch ($caso[0]['caso']) {
    case 1:{
         
        echo SGridView::widget('TGridView', array(
         'id' => $nombre.'gridEntradasalida'.$letras[$i],
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
                'type' => 'number(0)',
                'value'=>'$data->horainfo',
                'typeCol' => 'editable(idcategoriatipo==1 ||( idcategoriatipo==5 ))',
                //'onKeyUp' => 'Empleado.AceptarCambios(this,event);show(k);',
                 
                
                  ),
              array(
                
                'name' => 'hminreal',    
                'value'=>'$data->hminreal',           
                'typeCol' => 'hidden',
            ),
             array(
                'header' => 'Total Minutos',
                'name' => 'minutoinfo',
                'width' => 10,
                'type' => 'number(0)',
                'value'=>'$data->minutoinfo',
                
                 'typeCol' => 'editable(idcategoriatipo==1 ||( idcategoriatipo==5 ))',
              //'onKeyUp' => 'Empleado.AceptarCambiosx(this,event);show(k);',

               
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
                'header' => 'Autorizado',
                'name' => 'autorizado',
                'typeCol' => 'checkbox',
                 
               //'onKeyUp' => 'Empleado.AceptarCambios(this,event);show(k);',
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
         $evento='Empleado.AceptarCambiosEspecial(this,\''.$letras[$i].'\');';
         
            echo SGridView::widget('TGridView', array(
        'id' => $nombre.'gridEntradasalidaEspecial'.$letras[$i],
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
                 'value'=>'$data->intervalo',
                       
            ),
            array(
                'header' => 'Total Horas',
                'name' => 'horainfo',
                'width' => 10,
                'type' => 'number(0)',
                'value'=>'$data->horainfo',
                
                // 'typeCol' => 'editable',
                'onKeyUp' => $evento,

                'typeCol' => 'uneditable',
                ),
              array(
                'header' => 'Total Minutos',
                'name' => 'minutoinfo',
                'width' => 10,
                'type' => 'number(0)',
                'value'=>'$data->minutoinfo',
               
                // 'typeCol' => 'editable',
                //'onKeyUp' => 'Empleado.AceptarCambios(this,event);show(k);',
                'onKeyUp' => $evento,
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

    }
        # code...
        break;
    case 2:{
        echo '<div class=" alert alert-warning">Falta: El Empleado <strong>NO</strong> Cuenta con Permiso para este dia...</div>';
    }
    break;
   
     case 4:{
        echo '<div class=" alert alert-success">Permiso: El Empleado  Cuenta con Permiso para este dia...</div>';
    }
    break;
     case 5:{
        echo '<div class=" alert alert-success">Feriado: Dia configurado como Feriado...</div>';
    }
    break;
     case 6:{
        echo '<div class=" alert alert-success">Vacación: El Empleado  Cuenta con Vacación para este dia...</div>';
    }
    break;
    case 7:{
          if (count($listaentradasalidaespecial->getData())>0) {

            $evento='Empleado.AceptarCambiosEspecial(this,\''.$letras[$i].'\');';
            echo SGridView::widget('TGridView', array(
        'id' => $nombre.'gridEntradasalidaEspecial'.$letras[$i],
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
                 'value'=>'$data->intervalo',
                      
            ),
            array(
                'header' => 'Total Horas',
                'name' => 'horainfo',
                'width' => 10,
                'type' => 'number(0)',
                'value'=>'$data->horainfo',
                
                // 'typeCol' => 'editable',
                //'onKeyUp' => 'Empleado.AceptarCambios(this,event);show(k);',
                'onKeyUp' => $evento,
                'typeCol' => 'editable',
                 ),
              array(
                'header' => 'Total Minutos',
                'name' => 'minutoinfo',
                'width' => 10,
                'type' => 'number(0)',
                'value'=>'$data->minutoinfo',
               
                // 'typeCol' => 'editable',
                //'onKeyUp' => 'Empleado.AceptarCambios(this,event);show(k);',
                'onKeyUp' => $evento,

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

    } break;
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
    default:
        # code...
        break;
}

?>
 </div>

 </div>
<script>
    Empleado.colorear(<?php echo "'$letras[$i]'";?>);
    
</script>
<?php



//----fin ciclo



}
         

?>
