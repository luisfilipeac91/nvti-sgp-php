<?php

$GLOBALS['SiteName'] = 'NVTI_SGP';
$GLOBALS['SitePath'] = '/nvti_sgp/';

$GLOBALS['Config'] = array(
    'tempo_importacao'=>60*60 // 1 HR
);

$GLOBALS['DataBase_CS'] = array();
// PERSONALIZADO SQLSRV
// $GLOBALS['DataBase_CS'][0] = "Driver={SQL Server Native Client 10.0};Server=<server>;Database=<database>;user=<user>;pass=<pass>";
$GLOBALS['DataBase_CS'][0] = array(
    'Server'=>'<server>',
    'Database'=>'<database>',
    'UID'=>'<user>',
    'PWD'=>'<pass>'
);

require __DIR__.'/core/init.php';

?>