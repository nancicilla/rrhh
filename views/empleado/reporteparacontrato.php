<?php

/* @var $this EmpleadoController */
/* @var $model Empleado */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
          <?php $this->renderPartial('_formreporteparacontrato', array('model'=>$model,'ltipocontratos'=>$ltipocontratos,'listaBonos'=>$listaBonos)); ?>                     
		</div>
	</div>
</div>
