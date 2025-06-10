<?php
Class Search_library
{
    var $CI = ''; 
    function __construct()
    {
        $this->CI = & get_instance();
    }
    
    

    function getDatesFromRange($start, $end, $format = 'Y-m-d') {
        $array = array();
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

        foreach ($period as $date) {
            $array[] = $date->format($format);
        }

        return $array;
    }


    function getCondDates($date = ''){

        $str = "
            (tdw.has_sunday = floor(DAYOFWEEK('$date')) AND floor(DAYOFWEEK('$date')) != 0)
            OR
            (tdw.has_monday = floor(DAYOFWEEK('$date') - 1) AND floor(DAYOFWEEK('$date')) -1 != 0)
            OR
            (tdw.has_tuesday = floor(DAYOFWEEK('$date') - 2) AND floor(DAYOFWEEK('$date')) -2 != 0)
            OR
            (tdw.has_wednesday = floor(DAYOFWEEK('$date') - 3) AND floor(DAYOFWEEK('$date')) - 3 != 0)
            OR
            (tdw.has_thursday = floor(DAYOFWEEK('$date') - 4) AND floor(DAYOFWEEK('$date')) -4 != 0)
            OR
            (tdw.has_friday = floor(DAYOFWEEK('$date') - 5) AND floor(DAYOFWEEK('$date')) - 5 != 0)
            OR
            (tdw.has_saturday = floor(DAYOFWEEK('$date') - 6) AND floor(DAYOFWEEK('$date')) - 6 != 0)
        ";

        return $str; 
    }
    
    function getPrice(){
        $array = array(
            '300000-1000000'    => '300.000 vnđ - 1.000.000 vnđ',
            '1000000-3000000'   => '1.000.000 vnđ - 3.000.000 vnđ',
            '3000000-5000000'   => '3.000.000 vnđ - 5.000.000 vnđ',
            '5000000-10000000'  => '5.000.000 vnđ - 10.000.000 vnđ',
            '10000000-23000000' => '10.000.000 vnđ ++',    
        ); 
        
        return $array;
    }

    

    
}