<?php

namespace App\Models\DAO;

use App\Lib\Conexao;

abstract class BaseDAO
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getConnection();
    }

    public function select($sql, $params = [])
    {
        if (!empty($sql)) {
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        }
        return false;
    }


    public function insert($table, $cols, $values) 
    {
        if(!empty($table) && !empty($cols) && !empty($values))
        {
            $parametros    = $cols;
            $colunas       = str_replace(":", "", $cols);
            
            //             $table   $colunas             $cols
            //INSERT INTO usuario (nome,email) VALUES (:nome,:email);
            $stmt = $this->conexao->prepare("INSERT INTO $table ($colunas) VALUES ($parametros)");
            $stmt->execute($values);

            return $stmt->rowCount();
        }else{
            return false;
        }
    }

    public function update($table, $cols, $values, $where=null) 
    {
        if(!empty($table) && !empty($cols) && !empty($values))
        {
            if($where)
            {
                $where = " WHERE $where ";
            }

            $stmt = $this->conexao->prepare("UPDATE $table SET $cols $where");
            $stmt->execute($values);

            return $stmt->rowCount();
        }else{
            return false;
        }
    }
    
    public function delete($table, $where = null, $params = [])
    {
        if (!empty($table)) {
            if ($where) {
                $where = " WHERE $where ";
            }

            $stmt = $this->conexao->prepare("DELETE FROM $table $where");
            $stmt->execute($params);

            return $stmt->rowCount();
        } else {
            return false;
        }
    }
}