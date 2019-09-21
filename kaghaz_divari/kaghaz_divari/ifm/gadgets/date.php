<?php

namespace f\g ;

class date
{

    var $Day ;
    var $Month ;
    var $Year ;
    private $weekday = array (
        'Sunday'    => 'یک شنبه',
        'Monday'    => 'دوشنبه',
        'Tuesday'   => 'سه شنبه',
        'Wednesday' => 'چهارشنبه',
        'Thursday'  => 'پنج شنبه',
        'Friday'    => 'جمعه',
        'Saturday'  => 'شنبه' ) ;

    public function __construct ()
    {

        //parent::__construct () ;
    }

    //--------------------------------------------------------------------------
    public function dateHiToGr ( $date, $format )
    { // $date like 10121400, $format like DDMMYYYY, take date & check if its hijri then convert to gregorian date in format (DD-MM-YYYY), if it gregorian the return empty;
        $this->ConstractDayMonthYear ( $date, $format ) ;

        $d = intval ( $this->Day ) ;
        $m = intval ( $this->Month ) ;
        $y = intval ( $this->Year ) ;

        if ( $y < 1700 )
        {

            $jd = $this->intPart ( (11 * $y + 3) / 30 ) + 354 * $y + 30 * $m - $this->intPart ( ($m - 1) / 2 ) + $d + 1948440 - 385 ;

            if ( $jd > 2299160 )
            {
                $l = $jd + 68569 ;
                $n = $this->intPart ( (4 * $l) / 146097 ) ;
                $l = $l - $this->intPart ( (146097 * $n + 3) / 4 ) ;
                $i = $this->intPart ( (4000 * ($l + 1)) / 1461001 ) ;
                $l = $l - $this->intPart ( (1461 * $i) / 4 ) + 31 ;
                $j = $this->intPart ( (80 * $l) / 2447 ) ;
                $d = $l - $this->intPart ( (2447 * $j) / 80 ) ;
                $l = $this->intPart ( $j / 11 ) ;
                $m = $j + 2 - 12 * $l ;
                $y = 100 * ($n - 49) + $i + $l ;
            }
            else
            {
                $j = $jd + 1402 ;
                $k = $this->intPart ( ($j - 1) / 1461 ) ;
                $l = $j - 1461 * $k ;
                $n = $this->intPart ( ($l - 1) / 365 ) - $this->intPart ( $l / 1461 ) ;
                $i = $l - 365 * $n + 30 ;
                $j = $this->intPart ( (80 * $i) / 2447 ) ;
                $d = $i - $this->intPart ( (2447 * $j) / 80 ) ;
                $i = $this->intPart ( $j / 11 ) ;
                $m = $j + 2 - 12 * $i ;
                $y = 4 * $k + $n + $i - 4716 ;
            }

            if ( $d < 10 ) $d = "0" . $d ;

            if ( $m < 10 ) $m = "0" . $m ;

            return $d . "-" . $m . "-" . $y ;
        }
        else return "" ;
    }

    //--------------------------------------------------------------------------
    public function dateGrToJa ( $date, $format, $returnTime = false,
                                 $delimiter = '-' )
    {

        /** check time part * */
        $date_en = explode ( ' ', $date ) ;/** space is mysql standart delimiter between date and time * */
        $time    = '00:00:00' ;
        if ( count ( $date_en ) == 2 )
        {
            $time = $date_en[ 1 ] ;
        }
        $date_en = $date_en[ 0 ] ;

        /** extract year/month/day * */
        $date_en = explode ( '/', $date ) ;
        if ( count ( $date_en ) == 1 ) $date_en = explode ( '-', $date ) ;

        $date_fa = $this->gregorian_to_jalali ( $date_en[ 0 ], $date_en[ 1 ],
                                                $date_en[ 2 ] ) ;
        if ( $format == 0 )
        { /** Added by mahdian * */
            $Maindate = intval ( $date_fa[ 0 ] ) . $delimiter . intval ( $date_fa[ 1 ] ) . $delimiter . intval ( $date_fa[ 2 ] ) ;
            if ( $returnTime ) $Maindate .= ' ' . $time ;
        }
        if ( $format == 1 )
        {
            $Maindate = $date_fa[ 0 ] . '/' . $date_fa[ 1 ] . '/' . $date_fa[ 2 ] ;
            if ( $returnTime ) $Maindate .= ' ' . $time ;
        }
        if ( $format == 2 )
        {
            $date_fa  = $this->formated_j_date ( $date_fa[ 0 ], $date_fa[ 1 ],
                                                 $date_fa[ 2 ] ) ;
            $Maindate = $date_fa[ 2 ] . ' ' . $date_fa[ 1 ] . ' ' . $date_fa[ 0 ] ;
            if ( $returnTime ) $Maindate .= ' ' . $time ;
        }


        return $Maindate ;
    }

