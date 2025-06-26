<?php

namespace App\Models\Entidades;

use DateTime;

class Usuario
{
    private $id;
    private $nome;
    private $senha;
    private $email;
    private $descricao;
    private $dataCadastro;

    public function setUsuario($dados) {
      if (isset($dados['id'])) { $this->id = $dados['id'];}
      $this->nome = $dados['nome'];
      $this->senha = $dados['senha'];
      $this->email = $dados['email'];
      $this->permissao= $dados['descricao'];
    }

    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->permissao= $descricao;
    }

    public function getDataCadastro()
    {
        return new DateTime($this->dataCadastro);
    }

    public function setDataCadastro($dataCadastro)
    {
        $this->dataCadastro = $dataCadastro;
    }

}

