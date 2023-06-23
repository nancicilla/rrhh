<?php
/* @var $this BonoController */
/* @var $model Bono */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'admBonoPlanillaTributaria',
    ));
    ?>
    <div class="row">
        <?php echo $form->label($model, 'nombre'); ?>
        <?php echo $form->textField($model, 'nombre'); ?>
    </div>
    <div class="row">
        <?php
        if ($model->estado == null) {
            $model->estado = true;
        }
        echo $form->label($model, 'estado');
        ?>
        <?php echo $form->checkBox($model, 'estado'); ?>
    </div>
  
    <div class="row">
        <?php echo $form->label($model, 'usuario'); ?>
<?php echo $form->textField($model, 'usuario', array('maxlength' => 30)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'fecha'); ?>
        <?php
        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'fecha',
            'name' => 'bono[fecha]',
            'value' => $model->fecha,
            'language' => 'es',
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'slideDown',
                'showButtonPanel' => true,
                'changeMonth' => true,
                'changeYear' => true,
                'dateFormat' => 'dd-mm-yy',
                'maxDate' => 'today',
                'onClose' => 'js:function(selectedDate) {admBonoPlanillaTributaria.search()}'
            ),
            'htmlOptions' => array(
                'id' => 'Bono_fecha',
            ),
                ), true)
        ?>

    </div>
<?php $this->endWidget(); ?>
</div><!-- search-form -->
