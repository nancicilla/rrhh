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
  <div class="column">
    <?php
          echo $form->label($model, 'fechadesde',array('label'=>'Fecha'));
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
                        'dateFormat' => 'dd-mm-yy'  ,
                        'minDate'=>$fechaminima
                        
                    ),
                    'htmlOptions' => array(
                       'style' => 'width: 155px;',
                   

                    ),
                    ), true);
         
?>    </div>
<div class="column">
		<?php echo $form->labelEx($model,'dias',array('label'=>'Dias')); ?>
		<?php      

            echo $form->numberField($model,'dias',array('step'=> '0.001','value'=>'0.100',"min"=>"0.100",  'style' => 'width: 55px;'));
        ?>
	</div>
     <div class="column">
		<?php echo $form->labelEx($model,'tipo',array('label'=>'Seleccion..')); ?>
		<?php echo $form->dropDownList($model,'tipo',CHtml::listData(array(array('id'=>'1','nombre'=>''),array('id'=>'2','nombre'=>'Mujeres'),array('id'=>'3','nombre'=>'Varones'),array('id'=>'4','nombre'=>'Todos')),'id','nombre'),array('onchange'=>'Vacaciones.mostrarOpcion(this.value)')); ?>
	</div>
</div>
        <div class="row">
            <?php echo $form->labelEx($model,'observacion',array('label'=>'Detalle')); ?>
        <?php echo $form->textArea($model,'observacion', array('maxlength' => 300,'style' => 'width: 77%;')); ?>
    </div>
        <div class="row " <?php echo 'id="'.System::Id('contempleados').'"';?>>
   
   <?php

echo SGridView::widget('TGridView', array(
        'id' => 'gridEmpleados',
        'dataProvider' => $listaempleados,       
         'buttonAdd' => true,
        'buttonText' => '+',        
        'height' => 260,       
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
                'name' => 'tipo',
                'value' => '$data->tipo',
                'typeCol' => 'hidden'
                
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

 
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Vacaciones',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->