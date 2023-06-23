<?php

/* @var $this EmpleadoController */
/* @var $model Empleado */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
          <?php $this->renderPartial('_form', array('model'=>$model,'horarios'=>$horarios,'listaentradasalida'=>$listaentradasalida,'listaentradasalidaespecial'=>$listaentradasalidaespecial,'caso'=>$caso,'tienelactancia'=>$tienelactancia)); ?>                     
		</div>
	</div>
</div>
