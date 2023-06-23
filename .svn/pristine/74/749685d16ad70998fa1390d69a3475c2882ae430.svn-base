<?php
/* @var $this PagobeneficioController */
/* @var $model Pagobeneficio*/
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'id')
)); ?>
    <div class="formWindow">
   
	
 <div class="row">
      
 <?php
                 
        
                echo $form->label($model, 'id',array('label'=>'Seleccione ...'));
                echo $form->dropDownList($model,'id',CHtml::listData( $listaempleado ,'id','nombrecompleto'),array('empty'=>''));

            ?>  
      </div>
          <div class="row">
      
 <?php
                 
        
                echo $form->label($model, 'idtiporetiro',array('label'=>'Tipo de Retiro'));
                echo $form->dropDownList($model,'idtiporetiro',CHtml::listData( Tiporetiro::model()->findAll() ,'id','nombre'),array('empty'=>''));

            ?>  
      </div>
            <div class="row">
		 <?php echo $form->label($model, 'fecha',array('label'=>'Fecha Presentacion')); ?>

		<?php   echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fecha',
                    'value' => $model->fecha,
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                       
              
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                        ,'data-v'=>''
                        
                    ),
                    ), true);?>
	</div>
    

              
     
    
        <div class="row">
		<?php echo $form->labelEx($model,'sueldo'); ?>
		<?php echo $form->textField($model,'sueldo',array('maxlength'=>60,'style' => 'text-transform: uppercase','placeholder'=>'Sueldo a Imprimir...')); ?>
	</div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Historialestadoempleado',
        'buttons' => array(
            'baja' => array(
                'label' => 'Imprimir',
                'click' => 'Historialestadoempleado.ReporteBajaCaja()',
                'icon' => 'print',
                'width' => 130,)
        )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
