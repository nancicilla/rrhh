<?php
/* @var $this EntradasalidaController */
/* @var $model Entradasalida */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'idempleado')
)); ?>
    <div class="formWindow">
        <div  <?php echo 'id="'.System::Id('contenedorCabecera').'"';?>>
            <div class="row">
                <div class="column">
                    Desde : <?php  
                    
                    echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $model,
                                'attribute' => 'fechadesde',
                                'value' => $model->fechadesde,
                                'language' => 'es',                    
                                'options' => array(
                                    'showAnim' => 'slideDown',
                                    'showButtonPanel' => true,
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                    'dateFormat' => 'dd-mm-yy',
                                
                                                    ),
                                'htmlOptions' => array(
                                    'style' => 'width: 195px;',
                                    'onchange'=>'Entradasalida.Fechaminima(this.value)'
                                    
                                ),
                                ), true);
                    ?>
                </div> 
                <div class="column">
                Hasta : <?php  
                    
                    echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $model,
                                'attribute' => 'fechahasta',
                                'value' => $model->fechahasta,
                                'language' => 'es',                    
                                'options' => array(
                                    'showAnim' => 'slideDown',
                                    'showButtonPanel' => true,
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                    'dateFormat' => 'dd-mm-yy',
                                    'minDate'=>'today'
                                
                                                    ),
                                'htmlOptions' => array(
                                    'style' => 'width: 195x;',
                                    'onchange'=>'Entradasalida.cargartabla()'
                                ),
                                ), true);
                    ?>
                </div>
                  
            </div> 
            <div class="row">
                 <div class="column">
                    Area :         

                    <?php echo $form->dropDownList($model,'area',CHtml::listData(Area::model()->findAll(),'id','nombre'),array('empty'=>'','onchange'=>'Entradasalida.cargarfiltroarea();')); ?>
                </div> 
                    <div class="column">   
                         Empleado:
        <?php 
                echo $form->hiddenField($model,'idempleado'); 
   
     $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'empleado',
                'source' => $this->createUrl("entradasalida/autocompletePersona"),
                'options' => array(
                    'showAnim' => 'slideDown',
                    'delay' => '0',
                    'select' => "js:function(event, ui) {                      
                                     
                                       $('#'+Entradasalida.Id('idempleado')).val(ui.item.id);
                                       Entradasalida.cargartabla();
                                       
                                        
                                    }"
                ),
                'htmlOptions' => array(
                    'placeholder'=>'Buscar Empleado...',
                    'style' => 'text-transform: uppercase;',
                    
                ),
            ));

        
    
     ?>

  
    </div>

                 <div class="column">


                    <?php echo $form->radioButton($model,'evento',array('value'=>'E','onclick'=>'Entradasalida.cagarlistado(this.value)','uncheckValue'=>null)) . 'Entrada'; ?>

                    <?php echo $form->radioButton($model,'evento',array('value'=>'S','onclick'=>'Entradasalida.cagarlistado(this.value)','uncheckValue'=>null)) . 'Salida'; ?>

                    <?php echo $form->error($model,'evento'); ?>
                
              </div>  
            </div>
     
<div class="row">
   
    
    <div class="column" >
       Tipo Evento:		
		<?php echo $form->dropDownList($model,'tipoevento',CHtml::listData(array(),'id','nombre'),array('empty'=>'','onchange'=>'Entradasalida.cagarcambiara(this.value)','style'=>'width:170px'));?>
	
    </div>
    <div class="column">
	Cambiar A :
		
		<?php echo $form->dropDownList($model,'cambiara',CHtml::listData(array(),'id','nombre'),array('empty'=>'','onchange'=>'','style'=>'width:170px'));?>
	
    </div>

