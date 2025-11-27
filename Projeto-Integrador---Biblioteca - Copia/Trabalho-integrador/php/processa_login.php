<?php
session_start();
require '../php/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../html/login.html');
    exit();
}

$matricula = $_POST['matricula'] ?? '';
$senha = $_POST['senha'] ?? '';

if ($matricula === '' || $senha === '') {
    echo "<script>alert('Preencha todos os campos.'); history.back();</script>";
    exit();
}

$con = Conexao::getConexao();

$stmt = $con->prepare("SELECT * FROM Login WHERE matricula = :matricula");
$stmt->bindParam(':matricula', $matricula);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
    $_SESSION['id'] = $usuario['id'];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['nivel'] = $usuario['nivel'];

    header("Location: ./inicio.php");
    exit();
} else {
    echo "<script>alert('Matrícula ou senha incorretas!'); history.back();</script>";
}
?>
