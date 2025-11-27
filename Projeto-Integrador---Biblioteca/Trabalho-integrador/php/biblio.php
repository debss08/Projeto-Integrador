<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../html/login.html");
    exit();
}

require_once "../php/conexao.php";
require_once "../php/livro.php";

$livros = Livro::listarTodos();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acervo</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/global.js"></script>
</head>
<body class="fundoAzul">
<aside>
        <button id="opennavBar">
            <i class="fa-solid fa-angles-left" id="abrirMenu"></i>
            <i class="fa-solid fa-angles-right" id="fecharMenu" style="display: none;"></i>
        </button>
        <nav id="navBar">
            <div class="infosUser-menu flexRow">
                <i class="fa-regular fa-user"></i>
                <div class="flexColumn">
                    <p class="bolder"><?php echo htmlspecialchars($_SESSION['nome']);?></p>
                </div>
            </div>
            <ul class="navBar-list">
                <li>
                    <a href="./inicio.php" class="navBar-itemList">
                        <i class="fa-solid fa-house"></i>
                        <p>Início</p>
                    </a>
                </li>
                <li>
                    <a href="./emprestimos.php" class="navBar-itemList">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <p>Empréstimos</p>
                    </a>
                </li>
                <li>
                    <a href="./biblio.php" class="navBar-itemList">
                        <i class="fa-solid fa-book"></i>
                        <p>Acervo</p>
                    </a>
                </li>
            </ul>
            <a class="logout flexRow" type="button" href="./logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                <p>Logout</p>
            </a>
        </nav>
    </aside>
    <main id="content">
    <div class="searchFor">
        <input type="text" name="searchFor-input" id="searchFor-input" placeholder="Buscar..." class="input search">
        <i class="fa-solid fa-magnifying-glass"></i>
    </div>

    <a class="new book" href="../php/novoLivro.php">
        <i class="fa-solid fa-plus"></i>
        <h2>Novo livro</h2>
    </a>

    <?php foreach ($livros as $l):?>
        <div class="item-book flexRow"> 
            <img src="../imagens/domcasmurro.jpg" alt="Capa de Dom Casmurro">
            <div class="flexColumn">
                <h3><?= htmlspecialchars($l->getTitulo(), ENT_QUOTES, 'UTF-8'); ?></h3>
                <p>
                    Autor: <?= htmlspecialchars($l->getAutor(), ENT_QUOTES, 'UTF-8'); ?> <br>
                    Gênero: <?= htmlspecialchars($l->getCategoria(), ENT_QUOTES, 'UTF-8'); ?> <br>
                    Data de lançamento: <?= htmlspecialchars($l->getData_lancamento(), ENT_QUOTES, 'UTF-8'); ?> <br>
                    Quantidade disponível: <?= htmlspecialchars($l->getQuantidade(), ENT_QUOTES, 'UTF-8'); ?> <br>
                </p>
                <p class="resumo">
                    <strong>Resumo:</strong> <?= htmlspecialchars($l->getResumo(), ENT_QUOTES, 'UTF-8'); ?>
                </p>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="item-book flexRow"> 
        <img src="../imagens/domcasmurro.jpg" alt="Capa de Dom Casmurro">
        <div class="flexColumn">
            <h3>Dom Casmurro</h3>
            <p>
                Autor: Machado de Assis <br>
                Gênero: Romance <br>
                Data de lançamento: 1899-01-01 <br>
                Quantidade disponível: 3 <br>
            </p>
            <p class="resumo">
                <strong>Resumo:</strong> Bentinho narra suas memórias, revelando um ciúme intenso e a dúvida eterna sobre a fidelidade de Capitu, em um dos maiores clássicos da literatura brasileira.
            </p>
        </div>
    </div>

    <div class="item-book flexRow"> 
        <img src="../imagens/o-hobbit.jpg" alt="Capa de O Hobbit">
        <div class="flexColumn">
            <h3>O Hobbit</h3>
            <p>
                Autor: J.R.R. Tolkien <br>
                Gênero: Fantasia <br>
                Data de lançamento: 1937-09-21 <br>
                Quantidade disponível: 5 <br>
            </p>
            <p class="resumo">
                <strong>Resumo:</strong> Bilbo Bolseiro é arrastado para uma jornada inesperada ao lado de anões e do mago Gandalf, enfrentando dragões e descobrindo sua própria coragem.
            </p>
        </div>
    </div>

    <div class="item-book flexRow"> 
        <img src="../imagens/1984.jpg" alt="Capa de 1984">
        <div class="flexColumn">
            <h3>1984</h3>
            <p>
                Autor: George Orwell <br>
                Gênero: Ficção Científica <br>
                Data de lançamento: 1949-06-08 <br>
                Quantidade disponível: 2 <br>
            </p>
            <p class="resumo">
                <strong>Resumo:</strong> Em um futuro distópico, o governo totalitário controla cada aspecto da vida. Winston Smith luta contra o sistema em busca da liberdade e da verdade.
            </p>
        </div>
    </div>

    <div class="item-book flexRow"> 
        <img src="../imagens/harry-potter.jpg" alt="Capa de Harry Potter e a Pedra Filosofal">
        <div class="flexColumn">
            <h3>Harry Potter e a Pedra Filosofal</h3>
            <p>
                Autor: J.K. Rowling <br>
                Gênero: Fantasia <br>
                Data de lançamento: 1997-06-26 <br>
                Quantidade disponível: 4 <br>
            </p>
            <p class="resumo">
                <strong>Resumo:</strong> O jovem Harry descobre ser um bruxo e embarca em sua primeira aventura na Escola de Magia e Bruxaria de Hogwarts, enfrentando perigos e fazendo amigos leais.
            </p>
        </div>
    </div>

    <div class="item-book flexRow"> 
        <img src="../imagens/pequeno-principe.jpg" alt="Capa de O Pequeno Príncipe">
        <div class="flexColumn">
            <h3>O Pequeno Príncipe</h3>
            <p>
                Autor: Antoine de Saint-Exupéry <br>
                Gênero: Fábula / Filosófico <br>
                Data de lançamento: 1943-04-06 <br>
                Quantidade disponível: 6 <br>
            </p>
            <p class="resumo">
                <strong>Resumo:</strong> Uma história poética sobre amizade, amor e o sentido da vida, contada por um piloto que conhece um pequeno príncipe vindo de outro planeta.
            </p>
        </div>
    </div>

    </main>
</body>
</html>