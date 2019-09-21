<?
echo $boxWidget->begin ( array (
    'type'   => 'chart',
    'title'  => \f\ifm::t ( 'country' ),
    'focus'  => '1',
    'expand' => 1,
    'remove' => 1 ) ) ;

echo \f\html::markupBegin ( 'div',
                                        array (
            'htmlOptions' => array (
                'id' => 'country' ),
            'style'       => array (
                'text-align' => 'center' ) ) ) ;
echo \f\html::markupEnd ( 'div' ) ;

?>

<?
echo $boxWidget->flush () ;
?>