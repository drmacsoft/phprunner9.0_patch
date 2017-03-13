<?php

class EditDetailIrica extends UserControl {

    function initUserControl() {
        
    }

    function debt_detail_php_initail_result($value) {

        $arr = explode(",", $value);
        array_shift($arr);
        //var_dump($arr2);
        $len = count($arr);
        $half = $len / 2;
        //var_dump($len);
        //die();
        $sum = 0;
        for ($i = 0; $i < $len; $i++) {
            $sum = $sum + $arr[2 * $i];
        }
        echo ("<div class='debt_detail_first_show' style='background-color:rgba(181, 177, 177, 0.57);min-width:200px'> 
" . $half . '  مورد        
    به مجموع
    ' . $sum . '
	 ريال 
</div>');
    }

    function buildUserControl($value, $mode, $fieldNum = 0, $validate, $additionalCtrlParams, $data) {
        echo $this->getSetting("label") . '<input type="hidden" id="' . $this->cfield . '" ' . $this->inputStyle . ' type="text"  type="text"  class="color-picker black  debt debtDetailInput_hidden" '
        . ($mode == MODE_SEARCH ? 'autocomplete="off" ' : '')
        . (($mode == MODE_INLINE_EDIT || $mode == MODE_INLINE_ADD) && $this->is508 == true ? 'alt="' . $this->strLabel . '" ' : '')
        . 'name="' . $this->cfield . '" ' . $this->pageObject->pSetEdit->getEditParams($this->field) . ' value="'
        . htmlspecialchars($value) . '">';

        echo '<a class="btn btn-xs btn-bricky tooltips" href="#" style="float:right;"><i class="fa fa-edit" style="padding:3px;" onclick="debt_detail_main()"></i></a>';
        // $this->debt_detail_php_initail_result($value);
        echo'<div id="debt_detail_showResult" style="float:left;min-height:30px;margin-right:20px;background-color:bisque;margin-bottom:15px;">
            </div>';

        echo '<div id="dialog" title="ريز بدهي ها" style="display:none;" class="main_div_debt">
		<button id="adddebt" class="btn btn-primary">اضافه کردن</button>
		<div class="error_debt">
                <p class="error_text_debt" style="display:none;color:red;">*مقدار ورودي بايد بيشتر از 100000 ريال باشد</p>
                <p class="null_error_debt" style="display:none;color:red;">* مقدار نمي تواند خالي باشد</p>
                <p class="error_debt_sum" style="display:none;color:red;">* مجموع ورودي ها بايد بيشتر از 2000000 ريال باشد </p>
                 <p class="nonrepeat_error_debt" style="display:none;color:red;">ورودي تکراري است</p>
                
                </div>
		
				</div>';
    }

    function getUserSearchOptions() {
        return array(EQUALS, STARTS_WITH, NOT_EMPTY, NOT_EQUALS);
    }

    /**
     * addJSFiles
     * Add control JS files to page object
     */
    function addJSFiles() {
        $this->pageObject->AddJSFile("include/DetailIrica/IricaDebtDetail.js");
    }

    /**
     * addCSSFiles
     * Add control CSS files to page object
     */
    function addCSSFiles() {
        $this->pageObject->AddCSSFile("include/DetailIrica/IricaDebtDetail.css");
    }

}