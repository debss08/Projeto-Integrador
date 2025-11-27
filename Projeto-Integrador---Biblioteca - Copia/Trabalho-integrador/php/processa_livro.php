<?php
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = $_POST['titulo'] ?? '';
    $autor = $_POST['autor'] ?? '';
    $resumo = $_POST['resumo'] ?? '';
    $data_lancamento = $_POST['data_lancamento'] ?? '';
    $quantidade = $_POST['quantidade'] ?? 0;
    $categoria = $_POST['categoria'] ?? '';

    if ($titulo === '' || $autor === '' || $resumo === '' || $data_lancamento === '' || $quantidade <= 0 || $categoria === '') {
        echo "<script>alert('Preencha todos os campos corretamente.'); history.back();</script>";
        exit;
    }

    $caminhoImagem = null;
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $nomeArquivo = uniqid('capa_') . '.' . $extensao;
        $diretorio = "../uploads/";

        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        $caminhoImagem = $diretorio . $nomeArquivo;
        move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem);
    } else {
        echo "<script>alert('Erro ao enviar a imagem.'); history.back();</script>";
        exit;
    }

    try {
        $con = Conexao::getConexao();
        $con->beginTransaction(); 

        $sqlLivro = "INSERT INTO cad_livros (titulo, autor, resumo, data_lancamento, imagem_capa, id_categoria)
                     VALUES (:titulo, :autor, :resumo, :data_lancamento, :imagem, :categoria)";
        $stmt = $con->prepare($sqlLivro);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':autor', $autor);
        $stmt->bindParam(':resumo', $resumo);
        $stmt->bindParam(':data_lancamento', $data_lancamento);
        $stmt->bindParam(':imagem', $caminhoImagem);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->execute();

        $idLivro = $con->lastInsertId();

        $sqlAcervo = "INSERT INTO cad_acervo (id_livro, quantidade_total, quantidade_disponivel)
                      VALUES (:id_livro, :qtd, :qtd)";
        $stmt2 = $con->prepare($sqlAcervo);
        $stmt2->bindParam(':id_livro', $idLivro);
        $stmt2->bindParam(':qtd', $quantidade);
        $stmt2->execute();

        $con->commit(); 

        echo "<script>alert('Livro cadastrado com sucesso!'); window.location.href='../html/biblio.html';</script>";
        exit;
    } catch (PDOException $e) {
        $con->rollBack();
        echo "<script>alert('Erro ao cadastrar livro: " . addslashes($e->getMessage()) . "'); history.back();</script>";
    }
}
?>
