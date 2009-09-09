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
 * The configuration of the extension MyPackage
 *
 * @author	Jochen Rau <jochen.rau@typoplanet.de>
 * @package	TYPO3
 * @subpackage	Tx_MyPackage
 */
class Tx_FormhandlerGui_Configuration implements ArrayAccess {	
	const PACKAGE_KEY = 'FormhandlerGui';
	
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
	
	public function getPackageKey() {
		return self::PACKAGE_KEY;
	}

	public function getPackageKeyLowercase() {
		return strtolower(self::PACKAGE_KEY);
	}
	
	public function getPrefixedPackageKey() {
		return Tx_GimmeFive_Component_Manager::PACKAGE_PREFIX . '_' . self::PACKAGE_KEY;
	}
	
	public function getPrefixedPackageKeyLowercase() {
		return strtolower(Tx_GimmeFive_Component_Manager::PACKAGE_PREFIX . '_' . self::PACKAGE_KEY);
	}
}
?>