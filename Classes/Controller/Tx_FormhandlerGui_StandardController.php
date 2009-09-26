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

/**
 * 
 * @package TYPO3
 * @subpackage Formhandler
 * @version $Id$
 */
class Tx_FormhandlerGui_StandardController extends Tx_FormhandlerGui_ActionController {
	
	public function init() {
		//$this->view->setNoRender(true);
	}
	
	public function indexAction() {
		$this->_forward('form');
	}
	
	public function formAction() {
		$this->view->formAction = 'hallo';
		$this->view->formFields = 'Yes';
	}
}
?>