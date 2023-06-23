<?php
/* @var $this DefaultController */


?>
<div class="container">
            <h1>Módulo de RRHH </h1>
            
            <div class="column"  style="width: 45% !important;box-shadow: 0px 0px 5px 1px #eeeeee; padding: 5px;">
                <h3 style="text-align:center">Cumpleañeros</h3>
                <div>
                     <?php
            echo  Yii::app()->rrhh
                   ->createCommand("select cumpleanieros() as sms ")
                   ->queryAll()[0]['sms'];

		?>
                </div>
            </div>
            <div class="column" style="width: 45% !important;box-shadow: 0px 0px 5px 1px #eeeeee; padding: 5px;">
                <h3 style="text-align: center">Contratos Por Finalizar</h3>
                <div>
                           <?php
            $contratos= Yii::app()->rrhh
                   ->createCommand("select * from lista_contratos_fincalizar()")
                   ->queryAll();
           
                for($i=0;$i<count($contratos);$i++)
                {
                    echo'<div><span style="color: white;" class="label label-info">'.$contratos[$i]['informacion'].'  </span></div>';
       
                }
            

		?>
                </div>
            </div>



	
   
</div>



