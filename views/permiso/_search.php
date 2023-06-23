<?php
/* @var $this PermisoController */
/* @var $model Permiso */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'admPermiso',
)); ?>
		<div class="row">
		<?php echo $form->label($model,'empleado'); ?>

		
    	<?php echo $form->textField($model,'empleado',array('maxlength'=>60,'placeholder'=>'Buscar Empleado...')); ?>
              
          	</div>
	
        <div class="row">
        <?php echo $form->label($model,'idtipopermiso',array('label'=>'Tipo de Permiso')); ?>

        <?php echo $form->dropDownList($model,'idtipopermiso',CHtml::listData(Tipopermiso::model()->findAll(),'id','nombre'),array('empty'=>'')); ?>
              
            
    </div>
    <div class="row">
        <?php
     
         echo $form->label($model,'tipo', array('label' => 'Permiso por Hora?' )); 
         echo $form->dropDownList($model,'tipo',CHtml::listData(array(array('id'=>'true','nombre'=>'Hora'),array('id'=>'false','nombre'=>'Dia')),'id','nombre'),
                 array('empty'=>'','onclick'=>'admPermiso.search();'));
         ?>
        

  <div class="row">
        <?php echo $form->label($model, 'fechai'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechai',
                'name' => 'permiso[fechai]',
                'value' => $model->fechai,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate) {admPermiso.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Permiso_fechai',
                ),
                    ), true)  
                    ?>

                    </div>
   <div class="row">
        <?php echo $form->label($model, 'fechaf',array('label'=>'Hasta')); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechaf',
                'name' => 'permiso[fechaf]',
                'value' => $model->fechaf,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'maxDate' => 'today',
                    'onClose' => 'js:function(selectedDate) {admPermiso.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Permiso_fechaf',
                ),
                    ), true)  
                    ?>

                    </div>    

<div  id="contenedorfechai" style="display: none;" >
        <?php echo $form->label($model,'horai'); ?>
        <?php echo $form->textField($model,'horai',array('maxlength'=>100)); ?>
    </div>
   
    </div>
            
           

  <div class="row">
        <?php echo $form->label($model,'usuario'); ?>
        <?php echo $form->textField($model,'usuario',array('maxlength'=>30)); ?>
    </div>

      <div class="row">
        <?php echo $form->label($model, 'fecha'); ?>
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fecha',
                'name' => 'permiso[fecha]',
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
                    'onClose' => 'js:function(selectedDate) {admPermiso.search()}'

                ),
                'htmlOptions' => array(
                    'id' => 'Permiso_fecha',
                ),
                    ), true)  
                    ?>

                    </div>
    
  



   

<?php $this->endWidget(); ?>

</div><!-- search-form -->
