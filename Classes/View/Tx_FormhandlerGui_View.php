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
 * @version $id$
 */
class Tx_FormhandlerGui_View {

	private $viewScriptExtensions = array('phtml','php');
	
	/**
	 * The assigned values
	 *
	 * @var array
	 */
	private $vars = array();

	private $controller;
	
	private $action;
	
	private $viewScript;
	
	private $renderMethod;
	
	/**
	 * @var Tx_FormhandlerGui_Configuration
	 */
	private $config;

	/**
	 * @var Tx_GimmeFive_Component_Manager
	 */
	private $componentManager;

	public function __construct(Tx_GimmeFive_Component_Manager $componentManager, Tx_FormhandlerGui_Configuration $configuration) {
		$this->componentManager = $componentManager;
		$this->config = $configuration;
	}
	
	public function assign($varName, $value) {
		$varName = str_replace(array('$',' ','/','\\'),'',$varName);
		$name = strval(trim($varName));
		if (strlen($name) > 0) {
			$this->vars[$this->controller][$name] = $value;
		} else {
			throw new Exception('Name for the assigned variable "'.$name.'" is of the wrong type or contains restricted chars.');
		}
	}

	public function render($template = NULL) {
		
		$templateFile = $this->getTemplateFile($template);
		
		if ($this->renderMethod == 'VIEWSCRIPT') {
			return $this->renderViewScript($templateFile);
		} else {
			return $this->renderTemplate($templateFile);
		}
	}

	private function renderTemplate($templateFile) {
		//TODO: Make a function that renders the TYPO way
	}

	private function renderViewScript($templateFile) {
		$renderer = $this->componentManager->getComponent('Tx_FormhandlerGui_View_Renderer');
		return $renderer->render($templateFile, $this->vars[$this->controller]);
	}

	/**
	 * Gets the view script path
	 *
	 * @param $path string Path or Directory (if $cd is true)
	 * @param $cd boolean Change Directory
	 * @return unknown_type
	 */
	public function getTemplateFile($templateFile=null) {
		if ($templateFile !== null) {
			$file = pathinfo($template);
		}else{
			$file = array(
				'path' => ucfirst($this->controller), 
				'basename' => $this->action
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
				throw new Exception('The requested view '.$templateFile.' is of the wrong file type ('.
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
		
		$templateFile = rtrim($path,"\\,/");

		if (!empty($file['path'])) {
			$templateFile .= '/'.ltrim($file['path'],"\\,/");
		}
	
		$templateFile .= '/'.$file['basename'];
		$templateFile .= '.'.$file['extension'];

		if (!@file_exists($templateFile)) {
			throw new Exception('Could not retrieve template file: "'.$templateFile.'" (does not exist)');
		}
		
		return $templateFile;
	}
	
	private function isTemplate($ext) {
		$extensions = explode(',', Tx_FormhandlerGui_Configuration::TEMPLATE_EXTENSIONS);
		return in_array($ext,$extensions);
	}
	
	private function isViewScript($ext) {
		$extensions = explode(',', Tx_FormhandlerGui_Configuration::VIEWSCRIPT_EXTENSIONS);
		return in_array($ext,$extensions);
	}
	
	public function setController($controller) {
		$this->controller = $controller;
	}
	
	public function setAction($action) {
		$this->action = $action;
	}
}