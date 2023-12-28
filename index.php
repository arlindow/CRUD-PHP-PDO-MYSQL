<?php

//Inclui a classe Pessoa do arquivo classePessoa.php
require_once 'classePessoa.php';

/* Cria uma nova instância da classe Pessoa, passando 
os parâmetros para conexão com o banco de dados*/
$p = new Pessoa("crudpdo", "localhost","root", "");

?>

<!-- ----------------------------------------------------------------------------------->
<!DOCTYPE html>         
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Document</title>
</head>
<body>

<?php

// Clicou no botão cadastrar ou atualizar
if (isset($_POST['nome']))  
{
    //----------------------------------Atualizar----------------------------------//
    if (isset($_GET['id_up']) && !empty($_GET['id_up'])) {  //verifica se o parâmetro id_up (botão atualizar) está presente na URL ($_GET), e se o valor associado a esse parâmetro não é vazio. 
        $id_upd = addslashes($_GET['id_up']);
        $nome = addslashes($_POST['nome']);
        $telefone = addslashes($_POST['telefone']);
        $email = addslashes($_POST['email']);
        
        if (!empty($nome) && !empty($telefone) && !empty($email)) {
            //-------------------------Atualizar---------------------------------//

            $resultadoAtualizacao = $p->atualizarDados($id_upd, $nome, $telefone, $email);

            if ($resultadoAtualizacao === true) {
                header("Location: index.php");
                exit(); // Termina o script após o redirecionamento
            } else {
                // Exibir mensagem de aviso
                ?>
                <div class="aviso">
                    <img src="imagens\aviso.png" alt="aviso">
                    <h4><?php echo $resultadoAtualizacao; ?></h4>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="aviso">
                <img src="imagens\aviso.png" alt="aviso">
                <h4>Preencha todos os campos!</h4>
            </div>
            <?php
        }    

    }else{
    //---------------------------------Cadastrar-------------------------------------//
    $nome = isset($_POST['nome']) ? addslashes($_POST['nome']) : '';   
    $telefone = isset($_POST['telefone']) ? addslashes($_POST['telefone']) : '';
    $email = isset($_POST['email']) ? addslashes($_POST['email']) : '';
    
    if (!empty($nome) && !empty($telefone) && !empty($email)) {
        if (!$p->cadastrarPessoa($nome, $telefone, $email)) {

            ?>
            <div class="aviso">
            <img src="imagens\aviso.png" alt="aviso">
            <h4> Email já está cadastrado!</h4>
            </div>
            <?php

        } else {
            header("Location: index.php");
            exit(); // Termina o script após o redirecionamento
        }
    } else {

        ?>
        <div class="aviso">
        <img src="imagens\aviso.png" alt="aviso"> 
        <h4>Preencha todos os campos!</h4>
        </div>
        <?php
    }
    
    }
}

?>

    <!-- criando a variavel para trazer os dados para o formulário da esquerda -->
    <?php 
        if(isset($_GET['id_up']))
        {
            $id_update = addslashes($_GET['id_up']);
            $res = $p->buscarDadosPessoa($id_update);
        }

        ?>

    <!-- Seção da esquerda: Formulário de cadastro de pessoa -->
    <section id="esquerda">
        <form method="POST">
            <h2>CADASTRAR PESSOA</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome"
            value="<?php if(isset($res)){echo $res['nome'];}?>"
            >
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone"
            value="<?php if(isset($res)){echo $res['telefone'];}?>"
            >
            <label for="email">Email</label>
            <input type="email" name="email" id="email"
            value="<?php if(isset($res)){echo $res['email'];}?>"
            >
            <input type="submit" value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";} ?>">

        </form>
    </section>

    <!---------------- Seção da direita: Exibição dos dados em uma tabela ------------------------>
    <section id="direita">
        <table>
            <tr id="titulo">
                <td>Nome</td>
                <td>Telefone</td>
                <td colspan="2">Email</td>
            </tr>
    <!------------------------------------------------------------------------------------------->        
        <?php
            $dados = $p->buscarDados();/*Chama o método buscarDados() da instância da classe Pessoa 
            para obter os dados do banco de dados*/

            if(count($dados) > 0 )// Verifica se há dados a serem exibidos
            {

                for ($i=0; $i < count ($dados); $i++) // Loop pelos dados obtidos
                {
                    echo "<tr>";
                    foreach($dados[$i] as $k => $v)/* Loop pelos campos de cada registro, O valor de cada campo 
                    é atribuído à variável $v, e a chave é atribuída à variável $k.*/
                    {
                        if($k!="id")// Exibe os valores dos campos, exceto o campo "id"
                        {   
                            echo "<td>".$v."</td>";
                        }
                    }
        ?>  

    <!---------------------------------- Coluna de ações (Editar e Excluir) ------------------------------->
        <td>
            <!--<?php echo $dados[$i]['id'];?> visualizar id --> 
            <a href="index.php?id_up=<?php echo $dados[$i]['id'];?>" >Editar</a>
            <a href="index.php?id=<?php echo $dados[$i]['id'];?>" id="excluir">Excluir</a>
        </td>

    <!---------------------------------------------------------------------------------------------------->               
        <?php
        if (isset($_GET['id']) && !empty($_GET['id'])) 
        
        {
        $id_excluir = addslashes($_GET['id']);
        $p->excluirPessoa($id_excluir);
        header("Location: index.php");
        exit(); // Termina o script após o redirecionamento
        }
        
        ?>

        <?php            
                    echo "</tr>";
                }
        
            }
            else
            {
        ?>   
        </table>    

                <div class="aviso">
                <img src="imagens\aviso.png" alt="aviso">
                <h4>Ainda não há pessoas cadastradas!</h4>
                </div>

                <?php
            }

        ?>
        
    </section>
</body>
</html>

