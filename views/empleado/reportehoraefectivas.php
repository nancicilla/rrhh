<?php

/* @var $this EmpleadoController */
/* @var $model Empleado */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php $this->renderPartial('_formhorasefectivas', array('model'=>$model,'listaareas'=>$listaareas,'fechamaxima'=>$fechamaxima,'listatipo'=>$listatipo,'ltipocontratos'=>$ltipocontratos)); ?>                    
		</div>
	</div>
</div>
