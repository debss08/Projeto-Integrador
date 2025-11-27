<?php
require_once "conexao.php";

class Livro {
    private $id;
    private $titulo;
    private $autor;
    private $resumo;
    private $data_lancamento;
    private $quantidade;
    private $categoria;

    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getAutor(){
        return $this->autor;
    }

    public function getResumo(){
        return $this->resumo;
    }

    public function getData_lancamento(){
        return $this->data_lancamento;
    }

    public function getQuantidade(){
        return $this->quantidade;
    }

    public function getCategoria(){
        return $this->categoria;
    }

    public static function listarTodos() {
        $con = Conexao::getConexao();
        $sql = "SELECT * FROM cad_livros ORDER BY titulo";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Livro');
    }
}
?>
