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
        <div class="row "  <?php echo 'id="' . System::Id('contenedorGrilla') . '"'; ?>>

            <div class="row">
                <div class="column">
                    <?php echo $form->labelEx($model, 'idtiporetiro', array('label' => 'Tipo de Retiro')); ?>
                    <?php echo $form->dropDownList($model, 'idtiporetiro', CHtml::listData(Tiporetiro::model()->findAll(), 'id', 'nombre'), array('empty' => '')); ?>
                </div>
                <div class="column">
                    <?php
                    echo $form->label($model, 'fecharetiro', array('label' => 'Fecha Retiro'));

                    echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'fecharetiro',
                        'value' => $model->fecharetiro,
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
                    <?php echo $form->labelEx($model, 'idformapago'); ?>
                    <?php echo $form->dropDownList($model, 'idformapago', CHtml::listData(Formapago::model()->findAll(), 'id', 'nombre'), array('empty' => '','onchange'=>'Pagobeneficio.CargarOpcion(this.value)')); ?>
                </div>
                <div class="column">
                    <?php
                    echo $form->label($model, 'infoadicionalformapago');
                    echo $form->textField($model, 'infoadicionalformapago', array('maxlength' => 30)); 
                    ?>
                </div>
            </div>         
               <div class="row">
                <h4>RC-IVA</h4>
                <div class="column">
                    <?php
                    echo $form->labelEx($model, 'prciva', array('label' => 'Monto Total Facturas'
                        . '(Bs.)'
                        . ''));
                    ?>
<?php echo $form->textField($model, 'prciva', array('style' => 'text-transform: uppercase')); ?>
                </div>
            </div>
           
         
            <div class="row" <?php echo 'id="' . System::Id('contenedorAportacion') . '"'; ?>>
                <h4>Abonos </h4>
                <?php
                echo SGridView::widget('TGridView', array(
                    'id' => 'gridAbonos',
                    'dataProvider' => $beneficios,
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
                'buttons'=>array('delete'),
                
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
                    'dataProvider' => $listadeducciones,
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
                'buttons'=>array('delete'),
                
            ),
                    ),
                ));
                ?>

            </div>
        </div>
    </div>   
    <?php
    echo System::Buttons(array(
        'nameView' => 'Pagobeneficio',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>
</div><!-- form -->
