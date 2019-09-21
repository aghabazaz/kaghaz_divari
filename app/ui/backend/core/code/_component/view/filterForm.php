<div>


    <?php
    

    /* @var $form \f\w\form */

    $form  = \f\widgetFactory::make ( 'form' ) ;
    $form1 = '' ;
    

    $form1.=$form->rowStart () ;
    $form1 .= $form->input ( array (
        'htmlOptions' => array (
            'type'       => 'text',
            'name'       => 'setting[status]',
            'value'      =>  isset ( $setting[ 'status' ] ) ? $setting[ 'status' ] : ''
        ),
        'validation' => array (
            'required' => ''
        ),
        'style'    => array (
            'direction' => 'rtl',
        ),
        'label'     => array (
            'text' => \f\ifm::t ( 'status' ),
        )
            ) ) ;

    $form1.=$form->rowEnd () ;

    $form1.=$form->rowStart () ;
    $form1 .= $form->input ( array (
        'htmlOptions' => array (
            'type'       => 'text',
            'name'       => 'setting[name]',
            'value'      => isset ( $setting[ 'name' ] ) ? $setting[ 'name' ] : ''
        ),
        'validation' => array (
            'required' => ''
        ),
        'style'    => array (
            'direction' => 'ltr',
        ),
        'label'     => array (
            'text' => \f\ifm::t ( 'logicName' ),
        )
            ) ) ;

    $form1.=$form->rowEnd () ;

   

    echo $form1 ;
    ?>
</div>
