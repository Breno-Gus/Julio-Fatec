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

        self::setViewParam('listaUsuario',$usuarioDAO->listar());
        $this->render('/usuario/listar');

        Sessao::limpaMensagem();
    }
    
    public function editar($params)
    {
      $login = $params[0]; 

      $usuarioDAO = new UsuarioDAO();

      $usuarioObj = $usuarioDAO->listar($login);

      if ($usuarioObj==null) 
      {
        Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Falha ao recuperar dados do usuario id='.$login.'</div>');
        $this->redirect('/usuario/listar');
      }
            
      self::setViewParam('usuario',$usuarioObj);

      $this->render('/usuario/editar');

      Sessao::limpaMensagem();      
    }

    public function salvar($param) {
      $cmd = $param[0];
      $dadosform = Util::sanitizar($_POST);

      $usuarioObj = new Usuario();
      $usuarioObj->setUsuario($dadosform);
      
      $errovalidacao = false;
      if (empty($dadosform['senha'])) {
        Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Verifique os Campos em Vermelho.</div>');
        Sessao::gravaErro('errosenha','Este campo deve ser preemchido');
        $errovalidacao = true;
      }

      if ($errovalidacao) { 
        self::setViewParam('usuario',$usuarioObj);
        if ($cmd == 'editar'){ 
          $this->render('/usuario/editar');
        }elseif ($cmd == 'novo'){ 
          $this->render('/usuario/cadastrar');
        }
        return; 
      }

        
      $usuarioDAO = new UsuarioDAO(); 

      if ($cmd == 'editar'){ 
        $usuarioDAO->atualizar($usuarioObj);
        Sessao::gravaMensagem('<div class="alert alert-success" role="alert">Usuario atualizado com sucesso.</div>');
      }elseif ($cmd == 'novo'){ 
        $usuarioDAO->salvar($usuarioObj);
        Sessao::gravaMensagem('<div class="alert alert-success" role="alert">Novo Usuario gravado com sucesso.</div>');
      }
      
      Sessao::limpaErro();
      $this->redirect('/usuario/listar');      
    }
    
    public function excluirConfirma($param) 
    {
      $id = $param[0];
      
      $usuarioDAO = new UsuarioDAO();

      $usuarioObj = $usuarioDAO->listar($id);

      if ($usuarioObj === null) 
      {
        Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Falha ao recuperar dados do usuario id='.$id.'</div>');
        $this->redirect('/usuario/listar');
      }
            
      self::setViewParam('usuario',$usuarioObj);
      $this->render('/usuario/excluirConfirma');
    }
    
    public function excluir($param)
    {
      $usuarioObj = new Usuario();
      $usuarioObj->setLogin(Util::sanitizar($_POST['login']));
      $usuarioDAO = new UsuarioDAO();

      if(!$usuarioDAO->excluir($usuarioObj)){
        Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Usuario Não Encontrado.</div>');
      }else{Sessao::gravaMensagem('<div class="alert alert-success" role="alert">Usuario excluído com sucesso!.</div>');}
      $this->redirect('/usuario/listar');  
    }

    public function cadastrar()
    {
        $this->render('/usuario/cadastrar');
        Sessao::limpaMensagem();
        Sessao::limpaErro();
    }
}