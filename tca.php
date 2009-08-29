<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_formhandlergui_forms'] = array (
	'ctrl' => $TCA['tx_formhandlergui_forms']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,fe_group,title,config'
	),
	'feInterface' => $TCA['tx_formhandlergui_forms']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'fe_group' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		'title' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
			)
		),
		'config' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.config',		
			'config' => array (
				'type' => 'flex',
				'ds' => array (
					'default' => 'FILE:EXT:formhandlergui/flexform_tx_formhandlergui_forms_config.xml',
				),
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title, config')
	),
	'palettes' => array (
		'1' => array('showitem' => 'fe_group')
	)
);
?>