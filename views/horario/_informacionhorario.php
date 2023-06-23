
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
<div class="row">
    
<div class="column">
<?php echo $form->labelEx($model,'nombre'); ?>
<?php echo $model->nombre; ?>
</div>

</div>

<div class="row">




<div class="row" <?php echo 'id="'.System::Id('chd').'"';?>>


</div>

<div class="row">
    <?php echo $form->labelEx($model, 'horastrabajo',array('label'=>'Horas de Trabajo')); ?>

    <?php
  echo SGridView::widget('TGridView', array(
    'id' => 'gridHorasTrabajo',
    'dataProvider' => $listahorario,       
     'buttonAdd' => false,
    'buttonText' => '+',    
             'ableAddRow'=>false,
    'height' => 150,
  
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
            'width' => 15,
            
            
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
            
            'name'=>'mindescanso',
            'typeCol' => 'editable',
            'type' => 'number(2)',
             'width' => 15,
                 'typeCol' => 'uneditable',

            ),

       
    ),
));
     

?>
</div>
<script type="text/javascript">
    Horario.cantidadHora();
</script>

     
</div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Horario',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
