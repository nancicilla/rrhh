<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 
echo SGridView::widget('TGridView', array(
        'id' => 'gridListabono',
        'dataProvider' => $listabono,      
        'buttonAdd' => false,
        'buttonText' => '+',        
        'height' => 150,
        'columns' => array(           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
                
            ),
             array(
                'header' => 'Bono',
                'name' => 'nombre',               
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'uneditable',
                 'width' => 50,
                
            ),            
           
            array(
                'header'=>'Monto(Bs.)',
                'name'=>'monto',
                'type' => 'number(5,2)',
                'width' => 45,
                 'typeCol' => 'uneditable',

                ),
             $tipo
              

           
        ),
    ));
     
?>
        </div>
