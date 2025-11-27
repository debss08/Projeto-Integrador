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
    <title>Empréstimos</title>
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
    <a class="new sell" href="./novoEmprestimo.php">
        <i class="fa-solid fa-plus"></i>
        <h2>Novo empréstimo</h2>
    </a>

    <div class="item-emprestimo flexRow">
        <div class="flexColumn">
            <h3>Empréstimo #10231</h3>
            <p>
            Data retirada: <b>12/10/2025</b><br>
            Data devolução: <b>26/10/2025</b><br>
            Livro: <b>O Pequeno Príncipe</b><br>
            Aluno: <b>Marina Souza</b>
            </p>
        </div>
        </div>

        <div class="item-emprestimo flexRow">
        <div class="flexColumn">
            <h3>Empréstimo #10232</h3>
            <p>
            Data retirada: <b>15/10/2025</b><br>
            Data devolução: <b>29/10/2025</b><br>
            Livro: <b>Dom Casmurro</b><br>
            Aluno: <b>Lucas Almeida</b>
            </p>
        </div>
        </div>

        <div class="item-emprestimo flexRow">
        <div class="flexColumn">
            <h3>Empréstimo #10233</h3>
            <p>
            Data retirada: <b>20/10/2025</b><br>
            Data devolução: <b>03/11/2025</b><br>
            Livro: <b>A Revolução dos Bichos</b><br>
            Aluno: <b>Ana Clara Ribeiro</b>
            </p>
        </div>
        </div>

    </main>
</body>
</html>