</div>
          
            <div class="row">
	
       
       <div class="column">
		 <?php echo $form->labelEx($model,'intervaloini',array('label'=>'Minutos Diferencia ')); ?>
	
		<?php echo $form->textField($model,'intervaloini',array( 'maxlength'=>50,'style'=>'width:150px','placeholder'=>'Minuto desde (opcional)','onkeyup'=>'Entradasalida.validarValorini()')); ?>
	</div>
	<div class="column">
            <br>
		<?php echo $form->textField($model,'intervalofin',array('maxlength'=>50,'style'=>'width:150px','placeholder'=>'Minuto hasta (opcional)','onkeyup'=>'Entradasalida.validarValorfin()')); ?>
	</div>
	 <div class="column">
	<?php echo $form->labelEx($model,'observacionentrada',array('label'=>'Observacion ')); ?>
	
		
		<?php echo $form->textField($model,'observacionentrada',array('style'=>'width:170px','maxlength' => 300,'placeholder'=>'Observacion (opcional)','onblur'=>'Entradasalida.cargarTexto()')); ?>
       
    </div>
        <div class="column">
	<?php echo $form->labelEx($model,'horainfo',array('label'=>'Correccion Hora')); ?>
	
		
		<?php echo $form->textField($model,'horainfo',array('style'=>'width:170px','maxlength' => 300,'placeholder'=>'De 0 a 8 Horas (opcional)','onblur'=>'Entradasalida.cambiarHora()')); ?>
       
    </div>
       <div class="column">
		 <?php echo $form->labelEx($model,'minutoinfo',array('label'=>'Correccion Min. ')); ?>
	
		<?php echo $form->textField($model,'minutoinfo',array( 'maxlength'=>50,'style'=>'width:150px','placeholder'=>'De 0 a 59 Minutos (opcional)','onkeyup'=>'Entradasalida.cambiarMinuto()')); ?>
	</div>
    </div> 
         <hr style="border-buttom: 3px solid #f1f1f1 ;">    
        </div>
        <div   <?php echo 'id="'.System::Id('contenedorCuerpo').'"';?>>
        <?php

?>
<?php

echo SGridView::widget('TGridView', array(
    'id' => 'gridLista',
    'dataProvider' => array(),
    'buttonAdd' => false,
    'specialCellEditionMode' => false,   
    'eventAfterEditionAutomatic' => true,
    'eventAfterEdition' =>'Entradasalida.validarHoraMinuto();',  
    'buttonText' => '+',
    'height' => 300,
    'columns' => array(
       array(
            'name' => 'identradasalida',
            'typeCol' => 'hidden'
        ),
       
       array(
            'name' => 'idcategoriatipo',
             'typeCol' => 'hidden'
        ),   
        
        
        array(
            'name' => 'nombrecompleto',
           
            'header'=>'Nombre Completo',
            'width' => 24,
         
            'typeCol' => 'uneditable'
            
        ),
          array(
            'name' => 'fecha',
            
            'width' => 7,
            'typeCol' => 'uneditable'
            
        ),
          array(
            'header'=>'Sellada',
            'name' => 'entrada',
            'width' => 7,
            'typeCol' => 'uneditable'
            
        ),
        array(
            'header'=>'Hora',
            'name' => 'difhentrada',
            'width' => 7,
            'type' => 'number(0)',
            'typeCol' => 'editable(idcategoriatipo==1 || idcategoriatipo==5 )',
          
        ),
        array(
            'header'=>'Min',
            'name' => 'difmentrada',
            'width' => 7,
            'type' => 'number(0)',
            'typeCol' => 'editable(idcategoriatipo==1 || idcategoriatipo==5 )',
          
        ),
        array(
            
            'name' => 'difentradaoriginal',
                'typeCol' => 'hidden',
          
        ),
        array('name'=>'otrotipocolumna',
            'typeCol' => 'hidden',
            ),
        array(
            'header' => 'Tipo',
            'name' => 'tipoentrada',
            'width' =>18,
            'style' => array('text-transform' => 'uppercase'),
            'typeCol' => 'uneditable',
               ),
        array(
            'header' => 'Observacion',
            'name' => 'observacionentrada',
            'width' =>18,
            'style' => array('text-transform' => 'uppercase'),
            'typeCol' => 'editable',            
               ),
        array( 
            'name' => 'idtipoentrada',
            'typeCol' => 'hidden',
        ),
         array(
                'width' => 4,
                'typeCol' => 'buttons',
                'buttons'=>array('delete'),
                
            ),
       
       
    )
));
?>



        </div>
       
 

 

    <?php
    echo System::Buttons(array(
        'nameView' => 'Entradasalida',
        'buttons' => array(

            )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
</div>