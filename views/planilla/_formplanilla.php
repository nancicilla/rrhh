<?php
/* @var $this BonosController */
/* @var $model Bonos */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    
)); ?>
    <div class="formWindow" id="pl">
    <div class="row">
        <div class="column">
            <?php echo $form->hiddenField($model,'id'); ?>
            <?php echo $form->labelEx($model,'opciones'); ?>
            <?php echo $form->dropDownList($model,'opciones',CHtml::listData(array(array('id'=>1,'nombre'=>''),array('id'=>2,'nombre'=>'Planilla General'),array('id'=>3,'nombre'=>'Planilla C.N.S.'),array('id'=>4,'nombre'=>'Planilla AFP'),array('id'=>5,'nombre'=>'Planilla de Descuentos'),array('id'=>6,'nombre'=>'Cálculo Indemnizacion y Aguinaldos'),array('id'=>7,'nombre'=>'Otros Bonos'),array('id'=>8,'nombre'=>'RC-IVA'),array('id'=>9,'nombre'=>'RC-IVA (CSV)')),'id','nombre'),array('onchange'=>'Planilla.CargarOpcion(this.value)')); ?> 

        </div>
        <div class="column">
            <?php echo $form->labelEx($model,'descripcion',array('label'=>'Nombre')); ?>
            <?php echo $form->textField($model,'descripcion',array('maxlength'=>30,'style' => 'text-transform: uppercase','placeholder'=>'Nombre de la Planilla...')); ?>
        </div>
    </div>
    <div class="row" style="display: none;"  <?php echo 'id="'.System::Id('contenedorOpcionAFP').'"';?>>
        <?php echo $form->labelEx($model,'opcionafp',array('label'=>'Seleccione una AFP')); ?>
        <?php echo $form->dropDownList($model,'opcionafp',CHtml::listData(Afp::model()->findAll(),'id','nombre')); ?>   
    </div>
   
   <div class="row" style="display: none;"  <?php echo 'id="'.System::Id('contenedorOpcionDescuento').'"';?>>
        <?php echo $form->labelEx($model,'opcionDescuento',array('label'=>'Descargar con  AFP?')); ?>
        <?php echo $form->checkBox($model,'opcionDescuento'); ?>   
    </div>
 <div class="row" >
    <div class="column" <?php echo 'id="'.System::Id('contenedorOpciones0').'"';?>>
        <?php echo $form->labelEx($model,'ordenarNombre',array('label'=>'Ordenar por Nombre del Empleado?')); ?>
        <?php echo $form->checkBox($model,'ordenarNombre'); ?>    </div>
    <div class="column" <?php echo 'id="'.System::Id('contenedorOpciones1').'"';?>>
        <?php echo $form->labelEx($model,'separarNombre',array('label'=>'Separar Nombre Completo del Empleado?')); ?>
        <?php echo $form->checkBox($model,'separarNombre'); ?>    </div>
         
    </div>
</div>
<div <?php echo 'id="'.System::Id('contenedorOpciones').'"';?>>
    <div class="row"  >
        <div class="column" >
            <?php echo $form->labelEx($model,'mostrarBeneficioDesglosada',array('label'=>'Desea desglosar Beneficios?')); ?>
            <?php echo $form->checkBox($model,'mostrarBeneficioDesglosada',array('onchange'=>'Planilla.mostrarListaBeneficio()')); ?>    </div>
        <div class="column" style="padding-left: 2.7em;">
            <?php echo $form->labelEx($model,'mostrarAportacionDesglosada',array('label'=>'Desea desglosar Aportaciones ?')); ?>
            <?php echo $form->checkBox($model,'mostrarAportacionDesglosada', array('onchange'=>'Planilla.mostrarListaAportaciones()' )); ?>    </div>
        </div>
</div>
    <div class="row"  style="display:none;" <?php echo 'id="'.System::Id('contenedorTipocContrato').'"';?>>
            <?php echo $form->labelEx($model,'tipocontrato'); ?>
            <?php
              $this->widget('ext.select2.ESelect2', array(
                'id' => 'tipocontratos',
                'name' => 'tipocontratos',
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
    <div class="row"  style="display:none;" <?php echo 'id="'.System::Id('contenedorTipoIndemnizacion').'"';?>>
            <?php echo $form->labelEx($model,'tipoindemnizacion',array('label'=>'Tipo Indemnizacion')); ?>
            <?php
             echo $form->dropDownList($model,'tipoindemnizacion',CHtml::listData(Aportacionbeneficio::model()->findAll("t.nombre like '%INDEM%'"),'id','nombre'));
            ?>
   
    </div>
    <div <?php echo 'id="'.System::Id('contenedorOpcioneso').'"';?>>
            <?php echo $form->labelEx($model, 'area'); ?>           
            <?php           
                $this->widget('ext.select2.ESelect2', array(
                'id' => 'area',
                'name' => 'area',
                'value' => $lareas,
                'data' => CHtml::listData(Area::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'),
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
    <div class="row"   <?php echo 'id="'.System::Id('contenedorBA').'"';?>>
	<div class="column" <?php echo 'id="'.System::Id('contenedorBeneficio').'"';?>>    
	 <?php

echo SGridView::widget('TGridView', array(
        'id' => 'gridBeneficios',
        'dataProvider' => $lbeneficio,
        'buttonAdd' => false,
          'width' => 350,
        'height' => 250,
        'columns' => array(
           
            
          
             array(
               'header' => 'Beneficios',
                'name' => 'nombre',
                
                'width' => 30,
              
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'uneditable',

            ),
               array( 
                'name' => 'nombref',
                 'typeCol' => 'hidden'
                
                 
                
            ),
                 array( 
                'name' => 'orden1',
                 'typeCol' => 'hidden'
                
                 
                
            ),
              array( 
                 'header' => 'Seleccionar',
                'name' => 'estado',
                'typeCol' => 'checkbox',
                'width' => 10,
            ),
              
         
               
            
              

           
        ),
    ));

	 ?>
	 	
	 </div>
    
     <div class="column" <?php echo 'id="'.System::Id('contenedorAportacion').'"';?>>
    
     <?php

echo SGridView::widget('TGridView', array(
        'id' => 'gridAportaciones',
        'dataProvider' => $laportacion,
        'buttonAdd' => false,
         'width' => 350,
        'height' => 250,
        'columns' => array(
           
            
          
             array(
               'header' => 'Aportaciones',
                'name' => 'nombre',
                
                'width' => 30,
              
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'uneditable',

            ),
               array( 
                'name' => 'nombref',
                 'typeCol' => 'hidden'
                
                 
                
            ),
                 array( 
                'name' => 'orden1',
                 'typeCol' => 'hidden'
                
                 
                
            ),
              array( 
                 'header' => 'Seleccionar',
                'name' => 'estado',
                'typeCol' => 'checkbox',
                'width' => 10,
            ),
              
         
               
            
              

           
        ),
    ));

     ?>
        
     </div>
    </div>
    </div>
    <div class="row" <?php echo 'id="'.System::Id('contenedorMensaje').'"';?>>
        
    </div>
    </div>
    <?php
   echo System::Buttons(array(
        'nameView' => 'Planilla',
        'buttons' => array(

                        'planillas' => array(
                            'label' => 'Descargar Excel',
                            'click' => 'Planilla.descargarExcelPlanilla()',
                            'icon' => 'download-alt',
                            'width' => 130,)
            )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
