<?php

/* @var $this VacacionesController */
/* @var $model Vacaciones */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php $this->renderPartial('_saldovacacion', array('model'=>$model,'listaempleados'=>$listaempleados)); ?>                    
		</div>
	</div>
</div>
