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
class SwichConnectionResult {

    public $isSuccess;
    public $Result;
    public $messages;
    public $hasResult = true;

    public function __construct($isSuccess, $messages = null, $Result = null) {
        $this->isSuccess = $isSuccess;
        $this->messages = $messages;
        $this->Result = $Result;
    }

    public function tostring() {
        $mes = $this->messages;
        if ($mes AND ! is_array($mes)) {
            $mes = array($mes);
        }
        $ar = array('result' => $this->Result,
            'isSuccess' => $this->isSuccess,
            'messages' => $mes);
        if (!$this->hasResult) {
            unset($ar['result']);
        }
        $str = $this->raw_json_encode($ar);
        $this->log($str);
        if (SwichConnectionTool::isTest()) {
            return $str;
        } else {
            return SwichConnectionTool::strToHex($str);
        }
//        return strtoupper(SwichConnectionTool::strToHex($str));
    }

    function actionDie() {
        echo $this->tostring();
        die();
    }

    function raw_json_encode($input) {

        return preg_replace_callback(
                '/\\\\u([0-9a-zA-Z]{4})/', function ($matches) {
            return mb_convert_encoding(pack('H*', $matches[1]), 'UTF-8', 'UTF-16');
        }, json_encode($input)
        );
    }

    public function log($str) {
        Log4Service::FinalizeLog($str);
    }

}

?>
