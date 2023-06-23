<?php

/* @var $this PersonaController */
/* @var $model Persona */

?>
<div class="container">
	<div class="offset-12">
		<div id="content">
                    <?php $this->renderPartial('_reincorporacionempleado', array(
                            
                            'model' => $model,'modele'=>$modele,'fecha'=>$fecha,'areas'=>$areas,'secciones'=>$secciones,'puestotrabajos'=>$puestotrabajos,'Horarios'=>$Horarios,'listabono'=>$listabono
							                
                    
                    )); ?>                    
		</div>
	</div>
</div>
