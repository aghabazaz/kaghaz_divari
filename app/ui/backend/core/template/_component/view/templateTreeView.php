<link rel="stylesheet" href="<?= f\ifm::app ()->componentBaseUrl . 'view/lib/jstree/dist/themes/default/style.min.css' ?>" />
<script src="<?= f\ifm::app ()->componentBaseUrl . 'view/lib/jstree/dist/jstree.js' ?>"></script>

<style>
    .rtl .tree-classic li.open {
        background-position:right 5px;
        margin-right:-3px;
        padding-right:19px;
    }   
    .rtl .tree-classic li.closed {
        background-position:right 5px;
        margin-right:-3px;
        padding-right:19px;
    }
    .rtl .tree-classic #dragged li.open {
        background-position: right 5px;
    }    

    li a{
        font-family: Yekan,Tahoma;
        font-size: 13px ;
    }
</style>
<?
/* @var $pageWidget \f\w\pageTitle */
$pageWidget = \f\widgetFactory::make ( 'pageTitle' ) ;
echo $pageWidget->renderTitle ( array ( 'title' => \f\ifm::t ( 'templateTreeView' ) ) ) ;


$dialogWidget = \f\widgetFactory::make ( 'dialog' ) ;
$dialog       = $dialogWidget->begin ( array (
    'htmlOptions' => array (
        'id'    => 'editDialog'
    )
    ,
    'title' => array (
        'text'  => \f\ifm::t ( "documentTheTemplate" )
    ),
    'style' => array (
        'width' => '800px',
        
    ),
    'body'=>array(
        'style'=>array(
            'height'=>'430px',
            'overflow-y'=>'scroll',
            'direction'=>'ltr',
            'overflow-x'=>'hidden',
        )
    )
        ) ) ;
$dialog .= $dialogWidget->flush ( array ( ) ) ;
echo $dialog ;

//echo $editDialog;
?>
<?= $treeMarkup ?>

<script>

    var editDialogManager = {
       
        getFormMarkup: function (data) {
            var url;
            if(data['type']==='template')
            {
                url="<?= \f\ifm::app ()->baseUrl ?>core/template/documentTheTemplate";
            }
            else
            {
                url="<?= \f\ifm::app ()->baseUrl ?>core/template/sourceCode";
            }
                
            $.ajax({
                url:url,
                data: {type: data["type"], path: data["path"]},
                type: 'POST',
                success: function (response) {
                    if (response !== '')
                    {
                        $('#editDialog .modal-body').html(response);
                        //  widgetHelper.refreshUIElements();
                        $('form').parsley();
                        $('#methodForm').off('submit');
                       
                        
                    }
                    else
                    {
                        alert('New markup is empty !');
                    }
                }
            });
        },
        mousePosition: function () {
            document.addEventListener('mousemove', function (e) {
                x = e.clientX || e.pageX;
                y = e.clientY || e.pageY;
                return [x, y];
            }, false);
        },
        openEditDialog: function () {
            $("#editDialog").dialog({
                modal: true,
                width: 800,
                position: editDialogManager.mousePosition(),
                title: '<?= \f\ifm::t ( 'documentTheCode' ) ?>'
            });
        }
    };

    $(document).ready(function () {
        $('#jstree').jstree({
            "plugins": ["html_data", "dnd", "ui"]
        });
        $('#jstree').on("changed.jstree", function (e, data) {
            if (typeof (data.node.data.path) === 'undefined')
            {
                return false;
            }
            newMarkup = editDialogManager.getFormMarkup(data.node.data);
            $('#editDialog').modal()
            //  
            // editDialogManager.openEditDialog();
        });

         
         widgetHelper.formSubmit('#templateForm'); 
         
         
    });
    
    function getDocForm(){
        
    }
</script>
