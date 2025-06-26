<?php

namespace App\Models\DAO;

use App\Models\Entidades\Usuario;

class UsuarioDAO extends BaseDAO
{
    public  function listar($id = null)
    {
        if($id) {
            $resultado = $this->select(
                "SELECT * FROM usuario WHERE id = {$id}"
            );

            return $resultado->fetchObject(Usuario::class);
        }else{
            $resultado = $this->select(
                'SELECT * FROM usuario'
            );
            return $resultado->fetchAll(\PDO::FETCH_CLASS, Usuario::class);
        }

        return false;
    }

    public  function salvar(Usuario $usuario) 
    {
        try {

            $nome           = $usuario->getNome();
            $senha          = $usuario->getSenha();
            $email          = $usuario->getEmail();
            $permissao      = $usuario->getPermissao();

            return $this->insert(
                'usuario',
                ":nome,:senha,:email,:permissao",
                [
                    ':nome'=>$nome,
                    ':senha'=>$senha,
                    ':email'=>$email,
                    ':permissao'=>$permissao
                ]
            );

        }catch (\Exception $e){
            throw new \Exception("Erro na gravação de dados.", 500);
        }
    }

    public  function atualizar(Usuario $usuario) 
    {
        try {

            $id             = $usuario->getId();
            $nome           = $usuario->getNome();
            $senha          = $usuario->getSenha();
            $email          = $usuario->getEmail();
            $permissao      = $usuario->getPermissao();

            return $this->update(
                'usuario',
                "nome = :nome, preco = :preco, quantidade = :quantidade, descricao = :descricao",
                [
                    ':id'=>$id,
                    ':nome'=>$nome,
                    ':senha'=>$senha,
                    ':email'=>$email,
                    ':permissao'=>$permissao
                ],
                "id = :id"
            );

        }catch (\Exception $e){
            throw new \Exception("Erro na gravação de dados.", 500);
        }
    }

    public function excluir(Usuario $usuario)
    {
        try {
            $id = $usuario->getId();

            return $this->delete('usuario',"id = $id");

        }catch (Exception $e){

            throw new \Exception("Erro ao deletar", 500);
        }
    }
}

