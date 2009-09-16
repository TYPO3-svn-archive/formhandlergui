<?php

	// DO NOT REMOVE OR CHANGE THESE 2 LINES:
$MCONF['name'] = 'web_txformhandlerguiM1';
define('TYPO3_MOD_PATH', '../typo3conf/ext/formhandlergui/mod/');
$MCONF['script'] = 'index.php';
$BACK_PATH = '../../../../typo3/';
	
$MCONF['access'] = 'user,group';

$MCONF['navFrameScript'] = 'navframe.php';

$MLANG['default']['tabs_images']['tab'] = '../Resources/Images/icon_forms.gif';
$MLANG['default']['ll_ref'] = 'LLL:EXT:formhandlergui/Resources/Language/locallang_mod.xml';

$MCONF['menuItems'] = array(
	'forms' => 'func.forms',
	'report' => 'func.reports',
	'settings' => 'func.settings'
);
?>