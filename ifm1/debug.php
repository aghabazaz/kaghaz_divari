<?php

namespace f;

function pr($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

function pre($var) {
    pr($var);
    exit;
}
