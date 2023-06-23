<?php
/* @var $this DeduccionesController */
/* @var $model Deducciones */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
    
	   <?php
        echo System::widgetTabs(array(
            'nameView' => 'Aportacionbeneficio',
            'height' => 420,
            'tabs' => array(
                'Datos Generales' => array('id' => 'Generales',
                    'content' => $this->renderPartial('_general', array('model' => $model, 'form' => $form), true),
                    'titleWidth' => 210,
                    'active' => true,
                ),
                'Cuentas Haber' => array('id' => 'Areas',
                    'content' => $this->renderPartial('_areas', array('model' => $model, 'listaareas' => $listaareas, 'form' => $form), true),
                    'titleWidth' => 110,

                ),
            ),
        ));
        ?> 
	
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Deducciones',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
