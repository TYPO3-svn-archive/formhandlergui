<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_formhandlergui_forms'] = array (
	'ctrl' => $TCA['tx_formhandlergui_forms']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,fe_group,title,type,method,prefix,enable_email,enable_db,debug,rows,cols,fields'
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
		'type' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.type',		
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.type.I.0', '0'),
					array('LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.type.I.1', '1'),
				),
				'default' => '0',
				'size' => 1,	
				'maxitems' => 1,
			)
		),
		'method' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.method',		
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.method.I.0', '0'),
					array('LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.method.I.1', '1'),
				),
				'size' => 1,	
				'maxitems' => 1,
			)
		),
		'prefix' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.prefix',		
			'config' => array (
				'type' => 'input',	
				'size' => '10',
			)
		),
		'enable_email' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.enable_email',		
			'config' => array (
				'type' => 'check',
			)
		),
		'enable_db' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.enable_db',		
			'config' => array (
				'type' => 'check',
			)
		),
		'debug' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.debug',		
			'config' => array (
				'type' => 'check',
			)
		),
		'rows' => array(
			'label' => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.rows',
			'config' => array (
				'type' => 'user',
				'userFunc' => 'tx_formhandlergui_tca->rows'
			)
		),
		'cols' => array(
			'label' => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.cols',
			'config' => array (
				'type' => 'user',
				'userFunc' => 'tx_formhandlergui_tca->cols'
			)
		),
		'fields' => array(
			'label' => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.fields',
			'config' => array (
				'type' => 'user',
				'userFunc' => 'tx_formhandlergui_tca->fields'
			)
		)
	),
	'types' => array (
		'0' => array('showitem' => '
				hidden;;1;;1-1-1, title;;2;;2-2-2, enable_email, enable_db, debug,
				--div--;LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.tabs.fields, rows;;;;1-1-1, cols, fields')
	),
	'palettes' => array (
		'1' => array('showitem' => 'fe_group'),
		'2' => array('showitem' => 'type,method,prefix','canNotCollapse' => 1)
	)
);

include_once(t3lib_extMgm::extPath('formhandlergui') . '/Resources/Classes/class.tx_formhandlergui_tca.php');
?>