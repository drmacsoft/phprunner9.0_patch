<?php 
class EditPersianDate extends UserControl
{
	function initUserControl()
	{
	}
	
	function buildUserControl($value, $mode, $fieldNum = 0, $validate, $additionalCtrlParams, $data)
	{
		echo $this->getSetting("label").'<input id="'.$this->cfield.'" '.$this->inputStyle.' type="text" class="color-picker black apersiann" readonly="readonly" '
			.($mode == MODE_SEARCH ? 'autocomplete="off" ' : '')
			.(($mode==MODE_INLINE_EDIT || $mode==MODE_INLINE_ADD) && $this->is508==true ? 'alt="'.$this->strLabel.'" ' : '')
			.'name="'.$this->cfield.'" '.$this->pageObject->pSetEdit->getEditParams($this->field).' value="'
			.htmlspecialchars($value).'">';	
	}
	
	function getUserSearchOptions()
	{
		return array(EQUALS, STARTS_WITH, NOT_EMPTY, NOT_EQUALS);		
	}

	/**
	 * addJSFiles
	 * Add control JS files to page object
	 */
	function addJSFiles()
	{
		//$this->pageObject->AddJSFile("jquery.miniColors.min.js");
		//$this->pageObject->AddJSFile("include/js/jquery-migrate-1.2.1.min.js");
		
		
		//$this->pageObject->AddJSFile("jquery.min.js");
		
		$this->pageObject->AddJSFile("include/js/bootstrap-datepicker.min.js");
		//$this->pageObject->AddJSFile("include/js/bootstrap-datepicker.fa.min.js");
		//$this->pageObject->AddJSFile("include/js/my_date_loader.js");
	}

	/**
	 * addCSSFiles
	 * Add control CSS files to page object
	 */ 
	function addCSSFiles()
	{
		$this->pageObject->AddCSSFile("bootstrap-datepicker.min.css");		
		$this->pageObject->AddCSSFile("jquery.miniColors.css");
	}
}
?>