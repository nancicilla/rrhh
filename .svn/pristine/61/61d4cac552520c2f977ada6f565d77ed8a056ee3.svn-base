<?php
/* @var $this PagobeneficioController */
/* @var $model Pagobeneficio*/
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'id')
)); ?>
    <div class="formWindow">
        <div class="row alert alert-info">
            <p>Nota: Una vez eliminado el empleado y guardado la información,No se podra adicionar al empleado... </p>
        </div>
	<div class="row" >
               <?php echo $form->labelEx($model, 'horastrabajo',array('label'=>'Horas de Trabajo')); ?>
    
            <?php

echo SGridView::widget('TGridView', array(
        'id' => 'gridListaEmpleados',
        'dataProvider' => $listaempleados,       
         'buttonAdd' => false,
        'buttonText' => ' ',        
        'height' => 400,
       
        'columns' => array(           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
                
            ),
             
               array(
                'header'=>'Empleados',
                'name' => 'empleados',
                'width' => 30,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',

                

                
            ),
            array(
                'header'=>'Estado',
                'name' => 'estado',
                'width' => 10,
               
                'style' => array('text-transform' => 'uppercase'),
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
        'nameView' => 'Pagobeneficio',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
