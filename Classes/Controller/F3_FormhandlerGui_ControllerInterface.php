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
 * $Id: Tx_Formhandler_ControllerInterface.php 22614 2009-07-21 20:43:47Z fabien_u $
 *                                                                        */

/**
 * Controller interface for Controller Classes of Formhandler
 *
 * @author	Reinhard Führicht <rf@typoheads.at>
 * @package	F3_FormhandlerGui
 * @subpackage	Controller
 */
interface F3_FormhandlerGui_ControllerInterface {

	/**
	 * Sets the content object
	 *
	 * @return void
	 */
	public function setContent($content);

	/**
	 * Returns the content object
	 *
	 * @return void
	 */
	public function getContent();

	/**
	 * Process all
	 *
	 * @return void
	 */
	public function process();
}
?>
