<?php

/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'')
)); ?>
    <div class="formWindow">
     
    <?php echo $form->hiddenField($model,'id'); ?>
       <div class=" alert alert-info">
        <?php    echo $model->nombre; ?>
              <div class="row " <?php echo 'id="'.System::Id('contmensaje').'"';?>> 
              </div>
		
	</div>
       <?php
       echo $listafiniquitos;
       
       ?>
       <div class="row">
            <h5 style=" text-decoration: underline;">Seleccione a los empleados que recibieron su Finiquito</h5>
            <?php

echo SGridView::widget('TGridView', array(
        'id' => 'gridEmpleados',
        'dataProvider' => $listaretirados,
        'buttonAdd' => false,
          'width' => 430,
        'height' => 250,
        'columns' => array( 
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'  
                
            ),
             array(
               'header' => 'Empleado',
                'name' => 'nombrecompleto',
                'width' => 30,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'uneditable',

            ),             
            array( 
                 'header' => 'Seleccionar',
                'name' => 'estado',
                'typeCol' => 'checkbox',
                'width' => 10,
            ),
              
         
               
            
              

           
        ),
    ));

	 ?>
	 	
        </div>
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Planilla',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
