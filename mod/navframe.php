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
 * Creates the form tree.
 *
 * $Id$
 *
 * @author	Christian Opitz <co@netzelf.de>
 */

unset($MCONF);
require_once('conf.php');
require_once($BACK_PATH . 'init.php');
require_once($BACK_PATH . 'template.php');
require_once(PATH_t3lib.'class.t3lib_treeview.php');

$BE_USER->modAccess($MCONF,1);

$LANG->includeLLFile('EXT:formhandlergui/Resources/Language/locallang.xml');

/**
 * Generates the tree
 *
 * @author Christian Opitz <co@netzelf.de>
 */
class tx_formhandlergui_navframe extends t3lib_treeview {

	var $fieldArray = array('uid', 'formname');
	var $defaultList = 'uid,pid,tstamp,sorting,deleted,perms_userid,perms_groupid,perms_user,perms_group,perms_everybody,crdate,cruser_id';
	var $setRecs = 0;

	public function __construct() {
		global $BACK_PATH;

		$this->backPath = $BACK_PATH;

		$this->treeName='forms';
		$this->orderByFields = 'title';

		$this->MOUNTS = array(
			'formhandlerforms' => array(
				'name' => 'All Forms'
				)
				);
	}

	/**
	 * Returns true/false if the next level for $id should be expanded - and all levels should, so we always return 1.
	 *
	 * @param	integer		ID (uid) to test for (see extending classes where this is checked againts session data)
	 * @return	boolean
	 */
	function expandNext($id)	{
		return 1;
	}


	/**
	 * Get stored tree structure AND updating it if needed according to incoming PM GET var.
	 * - Here we just set it to nothing since we want to just render the tree, nothing more.
	 *
	 * @return	void
	 * @access private
	 */
	function initializePositionSaving()	{
		$this->stored=array();
	}

	function getForms() {
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'uid,pid,title,multiple,multiple_forms',
			'tx_formhandlergui_forms',
			'deleted <> 0',
			'title'
			);

			$multiple = array();
			$forms = array();

			while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
				if ($row['multiple']) {
					$multiple[] = $row['uid'];
				}
				$forms[] = $row;
			}
			foreach ($forms as $form) {
					
			}
	}
}
?>