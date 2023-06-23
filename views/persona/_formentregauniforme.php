<?php
/* @var $this PersonaController */
/* @var $model Persona */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
   
    'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
    <div class="formWindow">
    
     <div class="row">
	<?php echo '<strong>Empleado:</strong>'. $model->idpersona0->nombre." ".$model->idpersona0->apellidop." ".$model->idpersona0->apellidom.'<br><br>'   

    	?>
    </div>

        <?php
                echo System::widgetTabs(array(
            'nameView' => 'Uniforme',
            'height' => 355,
            'tabs' => array(
                'Entrega de Uniforme' => array('id' => 'entrega',
                    'content' => $this->renderPartial('_entregau', array('modeleu' => $modeleu,'form' => $form), true),
                    'titleWidth' => 310,
                    'active' => true,
                ),
                'Devolución Uniforme' => array('id' => 'devolucion',
                    'content' => $this->renderPartial('_devolucionu', array('modeleud' => $modeleud,'listauniformes' => $listauniformes,'form' => $form), true),
                    'titleWidth' => 310, 'active' => true
                ),
                
               
            ),
        ));
        ?> 
    
   
    <?php
    echo System::Buttons(array(
        'nameView' => 'Persona',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>



</div><!-- form -->
