<?php

$GLOBALS['RouteMap'] = str_replace($GLOBALS['SitePath'],'',$_SERVER['REQUEST_URI']);
$GLOBALS['RouteMap'] = explode('?',$GLOBALS['RouteMap'])[0];
$GLOBALS['RouteMap_Itens'] = explode('/',$GLOBALS['RouteMap']);
$GLOBALS['QueryDefault'] = array(
    'where'=>'',
    'order'=>'',
    'pagina'=>1,
    'limite'=>10
);

require __DIR__.'/functions.php';

$req_page = '';
$len = 0;
foreach($GLOBALS['RouteMap_Itens'] as $xv)
{
    if($len<2) $req_page.='/'.$xv;
    $len++;
}
ob_start();

if(is_file(__DIR__.'/../controller/'.$GLOBALS['RouteMap_Itens'][0].'.controller.php'))
{
    add_controller('Main',false);

    add_controller($GLOBALS['RouteMap_Itens'][0]);

    $cname = ucfirst($GLOBALS['RouteMap_Itens'][0]);
    

    $GLOBALS['Controller'] = new $cname();

    if(is_file(__DIR__.'/../view'.$req_page.'.php'))
        require __DIR__.'/../view'.$req_page.'.php';
}
else require __DIR__.'/../view/errors/404.php';

render();

?>