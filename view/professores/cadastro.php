<?php

$GLOBALS['SiteTitle'] = 'Cadastro de Professor';
use_layout('layout001');

$id = isset($GLOBALS['RouteMap_Itens'][2])&&is_numeric($GLOBALS['RouteMap_Itens'][2])?intval($GLOBALS['RouteMap_Itens'][2]):0;


$resposta = array();
if(!empty($_POST))
{
    $resposta = $GLOBALS['Controller']->SalvarProfessor();
    if($resposta['status']==1) header('Location: '.site_path().'professores/professores');
}

?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <?php
            $professor = $GLOBALS['Controller']->GetProfessor($id);
            ?>
            <form method="post" action="<?=site_path();?>professores/cadastro">
                <input name="id" type="hidden" value="<?=$professor['id'];?>" />
                <div class="row mt-3">
                    <div class="col-3 text-right">Nome</div>
                    <div class="col-9">
                        <input name="nome" class="form-control" value="<?=$professor['nome'];?>" />
                    </div>
                </div>
                <div class="border-top row mt-3 pt-3">
                    <div class="col-12">
                        <button class="btn btn-outline-primary">Salvar</button>
                        <a href="<?=site_path();?>professores/professores" class="btn btn-outline-secondary">Voltar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>