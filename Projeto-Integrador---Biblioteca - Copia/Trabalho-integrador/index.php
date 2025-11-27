<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libris - Sua Biblioteca Online</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/global.css">
</head>
<body>
    
    <header class="public-header">
        <a href="index.php" class="logo">Libris</a>
        <nav class="public-nav">
            <a href="index.php">Início</a>
            <a href="acervo.php">Nosso Acervo</a>
            <a href="login_aluno.php" class="btn-primary">Login / Cadastro</a>
        </nav>
    </header>

    <main>
        <section class="hero-section">
            <div class="hero-content">
                <h1>Expanda sua mente,<br>lendo um livro.</h1>
                <p>Explore nosso acervo e comece sua próxima aventura.</p>
                <a href="acervo.php" class="btn-primary">Ver Acervo Completo</a>
            </div>
        </section>

        <section class="acervo-container">
            <h2>Novas Aquisições</h2>
            <hr>
            <div class="acervo-grid">
                <?php
                require_once "php/conexao.php";
                $con = Conexao::getConexao();
                
                // Query para buscar os 8 livros mais recentes
                $sql = "SELECT * FROM cad_livros ORDER BY data_lancamento DESC LIMIT 8";
                $stmt = $con->query($sql);
                
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="book-card">';
                    $capa = $row['imagem_capa'] ? $row['imagem_capa'] : 'imagens/capa-padrao.png';
                    echo '<img src="' . htmlspecialchars($capa) . '" alt="Capa">';
                    echo '<h3>' . htmlspecialchars($row['titulo']) . '</h3>';
                    echo '<p>' . htmlspecialchars($row['autor']) . '</p>';
                    echo '<a href="livro_detalhe.php?id=' . $row['id'] . '" class="btn login">Ver Detalhes</a>';
                    echo '</div>';
                }
                ?>
            </div>
        </section>
    </main>

</body>
</html>