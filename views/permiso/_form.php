<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    
)); ?>
    <div class="formWindow">
    <div class="row">
        <?php echo $form->labelEx($model,'idtipopermiso'); ?>
        <?php 
        $criteria=new CDbCriteria;      
        $criteria->join = " right outer join general.tipopermisousuario se on se.idtipopermiso=t.id  right outer JOIN ftbl_usuario_web_cruge_user cu  on cu.iduser=se.idcrugeuser";   
        $criteria->addCondition("cu.username = '".Yii::app()->user->getName()."'");
        $criteria->addCondition("se.eliminado::boolean =false::boolean");
        $criteria->order='nombre asc';        
        echo $form->dropDownList($model,'idtipopermiso',CHtml::listData(Tipopermiso::model()->findAll($criteria),'id','nombre'),array('empty'=>'','style'=>'Width:90%')); ?>
    </div>
        <div class="row">       
        <?php 
                echo $form->hiddenField($model,'idempleado'); 

       

 
     echo $form->labelEx($model,'idempleado',array('label'=>'Empleado')); 
     $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'empleado',
                'source' => $this->createUrl("movimientopersonal/autocompletePersona"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {
                      
                                     
                                       $('#'+Permiso.Id('idempleado')).val(ui.item.id);
                                       Permiso.Fechasminimas(ui.item.id);
                                       $('#'+Permiso.Id('contenedorPermiso')).show();
                                        
                                    }"
                ),
                'htmlOptions' => array(
                    'placeholder'=>'Buscar Empleado...',
                    'style' => 'width: 100%;text-transform: uppercase;',
                    
                ),
            ));

        
    
     ?>

  
    </div>



    <div class="row" style="display:none ;" <?php echo 'id="'.System::Id('contenedorPermiso').'"';?>>
       

    
<div class="row">
        <?php echo $form->labelEx($model,'tipo',array('label'=>'Sacar Permiso por hora?')); ?>
        <?php echo $form->checkBox($model,'tipo',array('onclick'=>'Permiso.Mostrar(this)')); ?>
   
    </div>
 

<div class="row">
    <div class="column">
    <?php
          echo $form->label($model, 'fechai',array('label'=>'Fecha'));
             echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechai',
                    'value' => $model->fechai,
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                        
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 155px;',
                   
                    'onchange'=>'Permiso.validarfechai(this.value)'

                    ),
                    ), true);
         
?>    </div>
   <div class="column" style="display:none;" <?php echo 'id="'.System::Id('ocularfecha').'"';?>>
         <?php
         echo $form->label($model, 'fechaf');
         echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechaf',
                    'value' => $model->fechaf,
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy',
                                
                        
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 155px;',
                         'onchange'=>'Permiso.validarfechaf(this.value)'
                    ),
                    ), true);
          
?>

    </div>
</div>
<h6>Horario</h6>
    <div class="row" >
       
        <div class="row" <?php echo 'id="'.System::Id('contHorario').'"';?>>
            
        </div>
        
    </div>
<div class="row"  style="display:block;"<?php echo 'id="'.System::Id('conthoras').'"';?>>
   <div class="row" <?php echo 'id="'.System::Id('horastrabajador').'"';?>>
       
    </div>


    <div class="column">
        <?php echo $form->labelEx($model,'horai',array('label'=>'Hora (Desde)')); ?>
    <div class="column">
    
        <?php echo $form->labelEx($model,'hi',array('label'=>'HH')); ?>
        <?php echo $form->numberField($model,'hi',array('min'=>'0','value'=>'7','data-horario'=>'', 'max'=>'19', 'style'=>'width:35px' ,'onchange'=>'Permiso.validarHoras()')); ?>
    </div>
    <div class="column">:</div>
    <div class="column">    
        <?php echo $form->labelEx($model,'mi',array('label'=>'MM')); ?>
        <?php echo $form->numberField($model,'mi',array('min'=>'0','value'=>'0','data-horario'=>'', 'max'=>'59' , 'style'=>'width:35px','onchange'=>'Permiso.validarHoras()')); ?>
    </div>
    </div>
    

    <div class="column" >
        <?php echo $form->labelEx($model,'horaf',array('label'=>'Hora (Hasta)')); ?>
    <div class="column">
    
        <?php echo $form->labelEx($model,'hs',array('label'=>'HH')); ?>
        <?php echo $form->numberField($model,'hs',array('min'=>'0','value'=>'7','data-horario'=>'', 'max'=>'22' , 'style'=>'width:35px','onchange'=>'Permiso.validarHoras()')); ?>
    </div>
    <div class="column">:</div>
    <div class="column">
    
        <?php echo $form->labelEx($model,'ms',array('label'=>'MM')); ?>
        <?php echo $form->numberField($model,'ms',array('min'=>'0','value'=>'0','data-horario'=>'', 'max'=>'59' , 'style'=>'width:35px','onchange'=>'Permiso.validarHoras()')); ?>
    </div>
    </div>
    </div>
 




<div class="row">
      <?php echo $form->labelEx($model,'descripcion',array('label'=>'Detalle')); ?>
     
<?php echo $form->textArea($model, 'descripcion', array('maxlength' => 300, 'style'=>'width:95%','style' => 'text-transform: uppercase')); ?>
    
       
    </div>

        
    </div>


 
 <div class="row" style="display:none;" <?php echo 'id="'.System::Id('contenedorMensaje').'"';?>>
    
       
    </div>
     
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Permiso',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
