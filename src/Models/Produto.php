<?php

namespace Models;

class Produto extends Model {

    private $produtoId;
    private $nomeProduto;
    private $precoVenda;
    private $status;
    private $foto;
    private $categoriaId;
    private $unidadesEstoque;
    /**
     * @property Categoria
     */
    private $categoria;

    public function __construct() {
        $this->produtoId = 0;
        $this->nomeProduto = "";
        $this->precoVenda = 0;
        $this->status = true;
        $this->foto = "";
        $this->categoriaId = 0;
        $this->categoria = null;
        $this->unidadesEstoque = 0;
    }

    public function setProdutoId($produtoId) {
        $this->produtoId = $produtoId;
    }

    public function getProdutoId() {

        return $this->produtoId;
    }

    public function setNomeProduto($nomeProduto) {
        $this->nomeProduto = $nomeProduto;
    }

    public function getNomeProduto() {

        return $this->nomeProduto;
    }

    public function setPrecoVenda($precoVenda) {
        $this->precoVenda = $precoVenda;
    }

    public function getPrecoVenda() {

        return $this->precoVenda;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getStatus() {

        return $this->status;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function getFoto() {

        return $this->foto;
    }

    public function setCategoriaId($categoriaId) {
        $this->categoriaId = $categoriaId;
    }

    public function getCategoriaId() {

        return $this->categoriaId;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public function getCategoria() {

        return $this->categoria;
    }

    public function setUnidadesEstoque($unidadesEstoque) {
        $this->unidadesEstoque = $unidadesEstoque;
    }

    public function getUnidadesEstoque() {

        return $this->unidadesEstoque;
    }

    public function toArray() {
        
        return [
            "produto_id" => $this->getProdutoId(),
            "nome_produto" => $this->getNomeProduto(),
            "preco_venda" => $this->getPrecoVenda(),
            "status" => $this->getStatus(),
            "unidades_estoque" => $this->getUnidadesEstoque(),
            "categoria_id" => $this->getCategoriaId(),
            "categoria" => !empty($this->getCategoria()) ? $this->getCategoria()->toArray() : null
        ];
    }

}