    <main role="main" class="flex-shrink-0">
      <div class="container">
        <h1 class="mt-5">Listagem de Usuarios</h1>
        
        <?php

        //Mensagens de Erro ou Sucesso na execução das funções
        echo $Sessao::retornaMensagem();
        $Sessao::limpaMensagem();

        if (count($viewVar['listaUsuarios'])>0){
          echo '<div class="table-responsive">';
          echo ' <table class="table table-bordered table-hover table-sm">';
          echo ' <thead >';
          echo ' <tr>';
          echo ' <th class="table-info">Login</th>';
          echo ' <th class="table-info">Nome</th>';
          echo ' <th class="table-info">Email</th>';
          echo ' <th class="table-info">Permissão</th>';
          echo ' <th class="table-info"></th>';
          echo ' </tr>';
          echo ' </thead>';
          echo ' <tbody>';
          foreach ($viewVar['listaUsuarios'] as $objProduto) {
            $id = $objProduto->getId();
            $nome = $objProduto->getNome();
            $email = $objProduto->getEmail();
            $permissao = $objProduto->getPermissao();
                                
            echo '<tr>';
            echo ' <td>'.$id.'</td>';
            echo ' <td>'.$nome.'</td>';
            echo ' <td>'.$email.'</td>';
            echo ' <td>'.$permissao.'</td>';
            echo ' <td> <a href="http://'.APP_HOST.'/produto/editar/'.$id.'" class="btn btn-info btn-sm">Editar</a>  
              <a href="http://'.APP_HOST.'/produto/excluirConfirma/'.$id.'" class="btn btn-danger btn-sm mt-1">Excluir</a>';
            echo '</tr>';
          }
          echo ' </tbody>';
          echo ' </table>';
          echo '</div>'; 
        }else {
          echo "Nenhum Produto Encontrado.";
        }         
        ?>
        
      </div>
    </main>
