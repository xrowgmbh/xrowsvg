<?php

$Module = array( 'name' => 'Load SVG' );

$ViewList = array();

$ViewList['load'] = array( 'functions' => array( 'loadeditor' ),
                           'ui_context' => 'edit',
                           'script' => 'load.php',
                           'params' => array( 'ObjectID', 'AttributeID' ) );

$FunctionList = array();
$FunctionList['loadeditor'] = array();