<div class="row">
  <div class="row">
            <?php echo '<label>Unidad</label>'?>
           
            <?php
            
           $this->widget('ext.select2.ESelect2', array(
                'id' => 'area',
                'name' => 'area',
                'value' => array(),
                'data' => CHtml::listData($areas, 'id', 'nombre'),
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
    <div class="row">
	 <div class="column">
	 <?php

echo SGridView::widget('TGridView', array(
        'id' => $nombre.'gridBeneficios',
        'dataProvider' => $lbeneficio,
        'buttonAdd' => false,
          'width' => 320,
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
                 'header' => 'Seleccionar',
                'name' => 'estado',
                'typeCol' => 'checkbox',
                'width' => 10,
            ),
              
         
               
            
              

           
        ),
    ));

	 ?>
	 	
	 </div>
     <div class="column">
     <?php

echo SGridView::widget('TGridView', array(
        'id' => $nombre.'gridAportaciones',
        'dataProvider' => $laportacion,
        'buttonAdd' => false,
         'width' => 320,
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