<?php

$GLOBALS['SiteTitle'] = 'Cadastro de Aluno';
use_layout('layout001');

$id = isset($GLOBALS['RouteMap_Itens'][2])&&is_numeric($GLOBALS['RouteMap_Itens'][2])?intval($GLOBALS['RouteMap_Itens'][2]):0;


$resposta = array();
if(!empty($_POST))
{
    if(isset($_POST['acao']) && $_POST['acao']=='delete')
    {
        json_out($GLOBALS['Controller']->RemoverAluno($_POST['id']));
    }
    else if(isset($_POST['acao']) && $_POST['acao']=='import')
    {
        json_out($GLOBALS['Controller']->ImportarAlunos($_POST['professor']));
    }
    else
    {
        $resposta = $GLOBALS['Controller']->SalvarAluno();
        if($resposta['status']==1) header('Location: '.site_path().'alunos/alunos');
    }
}

?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <?php
            $aluno = $GLOBALS['Controller']->GetAluno($id);
            ?>
            <form method="post" action="<?=site_path();?>alunos/cadastro">
                <input name="id" type="hidden" value="<?=$aluno['id'];?>" />
                <div class="row mt-3">
                    <div class="col-3 text-right">Nome</div>
                    <div class="col-9">
                        <input name="nome" class="form-control" value="<?=$aluno['nome'];?>" />
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-3 text-right">Professor</div>
                    <div class="col-9">
                        <select name="professor" class="selectpicker" required>
                            <?php
                            add_controller('Professores');
                            $professores = (new Professores())->ListarProfessores();
                            foreach($professores['list'] as $professor)
                            {
                                ?>
                            <option value="<?=$professor['id'];?>"<?=$professor['id']==$aluno['professor']?' selected':'';?>><?=$professor['nome'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-3 text-right">Data de vencimento</div>
                    <div class="col-9">
                        <input type="date" name="data_vencimento" class="form-control" value="<?=$aluno['data_vencimento'];?>" required />
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-3 text-right">Mensalidade</div>
                    <div class="col-9">
                        <input type="number" name="mensalidade" min="0.00" step="any" max="9999999.99" class="form-control" value="<?=$aluno['mensalidade'];?>" required />
                    </div>
                </div>
                <div class="border-top row mt-3 pt-3">
                    <div class="col-12">
                        <button class="btn btn-outline-primary">Salvar</button>
                        <a href="<?=site_path();?>alunos/alunos" class="btn btn-outline-secondary">Voltar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>