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
        self::setViewParam('listaProdutos', $produtoDAO->listar());
        $this->render('/produto/listar');
        Sessao::limpaMensagem();
    }

    public function editar($params)
    {
        $id = $params[0];
        $produtoDAO = new ProdutoDAO();
        $produto = $produtoDAO->buscarPorId($id);

        if ($produto === null) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Produto com ID '.$id.' não encontrado.</div>');
            $this->redirect('/produto/listar');
            return;
        }

        self::setViewParam('produto', $produto);
        $this->render('/produto/editar');
        Sessao::limpaMensagem();      
    }

    public function salvar($param)
    {
        $cmd = $param[0];
        $dadosForm = Util::sanitizar($_POST);

        $produto = new Produto();
        $produto->setProduto($dadosForm);

        $erroValidacao = false;

        // Validação básica
        if (empty($dadosForm['nome'])) {
            Sessao::gravaErro('erronome', 'O campo nome é obrigatório.');
            $erroValidacao = true;
        }

        if (!is_numeric($dadosForm['preco']) || $dadosForm['preco'] <= 0) {
            Sessao::gravaErro('erropreco', 'Informe um preço válido.');
            $erroValidacao = true;
        }

        if (!isset($dadosForm['quantidade']) || !is_numeric($dadosForm['quantidade'])) {
            Sessao::gravaErro('erroquantidade', 'Informe uma quantidade válida.');
            $erroValidacao = true;
        }

        if ($erroValidacao) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Verifique os campos destacados.</div>');
            self::setViewParam('produto', $produto);
            $this->render($cmd === 'editar' ? '/produto/editar' : '/produto/cadastrar');
            return;
        }

        $produtoDAO = new ProdutoDAO();

        if ($cmd === 'editar') {
            $produtoDAO->atualizar($produto);
            Sessao::gravaMensagem('<div class="alert alert-success" role="alert">Produto atualizado com sucesso.</div>');
        } elseif ($cmd === 'novo') {
            $produtoDAO->salvar($produto);
            Sessao::gravaMensagem('<div class="alert alert-success" role="alert">Novo produto cadastrado com sucesso.</div>');
        }

        Sessao::limpaErro();
        $this->redirect('/produto/listar');      
    }

    public function excluirConfirma($param)
    {
        $id = $param[0];
        $produtoDAO = new ProdutoDAO();
        $produto = $produtoDAO->buscarPorId($id);

        if ($produto === null) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Produto com ID '.$id.' não encontrado.</div>');
            $this->redirect('/produto/listar');
            return;
        }

        self::setViewParam('produto', $produto);
        $this->render('/produto/excluirConfirma');
    }

    public function excluir($param)
    {
        $produto = new Produto();
        $produto->setId(Util::sanitizar($_POST['id']));
        $produtoDAO = new ProdutoDAO();

        if (!$produtoDAO->excluir($produto)) {
            Sessao::gravaMensagem('<div class="alert alert-danger" role="alert">Produto não encontrado ou não pôde ser excluído.</div>');
        } else {
            Sessao::gravaMensagem('<div class="alert alert-success" role="alert">Produto excluído com sucesso!</div>');
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
