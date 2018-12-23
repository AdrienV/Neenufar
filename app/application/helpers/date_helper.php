<?php

/**
 * Change une date BDD en date FR
 * 
 * @param datetime $date
 * @param int $segment 1/2/3
 * @param bool $deleteZero delete les zero pour JS
 * @param bool $forJS pour le JS
 * @return date FR
 */
function dateBDD_to_FR($date, $segment = 3, $deleteZero = false, $forJS = false, $withTime = false) {
    if ($date) {
        $date = explode(' ', $date);
        $time = isset($date[1]) ? $date[1] : '00:00:00';
        $date = explode('-', $date[0]);

        $zeroTab = array('01', '02', '03', '04', '05', '06', '07', '08', '09');
        
        if($forJS == false) {
        return ($deleteZero == true ? (in_array($date[2], $zeroTab) !== false ? substr($date[2], 1) : $date[2]) : $date[2]) . '/' . ($deleteZero == true ? (in_array($date[1], $zeroTab) !== false ? substr($date[1], 1) : $date[1]) : $date[1]) . '/' . $date[0].($withTime == true ? ' '.$time : '');
        } else {
         return ($deleteZero == true ? (in_array($date[1], $zeroTab) !== false ? substr($date[1], 1) : $date[1]) : $date[1]) . '/' . ($deleteZero == true ? (in_array($date[2], $zeroTab) !== false ? substr($date[2], 1) : $date[2]) : $date[2]) . '/' . $date[0].($withTime == true ? ' '.$time : '');
        }
    } else {
        return null;
    }
}

/**
 * Change une date FR vers une date Bdd
 * 
 * @param date $date
 * @param bool $deleteZero delete les zero pour JS
 * @return date Bdd
 */
function dateFR_to_BDD($date, $deleteZero = false, $inverse = false) {
    if ($date) {
        $date = explode('/', $date);

        $zeroTab = array('01', '02', '03', '04', '05', '06', '07', '08', '09');
        
        return ($deleteZero == true ? (in_array($date[2], $zeroTab) !== false ? substr($date[2], 1) : $date[2]) : $date[2]) . '-' . ($deleteZero == true ? (in_array($date[1], $zeroTab) !== false ? substr($date[1], 1) : $date[1]) : $date[1]) . '-' . $date[0];
    } else {
        return null;
    }
}

/**
 * Nombre de jours entre 2 dates
 * 
 * @param date $debut
 * @param date $fin
 * @return int
 */
function dateDiff($debut, $fin, $nbSecondes = null, $precision = 0) {
    //60 secondes X 60 minutes X 24 heures dans une journée
    if($nbSecondes == null) {
        $nbSecondes = 60 * 60 * 24;
    } 

    $debut_ts = strtotime($debut);
    $fin_ts = strtotime($fin);
    $diff = $fin_ts - $debut_ts;
    return round($diff / $nbSecondes, $precision);
}

function getAllMonths($month = 'all') {
    $months = array('01' => 'Janvier', '02' => 'Février', '03' => 'Mars', '04' => 'Avril', '05' => 'Mai', '06' => 'Juin', '07' => 'Juillet', '08' => 'Aout', '09' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre');
    
    if($month == 'all') {
        return $months;
    } else {
        return $months[$month];
    }
}


function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
