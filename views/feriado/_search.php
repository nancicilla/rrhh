<?php
/* @var $this FeriadoController */
/* @var $model Feriado */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admFeriado',
)); ?>
	<div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>100)); ?>
	</div>

	
       <div class="row">
		<?php echo $form->label($model, 'fechafestividad'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechafestividad',
                'name' => 'feriado[fechafestividad]',
                'value' => $model->fechafestividad,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'onClose' => 'js:function(selectedDate) {admFeriado.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Deducciones_fecha',
                ),
                    ), true)  
                    ?>

        </div>

	<div class="row">
		<?php echo $form->label($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion'); ?>
	</div>

	
        <div class="row">
                <?php echo $form->labelEx($model,'anio'); ?>
                <?php 
                 $criteria=new CDbCriteria;

		  $criteria->select="date_part('year',t.fechafestividad::date) as id,date_part('year',t.fechafestividad::date) as fecha ";
                  $criteria->order="id desc";
                  $criteria->distinct=true;
                  
		
                echo $form->dropDownList($model,'anio',CHtml::listData( Feriado::model()->findAll($criteria),'id','fecha'),array('empty'=>'')); ?> 
        </div>
       <div class="row">
		<?php echo $form->label($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('maxlength'=>30)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
