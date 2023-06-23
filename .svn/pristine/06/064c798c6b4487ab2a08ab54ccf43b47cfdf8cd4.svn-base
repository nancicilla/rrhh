<?php
/* @var $this BonosController */
/* @var $model Bonos */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    
)); ?>
    <div class="formWindow" id="pl">
   
   <div class="row" >
        <div class="column">
    <?php
          echo $form->label($model, 'fechai',array('label'=>'Desde'));
             echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechai',
                    'value' => $model->fechai,
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
         
?>    </div>
       <div class="column">
    <?php
          echo $form->label($model, 'fechaf',array('label'=>'Hasta'));
             echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechaf',
                    'value' => $model->fechaf,
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
         
?>    </div>
    </div>
    </div>
    <?php
   echo System::Buttons(array(
        'nameView' => 'Planilla',
        'buttons' => array(

                        'descargar' => array(
                            'label' => 'Imprimir',
                            'click' => 'Permiso.Imprimirpermisosinconstancia()',
                            'icon' => 'print',
                            'width' => 130,)
            )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
