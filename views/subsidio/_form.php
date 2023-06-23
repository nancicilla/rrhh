<?php
/* @var $this SubsidioController */
/* @var $model Subsidio */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'focus' => array($model, 'idempleado')
    ));
    ?>
    <div class="formWindow">

        <div class="row">
            <?php
            echo $form->hiddenField($model, 'idempleado');
            echo $form->labelEx($model, 'idempleado', array('label' => 'Empleado'));
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'empleado',
                'source' => $this->createUrl("subsidio/autocompletePersona"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {
                                        $('#' + Subsidio.Id('idempleado')).val(ui.item.id);
                                        Subsidio.dameBeneficiaria(ui.item.id);
                                   
                                    }"
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Buscar Empleado...',
                    'style' => 'width: 100%;text-transform: uppercase;',
                ),
            ));
            ?>

        </div>

        <div class="row" style="display:none" <?php echo 'id="' . System::Id('contenedorBeneficiaria') . '"'; ?>>

            <?php echo $form->labelEx($model, 'iddependiente');
            ?>
            <?php echo $form->dropDownList($model, 'iddependiente', CHtml::listData(array(), 'id', 'nombre'), array('empty' => '')); ?>
        </div>



        <div class="row">
            <?php
            echo $form->labelEx($model, 'fechar');
            echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'fechar',
                'value' => $model->fechar,
                'language' => 'es',
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                ),
                'htmlOptions' => array(
                    'style' => 'width: 150px;'
                    , 'data-v' => ''
                ),
                    ), true);
            ?>

        </div>

        <div class="row">
            <?php
            echo $form->labelEx($model, 'fechaiqmes');
            echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'fechaiqmes',
                'value' => $model->fechaiqmes,
                'language' => 'es',
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                ),
                'htmlOptions' => array(
                    'style' => 'width: 150px;'
                    , 'data-v' => ''
                ),
                    ), true);
            ?>

        </div>

        <div class="row">
            <?php
            echo $form->labelEx($model, 'fechanacbebe');
            echo $form->textField($model, 'fechanacbebe', array('readonly' => 'readonly'));
            ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'numbebe'); ?>
            <?php echo $form->numberField($model, 'numbebe'); ?>
        </div>



    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Subsidio',
        'buttons' => array()
    ));
    ?> 
    <?php $this->endWidget(); ?>

</div><!-- form -->
