<?php

/**
 * 
 * to use Curl and get json data from switch and other programs
 * @author kavakebi
 *
 */
class ConnectionBakedata {

    private $datapackage;
    public $timeout;
    public $hoststring;
    public $isCenter;
    public $Error;
    public $isSuccess;
    public $URL;

    function __construct() {
        //$this->hoststring = reg("link/switch/url");
        //$this->isCenter = reg('app/deploy/isCenter');
    }

    public static function SendSMS($number, $string) {
        global $globalParam;
        if (!$globalParam['sms']['Permission']) {
            var_dump($string);
            return false;
        }
        $a = new ConnectionGetdata($globalParam['sms']['URL'], array('Recipient' => $number, 'Message' => $string));
        $t = $a->getData();

        $logstr = 'Number:' . $number . "\n";
        $logstr.='Message:' . $string . "\n";
        $logstr.='FinalURL:' . $a->finalurl . "\n";

        return $t;
    }

    /**
     * 
     * @param ConnectionGetdata $getdata
     */
    private function Handle_DataError($getdata) {
        $ret = '';
        //GetData() must be in the first line
        $d = $getdata->GetData();
        //echo BR;
        //echo BR;
        $this->Error = array();
        $this->URL = $getdata->finalurl;

        if ($getdata->error) {
            $this->Error = array($getdata->error);
            $this->datapackage = null;
        } else {
            $this->Error = array();
            $this->datapackage = $d;

            if (!isset($d->isSuccess)) {
                $this->Error[] = 'bad return.';
            } elseif ($d->isSuccess == false) {
                $this->Error = array_merge($this->Error, $d->messages);
            } else {
                $ret = false;
            }
        }
        return $ret;
    }

    /**
     * returns the mojavez bargiri from exit door 
     * and registers the bazbini request for it
     * and is accessible after exit door makes the mojavez bargiri
     * (not good yet for us)
     * @param unknown_type $Cotag
     * @param unknown_type $Year
     */
    public function GetMojavezBargiriYear($Cotag, $Year) {
        $RequestArray = array(
            'kootaj' => $Cotag,
            "year" => $Year,
        );
        $c = new ConnectionGetdata($this->hoststring . "/GetMojavezBargiri", $RequestArray);
        $this->Handle_DataError($c);
    }
    
    /**
     * returns the mojavez bargiri from exit door 
     * and registers the bazbini request for it
     * and is accessible after exit door makes the mojavez bargiri
     * (not good yet for us)
     * @param unknown_type $Cotag
     * @param unknown_type $Year
     */
    public function GetPersonInfo($natcode, $Year) {
        $RequestArray = array(
            'NationalCode' => $natcode,
            'BDate' => $Year,
        );
        $c = new ConnectionGetdata($this->hoststring . "/GetPersonOrig2", $RequestArray);
        $this->Handle_DataError($c);
    }

    /**
     * returns the asyquda data
     * checks if the kootaj request with in three years if found then return else false
     * @param unknown_type $Cotag
     * @param unknown_type $Reapeat
     */
    public function GetMojavezBargiri($Cotag, $Reapeat = 3) {
        $calendar = new CalendarPlugin();
        $today = $calendar->TodayJalali();
        $todayArr = explode('-', $today);
        $year = $todayArr[0];

        $i = 0; //@todo use a constant for retry number
        while ($i++ < $Reapeat) {
            $myYear = $year - $i + 1;
            $this->GetMojavezBargiriYear($Cotag, $myYear . "");
            if ($this->Validate())
                return $myYear;
        }
        return false;
    }

    /**
     * returns parvane varedat from exit door 
     * by its serial number 
     * and is accessible when mojavez bargiri is generated
     * @param unknown_type $Serial
     */
    public function GetParvaneVaredati($Serial, $GateCode) {
        if ($this->isCenter) {
            if ($GateCode == null) {
                $this->Error[] = "کد گمرک نمی تواند خالی باشد!";
                return;
            }
            $RequestArray = array(
                'serialNumber' => $Serial,
                'src' => $GateCode
            );
            $c = new ConnectionGetdata($this->hoststring . "/GetParvanehVaredati", $RequestArray);
        } else {
            $RequestArray = array(
                'serial' => $Serial,
            );
            $c = new ConnectionGetdata($this->hoststring . "/GetParvanehVaredati", $RequestArray);
        }
        $this->Handle_DataError($c);
    }

