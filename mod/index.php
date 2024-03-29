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
 * Renders the module tx_formhandlergui.
 *
 * $Id$
 *
 * @author	Christian Opitz <co@netzelf.de>
 */

// DEFAULT initialization of a module [BEGIN]
unset($MCONF);
require_once('conf.php');
require_once($BACK_PATH . 'init.php');
require_once($BACK_PATH . 'template.php');
require_once(PATH_t3lib . 'class.t3lib_scbase.php');

$LANG->includeLLFile('EXT:formhandlergui/Resources/Language/locallang.xml');

// This checks permissions and exits if the users has no permission for entry:
$BE_USER->modAccess($MCONF,1);
// DEFAULT initialization of a module [END]

require_once (t3lib_extMgm::extPath('formhandlergui') . 'Classes/Component/Tx_FormhandlerGui_Dispatcher.php');

/**
 * Module 'Formhandler' for the 'formhandlergui' extension.
 *
 * @package	TYPO3
 * @subpackage	tx_formhandlergui
 * @author	Christian Opitz <co@netzelf.de>
 */
class  tx_formhandlergui_module1 extends t3lib_SCbase {

	/**
	 * @var template
	 */
	public  $doc;

	var $pageinfo;
	
	function init() {
		global $MCONF;
		$MCONF['extConf'] = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['formhandlergui']);
		parent::init();
	}

	/**
	 * Adds items to the ->MOD_MENU array. Used for the function menu selector.
	 *
	 * @return	void
	 */
	function menuConfig()	{
		global $LANG, $MCONF;
		$this->MOD_MENU = Array ('function' => Array ());
		
		foreach ($MCONF['menuItems'] as $action => $name) {
			$this->MOD_MENU['function'][$action] = $LANG->getLL($name);
		}
		
		parent::menuConfig();
	}

	/**
	 * Main function of the module. Write the content to $this->content
	 * If you chose "web" as main module, you will need to consider the $this->id parameter which will contain the uid-number of the page clicked in the page tree
	 *
	 * @return	void
	 */
	function main()	{
		global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

		// Access check!
		// The page will show only if there is a valid page and if this page may be viewed by the user
		$this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
		$access = is_array($this->pageinfo) ? 1 : 0;

		// initialize doc
		$this->doc = t3lib_div::makeInstance('template');
		$this->doc->setModuleTemplate(t3lib_extMgm::extPath('formhandlergui') . 'Resources/Templates/Module/mod_template.html');
		$this->doc->backPath = $BACK_PATH;
		$docHeaderButtons = $this->getButtons();

		if (($this->id && $access) || ($BE_USER->user['admin'] && !$this->id))	{

			// Draw the form
			$this->doc->form = '<form action="" method="post" name="editform" enctype="multipart/form-data">';

			// JavaScript
			$this->doc->JScode = '
				<script language="javascript" type="text/javascript">
					script_ended = 0;
					function jumpToUrl(URL)	{
						document.location = URL;
					}
				</script>
			';
			$this->doc->postCode='
				<script language="javascript" type="text/javascript">
					script_ended = 1;
					if (top.fsMod) top.fsMod.recentIds["web"] = 0;
				</script>
			';
			// Render content:
			//$this->moduleContent();
		} else {
			// If no access or if ID == zero
			$docHeaderButtons['save'] = '';
			$this->content.=$this->doc->spacer(10);
		}

		$this->content.=$this->doc->header($LANG->getLL('title'));
		$this->content.=$this->doc->spacer(5);

		//$this->doc->JScode .= $this->doc->getDynTabMenuJScode();

		// compile document
		$markers['FUNC_MENU'] = t3lib_BEfunc::getFuncMenu(0, 'SET[function]', $this->MOD_SETTINGS['function'], $this->MOD_MENU['function']);

		$this->moduleContent();

		$markers['CONTENT'] = $this->content;

		$this->content = $this->doc->startPage($LANG->getLL('title'));
		$this->content.= $this->doc->moduleBody($this->pageinfo, $docHeaderButtons, $markers);
		$this->content.= $this->doc->endPage();
		$this->content = $this->doc->insertStylesAndJS($this->content);

	}

	/**
	 * Prints out the module HTML
	 *
	 * @return	void
	 */
	function printContent()	{

		$this->content.=$this->doc->endPage();
		echo $this->content;
	}

	/**
	 * Generates the module content
	 *
	 * @return	void
	 */
	function moduleContent()	{

		$controller = (string) $this->MOD_SETTINGS['function'];
		$functions = array_keys($this->MOD_MENU['function']);
		if (in_array($function,$functions)) {
			$controller = $functions[0];
		}

		$dispatcher = t3lib_div::makeInstance('Tx_FormhandlerGui_Dispatcher');
		
		$content = $dispatcher->dispatch($controller);

		$this->content .= $this->doc->section('', $content, 0, 1);
	}


	/**
	 * Create the panel of buttons for submitting the form or otherwise perform operations.
	 *
	 * @return array all available buttons as an assoc. array
	 */
	protected function getButtons()	{
		global $MCONF;

		$buttons = array(
			'csh' => '',
			'shortcut' => '',
			'save' => '',
			'new' => ''
			);
			// CSH
			$buttons['csh'] = t3lib_BEfunc::cshItem('_MOD_web_func', '', $GLOBALS['BACK_PATH']);

			// SAVE button
			$buttons['save'] = '<input type="image" class="c-inputButton" name="submit" value="Update"' . t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'], 'gfx/savedok.gif', '') . ' title="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.php:rm.saveDoc', 1) . '" />';

			$pid = $MCONF['extConf']['fguiPid'];
			
			$returnUrl  = t3lib_extMgm::extRelPath('formhandlergui').'mod/index.php';
			$returnUrl  = urlencode($returnUrl);
			$createlink = $GLOBALS['BACK_PATH'].'alt_doc.php?returnUrl='.$returnUrl.'&edit[tx_formhandlergui_forms]['.$pid.']=new';

			//Wieso geht hier nicht $buttons['new']???
			$buttons['save'] .= '<a href="'.$createlink.'"><img'.t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'], 'gfx/new_el.gif', '').' alt="Create" /></a>';


			// Shortcut
			if ($GLOBALS['BE_USER']->mayMakeShortcut())	{
				$buttons['shortcut'] = $this->doc->makeShortcutIcon('', 'function', $this->MCONF['name']);
			}

			return $buttons;
	}

}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/formhandlergui/mod1/index.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/formhandlergui/mod1/index.php']);
}




// Make instance:
$SOBE = t3lib_div::makeInstance('tx_formhandlergui_module1');
$SOBE->init();

// Include files?
foreach($SOBE->include_once as $INC_FILE)	include_once($INC_FILE);

$SOBE->main();
$SOBE->printContent();

?>