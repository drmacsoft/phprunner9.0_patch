<?php

class EditShamsiToMiladi extends UserControl {

    function initUserControl() {
        
    }

    function buildUserControl($value, $mode, $fieldNum = 0, $validate, $additionalCtrlParams, $data) {
        echo $this->getSetting("label") . '<input  ' . $this->inputStyle . ' type="text" class="color-picker black jalali_toj viewconvertdate " readonly="readonly"  onchange="xxx()"
        >';
        echo $this->getSetting("label") . '<input id="' . $this->cfield . '" ' . $this->inputStyle . ' type="hidden" class="hidden_tojdate" '
        . ($mode == MODE_SEARCH ? 'autocomplete="off" ' : '')
        . (($mode == MODE_INLINE_EDIT || $mode == MODE_INLINE_ADD) && $this->is508 == true ? 'alt="' . $this->strLabel . '" ' : '')
        . 'name="' . $this->cfield . '" ' . $this->pageObject->pSetEdit->getEditParams($this->field) . ' value="'
        . htmlspecialchars($value) . '">'
        ;
    }

    function getUserSearchOptions() {
        return array(EQUALS, STARTS_WITH, NOT_EMPTY, NOT_EQUALS);
    }

    /**
     * addJSFiles
     * Add control JS files to page object
     */
    function addJSFiles() {
        //$this->pageObject->AddJSFile("jdate.js");
        //$this->pageObject->AddJSFile("jdate.min.js");
        //$this->pageObject->AddJSFile("jquery.miniColors.min.js");
        //$this->pageObject->AddJSFile("include/js/jquery-migrate-1.2.1.min.js");
        //$this->pageObject->AddJSFile("jquery.min.js");
        //$this->pageObject->AddJSFile("bootstrap-datepicker.min.js");
        //$this->pageObject->AddJSFile("bootstrap-datepicker.fa.min.js");
        //$this->pageObject->AddJSFile("1.js");
    }

    /**
     * addCSSFiles
     * Add control CSS files to page object
     */
    function addCSSFiles() {

        $this->pageObject->AddCSSFile("bootstrap-datepicker.min.css");

        $this->pageObject->AddCSSFile("jquery.miniColors.css");
    }

}
?>
<script>



    function xxx()
    {


        var Jinput = $('.jalali_toj').val();
        var arr = Jinput.split("/");
        var year = arr[0];
        var month = arr[1];
        var day = arr[2];
        var res = m_ShamsiToMiladi(year,month,day);
        var Jresult = String(res);
        var Jarr = Jresult.split("/");
        var Jyear = Jarr[0];
        var Jmonth = Jarr[1];
        var Jday = Jarr[2];
       
        var result= Jday+"/"+Jmonth+"/"+Jyear;
        $('.hidden_tojdate').val(result);


    }

    function m_MiladiToShamsi(g_y, g_m, g_d)
    {
        m_JalaliDate = {
            g_days_in_month: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
            j_days_in_month: [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29]
        };
        g_y = parseInt(g_y);
        g_m = parseInt(g_m);
        g_d = parseInt(g_d);
        var gy = g_y - 1600;
        var gm = g_m - 1;
        var gd = g_d - 1;

        var g_day_no = 365 * gy + parseInt((gy + 3) / 4) - parseInt((gy + 99) / 100) + parseInt((gy + 399) / 400);

        for (var i = 0; i < gm; ++i)
            g_day_no += m_JalaliDate.g_days_in_month[i];
        if (gm > 1 && ((gy % 4 == 0 && gy % 100 != 0) || (gy % 400 == 0)))
            /* leap and after Feb */
            ++g_day_no;
        g_day_no += gd;

        var j_day_no = g_day_no - 79;

        var j_np = parseInt(j_day_no / 12053);
        j_day_no %= 12053;

        var jy = 979 + 33 * j_np + 4 * parseInt(j_day_no / 1461);

        j_day_no %= 1461;

        if (j_day_no >= 366) {
            jy += parseInt((j_day_no - 1) / 365);
            j_day_no = (j_day_no - 1) % 365;
        }

        for (var i = 0; i < 11 && j_day_no >= m_JalaliDate.j_days_in_month[i]; ++i) {
            j_day_no -= m_JalaliDate.j_days_in_month[i];
        }
        var jm = i + 1;
        var jd = j_day_no + 1;
        var moj_res = jy + "/" + jm + "/" + jd;

        return moj_res;
    }

function m_ShamsiToMiladi(j_y, j_m, j_d)
    {
        mm_JalaliDate = {
            g_days_in_month: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
            j_days_in_month: [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29]
        };
        j_y = parseInt(j_y);
        j_m = parseInt(j_m);
        j_d = parseInt(j_d);
        var jy = j_y - 979;
        var jm = j_m - 1;
        var jd = j_d - 1;

        var j_day_no = 365 * jy + parseInt(jy / 33) * 8 + parseInt((jy % 33 + 3) / 4);
        for (var i = 0; i < jm; ++i)
            j_day_no += mm_JalaliDate.j_days_in_month[i];

        j_day_no += jd;

        var g_day_no = j_day_no + 79;

        var gy = 1600 + 400 * parseInt(g_day_no / 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
        g_day_no = g_day_no % 146097;

        var leap = true;
        if (g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */
        {
            g_day_no--;
            gy += 100 * parseInt(g_day_no / 36524); /* 36524 = 365*100 + 100/4 - 100/100 */
            g_day_no = g_day_no % 36524;

            if (g_day_no >= 365)
                g_day_no++;
            else
                leap = false;
        }

        gy += 4 * parseInt(g_day_no / 1461); /* 1461 = 365*4 + 4/4 */
        g_day_no %= 1461;

        if (g_day_no >= 366) {
            leap = false;

            g_day_no--;
            gy += parseInt(g_day_no / 365);
            g_day_no = g_day_no % 365;
        }

        for (var i = 0; g_day_no >= mm_JalaliDate.g_days_in_month[i] + (i == 1 && leap); i++)
            g_day_no -= mm_JalaliDate.g_days_in_month[i] + (i == 1 && leap);
        var gm = i + 1;
        var gd = g_day_no + 1;
        
        
        var moj_res = gy + "/" + gm + "/" + gd;

        return moj_res;
    }



</script>