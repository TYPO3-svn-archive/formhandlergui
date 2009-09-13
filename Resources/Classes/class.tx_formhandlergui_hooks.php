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
 * Some hooks that formhandlergui needs.
 *
 * $Id$
 *
 * @author	Christian Opitz <co@netzelf.de>
 */

/**
 * Contains some hook functions
 * 
 * @author Christian Opitz <co@netzelf.de>
 */
class tx_formhandlergui_hooks {
	
	/**
	 * Adds the predefined fields of formhandlergui to the selection
	 * in formhandler plugin.
	 * 
	 * @param $dataStructArray
	 * @param $conf
	 * @param $row
	 * @param $table
	 * @param $fieldName
	 * @return void
	 */
	public function getFlexFormDS_postProcessDS(&$dataStructArray, &$conf, &$row, &$table, &$fieldName) {
		
		//$func = $dataStructArray['sheets']['sDEF']['ROOT']['el']['predefined']['TCEforms']['config']['itemsProcFunc'];
		$struct = array('sheets','sDEF','ROOT','el','predefined','TCEforms','config');
		
		$array = $dataStructArray;
		
		foreach ($struct as $part) {
			if (is_array($array[$part])) {
				$array = $array[$part];
			}else{
				return;
			}
		}
		
		$func = $array['itemsProcFunc'];
		
		if ( $func == 'tx_dynaflex_formhandler->addFields_predefined') {
			
			include_once(t3lib_extMgm::extPath('formhandlergui') . '/Resources/Classes/class.tx_dynaflex_formhandlergui.php');
			
			$dataStructArray
			['sheets']
			['sDEF']
			['ROOT']
			['el']
			['predefined']
			['TCEforms']
			['config']
			['itemsProcFunc'] = 'tx_dynaflex_formhandlergui->addFields_predefined';
		}
	}
}