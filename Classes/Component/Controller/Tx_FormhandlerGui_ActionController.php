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
 * Public License for more details.                                       */

/**
 * Abstract class for Controller Classes used by FormhandlerGui
 *
 * @package	TYPO3
 * @subpackage	Tx_FormhandlerGui
 * @abstract
 * @version $Id$
 */
abstract class Tx_FormhandlerGui_ActionController /*implements Tx_FormhandlerGui_ControllerInterface*/ {

	/**
	 * @var Tx_GimmeFive_Component_Manager
	 */
	protected $componentManager;

	/**
	 * @var Tx_FormhandlerGui_Configuration
	 */
	protected $config;

	/**
	 * @var Tx_FormhandlerGui_View
	 */
	protected $view;

	/**
	 * Indicates if the controller is running
	 * @var boolean
	 */
	private $controllerRunning;

	/**
	 * Just puting the objects to the instance
	 *
	 * @param Tx_GimmeFive_Component_Manager $componentManager
	 * @param Tx_FormhandlerGui_Configuration $configuration
	 * @param Tx_FormhandlerGui_View $view
	 * @return void
	 * @author Christian Opitz
	 */
	public function __construct(
	Tx_GimmeFive_Component_Manager $componentManager,
	Tx_FormhandlerGui_Configuration $configuration
	) {
		$this->componentManager = $componentManager;
		$this->config = $configuration;
	}
	
	public function setView($viewClass) {
		$this->view = $viewClass;
	} 

	/**
	 * Sets the internal attribute "langFile"
	 *
	 * @param string $langFile
	 * @return void
	 * @author Christian Opitz <co@netzelf.de>
	 */
	public function setLangFile($langFile) {
		global $LANG;
		$this->langFile = $langFile;
		$LANG->includeLLFile($this->langFileRoot.$langFile);
	}

	/**
	 * Returns the right settings for the formhandler (Checks if predefined form was selected)
	 *
	 * @return array The settings
	 * @author Reinhard Führicht <rf@typoheads.at>
	 */
	public function getSettings() {
		$settings = $this->config->getSettings();

		if($this->predefined) {

			$settings = $settings['predef.'][$this->predefined];
		}
		return $settings;
	}

	/**
	 * Runs an action - must not be called from within the controller
	 * 
	 * @param string $action
	 * @param array $params
	 * @return void
	 */
	public function run($action = 'index', $params = null) {
		if ($this->controllerRunning) {
			throw new Exception('Tx_FormhandlerGui_AbstractController::runAction() can not be executed from within controllers!');
			return;
		}

		$this->setRunning(true);

		if (method_exists($this, 'init')) {
			$this->init();
		}

		$actionMethod = $action.'Action';

		if (method_exists($this,$actionMethod)) {
			$this->$actionMethod();
		}else{
			throw new Exception('Action method '.$actionMethod.' not found in '.get_class($this));
		}

		$this->setRunning(false);
	}

	/**
	 * Stops the current run-process and forwards to another action
	 * without resetting the view
	 *
	 * @param $action - the action to be executed
	 * @param $controller - optional: another controller
	 * @param $params - optional
	 * @return void
	 * @author Christian Opitz <co@netzelf.de>
	 */
	protected function _forward($action, $controller = null, $params = null) {
		$this->setRunning(false);
		
		if (is_object($this->view)) {
			if (method_exists($this->view, 'setActionName')) {
				$this->view->setActionName($action);
			}
		}

		if ($controller === null) {
			$this->run($action, $params);
		}else{
			$controllerClassName = Tx_FormhandlerGui_Configuration::getControllerClassName($controller);
			$controllerClass = $this->componentManager->getComponent($controllerClassName);
			$controllerClass->run($action, $params);
		}
	}

	/**
	 * Stops the current run-process, resets the view and forwards to another action
	 *
	 * @param $action - the action to be executed
	 * @param $controller - optional: another controller
	 * @param $params - optional
	 * @return void
	 * @author Christian Opitz <co@netzelf.de>
	 */
	private function _redirect($action, $controller = null, $params = null) {
		$this->setRunning(false);
		$dispatcher = $this->componentManager->getComponent('Tx_FormhandlerGui_Dispatcher');
		$dispatcher->dispatch($controller,$action,$params);
	}

	/**
	 * Sets controller running status in controller and view
	 *
	 * @param boolean $status If running or not
	 * @return void
	 */
	private function setRunning($status) {
		$this->controllerRunning = $status;
		if (is_object($this->view)) {
			if (method_exists($this->view, 'setActionName')) {
				$this->view->setControllerRunning($status);
			}
		}
	}
}
?>
