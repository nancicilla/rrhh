<?php

$cadena= '<option value=""></option>';
foreach ($lista as $l) {
	$cadena.='<option value="'.$l['id'].'">'.$l['nombrec'].'</option>';
}
echo $cadena;
?>