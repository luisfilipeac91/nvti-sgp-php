<?php

class Alunos extends Main
{
    public function ListarAlunos($options = array())
    {
        $settings = array_merge($GLOBALS['QueryDefault'],$options);

        $aux = array(
            'total'=>0,
            'list'=>array()
        );

        $sql = "
        SELECT Count(*) total
        FROM dbo.nvt_alunos a
        INNER JOIN dbo.nvt_professores p ON a.professor = p.id";
        $res = parent::ExecuteQuery($sql);
        while($row = sqlsrv_fetch_array($res))
            $aux['total'] = intval($row['total']);

        $sql = "
        SELECT
            a.id,
            a.nome,
            a.professor,
            p.nome professor_nome,
            a.mensalidade,
            CONVERT(date, a.data_vencimento, 103) data_vencimento
        FROM dbo.nvt_alunos a
        INNER JOIN dbo.nvt_professores p ON a.professor = p.id";
        $res = parent::ExecuteQuery($sql);
        while($row = sqlsrv_fetch_array($res))
            array_push($aux['list'],$row);
        return $aux;
    }

    public function GetAluno($id)
    {
        $aux = array(
            'id'=>isset($_POST['id'])?$_POST['id']:0,
            'nome'=>isset($_POST['nome'])?$_POST['nome']:'',
            'professor'=>isset($_POST['professor'])?$_POST['professor']:'',
            'mensalidade'=>isset($_POST['mensalidade'])?$_POST['mensalidade']:0,
            'data_vencimento'=>isset($_POST['data_vencimento'])?$_POST['data_vencimento']:date('d/m/Y')
        );

        if(intval($id)>0)
        {
            $sql = "
            SELECT
                id,
                nome,
                professor,
                mensalidade,
                CONVERT(date, data_vencimento, 103) data_vencimento 
            FROM dbo.nvt_alunos
            WHERE id = ".$id;
            $res = parent::ExecuteQuery($sql);
            if($row = sqlsrv_fetch_array($res))
                $aux = $row;
        }
        return $aux;
    }

    public function SalvarAluno()
    {
        $sql = "";
        $stmt = null;
        if(intval($_POST['id'])==0)
        {
            $sql = "
            INSERT INTO dbo.nvt_alunos
            (nome, professor, mensalidade, data_vencimento)
            VALUES
            (?,?,?,?)";
            $stmt = parent::Prepare($sql, array(
                &$_POST['nome'],
                &$_POST['professor'],
                &$_POST['mensalidade'],
                &$_POST['data_vencimento']
            ));
        }
        else
        {
            $sql = "
            UPDATE dbo.nvt_alunos
            SET nome = ?,
                professor = ?,
                mensalidade = ?,
                data_vencimento = ?
            WHERE id = ?";
            $stmt = parent::Prepare($sql, array(
                &$_POST['nome'],
                &$_POST['professor'],
                &$_POST['mensalidade'],
                &$_POST['data_vencimento'],
                &$_POST['id']
            ));
        }
        parent::ExecuteQuery($stmt);
        return array('status'=>1,'mensagem'=>'Salvo com sucesso');
    }

    public function ImportarAlunos($professor)
    {
        $pode_enviar = false;
        $tem_param = false;
        $sql = "
        SELECT valor
        FROM nvt_parametros
        WHERE acao = 'importar-".$professor."'";
        $res = parent::ExecuteQuery($sql);
        if($row = sqlsrv_fetch_array($res))
        {
            $tem_param = true;
            $data = strtotime($row['valor']);
            if(strtotime('now')-$GLOBALS['Config']['tempo_importacao']>$data)
                $pode_enviar = true;
        }
        else $pode_enviar = true;
        
        if($pode_enviar)
        {
            if(is_file($_FILES['arquivo']['tmp_name']))
            {
                $handle = fopen($_FILES['arquivo']['tmp_name'], "r");
                if ($handle)
                {
                    $xalunos = array();

                    while (($line = fgets($handle)) !== false)
                    {
                        $line = str_replace(PHP_EOL,'',$line);
                        $linha = explode('||',$line);
                        if(count($linha)!=3)
                        {
                            return array('status'=>0,'Problema validar o layout');
                        }
                        array_push($xalunos,$linha);
                    }
                    fclose($handle);

                    foreach($xalunos as $a)
                    {
                        $sql = "
                        INSERT INTO dbo.nvt_alunos
                        (nome, professor, mensalidade, data_vencimento)
                        VALUES
                        (?,1,?,?)";
                        $stmt = parent::Prepare($sql, array(
                            $a[0],
                            floatval($a[1]),
                            implode('-',array_reverse(explode('/',$a[2])))
                        ));
                        parent::ExecuteQuery($stmt);
                        sqlsrv_free_stmt($stmt);
                    }
                    $sql = "
                    INSERT INTO nvt_parametros
                    (acao, valor)
                    VALUES
                    ('importar-".$professor."',CONVERT(VARCHAR, GETDATE(),20))";
                    if($tem_param)
                    {
                        $sql = "
                        UPDATE nvt_parametros
                        SET valor = CONVERT(VARCHAR, GETDATE(),20)
                        WHERE acao = 'importar-".$professor."'";
                        parent::ExecuteQuery($sql);
                    }
                    parent::ExecuteQuery($sql);
                    return array('status'=>1,'mensagem'=>'Salvo com sucesso');
                }
                else return array('status'=>0,'mensagem'=>'Problema ao ler o arquivo');
            }
            else return array('status'=>0,'mensagem'=>'Problema ao enviar arquivo');
        }
        else
        {
            return array('status'=>0,'mensagem'=>'Voce não pode enviar arquivo de importação no momento, tente novamente mais tarde');
        }
    }
    public function RemoverAluno($id)
    {
        $sql = "
        DELETE FROM dbo.nvt_alunos
        WHERE id = ?";
        $stmt = parent::Prepare($sql, array(&$_POST['id']));
        parent::ExecuteQuery($stmt);
        return array('status'=>1,'mensagem'=>'Removido com sucesso');
    }
}

?>