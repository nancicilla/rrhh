<?php

/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'')
)); ?>
    <div class="formWindow">
      <?php
      if ($model->scenario=='proceso') {
          ?>
     <div class="alert alert-info">
         <h6>No se puede crear Nuevo Corte Hasta la Consolidacion de la Planilla...</h6>
     </div>

          <?php
      }else{?>

        <div class="">
                <h4>Datos Planilla</h4>
                <?php echo $form->labelEx($model,'encargadoplanilla',array('label'=>'Encargado de la Planilla')); 
    echo $form->textField($model,'encargadoplanilla',array('maxlength'=>100,'style' => 'text-transform: uppercase','placeholder'=>'Nombre Encargado de la Planilla')); 
  ?>
                         <?php echo $form->labelEx($model,'cargoencargado',array('label'=>'Cargo Encargado ')); 
    echo $form->textField($model,'cargoencargado',array('maxlength'=>100,'style' => 'text-transform: uppercase','placeholder'=>'Cargo')); 
  ?>
        </div>
        <div class="row">
    <?php
   
    $cadena='';
       $ahora = time();
                $unDiaEnSegundos = 24 * 60 * 60;
                $ayer = $ahora - $unDiaEnSegundos;    
                $ayer= date("d-m-Y", $ayer);
   $fecha = new DateTime();
                $fecha->modify('last day of this month');
    echo '<h4>Corte de Planilla</h4>';
   echo $form->labelEx($model,'nombre'); 
    echo $form->textField($model,'nombre',array('maxlength'=>100,'style' => 'text-transform: uppercase','placeholder'=>'Nombre Corte...')); 
    echo $form->labelEx($model,'fechadesde'); 

  if ($model->scenario=='mostrar') {
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
                        'maxDate'=>$model->fechamax
              
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                       
                    ),
                    ), true);
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
                        'maxDate'=>$fecha->format('d-m-Y'),
              
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                       
                    ),
                    ), true);
   

  }else{
    if ($model->fechadesde!='') {
        echo '<p><strong>'.$model->fechadesde.'</strong></p>';
     }
     

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
                        'minDate'=>$model->fechadesde,
                        'maxDate'=>$fecha->format('d-m-Y')
              
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                       
                    ),
                    ), true);
   
  }
 echo "<h4>Controlar Asistencia </h4>";
       echo $form->labelEx($model,'fechaic'); 
      if ($model->fechaic!='') {
       echo '<p><strong>'.$model->fechaic.'</strong></p>';
    }else{
         
     echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechaic',
                    'value' => $model->fechaic,
                    'language' => 'es',                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        
                        'maxDate'=>$ayer,
              
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                       
                    ),
                    ), true);
      
    }


      
       echo $form->labelEx($model,'fechafc'); 
     echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechafc',
                    'value' => $model->fechahasta,
                    'language' => 'es',                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                         'minDate'=>$model->fechaic,
                        'maxDate'=>$ayer,
              
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                       
                    ),
                    ), true);
    ?>
    
    
         </div>
      <?php
  }
      ?>
       <?php
       echo $listafiniquitos;
       ?>
    
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Planilla',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
