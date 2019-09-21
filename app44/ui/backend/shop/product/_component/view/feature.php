<?php

$label = '' ;

foreach ( $row AS $data )
{
    if ( $data[ 'featureTitle' ] != $label )
    {
        $label = $data[ 'featureTitle' ] ;
        $form.='<div style="font-size:18px;border-bottom:1px dotted #eee;color:gray">:: ' . $data[ 'featureTitle' ] . '</div>' ;
    }
    if ( $data[ 'required' ] )
    {
        $validation = array (
            'required' => ''
        ) ;
    }
    else
    {
        $validation = array () ;
    }
    $form.=$this->formW->rowStart () ;
    $form.=$this->formW->input ( array (
        'htmlOptions' => array (
            'type'  => 'hidden',
            'name'  => 'shop_feature_item_id[]',
            'value' => $data[ 'fId' ],
        ),
            ) ) ;
    $form.=$this->formW->input ( array (
        'htmlOptions' => array (
            'type'  => 'hidden',
            'name'  => 'shop_category_feature_id[]',
            'value' => $data[ 'catId' ],
        ),
            ) ) ;
    $choices = array () ;
    if ( $data[ 'type' ] == 'text' )
    {

        $form.=$this->formW->input ( array (
            'htmlOptions' => array (
                'type'  => 'text',
                'name'  => 'feature' . $data[ 'fId' ],
                'value' => $value[ $data[ 'fId' ] ],
            ),
            'label'       => array (
                'text' => $wiki[ $data[ 'id' ] ],
            ),
            'validation'  => $validation,
                ) ) ;
    }
    if ( $data[ 'type' ] == 'textarea' )
    {
        $form.=$this->formW->textarea ( array (
            'htmlOptions' => array (
                'name' => 'feature' . $data[ 'fId' ],
            ),
            'label'       => array (
                'text' => $wiki[ $data[ 'id' ] ],
            ),
            'content'     => $value[ $data[ 'fId' ] ],
            'validation'  => $validation,
                ) ) ;
    }
    if ( $data[ 'type' ] == 'oneSelect' )
    {
        $chArr = json_decode ( $data[ 'options' ], TRUE ) ;
        for ( $i = 0 ; $i < count ( $chArr ) ; $i ++ )
        {
            $choices[ $chArr[ $i ] ] = $wiki[ $chArr[ $i ] ] ;
        }

        $form.=$this->formW->select ( array (
            'htmlOptions' => array (
                'id'   => '',
                'name' => 'feature' . $data[ 'fId' ],
            ),
            'label'       => array (
                'text' => $wiki[ $data[ 'id' ] ],
            ),
            'choices'     => $choices,
            'selected'    => $value[ $data[ 'fId' ] ],
            'validation'  => $validation,
                ) ) ;
    }
    if ( $data[ 'type' ] == 'multiSelect' )
    {
        $chArr = json_decode ( $data[ 'options' ], TRUE ) ;
        for ( $i = 0 ; $i < count ( $chArr ) ; $i ++ )
        {
            $choices[ $chArr[ $i ] ] = $wiki[ $chArr[ $i ] ] ;
        }

        $form.=$this->formW->select ( array (
            'htmlOptions' => array (
                'id'       => '',
                'name'     => 'feature' . $data[ 'fId' ] . '[]',
                'multiple' => TRUE
            ),
            'label'       => array (
                'text' => $wiki[ $data[ 'id' ] ],
            ),
            'choices'     => $choices,
            'selected'    => $value[ $data[ 'fId' ] ],
            'validation'  => $validation,
                ) ) ;
    }
    if ( $data[ 'type' ] == 'yesOrNo' )
    {
        $form.=$this->formW->radio ( array (
            'htmlOptions' => array (
                'name' => 'feature' . $data[ 'fId' ],
            ),
            'choices'     => array (
                \f\ifm::t ( 'yes' ) => 'yes',
                \f\ifm::t ( 'no' )  => 'no',
            ),
            'label'       => array (
                'text' => $wiki[ $data[ 'id' ] ],
            ),
            'checked'     => $value[ $data[ 'fId' ] ] ? $value[ $data[ 'fId' ] ] : 'yes',
            'linear'      => TRUE,
            'validation'  => $validation,
                ) ) ;
    }
    $form.=$this->formW->rowEnd () ;
}

echo $form ;

