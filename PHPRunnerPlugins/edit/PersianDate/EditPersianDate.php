<?php 
include_once 'JalaliDate.php';
include_once 'Timely.php';
class EditPersianDate extends UserControl
{
	function initUserControl()
	{
	}
	
	function buildUserControl($value, $mode, $fieldNum = 0, $validate, $additionalCtrlParams, $data)
	{
		echo $this->getSetting("label").'<input id="'.$this->cfield.'" '.$this->inputStyle.' type="text" class="black apersiann2" readonly="readonly" '
			.($mode == MODE_SEARCH ? 'autocomplete="off" ' : '')
			.(($mode==MODE_INLINE_EDIT || $mode==MODE_INLINE_ADD) && $this->is508==true ? 'alt="'.$this->strLabel.'" ' : '')
			.'name="'.$this->cfield.'" '.$this->pageObject->pSetEdit->getEditParams($this->field).' value="'
			.htmlspecialchars(Timely::AllCalendartToGregory($value)).'">';		
			//.htmlspecialchars(Timely::AllCalendartToGregory($value)).'">';	
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
	}

	/**
	 * addCSSFiles
	 * Add control CSS files to page object
	 */ 
	function addCSSFiles()
	{
	}
}
?>