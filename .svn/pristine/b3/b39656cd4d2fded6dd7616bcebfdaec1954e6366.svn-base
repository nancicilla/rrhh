<?php
/* @var $this Formulario110Controller */
/* @var $model Formulario110 */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'idempleado')
)); ?>
    <div class="formWindow">
  
	<div class="row">
		<?php echo $form->labelEx($model,'fechapresentacion'); ?>
		 <?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fechapresentacion',
                'value' => $model->fechapresentacion,
                'language' => 'es',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'slideDown',
                    'showButtonPanel' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'minDate'=>$fechaminima
                    
                  

                ),
                
                    ), true)  
                    ?>

	</div>
    
        <div class="row">

         <div  <?php echo 'id="'.System::Id('contenedorListaempleados').'"';?>>
             <?php echo $this->renderPartial('listaempleado', array('lista' => array()), true); ?>
        </div>
               <h5 style="position: absolute; left: 12px; top: 450px;">Total
                <span class="badge" <?php echo 'id="'.System::Id('spanTotalBono').'"';?>  style="font-size: 18px; font-weight: bold;  color: black;"> <?php echo $total;?> Bs.</span> 
              </h5>
        </div>
        

       <div style=" position: absolute; left: 30px; top: 420px !important;" ><span><img src="protected/modules/rrhh/images/excel1.png"   width="32" height="32"> </span></div>
                      
       <div class="row" style="position: absolute; left: 60px; top: 420px;">

        <div  <?php echo 'id="'.System::Id('fileExcel').'"';?>>

        </div>
     
    </div>
	
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Formulario110',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
