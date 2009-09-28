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
 * The standard text field
 *
 * @package TYPO3
 * @subpackage FormhandlerGui
 * @version $Id$
 */
class Tx_FormhandlerGui_Text extends Tx_FormhandlerGui_ActionController {
	
	/**
	 * The standard action called by form controller
	 *
	 * @return void
	 * @author Christian Opitz <co@netzelf.de>
	 */
	public function indexAction() {
		$field = $this->params->field;
		$fieldConf = $field->getFieldConf();
		$langConf = $field->getLangConf();
		
		$this->view->name = $fieldName = $field->getFieldName();
		$this->view->size = $fieldConf->size;
		
		switch ($fieldConf->default) {
			case 'lang':
				$value = $langConf->default;
				break;
			case 'db':
				$value = $this->params->formController->getValueFromDb($fieldName);
				break;
			default:
				$value = '###value_'.$fieldName.'###';
				break;
		}
		$this->view->value = $value;
		
		if (!empty($fieldConf->cssClass)) {
			$this->view->params = ' class="'.$fieldConf->cssClass.'"';
		}
	}
}
?>