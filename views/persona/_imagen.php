<?php
/*
 * _imagen.php
 *
 * Version 0.$Rev: 705 $
 *
 * Creacion: 30/01/2015
 *
 * Ultima Actualizacion: $Date: 2017-07-18 16:50:06 -0400 (Tue, 18 Jul 2017) $
 *
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 */
?>
<div style="height: 340px; overflow: auto;">
    <?php

    $this->widget(
            'ext.clonnableFields.ClonnableFields', array(
        'id' => 'fotoPersona',
        'datas' => $fotoPersona,
        'rowGroupName' => 'fotoPersona', //required, all fields will be with this key number
        'startRows' => 1, //optional, default: 1 - The number of rows at widget start
        'labelsMode' => 2, //optional, default: 1 - (0 - never, 1 - always, 2 - only if rows exist)
        'addButtonLabel' => false,
        'removeButtonLabel' => '<i class="icon-trash"></i>',
        'fields' => array(//required  
            array(
                'label' => array(
                    'htmlOptions' => array('data-toggle' => 'popover', 'title' => 'Select2 field', 'data-content' => 'Select gender from the list', 'data-trigger' => 'hover', 'data-placement' => 'top'),
                ),
                'field' => array(//required
                    'name' => 'id',
                    'class' => 'TemplateSelectField', //required.
                    'attribute' => 'id', //required, model attribute or field name
                    'htmlOptions' => array('maxlength' => '128'), //optional
                    'data' =>  array(array('foto'=>'FOTOGRAFIA')),
                    'params' => array(//optional
                        'asDropDownList' => true,
                        'color' => 'red',
                        'width'=>470,
                            'height'=>29,
                    ),
                    'style' => array('readonly'=>true, 'color' => 'red'),
                ),
                'fieldHtmlOptions' => array('class' => 'span3', 'color' => 'red'),
            ),
            array
                (
                'label' => array(
                ),
                'field' => array(
                    'name' => 'foto',
                    'class' => 'TemplateFineUploaderField',
                    'attribute' => 'foto',
                    'params' => array(
                        'action' => Yii::app()->baseUrl . '/' . Yii::app()->session['directorioTemporal'] . $this->UPLOAD_FILE,
                        'deleteAction' => Yii::app()->baseUrl . '/' . Yii::app()->session['directorioTemporal'] . $this->DELETE_FILE,
                        'allowedExtensions' => "['jpeg', 'jpg', 'png']",
                        'debug' => 'true',
                        'imagesUrl' => Yii::app()->baseUrl . '/' . Yii::app()->session['directorioTemporal'] . '/',
                        'imageStyle' => 'height:240px;',
                        'emptyImage' => $this->NO_PHOTO_FILE,
                    ),
                ),
            ),
        ),
            )
    );
    ?>
</div>