<?php
/* @var $this BonosController */
/* @var $model Bonos */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>30,'style' => 'text-transform: uppercase')); ?>
	</div>
        <div class="row" <?php echo 'id="'.System::Id('contenedorAgrupador').'"';?>>
      <?php echo $form->labelEx($model,'idbonospadre',array('label'=>'Agrupar en...')); ?>
        <?php echo $form->dropDownList($model,'idbonospadre',CHtml::listData(Bonos::model()->findAll('t.idbonospadre is null and t.id<>'. ($model->id==null?0:$model->id)),'id','nombre'),array('empty'=>'')); ?>
    </div>
   
<div class="row">
      <?php echo $form->hiddenField($model, 'idcuenta'); ?>

        <?php echo $form->labelEx($model,'cuenta'); 

      	if ($model->scenario=='update') {
			 if ($model->idcuenta0!==null) {
              $model->cuenta=str_replace('.','',$model->idcuenta0->numero).' - '. $model->idcuenta0->nombre;
            }
			
		}


        ?>            
<?php
$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'cuenta',
                'source' => $this->createUrl("unidad/autocompleteCuenta"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {
                                        $('#' + Bonos.Id('idcuenta')).val(ui.item.id);
                                      
                                    }"
                ),
                'htmlOptions' => array(
                    'style' => 'width: 85%;text-transform: uppercase;'
                ),
            ));
                ?>

    </div>
        <div class="row">
        <div class="column">
        <?php echo $form->labelEx($model,'enplanilla',array('label'=>'Mostrar en  Planilla?')); ?>
         <?php  echo $form->checkBox($model,'enplanilla'); ?>  
     
    </div>
	<div class="column">
		<?php echo $form->labelEx($model,'estado', array('label' => 'Se Calcula con una funcion ?' )); ?>
		<?php echo $form->checkBox($model,'estado'); ?>
	</div>
</div>    <div class="row">
        <?php
          if ($model->scenario=='update') {
             echo $form->labelEx($model,'vigente', array('label' => 'Vigente ?' ));
              echo $form->checkBox($model,'vigente');
          }
         ?>
        
    </div>
	 <div class="row">
	 <?php

echo SGridView::widget('TGridView', array(
        'id' => 'gridPuestoTrabajo',
        'dataProvider' => $listaPuesto,
        'buttonAdd' => true,
        'buttonText' => '+',  
        'height' => 280,
        'columns' => array(
           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
                
            ),
          
             array(
               'header' => 'Puesto Trabajo',
                'name' => 'puesto',
                'searchUrl' => 'bonos/BuscarPuestotrabajo',
                'searchCopyCol' => 'idpuestotrabajo',
                'searchHeight' => 100,
                'searchWidth' => 520,
                'value' => '$data->idpuestotrabajo == null? "" : $data->idpuestotrabajo0->nombre." (".$data->idpuestotrabajo0->idseccion0->idarea0->idunidad0->nombre." - ".$data->idpuestotrabajo0->idseccion0->idarea0->nombre." - ".$data->idpuestotrabajo0->idseccion0->nombre.")" ',
                'width' => 30,
              
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',

            ),
               array( 
                'name' => 'valor',
                'type' => 'number(4,2)',
                'typeCol' => 'editable',
                'width' => 4, 
                
            ),
              array( 
                'name' => 'idpuestotrabajo',
                'typeCol' => 'hidden'
                
            ),
               array( 
                'name' => 'idbonos',
                'typeCol' => 'hidden'
                
            ),
         array(
                'width' => 4,
                'typeCol' => 'buttons',
                'buttons'=>array('delete'),
                
            ),
               
            
              

           
        ),
    ));

	 ?>
	 	
	 </div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Bonos',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
