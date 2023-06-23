
<div id="cuerpo" >
 
 
                <label><input type="checkbox" onclick="Horariolactancia.seleccionar(this);"  id="cbxgrilla1" > Seleccionar/Deseleccionar todos? </label><br>
                         
                            <?php
                                $evento="Horariolactancia.Actualizarcheckboxgeneral('gridEmpleados');";

                                echo SGridView::widget('TGridView', array(
                                    'id' =>'gridEmpleados',
                                    'dataProvider' => $listaempleado,       
                                     'buttonAdd' => false,
                                    'buttonText' => '+',        
                                    'height' => 200,
                                     'specialCellEditionMode' => false,
                                        'eventAfterEdition' => $evento,
                                        'eventAfterEditionAutomatic' => true,

                                    'columns' => array(           
                                        array( 
                                            'name' => 'id',
                                            'key' => true,
                                            'typeCol' => 'hidden'

                                        ),
                                         array(
                                            'header' => 'Empleado',
                                            'name' => 'nombrecompleto',
                                            'width' => 80,
                                            'style' => array('text-transform' => 'uppercase'),
                                            'typeCol' => 'uneditable',

                                        ),
                                        array(
                                            'header'=>'Seleccionar',
                                            'name' => 'seleccionar',
                                            'width' => 20,
                                            'typeCol' => 'checkbox',

                                        ),


                                    ),
                                ));
                            ?>




 

 
 </div>