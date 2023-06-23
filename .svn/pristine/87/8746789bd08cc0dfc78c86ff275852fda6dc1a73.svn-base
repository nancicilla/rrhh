<?php
/* @var $this VacacionesController */
/* @var $model Vacaciones */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    
)); ?>
    <div class="formWindow">
   


  <div class="row">
    <?php
          echo $form->label($model, 'fechadesde',array('label'=>'Fecha '));
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
                        
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 155px;'
                   

                    ),
                    ), true);
         
?>    </div>
        <div class="row">
        <?php 
         echo $form->label($model, 'descripcion',array('label'=>'Descripcion '));
        echo $form->textArea($model, 'descripcion', array('rows'=>2, 'cols'=>15,'style'=>'Width:90%')); ?>
            </div>
   <?php
   

echo SGridView::widget('TGridView', array(
        'id' => 'gridEmpleados',
        'dataProvider' => $listaempleados,       
         'buttonAdd' => true,
        'buttonText' => '+',        
        'height' => 280,
       
        'columns' => array(           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
                
            ),
             array(
                'header' => 'Nombre Completo',
                'name' => 'nombrecompleto',
                'searchUrl' => 'horario/BuscarEmpleado',
                'searchCopyCol' => 'id',
                'searchHeight' => 100,
                'searchWidth' => 220,
                'value' => '$data->nombrecompleto == null? "" : $data->nombrecompleto',
                'width' => 10,
                   'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
                
            ),
              array( 
                'name' => 'horas',
                'header'=>'Horas',
                'width' => 10,
            'type' => 'number(10,2)',
            'typeCol' => 'editable',
                
            ),
             
                array(
                'width' => 4,
                'typeCol' => 'buttons',
                'buttons'=>array('delete'),
                
            ),

           
        ),
    ));

?>



 
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Historialbancohoras',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
