<?php
/* @var $this DeduccionesController */
/* @var $model Deducciones */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array()
)); ?>
    <div class="formWindow">
   
  <div class="row" >
     <div class="column">
        <?php                 
                echo $form->label($model, 'fecharegistro');
                echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fecharegistro',
                    
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'minDate'=>$fecharegistro
                        
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 150px;'
                    ),
                    ), true);

            ?>
     </div>
     
    
    </div>
    <div class="row">
    <?php echo $form->labelEx($model,'nombre'); ?>
    <?php echo $form->textArea($model,'nombre',array('rows'=>2, 'cols'=>15,'style'=>'Width:90%')); ?>
  </div>
    <div  <?php echo 'id="'.System::Id('contenedorLista').'"';?>>
  <?php echo $this->renderPartial('listaotrosgastos', array('lista' => $lista), true); ?>
    </div>
   

<h5 style="position: absolute; left: 12px; top: 555px;">Total
    <span class="badge" id="<?= System::Id('spanTotalSubClientes') ?>" style="font-size: 18px; font-weight: bold; color: black;">0 Bs.</span> 
</h5>
   <div style=" position: absolute; left: 30px; top: 520px !important;" ><span><img src="protected/modules/rrhh/images/excel1.png"   width="32" height="32"> </span></div>
                      
<div class="row" style="position: absolute; left: 60px; top: 520px;">

<div  <?php echo 'id="'.System::Id('fileExcel').'"';?>>

</div>
                    
   </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Otrosgastos',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
    
