<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'id')
)); ?>
 <?php echo $form->hiddenField($model,'numeroquinquenios'); ?>
<?php 
 Yii::app()->getClientScript()->scriptMap=array('jquery.js'=>false, 'jquery.ui.js'=>false, 'jquery-ui.min.js'=>false);
       
if( $model->numeroquinquenios>0 &&  $observacion==''){

?>
 <div class="row alter alert-info">
     Quinquenio Habilitado=<?php echo '<strong>'.$model->numeroquinquenios.'</strong>'; ?>
    </div>

    <div class="row">
	
    <?php echo $form->labelEx($model,'numpago',array('label'=>'Cantidad de Quinquenios')); ?>
    <?php echo $form->numberField($model,'numpago',array('min'=>'1','value'=>1, 'max'=>$model->numeroquinquenios, 'style'=>'width:35px','onchange'=>'Historialestadoempleado.validarNumeroQuinquenio(this)' )); ?>
</div>
<?php
}else{
    ?>
    <div class="row alter alert-info">
    <?php 
     if($observacion!=''){
         echo 'El empleado tiene Quinquenio por Consolidar...';
     }else{
         echo'El empleado no tiene Quinquenio Habilitado...';
     }
    ?>
    
    </div>
    <?php
}
?>

 
<?php $this->endWidget(); ?>