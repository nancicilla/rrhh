<?php

/* @var $this VacacionesController */
/* @var $model Vacaciones */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php 
                    if($model->diasgestionactual==0)
                    $this->renderPartial('_formupdate', array('model'=>$model,'horario'=>$horario,'intervalohoras'=>$intervalohoras)); 
                    else
                        $this->renderPartial('_formmensaje', array('model'=>$model,'horario'=>$horario,'intervalohoras'=>$intervalohoras)); 
                    ?>                    
		</div>
	</div>
</div>
