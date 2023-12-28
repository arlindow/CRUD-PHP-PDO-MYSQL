<?php

Class Pessoa
{

    private $pdo; 

    //conexão com o banco de dados
    public function __construct($dbname, $host, $user, $senha) 
    {
        //tratamento de erros
        try
        {
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
        }
        catch(PDOException $e)
        {
            echo "Erro com banco de dados: ".$e->getMessage();
            exit();
        }
        catch (Exception $e)
        {
            echo "Erro generico: ".$e->getMessage();
            exit();
        }
    }

    /* é responsável por executar uma consulta SQL para obter todos os registros da tabela 'pessoa1', 
    ordenados pelo campo 'nome', e retorna esses resultados como um array associativo.*/
    public function buscarDados()
    {
        $res = array();// Cria um array vazio para armazenar os resultados "nome"
        $cmd = $this->pdo->query("SELECT * FROM pessoa1 ORDER BY id ASC ");// Executa uma consulta SQL para selecionar todos os campos da tabela 'pessoa' e ordena pelo campo 'nome'
        $res = $cmd->fetchALL(PDO::FETCH_ASSOC);// Obtém todos os resultados como um array associativo
        return $res;// Retorna o array contendo os resultados
    }

    public function cadastrarPessoa($nome, $telefone, $email)
    {
        //antes de cadastrar, verificar se o email já está cadastrado
        $cmd = $this->pdo->prepare("SELECT id from pessoa1 WHERE email = :e");
        $cmd->bindValue(":e", $email);
        $cmd->execute();
        if($cmd->rowCount() > 0)
        {
            return false;
        }
        else//não foi encontrado, pode cadastrar
        {
            $cmd = $this->pdo->prepare("INSERT INTO pessoa1 (nome, telefone, email) VALUES (:n, :t, :e)");
            $cmd -> bindValue(":n",$nome);
            $cmd -> bindValue(":t",$telefone);
            $cmd -> bindValue(":e",$email);
            $cmd -> execute();
            return true;
        }
    }

    public function excluirPessoa($id)
    {
        $cmd = $this->pdo->prepare("DELETE FROM pessoa1 WHERE id =:id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

    //buscar dados de uma pessoa
    public function buscarDadosPessoa($id)
    {   
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM pessoa1 WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    //-----------------------atualizar dados no banco de dados---------------------------//
    public function atualizarDados($id, $nome, $telefone, $email)
    {   
        // Verificar se o novo email já está cadastrado
        $cmdVerificar = $this->pdo->prepare("SELECT id FROM pessoa1 WHERE email = :e AND id <> :id");
        $cmdVerificar->bindValue(":e", $email);
        $cmdVerificar->bindValue(":id", $id);
        $cmdVerificar->execute();

        if ($cmdVerificar->rowCount() > 0) 

            {
            // Email já cadastrado, enviar aviso
            return "Email já cadastrado!";
            } 
            else 
            {
            // Atualizar os dados
            $cmdAtualizar = $this->pdo->prepare("UPDATE pessoa1 SET nome = :n, telefone = :t, email = :e WHERE id = :id");
            $cmdAtualizar->bindValue(":n", $nome);
            $cmdAtualizar->bindValue(":t", $telefone);
            $cmdAtualizar->bindValue(":e", $email);
            $cmdAtualizar->bindValue(":id", $id);
            $cmdAtualizar->execute();
            return true;
            }    
   
    
    }    
}
?>