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
		'label'     => 'field_label',	
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
		'dividers2tabs' => 2
	),
);

if (TYPO3_MODE == 'BE') {	
	t3lib_extMgm::addModulePath('web_txformhandlerguiM1', t3lib_extMgm::extPath($_EXTKEY) . 'mod/');
		
	t3lib_extMgm::addModule('web', 'txformhandlerguiM1', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod/');
	$TBE_MODULES['web']=str_replace('txformhandlermoduleM1,','',$TBE_MODULES['web']);
}

t3lib_extMgm::addTypoScriptSetup('plugin.tx_formhandler.includeLibs = EXT:formhandlergui/pi/class.tx_formhandler.php');
?>