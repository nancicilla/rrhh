<?php

/* @var $this HorarioController */
/* @var $model Horario */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php $this->renderPartial('_formhorarioespecial', array('model'=>$model,'listahorario'=>$listahorario,'listasecciones'=>$listasecciones,'fechaminima'=>$fechaminima)); ?>                    
		</div>
	</div>
</div>
