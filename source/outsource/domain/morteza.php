<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of morteza
 *
 * @author keva
 */
class morteza {

    function getEzharnameGist($inp) {
        try {
            $serv = new ConnectionBakedata();
            $res = $serv->getEzharnameFromMis($inp);
            if (!$res) {
                return 'اظهارنامه یافت نشد.';
            }
            return $res;
        } catch (Exception $exc) {
            return 'استعلام اظهارنامه ممکن نیست.';
        }
    }

}
