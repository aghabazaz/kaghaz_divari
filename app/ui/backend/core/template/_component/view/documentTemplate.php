
<div>


    <?php
    /* @var $form \f\w\form */

    $form  = \f\widgetFactory::make ( 'form' ) ;
    $form1 = '' ;
    $form1 .= $form->begin ( array (
        'htmlOptions' => array (
            'method' => 'post',
            'action' => \f\ifm::app ()->baseUrl . 'core/template/documentSave',
            'id'     => 'templateForm'
        ),
            ) ) ;



    $form1 .= $form->input ( array (
        'htmlOptions' => array (
            'type'  => 'hidden',
            'name'  => 'id',
            'value' => ( ! empty ( $row )) ? $row[ 'id' ] : ''
        )
            ) ) ;

    $form1 .= $form->input ( array (
        'htmlOptions' => array (
            'type'     => 'text',
            'name'     => 'name',
            'readonly' => true,
            'value'    => ( ! empty ( $row )) ? $row[ 'name' ] : $path
        ),
        'validation'  => array (
            'required' => ''
        )
        ,
        'style'       => array (
            'direction' => 'rtl',
        ),
        'label'       => array (
            'text' => \f\ifm::t ( 'name' ),
        ),
        'block'       => array ()
            ) ) ;



    $form1 .= $form->input ( array (
        'htmlOptions' => array (
            'type'  => 'text',
            'name'  => 'title',
            'value' => ( ! empty ( $row )) ? $row[ 'title' ] : ''
        ),
        'validation'  => array (
            'required' => ''
        )
        ,
        'style'       => array (
            'direction' => 'rtl',
        ),
        'label'       => array (
            'text' => \f\ifm::t ( 'title' ),
        ),
        'block'       => array ()
            ) ) ;




    $form1.= $form->radio ( array (
        'htmlOptions' => array (
            'name' => 'status',
        ),
        'choices'     => array (
            \f\ifm::t ( 'enabled' )  => 'enabled',
            \f\ifm::t ( 'disabled' ) => 'disabled'
        ),
        'label'       => array (
            'text' => \f\ifm::t ( 'status' ),
        ),
        'checked'     => ($row[ 'status' ]) ? $row[ 'status' ] : 'enabled',
        'linear'      => TRUE,
        'block'       => array ()
            ) ) ;

    $form1.= $form->radio ( array (
        'htmlOptions' => array (
            'name'  => 'type',
            'class' => 'type',
        ),
        'choices'     => array (
            \f\ifm::t ( 'default' ) => 'default',
            \f\ifm::t ( 'main' )    => 'main'
        ),
        'label'       => array (
            'text' => \f\ifm::t ( 'type' ),
        ),
        'checked'     => ($row[ 'type' ]) ? $row[ 'type' ] : 'default',
        'linear'      => TRUE,
        'block'       => array ()
            ) ) ;

    $form1.=\f\html::markupBegin ( 'div',
    array (
    'htmlOptions' => array (
    'id' => 'mainTemp'
    ),
    'style' => array( 
        'display'=>($row['type']=='main')?'block':'none')) ) ;
    $form1.=\f\html::markupBegin ( 'div',
                                   array (
                'style' => array (
                    'color' => 'silver'
                )
            ) ) ;
    $form1.=\f\ifm::t ( 'defaultCm' ) ;
    $form1.=\f\html::markupEnd ( 'div' ) ;
    foreach ( $lang AS $data )
    {
        $form1 .= $form->input ( array (
            'htmlOptions' => array (
                'type'  => 'hidden',
                'name'  => 'lang[]',
                'value' => $data[ 'id' ]
            )
                ) ) ;
        $form1 .= $form->select ( array (
            'htmlOptions' => array (
                'name' => 'default[]'
            ),
            'label'       => array (
                'text' => $data[ 'title' ],
            ),
            'choices'     => $defaultTemp,
            'block'       => array (),
            'selected'    => $mainDefaultTemp[ $data[ 'id' ] ] ? $mainDefaultTemp[ $data[ 'id' ] ] : ''
                ) ) ;
    }
    $form1.=\f\html::markupEnd ( 'div' ) ;
    $form1 .= $form->button ( array (
        'htmlOptions' => array (
            'type' => 'submit',
            'name' => 'save',
        ),
        'inline'      => array (
        ),
        'content'     => \f\ifm::t ( 'submit' ),
        'block'       => array (),
            ) ) ;

//    $form1 .= $form->button ( array (
//        'content' => \f\ifm::t ( 'cancel' ),
//        'inline'  => array (
//        )
//    ) ) ;


    $form1 .= $form->rowEnd () ;

    $form1 .= $form->flush () ;

    echo $form1 ;
    ?>
</div>

<script>


    $(document).ready(function ()
    {
        widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');

       

    });
    $('.type').on('click', function () {
        mainTamplate($(this).val());
    });
    function mainTamplate(choice)
    {
        //var choice=$('.type').val();
        if (choice == 'main')
        {
            $('#mainTemp').slideDown('slow');
        }
        else
        {
            $('#mainTemp').slideUp('fast');
        }
    }


</script>