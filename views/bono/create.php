<?php

/* @var $this BonoController */
/* @var $model Bono */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php $this->renderPartial('_form', array('model'=>$model,'laportebeneficio'=>$laportebeneficio,'fechaminima'=>$fechaminima,'consulta'=>$consulta)); ?>                    
		</div>
	</div>
</div>
