<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$TCA['tx_formhandlergui_forms'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'type' => 'type',	
		'origUid' => 't3_origuid',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'Resources/Images/icon_form.gif',
		'dividers2tabs' => 2
	),
);

$TCA['tx_formhandlergui_fields'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_fields',		
		'label'     => 'field_title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'type' => 'field_type',	
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l10n_parent',	
		'transOrigDiffSourceField' => 'l10n_diffsource',	
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'Resources/Images/icon_fields.gif',
	),
);

if (TYPO3_MODE == 'BE') {	
	t3lib_extMgm::addModulePath('tools_txformhandlerguiM1', t3lib_extMgm::extPath($_EXTKEY) . 'mod/');
		
	t3lib_extMgm::addModule('tools', 'txformhandlerguiM1', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod/');
}

t3lib_extMgm::addTypoScriptSetup('plugin.tx_formhandler.includeLibs = EXT:formhandlergui/pi/class.tx_formhandler.php');
?>