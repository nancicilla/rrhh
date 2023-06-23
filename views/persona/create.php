<?php

/* @var $this PersonaController */
/* @var $model Persona */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php $this->renderPartial('_form', array('model'=>$model,'fotoPersona'=>$fotoPersona,
                    	'direccion'=>$direccion,'secciones'=>$secciones,'modelc'=>$modelc,'listahorario'=>$listahorario,'puestotrabajos'=>$puestotrabajos,
                    	'modelns'=>$modelns,
                    	'modeld'=>$modeld,
                    	'modelmp'=>$modelmp,
                        'sueldos'=>$sueldos,
                        'modele'=>$modele,
                        'modelhistorial'=>$modelhistorial,
                        'lista'=>$lista,
                        'historialContrato'=>$historialContrato
                       
                    
                    )); ?>                    
		</div>
	</div>
</div>
