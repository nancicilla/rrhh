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
        <div    <?php echo 'id="'.System::Id('contenedorCabecera').'"';?>>
            <div  style="width: 70% !important;display:inline-block !important">
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
                                    'style' => 'width: 100px;',
                                   
                                    
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
                                
                                                    ),
                                'htmlOptions' => array(
                                    'style' => 'width: 100px;',
                                   'onchange'=>'Entradasalida.CargarListaEmpleados()'
                                    
                                ),
                                ), true);
                    ?>
                </div>
                    <div class="column">
                        Observación : <?php $criteria=new CDbCriteria;  $criteria->addCondition("t.id not in(0,10,13,6,19)");
    
                    $criteria->order = 't.nombre ASC'; echo $form->dropDownList($model,'tipoobservacion',CHtml::listData(Tipo::model()->findAll($criteria)
                        
                        
                                
                            ,'id','nombre')); ?>

                </div>
                <div class="column">
		  Incluir Personal Retirado?
		<?php echo $form->checkBox($model,'mostrartodo',array('onchange'=>'Entradasalida.CargarListaEmpleados()')); ?>
	</div>
               
               
            </div> 
            
            
            
             
            <div class="">
                 <div class="column">
                                    Empleado :                                    
                                    <?php
                                    $criteria=new CDbCriteria;
                                    $criteria->order = 't.nombrecompleto asc';

                                    echo $form->dropDownList($model,'empleado',CHtml::listData($listaempleado,'id','nombrecompleto'),array('empty'=>'','style'=>'width: 170px;','onclick'=>'Entradasalida.CargarListaEmpleados()')); ?>
                 
            </div>
            <div class="column">
      		Area : 	
		 <?php echo $form->dropDownList($model,'area',CHtml::listData(Area::model()->findAll(),'id','nombre'),array('empty'=>'','style'=>'width: 170px;')); ?>
                                </div>
                                <div class="column">
                                   
                            		Cargo : <?php echo $form->textField($model,'cargo',array('maxlength'=>60,'style' => 'text-transform: uppercase;width: 170px;','placeholder'=>'Cargo...')); ?>

                                </div>
                               
                                <div class="column">
                                 <a class='btn btn-primary' <?php echo 'id="'.System::Id('btnBuscarAsistencia').'"'; ?>><i class="icon-search"></i> Buscar</a>
                               
                                </div>
                               
                               
            </div>           
            
        </div>
            <div style="width: 30% !important ;display:inline-block !important;padding: 0;float: right;
   ">
                  <div class="row"  >
         
            <?php
            $criteria=new CDbCriteria;             
            $criteria->order='t.nombre asc';
        
              $this->widget('ext.select2.ESelect2', array(
                'id' => 'tipocontrato',
                'name' => 'tipocontrato',
                'value' => $ltipocontratos,
                'data' => CHtml::listData(Tipocontrato::model()->findAll($criteria), 'id', 'nombre'),
                'htmlOptions' => array(
                    'multiple' => 'multiple',
                    'style' => 'width:100%;'
                ),
                'options' => array(
                    'placeholder' => 'Tipo Contrato',
                    'allowClear' => true
                ),
            ));
            ?>
   
    </div>
                
            </div>
             <hr style="border-buttom: 3px solid #f1f1f1 ;">
    </div>
        <div   <?php echo 'id="'.System::Id('contenedorCuerpo').'"';?>>
        <?php
/* @var $this EntradasalidaController */
/* @var $model Entradasalida */
/* @var $form CActiveForm */
?>
<?php
 $evento='Entradasalida.edicionminutos();';
 $eventohora='Entradasalida.edicionhora();';
 $eventoobservacion='Entradasalida.edicionobservacion();';
 $nombref='Entradasalida.Cargarvariables();';        
