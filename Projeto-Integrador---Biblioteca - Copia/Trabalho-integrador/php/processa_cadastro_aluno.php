<?php
session_start();
require '../php/conexao.php'; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../cadastro_aluno.php');
    exit();
}

$nome = trim($_POST['nome'] ?? '');
$cpf = trim($_POST['cpf'] ?? '');
$data_nascimento = $_POST['data_nascimento'] ?? '';
$matricula = trim($_POST['matricula'] ?? '');
$senha = $_POST['senha'] ?? '';
$nivel = 'usuario'; 

if ($nome === '' || $cpf === '' || $data_nascimento === '' || $matricula === '' || $senha === '') {
    echo "<script>alert('Preencha todos os campos.'); history.back();</script>";
    exit();
}

$hash = password_hash($senha, PASSWORD_DEFAULT);
$con = Conexao::getConexao();

$con->beginTransaction();

try {
    $stmtLogin = $con->prepare("INSERT INTO Login (matricula, senha_hash, nivel)
                                VALUES (:matricula, :senha, :nivel)");
    $stmtLogin->bindParam(':matricula', $matricula);
    $stmtLogin->bindParam(':senha', $hash);
    $stmtLogin->bindParam(':nivel', $nivel);
    $stmtLogin->execute();

    $login_id = $con->lastInsertId();

    $stmtAluno = $con->prepare("INSERT INTO cad_alunos (login_id, nome, cpf, data_nascimento)
                                VALUES (:login_id, :nome, :cpf, :data_nascimento)");
    $stmtAluno->bindParam(':login_id', $login_id);
    $stmtAluno->bindParam(':nome', $nome);
    $stmtAluno->bindParam(':cpf', $cpf);
    $stmtAluno->bindParam(':data_nascimento', $data_nascimento);
    $stmtAluno->execute();

    $con->commit();

    echo "<script>alert('Cadastro realizado com sucesso! Faça seu login.'); window.location.href='../login_aluno.php';</script>";

} catch (PDOException $e) {
    $con->rollBack();
    if ($e->errorInfo[1] == 1062) {
        echo "<script>alert('Erro: CPF ou Matrícula já cadastrados!'); history.back();</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar usuário: " . addslashes($e->getMessage()) . "'); history.back();</script>";
    }
}
?>