<?php

/* @var $this TipocontratoController */
/* @var $model Tipocontrato */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php $this->renderPartial('_form', array('model'=>$model,
            'listabeneficio'=>$listabeneficio,
            'listaaportacion'=>$listaaportacion,)); ?>                    
		</div>
	</div>
</div>
