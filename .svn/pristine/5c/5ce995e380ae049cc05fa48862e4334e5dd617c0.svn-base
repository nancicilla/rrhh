<?php

/*
 * Pagobeneficio.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 16/06/2020
 *
 * Ultima Actualizacion: $Date: 2015-03-17 10:26:19 -0400 (mar, 17 mar 2015) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.

 * This is the model class for table "general.pagobeneficio".
 *
 * The followings are the available columns in table 'general.pagobeneficio':
 * @property integer $id
 * @property integer $numpago
 * @property string $fechasolicitud
 * @property string $fechadesde
 * @property string $fechahasta
 * @property string $fechapago
 * @property integer $idtipopagobeneficio
 * @property integer $idhistorialestadoempleado
 * @property string $monto
 * @property string $listaplanilla
 * @property boolean $eliminado
 * @property string $fecha
 * @property string $usuario
 *
 * The followings are the available model relations:
 * @property Historialestadoempleado $idhistorialestadoempleado
 * @property Tipopagobeneficio $idtipopagobeneficio
 */

class Pagobeneficio extends CActiveRecord {

    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $numeroquinquenios, $empleado, $gestion, $prciva, $monto, $descripcion,
            $idtiporetiro, $fecharetiro,$idformapago,$descripcionformapago,$tipocontratos,$tipocontrato,$opciones,$porcentaje;

