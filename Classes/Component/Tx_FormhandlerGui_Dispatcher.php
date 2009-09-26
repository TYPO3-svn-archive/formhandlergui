<?php
require_once (t3lib_extMgm::extPath('formhandlergui') . 'Classes/Component/Tx_GimmeFive_Component_Manager.php');

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 * Prepares controller and views
 *
 * @package	TYPO3
 * @subpackage	Tx_FormhandlerGui
 * @version $Id$
 */
class Tx_FormhandlerGui_Dispatcher {
	
	/**
	 * @var Tx_GimmeFive_Component_Manager
	 */
	private $componentManager;
	
	/**
	 * @var string
	 */
	private $controller = 'standard';
	
	/**
	 * @var string
	 */
	private $action = 'index';
	
	/**
	 * @var array
	 */
	private $params = array();
	
	/**
	 * Prepare controller and view and render it
	 *
	 * @param string $controller The controller that has to be fetched
	 * @param string $action The action for the controller
	 * @param array $params Params
	 * @return string The rendered view
	 * @author Christian Opitz <co@netzelf.de>
	 */
	public function dispatch($controller=null, $action=null, $params=null) {
		$controller = ($controller === null) ? $this->controller : $controller;
		$action = ($action === null) ? $this->action : $action;
		$params = ($params === null) ? $this->params : $params;
		
		$this->componentManager = Tx_GimmeFive_Component_Manager::getInstance();
		
		$controllerClassName = Tx_FormhandlerGui_Configuration::getControllerClassName($controller);
		
		$controllerClass = $this->componentManager->getComponent($controllerClassName);
		$controllerClass->setParams($params);
		
		$viewClass = $this->componentManager->getComponent('Tx_FormhandlerGui_View');
		
		$viewClass->init($controller, $action);
		
		$controllerClass->setView($viewClass);
		$controllerClass->run($action, $params);
		
		return $viewClass->render();
	}
	
	public function setController($controller) {
		$this->controller = $controller;
	}
	
	public function setAction($action) {
		$this->action = $action;
	}
	
	public function setParams(array $params) {
		$this->params = $params;
	}
}
?>