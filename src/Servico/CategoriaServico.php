<?php

namespace Servico;

use Exception;
use Models\Categoria;
use Repositorio\CategoriaRepositorio;
use Repositorio\Interfaces\ICategoriaRepositorio;
use Repositorio\Interfaces\IProdutoRepositorio;
use Repositorio\ProdutoRepositorio;
use Utils\Log;
use Utils\Resposta;

class CategoriaServico extends ServicoBase {

    /**
     * @property ICategoriaRepositorio $categoriaRepositorio
     */
    private $categoriaRepositorio;
    /**
     * @property IProdutoRepositorio $produtoRepositorio
     */
    private $produtoRepositorio;

    public function __construct() {
        parent::__construct();

        $this->categoriaRepositorio = new CategoriaRepositorio($this->bancoDados);
        $this->produtoRepositorio = new ProdutoRepositorio($this->bancoDados);
    }

    private function validarCamposCadastroCategoria($nomeCategoriaValidar) {
        $erros = [];

        if (empty($nomeCategoriaValidar)) {
            $erros["nome"] = "Informe o nome da categoria.";
        } elseif (strlen($nomeCategoriaValidar) < 3) {
            $erros["nome"] = "O nome da categoria deve possuir no mínimo 3 caracteres.";
        }

        return $erros;
    }

    public function cadastrar() {

        try {
            $nome = getParametro("nome");
            $status = getParametro("status");
            
            $errosCampos = $this->validarCamposCadastroCategoria($nome);

            if ($errosCampos) {
                Resposta::response(false, "Campos inválidos.", $errosCampos);
            }

            // validar se já existe outra categoria cadastrada com o mesmo nome
            if ($this->categoriaRepositorio->buscarPeloNome($nome)) {
                Resposta::response(false, "Já existe outra categoria cadastrada com o mesmo nome na base de dados.");
            }

            $categoria = new Categoria();

            $categoria->setNome($nome);
            $categoria->setStatus($status);

            $this->categoriaRepositorio->cadastrar($categoria);

            Resposta::response(true, "Categoria cadastrada com sucesso.", $categoria->toArray());
        } catch (Exception $e) {
            Log::erro("Erro ao tentar-se cadastrar a categoria: " . $e->getMessage());

            Resposta::response(false, "Erro ao tentar-se cadastrar a categoria.");
        }

    }

    public function editar() {

        try {
            $categoriaId = getParametro("categoria_id");
            $nome = getParametro("nome");
            $status = getParametro("status");

            $errosCampos = [];

            if (empty($categoriaId)) {
                $errosCampos["categoria_id"] = "Informe o id da categoria.";
            }

            if (empty($nome)) {
                $errosCampos["nome"] = "Informe o nome da categoria.";
            } elseif (strlen($nome) < 3) {
                $errosCampos["nome"] = "O nome da categoria deve possuir no mínimo 3 caracteres.";
            }

            if (!empty($errosCampos)) {
                Resposta::response(false, "Campos inválidos.", $errosCampos);
            }

            $categoriaValidar = $this->categoriaRepositorio->buscarPeloId($categoriaId);

            // validar se existe outra categoria cadastrada com o id informado
            if (empty($categoriaValidar)) {
                Resposta::response(false, "Não existe uma categoria cadastrada com o id informado.");
            }

            // validar se existe outra categoria com o mesmo nome informado
            if ($categoriaValidar["nome"] == $nome && $categoriaId != $categoriaValidar["categoria_id"]) {
                Resposta::response(false, "Já existe outra categoria cadastrada na base de dados com o mesmo nome.");
            }

            $categoria = new Categoria();
            $categoria->setCategoriaId($categoriaId);
            $categoria->setNome($nome);
            $categoria->setStatus($status);

            $this->categoriaRepositorio->editar($categoria);

            Resposta::response(true, "Categoria salva com sucesso na base de dados.", $categoria->toArray());
        } catch (Exception $e) {
            Log::erro("Erro ao tentar-se editar a categoria: " . $e->getMessage());
            
            Resposta::response(false, "Erro ao tentar-se editar a categoria.");
        }

    }

