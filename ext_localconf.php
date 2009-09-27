<?php 
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_befunc.php']['getFlexFormDSClass'][] =
'EXT:formhandlergui/Resources/Classes/class.tx_formhandlergui_hooks.php:tx_formhandlergui_hooks';

$path = 'EXT:formhandlergui/Classes/Fields/tx_formhandlergui_%field%.php:tx_formhandlergui_%field%';

$fields = array(
	'Tx_FormhandlerGui_Text' => array(
		'title' 	=> 'LLL:EXT:formhandlergui/Resources/Language/fields.xml:text.title',
		'langConf'	=> 'EXT:formhandlergui/Resources/Fields/Tx_FormhandlerGui_Text.lang.xml',
		'fieldConf'	=> 'EXT:formhandlergui/Resources/Fields/Tx_FormhandlerGui_Text.field.xml',
		'class'		=> 'EXT:formhandlergui/Resources/Fields/Tx_FormhandlerGui_Text.php',
		'template'	=> 'EXT:formhandlergui/Resources/Fields/Tx_FormhandlerGui_Text.html'
	)
);

foreach ($fields as $field) {
	$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['formhandlergui']['fieldTypes'] = $fields; //str_replace('%field%',$field,$path);
}