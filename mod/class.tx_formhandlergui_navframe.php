<?php

unset($MCONF);
require_once('conf.php');
require_once($BACK_PATH . 'init.php');
require_once($BACK_PATH . 'template.php');

$LANG->includeLLFile('EXT:formhandlergui/Resources/Language/locallang.xml');

class tx_formhandlergui_navframe {
	public function __construct() {
		
	}
}
?>