    //--------------------------------------------------------------------------
    public function dateGrToHi ( $date, $format )
    { // $date like 10122011, $format like DDMMYYYY, take date & check if its gregorian then convert to hijri date in format (DD-MM-YYYY), if it hijri the return empty;
        //$this->ConstractDayMonthYear ( $date, $format ) ;
        $dateArr = explode ( '/', $date ) ;
        $d       = intval ( $dateArr[ 2 ] ) ;
        $m       = intval ( $dateArr[ 1 ] ) ;
        $y       = intval ( $dateArr[ 0 ] ) ;

        //echo $y;

        if ( $y > 1700 )
        {
            if ( ($y > 1582) || (($y == 1582) && ($m > 10)) || (($y == 1582) && ($m == 10) && ($d > 14)) )
            {
                $jd = $this->intPart ( (1461 * ($y + 4800 + $this->intPart ( ($m - 14) / 12 ))) / 4 ) + $this->intPart ( (367 * ($m - 2 - 12 * ($this->intPart ( ($m - 14) / 12 )))) / 12 ) - $this->intPart ( (3 * ($this->intPart ( ($y + 4900 + $this->intPart ( ($m - 14) / 12 )) / 100 ))) / 4 ) + $d - 32075 ;
            }
            else
            {
                $jd = 367 * $y - $this->intPart ( (7 * ($y + 5001 + $this->intPart ( ($m - 9) / 7 ))) / 4 ) + $this->intPart ( (275 * $m) / 9 ) + $d + 1729777 ;
            }

            $l = $jd - 1948440 + 10632 ;
            $n = $this->intPart ( ($l - 1) / 10631 ) ;
            $l = $l - 10631 * $n + 354 ;
            $j = ($this->intPart ( (10985 - $l) / 5316 )) * ($this->intPart ( (50 * $l) / 17719 )) + ($this->intPart ( $l / 5670 )) * ($this->intPart ( (43 * $l) / 15238 )) ;
            $l = $l - ($this->intPart ( (30 - $j) / 15 )) * ($this->intPart ( (17719 * $j) / 50 )) - ($this->intPart ( $j / 16 )) * ($this->intPart ( (15238 * $j) / 43 )) + 29 ;
            $m = $this->intPart ( (24 * $l) / 709 ) ;
            $d = $l - $this->intPart ( (709 * $m) / 24 ) ;
            $y = 30 * $n + $j - 30 ;

            if ( $d < 10 ) $d = "0" . $d ;

            if ( $m < 10 ) $m = "0" . $m ;

            return $d . "-" . $m . "-" . $y ;
        }
        else return "" ;
    }

