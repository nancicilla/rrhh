<?php
/* @var $this MovimientopersonalController */
/* @var $model Movimientopersonal */
/* @var $form CActiveForm */
?>
<div class="container">
	<div class="offset-12">
		<div id="content">

        <?php $this->renderPartial('_generalcontrato', array('model' => $model,'fecha'=>$fecha,'areas'=>$areas,'secciones'=>$secciones,'puestotrabajos'=>$puestotrabajos,'historialContrato'=>$historialContrato)); ?>                    

</div>
	</div>
</div>
