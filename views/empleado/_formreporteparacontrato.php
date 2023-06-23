<?php
/* @var $this VacacionesController */
/* @var $model Vacaciones */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    
)); ?>
    <div class="formWindow">
  <h5>Ingreso</h5>
<div class="row">
    
    <div class="column">
        
    <?php
          echo $form->label($model, 'fechadesde',array('label'=>'Desde'));
          echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechadesde',
                    
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
                        'onchange'=>'Empleado.actualizarFecha(this.value)'
                        
                       

                    ),
                    ), true);
         
?>    </div>
  
 <div class="column">
    <?php
          echo $form->label($model, 'fechahasta',array('label'=>'Hasta'));
          echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechahasta',
                    
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
         <div class="row"  >
            <?php echo $form->labelEx($model,'tipo',array('label'=>'Bonos')); ?>
            <?php
     
             
              echo SGridView::widget('TGridView', array(
        'id' => 'tipo',
        'dataProvider' => $listaBonos,
        'buttonAdd' => false,
          'width' => 460,
        'height' => 250,
        'columns' => array(
           
             array(
                'name' => 'id',
                'typeCol' => 'hidden'
            ),
          
             array(
               'header' => 'Beneficios',
                'name' => 'nombre',
                
                'width' => 30,
              
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'uneditable',

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
    <?php
    echo System::Buttons(array(
        'nameView' => 'Empleado',
        'buttons' => array(
             'reporte' => array(
                            'label' => 'Imprimir',
                            'click' => 'Empleado.descargarReporte(\'DescargarReporteIParaContrato\')',
                            'icon' => 'print',
                            'width' => 130,)
        )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
