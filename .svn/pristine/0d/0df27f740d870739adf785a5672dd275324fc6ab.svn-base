<?php
/* @var $this SeguimientoempleadoController */
/* @var $model Seguimientoempleado */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'idempleado')
)); ?>
    <div class="formWindow">
    <?php 
                echo $form->hiddenField($model,'idcrugeuser'); 

       ?>
	 <div class="row">
                Usuario : <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'crugeuser',
                'source' => $this->createUrl("seguimientoempleado/autocompleteUsuario"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {
                                  $('#'+Seguimientoempleado.Id('idcrugeuser')).val(ui.item.id);     
                                      
                                    }"
                ),
                'htmlOptions' => array(
                	'placeholder'=>' Usuario',
                    
                    
                ),
            ));
		
          

                 ?>

                                </div>
    
	<div class="row">
		 <?php
            
  
echo SGridView::widget('TGridView', array(
        'id' => 'gridEmpleados',
        'dataProvider' =>array(),       
         'buttonAdd' => true,
        'buttonText' => '+',        
        'height' => 250,    
        'columns' => array(           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
                
            ),
            
             array(
                'header' => 'Nombre Completo',
                'name' => 'nombrecompleto',
                'searchUrl' => 'seguimientoempleado/BuscarEmpleado(estado==-1)',
                'searchCopyCol' => 'id',
                'nextFocus' => '[row]nombrecompleto',
                'searchHeight' => 100,
                'searchWidth' => 220,
                'value' => '$data->nombrecompleto == null? "" : $data->nombrecompleto',
                'width' => 10,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
                
            ),
            array(
             
                'name' => 'estado',
                'valueDefault' => '-1',
                'typeCol' => 'hidden',
               
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
        'nameView' => 'Seguimientoempleado',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
