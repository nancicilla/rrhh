<?php
/* @var $this TipobeneficioController */
/* @var $model Tipobeneficio */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'nombre')
)); ?>
    <div class="formWindow">
    
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('maxlength'=>60,'style' => 'text-transform: uppercase')); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'tipo'); ?>
		<?php echo $form->dropDownList($model,'tipo',array('B'=>'BONO','V'=>'VACACIÓN'),array('empty'=>'')); ?>
	</div>
    <div class="row">
        <?php echo $form->labelEx($model,'idparametro'); ?>
        <?php 
$criteria = new CDbCriteria;

$criteria->with='idconfiguracion0';
$criteria->condition="idconfiguracion0.para ='BENEFICIO' OR idconfiguracion0.para='APORTE'"     ;


//$criteria->select="t.id, concat(t.nombre,'(',t.valor,')') as valor";//array('rate', 'avg(rate) as avgRate');
//$criteria->select=array("id","concat(nombre,'-','(',valor,')') as valor");
$criteria->select=array("t.id","concat(t.nombre,' (',t.valor,')') as valor");
//var_dump(Parametro::model()->findAll($criteria));


        echo $form->dropDownList($model,'idparametro',CHtml::listData(Parametro::model()->with('idconfiguracion0')->findAll($criteria), 'id', 'valor'),array('empty'=>'')); ?>
    </div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textArea($model,'descripcion',array('rows'=>3, 'cols'=>15));?>
	</div>
     
    </div>
<?php

echo SGridView::widget('TGridView', array(
        'id' => 'gridBeneficio',
        'dataProvider' => $modelbeneficio,       
         'buttonAdd' => true,
        'buttonText' => '+',        
        'height' => 110,
        'columns' => array(           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
                
            ),
          
             array(
             	'header'=>'De (año)',
                'name' => 'rangoi',  
                'width' => 10,        
                'type' => 'number(2)',      
                'typeCol' => 'editable'
            ),
              array(
              	'header'=>'Al (año)',
                'name' => 'rangof',
                'width' => 10,
                'type' => 'number(2)',
                'typeCol' => 'editable'
            ),
               array(
               	'header'=>'Valor (Forma de Pago)',
                'name' => 'porcentaje',
                'width' => 10,
                 'type' => 'number(2,2)',
                'typeCol' => 'editable'
            ),
                array(
                'width' => 4,
                'typeCol' => 'buttons',
                'buttons'=>array('delete'),
                
            ),

           
        ),
    ));
?>

    <?php
    echo System::Buttons(array(
        'nameView' => 'Tipobeneficio',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
