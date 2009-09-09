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
 * A default view
 *
 * @author	Jochen Rau <j.rau@web.de>
 * @package	TYPO3
 * @subpackage	Tx_MyPackage
 */
class Tx_FormhandlerGui_View_Default extends Tx_FormhandlerGui_AbstractView {

	public function render() {
		$this->fillMarker(array('FORM_NAME'=>$this->formName), $markerArray, $wrappedSubpartArray);
		$subpartArray['###ITEM###'] .= $this->cObj->substituteMarkerArray($this->subparts['item'],$markerArray,$subpartArray,$wrappedSubpartArray);
		$content = $this->cObj->substituteMarkerArray($this->subparts['template'],$markerArray,$subpartArray,$wrappedSubpartArray);
		$content = $this->removeUnfilledMarker($content);
		return $this->pi_wrapInBaseClass($content);
	}
}
?>