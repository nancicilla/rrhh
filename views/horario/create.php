<?php

/* @var $this HorarioController */
/* @var $model Horario */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php $this->renderPartial('_form', array('model'=>$model,'estado'=>true,'listahorario'=>$listahorario,'listaempleados'=>$listaempleados,'fechaminima'=>$fechaminima)); ?>                    
		</div>
	</div>
</div>
