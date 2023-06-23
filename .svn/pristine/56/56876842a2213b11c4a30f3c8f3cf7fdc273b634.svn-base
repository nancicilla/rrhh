<?php

/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'')
)); ?>
    <div class="formWindow">
    <?php echo $form->hiddenField($model,'id'); ?>
      

    	<div class=" alert alert-info">
        <?php
         echo $model->scenario;
        ?>
            </div>
              <div class="row " <?php echo 'id="'.System::Id('contmensaje').'"';?>>
        </div>
            <?php  if ($model->scenario=='Desea Consolidar Quinquenio?'||$model->scenario=='Desea Consolidar el Finiquito?'){ ?>
              <div class="">
		<?php echo $form->label($model,'fechapago'); ?>
		
                <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechapago',
               
                'value' => $model->fechapago,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'maxDate' => 'today',
                    

                ),
               
                    ), true)  ;
            }
                    ?>
	
           
	</div>
       
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Pagobeneficio',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
