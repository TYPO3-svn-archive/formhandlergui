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
 *                                                                        */

require_once(PATH_t3lib.'class.t3lib_tceforms.php');

/**
 * Controller for Backend Module of Formhandler
 *
 * @author	Reinhard Führicht <rf@typoheads.at>
 * @package	Tx_Formhandler
 * @subpackage	Controller
 */
class Tx_FormhandlerGui_Controller_Forms extends Tx_FormhandlerGui_AbstractController {

	/**
	 * init method to load translation data
	 *
	 * @return void
	 */
	protected function init() {
		$this->setLangFile('locallang_mod.xml');
	}
	
	/**
	 * Main method of the controller.
	 *
	 * @return mixed rendered view or array with tabs
	 */
	public function indexAction() {
		$this->view->assign('test','Hallo');
	}
	
	protected function tabGeneral() {
		$this->view->assign('test','Huhu');
		return $this->view->render('general');
	}
	
	protected function tabMail() {
		return 'Mail';
	}
	
	protected function tabDatabase() {
		return 'DB';
	}

	/**
	 * Adds HTML code to include the CSS file to given HTML content.
	 *
	 * @param string The HTML content
	 * @return string The changed HML content
	 * @author Reinhard Führicht <rf@typoheads.at>
	 */
	protected function addCSS($content) {
		$cssLink = '
			<link 	rel="stylesheet" 
					type="text/css" 
					href="../../../Resources/CSS/backend/styles.css" 
			/>
		';
		return $cssLink. $content;
	}

}
?>
