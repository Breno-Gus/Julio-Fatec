<main role="main" class="flex-shrink-0">
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <h1 class="mt-2">Editar dados do Produto</h1>
        <?php
        //Mensagens de Erro ou Sucesso na execução das funções
        echo $Sessao::retornaMensagem();
        $Sessao::limpaMensagem();
      
        ?>
        
        <form action="<?php echo 'http://'.APP_HOST.'/produto/salvar/editar';?>" method="post" id="formEditarProduto">
          <div class="form-group">
              <input type="hidden" name="id" value="<?php echo $viewVar['produto']->getId();?>">
          </div>
          <div class="form-group">
            <label for="nome">Nome do Produto</label>
            <input type="text" class="form-control" name="nome" value="<?php echo $viewVar['produto']->getNome(); ?>" required>
          </div>
          <div class="form-group">
            <label for="permissao">Descrição</label>
            <textarea class="form-control" name="permissao"><?php echo $viewVar['produto']->getPermissao(); ?>
            </textarea>
          </div>
          <div class="form-group">
            <label for="senha">Preço</label>
            R$ <input type="text" class="form-control <?php if ($Sessao::retornaErro('errosenha')!="") echo "is-invalid"; ?>" name="senha" value="<?php echo $viewVar['produto']->getSenha();?>">
            <div class="invalid-feedback">
              <?php echo $Sessao::retornaErro('errosenha'); $Sessao::limpaErro(); ?>
            </div>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="number" class="form-control" name="email" value="<?php echo $viewVar['produto']->getEmail();?>" required>
          </div>
          <button type="submit" class="btn btn-success btn-sm">Salvar</button>
        </form>
      </div>
      <div class=" col-md-3"></div>
    </div>
  </div>
</main>

