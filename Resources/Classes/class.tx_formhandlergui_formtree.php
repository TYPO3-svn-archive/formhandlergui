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
 * Class for the form tree.
 *
 * $Id$
 *
 * @author	Christian Opitz <co@netzelf.de>
 */

require_once(PATH_t3lib.'class.t3lib_treeview.php');

/**
 * Generates the tree
 *
 * @author Christian Opitz <co@netzelf.de>
 */
class tx_formhandlergui_formtree extends t3lib_treeview {

	var $fieldArray = array('uid','pid','title','type','multistep_forms');
	var $setRecs = 0;

	public function init() {
		global $BACK_PATH, $LANG;

		$this->backPath = $BACK_PATH;
		
		$this->BE_USER = $GLOBALS['BE_USER'];	// Setting BE_USER by default
		$this->titleAttrib = 'title';	// Setting title attribute to use.
		$this->title = $LANG->getLL('all_forms');
		$this->treeName='forms_tree';
		$this->table = 'tx_formhandlergui_forms';
		$this->parentField = 'multistep_forms';
		$this->orderByFields = 'type, title';
		$this->expandFirst = true;
		$this->expandAll = 1;
		$this->MOUNTS = array(
			'1234' => '0'
		);
		
		$this->setTreeName();

		if($this->table) {
			t3lib_div::loadTCA($this->table);
		}
	}
	
	/**
	 * Returns the root icon for a tree/mountpoint (defaults to the globe)
	 *
	 * @param	array		Record for root.
	 * @return	string		Icon image tag.
	 */
	function getRootIcon($rec) {
		return $this->wrapIcon('<img src="'.$this->backPath.t3lib_extMgm::extRelPath('formhandlergui').'Resources/Images/icon_forms.gif" width="18" height="16"  alt="" />',$rec);
	}
	
	/**
	 * Get icon for the row.
	 * If $this->iconPath and $this->iconName is set, try to get icon based on those values.
	 *
	 * @param	array		Item row.
	 * @return	string		Image tag.
	 */
	function getIcon($row) {
		$src = $this->backPath.t3lib_extMgm::extRelPath('formhandlergui').'Resources/Images/icon_';
		
		if (intval($row['type']) == 1) {
			$src .= 'multistepform.gif';
		} elseif ($this->multiStep) {
			$src .= 'stepform.gif';
		} else {
			$src .= 'form.gif';
		}
		
		
		$icon = '<img src="'.$src.'" width="18" height="16" alt=""'.($this->showDefaultTitleAttribute ? ' title="UID: '.$row['uid'].'"':'').' />';
		
		return $this->wrapIcon($icon,$row);
	}
	
	function getDataInit($parentId,$subCSSclass='') {
		if ($parentId == 0) {
			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
				implode(',',$this->fieldArray),
				$this->table,
				'uid > 0 '.t3lib_BEfunc::deleteClause($this->table).
				//t3lib_BEfunc::versioningPlaceholderClause($this->table).
				$this->clause,	// whereClauseMightContainGroupOrderBy
				'',
				$this->orderByFields
			);
			
			$this->multiStep = false;
			
			return $res;
		}else{
			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
				$this->parentField,
				$this->table,
				"type='1' AND multistep_forms <> '' AND deleted = 0 AND uid=".$GLOBALS['TYPO3_DB']->fullQuoteStr($parentId, $this->table)
			);
			
			if ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
				$multiple = $row['multistep_forms'];
				
				$GLOBALS['TYPO3_DB']->sql_free_result($res);
				
				$this->multiStep = true;
				
				$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
					implode(',',$this->fieldArray),
					$this->table,
					'uid IN ('.trim($multiple).')'.
					t3lib_BEfunc::deleteClause($this->table).
					t3lib_BEfunc::versioningPlaceholderClause($this->table).
					$this->clause,	// whereClauseMightContainGroupOrderBy
					'',
					$this->orderByFields
				);
			}
			return $res;
		}
	}
}