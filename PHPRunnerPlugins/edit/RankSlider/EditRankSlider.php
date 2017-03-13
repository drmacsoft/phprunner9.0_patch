<?php 
class EditRankSlider extends UserControl
{
	function initUserControl()
	{
	}
	
	
	 //function slider_rank_initial($value) {
	
	
      
   // }
	
	function buildUserControl($value, $mode, $fieldNum = 0, $validate, $additionalCtrlParams, $data)
	{
		echo $this->getSetting("label").'<input id="'.$this->cfield.'" '.$this->inputStyle.' type="hidden" class="selection_slider_rank"  '
			.($mode == MODE_SEARCH ? 'autocomplete="off" ' : '')
			.(($mode==MODE_INLINE_EDIT || $mode==MODE_INLINE_ADD) && $this->is508==true ? 'alt="'.$this->strLabel.'" ' : '')
			.'name="'.$this->cfield.'" '.$this->pageObject->pSetEdit->getEditParams($this->field).' value="'
			.htmlspecialchars($value).'">';
				echo $this->getSetting("label").'<div class="slider" style="margin-top:42px;min-width:200px;" onclick="select_slider_r()" ></div>';
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
		$this->pageObject->AddJSFile("jquery-ui-slider-pips.js");
		//$this->pageObject->AddJSFile("include/js/jquery-migrate-1.2.1.min.js");
		
		
		//$this->pageObject->AddJSFile("jquery.min.js");
		//$this->pageObject->AddJSFile("bootstrap-datepicker.min.js");
		//$this->pageObject->AddJSFile("bootstrap-datepicker.fa.min.js");
		
		//$this->pageObject->AddJSFile("111.js");
	}

	/**
	 * addCSSFiles
	 * Add control CSS files to page object
	 */ 
	function addCSSFiles()
	{
		
		$this->pageObject->AddCSSFile("jquery-ui.css");
		
		
	}
}
?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
        var temp = $(".selection_slider_rank").val();
        $(".slider")
                .slider({
            max: 10,
            value: temp
        })
                .slider("pips", {
            rest: "label"
        });

$(".ui-slider-label").click(function() {
    //alert("The paragraph is now hidden");
     var tmp = $(".ui-slider-pip-selected .ui-slider-label").text();
    $(".selection_slider_rank").val(tmp);
    
});

    });
function select_slider_r()
{



//$(".slider").hover(function() {
//    ale
}
</script>