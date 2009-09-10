<?php
class Tx_FormhandlerGui_View_Renderer extends Tx_FormhandlerGui_View_Helpers {
	public function render($templateFile, $vars=array()) {
		extract($vars);
		ob_start();
		include_once($templateFile);
		$templateContent = ob_get_contents();
		ob_end_clean();
		return $templateContent;
	}
}