<script>
    var checkedAction = [];
    var widgetTree = {
        
        selectTree : function(treeid, contentid){
            $('#'+treeid).on('select_node.jstree', function (e, data)
            {
               
                var selected = $('#'+treeid).jstree('get_selected');
                
                var html = '';
                html +="<div id='"+data.node.id+"hid'>";    
                for(var i = 0; i < selected.length; i++){
                    var id = selected[i];  
                    
                    $('#'+treeid).jstree('open_node', '#'+id); 
                }
                
                if($('#'+treeid).data('editLoad')){
                    $('#'+treeid).jstree('select_node', '#'+selected[0]); 
                }
                html += widgetTree.getChild(selected, treeid);
                html +="</div>";
                $('#'+contentid).append(html);
                
            
            });
        },
        getChild : function(selected, treeid){
            var path;
            var html = '';
            for(var i = 0; i < selected.length; i++){
                var id = selected[i]
                 
                var node = $('#'+id).data();
                if(node.type && node.id){
                    if($('#'+treeid).data('editLoad')){
                    
                        if(checkedAction.indexOf(node.path) == -1){
                        
                            $('#'+treeid).jstree("uncheck_node", $('li[data-path="'+node.path+'"]').last());
                        }
                        else{
                            path = node.path.replace(/\./g,'_');   
                            $('#'+path+'exclude').remove();
                            $('#'+id+'exclude').remove();
                            if($('#'+path+'hid').size()==0){
                                html += '<span id="'+path+'hid"><input type="hidden" name="type[]" value="' + node.type + '" ><input type="hidden" name="m_id[]" value="' + node.id + '" ></span>';
                            }
                            
                        
                        }
                    }
                    else{
                        path = node.path.replace(/\./g,'_'); 
                        if($('#'+path+'hid').size()==0){
                            html += '<span id="'+path+'hid"><input type="hidden" name="type[]" value="' + node.type + '" ><input type="hidden" name="m_id[]" value="' + node.id + '" ></span>';
                        }
                    
                    }
                        
                }
                        
       
            }
            return html;
        }
        ,
        checkTree : function(treeid,contentDv ,filterContent, excludeDv){
            
            widgetTree.setHasFilters(treeid);
            $('#'+treeid).jstree('close_all');
            widgetTree.selectTree(treeid, contentDv);
            widgetTree.deselect_tree(treeid, excludeDv);
            setTimeout(function(){
            
            
            }, 2000)
            
            
            $('#'+treeid).data('editLoad', 1);
            var i=0;
            var j=0;
            
<?php
if ( ! empty ( $row_action ) )
{
    foreach ( $row_action as $data )
    {
        ?>
                            var path1 = '<?php echo $data[ 'path' ] ; ?>';              
                                                                                      
                            //   openBranch(path1,'action');
                            checkedAction[i] = path1;
                            i++;
                            // console.log($('#'+treeid+' li[data-path="'+path1+'"] a .jstree-checkbox').last().addClass('enable'));  
                            $('#'+treeid+' li[data-path="'+path1+'"] a .jstree-checkbox').last().addClass('enable')       
                            $('#'+treeid).jstree('select_node', $('#'+treeid+' li[data-path="'+path1+'"]').last());
                                                                                            
                                                                                                     
        <?php
    }
}
?>  
          
<?php
if ( ! empty ( $row_ui ) )
{
    foreach ( $row_ui as $data )
    {
        ?>
                            var path2 = '<?php echo $data[ 'path' ] ; ?>'; 
                                                                                                                                                                                                                                                                                                                                                               
                            checkedAction[i] = path2;                                                                     
                            widgetTree.openBranch(treeid,path2);
                                                                                                                                                                                                                                                                                         
                            i++; 
                                                                            
                            $('#'+treeid+' li[data-path="'+path2+'"]').last().find('a .jstree-checkbox').first().addClass('enable');
                            $('#'+treeid+' li[data-path="'+path2+'"]').last().children('ul').find('li a .jstree-checkbox').first().addClass('enable');
                            $('#'+treeid).jstree('select_node', $('#'+treeid+' li[data-path="'+path2+'"]').last()); 
                                                                                                   
                            j++;  
                                                                                                                                                                                                                                                                                                 
        <?php
    }
}
?>  
   
<?php
//if ( ! empty ( $row_actionFilter ) )
//{
//    foreach ( $row_actionFilter as $data )
//    {

        ?>
//                            var path = "<?php echo $data[ 'path' ] ; ?>";
//                            path = path.replace(/\./g,'_'); 
//                                                                           
//                            var html = '<div id="'+path+'filterDiv"><input type="hidden" name="rpaf_id[]" value=""><input type="hidden" name="action_filterid[]" value="<?php echo $data[ 'core_actionid' ] . '-' . $data[ 'core_filterid' ] ; ?>"></div>';
//                                                                                                                                
//                            $('#'+filterContent).append(html);                
        <?php
//    }
//}
?>  

<?php
//if ( ! empty ( $row_roleActionFilter ) )
//{
//    foreach ( $row_roleActionFilter as $data )
//    {
        ?>
//                            var path = "<?php// echo $data[ 'path' ] ; ?>";
//                            path = path.replace(/\./g,'_'); 
//                                                                           
//                            var html = '<div id="'+path+'filterDiv"><input type="hidden" name="rpaf_id[]" value="<?php// echo $data[ 'id' ]; ?>"><input type="hidden" name="action_filterid[]" value="<?php// echo $data[ 'core_actionid' ] . '-' . $data[ 'core_filterid' ] ; ?>"></div>';
//                                                                                                                                
//                            $('#'+filterContent).append(html);                
        <?php
//    }
//}
?>  
            
 
<?php
if ( ! empty ( $row_actionExclude ) )
{
    foreach ( $row_actionExclude as $data )
    {
        ?>
                            var pathEx = '<?php echo $data[ 'path' ] ; ?>'; 
                                                    
                            $('#'+treeid).jstree('deselect_node',$('#'+treeid+' li[data-path="'+pathEx+'"]').last());
        <?php
    }
}
?>  
            
        }
        ,
        setHasFilters :  function(treeid){
            $('#'+treeid).jstree('open_all');
            var liid = $('#'+treeid+" ul li").first().attr('id')
            $('#'+liid).hide();
            var html;
<?php
foreach ( $has_filters as $data )
{
    ?>
                    html = '<a  style="cursor:pointer;" class="selectFilter" id="selectFilter<?php echo $data[ 'filter_maker_id' ] ; ?>">&nbsp;<?php echo \f\ifm::t ( 'selectFilter' ) ; ?></a>';
                    html +=   '<input type="hidden" name="filter_maker_id" class="filter_maker_id" value="<?php echo $data[ 'filter_maker_id' ] ; ?>">';
                    html +=   '<input type="hidden" name="actionID" class="actionID" value="<?php echo $data[ 'id' ] ; ?>">';
                    $('#'+treeid+" li[data-path='<?php echo $data[ 'path' ] ; ?>']").append(html);
                                                                       

                                                                                            
<?php } ?>
        },
        
        openBranch : function(treeid,path){
            var liid = $('#'+treeid+" ul li").first().attr('id')
            
            $('#'+treeid).jstree('open_node', $('#'+liid).next());  
           
       
            var arr = path.split('.'); 
     
            for(var i=0; i<arr.length-1; i++){
          
                $('#'+treeid).jstree('open_node', $('li[data-path="'+arr[i]+'"]').last()); 
           
            }
        },
        deselect_tree : function(treeid, excludeDv){
            $('#'+treeid).on('deselect_node.jstree', function (e, data){
            
                var id = data.node.id;
                var pr_id = $('#'+id).parents('.permissionRow').find('.permissionId').val();
                var html = '';
                if(data.node.data.path){
                    var path = data.node.data.path.replace(/\./g,'_');  
                    $('#'+path+'hid').remove();
                    $('#'+id+'hid').remove();
                    $('#'+path+'filterDiv').remove();
                    html +="<div id='"+data.node.id+"exclude'>";    
                    html += '<span id="'+path+'exclude"><input type="hidden" name="type_ex[]" value="' + data.node.data.type + '" ><input type="hidden" name="m_id_ex['+pr_id+'][]" value="'+ data.node.data.id + '" ></span>';
                    html +="</div>";
                    $('#'+excludeDv).append(html);
                }  
            
            
            
            })
        },
        
        selectFilter :  function(obj , treeid, filterDiv, pr_id){
            var filter_maker_id = obj.siblings('.filter_maker_id').val();
            var actionID = obj.siblings('.actionID').val();
            var path = obj.parent().attr('data-path');
            var rp_id = $('#'+treeid).parents('.permissionRow').find('.rp_id').val();
            //var filterid = 0 ;
            
            $('#'+treeid).jstree('select_node', '#'+obj.parent().attr('id')); 
<?php
//if ( $row_action )
//{
//    foreach ( $row_action as $data )
//    {
?>
            //                            if(actionID == '<?php // echo $data[ 'core_actionid' ] ;       ?>'){
            //                                filterid = "<?php // echo $data[ 'core_filterid' ] ;       ?>";  
            //                                                     
            //                            }
                                        
<?php
//    }
//}
?>
            $.ajax({
                url: "<?= \f\ifm::app ()->baseUrl ?>core/rbac/renderMethodFilters/",
                type: 'POST',
                data :{
                    filter_maker_id : filter_maker_id,
                    actionID : actionID,
                    pr_id : pr_id,
                    filterDiv : filterDiv,
                    path : path,
                    rp_id : rp_id
                },
                success: function (response) {
                    if (response !== '')
                    {
                       
                        $('#filterDialog .modal-body').html(response);
                        //  $('#codeTree').html(response);
                        //  selectTree();
                        // confirmSelected();
                    
                    }
                    
                }
            });
            $('#filterDialog').modal()
        }
        
    }
</script>
