<?php

/* @var $this HistorialestadoempleadoController */
/* @var $model Historialestadoempleado */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php $this->renderPartial('_formingresoretiroempleado', array('model'=>$model,'listameses'=>$listameses,'fecha'=>$fecha)); ?>                    
		</div>
	</div>
</div>
