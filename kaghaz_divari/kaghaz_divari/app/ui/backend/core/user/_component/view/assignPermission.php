<style>
    .btnToggle , .logicToggle{
        border: 1px solid rgb(232, 227, 227);
        padding: 4px;
        background-color: whitesmoke;
        cursor: pointer;
        margin-left: 20px;
        margin-bottom: 20px;
        width: 35px;
    }
    .btnToggle:hover , .logicToggle:hover{
        background-color:rgb(53, 126, 189);
        color: white;

    }

    .btnToggle.showState > span.downBtn{
        display: none;
    }

    .btnToggle.showState > span.topBtn{
        display: inline;
    }    

    .btnToggle.hideState > span.downBtn{
        display: inline;
    }

    .btnToggle.hideState > span.topBtn{
        display: none;
    }   


    .logicToggle.showState > span.downBtn{
        display: none;
    }

    .logicToggle.showState > span.topBtn{
        display: inline;
    }    

    .logicToggle.hideState > span.downBtn{
        display: inline;
    }

    .logicToggle.hideState > span.topBtn{
        display: none;
    }   

    .permissionRow{
        border : 1px solid #eee;
        width : 100%;
        padding: 10px;
        margin-bottom: 10px;
    }

    .logicRow, .codeTree{
        border : 1px solid #eee;
        border-radius: 3px;
        padding: 10px;
        margin-bottom: 10px;
    }


</style>

