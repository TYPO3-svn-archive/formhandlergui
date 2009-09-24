<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 Christian Opitz <christian.opitz@netzelf.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * Generates the custom fields for form records
 *
 * $Id$
 *
 * @author	Christian Opitz <co@netzelf.de>
 */

/**
 * Userfuncs for fields in TCA
 *
 * @author Christian Opitz <co@netzelf.de>
 *
 */
class tx_formhandlergui_tca {
	public function rows($PA,$fobj) {
		return 'Reihen';
	}
	public function cols($PA,$fobj) {
		return 'Spalten';
	}
	
	public function tableSelect($config) {
		$tables = $GLOBALS['TYPO3_DB']->admin_get_tables();
		$tables = array_keys($tables);
		
		foreach ($tables as $table) {
			$config['items'][] = array($table, $table);
		}
		
		return $config;
	}
	
	public function fieldTypeSelect($config) {
		
		$types = $this->getFieldTypes();
		
		/*if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['formhandlergui']['fields'])) {
			foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['formhandlergui']['fields'] as $fieldClass) {
				$_procObj =& t3lib_div::getUserObj($fieldClass);
				$fields[]['title'] = $_procObj->getFieldName();
			}
		}*/
		
		foreach ($types as $type => $conf) {
			$config['items'][] = array(
				$GLOBALS['LANG']->sL($conf['title']),
				$type
			);
		}
		return $config;
	}
	
	/**
	 * Manipulates the TCA
	 * 
	 * @param $types
	 * @return unknown_type
	 */
	public static function addFieldTypes2TCA(&$TCA) {
		$types = self::getFieldTypes();
		
		foreach ($types as $id => $conf) {
			$TCA['types'][$id] = $TCA['types']['0'];
			if ($conf['fieldConf'] !== false) {
				$TCA['types'][$id]['showitem'] .= $TCA['types']['0-fieldConf']['showitem'];
				
				$TCA['columns']['field_conf']['config']['ds'][$id] = 'FILE:'.$conf['fieldConf'];
			}
			if ($conf['langConf'] !== false) {
				$TCA['types'][$id]['showitem'] .= $TCA['types']['0-langConf']['showitem'];
				
				$TCA['columns']['lang_conf']['config']['ds'][$id] = 'FILE:'.$conf['langConf'];
			}
			$TCA['types'][$id]['showitem'] .= $TCA['types']['0-access']['showitem'];
		}
	}
	
	public static function getFieldTypesLangDef() {
		$types = self::getFieldTypes();
		
		
	}
	
	private static function getFieldTypes() {
		if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['formhandlergui']['fieldTypes'])) {
			$types = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['formhandlergui']['fieldTypes'];
		}else{
			$types = array();
		}
		return $types;
	}
}
?>