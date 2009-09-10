<?php
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
 *
 * $Id$
 *                                                                        */

require_once (t3lib_extMgm::extPath('formhandlergui') . 'Classes/Component/Tx_GimmeFive_Component_Manager.php');

/**
 * The Dispatcher instatiates the Component Manager and delegates the process to the given controller.
 *
 * @author	Reinhard Führicht <rf@typoheads.at>
 * @package	Tx_Formhandler
 * @subpackage	Controller
 */
class Tx_FormhandlerGui_Dispatcher {
	
	/**
	 * @var Tx_GimmeFive_Component_Manager
	 */
	private $componentManager;
	
	/**
	 * Main method of the dispatcher.
	 *
	 * @return string rendered view
	 * @param string $controller The controller that has to be fetched
	 * @param string $action The action for the controller
	 * @param array $params Params
	 */
	public function dispatch($controller='standard', $action='index', $params=array()) {
		$this->componentManager = Tx_GimmeFive_Component_Manager::getInstance();
		
		$controllerClassName = Tx_FormhandlerGui_Configuration::getPrefixedPackageKey();
		$controllerClassName .= '_Controller_'.ucfirst($controller);
		
		$controllerClass = $this->componentManager->getComponent($controllerClassName);
		
		$actionMethod = $action.'Action';
		
		$viewClass = $this->componentManager->getComponent('Tx_FormhandlerGui_View');
		
		$viewClass->setController($controller);
		$viewClass->setAction($action);
		
		//$this->componentManager->injectConstructorArguments('Tx_FormhandlerGui_View');
		
		if (method_exists($controllerClass,$actionMethod)) {
			$controllerClass->$actionMethod();
		}else{
			throw new Exception('Action method '.$actionMethod.' not found in '.$controllerClassName);
		}
		
		return $viewClass->render();
	}
}
?>