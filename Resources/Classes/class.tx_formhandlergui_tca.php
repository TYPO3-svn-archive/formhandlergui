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
	public function fields($config) {
		$fields = array();
		if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['formhandlergui']['fields'])) {
			foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['formhandlergui']['fields'] as $fieldClass) {
				$_procObj =& t3lib_div::getUserObj($fieldClass);
				$fields[]['title'] = $_procObj->getFieldName();
			}
		}
		$form = '<select size="1" name="fgui_fieldSelect" id="fgui_fieldSelect">';
		foreach ($fields as $field) {
			$form .= '<option value="'.$field['id'].'">'.$field['title'].'</option>';
		}
		$form .= '</select>';
		return $form;
	}
}
?>