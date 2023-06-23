<?php
/* @var $this PersonaController */
/* @var $model Persona */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'htmlOptions' => array('enctype' => 'multipart/form-data')
    ));
    ?>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <div class="formWindow">
        <?php echo $form->hiddenField($modele, 'activo'); ?>
        <?php echo $form->hiddenField($modele, 'idempleado'); ?>

        <?php echo $form->hiddenField($model, 'estadocivil'); ?>
        <div class="row alter alert-info " style="display:none"   <?php echo 'id="' . System::Id('contenedorMensaje') . '"'; ?>></div>
        <div class="row alter alert-info " style="display:none"   <?php echo 'id="' . System::Id('contenedorAguinaldo') . '"'; ?>>
         <?php echo $form->labelEx($model,'consegundoaguinaldo',array('label'=>'El empleado Recibirá Segundo Aguinaldo?')); ?>
        <?php echo $form->checkBox($model,'consegundoaguinaldo'); ?>    </div>
         
        </div>
      
        <div class="row "  <?php echo 'id="' . System::Id('contenedorRetiro') . '"'; ?>>
            <div class="row">  
                <div class="column">
                    <?php echo $form->labelEx($modele, 'idtiporetiro', array('label' => 'Seleccione el Tipo de Retiro...')); ?>
                    <?php echo $form->dropDownList($modele, 'idtiporetiro', CHtml::listData(Tiporetiro::model()->findAll(), 'id', 'nombre')); ?>

                </div>
                <div class="column">
                    <?php
                    echo $form->label($modele, 'fecharetiro', array('label' => 'Fecha Retiro'));
                    echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $modele,
                        'attribute' => 'fecharetiro',
                        'value' => $modele->fecharetiro,
                        'language' => 'es',
                        'options' => array(
                            'showAnim' => 'slideDown',
                            'showButtonPanel' => true,
                            'changeMonth' => true,
                            'changeYear' => true,
                            'dateFormat' => 'dd-mm-yy',
                            'minDate'=>$fechaminima
                        ),
                        'htmlOptions' => array(
                            'style' => 'width: 155px;',
                        ),
                            ), true);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <?php echo $form->labelEx($model, 'idformapago', array('label' => 'Forma de Pago')); ?>
                    <?php echo $form->dropDownList($model, 'idformapago', CHtml::listData(Formapago::model()->findAll(array('order'=>"nombre asc")), 'id', 'nombre'), array('onchange' => 'Persona.CargarOpcion(this.value)')); ?>
                </div>
                <div class="column">
                    <?php echo $form->labelEx($model, 'descripcionformapago', array('label' => 'Detalle forma de pago')); ?>
                    <?php echo $form->textField($model, 'descripcionformapago', array('style' => 'text-transform: uppercase')); ?>
                </div>
            </div>
            <div class="row">
                <h4>RC-IVA</h4>
                <div class="column">
                    <?php echo $form->labelEx($model, 'montorciva', array('label' => 'Monto Facturas RC-IVA(Bs.)' . '')); ?>
                    <?php echo $form->textField($model, 'montorciva', array('value' => 0, 'style' => 'text-transform: uppercase')); ?>
                </div>
            </div>
            <div class="row "  <?php echo 'id="' . System::Id('contenedorGrilla') . '"'; ?>>

                <div class="row" <?php echo 'id="' . System::Id('contenedorAbonos') . '"'; ?>>
                    <h4>Abonos </h4>
                    <?php
                    echo SGridView::widget('TGridView', array(
                        'id' => 'gridAbonos',
                        'dataProvider' => array(),
                        'buttonAdd' => true,
                        'buttonText' => '+',
                        'width' => 520,
                        'height' => 80,
                        'columns' => array(
                            array(
                                'header' => 'Descripcion ',
                                'name' => 'descripcion',
                                'width' => 30,
                                'style' => array('text-transform' => 'uppercase'),
                                'typeCol' => 'editable',
                            ),
                            array(
                                'header' => 'Monto(Bs.)',
                                'name' => 'monto',
                                'width' => 20,
                                'type' => 'number(2)',
                            ),
                            array(
                                'width' => 4,
                                'typeCol' => 'buttons',
                                'buttons' => array('delete'),
                            ),
                        ),
                    ));
                    ?>

                </div>
                <div class="row" <?php echo 'id="' . System::Id('contenedorAportacion') . '"'; ?>>
                    <h4>Deducciones </h4>
                    <?php
                    echo SGridView::widget('TGridView', array(
                        'id' => 'gridAportaciones',
                        'dataProvider' => array(),
                        'buttonAdd' => true,
                        'buttonText' => '+',
                        'width' => 520,
                        'height' => 80,
                        'columns' => array(
                            array(
                                'header' => 'Descripcion ',
                                'name' => 'descripcion',
                                'width' => 30,
                                'style' => array('text-transform' => 'uppercase'),
                                'typeCol' => 'editable',
                            ),
                            array(
                                'header' => 'Monto(Bs.)',
                                'name' => 'monto',
                                'width' => 20,
                                'type' => 'number(2)',
                            ),
                            array(
                                'width' => 4,
                                'typeCol' => 'buttons',
                                'buttons' => array('delete'),
                            ),
                        ),
                    ));
                    ?>

                </div>
            </div>
        </div>
    </div>   
<?php
echo System::Buttons(array(
    'nameView' => 'Persona',
    'buttons' => array()
));
?> 
    <?php $this->endWidget(); ?>



</div><!-- form -->
