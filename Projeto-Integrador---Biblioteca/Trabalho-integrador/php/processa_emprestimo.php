<?php
require '../php/conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_livro = $_POST['id_livro'];
    $id_aluno = $_POST['id_aluno'];
    $data_retirada = $_POST['data_retirada'];
    $data_devolucao = $_POST['data_devolucao'];

    try {
        $con = Conexao::getConexao();
        $sql = "INSERT INTO cad_emprestimos (id_livro, id_aluno, data_retirada, data_devolucao)
                VALUES (:id_livro, :id_aluno, :data_retirada, :data_devolucao)";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':id_livro', $id_livro);
        $stmt->bindParam(':id_aluno', $id_aluno);
        $stmt->bindParam(':data_retirada', $data_retirada);
        $stmt->bindParam(':data_devolucao', $data_devolucao);
        $stmt->execute();

        echo "<script>alert('Empréstimo registrado com sucesso!'); window.location.href='../html/emprestimos.html';</script>";
    } catch (PDOException $e) {
        echo "Erro ao registrar empréstimo: " . $e->getMessage();
    }
}
?>