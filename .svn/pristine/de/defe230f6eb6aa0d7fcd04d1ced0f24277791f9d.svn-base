  
	  <div class="row">
            <?php echo $form->labelEx($model, 'id',array('label'=>'DEPENDIENTES')); ?>
           
            <?php

echo SGridView::widget('TGridView', array(
        'id' => 'gridDependientes',
        'dataProvider' => $modeld,       
         'buttonAdd' => true,
        'buttonText' => '+',        
        'height' => 180,
        'eventAfterEdition' => 'Persona.cantidadHora();',
        'columns' => array(           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
                
            ),
             array(
                'header' => 'Matricula de Suguro',
                'name' => 'maticulaseguro',
                
                'width' => 12,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',),
            
             array(
                'header' => 'C.I.',
                'name' => 'ci',
                
                'width' => 8,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
                
            ),
            array(
                'header' => 'Nombre Completo',
                'name' => 'nombrec',
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
             'width' => 15,
            ),
            
            array(
                'header'=>'Fecha de Nac.',
                'name' => 'fechanacr',
                'width' => 8,
              'value'=>'$data->fechanacr == null?"":  date("d-m-Y", strtotime($data->fechanacr))',
                'typeCol' => 'editable',
               
            ),
             array(
                'header'=>'Celular',
                'name' => 'celular',
                'width' => 8,
             
                'typeCol' => 'editable',
               
            ),
          
             array(
                'header'=>'Parentesco<br>(Empleado)',
                'name' => 'parentesco',
                'searchUrl' => 'persona/BuscarParentesco',
                'searchCopyCol' => 'idparentesco',
                'searchHeight' => 100,
                'searchWidth' => 220,
                'value' => '$data->idparentesco == null? "" : $data->idparentesco0->parentescod',
                'width' => 20,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
                
            ),
                array( 
                'name' => 'idparentesco',
                'typeCol' => 'hidden'
                
            ),
            array(
                'header'=>'Presenta<br>Discapacidad',
                'name'=>'discapacidad',
              
                'typeCol' => 'checkbox',
                 'width' => 16,

                ),
            array(
                'header'=>'Heredero',
                'name'=>'heredero',
              
                'typeCol' => 'checkbox',
                 'width' => 8,

                ),
                array(
                'width' => 5,
                'typeCol' => 'buttons',
                'buttons'=>array('delete'),
                
            ),

           
        ),
    ));
?>
        </div>

     


    