<div id="contentDv">


    <?php
    if ( $row[ 'type' ] == 'backend' && $row[ 'personality' ] == 'real' )
    {
        $userParam = 'mainUser' ;
    }
    else if ( $row[ 'type' ] == 'backend' && $row[ 'personality' ] == 'legal' )
    {
        $userParam = 'colleagueUser' ;
    }
    else if ( $row[ 'type' ] == 'frontend' && $row[ 'personality' ] == 'real' )
    {
        $userParam = 'memberUser' ;
    }
    else
    {
        $userParam = 'siteUser' ;
    }

    /* @var $pageWidget \f\w\pageTitle */
    $pageWidget = \f\widgetFactory::make ( 'pageTitle' ) ;
    echo $pageWidget->renderTitle ( array ( 'title' => \f\ifm::t ( 'permissionAssign' ),
        'links' => array ( array ( 'title' => \f\ifm::t ( 'listUser' ), 'href'  => \f\ifm::app ()->baseUrl . 'core/user/' . $userParam  ) ) ) ) ;

    /* @var $boxWidget \f\w\box */
    $boxWidget = \f\widgetFactory::make ( 'box' ) ;
    echo $boxWidget->begin ( array ( 'type'  => 'form', 'title' =>  \f\ifm::t ( 'permissionAssign' ) ) ) ;

    /* @var $form \f\w\form */

    $form  = \f\widgetFactory::make ( 'form' ) ;
    $form1 = '' ;
    $form1 .= $form->begin ( array (
        'htmlOptions' => array (
            'method' => 'post',
            'action' => \f\ifm::app ()->baseUrl . 'core/rbac/userSave',
            'id'     => 'permissionAssign'
        ),
            ) ) ;

    $form1 .= $form->input ( array (
        'htmlOptions' => array (
            'type'  => 'hidden',
            'name'  => 'userid',
            'id'    => 'userid',
            'value' => $userid
        )
            ) ) ;


    $form1.= $form->rowStart () ;
    
    $i     = 0 ;
    $j     = 0 ;
    $check = array ( ) ;
    $rp_id = array ( ) ;
    if ( $user_permission )
    {
        foreach ( $permission as $data )
        {

            $check[ $j ] = '' ;
            $rp_id[ $j ] = '' ;
            foreach ( $user_permission as $rp )
            {
                if ( $rp[ 'core_permissionid' ] == $data[ 'id' ] )
                {
                    $check[ $j ] = 'checked' ;
                    $rp_id[ $j ] = $rp[ 'id' ] ;
                }
            }
            $j ++ ;
        }
    }


    foreach ( $permission as $data )
    {

        $form1 .= '<div class="permissionRow">' ;
        $form1 .= '<label style="float:right;width:30%;" class="control-label">' . $data[ 'title' ] . '</label>' ;
        $form1 .= '<div style="float:right;width:15%;margin-right:20px;" ><input id="permissionId' . $i . '" class="permissionId checkBox" type="checkbox" ' . $check[ $i ] . '  value="' . $data[ 'id' ] . '" name="permissionId[]"  ><input type="hidden" class="rp_id" name="rp_id[' . $data[ 'id' ] . ']" value="' . $rp_id[ $i ] . '"></div>' ;

        $form1 .= '<div style="float:right;width:10%"><div data-toggle="hide" id="selectMethodToggle' . $data[ 'id' ] . '" style="float:right;width:60px;" class="btnToggle hideState"> ' . \f\ifm::t ( 'methods' ) . ' &nbsp;&nbsp;<span class="downBtn"> ˅</span><span class="topBtn"> ˄</span></div></div>' ;
        $form1 .= '<div style="float:right;width:15%"><div data-toggle="hide" id="selectLogicToggle' . $data[ 'id' ] . '" style="float:right;width:150px;" class="logicToggle hideState"> ' . \f\ifm::t ( 'logics' ) . ' &nbsp;&nbsp;<span class="downBtn"> ˅</span><span class="topBtn"> ˄</span></div></div>' ;

        $form1 .= '<div class="clear"></div>' ;
        $form1 .= "<div id='logicRow$i' class='logicRow' style='margin-right:10px;display:none;max-height:200px'></div>" ;
        $form1 .= '<div class="clear"></div>' ;
        $form1 .= "<div id='codeTree$i' class='codeTree' style='margin-right:10px;display:none;max-height:200px'>" ;
//        $form1 .= \f\ttt::ui ( 'ui.backend.core.rbac.renderRolePermission',
//                           array ( 'permissionid' => $data[ 'id' ] ) ) ;
//$form1 .= \f\ttt::ui ( 'ui.backend.core.code.viewSelectableCodesList') ;
        $form1 .= "</div>" ;
        $form1 .= '</div>' ;
        $i ++ ;
    }

    $form1.=$form->rowEnd () ;


    $form1.=$form->rowStart () ;

    $form1 .= $form->button ( array (
        'htmlOptions' => array (
            'type'   => 'submit',
            'id'     => 'save',
        ),
//        'style' =>array(
//            'display' => 'none'
//        ),
        'inline' => array (
        ),
        'content' => \f\ifm::t ( 'submit' )
            ) ) ;
    $form1.=$form->rowEnd () ;

    $form1 .= $form->rowEnd () ;

    $form1 .= $form->flush () ;

    echo $form1 ;

    $dialogWidget     = \f\widgetFactory::make ( 'dialog' ) ;
    $FConfilictDialog = $dialogWidget->begin ( array (
        'htmlOptions' => array (
            'id'    => 'confilictDialog'
        )
        ,
        'title' => array (
            'text'  => \f\ifm::t ( "selectFilter" )
        ),
        'style' => array (
            'width' => '700px'
        )
            ) ) ;
    $FConfilictDialog .= $dialogWidget->flush ( array ( ) ) ;

    $CFlogicDialog = $dialogWidget->begin ( array (
        'htmlOptions' => array (
            'id'    => 'CFlogicDialog'
        )
        ,
        'title' => array (
            'text'  => \f\ifm::t ( "logicSettings" )
        ),
        'style' => array (
            'width' => '700px'
        )
            ) ) ;
    $CFlogicDialog .= $dialogWidget->flush ( array ( ) ) ;

    echo $FConfilictDialog ;
    echo $CFlogicDialog ;
    ?>
