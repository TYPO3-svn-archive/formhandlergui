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
 * Loads setup for forms and passes it to formhandler.
 *
 * $Id$
 *
 * @author	Christian Opitz <co@netzelf.de>
 */

require_once(PATH_tslib.'class.tslib_pibase.php');
require_once (t3lib_extMgm::extPath('formhandler') . 'Classes/Controller/Tx_Formhandler_Dispatcher.php');

/**
 * This is a clone of class.tx_formhandler.php - we smuggled it in with
 *
 * t3lib_extMgm::addTypoScriptSetup('plugin.tx_formhandler.includeLibs =
 * typo3conf/ext/formhandlergui/pi/class.tx_formhandler.php');
 *
 * in ext_tables.php. So we can overwrite all settings for formhandler.
 *
 * @package TYPO3
 * @subpackage tx_formhandlergui
 * @see typo3conf/ext/formhandler/pi/class.tx_formhandler.php#main()
 * @see typo3conf/ext/formhandlergui/ext_tables.php#30
 */
class tx_formhandler extends Tx_Formhandler_Dispatcher {

	/**
	 * Same as class name
	 * @var string
	 */
	public $prefixId      = 'tx_formhandler';

	/**
	 * Path to this script relative to the extension dir.
	 * @var string
	 */
	public $scriptRelPath = 'pi/class.tx_formhandler.php';

	/**
	 * The extension key
	 * @var string
	 */
	public $extKey = 'formhandler';

	public $pi_checkCHash = true;

	public $conf;

	/**
	 * preloads our setup and calls Tx_Formhandler_Dispatcher::main
	 *
	 * @author Christian Opitz <co@netzelf.de>
	 * @see typo3conf/ext/formhandler/Classes/Controller/Tx_Formhandler_Dispatcher#main()
	 */
	public function main($content, $setup) {

		$setup['settings.']['predef.']['default.']['formValuesPrefix'] = 'formhandlergui';
		var_dump($setup);

		$GLOBALS['TSFE']->tmpl->setup['plugin.']['Tx_Formhandler.'] = $setup;

		$result = parent::main($content, $setup);

		return $result;
	}
}