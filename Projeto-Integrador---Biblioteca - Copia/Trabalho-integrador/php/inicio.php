<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../html/login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de biblioteca</title>
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
        <div class="container textWelcome">
            <div class="flexColumn">
            <h1 class="tituloPrincipal">Bem vindo(a), <?php echo htmlspecialchars($_SESSION['nome']);?>!</h1>
            <p class="descricao">Você está acessando Libris, seu Sistema de gerenciamento da biblioteca :)</p>
            </div>
            <img src="../imagens/bibliotecariaBranca.png" alt="jdfj">
        </div>

        <div class="invisibleContainer">
            <h1 class="flexCenter">O que quer fazer hoje?</h1>
        
            <div class="mainActions-container">
            <div class="mainAction roxo">
                <a href="./novoLivro.php" class="icon-mainAction">
                    <i class="fa-solid fa-book-open"></i>
                </a>
                <h2>Cadastrar um lovo livro</h2>
                <a href="./novoLivro.php">
                <button type="button" class="btn btn-mainAction">
                    Acessar
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
                </a>
            </div>
            <div class="mainAction rosa">
                <a href="./novaEmprestimo.php" class="icon-mainAction">
                    <i class="fa-solid fa-tags"></i>
                </a>
                <h2>Fazer um novo empréstimo</h2>
                <a href="./novaEmprestimo.php">
                <button type="button" class="btn btn-mainAction">
                    Acessar
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
                </a>
            </div>
            <div class="mainAction azul">
                <a href="./biblio.php" class="icon-mainAction">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </a>
                <h2>Consultar o acervo</h2>
                <a href="./biblio.php" >
                <button type="button" class="btn btn-mainAction">
                    Acessar
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
                </a>
            </div>
        </div>
        </div>
        <footer class="footer">
            Webmasters: Débora Martins de Oliveira e Vitória da Costa Pless
        </footer>
    </main>
    
</body>
</html>