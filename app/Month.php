<?php

namespace App;

class Month
{
    private static $months = [
        '01' => 'იან',
        '02' => 'თებ',
        '03' => 'მარ',
        '04' => 'აპრ',
        '05' => 'მაი',
        '06' => 'ივნ',
        '07' => 'ივლ',
        '08' => 'აგვ',
        '09' => 'სექ',
        '10' => 'ოქტ',
        '11' => 'ნოე',
        '12' => 'დეკ'
    ];

    public static function getMonthByNumberString($number)
    {
        if(isset(Month::$months[$number]))
        {
            return Month::$months[$number];
        }
        return null;
    }
}