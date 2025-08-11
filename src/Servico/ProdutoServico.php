<?php

namespace Servico;

use Exception;
use Models\Produto;
use Repositorio\CategoriaRepositorio;
use Repositorio\Interfaces\ICategoriaRepositorio;
use Repositorio\Interfaces\IProdutoRepositorio;
use Repositorio\ProdutoRepositorio;
use Utils\Funcoes;
use Utils\Log;
use Utils\Resposta;

class ProdutoServico extends ServicoBase {

    /**
     * @property IProdutoRepositorio $produtoRepositorio
     */
    private $produtoRepositorio;
    /**
     * @property ICategoriaRepositorio $categoriaRepositorio
     */
    private $categoriaRepositorio;

    public function __construct() {
        parent::__construct();

        $this->produtoRepositorio = new ProdutoRepositorio($this->bancoDados);
        $this->categoriaRepositorio = new CategoriaRepositorio($this->bancoDados);
    }

    public function cadastrar() {

        try {
            $nomeProduto = getParametro("nome_produto");
            $precoVenda = getParametro("preco_venda");
            $unidadesEstoque = getParametro("unidades_estoque");
            $status = getParametro("status");
            $foto = getParametro("foto");
            $categoriaId = getParametro("categoria_id");

            // validar dados do produto
            $errosCampos = Funcoes::validarDadosProdutoCadastro([
                "nome_produto" => $nomeProduto,
                "preco_venda" => $precoVenda,
                "unidades_estoque" => $unidadesEstoque,
                "foto" => $foto,
                "categoria_id" => $categoriaId
            ]);

            if ($errosCampos) {
                Resposta::response(false, "Campos inválidos.", $errosCampos);
            }

            // validar se existe outro produto cadastrado com esse nome
            if ($this->produtoRepositorio->buscarPeloNome($nomeProduto)) {
                Resposta::response(false, "Já existe outro produto cadastrado com esse nome na base de dados.");
            }

            // validar se existe a categoria informada
            if (!$this->categoriaRepositorio->buscarPeloId($categoriaId)) {
                Resposta::response(false, "Não existe uma categoria cadastrada com o id informado.");
            }

            $produtoCadastrar = new Produto();

            $produtoCadastrar->setNomeProduto($nomeProduto);
            $produtoCadastrar->setPrecoVenda($precoVenda);
            $produtoCadastrar->setStatus($status);
            $produtoCadastrar->setUnidadesEstoque($unidadesEstoque);
            $produtoCadastrar->setCategoriaId($categoriaId);
            $produtoCadastrar->setFoto($foto);

            $this->produtoRepositorio->cadastrar($produtoCadastrar);

            Resposta::response(true, "Produto cadastrado com sucesso.", $produtoCadastrar->toArray());
        } catch (Exception $e) {
            Log::erro("Erro ao tentar-se cadastrar o produto na base de dados: " . $e->getMessage());

            Resposta::response(false, "Erro ao tentar-se cadastrar o produto.");
        }

    }

}