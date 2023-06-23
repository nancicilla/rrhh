<?php
/* @var $this SubsidioController */
/* @var $model Subsidio */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'admSubsidio',
    ));
    ?>
    <div class="row">
        <?php echo $form->label($model, 'empleado'); ?>
        <?php echo $form->textField($model, 'empleado', array('placeholder' => 'Buscar Empleado...')); ?>
    </div>
    <div class="row">
		<?php echo $form->label($model,'area'); ?>
		<?php echo $form->textField($model,'area',array('maxlength'=>60)); ?>
	</div>
	
     <div class="row">               
        <?php
        echo $form->label($model, 'activo');
        echo $form->dropDownList(
                $model, 'activo', array(1 => 'Activo', 0 => 'Inactivo'), array('empty' => '')
        );
        ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model, 'fechar'); ?>
        <?php echo $form->textField($model, 'fechar'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'fechaiqmes'); ?>
        <?php
        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'fechaiqmes',
            'name' => 'subsidio[fechaiqmes]',
            'value' => $model->fechaiqmes,
            'language' => 'es',
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'slideDown',
                'showButtonPanel' => true,
                'changeMonth' => true,
                'changeYear' => true,
                'dateFormat' => 'dd-mm-yy',
                'maxDate' => 'today',
                'onClose' => 'js:function(selectedDate) {admSubsidio.search()}'
            ),
            'htmlOptions' => array(
                'id' => 'Subsidio_fechaiqmes',
            ),
                ), true)
        ?>
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
            'name' => 'subsidio[fecha]',
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
                'onClose' => 'js:function(selectedDate) {admSubsidio.search()}'
            ),
            'htmlOptions' => array(
                'id' => 'Subsidio_fecha',
            ),
                ), true)
        ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- search-form -->
