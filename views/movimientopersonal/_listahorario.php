	<?php 
	$elementos='<option ></option>';
 foreach ($lista as $l) {
 	$elementos.='<option value="'.$l->id.'">'.$l->nombre.'</option>';
 }
	echo $elementos;
	?>