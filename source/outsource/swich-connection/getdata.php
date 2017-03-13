<?php

/**
 * 
 * to use Curl and get json data from switch and other programs
 * @author kavakebi
 *
 */
class ConnectionGetdata {

    public $url;
    public $finalurl;
    private $RequestArray;
    public $timeout;
    public $error;
    public $InputFormat;
    public $OutputFormat;
    public $POSTorGET;

    function __construct($url, $RequestArray, $InputFormat = 'hex') {
        $this->url = $url;
        $this->RequestArray = $RequestArray;
        $this->timeout = 2;
        $this->error = null;
        $this->InputFormat = $InputFormat;
        $this->OutputFormat = 'hex';
        $this->POSTorGET = 'GET';
    }

    public function GetData() {
        list($url, $postData) = $this->make_url();
        $rawdata = $this->get_data($url, $postData);
        if ($this->OutputFormat == 'hex') {
            $json = SwichConnectionTool::hex2str($rawdata);
        } else {
            $json = $rawdata;
        }
        $ret = json_decode($json);
        $this->log($url, $ret);
        return $ret;
    }

    private function log($url, $ret) {
        return 0;
        $str = '********' . "\n";
        $str.='URL: ' . $url . "\n";
        $str.='INP: ' . print_r($this->RequestArray, true) . "\n";
        $str.='ANS: ' . print_r($ret, true) . "\n";
        file_put_contents('log/servicecall.txt', $str, FILE_APPEND);
    }

    private function make_url() {
        $req = array();
        foreach ($this->RequestArray as $par => $val) {
            if ($this->InputFormat == 'hex') {
                $FormattedValue = SwichConnectionTool::strToHex($val);
            } else {
                $FormattedValue = $val;
            }
            $req[] = $par . "=" . $FormattedValue;
        }

        $req = implode('&', $req);
        $dataStr = (count($this->RequestArray) ? $req : null);
        if ($this->POSTorGET == 'GET') {
            $url = $this->url . ($dataStr ? "?" . $dataStr : '');
            $postData = null;
        } else {
            $url = $this->url;
            $postData = $dataStr;
        }
        $this->finalurl = $url;
        return array($url, $postData);
    }

    /* gets the data from a URL */

    private function get_data($url, $postData = null) {
        //echo $url;
        $ret = null;
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        if ($postData) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_POST, 1);
        }

        $data = curl_exec($ch);
        if ($data === false) {
            $this->error = curl_error($ch);
            $ret = false;
        } else {
            $ret = $data;
        }
        curl_close($ch);
        return $ret;
    }

}
