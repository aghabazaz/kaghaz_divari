<style>
    .fileItem{
        float: right;
        width: 80px;
        height: 80px;
        margin-right: 20px;
        margin-top: 10px;
        margin-bottom: 10px;
       line-height:80px;
        border: 1px solid rgb(231, 231, 231);
        cursor: pointer;
       
    }
    .fileItem:hover{
        -webkit-box-shadow: 0px 0px 6px 1px rgba(3,39,107,0.82);
        -moz-box-shadow: 0px 0px 6px 1px rgba(3,39,107,0.82);
        box-shadow: 0px 0px 6px 1px rgba(3,39,107,0.82);
        border-color: white;
        /*        border: 1px solid rgb(53, 126, 189);*/
    }

    .imgItem{
        max-width: 78px;
        max-height: 78px;
        vertical-align: middle;
        margin:auto;
       
        
    }

    .largeImgItem{
        border: 1px solid  rgb(255, 242, 0);
        /*        box-shadow: 1px 1px 1px black;*/
        display: none;
        position: fixed;
        direction: ltr;
        z-index: 9500;
        opacity: 0.95;

    }
    .largeImgItem img{
        max-width: 400px;
        max-height: 600px;
    }

    #fileSelectContainer{
        margin-top: 20px;
        height: 170px;
        overflow-y: scroll;        
    }

    #selectFileToggle{
        border: 1px solid rgb(232, 227, 227);
        padding: 4px;
        background-color: whitesmoke;
        cursor: pointer;
        margin-right: 20px;
        margin-bottom: 20px;
        width: 150px;
    }
    #selectFileToggle:hover{
        background-color:rgb(53, 126, 189);
        color: white;

    }

    #selectFileToggle.showState > span.downBtn{
        display: none;
    }

    #selectFileToggle.showState > span.topBtn{
        display: inline;
    }    

    #selectFileToggle.hideState > span.downBtn{
        display: inline;
    }

    #selectFileToggle.hideState > span.topBtn{
        display: none;
    }        

</style>
<div style="float:right">
 <div data-toggle='show' id="selectFileToggle" class="showState" style="height:34px"><?= \f\ifm::t('selectFromExistingFiles') ?> &nbsp;&nbsp;<span class='downBtn'> ˅</span><span class='topBtn'> ˄</span></div>
   
</div>
<div style="float:right;margin-right:10px;width:300px">
 <input class="form-control" type="text" id="search" placeholder="جستجو بر اساس عنوان تصویر ...." onkeyup="searchImage()">   
</div>

 <div class='clear'></div>
 <div id="searchResult"></div>
<div id='fileSelectContainer' style="height:200px">

    <?php
    //\f\pr($files);
    foreach ( $files as $file )
    {
        if($file['type']=='file')
        {
            ?>
            <div class="largeImgItem" data-id="<?= $file[ 'id' ] ?>">
                <img src="<?= \f\ifm::app()->fileBaseUrl . $file[ 'id' ] ?>">
            </div>
            <div class="fileItem" data-id="<?= $file[ 'id' ] ?>">
                <img class='imgItem' src="<?= \f\ifm::app()->fileBaseUrl . $file[ 'id' ] ?>">
            </div>
            <?php
        } 
    
    } ?>
    <div class='clear'></div>
</div>


<script>
    function searchImage()
    {
        var q=($('#search').val());
        
        if(q.length >=3)
        {
           var options = {
            id: q
 
            }; 
            widgetHelper.addLoading();
            widgetHelper.tt("ui", "core.fileManager.searchFileByTitle", options, "searchResult");
            widgetHelper.removeLoading();
        }
        else
        {
             $('#searchResult').html('');
        }
    }
    
    function searchResult(params)
    {
        $('#searchResult').html(params.content);
        
        $('.fileItem').click(function () {
            refreshImage({
                mode: 'select',
                fileUrl: $(this).children('img').attr('src'),
                fileId: $(this).attr('data-id')
            });
        });
    }

    $(document).ready(function () {
        
//        $('.fileItem').mouseenter(function (e) {
////            console.log(e);
//
//////
////            console.log(mouseX);
////            console.log(mouseY);
//            largeImageSelector = '.largeImgItem[data-id=' + $(this).attr('data-id') + ']';
//
//            position = $(this).position();
//            console.log(position);
//
//            mouseX = (position.left + 20) + 'px';
//            mouseY = (position.top + 140) + 'px';
//
//            $(largeImageSelector).css('left', mouseX).css('top', mouseY).css('position', "absolute");
//            $(largeImageSelector).slideDown(200);
//
////        console.log()
//        });
//        $('.fileItem').mouseleave(function (e) {
////        console.log(e);
//            largeImageSelector = '.largeImgItem[data-id=' + $(this).attr('data-id') + ']';
////
//            $(largeImageSelector).slideUp(100);
//        });

        $('#selectFileToggle').click(function () {
            if ($(this).attr('data-toggle') === 'hide') {
                $('#fileSelectContainer').slideDown(400);
                $(this).attr('data-toggle', 'show');
                $(this).attr('class', 'showState');
            }
            else
            {
                $('#fileSelectContainer').slideUp(200);
                $(this).attr('data-toggle', 'hide');
                $(this).attr('class', 'hideState');
            }
        });

    });


</script>
<?php
