<?php

namespace f\w ;

class calendar extends \f\widget
{

    public $weekday = array (
        'Sunday'    => 'یک شنبه',
        'Monday'    => 'دوشنبه',
        'Tuesday'   => 'سه شنبه',
        'Wednesday' => 'چهارشنبه',
        'Thursday'  => 'پنج شنبه',
        'Friday'    => 'جمعه',
        'Saturday'  => 'شنبه' ) ;
    public $month      = array (
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
    public $month_hijri = array (
        'محرم',
        'صفر',
        'ربیع الاول',
        'ربیع الثانی',
        'جمادی الاول',
        'جمادی الثانی',
        'رجب',
        'شعبان',
        'رمضان',
        'شوال',
        'ذی القعده',
        'ذی الحجه' ) ;
    Public $month_gregorian = array (
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
    public $type_event_jalali = array ( ) ;
    public $type_event_hijri = array ( ) ;
    public $title_event_jalali = array ( ) ;
    public $title_event_hijri = array ( ) ;
    public $hijri_default = array (
        30,
        29,
        30,
        29,
        30,
        29,
        30,
        29,
        30,
        29,
        30,
        29 ) ;
    public $holiday = array (
        '011',
        '012',
        '013',
        '014',
        '0112',
        '0113',
        '0314',
        '0315',
        '1122',
        '1229' ) ;
    public $weekdayFa = array ( 'شنبه', 'یک شنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنج شنبه', 'آدینه' ) ;

    public function renderCalendar ( $params )
    {
        if ( $params[ 'type' ] == 'month' )
        {
            return $this->month_calendar ( $params ) ;
        }
        if ( $params[ 'type' ] == 'month-small' )
        {

            return $this->month_small ( $params ) ;
        }
        if ( $params[ 'type' ] == 'week' )
        {

            return $this->week_calendar ( $params ) ;
        }
    }

    public function month_calendar ( $params )
    {
        //\f\pre($params);
        $event           = ( $params[ 'event' ]) ;
        //return $event;
        $month_hijri_day = array ( ) ;
        $this->registerGadgets ( array (
            'dateG' => 'date'
        ) ) ;
        /* @var $dateG \f\g\date */
        $dateG  = \f\gadgetFactory::make ( 'date' ) ;


        $today_date = explode ( '/', $dateG->today () ) ;
        if ( ! isset ( $params[ 'year' ] ) )
        {
            $year  = $today_date[ 0 ] ;
            $month = $today_date[ 1 ] ;
            $day   = $today_date[ 2 ] ;
            $today = $day ;
        }
        else
        {
            $year  = $params[ 'year' ] ;
            $month = ($params[ 'month' ] < 10) ? '0' . $params[ 'month' ] : $params[ 'month' ] ;

            if ( $year == $today_date[ 0 ] && $month == $today_date[ 1 ] )
            {
                $today = $today_date[ 2 ] ;
            }
        }

        $calendar = $this->header_month ( $year, $month, $params[ 'section' ],
                                          $params[ 'section_id' ],
                                          $params[ 'user_id' ],
                                          $params[ 'path' ] ) ;
        //$today = ($today_date[ 1 ] * 100) + $today_date[ 2 ] ;
        $k        = 1 ;
        $row      = 0 ;
        $min      = 1 ;
        $max      = 12 ;
        // echo $today;
        while ( $k <= 12 )
        {
            $date = explode ( '/', $dateG->dateJaToGr ( "$year/$k/1", 1 ) ) ;

            $datetime  = $date[ 0 ] . '-' . $date[ 1 ] . '-' . $date[ 2 ] ;
            $timestamp = strtotime ( $datetime ) ;
            $firstday  = (date ( 'w', $timestamp ) + 1) % 7 ;

            $date_hijri = explode ( '-',
                                    $dateG->dateGrToHi ( date ( "Y/m/d",
                                                                $timestamp ),
                                                                'YMD' ) ) ;
            //\f\pr($dateG->dateGrToHi ( date ( "Y/m/d",$timestamp ), 1 ));

            $day_hijri   = intval ( $date_hijri[ 0 ] ) ;
            $month_hijri = intval ( $date_hijri[ 1 ] ) ;
            $year_hijri  = intval ( $date_hijri[ 2 ] ) ;
            if ( $k == 1 )
            {
                $leap          = date ( 'L', $timestamp ) ;
            }
            $day           = $this->numDay ( $k, $leap ) ;
            $day_prv_month = $this->numDay ( $k - 1, $leap ) ;

            $month_gregorian = date ( 'm', $timestamp ) ;
            $year_gregorian  = date ( 'Y', $timestamp ) ;

            if ( $k == $month )
            {
                $calendar.= '<div class="calendar_box" 
                style="display:block">
                <div class="title_month" >
                    <div class="title_jalali">' . $this->month[ $k - 1 ] . ' ' . $year . '</div> 
                    <div class="title_non_jalali">
                        <div class="title_hijri">' . $this->month_hijri[ $month_hijri - 1 ] . ' - ' . $this->month_hijri[ $month_hijri % 12 ] . ' ' . $year_hijri . '</div> 
                        <div class="title_gregorian">' . $this->month_gregorian[ $month_gregorian - 1 ] . ' - ' . $this->month_gregorian[ $month_gregorian % 12 ] . ' ' . $year_gregorian . '</div> 
                    </div> 
                    <div class="clear"></div>
                </div>

                <div class="week">
                    <div class="day_week">شنبه</div>
                    <div class="day_week">یکشنبه</div>
                    <div class="day_week">دوشنبه</div>
                    <div class="day_week">سه شنبه</div>
                    <div class="day_week">چهارشنبه</div>
                    <div class="day_week">پنج شنبه</div>
                    <div class="day_week">آدینه</div>
                    <div class="clear"></div>
                </div>
                <div class="week">' ;

                for ( $j = 0 ; $j < $firstday ; $j ++  )
                {


                    $calendar.='<div class="day_month_blank" style="color:silver"><div   class="jalali_date">' . ($day_prv_month - $firstday + $j + 1) . '</div></div>' ;
                }
                $i    = 1 ;
                $j    = $firstday + 1 ;
                $flag = false ;
                while ( $i <= $day )
                {
                    if ( $flag )
                    {

                        $calendar.='<div class="week">' ;

                        $flag = false ;
                    }

                    $date_day   = $k . '-' . $i ;
                    $date_day2  = ($k * 100) + $i ;
                    $day_miladi = $timestamp + ($i - 1) * 60 * 60 * 24 ;

                    $color = ( $j % 7 == 0 || in_array ( $month . $i,
                                                         $this->holiday )) ? 'red' : '' ;

                    $bg   = ($today && $today == $i) ? '#FCFBDE' : '' ;
                    $dayy = $i < 10 ? '0' . $i : $i ;
                    $date = "$year/$month/$dayy" ;

                    $calendar.='<div class="day_month" style="background:' . $bg . '" data-date="' . $date . '">
                                <div   class="jalali_date">
                                    <span style="color:' . $color . '">' . $i . '</span>
                                </div>' ;
                    if ( is_array ( $event[ $year ][ $month ][ $dayy ] ) )
                    {

                        //\f\pr($event[$year][$month][$i]);
                        foreach ( $event[ $year ][ $month ][ $dayy ] AS $data )
                        {
                            $href=  \f\ifm::app ()->baseUrl.'projectManager/'.$data['section'].'/'.$data['section'].'Detail/'.$data['section_id']; 
                            if ( $data[ 'numDay' ] != 0 )
                            {
                                if ( $data[ 'numDay' ] > 1 )
                                {
                                    $style = 'position:absolute;width:' . (($data[ 'numDay' ] * 100) - 1) . '%;z-index:100;top:0px' ;
                                }
                                else
                                {
                                    $style = '' ;
                                }
                                $calendar.= '<a href="'.$href.'" style="text-decoration:none" target="_blank"><div style="min-height:40px;background:none;position:relative;"><div class="fc-event calendar-event" style="background:' . $data[ 'color' ] . ';' . $style . '" data-date="' . $date . '" data-id="' . $data[ 'id' ] . '">
                                           <i class="fa ' . $data[ 'icon' ] . '"></i> ' . $data[ 'title' ] . '
                                           <div style="text-align:left;direction:ltr;font-size:10px"><i class="fa fa-clock-o"></i> ' . $data[ 'time_start' ] . ' - ' . $data[ 'time_end' ] . '</div>
                                        </div></div></a>' ;
                            }
                            else
                            {
                                $calendar.= '<div class="fc-event calendar-event" style="height:38px;background:none;" >
                                          
                                        </div>' ;
                            }
                        }
                    }
                    $calendar.='</div>' ;

                    if ( $j % 7 == 0 )
                    {

                        $flag = true ;
                        $row ++ ;

                        $calendar.='   <div class="clear"></div>
                            </div>' ;
                    }
                    $j ++ ;
                    $i ++ ;
                    $day_hijri ++ ;
                }

                if ( ! $flag )
                {
                    $ss = (($j - 1) % 7) ;
                    for ( $kk = $ss ; $kk < 7 ; $kk ++  )
                    {
                        $calendar.='<div class="day_month_blank"> <div   class="jalali_date" style="color:silver">' . (($kk % 7) - ($ss) + 1) . '</div></div>' ;
                    }

                    $calendar.='  <div class="clear"></div>
                    </div>' ;
                }
                if ( $row == 4 || ($j - 1) % 7 == 0 )
                {
                    $flag = false ;
                    $calendar.=' 
                    <div class="clear"></div>
                   
                ' ;
                }



                $calendar.='</div>' ;
                break ;
            }

            $k ++ ;
        }

        return $calendar ;
    }

    private function numDay ( $k, $leap )
    {
        if ( $k <= 6 )
        {
            $day = 31 ;
        }
        else if ( ($k > 6 && $k < 12) || $leap == 1 )
        {
            $day = 30 ;
        }
        else
        {
            $day = 29 ;
        }

        return $day ;
    }

    private function header_month ( $year, $month, $section, $section_id,
                                    $user_id, $path)
    {
        $prv_month = (($month - 1) > 0) ? ($month - 1) : 12 ;
        $prv_year  = ($prv_month == 12) ? $year - 1 : $year ;

        $prv = "widgetHelper.tt('ui', '$path',{type:'month',year:$prv_year,month:$prv_month,section:'$section',section_id:'$section_id',user_id:'$user_id'},'show_calendar')" ;

        $nex_month = (($month + 1) > 12) ? (1) : ($month + 1) ;
        $nex_year  = ($nex_month == 1) ? $year + 1 : $year ;

        $nex = "widgetHelper.tt('ui', '$path',{type:'month',year:$nex_year,month:$nex_month,section:'$section',section_id:'$section_id',user_id:'$user_id'},'show_calendar')" ;

        $today = "widgetHelper.tt('ui', '$path',{type:'month',section:'$section',section_id:'$section_id',user_id:'$user_id'},'show_calendar')" ;
        
       
        $week = "widgetHelper.tt('ui', '$path',{type:'week',section:'$section',section_id:'$section_id',user_id:'$user_id'},'show_calendar')" ;

        return '<br><table class="fc-header" style="width:100%">
                <tbody>
                <tr>
                <td class="fc-header-left">
                <div data-toggle="buttons" class="btn-group">
                    <label class="btn btn-info  active" style="margin:0 !important;padding:3px 20px !important" id="month">
                        <input type="radio" id="option1" name="options" value="month" > ماه
                    </label>
                    <label class="btn btn-info" style="margin:0 !important;padding:3px 20px !important" id="week">
                        <input type="radio" id="option2" name="options" onclick="'.$week.'" value="week"> هفته
                    </label>
                </div>
                </td>
                <td class="fc-header-center"></td>
                <td class="fc-header-right" style="text-align:left">
               
                <span class="fc-text-arrow" onclick="' . $prv . '">‹</span>
                <span class="fc-header-space"></span>
                <span class="fc-text-arrow" onclick="' . $nex . '">›</span>
               
                <span onclick="' . $today . '" class="fc-button fc-button-today fc-state-default fc-corner-left fc-corner-right fc-state-disabled" unselectable="on" style="-moz-user-select: none;">امروز</span>
                </td>
                </tr>
                </tbody>
                </table>' ;
    }

    private function header_week ( $firstDayWeek, $section, $section_id,
                                   $user_id, $path,$year,$month )
    {
        $prvWeek = $firstDayWeek - 604800 ;


        $prv = "widgetHelper.tt('ui', '$path',{type:'week',firstDayWeek:$prvWeek,section:'$section',section_id:'$section_id',user_id:'$user_id'},'show_calendar')" ;

        $nexWeek = $firstDayWeek + 604800 ;


        $nex = "widgetHelper.tt('ui', '$path',{type:'week',firstDayWeek:$nexWeek,section:'$section',section_id:'$section_id',user_id:'$user_id'},'show_calendar')" ;

        $today = "widgetHelper.tt('ui', '$path',{type:'week',section:'$section',section_id:'$section_id',user_id:'$user_id'},'show_calendar')" ;
        
        
        $month = "widgetHelper.tt('ui', '$path',{type:'month',year:$year,month:$month,section:'$section',section_id:'$section_id',user_id:'$user_id'},'show_calendar')" ;
        
        return '<br><table class="fc-header" style="width:100%">
                <tbody>
                <tr>
                <td class="fc-header-left">
                <div data-toggle="buttons" class="btn-group">
                    <label class="btn btn-info" style="margin:0 !important;padding:3px 20px !important" id="month">
                        <input type="radio" id="option1" name="options" onclick="'.$month.'" value="month"> ماه
                    </label>
                    <label class="btn btn-info active" style="margin:0 !important;padding:3px 20px !important" id="week">
                        <input type="radio" id="option2" name="options" value="week"> هفته
                    </label>
                </div>
                </td>
                <td class="fc-header-center"></td>
                <td class="fc-header-right" style="text-align:left">
               
                <span class="fc-text-arrow" onclick="' . $prv . '">‹</span>
                <span class="fc-header-space"></span>
                <span class="fc-text-arrow" onclick="' . $nex . '">›</span>
               
                <span onclick="' . $today . '" class="fc-button fc-button-today fc-state-default fc-corner-left fc-corner-right fc-state-disabled" unselectable="on" style="-moz-user-select: none;margin-top:4px">امروز</span>
                </td>
                </tr>
                </tbody>
                </table>' ;
    }

    public function month_small ( $params )
    {
        $event = ( $params[ 'event' ]) ;

        //return $event;
        $month_hijri_day = array ( ) ;
        $this->registerGadgets ( array (
            'dateG' => 'date'
        ) ) ;
        /* @var $dateG \f\g\date */
        $dateG  = \f\gadgetFactory::make ( 'date' ) ;


        $today_date = explode ( '/', $dateG->today () ) ;



        if ( ! isset ( $params[ 'year' ] ) )
        {
            $year  = $today_date[ 0 ] ;
            $month = $today_date[ 1 ] ;
            $day   = $today_date[ 2 ] ;
            $today = $day ;
        }
        else
        {
            $year  = $params[ 'year' ] ;
            $month = ($params[ 'month' ] < 10) ? '0' . $params[ 'month' ] : $params[ 'month' ] ;

            if ( $year == $today_date[ 0 ] && $month == $today_date[ 1 ] )
            {
                $today = $today_date[ 2 ] ;
            }
        }

        //$calendar=  $this->header_month($year,$month,$params['section'],$params['section_id'],$params['path']);

        $calendar = '' ;


        //$today = ($today_date[ 1 ] * 100) + $today_date[ 2 ] ;
        $k   = 1 ;
        $row = 0 ;
        $min = 1 ;
        $max = 12 ;

        // echo $today;
        while ( $k <= 12 )
        {
            $date = explode ( '/', $dateG->dateJaToGr ( "$year/$k/1", 1 ) ) ;

            $datetime  = $date[ 0 ] . '-' . $date[ 1 ] . '-' . $date[ 2 ] ;
            $timestamp = strtotime ( $datetime ) ;
            $firstday  = (date ( 'w', $timestamp ) + 1) % 7 ;

            $date_hijri = explode ( '-',
                                    $dateG->dateGrToHi ( date ( "Y/m/d",
                                                                $timestamp ),
                                                                'YMD' ) ) ;

            //\f\pr($dateG->dateGrToHi ( date ( "Y/m/d",$timestamp ), 1 ));

            $day_hijri   = intval ( $date_hijri[ 0 ] ) ;
            $month_hijri = intval ( $date_hijri[ 1 ] ) ;
            $year_hijri  = intval ( $date_hijri[ 2 ] ) ;


            if ( $k == 1 )
            {
                $leap          = date ( 'L', $timestamp ) ;
            }
            $day           = $this->numDay ( $k, $leap ) ;
            $day_prv_month = $this->numDay ( $k - 1, $leap ) ;

            $month_gregorian = date ( 'm', $timestamp ) ;
            $year_gregorian  = date ( 'Y', $timestamp ) ;

            if ( $k == $month )
            {
                $path      = $params[ 'path' ] ;
                $prv_month = (($month - 1) > 0) ? ($month - 1) : 12 ;
                $prv_year  = ($prv_month == 12) ? $year - 1 : $year ;

                $prv = "widgetHelper.tt('ui', '$path',{type:'month-small',year:$prv_year,month:$prv_month},'show_calendar')" ;

                $nex_month = (($month + 1) > 12) ? (1) : ($month + 1) ;
                $nex_year  = ($nex_month == 1) ? $year + 1 : $year ;

                $nex = "widgetHelper.tt('ui', '$path',{type:'month-small',year:$nex_year,month:$nex_month},'show_calendar')" ;

                $calendar.= '<div class="calendar_box" 
                style="display:block;position:relative">
                 <div class="title_month" >
                <table class="fc-header" style="width:100%">
                <tbody>
                <tr>
                <td class="fc-header-left" style="text-align:right">  
                  <span class="fc-text-arrow" style="background:none" onclick="' . $prv . '">‹</span>
                </td>
                <td class="fc-header-center" style="font-size:18px">
                ' . $this->month[ $k - 1 ] . ' ' . $year . '
                </td>
                <td class="fc-header-right" style="text-align:left">
              
                <span class="fc-text-arrow" style="background:none" onclick="' . $nex . '">›</span>
              
             
               
               
                </td>
                </tr>
                </tbody>
                </table>
                
               
                   
                    
                 
                </div>' ;
                $i = 1 ;
                while ( $i <= $day )
                {
                    $dayy = $i < 10 ? '0' . $i : $i ;
                    if ( is_array ( $event[ $year ][ $month ][ $dayy ] ) )
                    {


                        $date = $year . $month . $dayy ;
                        $calendar.='<div id="' . $date . '" style="position:absolute;width:100%;height:368px;background:white;z-index: 100;opacity:1;display:none">'
                                . '<div class="week" style="background:#ddd;text-align:center;padding:5px">رویدادهای ' . $year . '/' . $month . '/' . $dayy . ''
                                . '<i class="fa fa-close" style="position:absolute;left:7px;top:7px;cursor:pointer" onclick="close_event(' . $date . ')"></i></div>'
                                . '<div style="padding:10px;">' ;
                        foreach ( $event[ $year ][ $month ][ $dayy ] AS $data )
                        {
                            //\f\pr($event[ $year ][ $month ][ $i ]);
                            $calendar.='<div style="padding:5px 0px;border-bottom:1px dashed #eee">'
                                    . '<div style="float:right">'
                                    . '<div style="height:12px;width:12px;border-radius:100%;background:' . $data[ 'color' ] . ';margin:5px 0px 0px 5px"></div>'
                                    . '</div>'
                                    . '<div style="float:right">'
                                    . '<i class="fa fa-' . $data[ 'icon' ] . '"></i> ' . $data[ 'title' ] . '</div>'
                                    . '<div style="float:left;color:silver;direction:ltr"><i class="fa fa-clock-o"></i> ' . $data[ 'time_start' ] . ' - ' . $data[ 'time_end' ] . '</div>'
                                    . '<div class="clear"></div>'
                                    . '</div>' ;
                        }
                        $calendar.= '</div>'
                                . '</div>' ;
                    }
                    $i ++ ;
                }



                $calendar.='<div class="week">
                    <div class="day_week">شنبه</div>
                    <div class="day_week">یکشنبه</div>
                    <div class="day_week">دوشنبه</div>
                    <div class="day_week">سه شنبه</div>
                    <div class="day_week">چهارشنبه</div>
                    <div class="day_week">پنج شنبه</div>
                    <div class="day_week">آدینه</div>
                    <div class="clear"></div>
                </div>
                <div class="week">' ;

                for ( $j = 0 ; $j < $firstday ; $j ++  )
                {


                    $calendar.='<div class="day_month_blank" style="color:silver;height:65px"><div   class="jalali_date">' . ($day_prv_month - $firstday + $j + 1) . '</div></div>' ;
                }
                $i    = 1 ;
                $j    = $firstday + 1 ;
                $flag = false ;
                while ( $i <= $day )
                {

                    if ( $flag )
                    {

                        $calendar.='<div class="week">' ;

                        $flag = false ;
                    }

                    $date_day   = $k . '-' . $i ;
                    $date_day2  = ($k * 100) + $i ;
                    $day_miladi = $timestamp + ($i - 1) * 60 * 60 * 24 ;

                    $color = ( $j % 7 == 0 || in_array ( $month . $i,
                                                         $this->holiday )) ? 'red' : '' ;

                    $bg   = ($today && $today == $i) ? '#FCFBDE' : '' ;
                    $dayy = $i < 10 ? '0' . $i : $i ;
                    //$event=array('1394/02/22','1394/02/26');
                    $date = "$year/$month/$dayy" ;
                    if ( is_array ( $event[ $year ][ $month ][ $dayy ] ) )
                    {

                        $border  = 'border-bottom:3px solid #4BB2C5;' ;
                        $cursor  = 'cursor:pointer' ;
                        $date2   = "'" . $date . "'" ;
                        $onclick = 'onclick="show_event(' . $year . $month . $dayy . ')"' ;
                    }
                    else
                    {
                        $border  = '' ;
                        $cursor  = 'cursor:auto' ;
                        $onclick = '' ;
                    }
                    $calendar.='<div class="day_month" ' . $onclick . ' style="' . $cursor . ';height:65px;vertical-align:middle;background:' . $bg . '" data-date="' . $date . '">
                                <div   class="jalali_date" style="padding-bottom:5px;margin:0px auto;width:70%;text-align:center;' . $border . '">
                                    <span style="font-size:16px !important;color:' . $color . '">' . $i . '</span>
                                </div>' ;

                    $calendar.='</div>' ;



                    if ( $j % 7 == 0 )
                    {

                        $flag = true ;
                        $row ++ ;

                        $calendar.='   <div class="clear"></div>
                            </div>' ;
                    }
                    $j ++ ;
                    $i ++ ;
                    $day_hijri ++ ;
                }

                if ( ! $flag )
                {
                    $ss = (($j - 1) % 7) ;
                    for ( $kk = $ss ; $kk < 7 ; $kk ++  )
                    {
                        $calendar.='<div class="day_month_blank" style="height:65px"> <div   class="jalali_date" style="color:silver;height:65px">' . (($kk % 7) - ($ss) + 1) . '</div></div>' ;
                    }

                    $calendar.='  <div class="clear"></div>
                    </div>' ;
                }

                if ( $row == 4 || ($j - 1) % 7 == 0 )
                {
                    $flag = false ;
                    $calendar.=' 
                    <div class="clear"></div>
                   
                ' ;
                }



                $calendar.='</div>' ;
                break ;
            }

            $k ++ ;
        }

        return $calendar ;
    }

    public function week_calendar ( $params )
    {
        //\f\pre($params);
        $event = ( $params[ 'event' ]) ;

        //\f\pr($event);
        //return $event;
        $month_hijri_day = array ( ) ;
        $this->registerGadgets ( array (
            'dateG' => 'date'
        ) ) ;

        /* @var $dateG \f\g\date */
        $dateG = \f\gadgetFactory::make ( 'date' ) ;




        //$today_date = explode ( '/', $dateG->today () ) ;
        if ( ! isset ( $params[ 'firstDayWeek' ] ) )
        {
            $dayWeek      = (date ( 'w', strtotime ( date ( 'Y-m-d' ) ) ) + 1) % 7 ;
            $firstDayWeek = strtotime ( '-' . $dayWeek . ' days',
                                        strtotime ( date ( 'Y-m-d' ) ) ) ;
        }
        else
        {
            $firstDayWeek     = $params[ 'firstDayWeek' ] ;
        }
        $firstDayWeekDate = explode ( '/', $dateG->dateTime ( $firstDayWeek, 2 ) ) ;
        $lastDayWeekDate  = explode ( '/',
                                      $dateG->dateTime ( $firstDayWeek + 518400,
                                                         2 ) ) ;

        if ( $firstDayWeekDate[ 1 ] == $lastDayWeekDate[ 1 ] )
        {
            $title = $firstDayWeekDate[ 2 ] . ' ' . ' تا ' . $lastDayWeekDate[ 2 ] . ' ' . $this->month[ $lastDayWeekDate[ 1 ] - 1 ] . ' ' . $lastDayWeekDate[ 0 ] ;
        }
        else if ( $firstDayWeekDate[ 0 ] == $lastDayWeekDate[ 0 ] )
        {
            $title = $firstDayWeekDate[ 2 ] . ' ' . $this->month[ $firstDayWeekDate[ 1 ] - 1 ] . ' تا ' . $lastDayWeekDate[ 2 ] . ' ' . $this->month[ $lastDayWeekDate[ 1 ] - 1 ] . ' ' . $lastDayWeekDate[ 0 ] ;
        }
        else
        {
            $title = $firstDayWeekDate[ 2 ] . ' ' . $this->month[ $firstDayWeekDate[ 1 ] - 1 ] . ' ' . $firstDayWeekDate[ 0 ] . ' تا ' . $lastDayWeekDate[ 2 ] . ' ' . $this->month[ $lastDayWeekDate[ 1 ] - 1 ] . ' ' . $lastDayWeekDate[ 0 ] ;
        }

        $calendar = $this->header_week ( $firstDayWeek, $params[ 'section' ],
                                         $params[ 'section_id' ],
                                         $params[ 'user_id' ], $params[ 'path' ],$firstDayWeekDate[0],$firstDayWeekDate[1] ) ;

        $calendar.= '<div class="calendar_box" 
                style="display:block">
                <div class="title_month" >
                    <div class="title_jalali" style="width:280px">
                       ' . $title . '
                    </div> 
                     
                    <div class="clear"></div>
                </div>

                <div class="week">' ;

        $today = $dateG->today () ;
        $colToday=-1;

        for ( $i = 0 ; $i < 7 ; $i ++  )
        {
            $datee = explode ( '/',
                               $dateG->dateTime ( $firstDayWeek + ($i * 86400),
                                                  2 ) ) ;
            $color = ( $i == 6 || in_array ( $datee[ 1 ] . $datee[ 2 ],
                                             $this->holiday )) ? 'red' : '' ;
            if ( $color == 'red' )
            {
                $color1 = 'red' ;
            }
            else
            {
                $color1   = 'gray' ;
            }
            $dayEvent = $event[ $datee[ 0 ] ][ $datee[ 1 ] ][ $datee[ 2 ] ] ;
            if ( is_array ( $dayEvent ) )
            {
                foreach ( $dayEvent AS $data )
                {
                    $eventDayHour[ $datee[ 0 ] ][ $datee[ 1 ] ][ $datee[ 2 ] ][ $data[ 'time_start' ] ]              = $data ;
                    $eventDayHour[ $datee[ 0 ] ][ $datee[ 1 ] ][ $datee[ 2 ] ][ $data[ 'time_start' ] ][ 'num_min' ] = $this->calcNumMin ( $data[ 'time_start' ],
                                                                                                                                           $data[ 'time_end' ] ) ;
                }
            }
            $dayCol[ $i ] = $datee[ 2 ] ;
            $monthCol[ $i ]  = $datee[ 1 ] ;
            $yearCol[ $i ]  = $datee[ 0 ] ;
            
            if($today==$datee[0].'/'.$datee[1].'/'.$datee[2])
            {
                $colToday=$i;
            }

            $calendar.='<div class="day_week" style="color:' . $color . '">' . $this->weekdayFa[ $i ] . '<br><span style="color:' . $color1 . '">' . $datee[ 2 ] . ' ' . $this->month[ intval ( $datee[ 1 ] ) - 1 ] . '</span></div>' ;
        }

        //\f\pr($eventDayHour);


        $calendar.='<div class="clear"></div>
                </div>' ;
        ;
        if($colToday!=-1)
        {
            $top=date('H')*60+date('i')+175;
            $calendar.='<div style="position:absolute;top:'.$top.'px;right:0px;width:100%;height:2px;border-bottom:2px dotted #79DCF2;z-index:1000;"></div>';
       
        }
        $hourArray = $this->halfHourTimes () ;
        //\f\pr($hourArray);
        $col       = 0 ;
        for ( $i = 0 ; $i < 48 * 7 ; $i ++  )
        {
            if ( $i % 7 == 0 )
            {
                $flag = true ;
                $row ++ ;
                $col  = 0 ;

                $calendar.='   <div class="clear"></div>
                </div>' ;
            }
            if ( $flag )
            {
                if ( $row <= 12 || $row > 40 )
                {
                    $display = "" ;
                    if ( $row < 12 )
                    {
                        $class = "night1" ;
                    }
                    else
                    {
                        $class = 'night2' ;
                    }
                }
                else
                {
                    $display = '' ;
                    $class   = '' ;
                }

                $calendar.='<div class="week ' . $class . '" style="' . $display . '">' ;

                $flag = false ;
            }
            if ( $row % 2 == 1 )
            {
                $border = 'border-bottom:1px dashed #eee' ;
                if ( ($i + 1) % 7 == 0 )
                {
                    $clock = '<div style="position:absolute;left:0px;top:0px;color:#ddd;font-size:12px">' . $hourArray[ $row - 1 ] . '</div>' ;
                }
                else
                {
                    $c=$col==$colToday?'#FCFBDE':'white';
                    $clock = '<div style="position:absolute;left:0px;top:0px;color:'.$c.';font-size:12px">' . $hourArray[ $row - 1 ] . '</div>' ;
                }
            }
            else
            {
                $border = '' ;
                $c=$col==$colToday?'#FCFBDE':'white';
                $clock = '<div style="position:absolute;left:0px;top:0px;color:'.$c.';font-size:12px">' . $hourArray[ $row - 1 ] . '</div>' ;
            }
            
            $bg=$col==$colToday?'#FCFBDE':'';


            $calendar.='<div class="day_month" style="' . $border . ';height:30px;background:' . $bg . '" >' ;
            $calendar.=$clock ;
            if ( is_array ( $eventDayHour[ $yearCol[ $col ] ][ $monthCol[ $col ] ][ $dayCol[ $col ] ][ $hourArray[ $row - 1 ] ] ) )
            {
                $href=  \f\ifm::app ()->baseUrl.'projectManager/'.$data['section'].'/'.$data['section'].'Detail/'.$data['section_id']; 
                $data  = $eventDayHour[ $yearCol[ $col ] ][ $monthCol[ $col ] ][ $dayCol[ $col ] ][ $hourArray[ $row - 1 ] ] ;
                $style = 'position:absolute;height:' . ($data[ 'num_min' ] - 5) . 'px;z-index:100;top:0px;width:98%' ;

                $calendar.= '<a href="'.$href.'" style="text-decoration:none" target="_blank"><div style="font-size:13px"><div class="fc-event calendar-event" style="font-size:13px;background:' . $data[ 'color' ] . ';' . $style . '" data-date="' . $date . '" data-id="' . $data[ 'id' ] . '">
                                           ' . $data[ 'title' ] . '
                                           <div style="text-align:right;direction:rtl;padding-right:2px"><i class="fa fa-clock-o"></i> ' . $data[ 'time_start' ] . ' - ' . $data[ 'time_end' ] . '</div>
                                        </div></div></a>' ;
            }
            $calendar.=' </div>' ;

            $col ++ ;
        }






        return $calendar ;
    }

    function calcNumMin ( $start, $end )
    {
        $s    = explode ( ':', $start ) ;
        $sMin = $s[ 0 ] * 60 + $s[ 1 ] ;
        $e    = explode ( ':', $end ) ;
        $eMin = $e[ 0 ] * 60 + $e[ 1 ] ;

        return $eMin - $sMin ;
    }

    function halfHourTimes ()
    {

        $formatter = function ($time)
                {
                    //date_default_timezone_set('Asia/Tehran');
                    if ( $time % 3600 == 0 )
                    {
                        return date ( 'H:i', $time ) ;
                    }
                    else
                    {
                        return date ( 'H:i', $time ) ;
                    }
                } ;
        $halfHourSteps = range ( -7 * 1800, 40 * 1800, 1800 ) ;
        return array_map ( $formatter, $halfHourSteps ) ;
    }

}
