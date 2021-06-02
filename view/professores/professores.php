<?php

$GLOBALS['SiteTitle'] = 'Professores';
use_layout('layout001');

?>
<div class="container">
    <div class="row mb-3">
        <div class="col-12 text-right">
            <a href="<?=site_path();?>professores/cadastro" class="btn btn-outline-info">Cadastrar</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?php
            $professores = $GLOBALS['Controller']->ListarProfessores();
            if($professores['total']>0)
            {
                ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <!--<th>#</th>-->
                        <th>Nome</th>
                        <th colspan="3"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($professores['list'] as $professor)
                    {
                        ?>
                    <tr>
                        <!--<td><?=$professor['id'];?></td>-->
                        <td><?=$professor['nome'];?></td>
                        <td class="p-1" style="width:123px;"><a href="<?=site_path();?>professores/listar-alunos/<?=$professor['id'];?>" class="btn btn-outline-info">Listar alunos</a></td>
                        <td class="p-1" style="width:50px;"><a href="<?=site_path();?>professores/cadastro/<?=$professor['id'];?>" class="btn btn-outline-info">Alterar</a></td>
                        <td class="p-1" style="width:50px;"><button type="button" onclick="rem_professor(<?=$professor['id'];?>);" class="btn btn-outline-danger">Remover</button></td>
                    </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
                <?php
            }
            else
            {
                ?>
            <div class="alert alert-warning" role="alert">Nenhum aluno encontrado</div>
                <?php
            }
            ?>
        </div>
    </div>
</div>