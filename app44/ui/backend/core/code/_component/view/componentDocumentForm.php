
<div>


    <?php
    /* @var $form \f\w\form */

    $form  = \f\widgetFactory::make('form') ;
    $form1 = '' ;
    $form1 .= $form->begin(array (
        'htmlOptions' => array (
            'method' => 'post',
            'action' => \f\ifm::app()->baseUrl . 'core/code/documentSave',
            'id'     => 'componentForm'
        ),
            )) ;


    $form1 .= $form->input(array (
        'htmlOptions' => array (
            'type'     => 'text',
            'name'     => 'typeComponent',
            'id' => 'typeComponent',
            'value'    => $type,
            'readonly' => true
        ),
        'style'       => array (
            'direction' => 'rtl',
        ),
        'label'       => array (
            'text' => \f\ifm::t('typeComponent'),
        ),
        'block'       => array ()
            )) ;


    $form1 .= $form->input(array (
        'htmlOptions' => array (
            'type'  => 'hidden',
            'name'  => 'typeComp',
            'value' => $typeComp
        )
            )) ;

    $form1 .= $form->input(array (
        'htmlOptions' => array (
            'type'  => 'hidden',
            'name'  => 'parent_id',
            'value' => isset($parent[ 'id' ]) ? $parent[ 'id' ] : null
        )
            )) ;

    $form1 .= $form->input(array (
        'htmlOptions' => array (
            'type'  => 'hidden',
            'name'  => 'id',
            'id' => 'c_id',
            'value' => isset($row[ 'id' ]) ? $row[ 'id' ] : ''
        )
            )) ;

    $form1 .= $form->input(array (
        'htmlOptions' => array (
            'type'  => 'hidden',
            'name'  => 'path',
            'value' => isset($row[ 'path' ]) ? $row[ 'path' ] : $path
        )
            )) ;

    $form1 .= $form->input(array (
        'htmlOptions' => array (
            'type'     => 'text',
            'name'     => 'name',
            'readonly' => true,
            'value'    => ( ! empty($row)) ? $row[ 'name' ] : $name
        ),
        'validation'  => array (
            'required' => ''
        )
        ,
        'style'       => array (
            'direction' => 'rtl',
        ),
        'label'       => array (
            'text' => \f\ifm::t('name'),
        ),
        'block'       => array ()
            )) ;



    $form1 .= $form->input(array (
        'htmlOptions' => array (
            'type'  => 'text',
            'name'  => 'title',
            'value' => ( ! empty($row)) ? $row[ 'title' ] : ''
        ),
        'validation'  => array (
            'required' => ''
        )
        ,
        'style'       => array (
            'direction' => 'rtl',
        ),
        'label'       => array (
            'text' => \f\ifm::t('title'),
        ),
        'block'       => array ()
            )) ;

    $form1.= $form->rowStart() ;

    $form1 .= $form->select(array (
        'htmlOptions' => array (
            'name' => 'type'
        ),
        'label'       => array (
            'text' => \f\ifm::t('type'),
        ),
        'choices'     => $typeArr,
        'block'       => array (),
        'selected'    => $row[ 'type' ] ? $row[ 'type' ] : ''
            )) ;

    $form1.= $form->radio(array (
        'htmlOptions' => array (
            'name'  => 'status',
            'class' => 'info',
        ),
        'choices'     => array (
            \f\ifm::t('enabled')  => 'enabled',
            \f\ifm::t('disabled') => 'disabled'
        ),
        'label'       => array (
            'text' => \f\ifm::t('status'),
        ),
        'checked'     => ($row[ 'status' ]) ? $row[ 'status' ] : 'enabled',
        'linear'      => TRUE,
        'block'       => array ()
            )) ;

    if ( $type == 'ui' )
    {
        $form1.= $form->rowStart() ;

        $form1 .= $form->colStart(array (
            'padding-right' => '0px',
            'width'         => '25%'
                )
                ) ;

        $form1 .= \f\ifm::t('icon') ;

        $form1 .= $form->colEnd() ;
        $form1 .= $form->colStart() ;
        $fileIdInput = \f\html::readyMarkup('input', '',
                                            array (
                    'htmlOptions' => array (
                        'type'  => 'hidden',
                        'name'  => 'icon_id',
                        'id'    => 'fileId',
                        'value' => $row[ 'icon_id' ]
            ) )) ;
        $profilePic  = \f\html::readyMarkup('img', '',
                                            array (
                    'htmlOptions' => array (
                        'src'      => \f\ifm::app()->fileBaseUrl . $row[ 'icon_id' ],
                        'data-src' => \f\ifm::app()->fileBaseUrl . $row[ 'icon_id' ],
                    ),
                    'style'       => array (
                        'max-width'  => '50px',
                        'max-height' => '70px',
                        'display'    => $row[ 'icon_id' ] == '' ? 'none' : 'block'
                    )
                )) ;

        $form1.= \f\html::readyMarkup('div', $fileIdInput . $profilePic,
                                      array (
                    'htmlOptions' => array (
                        'id'        => 'fileContainer',
                        'data-type' => 'image'
                    ),
                    'style'       => array (
                        'float' => 'right'
                    )
                        ), true) ;
        $form1.= $form->buttonTag(array (
            'htmlOptions' => array (
                'type'  => 'button',
                'id'    => 'selectProfilePicBtn',
                'class' => 'btn btn-default'
            ),
            'content'     => '<i class="fa fa-upload"></i> ' . \f\ifm::t('selectIcon'),
            'action'      => array (
                'preServerSideAction' => array (
                    'route'   => 'core.fileManager.registerUploadSession',
                    'options' => array ( //change
                        'multiUpload' => 1,
                        'extensions'  => '.jpg, .png, .bmp, .jpeg',
                        'tasks'       => array ( 'upload', 'select' )
                    ),
                ),
                'display'             => 'dialog',
                'params'              => array (
                    'targetRoute'    => "core.fileManager.getUploadForm",
                    'containerId'    => '#fileContainer',
                    'triggerElement' => 'selectProfilePicBtn', //chanage
                    'urlParams'      => array (
                        'path' => 'icons.ui' //chanage
                    ),
                    'dialogTitle'    => \f\ifm::t("fileUpload"),
                    'ajaxParams'     => array (
                        'mode'   => $row[ 'icon_id' ] == '' ? '' : 'update',
                        'fileId' => $row[ 'icon_id' ],
                        'path'   => 'icons.ui'  //chanage
                    )
                )
            ) )) ;
        $form1 .= $form->colEnd() ;

        $form1.= $form->rowEnd() ;
        $form1 .= $form->input(array (
            'htmlOptions' => array (
                'type'  => 'text',
                'name'  => 'display_order',
                'value' => ( ! empty($row)) ? $row[ 'display_order' ] : '0'
            )
            ,
            'style'       => array (
                'direction' => 'rtl',
            ),
            'label'       => array (
                'text' => \f\ifm::t('displayOrder'),
            ),
            'block'       => array ()
                )) ;
    }


    $form1 .= $form->textarea(array (
        'htmlOptions' => array (
            'name' => 'description',
            'id'   => 'description',
        ),
        'style'       => array (
            'height' => '100px',
        ),
        'content'     => ( ! empty($row)) ? $row[ 'description' ] : '',
        'label'       => array (
            'text' => \f\ifm::t('description'),
        ),
        'block'       => array ()
            )
            ) ;


    $form1 .= $form->button(array (
        'htmlOptions' => array (
            'type' => 'submit',
            'name' => 'save',
        ),
        'inline'      => array (
        ),
        'content'     => \f\ifm::t('submit'),
        'inline'       => array (),
        'col'    => 'col-sm-2'
            )) ;
    
      $form1 .= $form->button ( array (
        'htmlOptions' => array (
            'type'   => 'button',
            'name'   => 'remove',
            'id'     => 'removeComp'
        ),
        'inline' => array ( ),
        'content' => \f\ifm::t ( 'remove' )
            ) ) ;

//    $form1 .= $form->button ( array (
//        'content' => \f\ifm::t ( 'cancel' ),
//        'inline'  => array (
//        )
//    ) ) ;


    $form1 .= $form->rowEnd() ;

    $form1 .= $form->flush() ;

    echo $form1 ;
    ?>
</div>

<script>


    $(document).ready(function ()
    {
        widgetHelper.makeSelect2('select', 'انتخاب کنید');
        
        setTimeout(function () {
            $('#editDialog').niceScroll({cursorcolor: "#00F"});
        }, 200);

        $('#removeComp').on('click', function(){
            var id = $('#c_id').val();
            var type = $('#typeComponent').val();
          
            if(id != ''){
                $.ajax({
                    url: "<?= \f\ifm::app ()->baseUrl ?>core/code/removeComponentDocument/",
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

    });


</script>