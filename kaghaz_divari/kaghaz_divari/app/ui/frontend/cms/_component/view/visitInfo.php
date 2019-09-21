<?php
$this->registerGadgets ( array (
    'dateG' => 'date' ) ) ;
$dateArr = $this->dateG->parse_date ( $data_visit[ 'max' ][ 'date' ] ) ;
$maxDate = $this->dateG->dateGrToJa ( implode ( '/', $dateArr ), 2 ) ;
?>
<div class="teaser_content media">
    <div class="" style="width:100%;text-align:center;direction: rtl">

        <h3 style="font-size:22px;color:#FFF">
            <i class="fa fa-bar-chart"></i> آمار بازدید
        </h3>
        <!-- testimonials indicators -->

    </div>
    <section class="widget-alt ">
        <ul style="direction: rtl">
            
            <li>
                <div class="col-sm-6" style="color: silver;text-align: right"><?= \f\ifm::t ( 'visitAll' ) ?></div>
                <div class="col-sm-6" style='text-align: left'><?php echo ($visit_all ? $visit_all : '0') . ' ' . \f\ifm::t ( 'visit' ) ?>  </div>
                <div class="clearfix"></div> 
            </li>
            <li>
                <div class="col-sm-6" style="color: silver;text-align: right"><?= \f\ifm::t ( 'visitToday' ) ?></div>
                <div class="col-sm-6" style='text-align: left'><?php echo ($data_visit[ 'today' ][ 'num_visit' ] ? $data_visit[ 'today' ][ 'num_visit' ] : '0') . ' ' . \f\ifm::t ( 'visit' ) ?>    </div>
                <div class="clearfix"></div> 
            </li>
            <li>
                <div class="col-sm-6" style="color: silver;text-align: right"><?= \f\ifm::t ( 'visitorToday' ) ?></div>
                <div class="col-sm-6" style='text-align: left'><?php echo ($data_visit[ 'today' ][ 'num_visitor' ] ? $data_visit[ 'today' ][ 'num_visitor' ] : '0') . ' ' . \f\ifm::t ( 'person' ) ; ?>   </div>
                <div class="clearfix"></div> 
            </li>
            <li>
                <div class="col-sm-6" style="color: silver;text-align: right"><?= \f\ifm::t ( 'visitYesterday' ) ?></div>
                <div class="col-sm-6" style='text-align: left'><?php echo ($data_visit[ 'yesterday' ][ 'num_visit' ] ? $data_visit[ 'yesterday' ][ 'num_visit' ] : '0') . ' ' . \f\ifm::t ( 'visit' ) ; ?> </div>
                <div class="clearfix"></div> 
            </li>
            <li>
                <div class="col-sm-6" style="color: silver;text-align: right"><?= \f\ifm::t ( 'visitorYestaerday' ) ?></div>
                <div class="col-sm-6" style='text-align: left'><?php echo ($data_visit[ 'yesterday' ][ 'num_visitor' ] ? $data_visit[ 'yesterday' ][ 'num_visitor' ] : '0') . ' ' . \f\ifm::t ( 'person' ) ; ?>  </div>
                <div class="clearfix"></div> 
            </li>
             <li>
                <div class="col-sm-5" style="color: silver;text-align: right"><?= \f\ifm::t ( 'maxDayVisit' ) ?></div>
                <div class="col-sm-7" style='text-align: left'><?php echo $maxDate ?> <span style='font-size: 11px'>- <?php echo $data_visit[ 'max' ][ 'num_visit' ] . ' ' . \f\ifm::t ( 'visit' ) ; ?>  </span></div>
                <div class="clearfix"></div> 
            </li>
        </ul>
    </section>
    
</div>