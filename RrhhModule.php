<?php
/*
 * RrhhModule.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 28/03/2019
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
 */
class RrhhModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'rrhh.models.*',

			'rrhh.components.*',
		));
      		$this->layoutPath = Yii::getPathOfAlias('application.modules.rrhh.views.layouts');
                $this->layout = 'main';
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{			
                        $controller->layout = 'main';
                        // this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
        
        public function afterControllerAction($controller, $action)
	{
		if(parent::afterControllerAction($controller, $action))
		{		
                        $controller->layout = 'main';
                        // this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	  public function getAssetFolder(){
            return "protected/modules/rrhh/assets";
        }
}
