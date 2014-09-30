<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'sys.def.php';

function __autoload($class_name) {
    require_once "../classes/".$class_name . '.class.php';
}

?>