    public function GetParvane($Serial) {
        $RequestArray = array(
            'serial' => $Serial,
            'check' => 'false'
        );
        $c = new ConnectionGetdata(reg("link/taval") . "/CheckParvaneh", $RequestArray);
        $this->Handle_DataError($c);
    }

    /**
     * 
     */
    public function SendEvent($eventid, $desc, $url, $userid, $ip, $params) {
        $p = array(
            'eventId' => $eventid . '',
            'description' => $desc,
            'url' => $url,
            'userId' => $userid,
            'date' => ConnectionTool::timeSTD(),
            'ip' => $ip,
            'Ids' => $params,
        );
        $RequestArray = array(
            'event' => json_encode($p, 256),
        );
        $c = new ConnectionGetdata($this->hoststring . "/AddEvent", $RequestArray);
        $this->Handle_DataError($c);
    }

    public function checkBedehi($Coding) {
        global $globalParam;
        $RequestArray = array(
            'Coding' => $Coding
        );
        $c = new ConnectionGetdata($globalParam['made7url'] . 'GetPersonDebt.php', $RequestArray);
        $this->Handle_DataError($c);
    }

    public function checkVekalat($EzharkonCoding, $BrokerCoding, $SahebCoding, $GomrokCode, $Ravie) {
        global $globalParam;
        $RequestArray = array(
            'EzharkonCoding' => $EzharkonCoding,
            'BrokerCoding' => $BrokerCoding,
            'SahebCoding' => $SahebCoding,
            'GomrokCode' => $GomrokCode,
            'Ravie' => $Ravie,
        );
        $c = new ConnectionGetdata($globalParam['myUrl'] . 'CheckThreeCoding', $RequestArray);
        $this->Handle_DataError($c);
    }

    public function getEzharnameFromMis($inp) {
        global $globalParam;
        $RequestArray = array(
            'inp' => $inp,
        );
        $c = new ConnectionGetdata($globalParam['url']['mis'] . '/detail/GetEzharnameForEhraz', $RequestArray);
        $c->InputFormat = '';
        $c->OutputFormat = '';
        return $c->GetData();
    }

    public function GetBizcards($lastid = null) {
        global $globalParam;
        if ($lastid) {
            $RequestArray = array(
                'lastid' => $lastid
            );
        } else {
            $RequestArray = array();
        }
        $c = new ConnectionGetdata($globalParam['made7url'] . 'GetBizcards.php', $RequestArray);
        $this->Handle_DataError($c);
    }

    public function BizcardPersistInError($serial, $errorCode, $errorDesc) {
        global $globalParam;
        $RequestArray = array(
            'serial' => $serial,
            'errorCode' => $errorCode,
            'errorDesc' => $errorDesc,
        );
        $c = new ConnectionGetdata($globalParam['made7url'] . 'BizcardPersistInError.php', $RequestArray);
        $this->Handle_DataError($c);
    }

    public function BizcardDelete($serial) {
        global $globalParam;
        $RequestArray = array(
            'serial' => $serial,
        );
        $c = new ConnectionGetdata($globalParam['made7url'] . 'BizcardDelete.php', $RequestArray);
        $this->Handle_DataError($c);
    }

    /**
     * 
     * @param AbrivFile $abrivFile
     */
    public function SendToCenter($abrivFile) {
        $RequestArray = array(
            'taskId' => 'add',
            //256=JSON_UNESCAPED_UNICODE
            'Object' => json_encode($abrivFile, 256),
            'type' => 'ir.customs.shared.bazbini.File',
            'sid' => 'BAZBINI_FILE',
        );
        $c = new ConnectionGetdata($this->hoststring . "/Sender", $RequestArray);
        $c->POSTorGET = 'POST';
        $this->Handle_DataError($c);
    }

    /**
     * /GetBijaks_Entrance    {kootaj} : List<VorudeEttelaatDarbeKhorujVaredat>
     * @param unknown_type $Serial
     */
    public function GetBijaks_Entrance($Serial) {
        $RequestArray = array(
            'kootaj' => $Serial,
        );
        $c = new ConnectionGetdata($this->hoststring . "/GetBijaks_Entrance", $RequestArray);
        $this->Handle_DataError($c);
    }

    public function Validate() {
        return ($this->Error == null);
    }

    public function GetResult() {
        if ($this->Validate()) {
            return $this->datapackage->result;
        }
        return false;
    }

    public function GetMessages() {
        if ($this->Validate()) {
            if (isset($this->datapackage->messages))
                return $this->datapackage->messages;
        }
        return null;
    }

}
