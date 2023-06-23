<?php

/* @var $this TrabajosexternosController */
/* @var $model Trabajosexternos */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php                     $this->renderPartial('_formupdate', array('model'=>$model,'horario'=>$horario,'intervalohoras'=>$intervalohoras,'fechaminima'=>$fechaminima)); ?>                    
		</div>
	</div>
</div>
