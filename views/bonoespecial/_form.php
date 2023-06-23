<?php
/* @var $this BonoliberalidadController */
/* @var $model Bonoliberalidad */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo 
             
                $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>100,'style' => 'text-transform: uppercase;width:80%','placeholder'=>'Nombre Bono Especial')); ?>
	</div>
        
        <div class="row"   >
        <?php echo $form->labelEx($model,'opcion',array('label'=>'Seleccione una  Opción')); ?>
        <?php echo $form->dropDownList($model,'opcion',CHtml::listData(array(array('id'=>'1','nombre'=>'Distribuir Monto(Similar Prima)'),array( 'id'=>'2','nombre'=>'Monto Constante'),array('id'=> '3', 'nombre'=>'% Salario')),'id','nombre'),array('empty'=>'','onchange'=>'Bonoespecial.MostrarOpcion(this.value)')); ?>   
        </div>
       
        <div  >
            <div class="row" style="display: none" <?php echo 'id="'.System::Id('contenedorMontoDistribuir').'"';?>>
    <div class="column">
		<?php echo $form->labelEx($model,'fechadesde'); ?>
		<?php   echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
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
                       
                    ),
                    ), true);?>
	</div>
    <div class="column">
		<?php echo $form->labelEx($model,'fechahasta'); ?>
		<?php   echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fechahasta',
                    'value' => $model->fechahasta,
                    'language' => 'es',
                    
                    'options' => array(
                        'showAnim' => 'slideDown',
                        'showButtonPanel' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'dateFormat' => 'dd-mm-yy'
                       
              
                    ),
                    'htmlOptions' => array(
                       
                      
                   
                    ),
                    ), true);?>
	</div>
   
</div>
  
        <div class="row" style="display:none" <?php echo 'id="'.System::Id('contenedorMonto').'"';?>>
            <?php echo $form->labelEx($model,'monto',array('label'=>'Monto a Distribuir(Bs.)')); ?>
            <?php echo $form->numberField($model,'monto',array('min'=>'1', 'style'=>'' ,'onchange'=>'Pagobeneficio.Decimales(this.value)')); ?>

        </div>
      <div class="row" style="display:none" <?php echo 'id="'.System::Id('contenedorMontoDistribuir2').'"';?>>
	<hr style="border-top: 1px solid #f1f1f1 ;">
    
	<div class="row" >
               
      <?php echo $form->labelEx($model,'aportebeneficioa',array('label'=>'Asignar Aporte','style'=>'text-align:center;font-size: 15px')); ?>
            <div class="column" style="height: 300px;width: 250px">
                <h6 style="text-align:center">Personal Activo</h6>
          <?php
        $criteria=new CDbCriteria;
        $criteria->addCondition("t.idaportacionbeneficiopadre is null and t.tipo in(2,3) ");
        if ($model->scenario=='update'){
            $criteria->addCondition("t.id not in( select idaportacionbeneficio from bonoaportaciones where  eliminado=false and idbono in ( select  idbonopadre from general.bono where eliminado=false  and  id=".$model->id.")) ");
        }
        $criteria->order='t.nombre asc';
        $this->widget('ext.select2.ESelect2', array(
                'id' => 'aportebeneficioa',
                'name' => 'aportebeneficioa',
                'value' => $laportebeneficioa,
                'data' => CHtml::listData(Aportacionbeneficio::model()->findAll($criteria), 'id', 'nombre'),
                'htmlOptions' => array(
                    'multiple' => 'multiple',
                    'style' => 'width:100%;'
                ),
                'options' => array(
                    'placeholder' => 'Seleccione...',
                    'allowClear' => true,
                ),
            ));
            ?>
        </div>    
        <div class="column" style="height: 300px;width: 250px">
            <h6 style="text-align:center">Personal Retirado</h6>
          <?php
          $lista=Yii::app()->rrhh->createCommand("select id,nombre from ftbl_impuesto where eliminado=false order by nombre asc")->queryAll();       

        
        $this->widget('ext.select2.ESelect2', array(
                'id' => 'aportebeneficior',
                'name' => 'aportebeneficior',
                'value' => $laportebeneficioa,
                'data' => CHtml::listData($lista, 'id', 'nombre'),
                'htmlOptions' => array(
                    'multiple' => 'multiple',
                    'style' => 'width:100%;'
                ),
                'options' => array(
                    'placeholder' => 'Seleccione...',
                    'allowClear' => true,
                ),
            ));
            ?>
        </div>   
        </div>
	      
      </div>
   
        
        </div>
	
        <div class="row" style="display:none"  <?php echo 'id="'.System::Id('contenedorBA').'"';?>>
	<div class="column" <?php echo 'id="'.System::Id('contenedorBeneficio').'"';?>>    
	 <?php

echo SGridView::widget('TGridView', array(
        'id' => 'gridBeneficios',
        'dataProvider' => $lbeneficio,
        'buttonAdd' => false,
          'width' => 350,
        'height' => 250,
        'columns' => array(
           
            
          
             array(
               'header' => 'Beneficios',
                'name' => 'nombre',
                
                'width' => 30,
              
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'uneditable',

            ),
               array( 
                'name' => 'nombref',
                 'typeCol' => 'hidden'
                
                 
                
            ),
                 array( 
                'name' => 'orden1',
                 'typeCol' => 'hidden'
                
                 
                
            ),
              array( 
                 'header' => 'Seleccionar',
                'name' => 'estado',
                'typeCol' => 'checkbox',
                'width' => 10,
            ),
              
         
               
            
              

           
        ),
    ));

	 ?>
	 	
	 </div>
    
     <div class="column" <?php echo 'id="'.System::Id('contenedorAportacion').'"';?>>
    
     <?php

echo SGridView::widget('TGridView', array(
        'id' => 'gridAportaciones',
        'dataProvider' => $laportacion,
        'buttonAdd' => false,
         'width' => 350,
        'height' => 250,
        'columns' => array(
           
            
          
             array(
               'header' => 'Aportaciones',
                'name' => 'nombre',
                
                'width' => 30,
              
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'uneditable',

            ),
               array( 
                'name' => 'nombref',
                 'typeCol' => 'hidden'
                
                 
                
            ),
                 array( 
                'name' => 'orden1',
                 'typeCol' => 'hidden'
                
                 
                
            ),
              array( 
                 'header' => 'Seleccionar',
                'name' => 'estado',
                'typeCol' => 'checkbox',
                'width' => 10,
            ),
              
         
               
            
              

           
        ),
    ));

     ?>
        
     </div>
    </div>
    </div>
    <?php
    echo System::Buttons(array(
        'nameView' => 'Bonoespecial',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
