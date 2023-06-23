 <div class="row">

    <?php
if ($estado) {
    
   echo SGridView::widget('TGridView', array(
        'id' => 'gridPuestoTrabajo',
        'dataProvider' => $listaPuesto,
        'buttonAdd' => true,
        'buttonText' => '+',  
        'height' => 280,
        'columns' => array(
           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
                
            ),
          
             array(
               'header' => 'Puesto de Trabajo',
                'name' => 'puesto',
                'searchUrl' => 'bonos/BuscarPuestotrabajo',
                'searchCopyCol' => 'idpuestotrabajo',
                'searchHeight' => 100,
                'searchWidth' => 220,
                'value' => '$data->idpuestotrabajo == null? "mm" : $data->idpuestotrabajo0->nombre',
                'width' => 10,
              
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',

            ),
              array( 
                'name' => 'idpuestotrabajo',
                'typeCol' => 'hidden'
                
            ),
               array( 
                'name' => 'idbonos',
                'typeCol' => 'hidden'
                
            ),
         array(
                'width' => 4,
                'typeCol' => 'buttons',
                'buttons'=>array('delete'),
                
            ),
               
             /*    array(
                'header'=>'Descripción',
                'name' => 'estado',
                'width' => 30,
                // 'type' => 'number(2,2)',
                'typeCol' => 'uneditable'
            ),*/
              

           
        ),
    ));
}else{
    echo SGridView::widget('TGridView', array(
        'id' => 'gridPuestoTrabajo',
        'dataProvider' => $listaPuesto,
        'buttonAdd' => true,
        'buttonText' => '+',  
        'height' => 280,
        'columns' => array(
           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
                
            ),
          
             array(
               'header' => 'Puesto de Trabajo',
                'name' => 'puesto',
                'searchUrl' => 'bonos/BuscarPuestotrabajo',
                'searchCopyCol' => 'idpuestotrabajo',
                'searchHeight' => 100,
                'searchWidth' => 220,
                'value' => '$data->idpuestotrabajo == null? "sss" : $data->idpuestotrabajo0->nombre',
                'width' => 10,
              
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',

            ),
              array( 
                'name' => 'idpuestotrabajo',
                'typeCol' => 'hidden'
                
            ),
               array( 
                'name' => 'idbonos',
                'typeCol' => 'hidden'
                
            ),
         array(
                'width' => 4,
                'typeCol' => 'buttons',
                'buttons'=>array('delete'),
                
            ),
               
             /*    array(
                'header'=>'Descripción',
                'name' => 'estado',
                'width' => 30,
                // 'type' => 'number(2,2)',
                'typeCol' => 'uneditable'
            ),*/
              

           
        ),
    ));
}
?>
 </div>