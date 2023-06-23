<?php
/* @var $this TipocontratoController */
/* @var $model Tipocontrato */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>50,'style' => 'text-transform: uppercase')); ?>
	</div>
    <div class="row">
        
        <?php
        $list = CHtml::listData(Aportacionbeneficio::model()->findAll(), 'id', 'nombre');
        $htmlOptions = array('template' => '{input}{label}', 'separator'=>'', 'class'=>'in-checkbox', 'multiple'=>true, 'checked'=>'checked');
        ?>

 
    </div>
    <div class="row">
    <div class="column">
        <?php echo $form->labelEx($model,'generarcc',array('label'=>'Generar C.C.?')); ?>
        <?php echo $form->checkBox($model,'generarcc'); ?>
    </div>
    <div class="column">
        <?php echo $form->labelEx($model,'diasfestivosparo'); ?>
        <?php echo $form->checkBox($model,'diasfestivosparo'); ?>
    </div>
    <div class="column">
        <?php echo $form->labelEx($model,'generafiniquito',array('label'=>'Genera Finiquito ?')); ?>
        <?php echo $form->checkBox($model,'generafiniquito'); ?>
    </div>
     <div class="column">
		<?php echo $form->labelEx($model,'idministerio'); ?>
		<?php      

            echo $form->numberField($model,'idministerio',array('step'=> '1',"min"=>"1",'placeholder'=>'Clasificacion Contrato Ministerio'));
        ?>
	</div>
    </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'beneficio'); ?>
           
            <?php
            
           $this->widget('ext.select2.ESelect2', array(
                'id' => 'beneficio',
                'name' => 'beneficio',
                'value' => $listabeneficio,
                'data' => CHtml::listData(Aportacionbeneficio::model()->findAll(array('order' => 'nombre','condition'=>'t.tipo in(1,2) ')), 'id', 'nombre'),
                'htmlOptions' => array(
                    'multiple' => 'multiple',
                    'style' => 'width:100%;'
                ),
                'options' => array(
                    'placeholder' => 'Introduzca los beneficios',
                    'allowClear' => true,
                ),
            ));
            ?>
        </div>
          <div class="row">
            <?php echo $form->labelEx($model, 'aportacion',array('label'=>'Aportes')); ?>
         
            <?php
          
           $this->widget('ext.select2.ESelect2', array(
                'id' => 'aportacion',
                'name' => 'aportacion',
                'value' => $listaaportacion,
                'data' => CHtml::listData(Aportacionbeneficio::model()->findAll( array('order' => 'nombre','condition'=>'t.id in(select id from (
select id,( select count(*) from general.aportacionbeneficio t where t.eliminado=false and idaportacionbeneficiopadre=t2.id) as cantidad 
from general.aportacionbeneficio t2 where t2.eliminado=false and t2.tipo in(3,4) ) as t3 where t3.cantidad=0)')), 'id', 'nombre'),
                'htmlOptions' => array(
                    'multiple' => 'multiple',
                    'style' => 'width:100%;'
                ),
                'options' => array(
                    'placeholder' => 'Introduzca los aportes',
                    'allowClear' => true,
                ),
            ));
            ?>
        </div>
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Tipocontrato',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->

