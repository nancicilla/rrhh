<?php
/* @var $this EmpleadodeduccionesController */
/* @var $model Empleadodeducciones */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'admEmpleadodeducciones',
    ));
    ?>
    <div class="row">
        <?php echo $form->label($model, 'empleado'); ?>
    </div>
    <div class="row">
        <?php echo $form->textField($model, 'empleado', array('placeholder' => 'Buscar Empleado...')); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'fechadesde'); ?>
        <?php
        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'fechadesde',
            'name' => 'empleadodeducciones[fechadesde]',
            'value' => $model->fechadesde,
            'language' => 'es',
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'slideDown',
                'showButtonPanel' => true,
                'changeMonth' => true,
                'changeYear' => true,
                'dateFormat' => 'dd-mm-yy',
                'onClose' => 'js:function(selectedDate) {admEmpleadodeducciones.search()}'
            ),
            'htmlOptions' => array(
                'id' => 'Empleadodeducciones_fechadesde',
            ),
                ), true)
        ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'fechahasta'); ?>
        <?php
        echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'fechahasta',
            'name' => 'empleadodeducciones[fechahasta]',
            'value' => $model->fechahasta,
            'language' => 'es',
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'slideDown',
                'showButtonPanel' => true,
                'changeMonth' => true,
                'changeYear' => true,
                'dateFormat' => 'dd-mm-yy',
                'onClose' => 'js:function(selectedDate) {admEmpleadodeducciones.search()}'
            ),
            'htmlOptions' => array(
                'id' => 'Empleadodeducciones_fechahasta',
            ),
                ), true)
        ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'tipodeduccion', array('label' => 'Deduccion')); ?>
        <?php echo $form->dropDownList($model, 'iddeducciones', CHtml::listData(Deducciones::model()->findAll('t.esagrupador=false and t.porfucion=false '), 'id', 'nombre'), array('empty' => '')); ?>
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
            'name' => 'empleadodeducciones[fecha]',
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
                'onClose' => 'js:function(selectedDate) {admEmpleadodeducciones.search()}'
            ),
            'htmlOptions' => array(
                'id' => 'Permiso_fecha',
            ),
                ), true)
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- search-form -->



