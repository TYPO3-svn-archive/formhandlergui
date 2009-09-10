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
	 * Prepare controller and view and render it
	 *
	 * @param string $controller The controller that has to be fetched
	 * @param string $action The action for the controller
	 * @param array $params Params
	 * @return string The rendered view
	 * @author Christian Opitz <co@netzelf.de>
	 */
	public function dispatch($controller='standard', $action='index', $params=array()) {
		$this->componentManager = Tx_GimmeFive_Component_Manager::getInstance();
		
		$controllerClassName = Tx_FormhandlerGui_Configuration::getPrefixedPackageKey();
		$controllerClassName .= '_Controller_'.ucfirst($controller);
		
		$controllerClass = $this->componentManager->getComponent($controllerClassName);
		
		$actionMethod = $action.'Action';
		
		$viewClass = $this->componentManager->getComponent('Tx_FormhandlerGui_View');
		
		$viewClass->setControllerName($controller);
		$viewClass->setActionName($action);
		
		if (method_exists($controllerClass,$actionMethod)) {
			$controllerClass->$actionMethod();
		}else{
			throw new Exception('Action method '.$actionMethod.' not found in '.$controllerClassName);
		}
		
		return $viewClass->render();
	}
}
?>