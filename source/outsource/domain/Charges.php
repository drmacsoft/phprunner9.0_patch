<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of charges
 *
 * @author keva
 */
class Charges {

    public $error;
    private $ChargeAmount;
    private $BedehiDetail;

    function __construct($values) {
        $this->error = null;
        $this->ChargeAmount = $values['ChargeAmount'];
        $this->BedehiDetail = $values['BedehiDetail'];
    }

    function checkCharge($action) {
        $detail = $this->BedehiDetail;
        if (strlen($detail) < 10) {
            $this->error = 'خطا در جزئیات بدهی.';
            return false;
        }
        $detArray = explode(',', $detail);
        if (count($detArray) % 2 == 0) {
            $this->error = 'خطا در جزئیات بدهی.';
            return false;
        }
        //---summation check------------
        $flag = true;
        foreach ($detArray as $number) {
            if ($flag) {
                $sum+=$number;
            }
            $flag = !$flag;
        }
        if ($sum == $this->ChargeAmount) {
            $this->error = 'بدهی با جمع جزئیات تطابق ندارد.';
            return false;
        }
        //---summation check------------
        return true;
    }

}
