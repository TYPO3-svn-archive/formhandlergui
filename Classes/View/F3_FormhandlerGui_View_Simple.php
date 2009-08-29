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
 * @author	Christian Opitz <co@netzelf.de>
 * @package	TYPO3
 * @subpackage	F3_FormhandlerGui
 */
class F3_FormhandlerGui_View_Simple {
	
	/**
	 * The assigned values
	 * 
	 * @var array
	 */
	private $vars = array();
	
	private $langFile;
	
	private $langFilePath;
	
	private $viewScriptPath;
	
	private $defaultExtension = 'phtml';
	
	public function __construct(F3_GimmeFive_Component_Manager $componentManager, F3_FormhandlerGui_Configuration $configuration) {
		$this->componentManager = $componentManager;
		$this->configuration = $configuration;
		$this->viewScriptPath = t3lib_extMgm::extPath($this->configuration->getPackageKeyLowercase()) . F3_GimmeFive_Component_Manager::DIRECTORY_TEMPLATES;
	}
	
	public function assign($varName, $value) {
		$varName = str_replace(array('$',' ','/','\\'),'',$varName);
		$name = strval(trim($varName));
		if (strlen($name) > 0) {
			$this->vars[$name] = $value;
		} else {
			throw new Exception('Name for the assigned variable "'.$name.'" is of the wrong type or contains restricted chars.');
		}
	}
	
	public function render($template) {
		$file = pathinfo($template);
		if (empty($file['extension'])) {
			$file['extension'] = $this->defaultExtension;
		}
		
		$templateFile = rtrim($this->viewScriptPath,"\\,/");
		
		if (!empty($file['path'])) {
			$templateFile .= '/'.ltrim($file['path'],"\\,/");
		}
		
		$templateFile .= '/'.$file['basename'];
		$templateFile .= '.'.$file['extension'];
		
		if (!@file_exists($templateFile)) {
			throw new Exception('Could not retrieve template file: "'.$templateFile.'" (does not exist)');
			return;
		}
		
		if (in_array($file['extension'],array('html','htm','tmpl'))) {
			return $this->renderMarkers($templateFile);
		} else {
			return $this->renderPHP($templateFile);
		}
	}
	
	private function renderMarkers($templateFile) {
		//TODO: Make a function that renders the TYPO way
	}
	
	private function renderPHP($templateFile) {
		extract($this->vars);
		ob_start();
		@include_once($templateFile);
		$templateContent = ob_get_contents();
		ob_end_clean();
		return $templateContent;
	}
	
	/**
	 * Sets the view script path
	 * 
	 * @param $path string Path or Directory (if $cd is true)
	 * @param $cd boolean Change Directory
	 * @return unknown_type
	 */
	public function setViewScriptPath($path,$cd = false) {
		if ($cd) {
			$this->viewScriptPath = rtrim($this->viewScriptPath,"\\,/").'/'.ltrim($path,"\\,/");
		} else {
			$this->viewScriptPath = $path;
		}
	}
	
	/**
	 * Sets the internal attribute "langFile"
	 *
	 * @author Christian Opitz <co@netzelf.de>
	 * @param string $langFile
	 * @return void
	 */
	public function setLangFile($langFile) {
		global $LANG;
		$this->langFile = $langFile;
		$LANG->includeLLFile($this->langFilePath.$langFile);
	}

	/**
	 * Sets the internal attribute "langFilePath"
	 *
	 * @author Christian Opitz <co@netzelf.de>
	 * @param string $langFilePath
	 * @return void
	 */
	public function setLangFilePath($langFilePath) {
		$this->langFilePath = $langFilePath;
	}
	
	/**
	 * Translates a string with the given ID
	 * 
	 * @param string $msgid
	 * @return string The translated string
	 */
	public function getLL($msgid) {
		global $LANG;
		return $LANG->getLL($msgid);
	}
}