    //--------------------------------------------------------------------------
    public function dateJaToGr ( $date, $format, $returnTime = false )
    {
//pr($date);
        /** check time part * */
        $date_fa = explode ( ' ', $date ) ;/** space is mysql standart delimiter between date and time * */
        $time    = '00:00:00' ;
        if ( count ( $date_fa ) == 2 )
        {
            $time = $date_fa[ 1 ] ;
        }
        $date_fa = $date_fa[ 0 ] ;

        /** extract year/month/day * */
        $date_fa = explode ( '/', $date ) ;
        if ( count ( $date_fa ) == 1 ) $date_fa = explode ( '-', $date ) ;


        $date_en = $this->jalali_to_gregorian ( $date_fa[ 0 ], $date_fa[ 1 ],
                                                $date_fa[ 2 ] ) ;

        if ( $format == 0 )
        { /** Added by mahdian * */
            $Maindate = $date_en[ 0 ] . '-' . $date_en[ 1 ] . '-' . $date_en[ 2 ] ;
            if ( $returnTime ) $Maindate .= ' ' . $time ;
        }
        if ( $format == 1 )
        {
            $Maindate = $date_en[ 0 ] . '/' . $date_en[ 1 ] . '/' . $date_en[ 2 ] ;
            if ( $returnTime ) $Maindate .= ' ' . $time ;
        }
        if ( $format == 2 )
        {
            $date_en  = $this->formated_j_date2 ( $date_en[ 0 ], $date_en[ 1 ],
                                                  $date_en[ 2 ] ) ;
            $Maindate = $date_en[ 2 ] . ' ' . $date_en[ 1 ] . ' ' . $date_en[ 0 ] ;
            if ( $returnTime ) $Maindate .= ' ' . $time ;
        }
        if ( $format == 3 )
        {
            $date_en  = $this->formated_j_date3 ( $date_en[ 0 ], $date_en[ 1 ],
                                                  $date_en[ 2 ] ) ;
            $Maindate = $date_en[ 2 ] . ' ' . $date_en[ 1 ] . ' ' . $date_en[ 0 ] ;
            if ( $returnTime ) $Maindate .= ' ' . $time ;
        }

        return $Maindate ;
    }

    //==========================================================================
    private function div ( $a, $b )
    {
        return ( int ) ($a / $b) ;
    }

    //==========================================================================
    public function formated_j_date ( $j_y, $j_m, $j_d )
    {
        $month = array (
            'فروردین',
            'اردیبهشت',
            'خرداد',
            'تیر',
            'مرداد',
            'شهریور',
            'مهر',
            'آبان',
            'آذر',
            'دی',
            'بهمن',
            'اسفند' ) ;
        return array (
            $j_y,
            $month[ $j_m - 1 ],
            $j_d ) ;
    }

