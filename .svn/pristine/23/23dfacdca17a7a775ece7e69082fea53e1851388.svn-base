<?php
/*
 * Horariolactancia.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 09/12/2019
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
 
 * This is the model class for table "horariolactancia".
 *
 * The followings are the available columns in table 'horariolactancia':
 * @property integer $id
 * @property string $fechadesde
 * @property string $fechahasta
 * @property string $rangohora
 * @property string $configuracion
 * @property integer $idsubsidio
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 *
 * The followings are the available model relations:
 * @property Subsidio $idsubsidio0
 * @property Diaslactancia[] $diaslactancias
 */
class Horariolactancia extends CActiveRecord
{
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public $empleado,$fechahasta;
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
            return 'horariolactancia';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idsubsidio', 'numerical', 'integerOnly'=>true),
                    array('usuario', 'length', 'max'=>30),
                    array('fechadesde, fechahasta, fecha, eliminado', 'safe'),
                    array('fechadesde,idsubsidio','required', 'on' => array('insert')),
                    array('fechadesde','required', 'on' => array('update')),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, fechadesde,empleado, idsubsidio, usuario, fecha, eliminado', 'safe', 'on'=>'search'),
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
                    'idsubsidio0' => array(self::BELONGS_TO, 'Subsidio', 'idsubsidio'),
                    'diaslactancias' => array(self::HAS_MANY, 'Diaslactancia', 'idhorariolactancia'),
                    
            );
    }
     public function listaHorarios($idsubsidio)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.idsubsidio = ".$idsubsidio);
        $criteria->addCondition("t.fechadesde<=now()::date");
        $criteria->order='t.id DESC';
        $criteria->limit=1;
        $hl= Horariolactancia::model()->find($criteria);
        return Cuerpohorariolactancia::model()->listaHorarios($hl->id);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'fechadesde' => 'Fecha Desde',
                    'fechahasta' => 'Fecha Hasta',
                    'idsubsidio' => 'Idsubsidio',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'idhorario'=>'Horario'
            );
    }
   /**
    * 
    * @param integer $idsubsidio, id del subisdio
    * @param integer $idempleado, id del empleado
    * @param date $fechadesde, fecha inicio del horario de lactancia
    * @param array $horario, informacion del horario
    * @return string, muestra un mensaje en caso de solapamineto de horario
    */
   public function registrarDatosHorarioLactancia($idsubsidio,$idempleado,$fechadesde,$horario)
    {
       $cadena='';
       $cant= count($horario);
       $hayhorario= Yii::app()->rrhh
            ->createCommand("select count(*) from  horariolactancia  where  eliminado=false and idsubsidio=$idsubsidio and fechadesde='$fechadesde'" )->queryScalar(); 
       $usuario = Yii::app()->user->getName();  
       if ($hayhorario==0){
           $hl=new Horariolactancia;
           $hl->fechadesde=$fechadesde;
           $hl->idsubsidio=$idsubsidio;
           $hl->save();
       
       for ($i=1; $i <=$cant ; $i++) { 
            if ($horario[$i]['iddia']!='') {
              $l= new Cuerpohorariolactancia;              
              $l->idhorariolactancia=$hl->id;
              $l->iddia=$horario[$i]['iddia'];
              $l->iddiad=$horario[$i]['iddiad'];
              $l->horai=$horario[$i]['horai'];
              $l->horas=$horario[$i]['horas'];
              $l->save();
            }
        }
         Yii::app()->rrhh
            ->createCommand("select   public.resetear_selladas_lactancia( $idempleado ,  '$fechadesde'::date,'POR REGISTRO DE HORARIO LACTANCIA', '$usuario' )")->execute(); 
           
       }else{
           $cadena='Cuenta con un horario en esa fecha...';
       }
        return $cadena;
        
    }
    /**
     * 
     * @param integer $idsubsidio, id del subsidio
     * @param integer $idhorariolactancia, id del horario de lactancia
     * @param integer $idempleado, id del empleado
     * @param date $fechadesde, fecha inicio de la aplicacion del horario
     * @param array $horario, informacion del horario
     * @return string,muestra un mensaje en caso de solapamiento del horario de lactancia
     */
     public function actualizarDatosHorarioLactancia($idsubsidio,$idhorariolactancia,$idempleado,$fechadesde,$horario)
    {
       $cadena='';
       $cant= count($horario);
       $hayhorario= Yii::app()->rrhh
            ->createCommand("select count(*) from  horariolactancia  where  eliminado=false and idsubsidio=$idsubsidio and id<>$idhorariolactancia and fechadesde='$fechadesde'" )->queryScalar(); 
       $usuario = Yii::app()->user->getName();  
       if ($hayhorario==0){           
           Yii::app()->rrhh
            ->createCommand("update cuerpohorariolactancia set eliminado=true,usuario='$usuario',fecha=now() where idhorariolactancia=$idhorariolactancia ")->execute(); 
                 
       for ($i=1; $i <=$cant ; $i++) { 
            if ($horario[$i]['iddia']!='') {
              $l= new Cuerpohorariolactancia;              
              $l->idhorariolactancia=$idhorariolactancia;
              $l->iddia=$horario[$i]['iddia'];
              $l->iddiad=$horario[$i]['iddiad'];
              $l->horai=$horario[$i]['horai'];
              $l->horas=$horario[$i]['horas'];
              $l->save();
            }
        }
         Yii::app()->rrhh
            ->createCommand("select   public.resetear_selladas_lactancia( $idempleado ,  '$fechadesde'::date,'POR MODIFICACION DE HORARIO LACTANCIA', '$usuario' )")->execute(); 
           
       }else{
           $cadena='Cuenta con un horario en esa fecha...';
       }
        return $cadena;
        
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
		$criteria->compare('t.idsubsidio',$this->idsubsidio);
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
                $criteria->join='right outer  JOIN subsidio s on t.idsubsidio=s.id inner join  general.empleado e on e.id=s.idempleado inner join general.persona p on p.id=e.idpersona  ';
                $criteria->addCondition('e.eliminado=false');
                $criteria->addSearchCondition('p.nombrecompleto',$this->empleado,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
                  if ($this->fechadesde != Null) {
		$criteria->addCondition("t.fechadesde::date = '" . $this->fechadesde. "'");
		 }

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
                'sort' => array(
                        'defaultOrder' => 'p.nombrecompleto,t.fechadesde asc',
                        'attributes' => array(
                            'idempleado'=>array(
                                'asc'=>'p.nombrecompleto asc,t.fechadesde asc',
                                'desc'=>'p.nombrecompleto desc,t.fechadesde asc'
                            ),
                            'fechadesde'=>array(
                                'asc'=>'t.fechadesde asc, p.nombrecompleto asc',
                                'desc'=>'t.fechadesde desc,p.nombrecompleto asc'
                            ),
                            'usuario'=>array(
                                'asc'=>'t.usuario asc,p.nombrecompleto asc',
                                'desc'=>'t.usuario desc,p.nombrecompleto asc'
                            )
                        )
                     )
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
     * @return Horariolactancia the static model class
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
		$this->usuario= Yii::app()->user->getName();
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }
    /**
     * 
     * @param integer $id, id del horario de lactancia
     * @return boolean, true= en caso de que la fecha inicio de la aplicacion del horario de lactancia NO se encuentre dentro de un corte de planilla y false en el caso de que la fecha de aplicacion este denro de un corte de planilla
     */
    public function mostrarBorrar($id)
    {
        $id=SeguridadModule::dec($id);     
        $hl= Horariolactancia::model()->findByPk($id);
        $fecha= Yii::app()->rrhh
            ->createCommand("select  fechafc  from planilla  where eliminado=false  order  by id desc  limit 1 ")
            ->queryScalar();
        $borra;    
        if ($fecha!=false ){
            if ($hl->fechadesde> $fecha) {                
                $borra=true;
            } else {
               $borra=false;
            }
        }else{
            
                $borra=true ;
           
        }
        
    return $borra;
    }
    public function registrarHorarioEmpleado($listahorarios,$listaempleados,$fechadesde,$fechahasta) {
       $usuario = Yii::app()->user->getName(); 
        for ($emp=1;$emp<= count($listaempleados);$emp++){ 
            if($listaempleados[$emp]['seleccionar']=='1'){
            $cant= count($listahorarios);
            $horario= Yii::app()->rrhh->createCommand("select hl.id as idh, s.id, hl.fechadesde,(select count(*) from horariolactancia hl1 where hl1.eliminado=false and hl1.idsubsidio=s.id and hl1.fechadesde=('".$fechahasta."')::date+1 ) as hayhorario from subsidio s inner join horariolactancia hl on hl.idsubsidio=s.id  where s.eliminado=false and hl.eliminado=false  and s.idempleado= ".$listaempleados[$emp]['id']." and hl.fechadesde<='".$fechadesde."' order by hl.fechadesde   desc limit 1 " )->queryAll()[0]; 
            
              $hl=new Horariolactancia;
                $hl->fechadesde=$fechadesde;
                $hl->idsubsidio=$horario['id'];
                $hl->save();
                for ($i=1; $i <=$cant ; $i++) { 
                 if ($listahorarios[$i]['iddia']!='') {
                   $l= new Cuerpohorariolactancia;              
                   $l->idhorariolactancia=$hl->id;
                   $l->iddia=$listahorarios[$i]['iddia'];
                   $l->iddiad=$listahorarios[$i]['iddiad'];
                   $l->horai=$listahorarios[$i]['horai'];
                   $l->horas=$listahorarios[$i]['horas'];
                   $l->save();
                 }
             }
            
            if ( $horario['fechadesde']==$fechadesde){
                if($horario['hayhorario']>0){
                    Yii::app()->rrhh
                 ->createCommand("update horariolactancia set eliminado=true where id=".$horario['idh'] )->execute();
                }else{
                     Yii::app()->rrhh
                 ->createCommand("update horariolactancia set fechadesde=('".$fechahasta."')::date+1 where id=".$horario['idh'] )->execute();
            
                }
            }
            else{
                 if($horario['hayhorario']==0){
                      Yii::app()->rrhh
                 ->createCommand("select registrar_copia_horariolactancia  ( ".$horario['idh'].", ('".$fechahasta."')::date+1,'$usuario') " )->execute();            
                 }                
            }           
               Yii::app()->rrhh
                 ->createCommand("select   public.resetear_selladas_lactancia( ".$listaempleados[$emp]['id']." ,  '$fechadesde'::date,'POR REGISTRO DE HORARIO LACTANCIA', '$usuario' )")->execute(); 

            }  
        }
        
                 }
    }


