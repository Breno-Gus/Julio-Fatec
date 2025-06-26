<?php

namespace App\Controllers;

use App\Lib\Sessao;
use App\Models\DAO\UsuarioDAO;
use App\Models\Entidades\Usuario;
use App\Lib\Util;

class UsuarioController extends Controller
{
    public function listar()
    {
        $usuarioDAO = new UsuarioDAO();  
        self::setViewParam('listaUsuarios', $usuarioDAO->listar()); // Busca todos os usuários
        $this->render('/usuarios/listar'); 
        Sessao::limpaMensagem();
    }

    public function editar($params)
    {
        $id = $params[0];
        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->buscarPorLogin($id); // Nome mais claro

        if ($usuario === null) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Usuário com ID '.$id.' não encontrado.</div>');
            $this->redirect('/usuarios/listar');
            return;
        }

        self::setViewParam('usuarios', $usuario);
        $this->render('/usuarios/editar');
        Sessao::limpaMensagem();      
    }

    public function salvar($param)
    {
        $cmd = $param[0]; // novo ou editar
        $dadosForm = Util::sanitizar($_POST);

        $usuario = new Usuario();
        $usuario->setUsuario($dadosForm);

        $erroValidacao = false;

        // Validação mínima
        if (empty($dadosForm['senha'])) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Verifique os campos obrigatórios.</div>');
            Sessao::gravaErro('errosenha', 'O campo senha deve ser preenchido.');
            $erroValidacao = true;
        }

        if (!filter_var($dadosForm['email'], FILTER_VALIDATE_EMAIL)) {
            Sessao::gravaErro('erroemail', 'Email inválido.');
            $erroValidacao = true;
        }

        if ($erroValidacao) {
            self::setViewParam('usuarios', $usuario);
            if ($cmd === 'editar') {
                $this->render('/usuarios/editar');
            } elseif ($cmd === 'novo') {
                $this->render('/usuarios/cadastrar');
            }
            return;
        }

        // Se a senha foi enviada, aplica hash
        if (!empty($dadosForm['senha'])) {
            $usuario->setSenha(password_hash($dadosForm['senha'], PASSWORD_DEFAULT));
        }

        $usuarioDAO = new UsuarioDAO();

        if ($cmd === 'editar') {
            $usuarioDAO->atualizar($usuario);
            Sessao::gravaMensagem('<div class="alert alert-success" role="alert">Usuário atualizado com sucesso.</div>');
        } elseif ($cmd === 'novo') {
            $usuarioDAO->salvar($usuario);
            Sessao::gravaMensagem('<div class="alert alert-success" role="alert">Novo usuário cadastrado com sucesso.</div>');
        }

        Sessao::limpaErro();
        $this->redirect('/usuarios/listar');      
    }

    public function excluirConfirma($param)
    {
        $id = $param[0];
        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->buscarPorId($id);

        if ($usuario === null) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Usuário com ID '.$id.' não encontrado.</div>');
            $this->redirect('/usuarios/listar');
            return;
        }

        self::setViewParam('usuario', $usuario);
        $this->render('/usuarios/excluirConfirma');
    }

    public function excluir($param)
    {
        $usuario = new Usuario();
        $usuario->setId(Util::sanitizar($_POST['id']));

        $usuarioDAO = new UsuarioDAO();

        if (!$usuarioDAO->excluir($usuario)) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Erro: usuário não encontrado ou não pôde ser excluído.</div>');
        } else {
            Sessao::gravaMensagem('<div class="alert alert-success" role="alert">Usuário excluído com sucesso.</div>');
        }

        $this->redirect('/usuarios/listar');  
    }

    public function cadastrar()
    {
        $this->render('/usuarios/cadastrar');
        Sessao::limpaMensagem();
        Sessao::limpaErro();
    }
}
