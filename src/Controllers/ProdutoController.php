<?php

namespace Controllers;

use Servico\ProdutoServico;

class ProdutoController {

    /**
     * @property ProdutoServico $produtoServico
     */
    private $produtoServico;

    public function __construct() {
        $this->produtoServico = new ProdutoServico();
    }

    public function cadastrar() {
        $this->produtoServico->cadastrar();
    }

    public function listar() {
        $this->produtoServico->listar();
    }

    public function buscarPeloId() {
        $this->produtoServico->buscarPeloId();
    }

    public function listarProdutosCategoria() {
        $this->produtoServico->listarProdutosCategoria();
    }

}