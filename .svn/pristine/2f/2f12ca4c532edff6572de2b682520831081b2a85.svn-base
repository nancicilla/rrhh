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
    <div class="row">
    
      <div class="column">
      
 <?php
                 
        
                echo $form->label($model, 'idhorario',array('label'=>'Horario'));
                echo $form->dropDownList($model,'idhorario',CHtml::listData( Horario::model()->findAll(array('order'=>'t.nombre asc ')) ,'id','nombre'),array('empty'=>'','onchange'=>'Movimientopersonal.dameInformacionHorario(this.value)'));

            ?>  
      </div>
      
        
    </div>
<div class="row">
            <?php echo $form->labelEx($model, 'rangohora',array('label'=>'Horas de Trabajo')); ?>
           
         
        </div>
    <div class="row " <?php echo 'id="'.System::Id('conthorario').'"';?>>
            <?php 
            if ($model->scenario=='update') {
             echo SGridView::widget('TGridView', array(
        'id' => 'gridHorasTrabajo',
        'dataProvider' => $Horarios,       
         'buttonAdd' =>false,
                 
    'ableAddRow'=>false,

        'buttonText' => '+',        
        'height' => 120,
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
                'width' => 15,
                'value'=>'$data->estado== 1?"SI":"NO"',
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
                'typeCol' => 'uneditable',
                'type' => 'number(2)',
                 'width' => 15,

                ),
                

           
        ),
    ));
            }


            ?>
        </div>
         
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Movimientopersonal',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
