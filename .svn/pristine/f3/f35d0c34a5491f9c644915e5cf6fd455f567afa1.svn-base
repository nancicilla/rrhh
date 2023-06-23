<?php
/* @var $this HorarioController */
/* @var $model Horario */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
          <div class="row">
            <?php
               

                        
                echo $form->label($model, 'fechainicio', array('label' => 'Fecha Inicio' ));
                echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechainicio',
                    'value' => $model->fechainicio,
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'minDate'=>$fecha
                        
              
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                        ,'data-v'=>''
                    ),
                    ), true);
//            echo '==>> '.$model->scenario;
            ?>
        </div>
        <div class="row">
            
            <?php
             
echo SGridView::widget('TGridView', array(
        'id' => 'gridEmpleados',
        'dataProvider' => $listaempleados,       
         'buttonAdd' => $estado,
        'buttonText' => '+',        
        'height' => 300,
         'eventAfterEdition' => 'Horario.Quitarboton();',
       
        'columns' => array(           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
                
            ),
            
              array(
                'header' => 'Nombre Completo',
                'name' => 'nombrecompleto',
                'searchUrl' => 'horario/BuscarEmpleado(editar==-1)',
                'searchCopyCol' => 'id',
                'searchHeight' => 100,
                'searchWidth' => 220,
                'value' => '$data->nombrecompleto == null? "" : $data->nombrecompleto',
                'width' => 10,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
                
            ),
              array(
                'header' => 'Fecha Inicio',
                'name' => 'fechainicio',
                'value' => '$data->fechainicio',
                'width' => 10,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable(editar==-1)',
               
            ),
             array(
                'header'=>'Selecionar Empleado',
                'name' => 'limpiar',
                 'typeCol' => 'checkbox',
                 'width' => 10,
                 'valueDefault' => true
            ),
            array(
             
                'name' => 'estado',
                'value' => '$data->estado',
                'valueDefault' => '-1',
                'typeCol' => 'hidden',
               
            ),array(
             
                'name' => 'editar',
                'value' => '$data->editar',
                'valueDefault' => '-1',
              'typeCol' => 'hidden',
               
            ),
              array(
             
                'name' => 'colorear',
                'value' => '$data->colorear',
                'valueDefault' => '-1',
              'typeCol' => 'hidden',
               
            ),  

           
        ),
    ));
?>
        </div>
   
        


     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Horario',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
Horario.colorear();
</script>