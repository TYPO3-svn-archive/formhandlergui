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
 *                                                                        */

/**
 * After hours of thinking - finally this class that for sure doesn't meet
 * the ideals of FLOW3 - but: it's simple and it works
 *
 * @package	TYPO3
 * @subpackage	Tx_FormhandlerGui
 * @version $Id$
 */
class Tx_FormhandlerGui_View {

	/**
	 * The scope of this class (read by component manager, could be moved to docblock)
	 * @var string
	 */
	const SCOPE = 'prototype';
	
	/**
	 * The assigned values
	 * @var array
	 */
	private $vars = array();

	/**
	 * The name of the controller
	 * @var string
	 */
	private $controllerName;

	/**
	 * The name of the action
	 * @var string
	 */
	private $actionName;

	/**
	 * Can be TEMPLATE or VIEWSCRIPT
	 * @var string
	 */
	private $renderMethod;

	/**
	 * @var Tx_FormhandlerGui_Configuration
	 */
	private $config;

	/**
	 * @var Tx_GimmeFive_Component_Manager
	 */
	private $componentManager;

	/**
	 * Path to the current view file
	 * @var string
	 */
	private $viewFile;

	/**
	 * Indicates whether the view should be rendered automatically from beyond the controller
	 * @var boolean
	 */
	private $noRender = false;

	/**
	 * Indicates if the controller is running
	 * @var boolean
	 */
	private $controllerRunning = false;

	/**
	 * Contains rendered contents by controller
	 * @var string
	 */
	private $renderedContent = '';

	/**
	 * @param $componentManager
	 * @param $configuration
	 * @return void
	 * @author Christian Opitz <co@netzelf.de>
	 */
	public function __construct(Tx_GimmeFive_Component_Manager $componentManager, Tx_FormhandlerGui_Configuration $configuration) {
		$this->componentManager = $componentManager;
		$this->config = $configuration;
	}

	/**
	 * Resets all internal vars and sets controller and action. Typically called from dispatcher
	 *
	 * @param $controllerName
	 * @param $actionName
	 * @return void
	 * @author Christian Opitz <co@netzelf.de>
	 */
	public function init($controllerName = '', $actionName = '') {
		$this->reset();

		$this->setControllerName($controllerName);
		$this->setActionName($actionName);
	}

	/**
	 * Resets internal vars
	 *
	 * @return void
	 * @author Christian Opitz <co@netzelf.de>
	 */
	protected function reset() {
		if ($this->controllerRunning) {
			return;
		}

		$this->renderedContent = '';
		$this->controllerRunning = false;
		$this->noRender = false;
		$this->vars = array();

		$this->viewFile = '';
		$this->renderMethod = '';
		$this->actionName = '';
		$this->controllerName = '';
	}

	/**
	 * Assigns a value (To enable $this->view->varName = value as shortcut for assign)
	 * 
	 * @param $varName
	 * @param $value
	 * @return void
	 * @author Christian Opitz <co@netzelf.de>
	 */
	public function __set($varName, $value) {
		$this->assign($varName, $value);
	}

	/**
	 * Puts a variable to the internal array for the current controller
	 *
	 * @param string $varName
	 * @param mixed $value
	 * @return void
	 * @author Christian Opitz <co@netzelf.de>
	 */
	public function assign($varName, $value) {
		$varName = str_replace(array('$',' ','/','\\'),'',$varName);
		$name = strval(trim($varName));
		if (strlen($name) > 0) {
			$this->vars[$name] = $value;
		} else {
			throw new Exception('Name for the assigned variable "'.$name.'" is of the wrong type or contains restricted chars.');
		}
	}

	/**
	 * Renders the view to a given template or viewScript. If you pass it a path
	 * it'll try to get the template this relative to the according view path -
	 * f.e. if rendering method is set to VIEWSCRIPT and you pass 'Standard/index'
	 * it fetches '[DIRECTORY_VIEWSCRIPT]/Standard/index.[DEFAULT_VIEWSCRIPT_EXT].
	 * You can switch the rendering method by using one of the extension that are set
	 * for the according rendering method - f.e. if you use Standard/index.html and
	 * VIEWSCRIPT is set as default it'll fetch as TEMPLATE anyway.
	 *
	 * @param string $view Another view if needed
	 * @return string The rendered view
	 * @author Christian Opitz <co@netzelf.de>
	 * @see Tx_FormhandlerGui_Configuration
	 */
	public function render($view = NULL) {
		if ($this->noRender && !$this->controllerRunning) {
			return $this->renderedContent;
		}

		if (!$this->prepareRendering($view)) {
			return "";
		}

		if ($this->renderMethod == 'VIEWSCRIPT') {
			$content = $this->renderViewScript();
		} else {
			$content = $this->renderTemplate();
		}

		if ($this->controllerRunning) {
			$this->noRender = true;
			$this->renderedContent .= $content;
		}

		return $content;
	}

