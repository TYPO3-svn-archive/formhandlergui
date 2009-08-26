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

/* Throw formhandler static template out of TCA
if (is_array($TCA['sys_template']['columns']['include_static_file']['config']['items'])) {
	foreach($TCA['sys_template']['columns']['include_static_file']['config']['items'] as $i => $a) {
		if ($a[1]=='EXT:formhandler/Configuration/Settings/')
			unset($TCA['sys_template']['columns']['include_static_file']['config']['items'][$i]);
	}
}*/
t3lib_extMgm::addTypoScriptSetup('plugin.Tx_Formhandler >
includeLibs.Tx_FormhandlerGui_default = EXT:formhandler/Classes/Controller/tx_FormhandlerGui_Dispatcher.php
plugin.Tx_Formhandler = USER_INT
plugin.Tx_Formhandler.userFunc = tx_FormhandlerGui_Dispatcher->main
tt_content.list.20.formhandler_pi1 < plugin.Tx_Formhandler');
?>