<?php

/* @var $this PlanillaretroactivoController */
/* @var $model Planillaretroactivo */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php $this->renderPartial('_formdescargarplanillaprefactura', array('model'=>$model,'ltipocontratos'=>$ltipocontratos,'listaempresas'=>$listaempresas)); ?>                    
		</div>
	</div>
</div>
