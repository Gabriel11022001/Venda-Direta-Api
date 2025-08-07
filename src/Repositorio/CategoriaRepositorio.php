<?php

namespace Repositorio;

use Exception;
use Models\Categoria;
use PDO;
use Repositorio\Interfaces\ICategoriaRepositorio;

class CategoriaRepositorio extends Repositorio implements ICategoriaRepositorio {

    /**
     * @property PDO $bancoDados
     */
    public function __construct($bancoDados) {
        parent::__construct($bancoDados);
    }

    /**
     * @property Categoria $categoriaCadastrar
     */
    public function cadastrar($categoriaCadastrar) {
        $stmt = $this->bancoDados->prepare("INSERT INTO tb_categorias(nome, status) VALUES(:nome, :status)");

        $stmt->bindValue(":nome", $categoriaCadastrar->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(":status", $categoriaCadastrar->getStatus(), PDO::PARAM_BOOL);

        if (!$stmt->execute()) {

            throw new Exception("Erro ao tentar-se cadastrar a categoria.");
        }

        $categoriaCadastrar->setCategoriaId(intval($this->bancoDados->lastInsertId()));
    }

    /**
     * @property Categoria $categoriaEditar
     */
    public function editar($categoriaEditar) {
        $stmt = $this->bancoDados->prepare("UPDATE tb_categorias SET nome = :nome, status = :status
        WHERE categoria_id = :categoria_id");

        $stmt->bindValue(":categoria_id", $categoriaEditar->getCategoriaId(), PDO::PARAM_INT);
        $stmt->bindValue(":nome", $categoriaEditar->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(":status", $categoriaEditar->getStatus(), PDO::PARAM_BOOL);

        if (!$stmt->execute()) {

            throw new Exception("Erro ao tentar-se editar a categoria.");
        }

    }

    public function deletar($idCategoria) {
        $stmt = $this->bancoDados->prepare("DELETE FROM tb_categorias WHERE categoria_id = :categoria_id");

        $stmt->bindValue(":categoria_id", $idCategoria, PDO::PARAM_INT);

        if (!$stmt->execute()) {

            throw new Exception("Erro ao tentar-se deletar a categoria na base de dados.");
        }

    }

    public function listarPaginado($paginaAtual, $elementosPorPagina) {
        
    }
    
    public function buscarPeloId($idCategoria) {
        $stmt = $this->bancoDados->prepare("SELECT * FROM tb_categorias WHERE categoria_id = :categoria_id");

        $stmt->bindValue(":categoria_id", $idCategoria, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarPeloNome($nome) {
        $stmt = $this->bancoDados->prepare("SELECT * FROM tb_categorias WHERE nome = :nome");

        $stmt->bindValue(":nome", $nome, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}