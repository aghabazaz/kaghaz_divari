
<div id="methodDiv">


    <?php
    /* @var $form \f\w\form */
    $form1 = '' ;
    $form  = \f\widgetFactory::make ( 'form' ) ;

    echo $form->begin ( array (
        'htmlOptions' => array (
            'method' => 'post',
            'action' => \f\ifm::app ()->baseUrl . 'core/code/documentSave',
            'id'     => 'methodForm'
        ),
    ) ) ;



    $form1 .= $form->input ( array (
        'htmlOptions' => array (
            'type'     => 'text',
            'name'     => 'typeComponent',
            'value'    => $type,
            'readonly' => true
        ),
        'style'    => array (
            'direction' => 'rtl',
        ),
        'label'     => array (
            'text'  => \f\ifm::t ( 'typeComponent' ),
        ),
        'block' => array ( )
            ) ) ;


    $form1 .= $form->input ( array (
        'htmlOptions' => array (
            'type'  => 'hidden',
            'name'  => 'typeComp',
            'id'    => 'typeComp',
            'value' => $typeComp
        )
            ) ) ;

    $form1 .= $form->input ( array (
        'htmlOptions' => array (
            'type'  => 'hidden',
            'name'  => 'parent_id',
            'value' => isset ( $parent[ 'id' ] ) ? $parent[ 'id' ] : null
        )
            ) ) ;

    $form1 .= $form->input ( array (
        'htmlOptions' => array (
            'type'  => 'hidden',
            'name'  => 'id',
            'id'    => 'm_id',
            'value' => isset ( $row[ 'id' ] ) ? $row[ 'id' ] : ''
        )
            ) ) ;

    $form1 .= $form->input ( array (
        'htmlOptions' => array (
            'type'  => 'hidden',
            'name'  => 'path',
            'value' => isset ( $row[ 'path' ] ) ? $row[ 'path' ] : $path
        )
            ) ) ;

//    $form1 .= $form->rowStart () ;
    $form1 .= $form->input ( array (
        'htmlOptions' => array (
            'type'       => 'text',
            'name'       => 'name',
            'readonly'   => true,
            'value'      => ( ! empty ( $row )) ? $row[ 'name' ] : $name
        ),
        'validation' => array (
            'required' => ''
        )
        ,
        'style'    => array (
            'direction' => 'rtl',
        ),
        'label'     => array (
            'text'  => \f\ifm::t ( 'name' ),
        ),
        'block' => array ( )
            ) ) ;
//    $form1 .= $form->rowEnd () ;

    $form1 .= $form->input ( array (
        'htmlOptions' => array (
            'type'       => 'text',
            'name'       => 'title',
            'value'      => ( ! empty ( $row )) ? $row[ 'title' ] : ''
        ),
        'validation' => array (
            'required' => ''
        )
        ,
        'style'    => array (
            'direction' => 'rtl',
        ),
        'label'     => array (
            'text'  => \f\ifm::t ( 'title' ),
        ),
        'block' => array ( )
            ) ) ;


    $form1 .= $form->select ( array (
        'htmlOptions' => array (
            'name'  => 'type'
        ),
        'label' => array (
            'text'  => \f\ifm::t ( 'type' ),
        ),
        'block' => array ( ),
        'choices'  => $typeArr,
        'selected' => $row[ 'type' ] ? $row[ 'type' ] : ''
            ) ) ;

    $form1.= $form->radio ( array (
        'htmlOptions' => array (
            'name'    => 'status',
            'class'   => 'info',
        ),
        'choices' => array (
            \f\ifm::t ( 'enabled' )  => 'enabled',
            \f\ifm::t ( 'disabled' ) => 'disabled'
        ),
        'label'                  => array (
            'text'    => \f\ifm::t ( 'status' ),
        ),
        'checked' => ($row[ 'status' ]) ? $row[ 'status' ] : 'enabled',
        'linear'  => TRUE,
        'block'   => array ( )
            ) ) ;
    if ( $type == 'ui' )
    {
        $form1.= $form->radio ( array (
            'htmlOptions' => array (
                'name'    => 'filter_type',
                'class'   => 'info',
            ),
            'choices' => array (
                \f\ifm::t ( 'filter' )     => 'filter',
                \f\ifm::t ( 'has_filter' ) => 'hasFilter',
                \f\ifm::t ( 'none' )       => 'none'
            ),
            'label'                    => array (
                'text'    => \f\ifm::t ( 'filter_type' ),
            ),
            'checked' => ($row[ 'filter_type' ]) ? $row[ 'filter_type' ] : 'none',
            'linear'  => TRUE,
            'block'   => array ( )
                ) ) ;
    }

    $form1 .= $form->select ( array (
        'htmlOptions' => array (
            'name'  => 'filter_maker_id'
        ),
        'label' => array (
            'text'  => \f\ifm::t ( 'filter' ),
        ),
        'block' => array ( ),
        'choices'  => $filterAction,
        'selected' => $row[ 'filter_maker_id' ] ? $row[ 'filter_maker_id' ] : ''
            ) ) ;

    $form1 .= $form->textarea ( array (
        'htmlOptions' => array (
            'name'  => 'description',
            'id'    => 'description'
        ),
        'style' => array (
            'height'  => '100px',
        ),
        'content' => ( ! empty ( $row )) ? $row[ 'description' ] : '',
        'label'   => array (
            'text'  => \f\ifm::t ( 'description' ),
        ),
        'block' => array ( )
            )
            ) ;


    $form2     = '' ;
    if ( ! $row_pr ) require 'paramForm.php' ;
    /* @var $tabWidget \f\w\tab */
    $tabWidget = \f\widgetFactory::make ( 'tab' ) ;

    $tabWidget->begin ( array (
        'htmlOptions' => array (
            'class' => 'mytabs'
        )
    ) ) ;

    $tabWidget->tab ( array (
        'active' => true,
        'title'  => array (
            'text'    => \f\ifm::t ( "documentation" ),
            'icon'    => 'fa-comment'
        ),
        'content' => array (
            'content' => $form1
        ),
        'block'   => array ( )
    ) ) ;

    if ( ! $row_pr )
    {
//        $tabWidget->tab ( array (
//            'title' => array (
//                'text'    => \f\ifm::t ( "parameters" ),
//                'icon'    => 'fa-download'
//            ),
//            'content' => array (
//                'content' => $form2
//            )
//        ) ) ;

        $tabWidget->tab ( array (
            'title' => array (
                'text'        => '+',
                'htmlOptions' => array ( 'class' => 'plus' )
            )
        ) ) ;
    }
    else
    {
        $i = 1 ;
        foreach ( $row_pr as $data )
        {
            require 'paramForm.php' ;
            $tabWidget->tab ( array (
                'title' => array (
                    'text'    => $i
                ),
                'content' => array (
                    'content' => $form2
                )
            ) ) ;
            $form2    = '' ;
            $i ++ ;
        }
        $tabWidget->tab ( array (
            'title' => array (
                'text'        => '+',
                'htmlOptions' => array ( 'class' => 'plus' )
            )
        ) ) ;
    }



    echo $tabWidget->flush () ;
    $submit = '' ;


    $submit .= $form->rowStart () ;
    $submit .= $form->button ( array (
        'htmlOptions' => array (
            'type'   => 'submit',
            'name'   => 'save'
        ),
        'col'    => 'col-sm-2',
        'inline' => array (
        ),
        'content' => \f\ifm::t ( 'submit' )
            ) ) ;

    $submit .= $form->button ( array (
        'htmlOptions' => array (
            'type'   => 'button',
            'name'   => 'remove',
            'id'     => 'remove'
        ),
        'inline' => array ( ),
        'content' => \f\ifm::t ( 'remove' )
            ) ) ;


    $submit .= $form->rowEnd () ;



    echo $submit ;



    echo $form->flush () ;
    ?>
