<?php 
unset($MCONF);
require_once('conf.php');
require_once($BACK_PATH . 'init.php');
require($BACK_PATH . 'template.php');
$LANG->includeLLFile('EXT:lang/locallang_alt_doc.xml');

class tx_formhandlergui_wizard_add {
	var $P;
	
	public function init() {
		global $MCONF;
		$MCONF['extConf'] = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['formhandlergui']);
		$this->P = t3lib_div::_GP('P');
		$this->doClose = t3lib_div::_GP('doClose');
	}
	
	public function main() {
		global $MCONF, $BACK_PATH;
		
		if ($this->doClose) {
			$this->updateParent();
			$this->closeWindow();
		}
		
		$pid = $MCONF['extConf']['fguiPid'];
		$docParams = '&edit['.$this->P['params']['table'].']['.$pid.']=new'.
		'&returnEditConf=1'.
		'&noView=1';
		
		$myParams = '?doClose=1'.
		'&table='.$this->P['table'].
		'&field='.$this->P['field'].
		'&itemName='.$this->P['itemName'].'_sel';
		
		$returnUrl  = t3lib_extMgm::extRelPath('formhandlergui').'mod/wizard_add.php'.rawurlencode($myParams);
		//var_dump($myParams);
		header('Location: '.t3lib_div::locationHeaderUrl($BACK_PATH.'alt_doc.php?returnUrl='.$returnUrl.$docParams));
	}
	
	private function updateParent() {
		global $TCA, $LANG;
		
		$table = t3lib_div::_GP('table');
		$field = t3lib_div::_GP('field');
		
		t3lib_div::loadTCA($table);
		
		$fieldValue = $TCA[$table]['columns'][$field];
		$f_table = $fieldValue['config']['foreign_table'];
		$prefix = $LANG->sL($fieldValue['config']['foreign_table_prefix']);
		
		$res = t3lib_BEfunc::exec_foreign_table_where_query($fieldValue, $field);
				
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))	{
			t3lib_BEfunc::workspaceOL($f_table, $row);
		
			if (is_array($row)) {
				$items[] = "{'title':'".$prefix.strip_tags(t3lib_BEfunc::getRecordTitle($f_table,$row))."',".
							"'id':'".$row['uid']."'}";
			}
		}
		
		if (!is_array($items))
			return;
		
		
		$itemName = t3lib_div::_GP('itemName');
		$itemJS = implode(',',$items);
		
		$fn = "var selectSource = document.getElementsByName('{$itemName}')[0];
		
		var items = [{$itemJS}];
		
		var options = selectSource.childElements();
		for (var i = 0, length = options.length; i < length; ++i) {
			options[i].remove(); 
		};
		
		for (var i = 0, length = items.length; i < length; ++i) {
			var option = new Element('option',{'value':items[i].id});
			option.innerHTML = items[i].title;
			selectSource.insert(option);
		}";
		
		$fn = strtr($fn, array("\n" => ' ', "\r\n" =>' ', "\t" => ''));
		
		$js = '<script type="text/javascript">
		var fn = "'.$fn.'";
		window.opener.top.content.list_frame.eval(fn);
		</script>';
		
		echo $js;
	}
	
	/**
	 * Printing a little JavaScript to close the open window.
	 *
	 * @return	void
	 */
	private function closeWindow()	{
		echo '<script language="javascript" type="text/javascript">close();</script>';
		exit;
	}
}

$SOBE = t3lib_div::makeInstance('tx_formhandlergui_wizard_add');
$SOBE->init();
$SOBE->main();
?>