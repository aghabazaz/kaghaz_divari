<?php

$states = array () ;

$states[ 1 ] = array (
    'result'  => 'Failed',
    'message' => 'When upload new file, path is required !'
        ) ;

$states[ 2 ] = array (
    'result'  => 'Failed',
    'message' => 'When upload new file to update old one, file id is required !'
        ) ;

$states[ 3 ] = array (
    'result'  => 'Failed',
    'message' => 'Mode is expected !'
        ) ;

$states[ 4 ] = array (
    'result'  => 'Failed',
    'message' => 'Upload key is wrong !'
        ) ;

$states[ 5 ] = array (
    'result'  => 'success',
    'message' => 'Folder created successfuly.'
        ) ;

$states[ 6 ] = array (
    'result'  => 'success',
    'message' => 'File/Folder deleted successfuly.'
        ) ;


$states[ 7 ] = array (
    'result'  => 'success',
    'message' => 'File updated successfully.'
        ) ;

$states[ 8 ] = array (
    'result'  => 'failed',
    'message' => 'File could not be updated due to an undefined reason!'
        ) ;

$states[ 9 ] = array (
    'result'  => 'success',
    'message' => 'File[s] completely uploaded.'
        ) ;


$states[ 10 ] = array (
    'result'  => 'success',
    'message' => 'File[s] uploaded incompletely.'
        ) ;

$states[ 11 ] = array (
    'result'  => 'success',
    'message' => 'File details updated successfully.'
        ) ;

$states[ 12 ] = array (
    'result'  => 'success',
    'message' => 'File details could not be updated! try again.'
        ) ;

$states[ 13 ] = array (
    'result'  => 'failed',
    'message' => 'File id is wrong please use file manager.'
        ) ;

$states[ 14 ] = array (
    'result'  => 'success',
    'message' => 'Folder details updated successfuly.'
        ) ;

$states[ 15 ] = array (
    'result'  => 'success',
    'message' => 'Folder created successfully.'
        ) ;

$states[ 16 ] = array (
    'result'  => 'failed',
    'message' => 'Folder already exists !'
        ) ;

$states[ 17 ] = array (
    'result'  => 'failed',
    'message' => 'File size is exceeded.'
) ;

$states[ 18 ] = array (
    'result'  => 'failed',
    'message' => 'File extension is wrong.'
) ;
