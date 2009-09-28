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
 * @subpackage FormhandlerGui
 * @version $Id$
 */
class Tx_FormhandlerGui_StandardController extends Tx_FormhandlerGui_ActionController {
	
	private $predefSetup = array();
	
	/**
	 * @var Tx_FormhandlerGui_FormRepository
	 * @inject
	 */
	protected $formRepository;
	
	/**
	 * @var Tx_FormhandlerGui_SetupRepository
	 */
	protected $setupRepository;
	
	public function init() {
		//$this->view->setNoRender(true);
	}
	
	public function indexAction() {
		$this->_forward('form');
	}
	
	public function formAction() {
		$formId = $this->getParam('formId');
		$this->form = $form = $this->formRepository->findOneByUid($formId);
		$this->fields = $fields = $form->getFields();
		
		if ($form->autoMapping && $form->enableDb) {
			$tables = strval($form->getTables());
			if (strlen($tables) > 0) {
				$tables = explode(',', $tables);
				foreach ($tables as $table) {
					$dbConf = array(
						'table.' => $table,
						'fields.' => $this->automap($fields, $table)
					);
					$this->setupRepository->addFinisher('Tx_Formhandler_Finisher_DB', $dbConf);
				}
			}
		}
		
		$formFields = '';
		foreach ($fields as $field) {
			 $formFields .= $this->getField($field);
		}
		$this->view->formFields = $formFields;
		
		$this->view->formMethod = $form->getMethod();
	}
	
	private function getField($field) {
		$fieldType = $field->getFieldType();
		$fieldConf = $this->params->fieldConf[$fieldType];

		if (empty($fieldConf['class'])) {
			if (!empty($fieldConf['template'])) {
				$templateFile = t3lib_div::getFileAbsFileName($fieldConf['template']);
				return t3lib_div::getURL($templateFile);
			}
			return '';
		}
		
		@include_once(t3lib_div::getFileAbsFileName($fieldConf['class']));
			
		$view = $this->componentManager->getComponent('Tx_FormhandlerGui_View');
		if (empty($fieldConf['template'])) {
			$view->setNoRender(true);
		}else{
			$view->config->setViewFile($fieldConf['template']);
		}
		$controller = $this->componentManager->getComponent($fieldType);
		$controller->setView($view);
		$controller->setParams(array(
			'field' => $field,
			'form' => $this->form
		));
		$controller->run();
		return $view->render();
	}
	
	private function automap($fields, $table) {
		$tableFields = $GLOBALS['TYPO3_DB']->admin_get_fields($table);
		$mappingFields = array();
		foreach ($fields as $field) {
			$name = $field->getFieldName();
			if (!empty($tableFields[$name])) {
				$mappingFields[$name.'.']['mapping.'] = $name;
			}
		}
		return $mappingFields;
	}
}
?>