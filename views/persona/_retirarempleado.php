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
       
       
        <div class="row "  <?php echo 'id="' . System::Id('contenedorRetiro') . '"'; ?>>
            <div class="row">  
              
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
                        ),
                        'htmlOptions' => array(
                            'style' => 'width: 155px;',
                        ),
                            ), true);
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
