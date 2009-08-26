<?php

########################################################################
# Extension Manager/Repository config file for ext: "formhandlergui"
#
# Auto generated 16-08-2009 12:56
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Formhandler GUI',
	'description' => 'This extension delivers a module to configure the formhandler extension via a graphical user interface:
- create fields and forms
- drag&drop grid
- automatic mapping
- full controll over generated TS',
	'category' => 'module',
	'author' => 'Christian Opitz',
	'author_email' => 'christian.opitz@netzelf.de',
	'shy' => '',
	'dependencies' => 'formhandler',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
			'formhandler' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:24:{s:9:"ChangeLog";s:4:"d94e";s:10:"README.txt";s:4:"ee2d";s:12:"ext_icon.gif";s:4:"1bdc";s:14:"ext_tables.php";s:4:"2d93";s:14:"ext_tables.sql";s:4:"ed17";s:43:"flexform_tx_formhandlergui_forms_config.xml";s:4:"638c";s:32:"icon_tx_formhandlergui_forms.gif";s:4:"475a";s:7:"tca.php";s:4:"9c1e";s:52:"Classes/Component/Tx_GimmeFive_Component_Manager.php";s:4:"5201";s:63:"Classes/Controller/Module/Tx_Formhandler_Controller_Backend.php";s:4:"10da";s:72:"Classes/Controller/Module/Tx_Formhandler_Controller_BackendClearLogs.php";s:4:"8edc";s:35:"Classes/Controller/Module/clear.gif";s:4:"cc11";s:34:"Classes/Controller/Module/conf.php";s:4:"fad5";s:35:"Classes/Controller/Module/index.php";s:4:"44da";s:40:"Classes/Controller/Module/moduleicon.gif";s:4:"1b05";s:19:"doc/wizard_form.dat";s:4:"4b83";s:20:"doc/wizard_form.html";s:4:"cc35";s:40:"mod1/class.tx_formandlergui_navframe.php";s:4:"269f";s:19:"mod1/moduleicon.gif";s:4:"8074";s:28:"Resources/Gfx/moduleicon.gif";s:4:"2577";s:40:"Resources/HTML/backend/mod_template.html";s:4:"7c59";s:32:"Resources/Language/locallang.xml";s:4:"2312";s:35:"Resources/Language/locallang_db.xml";s:4:"1764";s:36:"Resources/Language/locallang_mod.xml";s:4:"f5e1";}',
	'suggests' => array(
	),
);

?>