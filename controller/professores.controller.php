<?php

class Professores extends Main
{
    public function ListarProfessores($options = array())
    {
        $settings = array_merge($GLOBALS['QueryDefault'],$options);

        $aux = array(
            'total'=>0,
            'list'=>array()
        );

        $sql = "
        SELECT Count(*) total
        FROM dbo.nvt_professores";
        $res = parent::ExecuteQuery($sql);
        while($row = sqlsrv_fetch_array($res))
            $aux['total'] = intval($row['total']);

        $sql = "
        SELECT
            id,
            nome
        FROM dbo.nvt_professores";
        $res = parent::ExecuteQuery($sql);
        while($row = sqlsrv_fetch_array($res))
            array_push($aux['list'],$row);
        return $aux;
    }
    
    public function SalvarProfessor()
    {
        $sql = "";
        $stmt = null;
        if(intval($_POST['id'])==0)
        {
            $sql = "
            INSERT INTO dbo.nvt_professores
            (nome)
            VALUES
            (?)";
            $stmt = parent::Prepare($sql, array(
                &$_POST['nome']
            ));
        }
        else
        {
            $sql = "
            UPDATE dbo.nvt_professores
            SET nome = ?
            WHERE id = ?";
            $stmt = parent::Prepare($sql, array(
                &$_POST['nome'],
                &$_POST['id']
            ));
        }
        parent::ExecuteQuery($stmt);
        return array('status'=>1,'mensagem'=>'Salvo com sucesso');
    }

    public function ListarAlunos($professor)
    {
        $aux = array(
            'total'=>0,
            'list'=>array()
        );

        $sql = "
        SELECT Count(*) total
        FROM dbo.nvt_alunos WHERE professor = ".$professor;
        $res = parent::ExecuteQuery($sql);
        while($row = sqlsrv_fetch_array($res))
            $aux['total'] = intval($row['total']);

        $sql = "
        SELECT
            id,
            nome,
            mensalidade,
            CONVERT(date, data_vencimento, 103) data_vencimento 
        FROM dbo.nvt_alunos WHERE professor = ".$professor;
        $res = parent::ExecuteQuery($sql);
        while($row = sqlsrv_fetch_array($res))
            array_push($aux['list'],$row);
        return $aux;
    }
    public function GetProfessor($id)
    {
        $aux = array(
            'id'=>isset($_POST['id'])?$_POST['id']:0,
            'nome'=>isset($_POST['nome'])?$_POST['nome']:''
        );

        if(intval($id)>0)
        {
            $sql = "
            SELECT
                id,
                nome
            FROM dbo.nvt_professores
            WHERE id = ".$id;
            $res = parent::ExecuteQuery($sql);
            if($row = sqlsrv_fetch_array($res))
                $aux = $row;
        }
        return $aux;
    }
}

?>