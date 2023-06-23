<?php
/* @var $this BonosController */
/* @var $model Bonos */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    
)); ?>
        <div class="row">
            <div class="column">           
                <?php echo $form->labelEx($model,'opciones',array('label'=>'Planilla')); ?>
                <?php echo $form->dropDownList($model,'opciones',CHtml::listData(array(array('id'=>0,'nombre'=>''),array('id'=>1,'nombre'=>'Prefactura Sueldos y Salarios'),array('id'=>2,'nombre'=>'Prefactura Lactancia'),array('id'=>3,'nombre'=>'Prefactura Otros Bonos')),'id','nombre'),array('onchange'=>'Planilla.CargarOpcion(this.value)')); ?> 

          </div>
            <div class="column">
		<?php echo $form->labelEx($model,'id',array('label'=>'Mes')); ?>
		<?php 
                $criteria=new CDbCriteria;		
                $criteria->compare('t.porsistema',true);
                $criteria->order = 't.id desc ';
                echo $form->dropDownList($model,'id',CHtml::listData(Planilla::model()->findAll($criteria),'id','nombre'),array('empty'=>'')); ?>
            </div>
             
        </div>
     <div class="row"  <?php echo 'id="'.System::Id('contenedorEmpresasubempleadora').'"';?>>
            <?php echo $form->labelEx($model,'empresasubempleadora'); ?>
            <?php
              $this->widget('ext.select2.ESelect2', array(
                'id' => 'empresasubempleadora',
                'name' => 'empresasubempleadora',
                'value' => $lempresasubempleadora,
                'data' => CHtml::listData(Empresasubempleadora::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'),
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
   
    <div class="row"  <?php echo 'id="'.System::Id('contenedorMensaje').'"';?>></div>
   
  
 
    <?php
   echo System::Buttons(array(
        'nameView' => 'Planilla',
        'buttons' => array(

                        'planillas' => array(
                            'label' => 'Descargar Excel',
                            'click' => 'Planilla.descargarExcelPrefactura()',
                            'icon' => 'download-alt',
                            'width' => 130,)
            )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
