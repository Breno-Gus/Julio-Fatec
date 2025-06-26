<?php

namespace App\Models\Entidades;

class Usuario
{
    private $login;
    private $nome;
    private $senha;
    private $email;
    private $permissao;

    public function setUsuario($dados) {
      if (isset($dados['login'])) { $this->id = $dados['login'];}
      $this->nome = $dados['nome'];
      $this->senha = $dados['senha'];
      $this->email = $dados['email'];
      $this->permissao= $dados['permissao'];
    }

    
    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
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

    public function getPermissao()
    {
        return $this->permissao;
    }

    public function setPermissao($permissao)
    {
        $this->permissao= $permissao;
    }

}