</div>
<script>
    $(function(){
        widgetHelper.formSubmit('#userForm');
        
        setTimeout(function () {
            $('.codeTree').niceScroll({cursorcolor: "#00F"});
        }, 200);
        
        setTimeout(function () {
            $('#confilictDialog').niceScroll({cursorcolor: "#00F"});
        }, 200);
        
        setTimeout(function () {
            $('#CFlogicDialog').niceScroll({cursorcolor: "#00F"});
        }, 200);
        
        $('#contentDv').on('click', '.btnToggle, .logicToggle', function () {
            
            if ($(this).attr('data-toggle') === 'hide') {
                var permissionid = $(this).parents('.permissionRow').find('.permissionId').val();
                var rp_id =$(this).parents('.permissionRow').find('.rp_id').val();
                
                if($(this).is('.btnToggle')){
                    var treeDv =$(this).parents('.permissionRow').find('.codeTree');
                    
                    if(treeDv.find('.jstree').size() == 0){
                        $.ajax({
                            url: "<?= \f\ifm::app ()->baseUrl ?>core/rbac/renderRolePermission/",
                            data : {
                                permissionid : permissionid,
                                rp_id : rp_id
                            },
                            type: 'POST',
                
                            success: function (response) {
                                if (response !== '')
                                {
                       
                                    treeDv.html(response);
                    
                                }
                    
                            }
                        });
                    }
                    
            
                    $(this).parents('.permissionRow').find('.codeTree').slideDown(400);
                }
                else{
                    var logicDv =$(this).parents('.permissionRow').find('.logicRow');
                    var rp_id =$(this).parents('.permissionRow').find('.rp_id').val();
                    var userid = '<?php echo $row[ 'id' ] ; ?>'
                    // var userid = $('#userid').val();
                    $.ajax({
                        url: "<?= \f\ifm::app ()->baseUrl ?>core/rbac/renderRolePermissionLogic/",
                        data : {
                            permissionid : permissionid,
                            act : '<?php echo $title ; ?>',
                            rp_id : rp_id,
                            userid : userid
                        },
                        type: 'POST',
                
                        success: function (response) {
                            if (response !== '')
                            {
                       
                                logicDv.html(response);
                    
                            }
                    
                        }
                    });
                    
                    $(this).parents('.permissionRow').find('.logicRow').slideDown(400);
                }
                
                
                
                $(this).attr('data-toggle', 'show');
                $(this).removeClass('hideState');
                $(this).addClass('showState');
            }
            else
            {
                if($(this).is('.btnToggle')){
                    $(this).parents('.permissionRow').find('.codeTree').slideUp(200);
                }
                else{
                    $(this).parents('.permissionRow').find('.logicRow').slideUp(200);
                }
                
                $(this).attr('data-toggle', 'hide');
                $(this).removeClass('showState');
                $(this).addClass('hideState');
            }
        });
    })
    //--------------------------------------------------------------------------
    function renderConfilict(params){
       
        if(params.conflict){
            $.ajax({
                url: "<?= \f\ifm::app ()->baseUrl ?>core/rbac/renderConfilict/",
                data : params.conflict,
                type: 'POST',
                
                success: function (response) {
                    if (response !== '')
                    {
                       
                        $('#confilictDialog').modal()
                        $('#confilictDialog .modal-body').html(response);
                    
                    }
                    
                }
            });
        }
        
        if(params.logicSetting){
            $.ajax({
                url: "<?= \f\ifm::app ()->baseUrl ?>core/rbac/renderConfilictLogicSetting/",
                data :{
                    param : params.logicSetting,
                    userid : params.userid
                } ,
                type: 'POST',
                
                success: function (response) {
                    if (response !== '')
                    {
                       
                        $('#CFlogicDialog').modal()
                        $('#CFlogicDialog .modal-body').html(response);
                    
                    }
                    
                }
            });
        }
        
    }
</script>