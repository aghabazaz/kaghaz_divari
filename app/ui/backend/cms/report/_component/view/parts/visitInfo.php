<?
echo $boxWidget->begin ( array (
    'type'   => 'form',
    'title'  => \f\ifm::t ( 'visitInfo' ),
    'focus'  => '1',
    'expand' => 1,
    'remove' => 1 ) ) ;
$dateArr=$this->dateG->parse_date($data_visit[ 'max' ][ 'date' ]);
$maxDate=$this->dateG->dateGrToJa(  implode ( '/', $dateArr ),2);

?>
<div class="content" style="font-size: 13px">
    <div class="report_row">
        <div class="report_col"><?= \f\ifm::t ( 'visitAll' ) ?></div>
        <div class="report_col" style="color: gray"><?php echo ($visit_all ? $visit_all : '0').' '.\f\ifm::t ( 'visit' )?>  </div>
        <div class="clear"></div>
    </div>
    <div class="report_row">
        <div class="report_col"><?=  \f\ifm::t ( 'visitToday' ) ?></div>
        <div class="report_col" style="color: gray"><?php echo ($data_visit[ 'today' ][ 'num_visit' ] ? $data_visit[ 'today' ][ 'num_visit' ] : '0').' '.\f\ifm::t ( 'visit' ) ?>  </div>
        <div class="clear"></div>
    </div>
    <div class="report_row">
        <div class="report_col"><?=  \f\ifm::t ( 'visitorToday' ) ?></div>
        <div class="report_col" style="color: gray"><?php echo ($data_visit[ 'today' ][ 'num_visitor' ] ? $data_visit[ 'today' ][ 'num_visitor' ] : '0').' '.\f\ifm::t ( 'person' ) ; ?>  </div>
        <div class="clear"></div>
    </div>
    <div class="report_row">
        <div class="report_col"><?=  \f\ifm::t ( 'visitYesterday' ) ?></div>
        <div class="report_col" style="color: gray"><?php echo ($data_visit[ 'yesterday' ][ 'num_visit' ] ? $data_visit[ 'yesterday' ][ 'num_visit' ] : '0').' '.\f\ifm::t ( 'visit' ) ; ?>  </div>
        <div class="clear"></div>
    </div>
    <div class="report_row">
        <div class="report_col"><?=  \f\ifm::t ( 'visitorYestaerday' ) ?></div>
        <div class="report_col" style="color: gray"><?php echo ($data_visit[ 'yesterday' ][ 'num_visitor' ] ? $data_visit[ 'yesterday' ][ 'num_visitor' ] : '0').' '.\f\ifm::t ( 'person' ) ; ?>  </div>
        <div class="clear"></div>
    </div>
    <div class="report_row">
        <div class="report_col"><?=  \f\ifm::t ( 'maxDayVisit' ) ?></div>
        <div class="report_col" style="color: gray"><?php echo $maxDate?> - <?php echo $data_visit[ 'max' ][ 'num_visit' ] .' '.\f\ifm::t ( 'visit' ) ; ?> </div>
        <div class="clear"></div>
    </div>


</div>
<?
echo $boxWidget->flush () ;
?>