<?php

$GLOBALS['SiteTitle'] = '404';
use_layout('layout001');
http_response_code(404);

?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <p>Página não encontrada</p>
        </div>
    </div>
</div>