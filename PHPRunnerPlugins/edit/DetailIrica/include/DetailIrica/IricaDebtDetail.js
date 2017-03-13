
    var created = 0;
    var debt_detail_showResultID = '#debt_detail_showResult';
    var min_value_for_input = 10000;
    var min_sum_for_inputs = 200000;
    function validate(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault)
                theEvent.preventDefault();
        }




    }
    var sum_of_inputs = 0;
    function validate_all(value)
    {
        var input_value = "";
        var select_value = "";
        var null_flag = 0;
        var error_flag = 0;
        var sum_error = 0;
        var repeat_error = 0;
        var set_value = [];
        $("#dialog .dclass").each(function () {
            input_value = $(this).children(".input_debt_detail").val();
            select_value = $(this).children(".select_debt_detail").val();
            set_value.push($(this).children(".select_debt_detail").val());
            if (select_value == "")
            {
                null_flag = 1;
                $(this).children(".select_debt_detail").focus();
            }
            if (input_value == "")
            {
                null_flag = 1;
                $(this).children(".input_debt_detail").focus();
            }
            if (input_value < min_value_for_input)
            {
                error_flag = 1;
                $(this).children(".input_debt_detail").focus();
            }
            sum_of_inputs = +sum_of_inputs + +input_value;
            if (sum_of_inputs < min_sum_for_inputs)
            {
                sum_error = 1;
            }

            var count = 0;
            if ((new Set(set_value)).size !== set_value.length) {
                repeat_error = 1;
            }
        });
        if (error_flag == 1)
        {
            $(".ui-dialog-titlebar-close").hide();
//            $("#adddebt").hide();
            $(".error_text_debt").show();
            // $(".select_debt_detail").focus(); 
        }
        if (null_flag == 1)
        {
            $(".ui-dialog-titlebar-close").hide();
//            $("#adddebt").hide();
            $(".null_error_debt").show();
            // $(".select_debt_detail").focus(); 
        }
        if (sum_error == 1)
        {
            $(".ui-dialog-titlebar-close").hide();
            $(".error_debt_sum").show();

        }
        if (repeat_error == 1)
        {
            $(".ui-dialog-titlebar-close").hide();
//            $("#adddebt").hide();
            $(".nonrepeat_error_debt").show();
        }
        if (sum_error == 0 && null_flag == 0 && error_flag == 0 && repeat_error == 0)
        {
            $(".ui-dialog-titlebar-close").show();
            $("#adddebt").show();
            $(".error_debt_sum").hide();
            $(".null_error_debt").hide();
            $(".error_text_debt").hide();
            $(".nonrepeat_error_debt").hide();
        }
        else if (sum_error == 1 && null_flag == 0 && error_flag == 0 && repeat_error == 0)
        {
            $(".ui-dialog-titlebar-close").hide();
            $("#adddebt").show();
            //$(".error_debt_sum").hide();
            $(".null_error_debt").hide();
            $(".error_text_debt").hide();
            $(".nonrepeat_error_debt").hide();
        }
        else if (sum_error == 1 && null_flag == 0 && error_flag == 1 && repeat_error == 0)
        {
            $(".ui-dialog-titlebar-close").hide();
            //$("#adddebt").show();
            //$(".error_debt_sum").hide();
            $(".null_error_debt").hide();
            //$(".error_text_debt").hide();
            //$(".nonrepeat_error_debt").hide();
        }





    }
    var option_list_data = "";
    function debt_detail_addlist(inp, sel) {
        var eee = "<option value=''></option>";
        randomnumber = Math.random();
        for (var sel_option in option_list_data) {
            if (sel == sel_option) {
                eee = eee + '<option value="' + sel_option + '" selected="selected">' + option_list_data[sel_option] + '</option>';

            } else {
                eee = eee + '<option value="' + sel_option + '">' + option_list_data[sel_option] + '</option>';
            }
        }
        $("#dialog").append('<div style="margin-top:10px;" id="debtDetailDiv_' + randomnumber + '" class=dclass>'
                + '<a class="btn btn-xs btn-bricky tooltips" href="#"><i class="fa fa-times fa fa-white debtDetail_remove" id="icon_' + randomnumber + '"></i></a>'
                + '<select placeholder="" id="two" name="two" style="width=40px;margin-right:10px;vertical-align:top;margin-left:10px;" class="select_debt_detail" onblur="validate_all(this.value)">'
                + eee
                + '<input placeholder="" id="one" name="one" style="width=80px;margin-bottom:5px;height:20px;" class="input_debt_detail" value="' + inp + '" onkeypress="validate(event);validate_all(this.value)" onblur="validate_all(this.value)">'
                + '</select></div> ');
//         $("#adddebt").hide();
        $(".ui-dialog-titlebar-close").hide();
    }
    function debt_detail_showR()
    {
        var sum = 0;
        var x = $(".debtDetailInput_hidden").val();
        var arr = x.split(",");
        arr.shift();
        l = arr.length;
        s = l / 2;
        var text = "";
        for (var i = 0; i < s; i++)
        {
            if (created == 0)
            {
                debt_detail_addlist(arr[2 * i], arr[2 * i + 1]);
            }
            text = text + " از محل "
                    + option_list_data[arr[2 * i + 1]]
                    + "  به مبلغ "
                    + arr[2 * i]
                    + "ريال "
                    + "<br>";
            sum = +sum + +arr[2 * i];
        }
        if (created == 0)
        {
            $("#adddebt").click(function () {
                debt_detail_addlist("", "");
                $(".dclass a i").click(function () {
                    $(this).parent().parent().remove();
                });
            });
        }
        created = 1;
        $(debt_detail_showResultID).empty();
        $(debt_detail_showResultID).append(text);
        $(debt_detail_showResultID).append("  مجموع " + sum + " ريال ");
    }
    function debt_detail_createDialog()
    {
        $("#dialog").dialog();
        $(".ui-dialog-titlebar-close").click(function () {
            var input = "";
            $("#dialog .dclass").each(function () {
                input = input + ',' + $(this).children(".input_debt_detail").val() + ',' + $(this).children(".select_debt_detail").val(); // This is the jquery object of the input, do what you will
            });
            $('.debtDetailInput_hidden').val(input);
            // alert(input);
            debt_detail_showR();
            $("#dialog").dialog("destroy");
            $(".debt_detail_first_show").empty();
            //alert(sum);
        });
        debt_detail_showR();
    }
    function debt_detail_main() {

        $.ajax({
            url: "dept_detail_list.json",
            dataType: "json",
            data: "",
            success: function (data) {

                option_list_data = data;//$.parseJSON(data);
                //alert(option_list_data);
                debt_detail_createDialog();
            }
        });
    }