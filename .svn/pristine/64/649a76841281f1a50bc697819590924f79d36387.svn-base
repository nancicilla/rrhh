<?php

/* @var $this AsistenciaController */
/* @var $model Asistencia */
$criteria = new CDbCriteria;
$criteria->compare('t.estado', 1);
$criteria->limit = 1;
$fechas = Planilla::model()->findAll($criteria);

$fd = '';
$fh = '';
$fic = '';
$ffc = '';
if (count($fechas) > 0) {
    $fd = date('d-m-Y', strtotime($fechas[0]['fechadesde']));
    $fh = date('d-m-Y', strtotime($fechas[0]['fechahasta']));
    $fic = date('d-m-Y', strtotime($fechas[0]['fechaic']));
    $ffc = date('d-m-Y', strtotime($fechas[0]['fechafc']));
}


echo System::Search(array(
    'title' => 'Resumen de asistencia (<span class="label label-success">' . $fic . ' al ' . $ffc . '</span> &nbsp; &nbsp;<span class="label label-info">' . $fd . ' al ' . $fh . '</span>)',
    'formSearch' => $this->renderPartial('_search', array('model' => $model), true),
    'buttons' => array(
    ),
    'heightSearch' => Yii::app()->params['defaultAdminHeight'],
    'contentSearch' => SGridView::widget('TGridViewSearch', array(
        'id' => 'admAsistencia',
        'dataProvider' => $model->search(),
        'height' => Yii::app()->params['defaultAdminHeight'],
        'columns' => array(
            array(
                'name' => 'idempleado',
                'value' => '$data->idempleado0->idpersona0->apellidop." ".$data->idempleado0->idpersona0->apellidom." ".$data->idempleado0->idpersona0->nombre ',
                'width' => 25,
            ),
            array(
                'header' => 'H. Programadas',
                'name' => 'horashorario',
                'width' => 10,
                'type' => 'number(2)',
                'align' => 'right',
                'footer'=>'sum',
            ),
            array(
                'header' => 'H. Asistidas (Horario)',
                'name' => 'horasasistidas',
                'width' => 10,
                'type' => 'number(2)',
                'align' => 'right',
                'footer'=>'sum',
            ),
            array(
                'header' => 'Min Atrasos',
                'name' => 'horasatrasos',
                'width' => 9,
                'type' => 'number(2)',
                'typeCol' => 'editable',
                'align' => 'right',
                'onKeyUp' => 'Asistencia.actualizarvalor(\'horasatrasos\',event);show(k);',
                'footer'=>'sum',
            ),
            array(
                'header' => 'H. Extras',
                'name' => 'horasextras',
                'width' => 9,
                'type' => 'number(3,4)',
                'typeCol' => 'editable',
                'align' => 'right',
                'onKeyUp' => 'Asistencia.actualizarvalor(\'horasextras\',event);show(k);',
                'footer'=>'sum',
            ),
            array(
                'header' => 'H. Contra',
                'name' => 'horasencontra',
                'width' => 9,
                'type' => 'number(3,4)',
                'typeCol' => 'editable',
                'align' => 'right',
                'onKeyUp' => 'Asistencia.actualizarvalor(\'horasencontra\',event);show(k);',
                'footer'=>'sum',
            ),
            array(
                'header' => 'H. Sancion sin sellar',
                'name' => 'tiempofaltante',
                'width' => 9,
                'type' => 'number(3,4)',
                'typeCol' => 'editable',
                'align' => 'right',
                'onKeyUp' => 'Asistencia.actualizarvalor(\'tiempofaltante\',event);show(k);',
                'footer'=>'sum',
            ),
            array(
                'header' => 'Faltas',
                'name' => 'diasfalta',
                'width' => 5,
                'type' => 'number(2)',
                'typeCol' => 'uneditable',              
                'align' => 'right',
                'footer'=>'sum',
            ),
            array(
                'header' => 'Factor Descuento Falta',
                'name' => 'factordescuentofalta',
                'width' => 7,
                'type' => 'number(2,2)',
                'typeCol' => 'editable',
                'align' => 'right',
                'onKeyUp' => 'Asistencia.actualizarvalor(\'factordescuentofalta\',event);show(k);',
                'footer'=>'sum',
            ),
            array(
                'header' => 'Dias Pago',
                'name' => 'dias',
                'width' => 7,
                'type' => 'number(2)',
                'typeCol' => 'editable',
                'onKeyUp' => 'Asistencia.actualizarvalor(\'dias\',event);show(k);',
                'footer'=>'sum',
            ),

        ),
    ))
));

