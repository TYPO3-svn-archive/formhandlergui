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
abstract class Tx_FormhandlerGui_AbstractController /*implements Tx_FormhandlerGui_ControllerInterface*/ {

	/**
	 * @var Tx_GimmeFive_Component_Manager
	 */
	protected $componentManager;
	
	/**
	 * @var Tx_FormhandlerGui_Configuration
	 */
	protected $configuration;
	
	/**
	 * @var Tx_FormhandlerGui_View
	 */
	protected $view;

	/**
	 * The constructor for a finisher setting the component manager and the configuration.
	 *
	 * @param Tx_GimmeFive_Component_Manager $componentManager
	 * @param Tx_FormhandlerGui_Configuration $configuration
	 * @author Reinhard Führicht <rf@typoheads.at>
	 * @return void
	 */
	public function __construct(
		Tx_GimmeFive_Component_Manager $componentManager, 
		Tx_FormhandlerGui_Configuration $configuration,
		Tx_FormhandlerGui_View $view
	) {
		$this->componentManager = $componentManager;
		$this->configuration = $configuration;
		$this->view = $view;
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
