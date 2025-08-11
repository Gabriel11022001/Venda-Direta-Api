<?php

namespace Repositorio;

use Exception;
use Models\Produto;
use PDO;
use Repositorio\Interfaces\IProdutoRepositorio;

class ProdutoRepositorio extends Repositorio implements IProdutoRepositorio {

    /**
     * @param PDO $bancoDados
     */
    public function __construct($bancoDados) {
        parent::__construct($bancoDados);
    }

    /**
     * @param Produto $produtoCadastrar
     */
    public function cadastrar($produtoCadastrar) {
        $stmt = $this->bancoDados->prepare("INSERT INTO tb_produtos(nome_produto, preco_venda, unidades_estoque, status, foto, categoria_id)
        VALUES(:nome_produto, :preco_venda, :unidades_estoque, :status, :foto, :categoria_id)");
        
        $stmt->bindValue(":nome_produto", $produtoCadastrar->getNomeProduto(), PDO::PARAM_STR);
        $stmt->bindValue(":preco_venda", $produtoCadastrar->getPrecoVenda());
        $stmt->bindValue(":status", $produtoCadastrar->getStatus(), PDO::PARAM_BOOL);
        $stmt->bindValue(":categoria_id", $produtoCadastrar->getCategoriaId(), PDO::PARAM_INT);
        $stmt->bindValue(":unidades_estoque", $produtoCadastrar->getUnidadesEstoque(), PDO::PARAM_INT);
        $stmt->bindValue(":foto", $produtoCadastrar->getFoto(), PDO::PARAM_STR);

        if (!$stmt->execute()) {

            throw new Exception("Erro ao tentar-se cadastrar o produto na base de dados.");
        }

        $produtoCadastrar->setProdutoId($this->bancoDados->lastInsertId());

        $cagoriaRepositorio = new CategoriaRepositorio($this->bancoDados);

        $produtoCadastrar->setCategoria($cagoriaRepositorio->buscarPeloId($produtoCadastrar->getCategoriaId()));
    }

    /**
     * @param Produto $produtoEditar
     */
    public function editar($produtoEditar) {
        $stmt = $this->bancoDados->prepare("UPDATE tb_produtos SET nome_produto = :nome_produto, preco_venda = :preco_venda,
        status = :status, categoria_id = :categoria_id, unidades_estoque = :unidades_estoque, foto = :foto
        WHERE prodtuo_id = :produto_id");

        $stmt->bindValue(":nome_produto", $produtoEditar->getNomeProduto(), PDO::PARAM_STR);
        $stmt->bindValue(":preco_venda", $produtoEditar->getPrecoVenda());
        $stmt->bindValue(":status", $produtoEditar->getStatus(), PDO::PARAM_BOOL);
        $stmt->bindValue(":categoria_id", $produtoEditar->getCategoriaId(), PDO::PARAM_INT);
        $stmt->bindValue(":unidades_estoque", $produtoEditar->getUnidadesEstoque(), PDO::PARAM_INT);
        $stmt->bindValue(":produto_id", $produtoEditar->getProdutoId(), PDO::PARAM_INT);
        $stmt->bindValue(":foto", $produtoEditar->getFoto(), PDO::PARAM_STR);

        if (!$stmt->execute()) {

            throw new Exception("Erro ao tentar-se editar o produto na base de dados.");
        }

        $categoriaRepositorio = new CategoriaRepositorio($this->bancoDados);

        $produtoEditar->setCategoria(
            categoria: $categoriaRepositorio->buscarPeloId(
                $produtoEditar->getCategoriaId()
            )  
        );
    }

    public function listarPaginado($paginaAtual, $elementosPorPagina) {
        
    }

    public function buscarEntrePrecos($precoInicial, $precoFinal, $paginaAtual, $elementosPorPaginas) {

    }

    public function buscarPeloId($id) {
        $stmt = $this->bancoDados->prepare("SELECT *.p, c.nome AS nome_categoria, c.status AS status_categoria
        FROM tb_produtos AS p
        INNER JOIN tb_categorias AS c
        ON p.categoria_id = c.categoria_id
        AND p.produto_id = :produto_id");

        $stmt->bindValue(":produto_id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarSomentePossuemUnidadesEstoque($paginaAtual, $elementosPorPagina) {
        
    }

    public function deletar($id) {
        $stmt = $this->bancoDados->prepare("DELETE FROM tb_produtos WHERE produto_id = :produto_id");

        $stmt->bindValue(":produto_id", $id, PDO::PARAM_INT);

        if (!$stmt->execute()) {

            throw new Exception("Erro ao tentar-se deletar o produto na base de dados.");
        }

    }

    public function buscarPeloNome($nome) {
        $stmt = $this->bancoDados->prepare("SELECT p.*, c.nome AS nome_categoria, c.status AS status_categoria
        FROM tb_produtos AS p
        INNER JOIN tb_categorias AS c
        ON p.categoria_id = c.categoria_id
        AND p.nome_produto = :nome_produto");

        $stmt->bindValue(":nome_produto", $nome, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}