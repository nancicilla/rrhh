<?php

/* @var $this AportacionbeneficioController */
/* @var $model Aportacionbeneficio */

echo System::Search(array(
    'title' => 'Administración de Aportaciones y Beneficios',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admAportacionbeneficio',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'nombre',
                'width' => 20,
            ),
            array(
                'name' => 'estado',
                'header' => 'Habilitado',
                'value' => '($data->estado==true)?"SI":"NO"',
                'width' => 7,
            ),
            array(
                'name' => 'esagrupador',
                'width' => 8,
                'value'=>'($data->esagrupador==true)?"Si":"No"',
            ),
            array(
                'name' => 'idaportacionbeneficiopadre',
                'width' => 20,
                'value'=>'$data->idaportacionbeneficiopadre!=null?$data->idaportacionbeneficiopadre0->nombre :""'
            ),
            
            array(
                'name' => 'porcentaje',
                'width' => 7,
            ),
            array(
                'name' => 'enplanilla',
                'width' => 8,
            ),
            array(
                'name' => 'descripcion',
                'width' => 15,
            ),
            array(
                'name' => 'tipo',
                'width' => 10,
            ),
            
            array('typeCol' => 'buttons',
                'width' => 5,
                'deleteConfirmation' => '¿Seguro que desea eliminar este elemento?',
                'buttons' => array(
                    'update' => array('label' => 'Modificar'),
                    'delete' => array('label' => 'Eliminar'),
                ),
            ),
        ),
    ))
));

