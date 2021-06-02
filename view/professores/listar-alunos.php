<?php

$GLOBALS['SiteTitle'] = 'Lista de Alunos';
use_layout('layout001');

$id = isset($GLOBALS['RouteMap_Itens'][2])&&is_numeric($GLOBALS['RouteMap_Itens'][2])?intval($GLOBALS['RouteMap_Itens'][2]):0;


?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <?php
            $professor = $GLOBALS['Controller']->GetProfessor($id);
            ?>
            <div class="row mb-3">
                <div class="col-8">
                    <h5 class="display-4" style="font-size:1.5em;">Alunos do professor <?=$professor['nome'];?></h5>
                </div>
                <div class="col-4 text-right">
                    <input type="file" id="imp_aluno" accept=".txt" class="d-none" />
                    <a href="javascript:void(0);" onclick="imp_aluno();" class="btn btn-outline-info">Importar TXT</a>
                </div>
            </div>
            <?php            
            $alunos = $GLOBALS['Controller']->ListarAlunos($id);
            if($alunos['total']>0)
            {
                ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Mensalidade</th>
                        <th>Data de Vencimento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($alunos['list'] as $aluno)
                    {
                        ?>
                    <tr>
                        <td><?=$aluno['nome'];?></td>
                        <td>R$ <?=number_format($aluno['mensalidade'],2,',','.');?></td>
                        <td><?=implode('/',array_reverse(explode('-',$aluno['data_vencimento'])));?></td>
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
            
            function imp_aluno()
            {
                $('#imp_aluno').click();   
            }
            $('#imp_aluno').change(function(){
                if($('#imp_aluno')[0].files.length>0)
                {
                    var $post_data = new FormData();
                    $post_data.append('acao','import');
                    $post_data.append('professor','<?=$professor['id'];?>');
                    $post_data.append('arquivo',$('#imp_aluno')[0].files[0]);
                    $.ajax({
                        type:'POST',
                        enctype:'multipart/form-data',
                        url:'<?=site_path();?>alunos/cadastro',
                        data:$post_data,
                        processData: false,
                        contentType: false,
                        cache: false,
                        timeout: 600000,
                        success: function (data)
                        {
                            LuisAPI.mensagem({
                                titulo:'Atenção',
                                mensagem:data.mensagem,
                                onhidden:function()
                                {
                                    if(parseInt(data.status)) location.reload();
                                    $('#imp_aluno').val('');
                                }
                            });

                        }
                    });
                }
                $('#imp_aluno').val('');
            });
            </script>
        </div>
    </div>
</div>