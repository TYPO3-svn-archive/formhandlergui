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
 * Contains the setup for a predefined form for formhandler
 *
 * @package TYPO3
 * @subpackage FormhandlerGui
 * @version $Id$
 */
class Tx_FormhandlerGui_SetupRepository {
	
	private $setup = array();
	
	public function addFinisher($class, $conf) {
		$this->setup['finishers.'][] = array(
			'class' => $class,
			'config.'=> $conf
		);
	}
	
	public function addValue($path, $value, $delimiter = "/") {
		$path = trim($path,$delimiter);
		$pathArray = explode($delimiter, $path);
		$path = implode("'.'.']['", $pathArray);
		
		$dot = (is_array($value)) ? '.' : '';
		$eval = '$confArray[\''.$path.$dot.'\'] = $value;';
		$confArray = array();
		eval($eval);
		
		$this->setup = t3lib_div::array_merge_recursive_overrule($confArray, $this->setup);
	}
	
	public function getSetup() {
		return $this->setup;
	}
}
?>