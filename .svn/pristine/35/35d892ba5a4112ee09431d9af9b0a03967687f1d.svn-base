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
   
	<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'id')
)); ?>
        <?php 
         echo $form->hiddenField($model,'estado',array('type'=>"hidden")); 
        if($model->estado==2){
        ?>
 <div class="row">
<div class="column">
		<?php echo $form->labelEx($model,'fechadesde'); ?>
		<?php   echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
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
                        'style' => 'width: 150px;'
                        ,'data-v'=>'',
                        'onchange'=>'Pagobeneficio.MostrarGestion()'
                    ),
                    ), true);?>
	</div>
    <div class="column">
		<?php echo $form->labelEx($model,'fechahasta'); ?>
		<?php   echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechahasta',
                    'value' => $model->fechahasta,
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy'
                       
              
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                        ,'data-v'=>''
                        ,
                        'onchange'=>'Pagobeneficio.MostrarGestion()'
                    ),
                    ), true);?>
	</div>
   
    
    </div>
    <div class="row">
    <div class="column">
    <?php echo $form->labelEx($model,'gestion'); ?>
    <?php echo $form->textField($model,'gestion',array('maxlength'=>60,'style' => 'text-transform: uppercase','disabled'=>true,'placeholder'=>'Gesion ...')); ?>


    </div>
    <div class="column">
    <?php echo $form->labelEx($model,'monto',array('label'=>'Monto a Distribuir(Bs.)')); ?>
    <?php echo $form->numberField($model,'monto',array('min'=>'1', 'style'=>'' ,'onchange'=>'Pagobeneficio.Decimales(this.value)')); ?>

    </div>
    
    </div>
  <?php
  }else{
      ?>
        <div class="row alert alter-info" <?php echo 'id="'.System::Id('contenedorMensaje').'"';?>>
            <h6>Existe Prima Anual por Consolidar...</h6>
        </div>
          <?php
  }
  ?>

    
    </div>
    <?php $this->endWidget(); ?>
    

              
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Pagobeneficio',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
