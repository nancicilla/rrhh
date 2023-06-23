<?php
/* @var $this MovimientopersonalController */
/* @var $model Movimientopersonal */
/* @var $form CActiveForm */
?>
<div class="container">
	<div class="offset-12">
		<div id="content">
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'idempleado')
)); ?>
    <div class="formWindow">
     	
       
        
          <?php  echo System::widgetTabs(array(
            'nameView' => 'Producto',
            'height' => 250,
            'tabs' => array(
                'Datos Generales'=> array('id' => 'Datos',
                    'content' => $this->renderPartial('_general', array('model' => $model,'fecha'=>$fecha,'areas'=>$areas,'secciones'=>$secciones,'puestotrabajos'=>$puestotrabajos, 'form' => $form), true),
                    'titleWidth' => 110,
                    'active' => true,
                ),
                'Horario' => array('id' => 'imagenes',
                    'content' => $this->renderPartial('_horariou', array('model' => $model,'form'=>$form,'Horarios'=>$Horarios), true),
                    'titleWidth' => 80, 'active' => true
                ),
                
               
            ),
        ));?>
        
        
        
        
        
        
        


	
     
    </div>
    <?php
    echo System::Buttons(array(
         'nameView' => 'Persona',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
</div>
	</div>
</div>
