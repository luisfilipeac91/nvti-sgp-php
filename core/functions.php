<?php

function site_path()
{
    return $GLOBALS['SitePath'];
}

function add_controller($controller_name, $suffix = true)
{
    require __DIR__.'/../controller/'.$controller_name.($suffix?'.controller':'').'.php';
}

function json_out($arr)
{
    header('Content-Type: application/json; Charset=utf-8;');
    die(json_encode($arr));
}

$GLOBALS['PageData'] = null;

function use_layout($layout)
{
    ob_start();
    require __DIR__.'/../layout/'.$layout.'.php';
    $GLOBALS['PageData'] = ob_get_contents();
    $GLOBALS['PageData'] = str_replace("{{SITE_TITLE}}",$GLOBALS['SiteTitle'],$GLOBALS['PageData']);
    ob_end_clean();
}

function display_header()
{
    require __DIR__.'/../inc/header.php';
}

function render()
{
    $GLOBALS['PageContent'] = ob_get_contents();
    ob_end_clean();
    echo str_replace('{{SITE_BODY}}',$GLOBALS['PageContent'],$GLOBALS['PageData']);
}
?>