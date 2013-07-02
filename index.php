<?php
require_once "core/loader.php";

$api = new Image();
$view = loader::getView();

if(!empty($_REQUEST)){
    $api->validate($_REQUEST);
}

$content = loader::view($view , array('model' => $api), TRUE);
loader::view('layout', array('content' => $content,'active'=> $view));
?>