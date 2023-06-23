<?php
/* @var $this EntradasalidaController */
/* @var $model Entradasalida */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admEntradasalida',
)); ?>

	<div class="row">
		<?php
       
         echo $form->label($model,'empleado'); ?>

		<?php echo $form->textField($model,'empleado',array('placeholder'=>'Buscar Empleado...')); ?>

	</div>
	

	
        <div class="row">
		<?php echo $form->label($model, 'fecha',array('label'=>'Desde')); 

        ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fecha',
                'name' => 'entradasalida[fecha]',
                'value' => $model->fecha,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'onClose' => 'js:function(selectedDate) {admEntradasalida.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Entradasalida_fecha',
                ),
                    ), true)  
                    ?>

        </div>
        <div class="row">
                      <?php echo $form->label($model, 'fechahasta'); 

              ?>
                      <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                      'model'=>$model, 
                      'attribute'=>'fechahasta',
                      'name' => 'entradasalida[fechahasta]',
                      'value' => $model->fechahasta,
                      'language' => 'es',
                      // additional javascript options for the date picker plugin
                      'options' => array(
                          'showAnim' => 'slideDown',
                          'showButtonPanel' => true,
                          'changeMonth' => true,
                          'changeYear' => true,
                          'dateFormat' => 'dd-mm-yy',
                          'onClose' => 'js:function(selectedDate) {admEntradasalida.search()}'

                      ),
                      'htmlOptions' => array(
                          'id' => 'Entradasalida_fechahasta',
                      ),
                          ), true)  
                          ?>

             </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
