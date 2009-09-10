<?php
class Tx_FormhandlerGui_View_Helpers {
	public function translate($string) {
		global $LANG;
		return $LANG->getLL($msgid);
	}
}