    public function defaultScope() {
        return array(
            'condition' => $this->getTableAlias(false, false) .
            '.eliminado = false',
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'general.pagobeneficio';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('numpago, idtipopagobeneficio, idhistorialestadoempleado', 'numerical', 'integerOnly' => true),
            array('monto', 'length', 'max' => 12),
            array('usuario', 'length', 'max' => 40),
            array('gestion', 'length', 'max' => 12),
            array('numpago, fechasolicitud', 'required', 'on' => array('update')),
            array('fechadesde,fechahasta,monto,gestion', 'required', 'on' => array('prima')),
            array('fechasolicitud, fechadesde, fechahasta, fechapago, listaplanilla,gestion, eliminado, fecha', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id,empleado,gestion, numpago, fechasolicitud, fechadesde, fechahasta, fechapago, idtipopagobeneficio, idhistorialestadoempleado, monto, listaplanilla, eliminado, fecha, usuario', 'safe', 'on' => 'search'),
            array('id,empleado,gestion, numpago, fechasolicitud, fechadesde, fechahasta, fechapago, idtipopagobeneficio, idhistorialestadoempleado, monto, listaplanilla, eliminado, fecha, usuario', 'safe', 'on' => 'searchprimaanual'),
            array('id,empleado,gestion, numpago, fechasolicitud, fechadesde, fechahasta, fechapago, idtipopagobeneficio, idhistorialestadoempleado, monto, listaplanilla, eliminado, fecha, usuario', 'safe', 'on' => 'searchfiniquito'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idhistorialestadoempleado0' => array(self::BELONGS_TO, 'Historialestadoempleado', 'idhistorialestadoempleado'),
            'idtipopagobeneficio0' => array(self::BELONGS_TO, 'Tipopagobeneficio', 'idtipopagobeneficio'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'numpago' => 'Numero de Pago',
            'fechasolicitud' => 'Fecha Solicitud',
            'fechadesde' => 'Fecha Desde',
            'fechahasta' => 'Fecha Hasta',
            'fechapago' => 'Fecha Pago',
            'idtipopagobeneficio' => 'Tipo Pago Beneficio',
            'idhistorialestadoempleado' => 'Empleado',
            'monto' => 'Monto',
            'gestion' => 'Gestion',
            'listaplanilla' => 'Listaplanilla',
            'eliminado' => 'Eliminado',
            'fecha' => 'Fecha',
            'usuario' => 'Usuario',
            'idformapago' => 'Forma Pago',
            'infoadicionalformapago' => 'Detalle Forma Pago',
            'porcentaje'=>'Cancelacion en Especies(%)'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.numpago', $this->numpago);
        $criteria->compare('t.idtipopagobeneficio', 1);
        $criteria->compare('t.idhistorialestadoempleado', $this->idhistorialestadoempleado);

        $criteria->join = 'right outer  JOIN general.historialestadoempleado he on he.id=t.idhistorialestadoempleado right outer  JOIN general.empleado e on e.id=he.idempleado right outer  JOIN general.persona p on p.id=e.idpersona ';
        $criteria->addSearchCondition('p.nombrecompleto', $this->empleado, true, 'AND', 'ILIKE');


        if ($this->fecha != Null) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
        }
        if ($this->fechasolicitud != Null) {
            $criteria->addCondition("t.fechasolicitud::date = '" . $this->fechasolicitud . "'");
        }
        if ($this->fechadesde != Null) {
            $criteria->addCondition("t.fechadesde::date = '" . $this->fechadesde . "'");
        }
        if ($this->fechahasta != Null) {
            $criteria->addCondition("t.fechahasta::date = '" . $this->fechahasta . "'");
        }
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
             'sort' => array(
                        'defaultOrder' => 't.id desc',                      
                        'attributes' => array(
                            'idempleado'=>array(
                                'asc'=>'p.nombrecompleto asc, t.numpago desc',
                                'desc'=>'p.nombrecompleto ,t.numpago desc'
                                ),
                            'numpago'=>array(
                                'asc'=>'t.numpago asc, p.nombrecompleto asc',
                                'desc'=>'t.numpago des, p.nombrecompleto asc'
                            ),
                            'fechasolicitud'=>array(
                                'asc'=>'t.fechasolicitud,p.nombrecompleto asc',
                                'desc'=>'t.fechasolicitud desc,p.nombrecompleto asc'
                            ),
                            'fechadesde'=>array(
                                'asc'=>'t.fechadesde,p.nombrecompleto asc',
                                'desc'=>'t.fechadesde desc,p.nombrecompleto asc'
                            ),
                            'fechahasta'=>array(
                                'asc'=>'t.fechahasta,p.nombrecompleto asc',
                                'desc'=>'t.fechahasta desc,p.nombrecompleto asc'
                            ),
                            'usuario'=>array(
                                'asc'=>'t.usuario,p.nombrecompleto asc',
                                'desc'=>'t.usuario desc,p.nombrecompleto asc'
                            ),
                            'fecha'=>array(
                                'asc'=>'t.fecha,p.nombrecompleto asc',
                                'desc'=>'t.fecha desc,p.nombrecompleto asc'
                            ),
                        )
                 )
        ));
    }

    public function searchaguinaldonavidad() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $this->id);
        $criteria->join = "right outer  JOIN  listaaguinaldonavidad() l on l.idaguinaldo=t.id";

