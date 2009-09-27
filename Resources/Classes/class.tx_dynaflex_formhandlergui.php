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
 * Overwrites the dynaflex functions for formhandler plugin.
 *
 * $Id$
 *
 * @author	Christian Opitz <co@netzelf.de>
 */

/**
 * Brings predef forms from formhandlergui to formhandler plugin
 * 
 * @author Christian Opitz <co@netzelf.de>
 *
 */
class tx_dynaflex_formhandlergui extends tx_dynaflex_formhandler 
{
	/* (non-PHPdoc)
	 * @see typo3conf/ext/formhandler/Resources/PHP/tx_dynaflex_formhandler#addFields_predefined($config)
	 */
	public function addFields_predefined($config) {
		parent::addFields_predefined($config);
	}
	
	/** 
	 * Push our own predefined forms to TS-Setup so that they are visible in formhandler flexform
	 * 
	 * @see typo3conf/ext/formhandler/Resources/PHP/tx_dynaflex_formhandler#loadTS($pageUid)
	 */
	public function loadTS($pageUid) {
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'uid, title, type',
			'tx_formhandlergui_forms',
			'deleted = 0 AND hidden = 0',
			'',
			'title'
		);
		
		$ts = parent::loadTS($pageUid);
		$ts['plugin.']['Tx_Formhandler.']['settings.']['predef.'] = $ts['plugin.']['tx_formhandler.']['settings.']['predef.'];
		
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$id = 'Tx_FormhandlerGui_'.$row['uid'].'.';
			$name = 'FGui:'.$row['title'];
			if (intval($row['type']) == 1) {
				$name .= ' (MultiStep)';
			}
			
			$ts['plugin.']['Tx_Formhandler.']['settings.']['predef.'][$id]['name'] = $name;
		}
		
		return $ts;
	}
}