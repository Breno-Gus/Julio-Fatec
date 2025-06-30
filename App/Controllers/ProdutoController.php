<?php

namespace App\Controllers;

use App\Lib\Sessao;
use App\Models\DAO\ProdutoDAO;
use App\Models\Entidades\Produto;
use App\Lib\Util;

class ProdutoController extends Controller
{
  public function listar()
    {
      $produtoDAO = new ProdutoDAO();  
      self::setViewParam('listaProdutos',$produtoDAO->listar());
      $this->render('/produto/listar'); 
      Sessao::limpaMensagem();
    }
    
    public function editar($params)
    {
      $id = $params[0]; 
      $produtoDAO = new ProdutoDAO();
      $objProduto = $produtoDAO->listar($id);

      if ($objProduto == null) 
      {
        Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Falha ao recuperar dados do produto id='.$id.'</div>');
        $this->redirect('/produto/listar');
      }
            
      self::setViewParam('produto',$objProduto);
      $this->render('/produto/editar');

      Sessao::limpaMensagem();  
    }

    public function salvar($param) {
      $cmd = $param[0];
      $dadosform = Util::sanitizar($_POST);
      $objproduto = new Produto();
      $objproduto->setProduto($dadosform);
      
      $errovalidacao = false;
      if (empty($dadosform['preco'])) {
        Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Verifique os Campos em Vermelho.</div>');
        Sessao::gravaErro('erropreco','Este campo deve ser preemchido');
        $errovalidacao = true;
      }

      if ($errovalidacao) { 
        self::setViewParam('produto',$objproduto);
        if ($cmd == 'editar'){ 
          $this->render('/produto/editar');
        }elseif ($cmd == 'novo'){ 
          $this->render('/produto/cadastrar');
        }
        return;
      }
        
      $produtoDAO = new ProdutoDAO(); 
      
      if ($cmd == 'editar'){ 
        $produtoDAO->atualizar($objproduto);
        Sessao::gravaMensagem('<div class="alert alert-success" role="alert">Produto atualizado com sucesso.</div>');
      }elseif ($cmd == 'novo'){ 
        $produtoDAO->salvar($objproduto);
        Sessao::gravaMensagem('<div class="alert alert-success" role="alert">Novo Produto gravado com sucesso.</div>');
      }
      
      Sessao::limpaErro();
      $this->redirect('/produto/listar');      
    }
    
    public function excluirConfirma($param)
    {
      $id = $param[0];
      
      $produtoDAO = new ProdutoDAO();

      $objProduto = $produtoDAO->listar($id);

      if ($objProduto==null) 
      {
        Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Falha ao recuperar dados do produto id='.$id.'</div>');
        $this->redirect('/produto/listar');
      }
            
      self::setViewParam('produto',$objProduto);
      
      $this->render('/produto/excluirConfirma');
    }
    
    public function excluir($param)
    {
      $objproduto = new Produto();
      //Pega o id do produto a ser excluído
      $objproduto->setId(Util::sanitizar($_POST['id']));
      
      $produtoDAO = new ProdutoDAO();

      if(!$produtoDAO->excluir($objproduto)){
        Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Produto Não Encontrado.</div>');
      }else{
        Sessao::gravaMensagem('<div class="alert alert-success" role="alert">Produto excluído com sucesso!.</div>');
      }
      $this->redirect('/produto/listar');  
    }

    public function cadastrar()
    {
        $this->render('/produto/cadastrar');
        Sessao::limpaMensagem();
        Sessao::limpaErro();
    }
}
