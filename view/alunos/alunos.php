<?php

$GLOBALS['SiteTitle'] = 'Alunos';
use_layout('layout001');

?>
<div class="container">
    <div class="row mb-3">
        <div class="col-12 text-right">
            <a href="<?=site_path();?>alunos/cadastro" class="btn btn-outline-info">Cadastrar</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?php
            $alunos = $GLOBALS['Controller']->ListarAlunos();
            if($alunos['total']>0)
            {
                ?>
            <table id="registros" class="table table-bordered">
                <thead>
                    <tr>
                        <!--<th>#</th>-->
                        <th>Nome</th>
                        <th>Mensalidade</th>
                        <th>Data de Vencimento</th>
                        <th>Professor</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($alunos['list'] as $aluno)
                    {
                        ?>
                    <tr data-aluno="<?=$aluno['id'];?>">
                        <!--<td><?=$aluno['id'];?></td>-->
                        <td><?=$aluno['nome'];?></td>
                        <td>R$ <?=number_format($aluno['mensalidade'],2,',','.');?></td>
                        <td><?=implode('/',array_reverse(explode('-',$aluno['data_vencimento'])));?></td>
                        <td><?=$aluno['professor_nome'];?></td>
                        <td class="p-1" style="width:50px;"><a href="<?=site_path();?>alunos/cadastro/<?=$aluno['id'];?>" class="btn btn-outline-info">Alterar</a></td>
                        <td class="p-1" style="width:50px;"><button type="button" onclick="rem_aluno(<?=$aluno['id'];?>);" class="btn btn-outline-danger">Remover</button></td>
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
            <script>
            function rem_aluno(id)
            {
                LuisAPI.pergunta({
                    titulo:'Remover aluno',
                    mensagem:'Confirma a remoção deste aluno?',
                    botoes:[{
                        label:'Sim',
                        acao:function(){
                            $.post('<?=site_path();?>alunos/cadastro',{
                                id:id,
                                acao:'delete'
                            },function(data){
                                if(parseInt(data.status))
                                    $('#registros').find('tr[data-aluno="'+id+'"]').remove();
                                LuisAPI.mensagem({
                                    titulo:'Atenção',
                                    mensagem:data.mensagem
                                });
                            });
                        }
                    },{
                        label:'Não'
                    }]
                });
            }
            </script>
        </div>
    </div>
</div>