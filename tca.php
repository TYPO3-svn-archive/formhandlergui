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
				'type' => 'select',	
				'foreign_table' => 'tx_formhandlergui_fields',
				'foreign_table_where' => 'ORDER BY tx_formhandlergui_fields.field_title',	
				'size' => 6,	
				'minitems' => 0,
				'maxitems' => 100,	
				'wizards' => array(
					'_PADDING'  => 2,
					'_VERTICAL' => 1,
					'add' => array(
						'type'   => 'popup',
						'title'  => 'Create new record',
						'icon'   => 'add.gif',
						'params' => array(
							'table'    => 'tx_formhandlergui_fields',
							'setValue' => 'prepend',
						),
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						'script' => 'EXT:formhandlergui/mod/wizard_add.php',
					),
					'list' => array(
						'type'   => 'script',
						'title'  => 'List',
						'icon'   => 'list.gif',
						'params' => array(
							'table' => 'tx_formhandlerdev_fields',
							'pid'   => '###CURRENT_PID###',
						),
						'script' => 'wizard_list.php',
					),
					'edit' => array(
						'type'                     => 'popup',
						'title'                    => 'Edit',
						'script'                   => 'wizard_edit.php',
						'popup_onlyOpenIfSelected' => 1,
						'icon'                     => 'edit2.gif',
						'JSopenParams'             => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
					),
				),
			)
		),
		'multistep_forms' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.multistep_forms',		
			'config' => array (
				'type' => 'group',	
				'internal_type' => 'db',	
				'allowed' => 'tx_formhandlergui_forms',	
				'size' => 5,	
				'minitems' => 0,
				'maxitems' => 100,
			)
		)
	),
	'types' => array (
		'0' => array('showitem' => '
				hidden;;1;;1-1-1, title;;2;;2-2-2, enable_email, enable_db, debug,
				--div--;LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.tabs.fields, rows;;;;1-1-1, cols, fields'),
		
		'1' => array('showitem' => '
				hidden;;1;;1-1-1, title;;2;;2-2-2, multistep_forms, enable_email, enable_db, debug,
				--div--;LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_forms.tabs.fields, rows;;;;1-1-1, cols, fields')
	),
	'palettes' => array (
		'1' => array('showitem' => 'fe_group'),
		'2' => array('showitem' => 'type,method,prefix','canNotCollapse' => 1)
	)
);

$TCA['tx_formhandlergui_fields'] = array (
	'ctrl' => $TCA['tx_formhandlergui_fields']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,hidden,fe_group,field_type,title,label_fd2f0beb3c,lang_opt,field_opt,validators'
	),
	'feInterface' => $TCA['tx_formhandlergui_fields']['feInterface'],
	'columns' => array (
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l10n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_formhandlerdev_fields',
				'foreign_table_where' => 'AND tx_formhandlerdev_fields.pid=###CURRENT_PID### AND tx_formhandlerdev_fields.sys_language_uid IN (-1,0)',
			)
		),
		'l10n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
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
		'field_type' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_fields.field_type',		
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_fields.field_type.I.0', '0'),
				),
				'itemsProcFunc' => 'tx_formhandlergui_tca->fields',	
				'size' => 1,	
				'maxitems' => 1,
			)
		),
		'field_title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_fields.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'field_label' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_fields.label',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'nospace',
			)
		),
		'lang_opt' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_fields.lang_opt',		
			'config' => array (
				'type' => 'flex',
				'ds' => array (
					'default' => 'FILE:EXT:formhandler_dev/flexform_tx_formhandlerdev_fields_lang_opt.xml',
				),
			)
		),
		'field_opt' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_fields.field_opt',		
			'config' => array (
				'type' => 'flex',
				'ds' => array (
					'default' => 'FILE:EXT:formhandler_dev/flexform_tx_formhandlerdev_fields_field_opt.xml',
				),
			)
		),
		'validators' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_fields.validators',		
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:formhandlergui/Resources/Language/locallang_db.xml:tx_formhandlergui_fields.validators.I.0', '0'),
				),
				'size' => 5,	
				'maxitems' => 20,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 
		'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, field_type, field_title;;;;2-2-2')
	),
	'palettes' => array (
		'1' => array('showitem' => 'fe_group')
	)
);

include_once(t3lib_extMgm::extPath('formhandlergui') . '/Resources/Classes/class.tx_formhandlergui_tca.php');
?>