<?php

/* @var $this PersonaController */
/* @var $model Persona */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php $this->renderPartial('_form', array('model'=>$model,'direccion'=>$direccion, 'fotoPersona'=>$fotoPersona,'secciones'=>$secciones,'modelc'=>$modelc,'listahorario'=>$listahorario,'puestotrabajos'=>$puestotrabajos,'modelns'=>$modelns,'modeld'=>$modeld,'modelmp'=>$modelmp,'sueldos'=>$sueldos, 'modele'=>$modele,'modelhistorial'=>$modelhistorial,'listabono'=>$listabono,'lista'=>$lista,'historialContrato'=>$historialContrato)); ?>                    
		</div>
	</div>
</div>
