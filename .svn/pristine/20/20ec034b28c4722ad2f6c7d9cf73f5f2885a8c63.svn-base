<style> 
    .resaltar{padding: 0px 0px !important;
              margin: 0px 0px !important;
		
			color:black;
			background: linear-gradient(25deg,red ,red, #ffffff,red,red );
			background-size: 400% 400%;
			position: relative;
			animation: cambiar  0.55s ease-out infinite;
		}
		

		@keyframes cambiar{
			0%{background-position: 0% 50%;}
			50%{background-position: 100%  0%;}
			100%{background-position: 0% 50%;}
		}
</style>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'focus'=>array($model,'idempleado')
)); ?>
    <div class="formWindow">
     	
       
        
          <?php  echo System::widgetTabs(array(
            'nameView' => 'Movimiento',
            'height' => 250,
            'tabs' => array(
                'Datos Generales'=> array('id' => 'Datos',
                    'content' => $this->renderPartial('_general', array('model' => $model,'fecha'=>$fecha,'areas'=>$areas,'secciones'=>$secciones,'puestotrabajos'=>$puestotrabajos, 'form' => $form), true),
                    'titleWidth' => 110,
                    'active' => true,
                ),
                'Horario' => array('id' => 'horarios',
                    'content' => $this->renderPartial('_horariou', array('model' => $model,'form'=>$form,'Horarios'=>$Horarios), true),
                    'titleWidth' => 80, 'active' => true
                ),
                 'Lista Bonos' => array('id' => 'listabono',
                    'content' => $this->renderPartial('_listabono', array('listabono' => $listabono,'tipo'=>array(
                        'width' => 5,
                        'typeCol' => 'buttons',
                        'buttons' => array('delete'),
                    ),'model'=>$model,'form'=>$form), true),
                    'titleWidth' => 120,
                ),
                '<label class="resaltar">Evaluación</label>'=>array('id' => '',
                    'content' => $this->renderPartial('_evaluacion', array('model'=>$model,'modele'=>$modele,'form'=>$form), true),
                    'titleWidth' => 80,'class'=>'resaltar'),
               
            ),
        ));?>     
    </div>
    <?php
    echo System::Buttons(array(
         'nameView' => 'Persona',
        'buttons' => array()
    ));
    ?> 
<?php $this->endWidget(); ?>

</div><!-- form -->