echo SGridView::widget('TGridView', array(
    'id' =>'gridLista',
    'dataProvider' => $lista,
    'buttonAdd' => false,
    'specialCellEditionMode' => false,
    'eventAfterEdition' => $nombref,
    'eventAfterEditionAutomatic' => true,
    'buttonText' => '+',
    'height' => 400,
    'columns' => array(
        array(
            'name' => 'identradasalida',
            'typeCol' => 'hidden'
        ),
        array(
            'name' => 'idtipocategoriaentrada',
            'typeCol' => 'hidden'
        ),
        array(
            'name' => 'idtipocategoriasalida',
            'typeCol' => 'hidden'
        ),
        array(
            'name' => 'entradamanual',
            'typeCol' => 'hidden'
        ),
        array(
            'name' => 'salidamanual',
            'typeCol' => 'hidden'
        ), 
            array(
            'name' => 'horarelacionadaentrada',
            'typeCol' => 'hidden'
        ),  
         array(
            'name' => 'horarelacionadasalida',
            'typeCol' => 'hidden'
        ),  
        array(
            'name' => 'nombrecompleto',
           'header'=>'Nombre Completo',            
            'width' => 22,         
            'typeCol' => 'uneditable'
            
        ),
          array(
            'name' => 'fecha',
            
            'width' => 6,
            'typeCol' => 'uneditable'
            
        ),
          array(
            'name' => 'entrada',
            'width' => 6,
            'typeCol' => 'editable(entradamanual==1)',
              'onKeyUp' => $eventohora,
            
        ),
        array(
            'header'=>'Min',
            'name' => 'difentrada',
            'width' => 4,
            'type' => 'number(0)',
            'typeCol' => 'editable(idtipocategoriaentrada==1 || idtipocategoriaentrada==5 )',
            'onKeyUp' => $evento,
              
            
        ),
        array(
            'header' => 'Tipo',
            'name' => 'tipoentrada',
            'searchUrl' => 'asistencia/BuscarTipoentrada',
            'searchCopyCol' => 'idtipoentrada',
            'searchHeight' => 100,
            'searchWidth' => 220,
           'change' => 'function(){
               alert("ooooo");
            SGridView.selectRow(this);
            Entradasalida.cambiotipo();}',
            'width' => 14,
            'style' => array('text-transform' => 'uppercase'),
            'typeCol' => 'editable',
           
                 ),
           array(           
            'name' => 'horarelacionadaespecialentrada',
            'typeCol' => 'hidden',
               ),
          array(
            'header' => 'Observacion',
            'name' => 'observacionentrada',
            'width' => 9,
            'style' => array('text-transform' => 'uppercase'),           
            'typeCol' => 'editable',
            'onKeyUp' => $eventoobservacion,
               ),
        array( 
            'name' => 'idtipoentrada',
            'typeCol' => 'hidden',
        ),
        array(
            'name' => 'salida',
            'width' => 6,
            'typeCol' => 'editable(salidamanual==1)',
            'onKeyUp' => $eventohora,
            
        ),
        array(
            'header'=>'Min',
            'name' => 'difsalida',
            'width' => 4,
            'type' => 'number(0)',
            'typeCol' => 'editable(idtipocategoriasalida==1 || idtipocategoriasalida==5 )',
            'onKeyUp' => $evento,
        ),
        array(
            'header' => 'Tipo',
            'name' => 'tiposalida',
            'searchUrl' => 'asistencia/BuscarTiposalida',
            'searchCopyCol' => 'idtiposalida',
            'searchHeight' => 100,
            'searchWidth' => 220,
            'width' => 14,
            'style' => array('text-transform' => 'uppercase'),
            'typeCol' => 'editable',
            'select' => 'function(){
               
                SGridView.selectRow(this);
                Entradasalida.cambiotipo();}',
                  ),
            array(           
            'name' => 'horarelacionadaespecialsalida',
            'typeCol' => 'hidden',
               ),
          array(
            'header' => 'Observacion',
            'name' => 'observacionsalida',
            'width' => 9,
            'style' => array('text-transform' => 'uppercase'),
            'typeCol' => 'editable',
             'onKeyUp' => $eventoobservacion
               ),
          array(
             'header' => 'Horas Efectivas',
            'name' => 'horastrabajadas',
            'width' => 6,
            'type' => 'number(3,2)',
            
        ),
        array( 
            'name' => 'idtiposalida',
            'type' => 'number(0)',
            'typeCol' => 'hidden'
            
        ),
    )
));
?>

<script>
Entradasalida.colorear();
</script>


        </div>
        <div class="">
                
         
        <div <?php echo 'id="'.System::Id('contenedorPie').'"';?>>
        <hr style="border-top: 1px solid #f1f1f1 ;">
             <div class="">
                <div class="column">
                                    Horas Asistidas   :	<?php echo $form->textField($model,'horaasistida',array('maxlength'=>20,'readonly' => true,'style'=>'width:100px;')); ?>
                                  
                </div>
                <div class="column">
                                     Atraso Personal(min) : <?php echo $form->textField($model,'minatraso',array('maxlength'=>20,'readonly' => true,'style'=>'width:100px;')); ?>

             </div>
                  <div class="column">
                                     Salida Antes Personal(min) : <?php echo $form->textField($model,'minsalida',array('maxlength'=>20,'readonly' => true,'style'=>'width:100px;')); ?>

             </div>
             <div class="column">
                                   Horas a Favor : <?php echo $form->textField($model,'horaextra',array('maxlength'=>20,'readonly' => true,'style'=>'width:100px;')); ?>

             </div>
                                
             </div>
             

        </div>
    </div>
 

 

    <?php
    echo System::Buttons(array(
        'nameView' => 'Entradasalida',
        'buttons' => array(

                        'reporte' => array(
                            'label' => 'Imprimir',
                            'click' => 'Entradasalida.descargarAsistencia()',
                            'icon' => 'print',
                            'width' => 130,),
            'reporteempleados' => array(
                            'label' => 'Imprimir Reporte Empleado',
                            'click' => 'Entradasalida.descargarAsistenciaempleado()',
                            'icon' => 'print',
                            'width' => 180,)
            )
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
</div>