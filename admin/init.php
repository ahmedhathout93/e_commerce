<?php
include 'connect.php';
$tpl = 'includes/templates/';
$css = 'layout/css/';
$js  = 'layout/js/';
$lan = 'includes/languages/';

include $lan . "english.php";
include $tpl . "header.php";


if (!isset($noNavBar)){ include $tpl.'navbar.php';}

