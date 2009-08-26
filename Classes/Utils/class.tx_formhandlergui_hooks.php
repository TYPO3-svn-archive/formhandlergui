<?php 
class tx_formhandlergui_hooks {
	public function getFlexFormDS_postProcessDS(&$dataStructArray, $conf, $row, $table, $fieldName) {
		
		$func &= $dataStructArray['sheets']['sDEF']['ROOT']['el']['predefined']['TCEforms']['config']['itemsProcFunc'];

		if ($func == 'tx_dynaflex_formhandler->addFields_predefined') {
			
			include_once(t3lib_extMgm::extPath('formhandlergui') . '/Classes/Utils/class.tx_dynaflex_formhandlergui.php');
			
			$dataStructArray
			['sheets']
			['sDEF']
			['ROOT']
			['el']
			['predefined']
			['TCEforms']
			['config']
			['itemsProcFunc'] = 'tx_dynaflex_formhandlergui->addFields_predefined';
		}
	}
}