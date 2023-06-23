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
   <div class="row"  >
       <div class="column"  > 
    <?php
   echo $form->labelEx($model,'fechadesde', array('label' => 'Fecha Desde' )); 
     echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechadesde',
                    'value' => $model->fechadesde,
                    'language' => 'es',                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                       
              
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;',
                        
                       
                    ),
                    ), true);?>
           </div>
       <div class="column"  >
                        <?php
      
                    echo $form->labelEx($model,'fechahasta', array('label' => 'Fecha Hasta' )); 
     echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechahasta',
                    'value' => $model->fechahasta,
                    'language' => 'es',                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                       
              
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;',
                        
                       
                    ),
                    ), true);

      ?>
    </div>
		
   </div>
    <div class="row"  >
         
            <?php
            $criteria=new CDbCriteria;             
            $criteria->order='t.nombre asc';
        
              $this->widget('ext.select2.ESelect2', array(
                'id' => 'tipocontrato',
                'name' => 'tipocontrato',
                'value' => $ltipocontratos,
                'data' => CHtml::listData(Tipocontrato::model()->findAll($criteria), 'id', 'nombre'),
                'htmlOptions' => array(
                    'multiple' => 'multiple',
                    'style' => 'width:100%;'
                ),
                'options' => array(
                    'placeholder' => 'Tipo Contrato',
                    'allowClear' => true
                ),
            ));
            ?>
   
    </div>
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Entradasalida',
        'buttons' => array(

            'planilla' => array(
                'label' => 'Descargar Excel',
                'click' => 'Entradasalida.descargarExcelReporteHorasAsistidas()',
                'icon' => 'download-alt',
                'width' => 130,)
        )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
