<?php

/* @var $this EmpleadoController */
/* @var $model Empleado */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php $this->renderPartial('_formantiguedadpersonal', array('model'=>$model,'ltipocontratos'=>$ltipocontratos,'lareas'=>$lareas)); ?>                    
		</div>
	</div>
</div>
