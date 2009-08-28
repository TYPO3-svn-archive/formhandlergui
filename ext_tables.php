<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$TCA['tx_formhandlergui_forms'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms',		
		'label'     => 'formname',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_formhandlergui_forms.gif',
	),
);


if (TYPO3_MODE == 'BE') {	
	t3lib_extMgm::addModulePath('tools_txformhandlerguiM1', t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Controller/Module/');
		
	t3lib_extMgm::addModule('tools', 'txformhandlerguiM1', '', t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Controller/Module/');
}

t3lib_extMgm::addTypoScriptSetup('plugin.tx_formhandler.includeLibs = typo3conf/ext/formhandlergui/pi/class.tx_formhandler.php');
?>