<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of result
 *
 * @author Keva
 */
class SwichConnectionTool {

    public static function getInput($name) {
        if (!isset($_REQUEST[$name]))
            return null;

        $str = $_REQUEST[$name];
        if (self::isTest())
            return $str;
        else
            return self::hex2str($str);
    }

    public static function isTest() {
        return isset($_REQUEST['test']);
    }

    public static function timeSTD($timestamp = null) {
        if ($timestamp == null)
            $timestamp = time();
        return date("M d, Y H:i:s A", $timestamp);
    }
	
	public static function hex2str($hex) {
        $str = '';
        for ($i = 0; $i < strlen($hex); $i+=2)
            $str .= chr(hexdec(substr($hex, $i, 2)));

        return $str;
    }

    public static function strToHex($input) {
        $hex = '';
        $string = $input . '';
        for ($i = 0; $i < strlen($string); $i++) {
            if (ord($string[$i]) < 16)
                $hex .= "0";
            $hex .= dechex(ord($string[$i]));
        }
        return $hex;
    }

}

?>
