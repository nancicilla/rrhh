<?php
/*
 * Tipocontrato.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 08/04/2019
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
 
 * This is the model class for table "general.tipocontrato".
 *
 * The followings are the available columns in table 'general.tipocontrato':
 * @property integer $id
 * @property string $nombre
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Tipobetipocont[] $tipobetipoconts
 * @property Aportipocont[] $aportipoconts
 * @property Contrato[] $contratos
 */
class Tipocontrato extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public function defaultScope() {
        return array(
            'condition' => $this->getTableAlias(false, false) .
            '.eliminado = false',
        );
    }
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
            return 'general.tipocontrato';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('nombre', 'length', 'max'=>50),
                    array('usuario', 'length', 'max'=>30),
                    array('fecha, eliminado,generarcc,diasfestivosparo,generafiniquito', 'safe'),
                    array('idministerio', 'required', 'on' => array('insert', 'update')),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, nombre, usuario, fecha,generarcc,diasfestivosparo, eliminado', 'safe', 'on'=>'search'),
            );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
            // NOTE: you may need to adjust the relation name and the related
            // class name for the relations automatically generated below.
            return array(
                   
                      'contratos' => array(self::HAS_MANY, 'Contrato', 'idtipocontrato'),
                    'aporbetipoconts' => array(self::HAS_MANY, 'Aporbetipocont', 'idtipocontrato'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'nombre' => 'Nombre',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'generarcc'=>'Generar C.C.',
                    'diasfestivosparo'=>'Pago de dias Feriados?',
                    'idministerio'=>'Clasificacion Contrato Ministerio',
                    'eliminado' => 'Eliminado',
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
    public function search()
    {
            // @todo Please modify the following code to remove attributes that should not be searched.

            $criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->addSearchCondition('t.nombre',$this->nombre,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
            ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection()
    {
            return Yii::app()->rrhh;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Tipocontrato the static model class
     */
    public static function model($className=__CLASS__)
    {
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
		$this->nombre=strtoupper($this->nombre);
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }
    /**
     * 
     * @param integer $idtipocontrato, id del tipo de contrato
     * @param integer[] $beneficios, id de los beneficios que se relacionaran con el contrato
     * @param integer[] $aportaciones, id de las aportaciones que se relacionaran con el tipo de contrato
     */
    public function registrarBeneficioAportes($idtipocontrato, $beneficios,$aportaciones)
    {
        $cantb= count($beneficios);
        $canta=count($aportaciones);
        
            for ($i=0; $i <$cantb ; $i++) { 
              $tbtc=new Aporbetipocont;
              $tbtc->idaportacionbeneficio=$beneficios[$i];
              $tbtc->tipo=true;
              $tbtc->idtipocontrato=$idtipocontrato;
              $tbtc->save();
            }

            for ($j=0; $j <$canta ; $j++) { 
              $atc=new Aporbetipocont;
              $atc->idtipocontrato=$idtipocontrato;
              $atc->tipo=false;
              $atc->idaportacionbeneficio=$aportaciones[$j];
              $atc->save();

            }
        


    }
    /**
     * 
     * @param integer $idtipocontrato, id del tipo de contrato
     * @return array de aportaciones relaciondas con el tipo de contrato
     */
    public function listaApotaciones($idtipocontrato)
    {
        $lista=array();
        $listaa=Aporbetipocont::model()->findAll('t.eliminado=false and t.tipo=false and t.idtipocontrato='.$idtipocontrato);
        foreach ($listaa as $valor) {
            array_push($lista, $valor->idaportacionbeneficio);
        }
        return $lista;
    }
    /**
     * 
     * @param integer $idtipocontrato, id del tipo de contrato
     * @return array de beneficios relacionados con el tipo de contrato
     */
        public function listaTipoBeneficio($idtipocontrato)
    {
        $lista=array();
        $listaa=Aporbetipocont::model()->findAll(' t.eliminado=false and tipo=true and t.idtipocontrato='.$idtipocontrato);
        foreach ($listaa as $valor) {
            array_push($lista, $valor->idaportacionbeneficio);
        }
         return $lista;
    }
    /**
     * 
     * @param integer $idtipocontrato, id tipo de contrato
     * @param integer[] $beneficios, id de los beneficio que se relacionaran con el tipo de contrato
     * @param integer[] $aportaciones, id de las aportaciones que serelacionaran con el tipo de contrato
     */
    public function actualizarBeneficioAportes($idtipocontrato, $beneficios,$aportaciones)
    {
        $cantb= count($beneficios);
        $canta=count($aportaciones);
        // situaciones 1 cuando no se modifica nada,2 aunmeta beneficio, 3 disminuye beneficio
          $connection=Yii::app()->rrhh;
                $sql='update  general.aporbetipocont    set eliminado=true  WHERE   idtipocontrato= :idcontrato ';              
                $command=$connection->createCommand($sql);
                $command->bindParam(':idcontrato',$idtipocontrato,PDO::PARAM_INT);
                $command->execute(); 
               
        for ($i=0; $i <$cantb ; $i++) { 
            $beneficio = Aporbetipocont::model()->find('t.idaportacionbeneficio='.$beneficios[$i].' and t.eliminado=true');
            
            if ($beneficio!= null) {
             $beneficio->eliminado = false;
             $beneficio->save();
            }else{
                $tbtc=new Aporbetipocont;
              $tbtc->idaportacionbeneficio=$beneficios[$i];
              $tbtc->tipo=true;
              $tbtc->idtipocontrato=$idtipocontrato;
              $tbtc->save(); 
            }            
        }

           for ($j=0; $j <$canta ; $j++) { 
            $aportacion = Aporbetipocont::model()->find('t.idaportacionbeneficio='.$aportaciones[$j].' and t.eliminado=true');    
            if ($aportacion!= null) {
             $aportacion->eliminado = false;
             $aportacion->save();
            }else{
              $aportacion=new Aporbetipocont;
              $aportacion->idaportacionbeneficio=$aportaciones[$j];
              $aportacion->tipo=false;
              $aportacion->idtipocontrato=$idtipocontrato;
              $aportacion->save(); 
            }            
        }
    }
    /**
     * 
     * @return string, mensaje en caso que no se pueda eliminar un tipo de contrato
     */
     protected function beforeSafeDelete() {
        $id=$this->id;         
        $respuesta=Yii::app()->rrhh
            ->createCommand("select borrar_tipocontrato($id) as r")
            ->queryScalar();   

        if ($respuesta) {
            
            return parent::beforeSafeDelete();
        } else {
            echo System::messageError('El Tipo de Contrato NO puede ser eliminado porque tiene Empleados asociados a este Tipo de Contrato... ! ');
            return;
        }
    }
}
