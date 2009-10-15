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
class Tx_FormhandlerGui_Select extends Tx_FormhandlerGui_ActionController {
	
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
		
		if ($fieldConf->source == 'lang') {
			$options = explode("\n",$langConf->options);
			$values = explode("\n",$langConf->values);
			$optionTags = array();
			foreach($options as $i => $option) {
				$optionTags[] = '<option value="'.$values[$i].'">'.$option.'</option>';
			}
			$this->view->options = implode("\n",$optionTags);
		}
		$this->view->value = $value;
		
		$this->view->params = '';
		if (!empty($fieldConf->cssClass)) {
			$this->view->params = ' class="'.$fieldConf->cssClass.'"';
		}
	}
}
?>