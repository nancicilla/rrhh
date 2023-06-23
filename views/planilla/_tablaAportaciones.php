<?php




echo SGridView::widget('TGridView', array(
        'id' => $nombre.'gridAportaciones',
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