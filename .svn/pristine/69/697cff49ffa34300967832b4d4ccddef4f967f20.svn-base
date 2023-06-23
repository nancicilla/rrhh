<?php
/* @var $this MovimientopersonalController */
/* @var $model Movimientopersonal */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'idempleado')
)); ?>
    <div class="formWindow">
        <h5 style="text-decoration: underline;text-align: center;"> HORARIO</h5>
<div class="">
    <h5> <?php   if (isset($model)){    echo $model->idhorario0->nombre;}    ?></h5>
</div>

    <?php

echo SGridView::widget('TGridView', array(
        'id' => $nombre.'gridHorasTrabajo',
        'dataProvider' => $horarios,       
        
        'buttonText' => '+',    
 'buttonAdd' => false,
    'ableAddRow'=>false,
    
        'height' => 160,
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
                'header'=>'Horas',
                'name' => 'rangohora',
            
               'value' => '$data->idrangohora == null? "" :Horario::model()->ArmarNombreIntervalo($data->idrangohora0->horai,$data->idrangohora0->horas,$data->idrangohora0->controlarentrada,$data->idrangohora0->controlarsalida)',
                'width' => 25,
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
                'value'=>'$data->estado == 1?"SI":"NO"  ',
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
                
                'name'=>'mindescanso',
                'type' => 'number(2)',
                 'width' => 15,
                    'typeCol' => 'uneditable',

                )

           
        ),
    ));
?>

   
	
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Movimientopersonal',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
