<?php
require_once('php/conexao.php'); // Inclui a classe de conexão

try {
    $con = Conexao::getConexao(); // Inicia a conexão PDO

    // Lógica de Busca e Filtro
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $categoria_filter = isset($_GET['categoria']) ? (int)$_GET['categoria'] : 0;

    // Array para os parâmetros do PDO
    $params = [];

    $sql = "SELECT l.*, c.nome_categoria 
            FROM cad_livros l
            LEFT JOIN cad_categorias c ON l.id_categoria = c.id";

    // Adiciona filtros na query
    $where = [];
    if ($search) {
        $where[] = "(l.titulo LIKE :search OR l.autor LIKE :search)";
        $params[':search'] = '%' . $search . '%';
    }
    if ($categoria_filter) {
        $where[] = "l.id_categoria = :categoria_id";
        $params[':categoria_id'] = $categoria_filter;
    }
    if (count($where) > 0) {
        $sql .= " WHERE " . implode(' AND ', $where);
    }

    $sql .= " ORDER BY l.titulo";

    // Prepara e executa a consulta de livros
    $stmt_livros = $con->prepare($sql);
    $stmt_livros->execute($params); // Passa os parâmetros de busca
    $livros = $stmt_livros->fetchAll(PDO::FETCH_ASSOC);

    // Buscar categorias para o filtro
    $sql_categorias = "SELECT id, nome_categoria FROM cad_categorias ORDER BY nome_categoria";
    $stmt_categorias = $con->query($sql_categorias); // Aqui podemos usar query por ser simples
    $categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro ao conectar ou consultar o banco de dados: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nosso Acervo - Libris</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="public-header">
        <a href="index.php" class="logo">Libris 📚</a>
        <nav class="public-nav">
            <a href="index.php">Início</a>
            <a href="acervo.php">Acervo</a>
            <a href="login_aluno.php" class="btn-primary">Login / Cadastro</a>
        </nav>
    </header>

    <main class="acervo-container">
        <h1>Nosso Acervo</h1>
        
        <form method="GET" action="acervo.php" class="flexRow" style="margin-bottom: 2rem; gap: 1rem; align-items: center;">
            <input type="text" name="search" class="input" placeholder="Buscar por título ou autor..." value="<?php echo htmlspecialchars($search); ?>" style="flex-grow: 1;">
            
            <select name="categoria" class="input">
                <option value="0">Todas as Categorias</option>
                <?php
                if (count($categorias) > 0) {
                    foreach($categorias as $cat) {
                        $selected = ($categoria_filter == $cat['id']) ? 'selected' : '';
                        echo '<option value="' . $cat['id'] . '" ' . $selected . '>' . htmlspecialchars($cat['nome_categoria']) . '</option>';
                    }
                }
                ?>
            </select>
            <button type="submit" class="btn login">Filtrar</button>
        </form>

        <div class="acervo-grid">
            <?php
            if (count($livros) > 0) {
                foreach($livros as $row) {
                    echo '<div class="book-card">';
                    $capa = $row['imagem_capa'] ? $row['imagem_capa'] : 'imagens/capa-padrao.png';
                    echo '<img src="' . htmlspecialchars($capa) . '" alt="Capa de ' . htmlspecialchars($row['titulo']) . '">';
                    echo '<h3>' . htmlspecialchars($row['titulo']) . '</h3>';
                    echo '<p>' . htmlspecialchars($row['autor']) . '</p>';
                    echo '<p><strong>' . htmlspecialchars($row['nome_categoria'] ?? 'Sem Categoria') . '</strong></p>';
                    echo '<a href="livro_detalhe.php?id=' . $row['id'] . '" class="btn login">Ver Detalhes</a>';
                    echo '</div>';
                }
            } else {
                echo "<p>Nenhum livro encontrado com esses critérios.</p>";
            }
            ?>
        </div>
    </main>
</body>
</html>