    //==========================================================================
    private function formated_j_date2 ( $j_y, $j_m, $j_d )
    {
        $month = array (
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December' ) ;
        return array (
            $j_y,
            $month[ $j_m - 1 ],
            $j_d ) ;
    }

    //==========================================================================
    private function formated_j_date3 ( $j_y, $j_m, $j_d )
    {
        $month = array (
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec' ) ;
        return array (
            $j_y,
            $month[ $j_m - 1 ],
            $j_d ) ;
    }

    //==========================================================================
    public function parse_date ( $date )
    {
        $ar[ 0 ] = $date[ 0 ] . $date[ 1 ] . $date[ 2 ] . $date[ 3 ] ;
        $ar[ 1 ] = $date[ 4 ] . $date[ 5 ] ;
        $ar[ 2 ] = $date[ 6 ] . $date[ 7 ] ;
        return $ar ;
    }

    //==========================================================================
    private function intPart ( $floatNum )
    {
        if ( $floatNum < -0.0000001 )
        {
            return ceil ( $floatNum - 0.0000001 ) ;
        }
        return floor ( $floatNum + 0.0000001 ) ;
    }

    //==========================================================================
    private function ConstractDayMonthYear ( $date, $format )
    { // extract day, month, year out of the date based on the format.
        $this->Day   = "" ;
        $this->Month = "" ;
        $this->Year  = "" ;

        $format    = strtoupper ( $format ) ;
        $format_Ar = str_split ( $format ) ;
        //\f\pr($format_Ar);

        $srcDate_Ar = str_split ( $date ) ;

        for ( $i = 0 ; $i < count ( $format_Ar ) ; $i ++ )
        {

            switch ( $format_Ar[ $i ] )
            {
                case "D":
                    $this->Day   .= $srcDate_Ar[ $i ] ;
                    break ;
                case "M":
                    $this->Month .= $srcDate_Ar[ $i ] ;
                    break ;
                case "Y":
                    $this->Year  .= $srcDate_Ar[ $i ] ;
                    break ;
            }
        }
    }

    //==========================================================================
    private function gregorian_to_jalali ( $g_y, $g_m, $g_d )
    {
        $g_days_in_month = array (
            31,
            28,
            31,
            30,
            31,
            30,
            31,
            31,
            30,
            31,
            30,
            31 ) ;
        $j_days_in_month = array (
            31,
            31,
            31,
            31,
            31,
            31,
            30,
            30,
            30,
            30,
            30,
            29 ) ;

        $gy       = $g_y - 1600 ;
        $gm       = $g_m - 1 ;
        $gd       = $g_d - 1 ;
        $g_day_no = 365 * $gy + $this->div ( $gy + 3, 4 ) - $this->div ( $gy + 99,
                                                                         100 ) + $this->div ( $gy + 399,
                                                                                              400 ) ;
        for ( $i = 0 ; $i < $gm ; ++ $i ) $g_day_no += $g_days_in_month[ $i ] ;
        if ( $gm > 1 && (($gy % 4 == 0 && $gy % 100 != 0) || ($gy % 400 == 0)) )
                $g_day_no ++ ;
        $g_day_no += $gd ;
        $j_day_no = $g_day_no - 79 ;
        $j_np     = $this->div ( $j_day_no, 12053 ) ;
        $j_day_no = $j_day_no % 12053 ;
        $jy       = 979 + 33 * $j_np + 4 * $this->div ( $j_day_no, 1461 ) ;
        $j_day_no %= 1461 ;
        if ( $j_day_no >= 366 )
        {
            $jy       += $this->div ( $j_day_no - 1, 365 ) ;
            $j_day_no = ($j_day_no - 1) % 365 ;
        }
        for ( $i = 0 ; $i < 11 && $j_day_no >= $j_days_in_month[ $i ] ; ++ $i )
                $j_day_no -= $j_days_in_month[ $i ] ;
        $jm       = $i + 1 ;
        $jd       = $j_day_no + 1 ;
        $jd       = ($jd < 10) ? '0' . $jd : $jd ;
        $jm       = ($jm < 10) ? '0' . $jm : $jm ;

        return array (
            $jy,
            $jm,
            $jd ) ;
    }

    //==========================================================================
    private function jalali_to_gregorian ( $j_y, $j_m, $j_d )
    {
        $g_days_in_month = array (
            31,
            28,
            31,
            30,
            31,
            30,
            31,
            31,
            30,
            31,
            30,
            31 ) ;
        $j_days_in_month = array (
            31,
            31,
            31,
            31,
            31,
            31,
            30,
            30,
            30,
            30,
            30,
            29 ) ;
        $jy              = $j_y - 979 ;
        $jm              = $j_m - 1 ;
        $jd              = $j_d - 1 ;
        $j_day_no        = 365 * $jy + $this->div ( $jy, 33 ) * 8 + $this->div ( $jy % 33 + 3,
                                                                                 4 ) ;
        for ( $i = 0 ; $i < $jm ; ++ $i ) $j_day_no        += $j_days_in_month[ $i ] ;
        $j_day_no        += $jd ;
        $g_day_no        = $j_day_no + 79 ;
        $gy              = 1600 + 400 * $this->div ( $g_day_no, 146097 ) ; /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
        $g_day_no        = $g_day_no % 146097 ;
        $leap            = true ;
        if ( $g_day_no >= 36525 ) /* 36525 = 365*100 + 100/4 */
        {
            $g_day_no -- ;
            $gy       += 100 * $this->div ( $g_day_no, 36524 ) ; /* 36524 = 365*100 + 100/4 - 100/100 */
            $g_day_no = $g_day_no % 36524 ;

            if ( $g_day_no >= 365 ) $g_day_no ++ ;
            else $leap = false ;
        }
        $gy       += 4 * $this->div ( $g_day_no, 1461 ) ; /* 1461 = 365*4 + 4/4 */
        $g_day_no %= 1461 ;
        if ( $g_day_no >= 366 )
        {
            $leap     = false ;
            $g_day_no -- ;
            $gy       += $this->div ( $g_day_no, 365 ) ;
            $g_day_no = $g_day_no % 365 ;
        }
        for ( $i = 0 ; $g_day_no >= $g_days_in_month[ $i ] + ($i == 1 && $leap) ; $i ++ )
                $g_day_no -= $g_days_in_month[ $i ] + ($i == 1 && $leap) ;
        $gm       = $i + 1 ;
        $gd       = $g_day_no + 1 ;
        $gd       = ($gd < 10) ? '0' . $gd : $gd ;
        $gm       = ($gm < 10) ? '0' . $gm : $gm ;
        return array (
            $gy,
            $gm,
            $gd ) ;
    }

    //PART 2
    //--------------------------------------------------------------------------
    public function dateTotime ( $date, $type )
    {

        if ( $type == 2 )
        {
            $date = $this->dateJaToGr ( $date, 1 ) ;
        }
        if ( $type == 3 )
        {
            $date = $this->dateHiToGr ( $date, 'YYYY/MM/DD' ) ;
        }

        $time = strtotime ( $date ) ;
        return $time ;
    }

    //--------------------------------------------------------------------------
    public function todayDateGr ()
    {


        $array = $this->parse_date ( date ( 'Ymd' ) ) ;
        $date  = $this->gregorian_to_jalali ( $array[ 0 ], $array[ 1 ],
                                              $array[ 2 ] ) ;
        //------------------------------------------------------------
        $day   = $array[ 2 ] ;
        $month = $array[ 1 ] ;
        $year  = $array[ 0 ] ;

        $date1 = $this->formated_j_date2 ( $year, $month, $day ) ;


        return date ( 'l' ) . ' ، ' . $date1[ 2 ] . ' ' . $date1[ 1 ] . ' ' . $date1[ 0 ] ;
    }

    //--------------------------------------------------------------------------
    public function todayDate ()
    {


        $array = $this->parse_date ( date ( 'Ymd' ) ) ;
        $date  = $this->gregorian_to_jalali ( $array[ 0 ], $array[ 1 ],
                                              $array[ 2 ] ) ;
        //------------------------------------------------------------
        $day   = $date[ 2 ] ;
        $month = $date[ 1 ] ;
        $year  = $date[ 0 ] ;

        $date1 = $this->formated_j_date ( $year, $month, $day ) ;


        return $this->weekday[ date ( 'l' ) ] . ' ، ' . $date1[ 2 ] . ' ' . $date1[ 1 ] . ' ' . $date1[ 0 ] ;
    }

    //--------------------------------------------------------------------------
    public function today ()
    {


        $array   = $this->parse_date ( date ( 'Ymd' ) ) ;
        $date_fa = $this->gregorian_to_jalali ( $array[ 0 ], $array[ 1 ],
                                                $array[ 2 ] ) ;

        $Maindate = $date_fa[ 0 ] . '/' . $date_fa[ 1 ] . '/' . $date_fa[ 2 ] ;
        return $Maindate ;
    }

    //--------------------------------------------------------------------------
    public function dateTime ( $time, $type )
    {
        if ( $type == 1 )
        {
            $date = date ( 'Y/m/d', $time ) ;
        }
        if ( $type == 2 )
        {
            $date1 = date ( 'Y/m/d', $time ) ;
            $date  = $this->dateGrToJa ( $date1, 1 ) ;
        }
        if ( $type == 3 )
        {
            $date1 = date ( 'Y/m/d', $time ) ;
            $date  = $this->dateGrToHi ( $date1, "YYYY/MM/DD" ) ;
        }

        return $date ;
    }

    //--------------------------------------------------------------------------
    public function timeDate ( $date, $type )
    {
        if ( $type == 1 )
        {
            $time = strtotime ( $date ) ;
        }
        if ( $type == 2 )
        {
            $date = $this->dateJaToGr ( $date, 1 ) ;
            $time = strtotime ( $date ) ;
        }
        if ( $type == 3 )
        {
            $date = $this->dateHiToGr ( $date, "YYYY/MM/DD" ) ;
            $time = strtotime ( $date ) ;
        }

        return $time ;
    }

    //--------------------------------------------------------------------------
    public function numDay ( $d1, $d2 )
    {

        $d1Fa  = explode ( '/', $d1 ) ;
        $d1En  = $this->jalali_to_gregorian ( $d1Fa[ 0 ], $d1Fa[ 1 ], $d1Fa[ 2 ] ) ;
        $time1 = strtotime ( $d1En[ 0 ] . '-' . $d1En[ 1 ] . '-' . $d1En[ 2 ] ) ;

        $d2Fa  = explode ( '/', $d2 ) ;
        $d2En  = $this->jalali_to_gregorian ( $d2Fa[ 0 ], $d2Fa[ 1 ], $d2Fa[ 2 ] ) ;
        $time2 = strtotime ( $d2En[ 0 ] . '-' . $d2En[ 1 ] . '-' . $d2En[ 2 ] ) ;


        return ($time2 - $time1) / (3600 * 24) ;
    }

    //--------------------------------------------------------------------------
    public function getRange ( $params )
    {
        date_default_timezone_set ( "Asia/Tehran" ) ;

        if ( $params[ 'range' ] == 'day' )
        {
            return $this->dayRange ( $params ) ;
        }

        if ( $params[ 'range' ] == 'week' )
        {
            return $this->weekRange ( $params ) ;
        }

        if ( $params[ 'range' ] == 'month' )
        {
            return $this->monthRange ( $params ) ;
        }

        if ( $params[ 'range' ] == 'year' )
        {
            return $this->yearRange ( $params ) ;
        }

        if ( $params[ 'range' ] == 'years' )
        {
            return $this->yearsRange ( $params ) ;
        }
    }

    private function dayRange ( $params )
    {
        $params[ 'groupBy' ] = "'%Y/%m/%d %H'" ;
        $params[ 'minTime' ] = date ( 'Y-m-d' ) . ' 00:00:00' ;
        $params[ 'maxTime' ] = date ( 'Y-m-d' ) . ' 23:59:59' ;

        return $params ;
    }

    private function monthRange ( $params )
    {
        $todayJaArray = explode ( '/', $this->dateGrToJa ( date ( 'Y-m-d' ), 1 ) ) ;

        if ( $todayJaArray[ 1 ] == '12' )
        {
            $nextMonthDay = $todayJaArray[ 1 ] . '-29' ;
        }
        else
        {
            $nextMonthDay = $todayJaArray[ 1 ] + 1 ;
        }

        $params[ 'minTime' ] = $this->dateJaToGr ( $todayJaArray[ 0 ] . '-' . $todayJaArray[ 1 ] . '-01',
                                                   1 ) . ' 00:00:00' ;
        $params[ 'maxTime' ] = $this->dateJaToGr ( $todayJaArray[ 0 ] . '-' . $nextMonthDay,
                                                   1 ) . ' 00:00:00' ;
        $params[ 'groupBy' ] = "'%Y/%m/%d'" ;

        return $params ;
    }

    private function weekRange ( $params )
    {
        $firstWeek = new \DateTime ( date ( 'Y-m-d',
                                            strtotime ( 'Sunday last week' ) ) ) ;
        $lastWeek  = new \DateTime ( date ( 'Y-m-d',
                                            strtotime ( 'Sunday last week' ) ) ) ;
        $minTime   = $firstWeek->modify ( "- 1 day" ) ;
        $maxTime   = $lastWeek->modify ( "+ 6 day" ) ;

        $params[ 'minTime' ] = $minTime->format ( 'Y-m-d H:i:s' ) ;
        $params[ 'maxTime' ] = $maxTime->format ( 'Y-m-d H:i:s' ) ;

        $params[ 'groupBy' ] = "'%Y/%m/%d'" ;

        return $params ;
    }

    private function yearRange ( $params )
    {
        $todayJaArray = explode ( '/', $this->dateGrToJa ( date ( 'Y-m-d' ), 1 ) ) ;

        $params[ 'minTime' ] = $this->dateJaToGr ( $todayJaArray[ 0 ] . '-01-01',
                                                   1 ) . ' 00:00:00' ;
        $params[ 'maxTime' ] = $this->dateJaToGr ( $todayJaArray[ 0 ] + 1 . '-01-01',
                                                   1 ) . ' 00:00:00' ;
        $params[ 'groupBy' ] = "'%Y/%m'" ;

        return $params ;
    }

    public function yearsRange ( $params )
    {
        $todayJaArray = explode ( '/', $this->dateGrToJa ( date ( 'Y-m-d' ), 1 ) ) ;

        $params[ 'minTime' ] = $this->dateJaToGr ( $todayJaArray[ 0 ] - 10 . '-01-01',
                                                   1 ) . ' 00:00:00' ;
        $params[ 'maxTime' ] = $this->dateJaToGr ( $todayJaArray[ 0 ] . '-12-29',
                                                   1 ) . ' 00:00:00' ;

        $params[ 'groupBy' ] = "'%Y'" ;

        return $params ;
    }

    public function secondsToTime ( $inputSeconds, $format = 1 )
    {
        if ( $format == 1 )
        {
            $then = new \DateTime ( date ( 'Y-m-d H:i:s', $inputSeconds ) ) ;
            $now  = new \DateTime ( date ( 'Y-m-d H:i:s', time () ) ) ;
            $diff = $then->diff ( $now ) ;

            $diffArray = array (
                'years'   => $diff->y,
                'months'  => $diff->m,
                'days'    => $diff->d,
                'hours'   => $diff->h,
                'minutes' => $diff->i,
                'seconds' => $diff->s ) ;

            foreach ( $diffArray AS $key => $val )
            {
                if ( $val )
                {
                    return array (
                        'key' => $key,
                        'val' => $val ) ;
                }
            }
        }
        else
        {
            $then = new \DateTime ( date ( 'Y-m-d H:i:s', $inputSeconds ) ) ;
            $now  = new \DateTime ( date ( 'Y-m-d H:i:s', time () ) ) ;
            $diff = $then->diff ( $now ) ;



            $diffArray = array (
                'years'   => $diff->y,
                'months'  => $diff->m,
                'days'    => $diff->d,
                'hours'   => $diff->h,
                'minutes' => $diff->i,
                'seconds' => $diff->s ) ;

            if ( $diff->y > 0 || $diff->m > 0 || $diff->d > 6 )
            {
                $date = $this->dateGrToJa ( date ( 'Y/m/d', $inputSeconds ), 2 ) ;
                return $date ;
            }
            else
            {
                foreach ( $diffArray AS $key => $val )
                {
                    if ( $val )
                    {
                        return $val . ' ' . \f\ifm::t ( $key ) . ' ' . \f\ifm::t ( 'prv' ) ;
                    }
                }
            }
        }
    }

    public function getGrRangeYearMonthByJaDate ()
    {
        $today = explode ( '/', $this->today () ) ;

        $firstDayYear  = $today[ 0 ] . '/01/01' ;
        $lastDayYear   = $today[ 0 ] . '/12/29' ;
        $firstDayMonth = $today[ 0 ] . '/' . $today[ 1 ] . '/01' ;
        if ( $today[ 1 ] <= 6 )
        {
            $day = 31 ;
        }
        else
        {
            $day = 30 ;
        }
        $lastDayMonth = $today[ 0 ] . '/' . $today[ 1 ] . '/' . $day ;

        return array (
            'today'         => date ( 'Y-m-d' ),
            'firstDayYear'  => $this->formatDate ( $this->dateJaToGr ( $firstDayYear,
                                                                       1, FALSE ) ),
            'lastDayYear'   => $this->formatDate ( $this->dateJaToGr ( $lastDayYear,
                                                                       1, FALSE ) ),
            'firstDayMonth' => $this->formatDate ( $this->dateJaToGr ( $firstDayMonth,
                                                                       1, FALSE ) ),
            'lastDayMonth'  => $this->formatDate ( $this->dateJaToGr ( $lastDayMonth,
                                                                       1, FALSE ) )
                ) ;
    }

    public function formatDate ( $date )
    {
        return str_replace ( '/', '-', $date ) ;
    }

    public function formatJaDate ( $mainDate )
    {
        $date = explode ( '/', $mainDate ) ;

        //------------------------------------------------------------
        $day   = $date[ 2 ] ;
        $month = $date[ 1 ] ;
        $year  = $date[ 0 ] ;

        $date1 = $this->formated_j_date ( $year, $month, $day ) ;

        $dateGr = $this->dateJaToGr ( $mainDate, 1 ) ;


        return $this->weekday[ date ( 'l', strtotime($dateGr) ) ] . ' ، ' . $date1[ 2 ] . ' ' . $date1[ 1 ] . ' ' . $date1[ 0 ] ;
    }

}
