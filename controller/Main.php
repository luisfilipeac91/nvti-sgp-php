<?php

class Main
{
    private $conn;
    public function __construct()
    {
        // CUSTOMIZADO SQLSERVER
        // $this->conn = odbc_connect($GLOBALS['DataBase_CS'][0]);
        $this->conn = sqlsrv_connect($GLOBALS['DataBase_CS'][0]['Server'],array(
            'Database'=>$GLOBALS['DataBase_CS'][0]['Database'],
            'UID'=>$GLOBALS['DataBase_CS'][0]['UID'],
            'PWD'=>$GLOBALS['DataBase_CS'][0]['PWD'],
            'ReturnDatesAsStrings'=>true,
            'CharacterSet' => 'UTF-8'
        ));
        if(!$this->conn) die(print_r(sqlsrv_errors(), true));
    }
    protected function ExecuteQuery($obj)
    {
        if(is_string($obj))
        {
            $res = sqlsrv_query($this->conn, $obj, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
            if(!$res) die(print_r(sqlsrv_errors(),true));
            return $res;
        }
        else
        {
            if($res = sqlsrv_execute($obj)===false)
                die(print_r(sqlsrv_errors(), true));
            return $res;
        }
    }
    protected function Prepare($sql, $arr)
    {
        $stmt = sqlsrv_prepare($this->conn, $sql, $arr);
        if(!$stmt) die(print_r(sqlsrv_errors(),true));
        return $stmt;
    }
}
?>