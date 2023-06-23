<?php
/* @var $this VacacionesController */
/* @var $model Vacaciones */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    
)); ?>
    <div class="formWindow">
  
<div class="row">
    <div class="column">
    <?php
          echo $form->label($model, 'fechadesde',array('label'=>'Desde'));
          echo $form->dropDownList($model,'fechadesde',CHtml::listData($gestion,'id','esquema'),array('empty'=>'','onchange'=>'Empleado.ActualizarGestion(this.value)'));
  
         
?>    </div>
  
 <div class="column">
    <?php
          echo $form->label($model, 'fechahasta',array('label'=>'Hasta'));
          echo $form->dropDownList($model,'fechahasta',CHtml::listData($gestion,'id','esquema'),array('empty'=>'','onchange'=>'Empleado.ValidarGestion()'));
  
         
?>    </div>
   
    </div>
         <div class="row"  >
            <?php echo $form->labelEx($model,'tipocontrato',array('label'=>'Tipo Contratos')); ?>
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
        'buttons' => array(
             'reporte' => array(
                            'label' => 'Imprimir',
                            'click' => 'Empleado.descargarReporte(\'DescargarReporteIndiceDesersion\')',
                            'icon' => 'print',
                            'width' => 130,)
        )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
