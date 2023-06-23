<?php

/* @var $this BonoController */
/* @var $model Bono */

echo System::Search(array(
    'title' => 'Administración de Bonos Asociado a Empleados',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admBono',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'id',
                'typeCol' => 'hidden'
            ),
            array(
                'name' => 'nombre',
                'width' => 30,
            ),
            array(
                'name' => 'enplanilla',
                'width' => 10,
                'value' => '$data->enplanilla==true?"SI":"NO"'
            ),
              array(
                'name' => 'esagrupador',
                'width' => 10,
                'value' => '$data->esagrupador==true?"SI":"NO"'
            ),
             array(
                'header' => 'Grupo',
                'name' => 'idbonopadre',
                'width' => 16,
                'value' => '($data->idbonopadre==null)?"":$data->idbonopadre0->nombre',
            ),
            array(
                'name' => 'estado',
                'header' => 'Estado',
                'width' => 8,
                'value' => '($data->estado==true)?"Activo":"No Activo"',
            ),
            array(
                'name' => 'usuario',
                'width' => 8,
            ),
            array(
                'name' => 'fecha',
                'type' => 'date',
                'width' => 8,
                'value' => '$data->fecha',
            ),
            array('typeCol' => 'buttons',
                'width' => 10,
                'deleteConfirmation' => '¿Seguro que desea eliminar este elemento?',
                'buttons' => array(
                    'update' => array('label' => 'Modificar'),
                    'Bono' => array('click' => 'function () {SGridView.selectRow(this); admBono.Asignarbono(); return false;}', 'visible' => 'Bono::model()->MostrarAsignar(SeguridadModule::enc($data->getPrimaryKey()))', 'icon' => 'list-alt', 'label' => 'Asignar Bono'),
                   
                    'delete' => array('label' => 'Eliminar'),
                ),
            ),
        ),
    ))
));

