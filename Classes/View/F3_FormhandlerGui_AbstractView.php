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

/**
 * An abstract view
 *
 * @author	Jochen Rau <j.rau@web.de>
 * @package	TYPO3
 * @subpackage	F3_MyPackage
 */
abstract class F3_FormhandlerGui_AbstractView extends tslib_pibase {	
	public $prefixId = 'F3_MyPackage';
	public $scriptRelPath = 'Resources/Language/F3_LanguageDummy.php';
	public $extKey = 'mypackage';
	public $cObj;
	public $piVars;

	protected $componentManager;
	protected $configuration;
	protected $model;
	protected $subparts;
	protected $typolinkConf;

	public function __construct(F3_GimmeFive_Component_Manager $componentManager, F3_MyPackage_Configuration $configuration) {
		$this->componentManager = $componentManager;
		$this->configuration = $configuration;
		$this->cObj = t3lib_div::makeInstance('tslib_cObj');
		$this->cObj->setCurrentVal($GLOBALS['TSFE']->id);
		$this->typolinkConf['parameter.']['current'] = 1;
		$this->typolinkConf['additionalParams'] = $this->cObj->stdWrap($typolinkConf['additionalParams'], $typolinkConf['additionalParams.']);
		unset($this->typolinkConf['additionalParams.']);
		parent::__construct();
		$this->pi_loadLL();
		$this->initializeView();
	}
	
	public function setModel($model) {
		$this->model = $model;
	}

	public function getModel() {
		return $model;
	}

	public function setTemplate($templateFile, $templateName, $forceTemplate = FALSE) {
		if ($this->configuration->offsetGet('templateFile') && $forceTemplate == FALSE) {
			$templatePathAndFilename = PATH_site . $this->configuration->offsetGet('templateFile');			
		} else {
			// FIXME Hard coded path name
			$templatePathAndFilename = t3lib_extMgm::extPath($this->configuration->getPackageKeyLowercase()) . F3_GimmeFive_Component_Manager::DIRECTORY_TEMPLATES . $templateFile;
		}
		if (!isset($templatePathAndFilename) || !file_exists($templatePathAndFilename)) throw new Exception('Template file not found.');
			$templateCode = file_get_contents($templatePathAndFilename);
			$this->subparts['template'] = $this->cObj->getSubpart($templateCode,'###TEMPLATE_' . strtoupper($templateName) . '###');
			$this->subparts['item'] = $this->cObj->getSubpart($this->subparts['template'],'###ITEM###');
	}
	
	abstract public function render();
	
	/**
	 * Overwrite this method to extend the initialization of the View
	 *
	 * @return void
	 * @author Jochen Rau
	 */
	protected function initializeView() {
	}
	
	protected function fillMarker($term, &$markerArray, &$wrappedSubpartArray) {
		$labelWrap['noTrimWrap'] = $this->configuration->offsetGet('labelWrap') ? $this->configuration->offsetGet('labelWrap') : NULL;
		foreach ($term as $property => $value) {
			// TODO Improve pre-processing of property-values 
			if (is_array($value)) {
				$value = implode(', ', $value);
			}
			$propertyMarker = '###' . $this->getUpperCase($property) . '###';
			$markerArray[$propertyMarker] = $term[$property] ? $value : $this->pi_getLL('na');
			$labelMarker = '###' . $this->getUpperCase($property) . '_LABEL###';
			$markerArray[$labelMarker] = $this->cObj->stdWrap($this->pi_getLL($property), $labelWrap);
		}
	}
	
	protected function removeUnfilledMarker($content) {
		return preg_replace('/###.*?###/', '', $content);
	}
	
	protected function getUpperCase($camelCase) {
		return strtoupper(preg_replace('/\p{Lu}+(?!\p{Ll})|\p{Lu}/u', '_$0', $camelCase));
	}
}
?>