	/**
	 * Renders a html-template with markers
	 *
	 * @return string The rendered template
	 * @author Christian Opitz <co@netzelf.de>
	 */
	private function renderTemplate() {
		//TODO: Make a function that renders the TYPO way
		return '';
	}

	/**
	 * Calls the viewScript renderer
	 *
	 * @return string the rendered viewScript
	 * @author Christian Opitz <co@netzelf.de>
	 */
	private function renderViewScript() {
		$renderer = $this->componentManager->getComponent('Tx_FormhandlerGui_View_Renderer');
		return $renderer->render($this->viewFile, $this->vars);
	}

	/**
	 * Prepares the rendering method and the view file
	 *
	 * @param string $view
	 * @return boolean If preparation was successfull
	 * @author Christian Opitz <co@netzelf.de>
	 * @see Tx_FormhandlerGui_View::render()
	 */
	public function prepareRendering($view=null) {
		if ($view !== null) {
			$file = pathinfo($view);
		}else{
			if (empty($this->controllerName) || empty($this->actionName)) {
				throw new Exception('Could not autoload the view file. No controller or action defined. Set controller and action name first.');
				return false;
			}

			$file = array(
				'dirname' => ucfirst($this->controllerName), 
				'filename' => $this->actionName
			);
		}

		if (empty($file['extension'])) {
			$file['extension'] = $this->config->getDefaultExtension();
			$this->renderMethod = Tx_FormhandlerGui_Configuration::DEFAULT_RENDERMETHOD;
		}else{
			if ($this->isTemplate($file['extension'])) {
				$this->renderMethod = 'TEMPLATE';
			}elseif ($this->isViewScript($file['extension'])) {
				$this->renderMethod = 'VIEWSCRIPT';
			}else{
				throw new Exception('The requested view '.$view.' is of the wrong file type ('.
				Tx_FormhandlerGui_Configuration::VIEWSCRIPT_EXTENSIONS.','.
				Tx_FormhandlerGui_Configuration::TEMPLATE_EXTENSIONS.' allowed)'
				);
			}

		}

		if ($this->renderMethod == 'VIEWSCRIPT') {
			$path = $this->config->getViewScriptPath();
		}else{
			$path = $this->config->getTemplatePath();
		}

		$viewFile = rtrim($path,"\\,/");

		if (!empty($file['dirname'])) {
			$viewFile .= '/'.ltrim($file['dirname'],"\\,/");
		}

		$viewFile .= '/'.$file['filename'];
		$viewFile .= '.'.$file['extension'];

		if (!@file_exists($viewFile)) {
			throw new Exception('Could not retrieve template file: "'.$viewFile.'" (does not exist)');
			return false;
		}

		$this->viewFile = $viewFile;

		return true;
	}

	/**
	 * Tests if a file extension is of template
	 *
	 * @param $ext
	 * @return boolean True if it is a template
	 * @author Christian Opitz <co@netzelf.de>
	 */
	private function isTemplate($ext) {
		$extensions = explode(',', Tx_FormhandlerGui_Configuration::TEMPLATE_EXTENSIONS);
		return in_array($ext,$extensions);
	}

	/**
	 * Tests if a file extension is of viewScript
	 *
	 * @param $ext
	 * @return boolean True if it is a viewScript
	 * @author Christian Opitz <co@netzelf.de>
	 */
	private function isViewScript($ext) {
		$extensions = explode(',', Tx_FormhandlerGui_Configuration::VIEWSCRIPT_EXTENSIONS);
		return in_array($ext,$extensions);
	}

	/**
	 * Set the controller name. This is needed to put variables to
	 * the proper key while assigning and to fetch the right view
	 *
	 * @param $controllerName
	 * @return void
	 * @author Christian Opitz <co@netzelf.de>
	 */
	public function setControllerName($controllerName) {
		$this->controllerName = $controllerName;
	}

	/**
	 * Set the action name. This is needed  to fetch the right view
	 *
	 * @param $actionName
	 * @return void
	 * @author Christian Opitz <co@netzelf.de>
	 */
	public function setActionName($actionName) {
		$this->actionName = $actionName;
	}

	/**
	 * Sets if the view should be rendered automatically from beyond the controller
	 *
	 * @param $render
	 * @return void
	 * @author Christian Opitz <co@netzelf.de>
	 */
	public function setNoRender($render) {
		$this->noRender = $render;
	}

	/**
	 * Tells the view if the controller is running
	 *
	 * @param boolean $status
	 * @return void
	 * @author Christian Opitz <co@netzelf.de>
	 */
	public function setControllerRunning($status) {
		$this->controllerRunning = $status;
	}
}