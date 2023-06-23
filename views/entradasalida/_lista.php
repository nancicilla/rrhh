	<?php 
	$elementos='<option ></option>';
        for($i=0;$i<count($lista);$i++) {
 	$elementos.='<option value="'.$lista[$i]['id'].'">'.$lista[$i]['nombre'].'</option>';
        }
	echo $elementos;
	?>