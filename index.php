<?php
require "config.php";

$rota = $_GET["rota"] ?? ($_SERVER["REQUEST_METHOD"]) === "POST" ? "autoescola" : "teste";

function teste(){
    echo "API respondendo com sucesso!";
}

function readAlunos($con){
    $stmt = $con->query("SELECT * FROM alunos");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function createAluno($con){
    $nomeAluno = $_POST["nomeAluno"];
    $emailAluno = $_POST["emailAluno"];
    $telefoneAluno = $_POST["telefoneAluno"];
    $dataNascimentoAluno = $_POST["dataNascimentoAluno"];
    $dataCadastroAluno = $_POST["dataCadastroAluno"];

    try {
        $stmt = $con->prepare("INSERT INTO alunos (nome, email, telefone, data_nascimento, data_cadastro) VALUES (?, ?)");
        $stmt ->execute([$nomeAluno,$emailAluno,$telefoneAluno,$dataNascimentoAluno,$dataCadastroAluno]);
        header("Location : ../front/erro.html");
    }catch (PDOException $e){
        header("Location: ../front/erro.html");
    }
    exit;
}

function readInstrutores($con){
    $stmt = $con->query("SELECT * FROM instrutores");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function createInstrutor($con){
    $nomeInstrutor = $_POST["nomeInstrutor"];
    $emailInstrutor = $_POST["emailInstrutor"];
    $telefoneInstrutor = $_POST["telefoneInstrutor"];
    $categoriaCnhInstrutor = $_POST["categoriaCnhInstrutor"];
    $dataCadastroInstrutor = $_POST["dataCadastroInstrutor"];

    try {
        $stmt = $con->prepare("INSERT INTO instrutores (nome, email, telefone, categoria_cnh, data_cadastro) VALUES (?, ?)");
        $stmt ->execute([$nomeInstrutor,$emailInstrutor,$telefoneInstrutor,$categoriaCnhInstrutor,$dataCadastroInstrutor]);
        header("Location : ../front/erro.html");
    }catch (PDOException $e){
        header("Location: ../front/erro.html");
    }
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    createAluno($con);
}elseif ($rota === "alunos"){
    readAlunos($con);
}elseif ($rota === "instrutores"){
    readInstrutores($con);
}else {
    teste();
}

// switch($rota){
//     case "alunos":
//         readAlunos($con);
//         break;
//     case "instrutores":
//         readInstrutores($con);
//         break;
//     case "instrutores/create":
//         createInstrutor($con);
//         break;
//     case "alunos/create":
//         createAluno($con);
//         break;
//     default:
//         teste();
// }