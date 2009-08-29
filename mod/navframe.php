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
require_once(PATH_t3lib . 'class.t3lib_scbase.php');

$BE_USER->modAccess($MCONF,1);

$LANG->includeLLFile('EXT:formhandlergui/Resources/Language/locallang.xml');
/**
 * Generates the tree
 *
 * @author Christian Opitz <co@netzelf.de>
 */
class tx_formhandlergui_treeview extends t3lib_treeview {

	var $fieldArray = array('uid','pid','title','multiple','multiple_forms');
	var $setRecs = 0;

	public function init() {
		global $BACK_PATH;

		$this->backPath = $BACK_PATH;
		
		$this->BE_USER = $GLOBALS['BE_USER'];	// Setting BE_USER by default
		$this->titleAttrib = 'title';	// Setting title attribute to use.
		$this->title = 'Alle Formulare';
		$this->treeName='forms_tree';
		$this->table = 'tx_formhandlergui_forms';
		$this->parentField = 'multiple_forms';
		$this->orderByFields = 'multiple, title';
		$this->expandFirst = true;
		$this->expandAll = 1;
		$this->MOUNTS = array(
			'formhandlerforms' => '0'
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
		
		if ($row['multiple']) {
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
				t3lib_BEfunc::versioningPlaceholderClause($this->table).
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
				"multiple_forms <> '' AND deleted = 0 AND uid=".$GLOBALS['TYPO3_DB']->fullQuoteStr($parentId, $this->table)
			);
			
			if ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
				$multiple = $row['multiple_forms'];
				
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

class tx_formhandlergui_navframe extends t3lib_SCbase {
	
	/**
	 * @var tx_formhandlergui_treeview
	 */
	private $treeObj = '';
	
	/**
	 * @var template
	 */
	public $doc = '';
	
	function __construct() {
		$this->treeObj = t3lib_div::makeInstance('tx_formhandlergui_treeview');
		$this->treeObj->init();
	}
	
	function main() {
		global $BACK_PATH;
		
		$this->doc = t3lib_div::makeInstance('template');
		
		$this->doc->backPath = $BACK_PATH;
		
		$this->doc->getContextMenuCode();
		$this->doc->loadJavascriptLib('contrib/scriptaculous/scriptaculous.js?load=effects');
		
		$this->doc->setModuleTemplate('templates/alt_db_navframe.html');
		$this->doc->docType  = 'xhtml_trans';
		
		$tree = $this->treeObj->getBrowsableTree();
		$this->content .= '<div id="PageTreeDiv">'.$tree.'</div>';
		
		$docHeaderButtons = $this->getButtons();
		$markers = array(
			'IMG_RESET'     => '<img'.t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'], 'gfx/close_gray.gif', ' width="16" height="16"').' id="treeFilterReset" alt="Reset Filter" />',
			'WORKSPACEINFO' => '',
			'CONTENT'       => $this->content
		);
		$subparts = array();
		
		$this->content = $this->doc->startPage('TYPO3 Page Tree');
		$this->content.= $this->doc->moduleBody($this->pageinfo, $docHeaderButtons, $markers, $subparts);
		$this->content.= $this->doc->endPage();

		$this->content = $this->doc->insertStylesAndJS($this->content);
		
	}
	
	function printContent() {
		echo $this->content;
	}
	
/**
	 * Create the panel of buttons for submitting the form or otherwise perform operations.
	 *
	 * @return	array	all available buttons as an assoc. array
	 */
	protected function getButtons()	{
		global $LANG;

		$buttons = array(
			'csh' => '',
			'new_page' => '',
			'refresh' => '',
		);

			// New Page
		$onclickNewPageWizard = 'top.content.list_frame.location.href=top.TS.PATH_typo3+\'db_new.php?pagesOnly=1&id=\'+Tree.pageID;"';
		$buttons['new_page'] = '<a href="#" onclick="' . $onclickNewPageWizard . '"><img' . t3lib_iconWorks::skinImg('', 'gfx/new_page.gif') . ' title="' . $LANG->sL('LLL:EXT:cms/layout/locallang.xml:newPage', 1) . '" alt="" /></a>';

			// Refresh
		$buttons['refresh'] = '<a href="' . htmlspecialchars(t3lib_div::getIndpEnv('REQUEST_URI')) . '"><img' . t3lib_iconWorks::skinImg('', 'gfx/refresh_n.gif') . ' title="' . $LANG->sL('LLL:EXT:lang/locallang_core.php:labels.refresh', 1) . '" alt="" /></a>';

			// CSH
		$buttons['csh'] = str_replace('typo3-csh-inline','typo3-csh-inline show-right',t3lib_BEfunc::cshItem('xMOD_csh_corebe', 'pagetree', $GLOBALS['BACK_PATH'], '', TRUE));

		return $buttons;
	}
}

// Make instance if it is not an AJAX call
if (!(TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_AJAX)) {
	$SOBE = t3lib_div::makeInstance('tx_formhandlergui_navframe');
	$SOBE->init();
	$SOBE->main();
	$SOBE->printContent();
}
?>