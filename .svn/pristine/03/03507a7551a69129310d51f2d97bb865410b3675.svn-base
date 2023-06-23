<?php
/* @var $this AsistenciaController */
/* @var $model Asistencia */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
   
)); ?>
    <div class="formWindow">
   
	<?php
     if (is_null($model)){
        echo '<div class="alert alert-info"> No se ha geneerado ningun corte....</div>';
     }else{
echo"AQUIIII";
     
    $cadena='';
       $ahora = time();
                $unDiaEnSegundos = 24 * 60 * 60;
                $ayer = $ahora - $unDiaEnSegundos;    
                $ayer= date("d-m-Y", $ayer);
   $fecha = new DateTime();
                $fecha->modify('last day of this month+1');
    echo '<h4>Corte de Planilla</h4>';
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
     
 echo '<p><strong>'.$model->fechadesde.'</strong></p>';
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
      echo '<p><strong>'.$model->fechaic.'</strong></p>';
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
    
     }
 

    ?>
   
	
     
    </div>
    <?php

   

  echo System::Buttons(array(
        'nameView' => 'Asistencia',
        'buttons' => array(


            )
    ));

   
    
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
