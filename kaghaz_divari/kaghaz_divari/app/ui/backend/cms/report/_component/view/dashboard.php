<?php
$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;

$boxWidget = $this->boxW ;
$this->registerGadgets ( array ( 'dateG' => 'date' ) ) ;
//$this->

echo $this->pageTitleW->renderTitle ( array (
    'title' => \f\ifm::t ( 'report' ),
) ) ;

echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'row' ) ) ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'col-md-6' ) ) ) ;
include_once 'parts/visitInfo.php' ;
include_once 'parts/lastVisitToday.php' ;
echo \f\html::markupEnd ( 'div' ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'col-md-6' ) ) ) ;

include_once 'parts/monthVisit.php' ;
include_once 'parts/alexa.php' ;
include_once 'parts/browser.php' ;
include_once 'parts/country.php' ;
include_once 'parts/os.php' ;
echo \f\html::markupEnd ( 'div' ) ;
echo \f\html::markupEnd ( 'div' ) ;
?>
<script>
    $(document).ready(function () {
        getChartByDate('monthVisit', 'visit_inf', 'date', 'all', 'chartLine',30);
        //getChartByDate('leadDay', 'crm_lead', 'date_register', 'all', 'chartLine', 30);
        //getChartByDate('accountDay', 'crm_account', 'date_register', 'all', 'chartLine', 30);
        //getChartByCount('accountStatus', 'crm_account', 'industrial_groupid', 'all', 'makeChart');
        getChartByCount('browser', 'visit_browser', 'browserName', 'all', 'chartPie');
        getChartByCount('country', 'visit_country', 'countryName', 'all', 'chartPie');
        getChartByCount('os', 'visit_os', 'osName', 'all', 'chartPie');
    });

    function getChartByCount(id, tbl, col, user, graphtype) {
        var options = {
            id: id,
            user: user,
            tbl: tbl,
            col: col,
            siteId:<?=$siteId?>
        };
        //$('#' + id).html('');
        //$("#" + id + "-tab li").removeClass("active");
        //$("#" + graphtype + '-' + id).addClass("active");
        widgetHelper.tt("ui", "core.visit.getChartByCount", options, graphtype);
    }

    function getChartByDate(id, tbl, col, user, graphtype, numDay)
    {
        var options = {
            id: id,
            user: user,
            tbl: tbl,
            col: col,
            numDay: numDay,
            site_id:<?=$siteId?>
        };
        //$("#" + id + "-tab li").removeClass("active");
        //$("#" + graphtype + '-' + id).addClass("active");
        widgetHelper.tt("ui", "core.visit.getChartByDate", options, graphtype);
    }



</script>

<style>
    .report_row {
        border-bottom: 1px solid #eee;
        padding: 10px 0;
    }
    .report_col {
        float: right;
        width: 50%;
    }
    .report_col1 {
        float: right;
        width: 40%;
    }
    .report_col2 {
        float: right;
        width: 30%;
    }
    .title_tbl 
    {
        font-size: 13px;
        text-align: center;
    }
    .jqplot-data-label
    {
        color:white;
    }
</style>