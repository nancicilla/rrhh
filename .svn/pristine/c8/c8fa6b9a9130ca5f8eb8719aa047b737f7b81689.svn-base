<?php
/* @var $this SubsidioController */
/* @var $model Subsidio */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'focus' => array($model, 'idempleado'),
    ));
    ?>
    <div class="formWindow">

        <?php
        echo System::widgetTabs(array(
            'nameView' => 'Subsidio',
            'height' => 400,
            'tabs' => array(
                'Datos Generales' => array('id' => 'Datogeneral',
                    'content' => $this->renderPartial('_datogeneral', array('model' => $model, 'form' => $form), true),
                    'titleWidth' => 110,
                    'active' => true,
                ),
                'Horario Lactancia' => array('id' => 'Lactancia',
                    'content' => $this->renderPartial('_horariolactancia', array('model' => $model, 'form' => $form, 'horariolactancias' => $horariolactancias), true),
                    'titleWidth' => 110,
                ),
            ),
        ));
        ?> 
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Subsidio',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