    public function buscarPeloId() {

        try {
            
            if (!isset($_GET["categoria_id"])) {
                Resposta::response(false, "Informe o id da categoria.");
            }

            $categoriaId = $_GET["categoria_id"];

            if (empty($categoriaId)) {
                Resposta::response(false, "Informe o id da categoria.");
            }

            $categoria = $this->categoriaRepositorio->buscarPeloId($categoriaId);

            if (!$categoria) {
                Resposta::response(false, "Categoria não encontrada.");
            }

            Resposta::response(true, "Categoria encontrada com sucesso.", [
                "categoria_id" => $categoria["categoria_id"],
                "nome" => $categoria["nome"],
                "status" => $categoria["status"] ? "Ativo" : "Inativo"
            ]);
        } catch (Exception $e) {
            Log::erro("Erro ao tentar-se buscar a categoria pelo id: " . $e->getMessage());

            Resposta::response(false, "Erro ao tentar-se buscar a categoria pelo id.");
        }

    }

    public function alterarStatus() {

        try {
            $categoriaId = getParametro("categoria_id");
            $status = getParametro("status");

            if (empty($categoriaId)) {
                Resposta::response(false, "Informe o id da categoria.");
            }

            // validar se existe uma categoria cadastrada com o id informado
            if (empty($this->categoriaRepositorio->buscarPeloId($categoriaId))) {
                Resposta::response(false, "Não existe uma categoria na base de dados com o id informado.");
            }

            $this->categoriaRepositorio->alterarStatus($categoriaId, $status);

            Resposta::response(true, "O status da categoria foi alterado com sucesso na base de dados.");
        } catch (Exception $e) {
            Log::erro("Erro ao tentar-se alterar o status da categoria: " . $e->getMessage());

            Resposta::response(false, "Erro ao tentar-se alterar o status da categoria.");
        }

    }

    public function deletar() {

        try {

            if (!isset($_GET["categoria_id"])) {
                Resposta::response(false, "Informe o id da categoria.");
            }

            $categoriaId = $_GET["categoria_id"];

            if (empty($categoriaId)) {
                Resposta::response(false, "Informe o id da categoria.");
            }

            // validar se existe uma categoria cadastrada na base de dados com o id informado
            $categoriaDeletar = $this->categoriaRepositorio->buscarPeloId($categoriaId);

            if (!$categoriaDeletar) {
                Resposta::response(false, "Não existe uma categoria cadastrada com o id informado.");
            }

            // validar se a categoria em questão está relacionada a algum produto
            if (!empty($this->produtoRepositorio->buscarPelaCategoria($categoriaId))) {
                Resposta::response(false, "A categoria em questão está relacionada a produtos, não é possível deletar a mesma.");
            }

            $this->categoriaRepositorio->deletar($categoriaId);

            Resposta::response(true, "Categoria deletada com sucesso.");
        } catch (Exception $e) {
            Log::erro("Erro ao tentar-se deletar a categoria do produto na base de dados: " . $e->getMessage());
            
            Resposta::response(false, "Erro ao tentar-se deletar a categoria do produto.");
        }

    }

    public function listar() {

        try {

            if (!isset($_GET["pagina_atual"]) || !isset($_GET["elementos_por_pagina"])) {
                Resposta::response(false, "Informe a pagina atual e quantidade de elementos por página.");
            }

            $paginaAtual = $_GET["pagina_atual"];
            $elementosPorPagina = $_GET["elementos_por_pagina"];

            if (empty($paginaAtual) || empty($elementosPorPagina)) {
                Resposta::response(false, "Informe a pagina atual e quantidade de elementos por página.");
            }

            $maximosElementosPorPagina = [
                5,
                10,
                15
            ];

            if (!in_array($elementosPorPagina, $maximosElementosPorPagina)) {
                Resposta::response(false, "Quantidade de elementos por página inválido.");
            }

            $categorias = $this->categoriaRepositorio->listarPaginado($paginaAtual, $elementosPorPagina);

            if (!$categorias) {
                Resposta::response(true, "Não existem categorias cadastradas na base de dados.", array());
            }

            $categorias = array_map(function ($categoria) {

                return [
                    "categoria_id" => $categoria["categoria_id"],
                    "nome" => $categoria["nome"],
                    "status" => $categoria["status"] ? "Ativo" : "Inativo"
                ];
            }, $categorias);

            Resposta::response(true, "Categorias listadas com sucesso.", $categorias);
        } catch (Exception $e) {
            Log::erro("Erro ao tentar-se listar as categorias: " . $e->getMessage());

            Resposta::response(false, "Erro ao tentar-se listar as categorias.");
        }

    }

}