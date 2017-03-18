<?php

class Timely extends JalaliDate {
 
    public static function AllCalendartToGregory($date, $sep = '/', $relativeTo = null) {
        if ($relativeTo) {
            $relativeTo = time();
        }
        $date2 = $date;
		try{
        list($Y, $M, $D) = self::ExplodeGeneralDate($date2);
		}catch(Exception $ee){
		return '';	
		}
        if ($Y < 1500) { //then it is Jalali Date
            $a = self::jalali_to_gregorian($Y, $M, $D);
            $a[1]=  str_pad($a[1], 2, "0",STR_PAD_LEFT);
            $a[2]=  str_pad($a[2], 2, "0",STR_PAD_LEFT);
            return implode($sep, $a);
        } else {
            return $date2;
        }
    }

    public static function AllCalendartToJalali(&$date, $sep = '/', $relativeTo = null) {
        if (!$relativeTo) {
            $relativeTo = time();
        }
        try {
            $date2 = $date;
        } catch (Exception $exc) {
            $date2 = $date;
        }


        list($Y, $M, $D) = self::ExplodeGeneralDate($date2);
        if ($Y > 1500) { //then it is Jalali Date
            $a = self::gregorian_to_jalali($Y, $M, $D);
            $formatted = self::formatDateArray($a);
            return implode($sep, $formatted);
        } else {
            return $date2;
        }
    }

    private static function formatDateArray($dateAr) {
        if ($dateAr[1] < 10) {
            $dateAr[1] = '0' . $dateAr[1];
        }
        if ($dateAr[2] < 10) {
            $dateAr[2] = '0' . $dateAr[2];
        }
        return $dateAr;
    }

    /**
     * 
     * @param type $fromTime
     * @return type
     * * returns exploded date from string Date
     */
    private static function ExplodeGeneralDate($fromTime) {
        $fromTime = str_replace('-', '/', $fromTime);
        $jdatestr = explode(' ', $fromTime);
        $gFromParam = explode('/', $jdatestr[0]);
        if (count($gFromParam) != 3)
            throw new Exception('Date input is not valid!');
        $gY = $gFromParam[0];
        $gM = $gFromParam[1];
        $gD = $gFromParam[2];
        return array($gY, $gM, $gD);
    }





}
