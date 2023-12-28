<!-- criando o banco de dados

CREATE DATABASE CRUDPDO;

USE CRUDPDO;

CREATE TABLE PESSOA
(
id int AUTO_INCREMENT PRIMARY key,
nome varchar(40), 
telefone varchar(15),
email varchar(50)
);                             -->


<?php

//------------------------------conexão---------------------------------//
/*
try 
{
    $pdo = new PDO("mysql:dbname=CRUDPDO;host=localhost","root","");

} catch (PDOException $e) {

    echo "Erro com banco de dados: ".$e->getMessage();

}
catch (Exception $e) { 

    echo "Erro genérico: ".$e->getMessage();

} */

//--------------------------------insert-------------------------------//
/*
// 1° forma
$res = $pdo->prepare("INSERT INTO pessoa(nome,telefone,email) VALUES (:n, :t, :e)");
$res->bindValue(":n","nome");
$res->bindValue(":t","telefone");
$res->bindValue(":e","email");
$res->execute();

/*2° forma
$pdo->query("INSERT INTO pessoa(nome,telefone, email) VALUES ('teste','00000000000',
'teste@gmail.com')"); */

//---------------------------------delete--------------------------------//

//1°forma
//$res = $pdo->prepare("DELETE FROM pessoa WHERE id= :id");
//$id = 2;
//$res->bindValue(":id",$id);
//$res->execute();

//2°fomra
//$res = $pdo->query("DELETE FROM pessoa WHERE id= '3'");

//-------------------------------update--------------------------------//

//$res = $pdo->prepare("UPDATE pessoa SET email = :e WHERE id= :id");
//$res->bindValue(":e","Arlindo@arlindo");
//$res->bindValue(":id",1);
//$res->execute();

//-------------------------------select--------------------------------//

//$res = $pdo->prepare("SELECT * FROM pessoa WHERE id= :id");
//$res->bindValue(":id",1);
//$res->execute();
//$resultado = $res->fetch(PDO::FETCH_ASSOC);

//foreach($resultado as $key => $value) {
//    echo $key.": ".$value."<br>";
//}


?>
