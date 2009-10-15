<?php 
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_befunc.php']['getFlexFormDSClass'][] =
'EXT:formhandlergui/Resources/Classes/class.tx_formhandlergui_hooks.php:tx_formhandlergui_hooks';

$path = 'EXT:formhandlergui/Classes/Fields/tx_formhandlergui_%field%.php:tx_formhandlergui_%field%';

$fields = array(
	'Tx_FormhandlerGui_Text' => array(
		'title' 	=> 'LLL:EXT:formhandlergui/Resources/Language/fields.xml:text.title',
		'langConf'	=> 'EXT:formhandlergui/Resources/Fields/Text/lang_conf.xml',
		'fieldConf'	=> 'EXT:formhandlergui/Resources/Fields/Text/field_conf.xml',
		'class'		=> 'EXT:formhandlergui/Resources/Fields/Text/Tx_FormhandlerGui_Text.php',
		'template'	=> 'EXT:formhandlergui/Resources/Fields/Text/template.html'
	),
	'Tx_FormhandlerGui_TextArea' => array(
		'title' 	=> 'LLL:EXT:formhandlergui/Resources/Language/fields.xml:textarea.title',
		'langConf'	=> 'EXT:formhandlergui/Resources/Fields/Text/lang_conf.xml',
		'fieldConf'	=> 'EXT:formhandlergui/Resources/Fields/TextArea/field_conf.xml',
		'class'		=> 'EXT:formhandlergui/Resources/Fields/TextArea/Tx_FormhandlerGui_TextArea.php',
		'template'	=> 'EXT:formhandlergui/Resources/Fields/TextArea/template.html'
	),
	'Tx_FormhandlerGui_Select' => array(
		'title' 	=> 'LLL:EXT:formhandlergui/Resources/Language/fields.xml:select.title',
		'langConf'	=> 'EXT:formhandlergui/Resources/Fields/Select/lang_conf.xml',
		'fieldConf'	=> 'EXT:formhandlergui/Resources/Fields/Select/field_conf.xml',
		'class'		=> 'EXT:formhandlergui/Resources/Fields/Select/Tx_FormhandlerGui_Select.php',
		'template'	=> 'EXT:formhandlergui/Resources/Fields/Select/template.html'
	),
	'Tx_FormhandlerGui_CheckBox' => array(
		'title' 	=> 'LLL:EXT:formhandlergui/Resources/Language/fields.xml:checkbox.title',
		'langConf'	=> 'EXT:formhandlergui/Resources/Fields/CheckBox/lang_conf.xml',
		'fieldConf'	=> 'EXT:formhandlergui/Resources/Fields/CheckBox/field_conf.xml',
		'class'		=> 'EXT:formhandlergui/Resources/Fields/CheckBox/Tx_FormhandlerGui_CheckBox.php',
		'template'	=> 'EXT:formhandlergui/Resources/Fields/CheckBox/template.html'
	),
	'Tx_FormhandlerGui_Submit' => array(
		'title' 	=> 'LLL:EXT:formhandlergui/Resources/Language/fields.xml:submit.title',
		'class'		=> 'EXT:formhandlergui/Resources/Fields/Submit/Tx_FormhandlerGui_Submit.php',
		'langConf'	=> 'EXT:formhandlergui/Resources/Fields/Submit/lang_conf.xml',
		'template'	=> 'EXT:formhandlergui/Resources/Fields/Submit/template.html'
	)
	
);

foreach ($fields as $field) {
	$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['formhandlergui']['fieldTypes'] = $fields; //str_replace('%field%',$field,$path);
}