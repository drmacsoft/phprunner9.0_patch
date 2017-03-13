<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PersonOrig
 *
 * @author keva
 */
class PersonOrig {

    const NOT_VALID = "notValid";
    const SERVICE_UNAVAILABLE = "serviceUnavailable";
    const VALID = "valid";

    static function UpdatePersonOrig($natcode, $Year) {
        $C = new ConnectionBakedata();
        $res = $C->GetPersonInfo($natcode, $Year);
        if ($res) {
            $status = self::NOT_VALID;
            $person = null;
        } elseif (1 == 1) {
            $status = self::SERVICE_UNAVAILABLE;
            $person = null;
        } else {
            $status = self::VALID;
            $person = $res;
        }
        return [$status, $person];
    }

}
