<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Aluno</title>
    <link rel="stylesheet" href="css/global.css">
</head>
<body>
<main id="welcomePage">
    <div class="containerWelcome">
        <h1>Criar Conta de Aluno</h1>
        <form action="php/processa_cadastro_aluno.php" method="POST" class="flexColumn">
            <label>Nome Completo</label>
            <input type="text" class="input signin" name="nome" required>

            <label>CPF (só números)</label>
            <input type="text" class="input signin" name="cpf" maxlength="11" required>

            <label>Data de Nascimento</label>
            <input type="date" class="input signin" name="data_nascimento" required>

            <label>Matrícula (Ex: 20240001)</label>
            <input type="text" class="input signin" name="matricula" maxlength="17" required>

            <label>Senha</label>
            <input type="password" class="input signin" name="senha" required>

            <button type="submit" class="btn login">Finalizar cadastro</button>
        </form>
        <a class="btn signin" href="login_aluno.php">Já tenho conta</a>
    </div>
</main>
</body>
</html>