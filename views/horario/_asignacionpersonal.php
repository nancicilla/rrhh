
<div id="cuerpo" style=" overflow: scroll;height: 410px;">
 <?php
 $cantidad=count($listasecciones);
  $letras=$model->dameColumna('A',$cantidad);
 for($i=0;$i< $cantidad;$i++){
 ?>
    <div id="accordion<?php echo $letras[$i];?>">
        
            <div  id="<?php echo $letras[$i];?>">
                <h5>
                    <a  data-toggle="collapse" data-target="#collapse<?php echo $letras[$i];?>" aria-expanded="true" aria-controls="collapseOne">
                        <?php echo $listasecciones[$i]['nombre']."(".$listasecciones[$i]['nombrearea'].")";?> 
                    </a>
                </h5>
            </div>

            <div id="collapse<?php echo $letras[$i];?>" class="show in collapse" aria-labelledby="<?php echo $letras[$i];?>" data-parent="#accordion">
                <script>
                    
                    Horario.listagrilla.push('grilla'+'<?php echo $letras[$i];?>');         
                </script>                <?php
                                 
                   $listaempleado=Yii::app()->rrhh
                 ->createCommand                    
                         ("select e.id,p.nombrecompleto,false as seleccionar from 
 general.empleado e inner join general.persona p on p.id=e.idpersona
 inner join general.historialestadoempleado hee on hee.idempleado=e.id 
inner join contrato c on c.idhistorialestadoempleado=hee.id inner join historialcontrato hc on hc.idcontrato=c.id 
 
  inner join general.puestotrabajo pt on pt.id=hc.idpuestotrabajo inner join general.seguimientoempleado se on se.idempleado=e.id inner join 
  ftbl_usuario_web_cruge_user cu on cu.iduser=se.idcrugeuser 
  where se.eliminado=false and cu.username='".Yii::app()->user->getName()."' and  pt.idseccion=".$listasecciones[$i]['id']." and hc.id in (select hc1.id from historialcontrato hc1 inner join contrato c1 on c1.id=hc1.idcontrato where 
  hc1.eliminado=false and c1.idhistorialestadoempleado=hee.id order by hc1.fecharegistro desc limit 1)
 and  hee.activo=1 and hee.id in(select  (select  max(id ) from general.historialestadoempleado where eliminado=false and idempleado=e.id)  from general.empleado  e where eliminado=false) order by p.nombrecompleto asc    ")
                         
                 ->queryAll();
                ?>
                <label><input type="checkbox" onclick="Horario.seleccionar(this);"  id="cbxgrilla<?php echo $letras[$i] ?>" > Seleccionar/Deseleccionar todos? </label><br>
                         
                            <?php
                                $evento="Horario.Actualizarcheckboxgeneral('grilla".$letras[$i]."');";

                                echo SGridView::widget('TGridView', array(
                                    'id' =>'grilla'.$letras[$i],
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
  </div>
 <?php }?>
 
 </div>