</div>

<script>


    $(document).ready(function()
    {
        widgetHelper.makeSelect2('select','انتخاب کنید');
        
        setTimeout(function () {
            $('#editDialog').niceScroll({cursorcolor: "#00F"});
        }, 200);
        //-------------------------------------------------------------------------
        
        $('#remove').on('click', function(){
            var id = $('#m_id').val();
            var type = '<?php echo $type; ?>';
          
            if(id != ''){
                $.ajax({
                    url: "<?= \f\ifm::app ()->baseUrl ?>core/code/removeMethodDocument/",
                    type: 'POST',
                    data :{
                        id : id,
                        type : type
                    },
                    success: function (response) {
                        var responseArray = JSON.parse(response);
                        var result = responseArray[0];
                        var message = responseArray[1];
                    
                        if (result.toUpperCase() == 'ERROR' || result.toUpperCase() === 'FAILED')
                        {
                            setTimeout(function () {
                                widgetHelper.errorDialog(message);
                                widgetHelper.closeDialog('errorDialog');
                            }, 800);

                        }
                        if (result == 'success')
                        {
                            setTimeout(function () {
                                widgetHelper.successDialog(message);
                                widgetHelper.closeDialog('successDialog');

                            }, 800);

                        }
                    
                    }
                });
            }
            
        })
        //----------------------------------------------------------------------
        
        $('#methodDiv').on('click', '.plus', function(){
            
            var href=$(this).attr('href');
            var num = parseInt(href.match(/(.*Tab(.)-.*)/)[2]) + 1;
            $(this).text(num-1);
            
            $(this).parents('li').after('<li><a class="plus" data-toggle="tab" href="#autoTab'+num+'-tab">+</a></li>');
            var n = num-1;

            
            var form = '<?php include "paramForm.php" ;
    echo $form2 ;
    ?>';
                var fo = $.parseHTML(form);
                var form2 = ''
           
                $.each(fo, function (i, el) {
                
                    if($(this).find('.formRow #p_type-1int').attr('id')){
                    
                        var str = 'p_type-1int';
                        var id = str.replace('-1', n-1); 
                        var name = 'p_type-1[]';
                        name = name.replace('-1', n-1); 
                     
                        $(this).find('.formRow  #p_type-1int').next().attr('for', id);
                        $(this).find('.formRow #p_type-1int').attr('name', name);
                        $(this).find('.formRow #p_type-1int').attr('id', id);
                        var str2 = 'p_type-1string' ;
                        var id2 = str2.replace('-1', n-1); 
                        $(this).find('.formRow  #p_type-1string').next().attr('for', id2);
                        $(this).find('.formRow #p_type-1string').attr('name', name);
                        $(this).find('.formRow #p_type-1string').attr('id', id2);
                    
                    
                    }
                
                    if($(this).find('.formRow #required-1').attr('id')){
                        var str3 = 'required-1' ;
                        var id3 = str3.replace('-1', n-1); 
                        var name3 = 'required-1[]';
                        name3 = name3.replace('-1', n-1); 
                    
                        $(this).find('.formRow  #required-1').next().attr('for', id3);
                        $(this).find('.formRow #required-1').attr('name', name3);
                        $(this).find('.formRow #required-1').attr('id', id3);
                    }
                
                    form2 += $(this).html();
                });
        
                $('.tab-content .tab-pane:last').after('<div id="autoTab'+n+'-tab" class="tab-pane autoTab'+n+' ">'+form2+'</div>');
                $(this).removeClass('plus');
            })
        });
        //-------------------------------------------------------------------------
   

</script>