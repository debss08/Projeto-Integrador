<?php
session_start();
// ATENÇÃO: Verificando sessão de ADMIN
if (!isset($_SESSION['admin_id'])) { 
    header("Location: ../html/login_admin.html");
    exit();
}
require_once "../php/conexao.php";
require_once "../php/categoria.php";
$categorias = Categoria::listarTodas();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar novo livro</title>
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
                    <p class="bolder"><?php echo htmlspecialchars($_SESSION['admin_nome']);?></p>
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
            <a class="logout flexRow" type="button" href="../php/logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                <p>Logout</p>
            </a>
        </nav>
    </aside>
    <main id="content">
        <div class="item-book flexColumn"> <div class="flexColumn">
                <h1 class="subtitulo">Novo livro</h1>
                <hr>

                <form action="../php/processa_livro.php" method="POST" enctype="multipart/form-data" class="flexColumn">

                    <label for="titulo">Título do livro</label>
                    <input type="text" id="titulo" name="titulo" class="input welcome" required>

                    <label for="autor">Autor</label>
                    <input type="text" id="autor" name="autor" class="input welcome" required>

                    <label for="resumo">Resumo</label>
                    <textarea id="resumo" name="resumo" class="input welcome" rows="4" required></textarea>

                    <label for="data_lancamento">Data de lançamento</label>
                    <input type="date" id="data_lancamento" name="data_lancamento" class="input welcome" required>

                    <label for="imagem">Imagem da capa</label>
                    <input type="file" id="imagem" name="imagem" accept="image/*" class="input welcome" required>

                    <label for="quantidade">Quantidade</label>
                    <input type="number" id="quantidade" name="quantidade" class="input welcome" required min="1">

                    <div class="categoria-label">
                        <label for="categoria">Categoria</label>
                        <button type="button" class="btn-add-categoria" id="btnAbrirModal">+</button>
                    </div>
                    <select id="categoria" name="categoria" class="input welcome" required>
                        <option value="">Selecione uma categoria</option>
                        <?php foreach ($categorias as $c): ?>
                            <option value="<?php echo htmlspecialchars($c->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($c->getNome(), ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <br>
                    <button type="submit" class="btn login">Registrar livro</button>
                </form>

            </div>
        </div>
    </main>

    <div id="modalCategoria" class="modal">
        <div class="modal-content">
            <span class="close-modal" id="btnCloseModal">&times;</span>
            <h2>Nova Categoria</h2>
            <form id="formAddCategoria" class="flexColumn">
                <label for="nome_categoria">Nome da Categoria</label>
                <input type="text" id="nome_categoria" name="nome_categoria" class="input welcome" required>
                <button type="submit" class="btn login">Salvar Categoria</button>
                <p id="modalMensagem" style="color: red;"></p>
            </form>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        const modal = $("#modalCategoria");
        const btnAbrir = $("#btnAbrirModal");
        const btnFechar = $("#btnCloseModal");
        const formCategoria = $("#formAddCategoria");
        const selectCategoria = $("#categoria");
        const modalMensagem = $("#modalMensagem");

        // Abrir modal
        btnAbrir.on("click", function() {
            modalMensagem.text("");
            formCategoria.trigger("reset"); // Limpa o formulário
            modal.css("display", "block");
        });

        // Fechar modal
        btnFechar.on("click", function() {
            modal.css("display", "none");
        });
        
        // Fechar se clicar fora
        $(window).on("click", function(event) {
            if (event.target == modal[0]) {
                modal.css("display", "none");
            }
        });

        // Enviar o formulário de nova categoria via AJAX
        formCategoria.on("submit", function(e) {
            e.preventDefault(); // Impede o envio normal
            modalMensagem.text("");
            
            $.ajax({
                url: '../php/processa_categoria.php', // O script que salva a categoria
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // 1. Adiciona a nova opção no select
                        const novaOpcao = new Option(response.nome, response.id);
                        selectCategoria.append(novaOpcao);
                        
                        // 2. Seleciona a opção que acabou de ser criada
                        selectCategoria.val(response.id);
                        
                        // 3. Fecha o modal
                        modal.css("display", "none");
                        alert('Categoria "' + response.nome + '" adicionada!');
                    } else {
                        // Mostra erro (ex: "categoria já existe")
                        modalMensagem.text(response.message);
                    }
                },
                error: function() {
                    modalMensagem.text('Erro de conexão. Tente novamente.');
                }
            });
        });
    });
    </script>

</body>
</html>