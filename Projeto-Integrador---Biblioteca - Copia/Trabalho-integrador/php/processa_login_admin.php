<?php
session_start();
require '../php/conexao.php'; // Verifique o caminho para a classe Conexao

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../html/login_admin.html');
    exit();
}

$matricula = $_POST['matricula'] ?? '';
$senha = $_POST['senha'] ?? '';

if ($matricula === '' || $senha === '') {
    echo "<script>alert('Preencha todos os campos.'); history.back();</script>";
    exit();
}

try {
    $con = Conexao::getConexao();

    // 1. Buscar o registro na tabela Login pela matrícula
    $stmt = $con->prepare("SELECT id, matricula, senha_hash, nivel FROM Login WHERE matricula = :matricula");
    $stmt->bindParam(':matricula', $matricula);
    $stmt->execute();
    $login = $stmt->fetch(PDO::FETCH_ASSOC);

    // 2. Verificar a matrícula, senha e nível de acesso
    if ($login && password_verify($senha, $login['senha_hash']) && $login['nivel'] === 'admin') {

        // 3. Buscar nome do funcionário na tabela 'cad_funcionarios'
        $stmtFunc = $con->prepare("SELECT nome FROM cad_funcionarios WHERE login_id = :login_id");
        $stmtFunc->bindParam(':login_id', $login['id']);
        $stmtFunc->execute();
        $funcionario = $stmtFunc->fetch(PDO::FETCH_ASSOC); 

        // 4. Criar a Sessão de ADMIN
        $_SESSION['admin_id'] = $login['id']; // ID da tabela Login
        $_SESSION['admin_nome'] = $funcionario['nome'] ?? 'Admin Sem Nome';
        $_SESSION['nivel'] = $login['nivel'];

        header("Location: ../html/inicio.php"); // Redireciona para o dashboard admin
        exit();

    } else {
        echo "<script>alert('Matrícula, senha ou nível de acesso incorretos!'); history.back();</script>";
    }

} catch (PDOException $e) {
    // Mensagem genérica para o usuário, mas erro detalhado para você
    echo "<script>alert('Erro no servidor. Tente novamente mais tarde.'); history.back();</script>";
    // Para debugar: die("Erro de PDO: " . $e->getMessage()); 
}
?>