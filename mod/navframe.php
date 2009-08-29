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
 * Creates and prints the navframe page
 *
 * $Id$
 *
 * @author	Christian Opitz <co@netzelf.de>
 */

unset($MCONF);
require_once('conf.php');
require_once($BACK_PATH . 'init.php');
require_once($BACK_PATH . 'template.php');
require_once(PATH_t3lib . 'class.t3lib_scbase.php');

$BE_USER->modAccess($MCONF,1);

$LANG->includeLLFile('EXT:formhandlergui/Resources/Language/locallang.xml');

require_once('../Resources/Classes/class.tx_formhandlergui_formtree.php');

/**
 * Creates and prints the navframe page
 * 
 * @author Christian Opitz <co@netzelf.de
 */
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
		$this->treeObj = t3lib_div::makeInstance('tx_formhandlergui_formtree');
		$this->treeObj->init();
	}
	
	function initPage() {
		global $BACK_PATH, $BE_USER;
		
		// Setting highlight mode:
		$this->doHighlight = !$BE_USER->getTSConfigVal('options.pageTree.disableTitleHighlight');

			// If highlighting is active, define the CSS class for the active item depending on the workspace
		if ($this->doHighlight) {
			$hlClass = ($BE_USER->workspace === 0 ? 'active' : 'active active-ws wsver'.$BE_USER->workspace);
		}
		
		$this->doc = t3lib_div::makeInstance('template');
		
		$this->doc->backPath = $BACK_PATH;
		
		$this->doc->getContextMenuCode();
		$this->doc->loadJavascriptLib('contrib/scriptaculous/scriptaculous.js?load=effects');
		
		$this->doc->setModuleTemplate('templates/alt_db_navframe.html');
		$this->doc->docType  = 'xhtml_trans';

			// get HTML-Template


			// Adding javascript code for AJAX (prototype), drag&drop and the pagetree as well as the click menu code
		$this->doc->getDragDropCode('pages');
		$this->doc->getContextMenuCode();
		$this->doc->loadJavascriptLib('contrib/scriptaculous/scriptaculous.js?load=effects');

		$this->doc->JScode .= $this->doc->wrapScriptTags(
		($this->currentSubScript?'top.currentSubScript=unescape("'.rawurlencode($this->currentSubScript).'");':'').'
		// setting prefs for pagetree and drag & drop
		'.($this->doHighlight ? 'Tree.highlightClass = "'.$hlClass.'";' : '').'

		// Function, loading the list frame from navigation tree:
		function jumpTo(id, linkObj, highlightID, bank)	{ //
			
			parent.list_frame.location.href=\''.$BACK_PATH.'alt_doc.php?returnUrl='.$returnUrl.'&edit[tx_formhandlergui_forms][\'+id+\']=edit\';

			'.($this->doHighlight ? 'Tree.highlightActiveItem("typo3-tree", highlightID + "_" + bank);' : '').'
			'.(!$GLOBALS['CLIENT']['FORMSTYLE'] ? '' : 'if (linkObj) linkObj.blur(); ').'
			return false;
		}
		'.($this->cMR?"jumpTo(top.fsMod.recentIds['web'],'');":'').

			($this->hasFilterBox ? 'var TYPO3PageTreeFilter = new PageTreeFilter();' : '') . '

		');
	}
	
	function main() {
		
		
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
	$SOBE->initPage();
	$SOBE->main();
	$SOBE->printContent();
}
?>