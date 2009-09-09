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
 *                                                                        */

require_once(PATH_t3lib.'class.t3lib_tceforms.php');

/**
 * Controller for Backend Module of Formhandler
 *
 * @author	Reinhard Führicht <rf@typoheads.at>
 * @package	Tx_Formhandler
 * @subpackage	Controller
 */
class Tx_FormhandlerGui_Controller_Forms extends Tx_FormhandlerGui_AbstractController {


	/**
	 * The GimmeFive component manager
	 *
	 * @access protected
	 * @var Tx_GimmeFive_Component_Manager
	 */
	protected $componentManager;

	/**
	 * The global Formhandler configuration
	 *
	 * @access protected
	 * @var Tx_FormhandlerGui_Configuration
	 */
	protected $configuration;

	/**
	 * The view
	 *
	 * @access protected
	 * @var Tx_FormhandlerGui_View_Simple
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
	public function __construct(Tx_GimmeFive_Component_Manager $componentManager, Tx_FormhandlerGui_Configuration $configuration) {
		$this->componentManager = $componentManager;
		$this->configuration = $configuration;
		
		$this->view = $this->componentManager->getComponent('Tx_FormhandlerGui_View_Simple');
		$this->view->setViewScriptPath('Module',true);
		
		$this->templatePath = t3lib_extMgm::extPath('formhandlergui') . 'Resources/HTML/backend/';
		$this->templateFile = $this->templatePath . 'template.html';
		$this->templateCode = t3lib_div::getURL($this->templateFile);
		
		$this->tceforms = t3lib_div::makeInstance("t3lib_TCEforms");
		$this->tceforms->initDefaultBEMode();
		$this->tceforms->backPath = $GLOBALS['BACK_PATH'];

	}

	/**
	 * init method to load translation data
	 *
	 * @return void
	 */
	protected function init() {
		$this->setLangFile('locallang_mod.xml');
		
		$this->view = $this->componentManager->getComponent('Tx_FormhandlerGui_View_Default');
	}
	
	/**
	 * Main method of the controller.
	 *
	 * @return mixed rendered view or array with tabs
	 */
	public function process() {
		$content = array();
		$content[] = array(
			'label' => $this->getLL('tab_general'),
			'content' => $this->tabGeneral()
		);
		$content[] = array(
			'label' => $this->getLL('tab_mail'),
			'content' => $this->tabMail()
		);
		$content[] = array(
			'label' => $this->getLL('tab_database'),
			'content' => $this->tabDatabase()
		);
		return $content;
	}
	
	protected function tabGeneral() {
		$this->view->assign('test','Huhu');
		return $this->view->render('general');
	}
	
	protected function tabMail() {
		/*$conf = array(
		    'itemFormElName' => 'tx_formhandlergui[myField]',
		    'itemFormElValue' => 'Hallo Welt',
		    'fieldConf' => array(
		        'config' => array(
		            'type' => 'input',
		            'size' => '30'
		        ),
		    ),
		    'fieldChangeFunc' => array()
		);
		$content = $this->tceforms->printNeededJSFunctions_top();
		
		$content .= $this->tceforms->getSingleField_SW('','',array(),$conf);
		
		$content .= $this->tceforms->printNeededJSFunctions_top();
		*/
		$trData = t3lib_div::makeInstance("t3lib_transferData");
		$trData->addRawData = TRUE;
		$trData->lockRecords=1;
		$trData->disableRTE = $GLOBALS['SOBE']->MOD_SETTINGS['disableRTE'];
		
		$trData->fetchRecord('tx_formhandlergui_forms',0,'new');
		reset($trData->regTableItems_data);
		$row = current($trData->regTableItems_data);
		
		$content = $this->tceforms->getMainFields ('tx_formhandlergui_forms',$row);
		//$this->view->assign('test',$content);
		//return $this->view->render('general');
		return $content;
	}
	
	protected function tabDatabase() {
		return $this->getLL('tab_database');
	}

	/**
	 * Adds HTML code to include the CSS file to given HTML content.
	 *
	 * @param string The HTML content
	 * @return string The changed HML content
	 * @author Reinhard Führicht <rf@typoheads.at>
	 */
	protected function addCSS($content) {
		$cssLink = '
			<link 	rel="stylesheet" 
					type="text/css" 
					href="../../../Resources/CSS/backend/styles.css" 
			/>
		';
		return $cssLink. $content;
	}

}
?>
