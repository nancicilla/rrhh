<?php
/* @var $this PersonaController */
/* @var $model Persona */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'ci'),
    'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
     <div class="formWindow">
     <div class="row">
		<?php echo $form->labelEx($model,'fechaini',array('label'=>'Fecha Inicio')); ?>
                <?php echo $form->hiddenField($model, 'idempleado'); ?>

		<?php  
         
        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechaini',
                    'value' => $model->fechaini,
                    'language' => 'es',                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'minDate' =>$fecha,
                                        ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;',
                        'onchange'=>'Persona.mostrarObservacion()'
                      
                        
                    ),
                    ), true);
	 ?>
	</div>  
<div class="row">
    
    <div class="column">
    
<?php
               
      
              echo $form->label($model, 'idhorario',array('label'=>'Horario'));
              echo $form->dropDownList($model,'idhorario',CHtml::listData( Horario::model()->findAll() ,'id','nombre'),array('empty'=>'','onchange'=>'Persona.dameInformacionHorario(this.value)'));

          ?>  
    </div>
    
      
  </div>

	

        <div class="row">
          <?php echo $form->labelEx($model, 'rangohora',array('label'=>'Horas de Trabajo')); ?>
         
       
      </div>
  <div class="row " <?php echo 'id="'.System::Id('contenedorHorario').'"';?>>
          <?php 
         
           echo SGridView::widget('TGridView', array(
      'id' => 'gridHorasTrabajo',
      'dataProvider' => $Horarios,       
       'buttonAdd' => false,
      'buttonText' => '+',    
               'ableAddRow'=>false,
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
         <div class="row alert alert-info" <?php echo 'id="'.System::Id('contenedorMensaje').'"';?>>
         </div>
      </div>   
    <?php
    echo System::Buttons(array(
        'nameView' => 'Persona',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget();  ?>
</div><!-- form -->
