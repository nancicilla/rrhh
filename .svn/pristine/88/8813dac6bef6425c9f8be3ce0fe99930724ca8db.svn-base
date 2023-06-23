<?php

/* @var $this DeduccionesController */
/* @var $model Deducciones */

echo System::Search(array(
    'title' => 'Administración de Deducciones',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admDeducciones',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'nombre',
                'width' => 30,
            ),
            array(
                'header' => 'Agrupador',
                'name' => 'esagrupador',
                'width' => 5,
                'value' => '($data->esagrupador== true)?"Si":"No "',
            ),
            array(
                'header' => 'Grupo',
                'name' => 'iddeduccionpadre',
                'width' => 5,
                'value' => '($data->iddeduccionpadre==null)?"":$data->iddeduccionpadre0->nombre',
            ),
            array(
                'header' => 'Detallado',
                'name' => 'mostrardetallado',
                'width' => 5,
                'value' => '($data->mostrardetallado==true)?"Si":"No"',
            ),
            array(
                'header' => 'Cuenta',
                'name' => 'idcuenta',
                'width' => 35,
                'value' => '($data->esagrupador==false)? ($data->idcuenta==null)?"": str_replace(".","",$data->idcuenta0->numero)." - ". $data->idcuenta0->nombre :""',
            ),
            array(
                'name' => 'usuario',
                'width' => 6,
            ),
            array(
                'name' => 'fecha',
                'type' => 'datetime',
                'width' => 10,
                'value' => '$data->fecha',
            ),
            array('typeCol' => 'buttons',
                'width' => 4,
                'deleteConfirmation' => '¿Seguro que desea eliminar este elemento?',
                'buttons' => array(
                    'update' => array('label' => 'Modificar'),
                    'delete' => array('label' => 'Eliminar'),
                ),
            ),
        ),
    ))
));

