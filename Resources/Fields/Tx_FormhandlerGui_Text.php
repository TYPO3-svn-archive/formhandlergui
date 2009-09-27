<?php
class Tx_FormhandlerGui_Text extends Tx_FormhandlerGui_ActionController {
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