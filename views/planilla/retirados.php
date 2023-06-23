<?php

/* @var $this PlanillaController */
/* @var $model Planilla */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php $this->renderPartial('_formretirados', array('model'=>$model,'listafiniquitos'=>$listafiniquitos,'listaretirados'=>$listaretirados)); ?>                    
		</div>
	</div>
</div>