        $criteria->select = 't.id,t.fechapago,t.fecha,t.usuario';
        $criteria->order = 't.fechapago desc ';
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        $usuario = Yii::app()->user->getName();
        if ($this->fechapago != NULL) {
            $criteria->addCondition("t.fechapago = '" . $this->fechapago . "'");
        }
        if ($this->fecha != NULL) {
            $criteria->addCondition("t.fecha = '" . $this->fecha . "'");
        }

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
        ));
    }

    public function searchsegundoaguinaldo() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $this->id);
        $criteria->join = "right outer  JOIN  listasegundoaguinaldo() l on l.idaguinaldo=t.id";

        $criteria->select = 't.id,t.fechapago,t.diasvacacion,t.fecha,t.usuario';
        $criteria->order = 't.fechapago desc ';
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        $usuario = Yii::app()->user->getName();
        if ($this->fechapago != NULL) {
            $criteria->addCondition("t.fechapago = '" . $this->fechapago . "'");
        }
        if ($this->fecha != NULL) {
            $criteria->addCondition("t.fecha = '" . $this->fecha . "'");
        }

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
        ));
    }

    public function searchprimaanual() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $this->id);
        $criteria->join = "right outer  JOIN  listaprimaanual() l on l.idprima=t.id";

        $criteria->addSearchCondition('l.gestion', $this->gestion, true, 'AND', 'ILIKE');
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        $criteria->select = 't.id,t.fechadesde,t.fechahasta,t.fecha,t.usuario,l.gestion';
        $criteria->order = 't.fechadesde desc ';
        $usuario = Yii::app()->user->getName();
        if ($this->fecha != NULL) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
        }


        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
        ));
    }

    public function searchfiniquito() {
        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.idtipopagobeneficio', 2);
        $criteria->compare('t.idhistorialestadoempleado', $this->idhistorialestadoempleado);
        $criteria->join = 'right outer  JOIN general.historialestadoempleado he on he.id=t.idhistorialestadoempleado right outer  JOIN general.empleado e on e.id=he.idempleado right outer  JOIN general.persona p on p.id=e.idpersona ';
        $criteria->addSearchCondition('p.nombrecompleto', $this->empleado, true, 'AND', 'ILIKE');
        if ($this->fecha != Null) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
        }
        if ($this->fechadesde != Null && $this->fechahasta != Null){
            $criteria->addCondition("he.fecharetiro::date between '" . $this->fechadesde . "'::date and '".$this->fechahasta."'::date");
        }else{
        if ($this->fechadesde != Null) {
            $criteria->addCondition("he.fecharetiro::date >='" . $this->fechadesde . "'");
        }
        if ($this->fechahasta != Null) {
            $criteria->addCondition("he.fecharetiro::date<= '" . $this->fechahasta . "'");
        }}
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
             'sort' => array(
                        'defaultOrder' => 't.id desc',                      
                        'attributes' => array(
                            'idempleado'=>array(
                                'asc'=>'p.nombrecompleto asc',
                                'desc'=>'p.nombrecompleto desc'
                                ),                         
                            'fechadesde'=>array(
                                'asc'=>'t.fechadesde,p.nombrecompleto asc',
                                'desc'=>'t.fechadesde desc,p.nombrecompleto asc'
                            ),
                            'fechahasta'=>array(
                                'asc'=>'t.fechahasta,p.nombrecompleto asc',
                                'desc'=>'t.fechahasta desc,p.nombrecompleto asc'
                            ),
                            'usuario'=>array(
                                'asc'=>'t.usuario,p.nombrecompleto asc',
                                'desc'=>'t.usuario desc,p.nombrecompleto asc'
                            ),
                            'fecha'=>array(
                                'asc'=>'t.fecha,p.nombrecompleto asc',
                                'desc'=>'t.fecha desc,p.nombrecompleto asc'
                            ),
                        )
                 )
        ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection() {
        return Yii::app()->rrhh;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Pagobeneficio the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     *
     * Sentencias entes de ejecutar metodo save
     * Antes de guardar se cambia todos los campos  de tipo character
     * varying y text a mayúsculas
     * Si existe el campo fecha, este toma el valor de la fecha actual antes
     * de almacenarse
     * Si existe el campo usuario, toma el valor del usuario actual antes de
     * almacenarse
     * 
     */
    public function beforeSave() {
        $this->listaplanilla = strtoupper($this->listaplanilla);
        $this->fecha = new CDbExpression('NOW()');
        $this->usuario = Yii::app()->user->getName();
        return parent::beforeSave();
    }
    /**
     * 
     * @param integer $idhistorialestadoempleado, id del historial de estado del empleado
     * @param date $fechasolicitud, fecha solicitud
     * @param integer $numeroquinquenios, cantidad de quinquenios solicitados
     * @param integer $idformapago, posibles valores 1= pago en efectivo, 2= pago mediante cheque y 3= pago bancario
     * @param type $descrpcionformapago
     * @return type
     */
    public function RegistrarQuinquenio($idhistorialestadoempleado, $fechasolicitud, $numeroquinquenios,$idformapago,$descrpcionformapago) {
        $usuario = Yii::app()->user->getName();
        $respuesta = Yii::app()->rrhh
                        ->createCommand("select  registrar_quinquenio($idhistorialestadoempleado ,'$fechasolicitud',$numeroquinquenios,$idformapago,'$descrpcionformapago','$usuario')  as r ")
                        ->queryScalar();
        return $respuesta;
    }
    /**
     * 
     * @param date $fechapago, fecha en la que se va ahacer el pago del  aguinaldo
     * @return string, una cadena informando si se pudo realizar el registro del aguinaldo
     */
    public function RegistrarAguinaldoNavidad($fechapago) {
        $usuario = Yii::app()->user->getName();
        $respuesta = Yii::app()->rrhh
                        ->createCommand("select  registrar_aguinaldo_navidad('$fechapago','$usuario')  as r ")
                        ->queryScalar();
                          
        return $respuesta;
    }
    /**
     * 
     * @param integer $id, id relacionado con el aguinaldo
     * @return boolean, true = si esta en estado de corte y false= si  la planilla a sido generada
     */
    public function EstadoAguinaldo($id) 
    {$corte= Pagobeneficio::model()->find('t.id='.SeguridadModule::dec($id));
        if ($corte->estado==1) {
         return true;
        }else{
            return false;
        }
    }
    /**
     * 
     * @param date $fechapago, fecha en la que se realizara el pago del aguinaldo
     * @param integer $idtipopagobeneficio, posibles valores 3= aguinaldo de navidad  y 5= segundo aguinaldo
     */
     public function ConsolidarAguinaldo($fechapago,$idtipopagobeneficio) {
        $usuario = Yii::app()->user->getName();
        if ($idtipopagobeneficio==3){
        Yii::app()->contabilidad
                        ->createCommand("select  registrar_asiento_aguinaldo_navidad('$fechapago','$usuario' ) ")
                        ->execute();
        }else{
             Yii::app()->contabilidad
                        ->createCommand("select  registrar_asiento_segundo_aguinaldo('$fechapago','$usuario' ) ")
                        ->execute(); 
        }              
        
    }
    /**
     * Actualizacion de la fecha de pago del Aguinaldo de Navidad
     * @param date $fechapagoantigua, fecha  de pago antigua
     * @param date $fechaactual, fecha de pago nueva
     */
    public function ActualizarAguinaldoNavidad($fechapagoantigua,$fechaactual) {
        $usuario = Yii::app()->user->getName();
        Yii::app()->rrhh
                        ->createCommand("update general.pagobeneficio set fechapago='$fechaactual'::date,usuario='$usuario'  where eliminado=false and idtipopagobeneficio=3 and fechapago='$fechapagoantigua'::date")
                        ->execute();
    }
    /**
     * Actualizacion de la informacion del pago el Segundo Aguinaldo
     * @param date $fechapagoantigua, fecha de pago antigua
     * @param date $fechaactual, fecha nueva de pago  de segundo aguinaldo
     * @param float $porecentaje, porcentaje que se pagara en especias
     */
    public function ActualizarSegundoAguinaldo($fechapagoantigua,$fechaactual,$porecentaje ) {
            $usuario = Yii::app()->user->getName();
            Yii::app()->rrhh
                            ->createCommand("update general.pagobeneficio set fechapago='$fechaactual'::date,usuario='$usuario'  ,diasvacacion=$porecentaje where eliminado=false and idtipopagobeneficio=5 and fechapago='$fechapagoantigua'::date")
                            ->execute();
        }
        /**
         * Registra el pago del Segundo Aguinaldo
         * @param date $fechapago, fecha de pago del Segundo Aguinaldo
         * @param float $porcentaje, porcentaje del pago que se pagara en especies
         * @return string, un mensaje en el caso que no se pueda registrar el Segundo Aguinaldo 
         */
    public function RegistrarSegundoaguinaldo($fechapago,$porcentaje) {
        $usuario = Yii::app()->user->getName();
        $respuesta = Yii::app()->rrhh
                        ->createCommand("select  registrar_segundo_aguinaldo('$fechapago',$porcentaje,'$usuario')  as r ")
                        ->queryScalar();    
           
        return $respuesta;
    }
    /**
     * Registro de la Prima Anual
     * @param date $fechadesde, fecha desde
     * @param date $fechahasta, fecha hasta
     * @param string $gestion, nombre de la gestion
     * @param float $porcentaje, el porcentaje que se pagara a los empleados
     * @return string, un mensaje en el caso de que no se pueda registrala Prima Anual
     */
    public function RegistrarPrimaanual($fechadesde, $fechahasta, $gestion, $porcentaje) {
        $usuario = Yii::app()->user->getName();
        $respuesta = Yii::app()->rrhh
                        ->createCommand("select  registrar_prima_anual('$fechadesde'::date,'$fechahasta'::date,'$gestion'::varchar(12),$porcentaje,'$usuario'::varchar(30))  as r ")
                        ->queryScalar();
        return $respuesta;
    }
    /**
     * 
     * @param integer $id, id del pago del beneficio
     * @return boolean, true= se puede mostrar el boton en el administrador, false= no se puede mostrar el boton en el administrador
     */ 
    public function MotrarElemento($id) {
        $beneficio = Pagobeneficio::model()->find('t.id=' . SeguridadModule::dec($id));
        if ($beneficio->estado == 1) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * 
     * @return string, un mensaje en el caso de que no se pueda eliminar
     */
    protected function beforeSafeDelete() {    
        $beneficio = Pagobeneficio::model()->find('t.id=' . $this->id);      
        if ($beneficio->estado == 1) {
            Yii::app()->rrhh
                    ->createCommand("update general.historialestadoempleado set fechaultidemnizacion='" . $beneficio->fechadesde . "' where id=" . $beneficio->idhistorialestadoempleado)
                    ->execute();
            
            return parent::beforeSafeDelete();
        } else {
            echo System::messageError('El Beneficio  NO puede ser eliminada porque tiene Asiento Contable Asociado... ! ');
            return;
        }
    }
    /**
     * 
     * @param integer[] $lista, lista de empleados  a los que se les pagara la Prima Anual
     */
    function GuaradarListaempleadoPrima($lista) {
        $cant = count($lista);
        $usuario = Yii::app()->user->getName();
        $ids = '';
        for ($i = 1; $i <= $cant; $i++) {
            $ids .= $lista[$i]['id'] . ',';
        }
        $ids .= '0';
        Yii::app()->rrhh->createCommand("update general.pagobeneficio set eliminado=true,usuario='$usuario' where idtipopagobeneficio=4 and infoadicionalformapago=(select infoadicionalformapago from general.pagobeneficio where id=" . $lista[1]['id'] . ") and id not in(" . $ids . ")")->execute();
        Yii::app()->rrhh->createCommand("select recalcular_porcentaje_primaanual( ".$lista[1]['id'] . ")")->execute();

        
    }
    /**
     * 
     * @param integer $id, id  relacionado con la Prima Anual
     * @return boolean, true= La Prima Anual se encuentra con Planilla  y false= La Prima Anual ya se encuentraconsolidada
     */
    public function MotrarOpcionPrimaAnual($id) {
        $corte = Pagobeneficio::model()->find('t.id=' . SeguridadModule::dec($id));
        if ($corte->estado == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Actualizacion de Parametros del Finiquito
     * @param integer $id, id relacionado con el Finiquito
     * @param integer $idprciva, id relacionado don el pago del rc-iva(Otros Pagos bnenficio)
     * @param float $prciva, nuevo monto del pago del rc-iva
     * @param array $listabeneficios, informacion de beneficio que se le pagara en su finiquito
     * @param array $listadeducciones, informacion de descuentos que se le hara en su finiquito
     * @param integer $idtiporetiro , cuyos posibles valores son: 
       1=RETIRO VOLUNTARIO
       2=CONCLUSIÓN DE CONTRATO
       3=RETIRO FORZOSO
       4=RETIRO CON CAUSA JUSTIFICADA
       11=ABANDONO DE TRABAJO
       12=FALLECIMIENTO POR CAUSA NATURAL
       13=RETIRO VOLUNTARIO (SIN VACACION)

     * @param date $fecharetiro, fecha de retiro del empleado
     * @param integer $idformapago , posibles valores 1= pago en efectivo, 2= pago mediante cheque y 3= pago bancario
     * @param string $descripcionformapago, descripcion de la forma de pago 
     */
    public function ActualizarParametros($id, $idprciva, $prciva, $listabeneficios, $listadeducciones, $idtiporetiro, $fecharetiro, $idformapago, $descripcionformapago) {
        $usuario = Yii::app()->user->getName();

        Yii::app()->rrhh
                ->createCommand("select modificar_fecharetiro_formapago($id,$idtiporetiro,"
                        . "'$fecharetiro'::date,$idformapago,'$descripcionformapago','$usuario')")
                ->execute();

        if (floatval($prciva) >= 0) {
            if ($idprciva > 0) {
                $piva = Otrasdeduccionesbonificaciones::model()->find('t.id=' . $idprciva);
                $piva->descripcion = 'Monto Factura Presentadas';
                $piva->monto = floatval($prciva);
                $piva->usuario = $usuario;
                $piva->save();
            } else {
                if (floatval($prciva) > 0) {
                    $piva = new Otrasdeduccionesbonificaciones;
                    $piva->descripcion = 'Monto Factura Presentadas';
                    $piva->monto = floatval($prciva);
                    $piva->usuario = $usuario;
                    $piva->tipo = 'R';
                    $piva->idpagobeneficio = $id;
                    $piva->save();
                }
            }
        }

        Yii::app()->rrhh
                ->createCommand("update general.otrasdeduccionesbonificaciones set eliminado=true where tipo='A' and idpagobeneficio=" . $id)
                ->execute();
        $cantidad = count($listabeneficios);
        for ($i = 1; $i <= $cantidad; $i++) {
            if ($listabeneficios[$i]['descripcion'] != '' && floatval($listabeneficios[$i]['monto']) > 0) {
                $piva = new Otrasdeduccionesbonificaciones;
                $piva->descripcion = $listabeneficios[$i]['descripcion'];
                $piva->monto = floatval($listabeneficios[$i]['monto']);
                $piva->idpagobeneficio = $id;
                $piva->tipo = 'A';
                $piva->usuario = $usuario;
                $piva->save();
            }
        }

        Yii::app()->rrhh
                ->createCommand("update general.otrasdeduccionesbonificaciones set eliminado=true where tipo='D' and idpagobeneficio=" . $id)
                ->execute();
        $cantidad = count($listadeducciones);
        for ($i = 1; $i <= $cantidad; $i++) {
            if ($listadeducciones[$i]['descripcion'] != '' && floatval($listadeducciones[$i]['monto']) > 0) {
                $piva = new Otrasdeduccionesbonificaciones;
                $piva->descripcion = $listadeducciones[$i]['descripcion'];
                $piva->monto = floatval($listadeducciones[$i]['monto']);
                $piva->idpagobeneficio = $id;
                $piva->tipo = 'D';
                $piva->usuario = $usuario;
                $piva->save();
            }
        }
    }

    function getLastFiniquito($idempleado) {
        echo 'idempleado ' . $idempleado;
        $idPagobeneficio = Pagobeneficio::model()->findBySql("select p.id from 
    general.pagobeneficio p inner join general.historialestadoempleado h on 
    p.idhistorialestadoempleado=h.id where p.eliminado=false and h.eliminado=false
    and p.idtipopagobeneficio=2 and h.idempleado=" . $idempleado)->id;
        return $idPagobeneficio;
    }

}
