<?php

/* @var $this EmpleadodeduccionesController */
/* @var $model Empleadodeducciones */

echo System::Search(array(
    'title' => 'Administración de Deducciones al Empleado',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admEmpleadodeducciones',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'idempleado',
                'width' => 20,
                'value' => '$data->idempleado0->idpersona0->apellidop." ".$data->idempleado0->idpersona0->apellidom." ".$data->idempleado0->idpersona0->nombre',
            ),
            array(
                'name' => 'fechar',
                'width' => 10,
                'value' => 'date("d-m-Y",strtotime($data->fechar))',
            ),
            array(
                'name' => 'iddeducciones',
                'width' => 10,
                'value' => '($data->iddeducciones0== null)?"":$data->iddeducciones0->nombre '
            ),
            array(
                'name' => 'descripcion',
                'width' => 28,
            ),
            array(
                'name' => 'monto',
                'width' => 8,
                'align'=>'right',
                'split'=>false,
                'footer'=>'sum',
            ),
            array(
                'name' => 'usuario',
                'width' => 10,
            ),
            array(
                'name' => 'fecha',
                'type' => 'datetime',
                'width' => 10,
                'value' => 'date("d-m-Y",strtotime($data->fecha))',
            ),
            array('typeCol' => 'buttons',
                'width' => 4,
                'deleteConfirmation' => '¿Seguro que desea eliminar este elemento?',
                'buttons' => array(
                    'update' => array( 'visible' => 'Empleadodeducciones::model()->MostrarElemento(SeguridadModule::enc($data->getPrimaryKey()))',
    
                    'label' => 'Modificar'),
                    'delete' => array('visible' => 'Empleadodeducciones::model()->MostrarElemento(SeguridadModule::enc($data->getPrimaryKey()))',
                    'label' => 'Eliminar'),
                ),
            ),
        ),
    ))
));

