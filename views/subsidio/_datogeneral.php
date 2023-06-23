<div >
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
        echo $form->textField($model, 'fechanacbebe', array( 'readonly' => 'readonly'));
        ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'numbebe'); ?>
        <?php echo $form->numberField($model, 'numbebe'); ?>
    </div>
     <div class="row">
        <?php
        echo $form->labelEx($model, 'fechadesde', array( 'label' => 'Fecha Inicio Horario Lactancia'));
        echo $form->textField($model, 'fechadesde', array( 'readonly' => 'readonly'));
        ?>
    </div>
     <div class="row">
        <?php
        echo $form->labelEx($model, 'fechahasta', array( 'label' => 'Fecha Fin Horario Lactancia'));
        echo $form->textField($model, 'fechahasta', array( 'readonly' => 'readonly'));
        ?>
    </div>
</div>