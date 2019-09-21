
<?php
/* @var $pageWidget \f\w\pageTitle */
$pageWidget = \f\widgetFactory::make ( 'pageTitle' ) ;
echo $pageWidget->renderTitle ( array ( 'title' => \f\ifm::t ( 'menus' ), 'links' => array ( array ( 'title'    => '+ ' . \f\ifm::t ( 'add_menu' ), 'href'     => \f\ifm::app ()->baseUrl . 'cms/menu/menuAdd/' . $section_id ,
    ) ) ) ) ;
/* @var $boxWidget \f\w\box */
$boxWidget = \f\widgetFactory::make ( 'box' ) ;
echo $boxWidget->begin ( array ( 'type'  => 'table', 'title' => \f\ifm::t ( 'list' ) . \f\ifm::t ( 'menus' ) ) ) ;
echo $row ;
echo $boxWidget->flush () ;
?> 
<script>
   
    $(document).ready(function () {
        $('a.priorityup').on('click',function() {
            var priority=$(this).closest('tr').children('td.priup').find("input.priority").val();
            var id=$(this).closest('tr').attr('id');
           
              
            var options = {
                priority:priority,
                id:id,
                type:'Up'
            };
            widgetHelper.tt('ui', 'cms.menu.priority', options,'reloaddatatable');
        });
        
        $('a.prioritydown').on('click',function() {
            var priority=$(this).closest('tr').children('td.priup').find("input.priority").val();
            var id=$(this).closest('tr').attr('id');
            var options = {
                priority:priority,
                id:id,
                type:'Down'
            };
            widgetHelper.tt('ui', 'cms.menu.priority', options,'reloaddatatable');
        });
        
        
        $('#menuTable').dataTable({
            "bSort" : false,
            "paging": false
        });


    }); 
     
     
    function reloaddatatable(params)
    {  
        if(params.result=='success')
        {
            if(params.type=='Up'){
                var idRow=$('#menuTable').find('tr#'+params.id).html();
                $('#menuTable').find('tr#'+params.id).remove();  
                $('#menuTable').find('tr#'+params.parentId).before('<tr id="'+params.id+'">'+idRow+'</tr>');

                $('a.priorityup').on('click',function() {
                    var priority=$(this).closest('tr').children('td.priup').find("input.priority").val();
                    var id=$(this).closest('tr').attr('id');
                    
                    var options = {
                        priority:priority,
                        id:id,
                        type:'Up'
                    };
                    widgetHelper.tt('ui', 'cms.menu.priority', options,'reloaddatatable');
                });
        
                $('a.prioritydown').on('click',function() {
                    var priority=$(this).closest('tr').children('td.priup').find("input.priority").val();
                    var id=$(this).closest('tr').attr('id');
                    var options = {
                        priority:priority,
                        id:id,
                        type:'Down'
                    };
                    widgetHelper.tt('ui', 'cms.menu.priority', options,'reloaddatatable');
                });
            }
            if(params.type=='Down'){
                var idRow=$('#menuTable').find('tr#'+params.id).html();
                $('#menuTable').find('tr#'+params.id).remove();  
                $('#menuTable').find('tr#'+params.parentId).after('<tr id="'+params.id+'">'+idRow+'</tr>');

                $('a.priorityup').on('click',function() {
                    var priority=$(this).closest('tr').children('td.priup').find("input.priority").val();
                    var id=$(this).closest('tr').attr('id');
                    var options = {
                        priority:priority,
                        id:id,
                        type:'Up'
                    };
                    widgetHelper.tt('ui', 'cms.menu.priority', options,'reloaddatatable');
                });
        
                $('a.prioritydown').on('click',function() {
                    var priority=$(this).closest('tr').children('td.priup').find("input.priority").val();
                    var id=$(this).closest('tr').attr('id');
                    var options = {
                        priority:priority,
                        id:id,
                        type:'Down'
                    };
                    widgetHelper.tt('ui', 'cms.menu.priority', options,'reloaddatatable');
                });
            }

        }
        
        
    }
     
</script>

<style>
    .listslideUser{
        float:left;
        clear:both;
    }
</style>
