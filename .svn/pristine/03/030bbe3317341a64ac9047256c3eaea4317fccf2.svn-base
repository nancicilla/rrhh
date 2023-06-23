<?php
/* @var $this AreaController */
/* @var $model Area */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">   
	 <div class="row">
             <?php echo $form->hiddenField($model,'id'); ?>
             <?php echo $form->labelEx($model,'pempleado',array('label'=>'Empleado')); ?>
                                  <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'pempleado',
                'source' => $this->createUrl("entradasalida/autocompleteEmpleado"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {    
                          $('#' + Empleado.Id('id')).val(ui.item.id);
                                      
                                    }"
                ),
                'htmlOptions' => array(
                	'placeholder'=>'Empleado',
                    'style' => 'text-transform: uppercase;width:90%',
                    
                ),
                ));         

            ?>

        </div>
      
        
        <div class="row">
            <?php echo $form->labelEx($model, 'beneficio',array('label'=>'Seleccione')); ?>
           
            <?php
             $lista = Parentesco::model()->findAll("t.sexoe='M'");
       
           $this->widget('ext.select2.ESelect2', array(
                'id' => 'beneficio',
                'name' => 'beneficio',
                'value' => $lista,
                'data' =>  CHtml::listData(Parentesco::model()->findAll("t.sexoe='M'"), 'id', 'parentescod')
       ,
                'htmlOptions' => array(
                    'multiple' => 'multiple',
                    'style' => 'width:100%;'
                ),
                'options' => array(
                    'placeholder' => 'Introduzca Parentesco',
                    'allowClear' => true,
                ),
            ));
            ?>
        </div>
   <div class="row"  <?php echo 'id="'.System::Id('contenedorTipocContrato').'"';?>>
            <?php echo $form->labelEx($model,'tipocontrato',array('label'=>'Tipo Contrato')); ?>
            <?php
              $this->widget('ext.select2.ESelect2', array(
                'id' => 'tipocontrato',
                'name' => 'tipocontrato',
                'value' => $ltipocontratos,
                'data' => CHtml::listData(Tipocontrato::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'),
                'htmlOptions' => array(
                    'multiple' => 'multiple',
                    'style' => 'width:100%;'
                ),
                'options' => array(
                    'placeholder' => 'Seleccione...',
                    'allowClear' => true,
                ),
            ));
            ?>
   
    </div>   
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Empleado',
        'buttons' => array( 'impresion' => array(
                'label' => 'Imprimir PDF',
                'click' => 'Empleado.descargaReportefamiliaresedades()',
                'icon' => 'print',
                'width' => 130,),
            'impresionxls' => array(
                'label' => 'Imprimir EXCEL',
                'click' => 'Empleado.descargaReportefamiliaresedadesxls()',
                'icon' => 'print',
                'width' => 130,)
            )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
