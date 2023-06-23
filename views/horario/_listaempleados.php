  <div class="row">
       <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
            <div class="row alert alert-info">
                <h5> <strong>NOTA:</strong> El color rojo en el nombre del empleado significa que el empleado cuenta con un horario de inicio al <span  <?php echo 'id="'.System::Id('contenedorFecha').'"';?>></span>  , si <strong>NO</strong> desea reemplazar el horario del empleado por este nuevo Horario, solo debera quitar al empleado del listado </h5> 
    
</div>
            <?php
            
echo SGridView::widget('TGridView', array(
        'id' => 'gridEmpleados',
        'dataProvider' => $listaempleados,       
         'buttonAdd' => $estado,
        'buttonText' => '+',        
        'height' => 250,
        'eventAfterEdition' => 'Horario.Observacionempleado();',  
        'eventAfterEditionAutomatic' => true,    
        'columns' => array(           
            array( 
                'name' => 'id',
                'typeCol' => 'hidden'
                
            ),
            
             array(
                'header' => 'Nombre Completo',
                'name' => 'nombrecompleto',
                'searchUrl' => 'horario/BuscarEmpleado',
                'searchCopyCol' => 'id',
                'nextFocus' => '[row]nombrecompleto',
                'searchHeight' => 100,
                'searchWidth' => 220,
                'value' => '$data->nombrecompleto == null? "" : $data->nombrecompleto',
                'width' => 10,
                'style' => array('text-transform' => 'uppercase'),
                'typeCol' => 'editable',
                
            ),
            array(
             
                'name' => 'estado',
                'valueDefault' => '-1',
                'typeCol' => 'hidden',
               
            ),
             
                array(
                'width' => 4,
                'typeCol' => 'buttons',
                'buttons'=>array('delete'),
                
            ),

           
        ),
    ));
?>
        </div>
