<?php
/* @var $this HorarioespecialController */
/* @var $model Horarioespecial */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array()
)); ?>
    <div class="formWindow">
	<div class="row">
            <?php
                    echo System::widgetTabs(array(
                        'nameView' => 'Horarioespecial',
                        'height' => 420,
                        'tabs' => array(
                            'General' => array('id' => 'datosgeneral',
                                'content' => $this->renderPartial('_general', array('model' => $model,'fechaminima'=>$fechaminima, 'form' => $form), true),
                                'titleWidth' => 110,
                                'active' => true,
                            ),
                           'Asignacion Personal' => array('id' => 'personal',
                                'content' => $this->renderPartial('_asignacionpersonal', array('model' => $model, 'form' => $form,'listaempleado'=>$listaempleado), true),
                                'titleWidth' => 150, 'active' => true
                            ),


                        ),
                    ));?>
	</div>
        <div class="row alert alert-info" <?php echo 'id="'.System::Id('contenedorMensaje').'"';?>></div>

    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Horariolactancia',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
