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
 *
 * $Id$
 *                                                                        */

//require_once (t3lib_extMgm::extPath('formhandlergui') . 'Classes/Component/F3_GimmeFive_Component_Manager.php');


require_once(PATH_tslib.'class.tslib_pibase.php');

/**
 * The Dispatcher instatiates the Component Manager and delegates the process to the given controller.
 *
 * @author	Reinhard Führicht <rf@typoheads.at>
 * @package	Tx_Formhandler
 * @subpackage	Controller
 */
class tx_FormhandlerGui_Dispatcher extends tslib_pibase {

	/* Trying this:
	 	includeLibs.Tx_FormhandlerGui_default = EXT:formhandlergui/Classes/Controller/tx_FormhandlerGui_Dispatcher.php
		plugin.Tx_FormhandlerGui = USER_INT
		plugin.Tx_FormhandlerGui.userFunc = tx_FormhandlerGui_Dispatcher->main
		plugin.Tx_Formhandler.settings.predef
	 */

	/**
	 * Main method of the dispatcher. This method is called as a user function.
	 *
	 * @return string rendered view
	 * @param string $content
	 * @param array $setup The TypoScript config
	 */
	public function main($content, &$setup) {

		$this->pi_USER_INT_obj = 1;
		
		$setup['settings.']['predef.']['hallo.'] = $setup['settings.']['predef.']['default.'];
		$funcs = get_class_methods($GLOBALS['TSFE']);
		$GLOBALS['TSFE']->tmpl->setup['plugin.']['Tx_Formhandler.']['settings.']['predef.']['my.']['name']='My Predef';
		var_dump($func);
	}
}
?>