<?php
/* @var $this AreaController */
/* @var $model Area */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">   
	<div class="row">
		<?php echo $form->labelEx($model,'id',array('label'=>'Planilla')); ?>
		<?php
                $criteria=new CDbCriteria;		
                $criteria->compare('t.porsistema',true);
                $criteria->order = 't.id desc';
                echo $form->dropDownList($model,'id',CHtml::listData(Planilla::model()->findAll($criteria),'id','nombre'),array('empty'=>'')); ?>
	</div>
      
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Planilla',
        'buttons' => array( 'Imprimir' => array(
                'label' => 'Imprimir',
                'click' => 'Planilla.descargaReportedistribuciondominical()',
                'icon' => 'print',
                'width' => 130,))
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
