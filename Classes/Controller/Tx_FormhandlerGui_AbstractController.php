<?php
/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *
 * $Id$
 *                                                                        */

/**
 * Abstract class for Controller Classes used by Formhandler.
 *
 * @package	Tx_FormhandlerGui
 * @subpackage	Controller
 * @abstract
 */
abstract class Tx_FormhandlerGui_AbstractController implements Tx_FormhandlerGui_ControllerInterface {

	/**
	 * The content returned by the controller
	 *
	 * @access protected
	 * @var Tx_Formhandler_Content
	 */
	protected $content;

	/**
	 * The key of a possibly selected predefined form
	 *
	 * @access protected
	 * @var string
	 */
	protected $predefined;

	/**
	 * The name of the current translation file
	 *
	 * @access protected
	 * @var string
	 */
	protected $langFile;
	
	/**
	 * The path where the translation files are located
	 * 
	 * @access protected
	 * @var string
	 */
	protected $langFileRoot = 'EXT:formhandlergui/Resources/Language/';

	/**
	 * Sets the content attribute of the controller
	 *
	 * @param Tx_Formhandler_Content $content
	 * @author Reinhard Führicht <rf@typoheads.at>
	 * @return void
	 */
	public function setContent($content) {
		$this->content = $content;
	}

	/**
	 * Returns the content attribute of the controller
	 *
	 * @author Reinhard Führicht <rf@typoheads.at>
	 * @return Tx_Formhandler_Content
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Sets the internal attribute "langFile"
	 *
	 * @author Christian Opitz <co@netzelf.de>
	 * @param string $langFile
	 * @return void
	 */
	public function setLangFile($langFile) {
		global $LANG;
		$this->langFile = $langFile;
		$LANG->includeLLFile($this->langFileRoot.$langFile);
	}
	
	/**
	 * Translates a string with the given ID
	 * 
	 * @param string $msgid
	 * @return string The translated string
	 */
	public function getLL($msgid) {
		global $LANG;
		return $LANG->getLL($msgid);
	}
	
	/**
	 * Sets the internal attribute "emailSettings"
	 *
	 * @author Reinhard Führicht <rf@typoheads.at>
	 * @param array $new
	 * @return void
	 */
	public function setEmailSettings($new) {
		$this->emailSettings = $new;
	}

	/**
	 * Sets the template file attribute to $template
	 *
	 * @author	Reinhard Führicht <rf@typoheads.at>
	 * @param string $template
	 * @return void
	 */
	public function setTemplateFile($template) {
		$this->templateFile = $template;
	}
	
	/**
	 * Returns the right settings for the formhandler (Checks if predefined form was selected)
	 *
	 * @author Reinhard Führicht <rf@typoheads.at>
	 * @return array The settings
	 */
	public function getSettings() {
		$settings = $this->configuration->getSettings();

		if($this->predefined) {
				
			$settings = $settings['predef.'][$this->predefined];
		}
		return $settings;
	}
}
?>
