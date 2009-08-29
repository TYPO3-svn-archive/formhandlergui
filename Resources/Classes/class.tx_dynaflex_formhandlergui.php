<?php

/**
 * Brings predef forms from formhandlergui to formhandler plugin
 * 
 * @author Christian Opitz <co@netzelf.de>
 *
 */
class tx_dynaflex_formhandlergui extends tx_dynaflex_formhandler 
{
	/* (non-PHPdoc)
	 * @see typo3conf/ext/formhandler/Resources/PHP/tx_dynaflex_formhandler#addFields_predefined($config)
	 */
	public function addFields_predefined($config) {
		parent::addFields_predefined($config);
	}
	
	/** 
	 * Push our own predefined forms to TS-Setup so that they are visible in formhandler flexform
	 * 
	 * @see typo3conf/ext/formhandler/Resources/PHP/tx_dynaflex_formhandler#loadTS($pageUid)
	 */
	public function loadTS($pageUid) {
		$ts = parent::loadTS($pageUid);
		$ts['plugin.']['Tx_Formhandler.']['settings.']['predef.']['test.']['name'] = 'Hallo';
		return $ts;
	}
}