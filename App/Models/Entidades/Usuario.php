<?php

namespace App\Models\Entidades;

use DateTime;

class Usuario
{
    private $login;
    private $nome;
    private $email;
    private $permissao;
    private $senha;

    public function setUsuario($dados) {
      if (isset($dados['login'])) { $this->login = $dados['login'];}
      $this->nome = $dados['nome'];
      $this->email = $dados['email'];
      $this->permissao = $dados['permissao'];
      $this->senha = $dados['senha'];
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

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha= $senha;
    }


}

