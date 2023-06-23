<?php

/* @var $this MovimientopersonalController */
/* @var $model Movimientopersonal */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php $this->renderPartial('_formcambiarhorario', array('model'=>$model,'Horarios'=>$horarios   ,'mensaje'=>$mensaje     
            )); ?>                    
		</div>
	</div>
</div>
