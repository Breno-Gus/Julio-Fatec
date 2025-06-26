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
        
        <form action="<?php echo 'http://'.APP_HOST.'/usuarios/salvar/editar';?>" method="post" id="formEditarProduto">
          <div class="form-group">
              <input type="hidden" name="id" value="<?php echo $viewVar['usuario']->getLogin();?>">
          </div>
          <div class="form-group">
            <label for="nome">Nome do Usuario</label>
            <input type="text" class="form-control" name="nome" value="<?php echo $viewVar['usuario']->getNome(); ?>" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo $viewVar['usuario']->getEmail(); ?>" required>
          </div>
          <div class="form-group">
            <label for="permissao">Permissao</label>
            <input type="text" class="form-control" name="permissao" value="<?php echo $viewVar['usuario']->getPermissao(); ?>" required>
            </div>
          </div>
          <button type="submit" class="btn btn-success btn-sm">Salvar</button>
        </form>
      </div>
      <div class=" col-md-3"></div>
    </div>
  </div>
</main>

