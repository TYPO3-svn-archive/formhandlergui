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
 * The configuration of the extension FormhandlerGui
 *
 * @package	TYPO3
 * @subpackage	Tx_MyPackage
 * @version $Id$
 * @author	Jochen Rau <jochen.rau@typoplanet.de>
 * @author Christian Opitz <co@netzelf.de>
 */
class Tx_FormhandlerGui_Configuration implements ArrayAccess {

	/**
	 * Must be lowercase the same as the extension key
	 * @var string
	 */
	const PACKAGE_KEY = 'FormhandlerGui';
	
	/**
	 * ViewScript directory
	 * @var string
	 */
	const DIRECTORY_VIEWSCRIPTS = 'Resources/ViewScripts/';
	
	/**
	 * Template directory
	 * @var string
	 */
	const DIRECTORY_TEMPLATES = 'Resources/Template/';
	
	/**
	 * The default rendering method - can be VIEWSCRIPT or TEMPLATE
	 * Can be overruled by passing a file extension to the view 
	 * render method
	 * @see Tx_FormhandlerGui_View::render
	 * @var string
	 */
	const DEFAULT_RENDERMETHOD = 'VIEWSCRIPT';
	
	/**
	 * The file extensions that can be used as templates. If you pass
	 * a file with one of these extensions the view will render the
	 * template file from the template directory
	 * @var string
	 */
	const TEMPLATE_EXTENSIONS = 'html,htm,tmpl';
	
	/**
	 * The file extensions that can be used as viewScripts. If you pass
	 * a file with one of these extensions the view will render the
	 * viewScript file from the viewScript directory
	 * @var string
	 */
	const VIEWSCRIPT_EXTENSIONS = 'php,phtml';
	
	/**
	 * This is used to get the right file for the default rendering method
	 * @var string
	 */
	const DEFAULT_TEMPLATE_EXT = 'html';
	
	/**
	 * This is used to get the right file for the default rendering method
	 * @var string
	 */
	const DEFAULT_VIEWSCRIPT_EXT = 'phtml';

	protected $setup;

	public function __construct() {
		$this->setup = $GLOBALS['TSFE']->tmpl->setup['plugin.'][$this->getPrefixedPackageKey() . '.'];
	}

	public function merge($setup) {
		if (is_array($setup)) {
			$settings = $this->setup['settings.'];
			$settings = t3lib_div::array_merge_recursive_overrule($settings, $setup);
			$this->setup['settings.'] = $settings;
		}
	}

	public function offsetGet($offset) {
		return $this->setup['settings.'][$offset];
	}

	public function offsetSet($offset, $value) {
		$this->setup['settings.'][$offset] = $value;
	}

	public function offsetExists($offset) {
		if (isset($this->setup['settings.'][$offset])) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function offsetUnset($offset) {
		$this->setup['settings.'][$offset] = NULL;
	}

	public function getSettings() {
		return $this->setup['settings.'];
	}

	public function getSourcesConfiguration() {
		return $this->setup['sources.'];
	}

	public static function getPackageKey() {
		return self::PACKAGE_KEY;
	}

	public static function getPackageKeyLowercase() {
		return strtolower(self::PACKAGE_KEY);
	}

	public static function getPrefixedPackageKey() {
		return Tx_GimmeFive_Component_Manager::PACKAGE_PREFIX . '_' . self::PACKAGE_KEY;
	}

	public static function getPrefixedPackageKeyLowercase() {
		return strtolower(Tx_GimmeFive_Component_Manager::PACKAGE_PREFIX . '_' . self::PACKAGE_KEY);
	}

	public static function getPackagePath() {
		return t3lib_extMgm::extPath(strtolower(self::PACKAGE_KEY));
	}

	public static function getViewScriptPath() {
		return self::getPackagePath().self::DIRECTORY_VIEWSCRIPTS;
	}

	public static function getTemplatePath() {
		return self::getPackagePath().Tx_GimmeFive_Component_Manager::DIRECTORY_TEMPLATES;
	}

	public static function getDefaultExtension() {
		return (self::DEFAULT_RENDERMETHOD == 'VIEWSCRIPT') ? self::DEFAULT_VIEWSCRIPT_EXT : self::DEFAULT_TEMPLATE_EXT;
	}
	
	public static function getControllerClassName($controller) {
		$controllerClassName = self::getPrefixedPackageKey();
		$controllerClassName .= '_Controller_'.ucfirst($controller);
		return $controllerClassName;
	}
}
?>