	  <div class="row">
              <div class=" alert alert-info">
                  <h5>Última Evaluación</h5>
                  <p><?php
                  if ($modele->ultimaevaluacion==''){
                       echo 'Sin Evaluación....';
                  }else{
                  echo $modele->ultimaevaluacion;}
                          ?></p>
              </div>
              <?php 
               if ($model->scenario!='Reincorporacion'){
              echo $form->labelEx($model, 'id',array('label'=>'Evaluación')); 
                                                                                               
            echo $form->textArea($modele, 'observacion', array('maxlength' => 300, 'cols' => 50,'style'=>'width: 869px; height: 70px;text-transform: uppercase;'));
         
           }?>
           
        </div>

     


    