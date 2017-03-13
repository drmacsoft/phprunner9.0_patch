<?php
class ViewQRCode extends ViewUserControl
{
	// Optional. Can be deleted
	public function initUserControl()
	{
		$myOption = $this->settings["MyOption"];
		$this->addJSControlSetting("myOpt", "myOpt:".$myOption);
	}
	
	// Optional. Can be deleted
	public function addJSFiles()
	{
		$this->AddJSFile("qrcode2.js");
		$this->AddJSFile("jquery.qrcode.js");
	}
	
	public function showDBValue(&$data, $keylink)
	{
		$result = "<span id='qrcode_".$this->field."' value='".$data[$this->field]."'></span>";
		return $result;
	}
}
?>