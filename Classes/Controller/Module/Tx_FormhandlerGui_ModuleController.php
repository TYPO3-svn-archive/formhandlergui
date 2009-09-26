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
 * The controller for the backend module stuff
 *
 * @package	TYPO3
 * @subpackage	Tx_FormhandlerGui
 * @version $Id$
 */
class Tx_FormhandlerGui_ModuleController extends Tx_FormhandlerGui_ActionController {

	/**
	 * init method of the controller
	 *
	 * @return void
	 * @author Christian Opitz <co@netzelf.de>
	 */
	public function init() {
		//$this->view->setNoRender(true);
		$this->config->view->setRenderMethod('VIEWSCRIPT');
	}
	
	/**
	 * Main method of the controller.
	 *
	 * @return void
	 * @author Christian Opitz <co@netzelf.de>
	 */
	public function indexAction() {
		$this->view->test = 'Huhu';
		//$this->view->assign('test','Hallo');
	}
}
?>
