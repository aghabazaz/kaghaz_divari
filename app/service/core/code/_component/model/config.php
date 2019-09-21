<?php

$tiersInfo = array (
    'service' => array (
        'root' => \f\ifm::app()->serviceDir . \f\DS,
    ),
    'ui'      => array (
        'root' => \f\ifm::app()->uiDir . \f\DS . 'backend' . \f\DS
    )
        ) ;

$methodsBlackList = array (
    '__construct',
    '__destruct',
    '__autoload'
        ) ;
