<?php
/* @var $this MovimientopersonalController */
/* @var $model Movimientopersonal */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'idempleado')
)); ?>
    <div class="formWindow">



    <!-------- desde aqui---------->
   
   <?php echo System::widgetTabs(array(
            'nameView' => 'Movimientopersonal',
            'height' => 225,
            'tabs' => array(
               
                 'DatosGenerales' => array('id' => 'general',
                    'content' => $this->renderPartial('_general', array('form'=>$form,'model'=>$model,'areas'=>$areas,'secciones'=>$secciones,
                    'puestotrabajos'=>$puestotrabajos,
                    'sueldos'=>$sueldos,
                    'contrato'=>$contrato), true),
                    'titleWidth' => 120,
                    'active' => true,
                ),
                'Horarios'=>array('id' => 'horario',
                    'content' => $this->renderPartial('_horario', array('model'=>$model,'horarios'=>$horarios,'nombre'=>$nombre,'form'=>$form), true),
                    'titleWidth' => 120,),
               
            ),
        ));
        ?>
    <!--hasta aqui--->
   
	
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Movimientopersonal',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
