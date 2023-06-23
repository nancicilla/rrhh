<?php
/* @var $this AportacionbeneficioController */
/* @var $model Aportacionbeneficio */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'focus' => array($model, 'nombre')
    ));
    ?>
    <div class="formWindow">
         <div class="row">
		<?php echo $form->labelEx($model,'mes'); ?>
		<?php echo $form->dropDownList($model,'mes',CHtml::listData(
                        array(array('id'=>1,'nombre'=>'ENERO'),array('id'=>2,'nombre'=>'FEBRERO'),array('id'=>3,'nombre'=>'MARZO'),array('id'=>4,'nombre'=>'ABRIL'),array('id'=>5,'nombre'=>'MAYO'),array('id'=>6,'nombre'=>'JUNIO'),array('id'=>7,'nombre'=>'JULIO'),array('id'=>8,'nombre'=>'AGOSTO'),array('id'=>9,'nombre'=>'SEPTIEMBRE'),array('id'=>10,'nombre'=>'OCTUBRE'),array('id'=>11,'nombre'=>'NOVIEMBRE'),array('id'=>12,'nombre'=>'DICIEMBRE')),'id','nombre')); ?>
	</div>



    </div>
<?php
echo System::Buttons(array(
    'nameView' => 'Aportacionbeneficio',
    'buttons' => array('bonomensual' => array(
                'label' => 'Imprimir',
                'click' => 'Aportacionbeneficio.Reportebonoantiguedadmensual()',
                'icon' => 'print',
                'width' => 130,))
));
?> 
    <?php $this->endWidget(); ?>

</div><!-- form -->
