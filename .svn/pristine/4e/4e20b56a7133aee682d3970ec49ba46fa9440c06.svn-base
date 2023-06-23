<?php
/* @var $this TmpentradasalidaController */
/* @var $model Tmpentradasalida */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'ci')
)); ?>
    <div class="formWindow">
    
	  <div  <?php echo 'id="'.System::Id('contenedorListaImportacion').'"';?>>
  <?php echo $this->renderPartial('_tabla', array('lista' => $lista), true); ?>
    </div>
   

  <div style=" position: absolute; left: 30px; top: 410px !important;" ><span><img src="protected/modules/rrhh/images/excel1.png"   width="32" height="32"> </span></div>
<div class="row" style="position: absolute; left: 60px; top: 400px;">

<div  <?php echo 'id="'.System::Id('fileExcel').'"';?>>

</div>
                    
   </div>

     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Tmpentradasalida',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
